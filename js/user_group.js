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
 * This set the history to allow back/forwards buttons. This is for the
 * user group administration add user group page.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function setHistoryUserGroupAdd() {
  'use strict';
  
  var historyState = {};
  var content = '';
  historyState.pageUrl = 'user_group.php';
  historyState.pageAttributes = 'a=add';
  historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_GroupAdministration+' | '+butr_i18n_AddGroup;
  
  content = '?page=' + historyState.pageUrl + '&' + historyState.pageAttributes;

  // Remove trailing ampersand
  if (content.charAt(content.length - 1) === '&') {
	  content = content.substring(0, content.length - 1);
  }
  
  document.title = historyState.pageTitle;
  $('#title').html(butr_i18n_GroupAdministration+' - '+butr_i18n_AddGroup);
  document.butr_state_form.content.value = content;
  History.pushState(historyState, historyState.pageTitle, content);
}

/**
 * This set the history to allow back/forwards buttons. This is for the
 * user group administration fetch user group page.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param uuid
 *   - string containing the uuid of the user group configuration record.
 */
function setHistoryUserGroupFetch(uuid) {
  'use strict';
  
  var historyState = {};
  var content = '';
  historyState.pageUrl = 'user_group.php';
  historyState.pageAttributes = 'a=fetch&uuid=' + uuid;
  historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_GroupAdministration+' | '+butr_i18n_ModifyGroup;
  
  content = '?page=' + historyState.pageUrl + '&' + historyState.pageAttributes;

  // Remove trailing ampersand
  if (content.charAt(content.length - 1) === '&') {
	  content = content.substring(0, content.length - 1);
  }
  
  document.title = historyState.pageTitle;
  $('#title').html(butr_i18n_GroupAdministration+' - '+butr_i18n_ModifyGroup);
  document.butr_state_form.content.value = content;
  History.pushState(historyState, historyState.pageTitle, content);
}

/**
 * This set the history to allow back/forwards buttons. This is for the
 * user group administration list user groups page.
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
function setHistoryUserGroupList(offset, size, ordinal, direction) {
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
	  historyState.pageUrl = 'user_group.php';
	  historyState.pageAttributes = 'a=list&offset=' + escape(offset) + '&size=' + escape(size) + '&ordinal=' + escape(ordinal) + '&direction=' + escape(direction);
	  historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_GroupAdministration+' | '+butr_i18n_ListGroups;
	  
	  content = '?page=' + historyState.pageUrl + '&' + historyState.pageAttributes;

	  // Remove trailing ampersand
	  if (content.charAt(content.length - 1) === '&') {
		  content = content.substring(0, content.length - 1);
	  }
	  
	  document.title = historyState.pageTitle;
	  $('#title').html(butr_i18n_GroupAdministration + ' - ' + butr_i18n_ListGroups);
	  document.butr_state_form.content.value = content;
	  History.pushState(historyState, historyState.pageTitle, content);
	}

/**
 * This checks the form to ensure that the form has sensible information.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function processUserGroupAddForm() {
  'use strict';
  
  var errorMessage = '';
  var groupName = document.user_group_add_form.group_name.value;
  var displayName = document.user_group_add_form.display_name.value;
  var description = document.user_group_add_form.description.value;
  var isActive = 0;
  if (document.user_group_add_form.is_active.checked === true) {
	isActive = 1;  
  }
  
  $('#error').hide();
  $('#warning').hide();
  $('#notice').hide();
  document.user_group_add_form.submit.disabled = true;
  
  if (groupName === undefined || groupName === null || groupName === '') {
    errorMessage += '<br>* '+butr_i18n_GroupName;
  }
  if (displayName === undefined || displayName === null || displayName === '') {
    displayName = '';
  }
  if (description === undefined || description === null || description === '') {
    description = '';
  }
  
  if (errorMessage !== '') {
    $('#notice_message').html(butr_i18n_PleaseCheckThatYouHaveCompleted+':'+errorMessage);
    $('#notice').show();
    document.user_group_add_form.submit.disabled = false;
    return false;
  }
  
  var form_body = '';
   
  form_body = 'group_name=' + escape(groupName)
    + '&display_name=' + escape(displayName)
    + '&description=' + escape(description)
    + '&is_active=' + escape(isActive)
    + '&command=add_group'
    + '&window_name=' + escape(window.name);
    
  $.ajax({
    url: 'ajax/user_group.php',
    data: form_body,
    type: 'POST',
    contentType: 'application/x-www-form-urlencoded',
    success: function(data, textStatus, jqXHR) {
      'use strict';
      
      try {
        processUserGroupAddResponse(JSON.parse(jqXHR.responseText));
      } catch (e) {
        handleUserGroupAddError(jqXHR.responseText);
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      'use strict';
      
      handleUserGroupAddError(jqXHR.responseText);
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
function processUserGroupAddResponse(res) {
  'use strict';
  
  var responseStatus = '';
  var explanation = '';
  var groupUuid = '';

  if (res === undefined || res === null || typeof(res) !== 'object') {
    return handleUserGroupAddError(res);
  }
  
  if (res.result !== undefined) {
    if (res.result.status !== undefined
      && res.result.status !== null
      && res.result.status !== '') {
      responseStatus = res.result.status ;
    }
  }
  
  if (res.add_group !== undefined) {
    if (res.add_group.uuid !== undefined
      && res.add_group.uuid !== null
      && res.add_group.uuid !== '') {
      groupUuid = res.add_group.uuid;
    }
  }
  
  if (responseStatus === 'OK' && groupUuid !== '') {
	return setHistoryUserGroupFetch(groupUuid);
  }

  return handleUserGroupFetchAddError(res);
}

/**
 * This checks the form to ensure that the form has sensible information.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function processUserGroupModifyForm() {
  'use strict';
  
  var errorMessage = '';
  var uuid = document.user_group_modify_form.uuid.value;
  var groupName = document.user_group_modify_form.group_name.value;
  var displayName = document.user_group_modify_form.display_name.value;
  var description = document.user_group_modify_form.description.value;
  var isActive = 0;
  if (document.user_group_modify_form.is_active.checked === true) {
	isActive = 1;  
  }
  
  $('#error').hide();
  $('#warning').hide();
  $('#notice').hide();
  document.user_group_modify_form.submit.disabled = true;
  
  if (groupName === undefined || groupName === null || groupName === '') {
    errorMessage += '<br>* '+butr_i18n_GroupName;
  }
  if (displayName === undefined || displayName === null || displayName === '') {
    displayName = '';
  }
  if (description === undefined || description === null || description === '') {
    description = '';
  }
  
  if (errorMessage !== '') {
    $('#notice_message').html(butr_i18n_PleaseCheckThatYouHaveCompleted+':'+errorMessage);
    $('#notice').show();
    document.user_group_modify_form.submit.disabled = false;
    return false;
  }
  
  var form_body = '';
  
  form_body = 'uuid=' + escape(uuid)
	+ '&group_name=' + escape(groupName)
    + '&display_name=' + escape(displayName)
    + '&description=' + escape(description)
    + '&is_active=' + escape(isActive)
    + '&command=modify_group'
    + '&window_name=' + escape(window.name);
    
  $.ajax({
    url: 'ajax/user_group.php',
    data: form_body,
    type: 'POST',
    contentType: 'application/x-www-form-urlencoded',
    success: function(data, textStatus, jqXHR) {
      'use strict';
      
      try {
        processUserGroupModifyResponse(JSON.parse(jqXHR.responseText));
      } catch (e) {
        handleUserGroupModifyError(jqXHR.responseText);
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      'use strict';
      
      handleUserGroupModifyError(jqXHR.responseText);
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
function processUserGroupModifyResponse(res) {
  'use strict';
  
  var responseStatus = '';
  var explanation = '';
  var groupUuid = '';

  if (res === undefined || res === null || typeof(res) !== 'object') {
    return handleUserGroupModifyError(res);
  }
  
  if (res.result !== undefined) {
    if (res.result.status !== undefined
      && res.result.status !== null
      && res.result.status !== '') {
      responseStatus = res.result.status ;
    }
  }
  
  if (res.modify_group !== undefined) {
    if (res.modify_group.uuid !== undefined
      && res.modify_group.uuid !== null
      && res.modify_group.uuid !== '') {
      groupUuid = res.modify_group.uuid;
    }
  }
  
  if (responseStatus === 'OK' && groupUuid !== '') {
    // refresh view to be the view and get it to pop a message to say record
    // was added.
    
    alert('Group wth UUID = ' + groupUuid + ' was modified.');
    
    document.user_group_modify_form.submit.disabled = false;
    
    return;
  }

  return handleUserGroupModifyError(res);
}

/**
 * This handles any errors and displays them in an error div.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param res
 *   - object or string containing the response from the server.
 */
function handleUserGroupAddError(res) {
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
      if (res.result.status !== undefined
        && res.result.status !== null
        && res.result.status !== '') {
        responseStatus = res.result.status ;
      }
    }

    if (responseStatus !== 'OK') {
      if (res.result !== undefined) {
        if (res.result.explanation !== undefined
          && res.result.explanation !== null
          && res.result.explanation !== '') {
          explanation = res.result.explanation;
        }
      }
    }
  }
  
  if (explanation === '') {
    explanation = butr_i18n_CouldNotAddGroup+'.';
  }

  if (responseStatus !== 'OK') {
    $('#error_message').html(explanation);
    $('#error').show();
  }
  
  document.user_group_add_form.submit.disabled = false;
}

/**
 * This handles any errors and displays them in an error div.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param res
 *   - object or string containing the response from the server.
 */
function handleUserGroupModifyError(res) {
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
      if (res.result.status !== undefined
        && res.result.status !== null
        && res.result.status !== '') {
        responseStatus = res.result.status ;
      }
    }

    if (responseStatus !== 'OK') {
      if (res.result !== undefined) {
        if (res.result.explanation !== undefined
          && res.result.explanation !== null
          && res.result.explanation !== '') {
          explanation = res.result.explanation;
        }
      }
    }
  }
  
  if (explanation === '') {
    explanation = butr_i18n_CouldNotModifyGroup+'.';
  }

  if (responseStatus !== 'OK') {
    $('#error_message').html(explanation);
    $('#error').show();
  }
  
  document.user_group_modify_form.submit.disabled = false;
}