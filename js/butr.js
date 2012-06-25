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
 * This handles the response from the session active query and displays an error or not.
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
 * This handles any errors and displays them in an error div.
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
    $('#error_message').html(explanation);
    $('#error').show();
  }
}

/**
 * This opens up the dock item
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param dock
 *   - string containing the html id of the dock-item-wrap div to display.
 */
function flyOpenDockItem(dock) {
  'use strict';
  
  var dockItemWrap = $('#' + dock);
  var dockTile = $('#' + dock.substring(0, dock.length - 5));
  var isVisible = false;
  
  if (dockItemWrap !== undefined && dockItemWrap !== null && typeof(dockItemWrap) === 'object'
    && dockTile !== undefined && dockTile !== null && typeof(dockTile) === 'object') {
    isVisible = dockItemWrap.is(":visible");    
    closeAllDockItems();
    
    if (!isVisible) {
      dockItemWrap.show();
      dockItemWrap.position({ of: dockTile,
        my: 'center bottom',
        at: 'center top',
        collision: 'flip flip',
        offset: '-5px'
      });
    }
  }
}

/**
 * Close the dock item
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param dock
 *   - string containing the identifier for the dock item.
 */
function flyCloseDockItem(dock) {
'use strict';
  
  var dockItemWrap = $('#' + dock);
  
  if (dockItemWrap !== undefined && dockItemWrap !== null && typeof(dockItemWrap) === 'object') {
    closeAllDockSubitems();
    dockItemWrap.hide();
  }
}

/**
 * This closes all the dock item menus
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function closeAllDockItems() {
  'use strict';
  
  var dockItemId = '';
  
  for(var i = 0; i < dockCount; i++) {
    dockItemId = 'dock-' + ((i < 10) ? '0' + i : i) + '-item';    
    flyCloseDockItem(dockItemId);
  }
  
}

/**
 * This opens up the dock item
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param dock
 *   - string containing the html id of the dock-item-wrap div to display.
 */
function flyOpenDockSubitem(dockItem) {
  'use strict';
  
  var dockSubitemWrap = $('#' + dockItem);
  var dockItemDiv = $('#' + dockItem.substring(0, dockItem.length - 8));
  var isVisible = false;
  
  if (dockSubitemWrap !== undefined && dockSubitemWrap !== null && typeof(dockSubitemWrap) === 'object'
    && dockItemDiv !== undefined && dockItemDiv !== null && typeof(dockItemDiv) === 'object') {
    isVisible = dockSubitemWrap.is(":visible");    
    closeAllDockSubitems();
    
    if (!isVisible) {
      dockSubitemWrap.show();
      dockSubitemWrap.position({ of: dockItemDiv,
        my: 'left bottom',
        at: 'right top',
        collision: 'flip flip',
        offset: '5px'
      });
    }
  }
}

/**
 * Close the dock subitem
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param dock
 *   - string containing the identifier for the dock item.
 */
function flyCloseDockSubitem(dockItem) {
  'use strict';
  
  var dockSubitemWrap = $('#' + dockItem);
  
  if (dockSubitemWrap !== undefined && dockSubitemWrap !== null && typeof(dockSubitemWrap) === 'object') {
    dockSubitemWrap.hide();
  }
}

/**
 * This closes all the dock item menus
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function closeAllDockSubitems() {
  'use strict';
  
  var dockSubitemId = '';
  
  for(var i = 0; i < dockCount; i++) {
    for(var j = 0; j < dockItemCount; j++) {
      dockSubitemId = 'dock-' + ((i < 10) ? '0' + i : i) + '-item-' + ((j < 10) ? '0' + j : j) + '-subitem';
      flyCloseDockSubitem(dockSubitemId);
    }
  }
}

/**
 * This is used to populate the content div with whatever is coming
 * from the menu item.
 * @param content
 *   - String containing the page to call to get the content from.
 */
function insertContent(content) {
  'use strict';
  
  $('#error').hide();
  $('#warning').hide();
  $('#notice').hide();
  
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
      
      insertContentResponse(jqXHR.responseText);
    },
    error: function(jqXHR, textStatus, errorThrown) {
      'use strict';
      
      handleInsertContentError(jqXHR.responseText);
    }
  });
}

/**
 * This function populates the content div with whatever the content from the
 * page call is.
 * @param res
 *   - String containing the HTML snippet.
 */
function insertContentResponse(res) {
  'use strict';
  
  var contentDiv = $('#content');
  
  if (contentDiv !== undefined && contentDiv !== null) {
    contentDiv.html(res);
  }
  closeAllDockItems();
}

/**
 * This handles any errors and displays them in an error div.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param res
 *   - object or string containing the response from the server.
 */
function handleInsertContentError(res) {
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
    $('#error_message').html(explanation);
    $('#error').show();
  }
}

/**
 * This parses the global configuration to leave an object
 * with name value pairs.
 * @param jsonConfig
 *   - String containing the global configuration.
 * @returns object
 *   - Object containing the configuration settings.
 */
function parseGlobalConfiguration(jsonConfig) {
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
  
  return jsonOutput;
}

/**
 * This parses the user's session to leave an object
 * with the same data.
 * @param jsonSession
 *   - String containing the user's session.
 * @returns object
 *   - Object containing the session settings.
 */
function parseSession(jsonSession) {
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
  
  return jsonOutput;
}

/**
 * This ends the current session.
 * @author Damien Whaley <damien@whelbonestudios.com>
 */
function logOut() {
  'use strict';
  
  $('#error').hide();
  $('#warning').hide();
  $('#notice').hide();
  
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
 * to the login screen.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param res
 *   - object or string containing the response from the server.
 */
function handleEndSessionError(res) {
  'use strict';
  
  var cookieName = 'Butr|' + window.name;
  eraseCookie(cookieName);
  window.name = '';
  
  window.location.href = 'index.php';
  return;
}

/**
 * This is fired whenever there is a state change. This figures out the content
 * to load and calls insertContent with the correct parameters.
 * @param state
 *   - Object containing the History state
 *   
 * TODO: Seems to cause a double hit when refreshing page. need to check to make
 * sure that if the previous state is the same as the current state that we do
 * not need to do this. It could also be in the history handling functions in the
 * js files for the pages themselves. need to document a case where it happens to
 * investigate.
 */
function handleHistoryStateChange(state) {
  'use strict';
  
  if (state === undefined || state === null) {
    // Nothing to do.
    return;
  }
  
  if (state.data === undefined || state.data === null) {
    // Nothing to do.
    return;
  }
  
  var pageUrl = state.data.pageUrl;
  var pageAttributes = state.data.pageAttributes;
  
  var content = pageUrl;
  if (pageAttributes !== undefined && pageAttributes !== null && pageAttributes !== '') {
    content += '?' + pageAttributes;
  }
  
  if (content !== undefined && content !== null && content !== '') {
    insertContent(content);
  }
}

/**
 * This changes the number of results per page and refreshes the page with the requested
 * number of results per page.
 * @param type
 *   - String containing the pagination type.
 * @param size
 *   - Integer containing the number of results per page.
 * @param callback
 *   - Function to be called to set the new list view. It is assumed it will
 *     have the parameters: callback(offset, size, ordinal, direction)
 */
function sizePagination(type, size, callback) {
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
 * @param type
 *   - Integer containing the pagination type.
 * @param offset
 *   - Integer containing the offset position for the results.
 * @param callback
 *   - Function to be called to set the new list view. It is assumed it will
 *     have the parameters: callback(offset, size, ordinal, direction)
 */
function jumpPagination(type, offset, callback) { 
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