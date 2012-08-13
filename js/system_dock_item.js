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
 * This set the dock item history to allow back/forwards buttons. This is for the
 * dock item administration page.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function setHistorySystemDockItem() {
  'use strict';
  
  var content = '';
  var historyState = {};
  historyState.pageUrl = 'system_dock_item.php';
  historyState.pageAttributes = '';
  historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_DockItemAdministration;
  
  content = '?page=' + historyState.pageUrl + '&' + historyState.pageAttributes;

  //remove trailing ampersand
  if (content.charAt(content.length - 1) === '&') {
	  content = content.substring(0, content.length - 1);
  }
  
  History.pushState(historyState, historyState.pageTitle, content);
  
  document.title = historyState.pageTitle;
  $('#title').html(butr_i18n_DockItemAdministration);
  
  document.butr_state_form.content.value = content;
}

/**
 * This set the dock item history to allow back/forwards buttons. This is for the
 * system dock item administration add dock item page.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function setHistorySystemDockItemAdd() {
  'use strict';
  
  var historyState = {};
  var content = '';
  historyState.pageUrl = 'system_dock_item.php';
  historyState.pageAttributes = 'a=add';
  historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_DockItemAdministration+' | '+butr_i18n_AddDockItem;
  
  content = '?page=' + historyState.pageUrl + '&' + historyState.pageAttributes;

  //remove trailing ampersand
  if (content.charAt(content.length - 1) === '&') {
	  content = content.substring(0, content.length - 1);
  }
  
  History.pushState(historyState, historyState.pageTitle, content);
  
  document.title = historyState.pageTitle;
  $('#title').html(butr_i18n_DockItemAdministration+' - '+butr_i18n_AddDockItem);
  
  document.butr_state_form.content.value = content;
}

/**
 * This set the dock item history to allow back/forwards buttons. This is for the
 * dock item administration add dock item page.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param uuid
 *   - string containing the uuid of the dock item record.
 */
function setHistorySystemDockItemFetch(uuid) {
  'use strict';
  
  var historyState = {};
  var content = '';
  historyState.pageUrl = 'system_dock_item.php';
  historyState.pageAttributes = 'a=fetch&uuid=' + uuid;
  historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_DockItemAdministration+' | '+butr_i18n_ModifyDockItem;
  
  content = '?page=' + historyState.pageUrl + '&' + historyState.pageAttributes;

  //remove trailing ampersand
  if (content.charAt(content.length - 1) === '&') {
	  content = content.substring(0, content.length - 1);
  }
  
  History.pushState(historyState, historyState.pageTitle, content);
  
  document.title = historyState.pageTitle;
  $('#title').html(butr_i18n_DockItemAdministration+' - '+butr_i18n_ModifyDockItem);
  
  document.butr_state_form.content.value = content;
}

/**
 * This set the dock item history to allow back/forwards buttons. This is for the
 * dock item administration list dock item page.
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
function setHistorySystemDockItemList(offset, size, ordinal, direction) {
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
  historyState.pageUrl = 'system_dock_item.php';
  historyState.pageAttributes = 'a=list&offset=' + escape(offset) + '&size=' + escape(size) + '&ordinal=' + escape(ordinal) + '&direction=' + escape(direction);
  historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_DockItemAdministration+' | '+butr_i18n_ListDockItems;
  
  content = '?page=' + historyState.pageUrl + '&' + historyState.pageAttributes;

  //remove trailing ampersand
  if (content.charAt(content.length - 1) === '&') {
	  content = content.substring(0, content.length - 1);
  }
  
  History.pushState(historyState, historyState.pageTitle, content);
  
  document.title = historyState.pageTitle;
  $('#title').html(butr_i18n_DockItemAdministration  + ' - ' + butr_i18n_ListDockItems);
  
  document.butr_state_form.content.value = content;
}

/**
 * This checks the dock item form to ensure that the form has sensible information.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function processSystemDockItemAddForm() {
  'use strict';
  
  var errorMessage = '';
  var dockUuid = document.system_dock_item_add_form.dock_uuid.value;
  var systemDockTypeUuid = document.system_dock_item_add_form.system_dock_type_uuid.value;
  var securityClientTypeUuid = document.system_dock_item_add_form.security_client_type_uuid.value;
  var itemName = document.system_dock_item_add_form.item_name.value;
  var displayName = document.system_dock_item_add_form.display_name.value;
  var description = document.system_dock_item_add_form.description.value;
  var weighting = document.system_dock_item_add_form.weighting.value;
  var picturePath = document.system_dock_item_add_form.picture_path.value;
  var itemAction = document.system_dock_item_add_form.item_action.value;
  var isActive = 0;
  if (document.system_dock_item_add_form.is_active.checked === true) {
	isActive = 1;  
  }
  
  $('#error').modal('hide');
  $('#warning').modal('hide');
  $('#notice').modal('hide');
  $('#debug').modal('hide');
  
  document.system_dock_item_add_form.submit.disabled = true;
  
  if (dockUuid === undefined || dockUuid === null || dockUuid === '') {
    errorMessage += '<br>* '+butr_i18n_Dock;
  }
  if (systemDockTypeUuid === undefined || systemDockTypeUuid === null || systemDockTypeUuid === '') {
	errorMessage += '<br>* '+butr_i18n_SystemDockType;
  }
  if (securityClientTypeUuid === undefined || securityClientTypeUuid === null || securityClientTypeUuid === '') {
	errorMessage += '<br>* '+butr_i18n_SecurityClientType;
  }
  if (itemName === undefined || itemName === null || itemName === '') {
	  errorMessage += '<br>* '+butr_i18n_ItemName;
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
  if (itemAction === undefined || itemAction === null || itemAction === '') {
	itemAction = '';
  }
  
  if (errorMessage !== '') {
    $('#notice_message').html(butr_i18n_PleaseCheckThatYouHaveCompleted+':'+errorMessage);
    $('#notice').modal('show');
    document.system_dock_item_add_form.submit.disabled = false;
    return false;
  }
  
  var form_body = '';
   
  form_body = 'security_client_type_uuid=' + escape(securityClientTypeUuid)
    + '&dock_uuid=' + escape(dockUuid)
    + '&system_dock_type_uuid=' + escape(systemDockTypeUuid)
    + '&item_name=' + escape(itemName)
    + '&display_name=' + escape(displayName)
    + '&description=' + escape(description)
    + '&weighting=' + escape(weighting)
    + '&picture_path='+ escape(picturePath)
    + '&is_active=' + escape(isActive)
    + '&item_action=' + escape(itemAction)
    + '&command=add_dock_item'
    + '&window_name=' + escape(window.name);
    
  $.ajax({
    url: 'ajax/system_dock_item.php',
    data: form_body,
    type: 'POST',
    contentType: 'application/x-www-form-urlencoded',
    success: function(data, textStatus, jqXHR) {
      'use strict';
      
      try {
        processSystemDockItemAddResponse(JSON.parse(jqXHR.responseText));
      } catch (e) {
        handleSystemDockItemAddError(jqXHR.responseText);
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      'use strict';
      
      handleSystemDockItemAddError(jqXHR.responseText);
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
function processSystemDockItemAddResponse(res) {
  'use strict';
  
  var responseStatus = '';
  var explanation = '';
  var dockItemUuid = '';

  if (res === undefined || res === null || typeof(res) !== 'object') {
    return handleSystemDockItemAddError(res);
  }
  
  if (res.result !== undefined) {
    if (res.result.status !== undefined && res.result.status !== null && res.result.status !== '') {
      responseStatus = res.result.status ;
    }
  }
  
  if (res.add_dock_item !== undefined) {
    if (res.add_dock_item.uuid !== undefined && res.add_dock_item.uuid !== null && res.add_dock_item.uuid !== '') {
      dockItemUuid = res.add_dock_item.uuid;
    }
  }
  
  if (responseStatus === 'OK' && dockItemUuid !== '') {
	document.butr_state_form.content.value = 'system_dock_item.php?a=fetch&uuid=' + escape(dockItemUuid) + '&success=ok_add';
	document.butr_state_form.submit();   
    return;
  }

  return handleSystemDockItemAddError(res);
}

/**
 * This checks the dock item form to ensure that the form has sensible information.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function processSystemDockItemModifyForm() {
  'use strict';
  
  var errorMessage = '';
  var uuid = document.system_dock_item_modify_form.uuid.value;
  var dockUuid = document.system_dock_item_modify_form.dock_uuid.value;
  var systemDockTypeUuid = document.system_dock_item_modify_form.system_dock_type_uuid.value;
  var securityClientTypeUuid = document.system_dock_item_modify_form.security_client_type_uuid.value;
  var itemName = document.system_dock_item_modify_form.item_name.value;
  var displayName = document.system_dock_item_modify_form.display_name.value;
  var description = document.system_dock_item_modify_form.description.value;
  var weighting = document.system_dock_item_modify_form.weighting.value;
  var picturePath = document.system_dock_item_modify_form.picture_path.value;
  var itemAction = document.system_dock_item_modify_form.item_action.value;
  var isActive = 0;
  if (document.system_dock_item_modify_form.is_active.checked === true) {
	isActive = 1;  
  }
  
  $('#error').modal('hide');
  $('#warning').modal('hide');
  $('#notice').modal('hide');
  $('#debug').modal('hide');
  
  document.system_dock_item_modify_form.submit.disabled = true;
  
  if (uuid === undefined || uuid === null || uuid === '') {
	errorMessage += '<br>* '+butr_i18n_Uuid;
  }
  if (dockUuid === undefined || dockUuid === null || dockUuid === '') {
    errorMessage += '<br>* '+butr_i18n_Dock;
  }
  if (systemDockTypeUuid === undefined || systemDockTypeUuid === null || systemDockTypeUuid === '') {
	errorMessage += '<br>* '+butr_i18n_SystemDockType;
  }
  if (securityClientTypeUuid === undefined || securityClientTypeUuid === null || securityClientTypeUuid === '') {
	errorMessage += '<br>* '+butr_i18n_SecurityClientType;
  }
  if (itemName === undefined || itemName === null || itemName === '') {
	  errorMessage += '<br>* '+butr_i18n_ItemName;
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
  if (itemAction === undefined || itemAction === null || itemAction === '') {
	itemAction = '';
  }
  
  if (errorMessage !== '') {
    $('#notice_message').html(butr_i18n_PleaseCheckThatYouHaveCompleted+':'+errorMessage);
    $('#notice').modal('show');
    document.system_dock_item_modify_form.submit.disabled = false;
    return false;
  }
  
  var form_body = '';
   
  form_body = 'uuid=' + escape(uuid)
    + '&security_client_type_uuid=' + escape(securityClientTypeUuid)
    + '&dock_uuid=' + escape(dockUuid)
    + '&system_dock_type_uuid=' + escape(systemDockTypeUuid)
    + '&item_name=' + escape(itemName)
    + '&display_name=' + escape(displayName)
    + '&description=' + escape(description)
    + '&weighting=' + escape(weighting)
    + '&picture_path='+ escape(picturePath)
    + '&is_active=' + escape(isActive)
    + '&item_action=' + escape(itemAction)
    + '&command=modify_dock_item'
    + '&window_name=' + escape(window.name);
  
  $.ajax({
    url: 'ajax/system_dock_item.php',
    data: form_body,
    type: 'POST',
    contentType: 'application/x-www-form-urlencoded',
    success: function(data, textStatus, jqXHR) {
      'use strict';
      
      try {
        processSystemDockItemModifyResponse(JSON.parse(jqXHR.responseText));
      } catch (e) {
        handleSystemDockItemModifyError(jqXHR.responseText);
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      'use strict';
      
      handleSystemDockItemModifyError(jqXHR.responseText);
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
function processSystemDockItemModifyResponse(res) {
  'use strict';
  
  var responseStatus = '';
  var explanation = '';
  var dockItemUuid = '';

  if (res === undefined || res === null || typeof(res) !== 'object') {
    return handleSystemDockItemModifyError(res);
  }
  
  if (res.result !== undefined) {
    if (res.result.status !== undefined && res.result.status !== null && res.result.status !== '') {
      responseStatus = res.result.status;
    }
  }
  
  if (res.modify_dock_item !== undefined) {
    if (res.modify_dock_item.uuid !== undefined && res.modify_dock_item.uuid !== null && res.modify_dock_item.uuid !== '') {
      dockItemUuid = res.modify_dock_item.uuid;
    }
  }
  
  if (responseStatus === 'OK' && dockItemUuid !== '') {
    // refresh view to be the view dock and get it to pop a message to say dock
    // was modified.
    
    alert('Dock Item wth UUID = ' + dockItemUuid + ' was modified.');
    
    document.system_dock_item_modify_form.submit.disabled = false;
    
    return;
  }

  return handleSystemDockItemModifyError(res);
}

/**
 * This handles any errors and displays them in an error div.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param res
 *   - object or string containing the response from the server.
 */
function handleSystemDockItemAddError(res) {
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
    explanation = butr_i18n_CouldNotAddDockItem+'.';
  }

  if (responseStatus !== 'OK') {
    $('#error_message').html(explanation);
    $('#error').modal('show');
  }
  
  document.system_dock_item_add_form.submit.disabled = false;
}

/**
 * This handles any errors and displays them in an error div.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param res
 *   - object or string containing the response from the server.
 */
function handleSystemDockItemModifyError(res) {
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
    explanation = butr_i18n_CouldNotModifyDockItem+'.';
  }

  if (responseStatus !== 'OK') {
    $('#error_message').html(explanation);
    $('#error').modal('show');
  }
  
  document.system_dock_item_modify_form.submit.disabled = false;
}