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
 * This set the dock history to allow back/forwards buttons. This is for the
 * dock administration page.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function setHistorySystemDock() {
  'use strict';
  
  var content = '';
  var historyState = {};
  historyState.pageUrl = 'system_dock.php';
  historyState.pageAttributes = '';
  historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_DockAdministration;
  
  content = '?page=' + historyState.pageUrl + '&' + historyState.pageAttributes;

  // Remove trailing ampersand
  if (content.charAt(content.length - 1) === '&') {
	  content = content.substring(0, content.length - 1);
  }

  document.title = historyState.pageTitle;
  $('#title').html(butr_i18n_DockAdministration);
  document.butr_state_form.content.value = content;
  History.pushState(historyState, historyState.pageTitle, content);
}

/**
 * This set the dock history to allow back/forwards buttons. This is for the
 * system dock administration add dock page.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function setHistorySystemDockAdd() {
  'use strict';
  
  var historyState = {};
  var content = '';
  historyState.pageUrl = 'system_dock.php';
  historyState.pageAttributes = 'a=add';
  historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_DockAdministration+' | '+butr_i18n_AddDock;
  
  content = '?page=' + historyState.pageUrl + '&' + historyState.pageAttributes;

  // Remove trailing ampersand
  if (content.charAt(content.length - 1) === '&') {
	  content = content.substring(0, content.length - 1);
  }

  document.title = historyState.pageTitle;
  $('#title').html(butr_i18n_DockAdministration+' - '+butr_i18n_AddDock);
  document.butr_state_form.content.value = content;
  History.pushState(historyState, historyState.pageTitle, content);
}

/**
 * This set the dock history to allow back/forwards buttons. This is for the
 * dock administration add dock page.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param uuid
 *   - string containing the uuid of the dock record.
 */
function setHistorySystemDockFetch(uuid) {
  'use strict';
  
  var historyState = {};
  var content = '';
  historyState.pageUrl = 'system_dock.php';
  historyState.pageAttributes = 'a=fetch&uuid=' + uuid;
  historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_DockAdministration+' | '+butr_i18n_ModifyDock;
  
  content = '?page=' + historyState.pageUrl + '&' + historyState.pageAttributes;

  // Remove trailing ampersand
  if (content.charAt(content.length - 1) === '&') {
	  content = content.substring(0, content.length - 1);
  }
  
  document.title = historyState.pageTitle;
  $('#title').html(butr_i18n_DockAdministration+' - '+butr_i18n_ModifyDock);
  document.butr_state_form.content.value = content;
  History.pushState(historyState, historyState.pageTitle, content);
}

/**
 * This set the dock history to allow back/forwards buttons. This is for the
 * dock administration list dock page.
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
function setHistorySystemDockList(offset, size, ordinal, direction) {
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
	  historyState.pageUrl = 'system_dock.php';
	  historyState.pageAttributes = 'a=list&offset=' + escape(offset) + '&size=' + escape(size) + '&ordinal=' + escape(ordinal) + '&direction=' + escape(direction);
	  historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_DockAdministration+' | '+butr_i18n_ListDocks;
	  
	  content = '?page=' + historyState.pageUrl + '&' + historyState.pageAttributes;

	  //remove trailing ampersand
	  if (content.charAt(content.length - 1) === '&') {
		  content = content.substring(0, content.length - 1);
	  }
	  
	  History.pushState(historyState, historyState.pageTitle, content);
	  
	  document.title = historyState.pageTitle;
	  $('#title').html(butr_i18n_DockAdministration  + ' - ' + butr_i18n_ListDocks);
	  
	  document.butr_state_form.content.value = content;
	}

/**
 * This checks the dock form to ensure that the form has sensible information.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function processSystemDockAddForm() {
  'use strict';
  
  var errorMessage = '';
  var securityClientTypeUuid = document.system_dock_add_form.security_client_type_uuid.value;
  var dockName = document.system_dock_add_form.dock_name.value;
  var displayName = document.system_dock_add_form.display_name.value;
  var description = document.system_dock_add_form.description.value;
  var weighting = document.system_dock_add_form.weighting.value;
  var picturePath = document.system_dock_add_form.picture_path.value;
  var isActive = 0;
  if (document.system_dock_add_form.is_active.checked === true) {
	isActive = 1;  
  }
  
  $('#error').modal('hide');
  $('#warning').modal('hide');
  $('#notice').modal('hide');
  $('#debug').modal('hide');
  
  document.system_dock_add_form.submit.disabled = true;
  
  if (securityClientTypeUuid === undefined || securityClientTypeUuid === null || securityClientTypeUuid === '') {
    errorMessage += '<br>* '+butr_i18n_SecurityClientType;
  }
  if (dockName === undefined || dockName === null || dockName === '') {
	  errorMessage += '<br>* '+butr_i18n_DockName;
  }
  if (displayName === undefined || displayName === null || displayName === '') {
    displayName = '';
  }
  if (description === undefined || description === null || description === '') {
    description = '';
  }
  if (weighting === undefined || weighting === null || isNaN(weighting)) {
    weighting = '';
  }
  if (picturePath === undefined || picturePath === null || picturePath === '') {
	picturePath = '';
  }
  
  if (errorMessage !== '') {
    $('#notice_message').html(butr_i18n_PleaseCheckThatYouHaveCompleted+':'+errorMessage);
    $('#notice').modal('show');
    document.system_dock_add_form.submit.disabled = false;
    return false;
  }
  
  var form_body = '';
   
  form_body = 'security_client_type_uuid=' + escape(securityClientTypeUuid)
    + '&dock_name=' + escape(dockName)
    + '&display_name=' + escape(displayName)
    + '&description=' + escape(description)
    + '&weighting=' + escape(weighting)
    + '&picture_path='+ escape(picturePath)
    + '&is_active=' + escape(isActive)
    + '&command=add_dock'
    + '&window_name=' + escape(window.name);
    
  $.ajax({
    url: 'ajax/system_dock.php',
    data: form_body,
    type: 'POST',
    contentType: 'application/x-www-form-urlencoded',
    success: function(data, textStatus, jqXHR) {
      'use strict';
      
      try {
        processSystemDockAddResponse(JSON.parse(jqXHR.responseText));
      } catch (e) {
        handleSystemDockAddError(jqXHR.responseText);
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      'use strict';
      
      handleSystemDockAddError(jqXHR.responseText);
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
function processSystemDockAddResponse(res) {
  'use strict';
  
  var responseStatus = '';
  var explanation = '';
  var dockUuid = '';

  if (res === undefined || res === null || typeof(res) !== 'object') {
    return handleSystemDockAddError(res);
  }
  
  if (res.result !== undefined) {
    if (res.result.status !== undefined && res.result.status !== null && res.result.status !== '') {
      responseStatus = res.result.status ;
    }
  }
  
  if (res.add_dock !== undefined) {
    if (res.add_dock.uuid !== undefined && res.add_dock.uuid !== null && res.add_dock.uuid !== '') {
      dockUuid = res.add_dock.uuid;
    }
  }
  
  if (responseStatus === 'OK' && dockUuid !== '') {
	document.butr_state_form.content.value = 'system_dock.php?a=fetch&uuid=' + escape(dockUuid) + '&success=ok_add';
	document.butr_state_form.submit();   
    return;
  }

  return handleSystemDockAddError(res);
}

/**
 * This checks the dock form to ensure that the form has sensible information.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function processSystemDockModifyForm() {
  'use strict';
  
  var errorMessage = '';
  var uuid = document.system_dock_modify_form.uuid.value;
  var securityClientTypeUuid = document.system_dock_modify_form.security_client_type_uuid.value;
  var dockName = document.system_dock_modify_form.dock_name.value;
  var displayName = document.system_dock_modify_form.display_name.value;
  var description = document.system_dock_modify_form.description.value;
  var weighting = document.system_dock_modify_form.weighting.value;
  var picturePath = document.system_dock_modify_form.picture_path.value;
  var isActive = 0;
  if (document.system_dock_modify_form.is_active.checked === true) {
	isActive = 1;  
  }
  
  $('#error').modal('hide');
  $('#warning').modal('hide');
  $('#notice').modal('hide');
  $('#debug').modal('hide');
  
  document.system_dock_modify_form.submit.disabled = true;
  
  if (securityClientTypeUuid === undefined || securityClientTypeUuid === null || securityClientTypeUuid === '') {
    errorMessage += '<br>* '+butr_i18n_SecurityClientType;
  }
  if (dockName === undefined || dockName === null) {
	  errorMessage += '<br>* '+butr_i18n_DockName;
  }
  if (displayName === undefined || displayName === null || displayName === '') {
    displayName = '';
  }
  if (description === undefined || description === null || description === '') {
    description = '';
  }
  if (weighting === undefined || weighting === null || isNaN(weighting)) {
    weighting = '';
  }
  if (picturePath === undefined || picturePath === null || picturePath === '') {
	picturePath = '';
  }
  
  if (errorMessage !== '') {
    $('#notice_message').html(butr_i18n_PleaseCheckThatYouHaveCompleted+':'+errorMessage);
    $('#notice').modal('show');
    document.system_dock_modify_form.submit.disabled = false;
    return false;
  }
  
  var form_body = '';
   
  form_body = 'uuid=' + escape(uuid)
    + '&security_client_type_uuid=' + escape(securityClientTypeUuid)
    + '&dock_name=' + escape(dockName)
    + '&display_name=' + escape(displayName)
    + '&description=' + escape(description)
    + '&weighting=' + escape(weighting)
    + '&picture_path='+ escape(picturePath)
    + '&is_active=' + escape(isActive)
    + '&command=modify_dock'
    + '&window_name=' + escape(window.name);
    
  $.ajax({
    url: 'ajax/system_dock.php',
    data: form_body,
    type: 'POST',
    contentType: 'application/x-www-form-urlencoded',
    success: function(data, textStatus, jqXHR) {
      'use strict';
      
      try {
        processSystemDockModifyResponse(JSON.parse(jqXHR.responseText));
      } catch (e) {
        handleSystemDockModifyError(jqXHR.responseText);
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      'use strict';
      
      handleSystemDockModifyError(jqXHR.responseText);
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
function processSystemDockModifyResponse(res) {
  'use strict';
  
  var responseStatus = '';
  var explanation = '';
  var dockUuid = '';

  if (res === undefined || res === null || typeof(res) !== 'object') {
    return handleSystemDockModifyError(res);
  }
  
  if (res.result !== undefined) {
    if (res.result.status !== undefined && res.result.status !== null && res.result.status !== '') {
      responseStatus = res.result.status ;
    }
  }
  
  if (res.modify_dock !== undefined) {
    if (res.modify_dock.uuid !== undefined && res.modify_dock.uuid !== null && res.modify_dock.uuid !== '') {
      dockUuid = res.modify_dock.uuid;
    }
  }
  
  if (responseStatus === 'OK' && dockUuid !== '') {
    // refresh view to be the view dock and get it to pop a message to say dock
    // was modified.
    
    alert('Dock wth UUID = ' + dockUuid + ' was modified.');
    
    document.system_dock_modify_form.submit.disabled = false;
    
    return;
  }

  return handleSystemDockModifyError(res);
}

/**
 * This handles any errors and displays them in an error div.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param res
 *   - object or string containing the response from the server.
 */
function handleSystemDockAddError(res) {
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
    explanation = butr_i18n_CouldNotAddDock+'.';
  }

  if (responseStatus !== 'OK') {
    $('#error_message').html(explanation);
    $('#error').modal('show');
  }
  
  document.system_dock_add_form.submit.disabled = false;
}

/**
 * This handles any errors and displays them in an error div.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param res
 *   - object or string containing the response from the server.
 */
function handleSystemDockModifyError(res) {
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
    explanation = butr_i18n_CouldNotModifyDock+'.';
  }

  if (responseStatus !== 'OK') {
    $('#error_message').html(explanation);
    $('#error').modal('show');
  }
  
  document.system_dock_modify_form.submit.disabled = false;
}