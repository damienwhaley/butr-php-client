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
 * This set the user history to allow back/forwards buttons. This is for the
 * user administration add user page.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function setHistoryUserUserAdd() {
  'use strict';
  
  var historyState = {};
  var content = '';
  historyState.pageUrl = 'user_user.php';
  historyState.pageAttributes = 'a=add';
  historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_UserAdministration+' | '+butr_i18n_AddUser;
  
  content = '?page=' + historyState.pageUrl + '&' + historyState.pageAttributes;

  // Remove trailing ampersand
  if (content.charAt(content.length - 1) === '&') {
	  content = content.substring(0, content.length - 1);
  }
  
  document.title = historyState.pageTitle;
  $('#page-title').html(butr_i18n_UserAdministration+' - '+butr_i18n_AddUser);
  document.butr_state_form.content.value = content;
  History.pushState(historyState, historyState.pageTitle, content);
}

/**
 * This set the user history to allow back/forwards buttons. This is for the
 * user administration add user page.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param uuid
 *   - string containing the uuid of the user record.
 */
function setHistoryUserUserFetch(uuid) {
  'use strict';
  
  var historyState = {};
  var content = '';
  historyState.pageUrl = 'user_user.php';
  historyState.pageAttributes = 'a=fetch&uuid=' + uuid;
  historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_UserAdministration+' | '+butr_i18n_ModifyUser;
  
  content = '?page=' + historyState.pageUrl + '&' + historyState.pageAttributes;

  // Remove trailing ampersand
  if (content.charAt(content.length - 1) === '&') {
	  content = content.substring(0, content.length - 1);
  }
  
  document.title = historyState.pageTitle;
  $('#page-title').html(butr_i18n_UserAdministration+' - '+butr_i18n_ModifyUser);
  document.butr_state_form.content.value = content;
  History.pushState(historyState, historyState.pageTitle, content);
}

/**
 * This set the user history to allow back/forwards buttons. This is for the
 * user administration add user page.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param offset
 *   - integer containing the segment to display.
 * @param size
 *   - integer containing the number of results per offset.
 * @param ordinal
 *   - string containing the field ordinal to order results on.
 * @param direction
 *   - string containing the direction of sorting.
 */
function setHistoryUserUserList(offset, size, ordinal, direction) {
	  'use strict';
	  
	  if (offset === undefined || offset === null || isNaN(offset)) {
		offset = 0;
	  }
	  
	  if (size === undefined || size === null || isNaN(size)) {
		size = 20;
	  }
	  
	  if (ordinal === undefined || ordinal === null || ordinal === '') {
		ordinal = 'default';
	  }
	  
	  if (direction === undefined || direction === null || direction === '') {
		direction = 'ascending';
	  }
	  
	  var content = '';
	  var historyState = {};
	  historyState.pageUrl = 'user_user.php';
	  historyState.pageAttributes = 'a=list&offset=' + escape(offset) + '&size=' + escape(size) + '&ordinal=' + escape(ordinal) + '&direction=' + escape(direction);
	  historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_UserAdministration+' | '+butr_i18n_ListUsers;
	  
	  content = '?page=' + historyState.pageUrl + '&' + historyState.pageAttributes;

	  // Remove trailing ampersand
	  if (content.charAt(content.length - 1) === '&') {
		  content = content.substring(0, content.length - 1);
	  }
	  
	  document.title = historyState.pageTitle;
	  $('#page-title').html(butr_i18n_UserAdministration + ' - ' + butr_i18n_ListUsers);
	  document.butr_state_form.content.value = content;
	  History.pushState(historyState, historyState.pageTitle, content);
	}

/**
 * This checks the user form to ensure that the form has sensible information.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function processUserUserAddForm() {
  'use strict';
  
  var errorMessage = '';
  var globalTitleUuid = document.user_user_add_form.global_title_uuid.value;
  var firstName = document.user_user_add_form.first_name.value;
  var lastName = document.user_user_add_form.last_name.value;
  var preferredGlobalLanguageUuid = document.user_user_add_form.preferred_global_language_uuid.value;
  var username = document.user_user_add_form.username.value;
  
  $('#error').modal('hide');
  $('#warning').modal('hide');
  $('#notice').modal('hide');
  $('#debug').modal('hide');
  
  document.user_user_add_form.submit.disabled = true;
  
  if (globalTitleUuid === undefined || globalTitleUuid === null || globalTitleUuid === '') {
    errorMessage += '<br>* '+butr_i18n_Title;
  }
  if (firstName === undefined || firstName === null) {
    firstName = '';
  }
  if (lastName === undefined || lastName === null || lastName === '') {
    errorMessage += '<br>* '+butr_i18n_LastName;
  }
  if (preferredGlobalLanguageUuid === undefined || preferredGlobalLanguageUuid === null) {
    preferredGlobalLanguageUuid = '';
  }
  if (username === undefined || username === null || username === '') {
    errorMessage += '<br>* '+butr_i18n_Username;
  }
  
  if (errorMessage !== '') {
    $('#notice_message').html(butr_i18n_PleaseCheckThatYouHaveCompleted+':'+errorMessage);
    $('#notice').modal('show');
    document.user_user_add_form.submit.disabled = false;
    return false;
  }
  
  var form_body = '';
   
  form_body = 'global_title_uuid=' + escape(globalTitleUuid)
    + '&first_name=' + escape(firstName)
    + '&last_name=' + escape(lastName)
    + '&preferred_global_language_uuid=' + escape(preferredGlobalLanguageUuid)
    + '&username=' + escape(username)
    + '&command=add_user'
    + '&window_name=' + escape(window.name);
    
  $.ajax({
    url: 'ajax/user_user.php',
    data: form_body,
    type: 'POST',
    contentType: 'application/x-www-form-urlencoded',
    success: function(data, textStatus, jqXHR) {
      'use strict';
      
      try {
        processUserUserAddResponse(JSON.parse(jqXHR.responseText));
      } catch (e) {
        handleUserUserAddError(jqXHR.responseText);
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      'use strict';
      
      handleUserUserAddError(jqXHR.responseText);
    }
  });
  
  return false;
}

/**
 * This function handles the login and then posts to the next system screen.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param res
 *   - object containing the JSON response from the Butr server.
 */
function processUserUserAddResponse(res) {
  'use strict';
  
  var responseStatus = '';
  var explanation = '';
  var userUuid = '';

  if (res === undefined || res === null || typeof(res) !== 'object') {
    return handleUserUserAddError(res);
  }
  
  if (res.result !== undefined) {
    if (res.result.status !== undefined && res.result.status !== null && res.result.status !== '') {
      responseStatus = res.result.status ;
    }
  }
  
  if (res.add_user !== undefined) {
    if (res.add_user.uuid !== undefined && res.add_user.uuid !== null && res.add_user.uuid !== '') {
      userUuid = res.add_user.uuid;
    }
  }
  
  if (responseStatus === 'OK' && userUuid !== '') {
	document.butr_state_form.content.value = 'user_user.php?a=fetch&uuid=' + escape(userUuid) + '&success=ok_add';
	document.butr_state_form.submit();   
    return;
  }

  return handleUserUserAddError(res);
}

/**
 * This checks the user form to ensure that the form has sensible information.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function processUserUserModifyForm() {
  'use strict';
  
  var errorMessage = '';
  var uuid = document.user_user_modify_form.uuid.value;
  var globalTitleUuid = document.user_user_modify_form.global_title_uuid.value;
  var firstName = document.user_user_modify_form.first_name.value;
  var lastName = document.user_user_modify_form.last_name.value;
  var preferredGlobalLanguageUuid = document.user_user_modify_form.preferred_global_language_uuid.value;
  var username = document.user_user_modify_form.username.value;
  
  $('#error').modal('hide');
  $('#warning').modal('hide');
  $('#notice').modal('hide');
  $('#debug').modal('hide');
  
  document.user_user_modify_form.submit.disabled = true;
  
  if (globalTitleUuid === undefined || globalTitleUuid === null || globalTitleUuid === '') {
    errorMessage += '<br>* '+butr_i18n_Title;
  }
  if (firstName === undefined || firstName === null) {
    firstName = '';
  }
  if (lastName === undefined || lastName === null || lastName === '') {
    errorMessage += '<br>* '+butr_i18n_LastName;
  }
  if (preferredGlobalLanguageUuid === undefined || preferredGlobalLanguageUuid === null) {
    preferredGlobalLanguageUuid = '';
  }
  if (username === undefined || username === null || username === '') {
    errorMessage += '<br>* '+butr_i18n_Username;
  }
  
  if (errorMessage !== '') {
    $('#notice_message').html(butr_i18n_PleaseCheckThatYouHaveCompleted+':'+errorMessage);
    $('#notice').modal('show');
    document.user_user_modify_form.submit.disabled = false;
    return false;
  }
  
  var form_body = '';
   
  form_body = 'uuid=' + escape(uuid)
    + '&global_title_uuid=' + escape(globalTitleUuid)
    + '&first_name=' + escape(firstName)
    + '&last_name=' + escape(lastName)
    + '&preferred_global_language_uuid=' + escape(preferredGlobalLanguageUuid)
    + '&username=' + escape(username)
    + '&command=modify_user'
    + '&window_name=' + escape(window.name);
    
  $.ajax({
    url: 'ajax/user_user.php',
    data: form_body,
    type: 'POST',
    contentType: 'application/x-www-form-urlencoded',
    success: function(data, textStatus, jqXHR) {
      'use strict';
      
      try {
        processUserUserModifyResponse(JSON.parse(jqXHR.responseText));
      } catch (e) {
        handleUserUserModifyError(jqXHR.responseText);
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      'use strict';
      
      handleUserUserModifyError(jqXHR.responseText);
    }
  });
  
  return false;
}

/**
 * This function handles the login and then posts to the next system screen.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param res
 *   - object containing the JSON response from the Butr server.
 */
function processUserUserModifyResponse(res) {
  'use strict';
  
  var responseStatus = '';
  var explanation = '';
  var userUuid = '';

  if (res === undefined || res === null || typeof(res) !== 'object') {
    return handleUserUserModifyError(res);
  }
  
  if (res.result !== undefined) {
    if (res.result.status !== undefined && res.result.status !== null && res.result.status !== '') {
      responseStatus = res.result.status ;
    }
  }
  
  if (res.modify_user !== undefined) {
    if (res.modify_user.uuid !== undefined && res.modify_user.uuid !== null && res.modify_user.uuid !== '') {
      userUuid = res.modify_user.uuid;
    }
  }
  
  if (responseStatus === 'OK' && userUuid !== '') {
    // refresh view to be the view user and get it to pop a message to say user
    // was added.
    
    alert('User wth UUID = ' + userUuid + ' was modified.');
    
    document.user_user_modify_form.submit.disabled = false;
    
    return;
  }

  return handleUserUserModifyError(res);
}

/**
 * This handles any errors and displays them in an error div.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param res
 *   - object or string containing the response from the server.
 */
function handleUserUserAddError(res) {
  'use strict';
  
  var responseStatus = '';
  var explanation = '';
  
  try {
    res = JSON.parse(res);
  }
  catch (e) {
    // Do nothing.
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
    explanation = butr_i18n_CouldNotAddUser+'.';
  }

  if (responseStatus !== 'OK') {
    $('#error_message').html(explanation);
    $('#error').modal('show');
  }
  
  document.user_user_add_form.submit.disabled = false;
}

/**
 * This handles any errors and displays them in an error div.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param res
 *   - object or string containing the response from the server.
 */
function handleUserUserModifyError(res) {
  'use strict';
  
  var responseStatus = '';
  var explanation = '';
  
  try {
    res = JSON.parse(res);
  }
  catch (e) {
    // Do nothing.
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
    explanation = butr_i18n_CouldNotModifyUser+'.';
  }

  if (responseStatus !== 'OK') {
    $('#error_message').html(explanation);
    $('#error').modal('show');
  }
  
  document.user_user_modify_form.submit.disabled = false;
}