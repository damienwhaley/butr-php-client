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
 * This set the dock tab history to allow back/forwards buttons. This is for the
 * dock item administration page.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function setHistorySystemDockTab() {
  'use strict';
  
  var content = '';
  var historyState = {};
  historyState.pageUrl = 'system_dock_tab.php';
  historyState.pageAttributes = '';
  historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_DockTabAdministration;
  
  content = '?page=' + historyState.pageUrl + '&' + historyState.pageAttributes;

  //remove trailing ampersand
  if (content.charAt(content.length - 1) === '&') {
	  content = content.substring(0, content.length - 1);
  }
  
  History.pushState(historyState, historyState.pageTitle, content);
  
  document.title = historyState.pageTitle;
  $('#title').html(butr_i18n_DockTabAdministration);
  
  document.butr_state_form.content.value = content;
}

/**
 * This set the dock tab history to allow back/forwards buttons. This is for the
 * system dock tab administration add dock tab page.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function setHistorySystemDockTabAdd() {
  'use strict';
  
  var historyState = {};
  var content = '';
  historyState.pageUrl = 'system_dock_tab.php';
  historyState.pageAttributes = 'a=add';
  historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_DockTabAdministration+' | '+butr_i18n_AddDockTab;
  
  content = '?page=' + historyState.pageUrl + '&' + historyState.pageAttributes;

  //remove trailing ampersand
  if (content.charAt(content.length - 1) === '&') {
	  content = content.substring(0, content.length - 1);
  }
  
  History.pushState(historyState, historyState.pageTitle, content);
  
  document.title = historyState.pageTitle;
  $('#title').html(butr_i18n_DockTabAdministration+' - '+butr_i18n_AddDockTab);
  
  document.butr_state_form.content.value = content;
}

/**
 * This set the dock tab history to allow back/forwards buttons. This is for the
 * dock tab administration add dock tab page.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param uuid
 *   - string containing the uuid of the dock item record.
 */
function setHistorySystemDockTabFetch(uuid) {
  'use strict';
  
  var historyState = {};
  var content = '';
  historyState.pageUrl = 'system_dock_tab.php';
  historyState.pageAttributes = 'a=fetch&uuid=' + uuid;
  historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_DockTabAdministration+' | '+butr_i18n_ModifyDockTab;
  
  content = '?page=' + historyState.pageUrl + '&' + historyState.pageAttributes;

  //remove trailing ampersand
  if (content.charAt(content.length - 1) === '&') {
	  content = content.substring(0, content.length - 1);
  }
  
  History.pushState(historyState, historyState.pageTitle, content);
  
  document.title = historyState.pageTitle;
  $('#title').html(butr_i18n_DockTabAdministration+' - '+butr_i18n_ModifyDockTab);
  
  document.butr_state_form.content.value = content;
}

/**
 * This set the dock tab history to allow back/forwards buttons. This is for the
 * dock tab administration list dock tab page.
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
function setHistorySystemDockTabList(offset, size, ordinal, direction) {
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
	  historyState.pageUrl = 'system_dock_tab.php';
	  historyState.pageAttributes = 'a=list&offset=' + escape(offset) + '&size=' + escape(size) + '&ordinal=' + escape(ordinal) + '&direction=' + escape(direction);
	  historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_DockTabAdministration+' | '+butr_i18n_ListDockTabs;
	  
	  content = '?page=' + historyState.pageUrl + '&' + historyState.pageAttributes;

	  //remove trailing ampersand
	  if (content.charAt(content.length - 1) === '&') {
		  content = content.substring(0, content.length - 1);
	  }
	  
	  History.pushState(historyState, historyState.pageTitle, content);
	  
	  document.title = historyState.pageTitle;
	  $('#title').html(butr_i18n_DockTabAdministration  + ' - ' + butr_i18n_ListDockTabs);
	  
	  document.butr_state_form.content.value = content;
	}

/**
 * This checks the dock tab form to ensure that the form has sensible information.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function processSystemDockTabAddForm() {
  'use strict';
  
  var errorMessage = '';
  var dockItemUuid = document.system_dock_tab_add_form.dock_item_uuid.value;
  var dockSubitemUuid = document.system_dock_tab_add_form.dock_subitem_uuid.value;
  var systemDockTypeUuid = document.system_dock_tab_add_form.system_dock_type_uuid.value;
  var securityClientTypeUuid = document.system_dock_tab_add_form.security_client_type_uuid.value;
  var tabName = document.system_dock_tab_add_form.tab_name.value;
  var displayName = document.system_dock_tab_add_form.display_name.value;
  var description = document.system_dock_tab_add_form.description.value;
  var weighting = document.system_dock_tab_add_form.weighting.value;
  var picturePath = document.system_dock_tab_add_form.picture_path.value;
  var tabAction = document.system_dock_tab_add_form.tab_action.value;
  var isActive = 0;
  if (document.system_dock_tab_add_form.is_active.checked === true) {
	isActive = 1;  
  }
  
  $('#error').modal('hide');
  $('#warning').modal('hide');
  $('#notice').modal('hide');
  $('#debug').modal('hide');
  
  document.system_dock_tab_add_form.submit.disabled = true;
  
  if ((dockItemUuid === undefined || dockItemUuid === null || dockItemUuid === '')
    && (dockSubitemUuid === undefined || dockSubitemUuid === null || dockSubitemUuid === '')) {
    errorMessage += '<br>* '+butr_i18n_DockItem+' '+butr_i18n_Or+' '+butr_i18n_DockSubitem;
  }
  if (systemDockTypeUuid === undefined || systemDockTypeUuid === null || systemDockTypeUuid === '') {
	errorMessage += '<br>* '+butr_i18n_SystemDockType;
  }
  if (securityClientTypeUuid === undefined || securityClientTypeUuid === null || securityClientTypeUuid === '') {
	errorMessage += '<br>* '+butr_i18n_SecurityClientType;
  }
  if (tabName === undefined || tabName === null || tabName === '') {
	  errorMessage += '<br>* '+butr_i18n_TabName;
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
  if (tabAction === undefined || tabAction === null || tabAction === '') {
	tabAction = '';
  }
  
  if (errorMessage !== '') {
    $('#notice_message').html(butr_i18n_PleaseCheckThatYouHaveCompleted+':'+errorMessage);
    $('#notice').modal('show');
    document.system_dock_tab_add_form.submit.disabled = false;
    return false;
  }
  
  var form_body = '';
   
  form_body = 'security_client_type_uuid=' + escape(securityClientTypeUuid)
    + '&dock_item_uuid=' + escape(dockItemUuid)
    + '&dock_subitem_uuid=' + escape(dockSubitemUuid)
    + '&system_dock_type_uuid=' + escape(systemDockTypeUuid)
    + '&tab_name=' + escape(tabName)
    + '&display_name=' + escape(displayName)
    + '&description=' + escape(description)
    + '&weighting=' + escape(weighting)
    + '&picture_path='+ escape(picturePath)
    + '&is_active=' + escape(isActive)
    + '&tab_action=' + escape(tabAction)
    + '&command=add_dock_tab'
    + '&window_name=' + escape(window.name);
  
  $.ajax({
    url: 'ajax/system_dock_tab.php',
    data: form_body,
    type: 'POST',
    contentType: 'application/x-www-form-urlencoded',
    success: function(data, textStatus, jqXHR) {
      'use strict';
      
      try {
        processSystemDockTabAddResponse(JSON.parse(jqXHR.responseText));
      } catch (e) {
        handleSystemDockTabAddError(jqXHR.responseText);
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      'use strict';
      
      handleSystemDockTabAddError(jqXHR.responseText);
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
function processSystemDockTabAddResponse(res) {
  'use strict';
  
  var responseStatus = '';
  var explanation = '';
  var dockTabUuid = '';

  if (res === undefined || res === null || typeof(res) !== 'object') {
    return handleSystemDockItemAddError(res);
  }
  
  if (res.result !== undefined) {
    if (res.result.status !== undefined && res.result.status !== null && res.result.status !== '') {
      responseStatus = res.result.status ;
    }
  }
  
  if (res.add_dock_tab !== undefined) {
    if (res.add_dock_tab.uuid !== undefined && res.add_dock_tab.uuid !== null && res.add_dock_tab.uuid !== '') {
      dockTabUuid = res.add_dock_tab.uuid;
    }
  }
  
  if (responseStatus === 'OK' && dockTabUuid !== '') {
	document.butr_state_form.content.value = 'system_dock_tab.php?a=fetch&uuid=' + escape(dockTabUuid) + '&success=ok_add';
	document.butr_state_form.submit();   
    return;
  }

  return handleSystemDockTabAddError(res);
}

/**
 * This checks the dock tab form to ensure that the form has sensible information.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function processSystemDockTabModifyForm() {
  'use strict';
  
  var errorMessage = '';
  var uuid = document.system_dock_tab_modify_form.uuid.value;
  var dockItemUuid = document.system_dock_tab_modify_form.dock_item_uuid.value;
  var dockSubitemUuid = document.system_dock_tab_modify_form.dock_subitem_uuid.value;
  var systemDockTypeUuid = document.system_dock_tab_modify_form.system_dock_type_uuid.value;
  var securityClientTypeUuid = document.system_dock_tab_modify_form.security_client_type_uuid.value;
  var tabName = document.system_dock_tab_modify_form.tab_name.value;
  var displayName = document.system_dock_tab_modify_form.display_name.value;
  var description = document.system_dock_tab_modify_form.description.value;
  var weighting = document.system_dock_tab_modify_form.weighting.value;
  var picturePath = document.system_dock_tab_modify_form.picture_path.value;
  var tabAction = document.system_dock_tab_modify_form.item_action.value;
  var isActive = 0;
  if (document.system_dock_tab_modify_form.is_active.checked === true) {
	isActive = 1;  
  }
  
  $('#error').modal('hide');
  $('#warning').modal('hide');
  $('#notice').modal('hide');
  $('#debug').modal('hide');
  
  document.system_dock_tab_modify_form.submit.disabled = true;
  
  if (uuid === undefined || uuid === null || uuid === '') {
	errorMessage += '<br>* '+butr_i18n_Uuid;
  }
  if ((dockItemUuid === undefined || dockItemUuid === null || dockItemUuid === '')
    && (dockSubitemUuid === undefined || dockSubitemUuid === null || dockSubitemUuid === '')) {
    errorMessage += '<br>* '+butr_i18n_DockItem+' '+butr_i18n_Or+' '+butr_i18n_DockSubitem;
  }
  if (systemDockTypeUuid === undefined || systemDockTypeUuid === null || systemDockTypeUuid === '') {
	errorMessage += '<br>* '+butr_i18n_SystemDockType;
  }
  if (securityClientTypeUuid === undefined || securityClientTypeUuid === null || securityClientTypeUuid === '') {
	errorMessage += '<br>* '+butr_i18n_SecurityClientType;
  }
  if (tabName === undefined || tabName === null || tabName === '') {
	  errorMessage += '<br>* '+butr_i18n_TabName;
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
  if (tabAction === undefined || tabAction === null || tabAction === '') {
	tabAction = '';
  }
  
  if (errorMessage !== '') {
    $('#notice_message').html(butr_i18n_PleaseCheckThatYouHaveCompleted+':'+errorMessage);
    $('#notice').modal('show');
    document.system_dock_tab_modify_form.submit.disabled = false;
    return false;
  }
  
  var form_body = '';
   
  form_body = 'uuid=' + escape(uuid)
    + '&security_client_type_uuid=' + escape(securityClientTypeUuid)
    + '&dock_item_uuid=' + escape(dockItemUuid)
    + '&dock_subitem_uuid=' + escape(dockSubitemUuid)
    + '&system_dock_type_uuid=' + escape(systemDockTypeUuid)
    + '&tab_name=' + escape(tabName)
    + '&display_name=' + escape(displayName)
    + '&description=' + escape(description)
    + '&weighting=' + escape(weighting)
    + '&picture_path='+ escape(picturePath)
    + '&is_active=' + escape(isActive)
    + '&tab_action=' + escape(tabAction)
    + '&command=modify_dock_tab'
    + '&window_name=' + escape(window.name);
  
  $.ajax({
    url: 'ajax/system_dock_tab.php',
    data: form_body,
    type: 'POST',
    contentType: 'application/x-www-form-urlencoded',
    success: function(data, textStatus, jqXHR) {
      'use strict';
      
      try {
        processSystemDockTabModifyResponse(JSON.parse(jqXHR.responseText));
      } catch (e) {
        handleSystemDockTabModifyError(jqXHR.responseText);
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      'use strict';
      
      handleSystemDockTabModifyError(jqXHR.responseText);
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
function processSystemDockTabModifyResponse(res) {
  'use strict';
  
  var responseStatus = '';
  var explanation = '';
  var dockTabUuid = '';

  if (res === undefined || res === null || typeof(res) !== 'object') {
    return handleSystemDockTabModifyError(res);
  }
  
  if (res.result !== undefined) {
    if (res.result.status !== undefined && res.result.status !== null && res.result.status !== '') {
      responseStatus = res.result.status;
    }
  }
  
  if (res.modify_dock_tab !== undefined) {
    if (res.modify_dock_tab.uuid !== undefined && res.modify_dock_tab.uuid !== null && res.modify_dock_tab.uuid !== '') {
      dockTabUuid = res.modify_dock_tab.uuid;
    }
  }
  
  if (responseStatus === 'OK' && dockTabUuid !== '') {
    // refresh view to be the view dock and get it to pop a message to say dock
    // was modified.
    
    alert('Dock Tab wth UUID = ' + dockTabUuid + ' was modified.');
    
    document.system_dock_tab_modify_form.submit.disabled = false;
    
    return;
  }

  return handleSystemDockTabModifyError(res);
}

/**
 * This handles any errors and displays them in an error div.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param res
 *   - object or string containing the response from the server.
 */
function handleSystemDockTabAddError(res) {
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
        responseStatus = res.result.status;
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
    explanation = butr_i18n_CouldNotAddDockTab+'.';
  }

  if (responseStatus !== 'OK') {
    $('#error_message').html(explanation);
    $('#error').modal('show');
  }
  
  document.system_dock_tab_add_form.submit.disabled = false;
}

/**
 * This handles any errors and displays them in an error div.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param res
 *   - object or string containing the response from the server.
 */
function handleSystemDockTabModifyError(res) {
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
        responseStatus = res.result.status;
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
    explanation = butr_i18n_CouldNotModifyDockTab+'.';
  }

  if (responseStatus !== 'OK') {
    $('#error_message').html(explanation);
    $('#error').modal('show');
  }
  
  document.system_dock_tab_modify_form.submit.disabled = false;
}