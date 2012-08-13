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
 * permission administration add permission page.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function setHistorySecurityPermissionAdd() {
  'use strict';
  
  var historyState = {};
  var content = '';
  historyState.pageUrl = 'security_permission.php';
  historyState.pageAttributes = 'a=add';
  historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_PermissionAdministration+' | '+butr_i18n_AddPermission;
  
  content = '?page=' + historyState.pageUrl + '&' + historyState.pageAttributes;

  // Remove trailing ampersand
  if (content.charAt(content.length - 1) === '&') {
	content = content.substring(0, content.length - 1);
  }
  
  document.title = historyState.pageTitle;
  $('#title').html(butr_i18n_PermissionAdministration+' - '+butr_i18n_AddPermission);
  document.butr_state_form.content.value = content;
  History.pushState(historyState, historyState.pageTitle, content);
}

/**
 * This set the history to allow back/forwards buttons. This is for the
 * permission administration fetch permission page.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param uuid
 *   - string containing the uuid of the user record.
 */
function setHistorySecurityPermissionFetch(uuid) {
  'use strict';
  
  var historyState = {};
  var content = '';
  historyState.pageUrl = 'security_permission.php';
  historyState.pageAttributes = 'a=fetch&uuid=' + uuid;
  historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_PermissionAdministration+' | '+butr_i18n_ModifyPermission;
  
  content = '?page=' + historyState.pageUrl + '&' + historyState.pageAttributes;

  // Remove trailing ampersand
  if (content.charAt(content.length - 1) === '&') {
	content = content.substring(0, content.length - 1);
  }
  
  document.title = historyState.pageTitle;
  $('#title').html(butr_i18n_PermissionAdministration+' - '+butr_i18n_ModifyPermission);
  document.butr_state_form.content.value = content;
  History.pushState(historyState, historyState.pageTitle, content);
}

/**
 * This set the history to allow back/forwards buttons. This is for the
 * permission administration list permission page.
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
function setHistorySecurityPermissionList(offset, size, ordinal, direction) {
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
  historyState.pageUrl = 'security_permission.php';
  historyState.pageAttributes = 'a=list&offset=' + escape(offset) + '&size=' + escape(size) + '&ordinal=' + escape(ordinal) + '&direction=' + escape(direction);
  historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_PermissionAdministration+' | '+butr_i18n_ListPermissions;
  
  content = '?page=' + historyState.pageUrl + '&' + historyState.pageAttributes;

  // Remove trailing ampersand
  if (content.charAt(content.length - 1) === '&') {
	content = content.substring(0, content.length - 1);
  }
  
  document.title = historyState.pageTitle;
  $('#title').html(butr_i18n_UserAdministration + ' - ' + butr_i18n_ListPermissions);
  document.butr_state_form.content.value = content;
  History.pushState(historyState, historyState.pageTitle, content);
}

/**
 * This checks the user form to ensure that the form has sensible information.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function processSecurityPermissionAddForm() {
  'use strict';
  
  var errorMessage = '';
  var moduleUuid = document.security_permission_add_form.module_uuid.value;
  var permissionName = document.security_permission_add_form.permission_name.value;
  var description = document.security_permission_add_form.description.value;
  var magic = document.security_permission_add_form.magic.value;
  var importance = document.security_permission_add_form.importance.value;
  
  $('#error').modal('hide');
  $('#warning').modal('hide');
  $('#notice').modal('hide');
  $('#debug').modal('hide');
  
  document.security_permission_add_form.submit.disabled = true;
  
  if (moduleUuid === undefined || moduleUuid === null || moduleUuid === '') {
    errorMessage += '<br>* '+butr_i18n_Module;
  }
  if (permissionName === undefined || permissionName === null || permissionName === '') {
	errorMessage += '<br>* '+butr_i18n_PermissionName;
  }
  if (magic === undefined || magic === null || magic === '') {
    errorMessage += '<br>* '+butr_i18n_Magic;
  }
  if (importance === undefined || importance === null || isNaN(importance)) {
    importance = '';
  }
  if (description === undefined || description === null || description === '') {
    description = '';
  }
  
  if (errorMessage !== '') {
    $('#notice_message').html(butr_i18n_PleaseCheckThatYouHaveCompleted+':'+errorMessage);
    $('#notice').modal('show');
    document.security_permission_add_form.submit.disabled = false;
    return false;
  }
  
  var form_body = '';
   
  form_body = 'module_uuid=' + escape(moduleUuid)
    + '&permission_name=' + escape(permissionName)
    + '&description=' + escape(description)
    + '&magic=' + escape(magic)
    + '&importance=' + escape(importance)
    + '&command=add_permission'
    + '&window_name=' + escape(window.name);
  
  $.ajax({
    url: 'ajax/security_permission.php',
    data: form_body,
    type: 'POST',
    contentType: 'application/x-www-form-urlencoded',
    success: function(data, textStatus, jqXHR) {
      'use strict';
      
      try {
        processSecurityPermissionAddResponse(JSON.parse(jqXHR.responseText));
      } catch (e) {
        handleSecurityPermissionAddError(jqXHR.responseText);
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      'use strict';
      
      handleSecurityPermissionAddError(jqXHR.responseText);
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
function processSecurityPermissionAddResponse(res) {
  'use strict';
  
  var responseStatus = '';
  var explanation = '';
  var permissionUuid = '';

  if (res === undefined || res === null || typeof(res) !== 'object') {
    return handleSecurityPermissionAddError(res);
  }
  
  if (res.result !== undefined) {
    if (res.result.status !== undefined && res.result.status !== null && res.result.status !== '') {
      responseStatus = res.result.status ;
    }
  }
  
  if (res.add_permission !== undefined) {
    if (res.add_permission.uuid !== undefined && res.add_permission.uuid !== null && res.add_permission.uuid !== '') {
      permissionUuid = res.add_permission.uuid;
    }
  }
  
  if (responseStatus === 'OK' && permissionUuid !== '') {
	return setHistorySecurityPermissionFetch(permissionUuid)
  }

  return handleSecurityPermissionAddError(res);
}

/**
 * This checks the user form to ensure that the form has sensible information.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function processSecurityPermissionModifyForm() {
  'use strict';
  
  var errorMessage = '';
  var uuid = document.security_permission_modify_form.uuid.value;
  var moduleUuid = document.security_permission_modify_form.module_uuid.value;
  var permissionName = document.security_permission_modify_form.permission_name.value;
  var description = document.security_permission_modify_form.description.value;
  var magic = document.security_permission_modify_form.magic.value;
  var importance = document.security_permission_modify_form.importance.value;
  
  $('#error').modal('hide');
  $('#warning').modal('hide');
  $('#notice').modal('hide');
  $('#debug').modal('hide');
  
  document.security_permission_modify_form.submit.disabled = true;
  
  if (moduleUuid === undefined || moduleUuid === null || moduleUuid === '') {
    errorMessage += '<br>* '+butr_i18n_Module;
  }
  if (permissionName === undefined || permissionName === null) {
	errorMessage += '<br>* '+butr_i18n_PermissionName;
  }
  if (magic === undefined || magic === null || magic === '') {
    errorMessage += '<br>* '+butr_i18n_Magic;
  }
  if (importance === undefined || importance === null || isNaN(importance)) {
    importance = '';
  }
  if (description === undefined || description === null || description === '') {
    description = '';
  }
  
  if (errorMessage !== '') {
    $('#notice_message').html(butr_i18n_PleaseCheckThatYouHaveCompleted+':'+errorMessage);
    $('#notice').modal('show');
    document.security_permission_modify_form.submit.disabled = false;
    return false;
  }
  
  var form_body = '';
   
  form_body = 'uuid=' + escape(uuid)
    + '&module_uuid=' + escape(moduleUuid)
    + '&permission_name=' + escape(permissionName)
    + '&description=' + escape(description)
    + '&magic=' + escape(magic)
    + '&importance=' + escape(importance)
    + '&command=modify_permission'
    + '&window_name=' + escape(window.name);
    
  $.ajax({
    url: 'ajax/security_permission.php',
    data: form_body,
    type: 'POST',
    contentType: 'application/x-www-form-urlencoded',
    success: function(data, textStatus, jqXHR) {
      'use strict';
      
      try {
        processSecurityPermissionModifyResponse(JSON.parse(jqXHR.responseText));
      } catch (e) {
        handleSecurityPermissionModifyError(jqXHR.responseText);
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      'use strict';
      
      handleSecurityPermissionModifyError(jqXHR.responseText);
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
function processSecurityPermissionModifyResponse(res) {
  'use strict';
  
  var responseStatus = '';
  var explanation = '';
  var permissionUuid = '';

  if (res === undefined || res === null || typeof(res) !== 'object') {
    return handleSecurityPermissionModifyError(res);
  }
  
  if (res.result !== undefined) {
    if (res.result.status !== undefined && res.result.status !== null && res.result.status !== '') {
      responseStatus = res.result.status ;
    }
  }
  
  if (res.modify_permission !== undefined) {
    if (res.modify_permission.uuid !== undefined && res.modify_permission.uuid !== null && res.modify_permission.uuid !== '') {
      permissionUuid = res.modify_permission.uuid;
    }
  }
  
  if (responseStatus === 'OK' && permissionUuid !== '') {
    // refresh view to be the view user and get it to pop a message to say user
    // was added.
    
    alert('Permission wth UUID = ' + permissionUuid + ' was modified.');
    
    document.security_permission_modify_form.submit.disabled = false;
    
    return;
  }

  return handleSecurityPermissionModifyError(res);
}

/**
 * This handles any errors and displays them in an error div.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param res
 *   - object or string containing the response from the server.
 */
function handleSecurityPermissionAddError(res) {
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
    explanation = butr_i18n_CouldNotAddPermission+'.';
  }

  if (responseStatus !== 'OK') {
    $('#error_message').html(explanation);
    $('#error').modal('show');
  }
  
  document.security_permission_add_form.submit.disabled = false;
}

/**
 * This handles any errors and displays them in an error div.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param res
 *   - object or string containing the response from the server.
 */
function handleSecurityPermissionModifyError(res) {
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
    explanation = butr_i18n_CouldNotModifyPermission+'.';
  }

  if (responseStatus !== 'OK') {
    $('#error_message').html(explanation);
    $('#error').modal('show');
  }
  
  document.security_permission_modify_form.submit.disabled = false;
}