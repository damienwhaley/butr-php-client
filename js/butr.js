/*
 * Butr Universal Travel Reservations
 * A bleeding edge business management system for the travel industry.
 *
 * Copyright (C) 2012 Whalebone Studios and contributors.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * This checks to see if the current session key is valid or not.
 * This is using long polling but will switch to socket.io soon.
 * @author Damien Whaley <damien@whelbonestudios.com>
 */
function checkSessionAlive() {
  'use strict';
  
  var cookieName = 'Butr|' + window.name;
  
  var sessionToken = readCookie(cookieName);
  
  var formBody = 'token=' + escape(sessionToken)
    + '&command=check_session_alive'
    + '&window_name=' + escape(window.name);
    
  $.ajax({
    url: 'ajax/butr.php',
    data: formBody,
    type: 'POST',
    contentType: 'application/x-www-form-urlencoded',
    success: function(data, textStatus, jqXHR) {
      'use strict';
      
      try {
        checkSessionAliveResponse(JSON.parse(jqXHR.responseText));
      } catch (e) {
        handleCheckSessionAliveError(jqXHR.responseText);
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      'use strict';
      
      handleCheckSessionAliveError(jqXHR.responseText);
    }
  });
}

/**
 * This handles the response from the session active query
 * and displays an error or not.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param res
 *   - object containing the JSON response from the Butr server.
 */
function checkSessionAliveResponse(res) {
  'use strict';
  
  var responseStatus = '';
  var sessionToken = '';
  var explanation = '';

  if (res === undefined || res === null || typeof(res) !== 'object') {
    return handleCheckSessionAliveError(res);
  }
  
  if (res.result !== undefined) {
    if (res.result.status !== undefined && res.result.status !== null && res.result.status !== '') {
      responseStatus = res.result.status ;
    }
  }

  if (res.authentication !== undefined) {
    if (res.authentication.token !== undefined && res.authentication.token !== null && res.authentication.token !== '') {
      sessionToken = res.authentication.token;
    }
  }
  
  if (responseStatus === 'OK' && sessionToken !== '') {
    // Session is active, queue up check for another minute    
    setTimeout(checkSessionAlive, 60000);
    return;
  }

  return handleCheckSessionActiveError(res);
}

/**
 * This handles any errors and displays them in an error modal.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param res
 *   - object or string containing the response from the server.
 */
function handleCheckSessionAliveError(res) {
  'use strict';
  
  var responseStatus = '';
  var explanation = '';
  
  try {
    res = JSON.parse(res);
  } catch(e) {
    // Do nothing
  }

  if (res !== null && res !== undefined && typeof(res) === 'object') {
    if (res.result !== undefined) {
      if (res.result.status !== undefined && res.result.status !== null && res.result.status !== '') {
        responseStatus = res.result.status ;
      }
    }

    if (responseStatus !== 'OK') {
      if (res.result !== undefined) {
        if (res.result.explanation !== undefined && res.result.explanation !== null && res.result.explanation !== '') {
          explanation = res.result.explanation;
        }
      }
    }
  }
  
  if (explanation === '') {
    explanation = butr_i18n_CouldNotCommunicate+'.';
  }

  if (responseStatus !== 'OK') {
    $('#error_modal_message').html(explanation);
    $('#error_modal').modal('show');
  }
}

/**
 * This is used to populate the page div with whatever is coming
 * from the menu item.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param content
 *   - String containing the page to call to get the content from.
 * @param alterHistory
 *   - Boolean set to true to have an in-fragment history alter.
 */
function insertPageFragment(content, alterHistory) {
  'use strict';
  
  hideAllModalsAndAlerts();
  $('#page-title').html('&nbsp;');
  $('#page-title-buttons').html('');
  
  if (content === undefined || content === null || content === '') {
    // Nothing to do.
    return;
  }
  
  var language = 'en-AU';
  if (butrSession !== undefined && butrSession !== null) {
    if (butrSession.language !== undefined && butrSession !== null && butrSession.language !== '') {
      language = butrSession.language;
    }
  }
  
  var formBody = 'window_name='+escape(window.name)+'&language='+escape(language);
  
  if (alterHistory !== undefined && alterHistory !== null && alterHistory === true) {
	if (formBody.indexOf('alter_history=1') < 0) {
	  formBody += '&alter_history=1';
	}
  }
  
  // Remove trailing ampersand
  if (content.charAt(content.length - 1) === '&') {
	content = content.substring(0, content.length - 1);
  }
  
  var charPos = -1;
  charPos = content.indexOf('?');
  
  if (charPos >= 0) {
    formBody = formBody + '&' + content.substring((charPos + 1));
    content = content.substring(0, charPos);
  }
  else {
	formBody = formBody + '&' + content;
  }
  
  $.ajax({
    url: content,
    data: formBody,
    type: 'POST',
    contentType: 'application/x-www-form-urlencoded',
    success: function(data, textStatus, jqXHR) {
      'use strict';
      
      insertPageFragmentResponse(jqXHR.responseText);
    },
    error: function(jqXHR, textStatus, errorThrown) {
      'use strict';
      
      handleInsertPageFragmentError(jqXHR.responseText);
    }
  });
}

/**
 * This function populates the page div with whatever the content from the
 * page call is.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param res
 *   - String containing the HTML snippet.
 */
function insertPageFragmentResponse(res) {
  'use strict';
  
  var pageSection = $('#page');
  
  if (pageSection !== undefined && pageSection !== null) {
	pageSection.html(res);
  }
}

/**
 * This handles any errors and displays them in an error modal.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param res
 *   - object or string containing the response from the server.
 */
function handleInsertPageFragmentError(res) {
  'use strict';
  
  var responseStatus = '';
  var explanation = '';
  
  try {
    res = JSON.parse(res);
  } catch(e) {
    // Do nothing
  }

  if (res !== null && res !== undefined && typeof(res) === 'object') {
    if (res.result !== undefined) {
      if (res.result.status !== undefined && res.result.status !== null && res.result.status !== '') {
        responseStatus = res.result.status ;
      }
    }

    if (responseStatus !== 'OK') {
      if (res.result !== undefined) {
        if (res.result.explanation !== undefined && res.result.explanation !== null && res.result.explanation !== '') {
          explanation = res.result.explanation;
        }
      }
    }
  }
  
  if (explanation === '') {
    explanation = butr_i18n_CouldNotCommunicate+'.';
  }

  if (responseStatus !== 'OK') {
    $('#error_modal_message').html(explanation);
    $('#error_modal').modal('show');
  }
}

/**
 * This is used to populate the page div with whatever is coming
 * from the menu item.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param content
 *   - String containing the page to call to get the content from.
 * @param target
 *   - String containing the id for the target well on the page
 *     fragment.
 * @param scroll
 *   - Boolean to tell the response handler to scroll the page or not.
 * @param alterHistory
 *   - Boolean set to true to have an in-well history alter.
 * @param requiresUuid
 *   - Boolean set to true if you must have a uuid to insert this well.
 */
function insertPageFragmentWell(content, target, scroll, alterHistory, requiresUuid) {
  'use strict';
  
  var pageWellInner = $('#' + target + '-inner');
  
  if (pageWellInner.is(':visible')) {
	// Toggle and exit
	pageWellInner.slideToggle();
	return;
  }
  
  if (content === undefined || content === null || content === '') {
    // Nothing to do.
    return;
  }
  
  if (requiresUuid === undefined || requiresUuid === null || requiresUuid === '') {
	requiresUuid = false;
  }
  
  if (requiresUuid === '1' || requiresUuid === true) {
	requiresUuid = true;
  }
  
  if (requiresUuid === true && document.fragment_state_form.uuid.value === '') {
	// Need to have a record selected first
	$('#warning_alert_message').html(butr_i18n_YouNeedARecordFirst + '.');
	$('#warning_alert').show();
	return;
  }
  
  var language = 'en-AU';
  if (butrSession !== undefined && butrSession !== null) {
    if (butrSession.language !== undefined && butrSession !== null && butrSession.language !== '') {
      language = butrSession.language;
    }
  }
  
  var formBody = 'window_name='+escape(window.name)+'&language='+escape(language);
  
  if (alterHistory !== undefined && alterHistory !== null && alterHistory === true) {
	formBody += '&alter_history=1';
  }
  
  // Remove trailing ampersand
  if (content.charAt(content.length - 1) === '&') {
	content = content.substring(0, content.length - 1);
  }
  
  var charPos = -1;
  charPos = content.indexOf('?');
  
  if (charPos >= 0) {
    formBody = formBody + '&' + content.substring((charPos + 1));
    content = content.substring(0, charPos);
  }
  else {
	formBody = formBody + '&' + content;
  }
  
  $.ajax({
    url: content,
    data: formBody,
    type: 'POST',
    contentType: 'application/x-www-form-urlencoded',
    success: function(data, textStatus, jqXHR) {
      'use strict';
      
      insertPageFragmentWellResponse(jqXHR.responseText, target, scroll);
    },
    error: function(jqXHR, textStatus, errorThrown) {
      'use strict';
      
      handleInsertPageFragmentWellError(jqXHR.responseText);
    }
  });
}

/**
 * This function populates the page div with whatever the content from the
 * page call is.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param res
 *   - String containing the HTML snippet.
 * @param target
 *   - String containing the div identifier to insert the content into.
 * @param scroll
 *   - Boolean to decide on whether the page should scroll or not.
 */
function insertPageFragmentWellResponse(res, target, scroll) {
  'use strict';

  var pageWell = $('#' + target);
  var pageWellInner = $('#' + target + '-inner');
  var shouldScroll = true;
  
  if (scroll === undefined || scroll === null || scroll !== true) {
	shouldScroll = false;
  }
  
  if (shouldScroll === true && pageWell !== undefined && pageWell !== null) {
    $.scrollTo(pageWell, { 'over': -1.8 });
  }
  
  if (pageWellInner !== undefined && pageWellInner !== null) {
	if (!pageWellInner.is(':visible')) {
	  pageWellInner.html(res);
	  pageWellInner.slideToggle();
	}
  }
  
  // Add to open well to the form state
  var wells = document.butr_state_form.page_wells.value;
  if (wells !== undefined && wells !== null && wells !== '') {
    if (wells.indexOf(target + ',') === -1) {
      wells += target + ',';
    }
  }
  else {
    wells = target + ',';
  }
  document.butr_state_form.page_wells.value = wells;
}

/**
 * This handles any errors and displays them in an error div.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param res
 *   - object or string containing the response from the server.
 */
function handleInsertPageFragmentWellError(res) {
  'use strict';
  
  var responseStatus = '';
  var explanation = '';
  
  try {
    res = JSON.parse(res);
  } catch(e) {
    // Do nothing
  }

  if (res !== null && res !== undefined && typeof(res) === 'object') {
    if (res.result !== undefined) {
      if (res.result.status !== undefined && res.result.status !== null && res.result.status !== '') {
        responseStatus = res.result.status ;
      }
    }

    if (responseStatus !== 'OK') {
      if (res.result !== undefined) {
        if (res.result.explanation !== undefined && res.result.explanation !== null && res.result.explanation !== '') {
          explanation = res.result.explanation;
        }
      }
    }
  }
  
  if (explanation === '') {
    explanation = butr_i18n_CouldNotCommunicate+'.';
  }

  if (responseStatus !== 'OK') {
    $('#error_modal_message').html(explanation);
    $('#error_modal').modal('show');
  }
}

/**
 * This parses the global configuration to leave an object
 * with name value pairs.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param jsonConfig
 *   - String containing the global configuration.
 * @returns object
 *   - Object containing the configuration settings.
 */
function parseGlobalConfiguration(jsonConfig) {
  'use strict';
  
  var jsonSetting = {};
  var jsonOutput = {};
  
  try {
    jsonSetting = JSON.parse(jsonConfig);
    
    if (jsonSetting.list_global_configurations !== undefined && jsonSetting.list_global_configurations !== null) {
      for (var i = 0; i < jsonSetting.list_global_configurations.items.length; i++) {
        jsonOutput[jsonSetting.list_global_configurations.items[i].magic] = jsonSetting.list_global_configurations.items[i].effective_setting;
      }
    }
  }
  catch (e) {
    // Do nothing.
  }
  jsonSetting = null;
  
  return jsonOutput;
}

/**
 * This parses the user's session to leave an object
 * with the same data.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param jsonSession
 *   - String containing the user's session.
 * @returns object
 *   - Object containing the session settings.
 */
function parseSession(jsonSession) {
  'use strict';
  
  var jsonData = {};
  var jsonOutput = {};
  
  try {
    jsonData = JSON.parse(jsonSession);
    
    if (jsonData.fetch_session !== undefined && jsonData.fetch_session !== null) {
      if (jsonData.fetch_session.data !== undefined && jsonData.fetch_session.data !== null) {
        jsonOutput = jsonData.fetch_session.data;
      }
    }
  }
  catch (e) {
    // Do nothing.
  }
  jsonData = null;
  
  return jsonOutput;
}

/**
 * This ends the current session.
 * @author Damien Whaley <damien@whelbonestudios.com>
 */
function logOut() {
  'use strict';
  
  hideAllModalsAndAlerts();
  
  var cookieName = 'Butr|' + window.name;
  
  var sessionToken = readCookie(cookieName);
  
  var formBody = 'token=' + escape(sessionToken)
    + '&command=end_session'
    + '&window_name=' + escape(window.name);
    
  $.ajax({
    url: 'ajax/butr.php',
    data: formBody,
    type: 'POST',
    contentType: 'application/x-www-form-urlencoded',
    success: function(data, textStatus, jqXHR) {
      'use strict';
      
      try {
        endSessionResponse(JSON.parse(jqXHR.responseText));
      } catch (e) {
        handleEndSessionError(jqXHR.responseText);
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      'use strict';
      
      handleEndSessionError(jqXHR.responseText);
    }
  });
}

/**
 * This handles the response from the end session query and displays an error or not.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param res
 *   - object containing the JSON response from the Butr server.
 */
function endSessionResponse(res) {
  'use strict';
  
  var responseStatus = '';
  var explanation = '';

  if (res === undefined || res === null || typeof(res) !== 'object') {
    return handleEndSessionError(res);
  }
  
  if (res.result !== undefined) {
    if (res.result.status !== undefined && res.result.status !== null && res.result.status !== '') {
      responseStatus = res.result.status ;
    }
  }

  if (responseStatus === 'OK') {
    // Session ended, so erase cookie and go and redirect to login screen.
    var cookieName = 'Butr|' + window.name;
    eraseCookie(cookieName);
    window.name = '';
    
    window.location.href = 'index.php';
    return;
  }

  return handleEndSessionError(res);
}

/**
 * This cleans up the session in the browser and takes you back
 * to the login screen. If an error occurs it logs you
 * out anyway.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param res
 *   - object or string containing the response from the server.
 */
function handleEndSessionError(res) {
  'use strict';
  
  // Erase cookies anyway
  var cookieName = 'Butr|' + window.name;
  eraseCookie(cookieName);
  window.name = '';
  
  window.location.href = 'index.php';
  return;
}

/**
 * This changes the number of results per page and refreshes the page with the requested
 * number of results per page.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param type
 *   - String containing the pagination type.
 * @param size
 *   - Integer containing the number of results per page.
 * @param callback
 *   - Function to be called to set the new list view. It is assumed it will
 *     have the parameters: callback(offset, size, ordinal, direction)
 */
function sizePagination(type, size, callback) {
  'use strict';
  
  var offset = 0;
  var ordinal = 'default';
  var direction = 'ascending';
  if (type === 'page') {
	offset = document.pagination_page_form.offset.value;
	ordinal = document.pagination_page_form.ordinal.value;
	direction = document.pagination_page_form.direction.value;
  }

  if (callback !== undefined && callback !== null && typeof(callback) === 'function') {
    callback(offset, size, ordinal, direction);
  }
}

/**
 * This changes the page being displayed for the results.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param type
 *   - Integer containing the pagination type.
 * @param offset
 *   - Integer containing the offset position for the results.
 * @param callback
 *   - Function to be called to set the new list view. It is assumed it will
 *     have the parameters: callback(offset, size, ordinal, direction)
 */
function jumpPagination(type, offset, callback) {
  'use strict';
  
  var size = 0;
  var ordinal = 'default';
  var direction = 'ascending';
  if (type === 'page') {
	size = document.pagination_page_form.size.value;
	ordinal = document.pagination_page_form.ordinal.value;
	direction = document.pagination_page_form.direction.value;
  }

  if (callback !== undefined && callback !== null && typeof(callback) === 'function') {
    callback(offset, size, ordinal, direction);
  }
}

/**
 * This toggles a well when it is clicked on. This is the default function
 * which is called if there is no action.
 * @param well
 *   - String containing the id of the well div
 */
function wellToggle(well) {
  'use strict';
  
  var pageWellInner = $('#' + well + '-inner');
  
  if (pageWellInner !== undefined && pageWellInner) {
	pageWellInner.slideToggle();
  }
}
