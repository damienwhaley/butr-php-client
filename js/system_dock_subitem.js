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
 * This set the dock subitem history to allow back/forwards buttons. This is for the
 * dock subitem administration page.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function setHistorySystemDockSubitem() {
  'use strict';
  
  var content = '';
  var historyState = {};
  historyState.pageUrl = 'system_dock_subitem.php';
  historyState.pageAttributes = '';
  historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_DockSubitemAdministration;
  
  content = '?page=' + historyState.pageUrl + '&' + historyState.pageAttributes;

  //remove trailing ampersand
  if (content.charAt(content.length - 1) === '&') {
	  content = content.substring(0, content.length - 1);
  }
  
  History.pushState(historyState, historyState.pageTitle, content);
  
  document.title = historyState.pageTitle;
  $('#title').html(butr_i18n_DockSubitemAdministration);
  
  document.butr_state_form.content.value = content;
}

/**
 * This set the dock subitem history to allow back/forwards buttons. This is for the
 * system dock subitem administration add dock item page.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function setHistorySystemDockSubitemAdd() {
  'use strict';
  
  var historyState = {};
  var content = '';
  historyState.pageUrl = 'system_dock_subitem.php';
  historyState.pageAttributes = 'a=add';
  historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_DockSubitemAdministration+' | '+butr_i18n_AddDockSubitem;
  
  content = '?page=' + historyState.pageUrl + '&' + historyState.pageAttributes;

  //remove trailing ampersand
  if (content.charAt(content.length - 1) === '&') {
	  content = content.substring(0, content.length - 1);
  }
  
  History.pushState(historyState, historyState.pageTitle, content);
  
  document.title = historyState.pageTitle;
  $('#title').html(butr_i18n_DockSubitemAdministration+' - '+butr_i18n_AddDockSubitem);
  
  document.butr_state_form.content.value = content;
}

/**
 * This set the dock subitem history to allow back/forwards buttons. This is for the
 * dock subitem administration add dock subitem page.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param uuid
 *   - string containing the uuid of the dock item record.
 */
function setHistorySystemDockSubitemFetch(uuid) {
  'use strict';
  
  var historyState = {};
  var content = '';
  historyState.pageUrl = 'system_dock_subitem.php';
  historyState.pageAttributes = 'a=fetch&uuid=' + uuid;
  historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_DockSubitemAdministration+' | '+butr_i18n_ModifyDockSubitem;
  
  content = '?page=' + historyState.pageUrl + '&' + historyState.pageAttributes;

  //remove trailing ampersand
  if (content.charAt(content.length - 1) === '&') {
	  content = content.substring(0, content.length - 1);
  }
  
  History.pushState(historyState, historyState.pageTitle, content);
  
  document.title = historyState.pageTitle;
  $('#title').html(butr_i18n_DockSubitemAdministration+' - '+butr_i18n_ModifyDockSubitem);
  
  document.butr_state_form.content.value = content;
}

/**
 * This set the dock subitem history to allow back/forwards buttons. This is for the
 * dock subiitem administration list dock subitem page.
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
function setHistorySystemDockSubitemList(offset, size, ordinal, direction) {
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
	  historyState.pageUrl = 'system_dock_subitem.php';
	  historyState.pageAttributes = 'a=list&offset=' + escape(offset) + '&size=' + escape(size) + '&ordinal=' + escape(ordinal) + '&direction=' + escape(direction);
	  historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_DockSubitemAdministration+' | '+butr_i18n_ListDockSubitems;
	  
	  content = '?page=' + historyState.pageUrl + '&' + historyState.pageAttributes;

	  //remove trailing ampersand
	  if (content.charAt(content.length - 1) === '&') {
		  content = content.substring(0, content.length - 1);
	  }
	  
	  History.pushState(historyState, historyState.pageTitle, content);
	  
	  document.title = historyState.pageTitle;
	  $('#title').html(butr_i18n_DockSubitemAdministration  + ' - ' + butr_i18n_ListDockSubitems);
	  
	  document.butr_state_form.content.value = content;
	}

/**
 * This checks the dock subitem form to ensure that the form has sensible information.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function processSystemDockSubitemAddForm() {
  'use strict';
  
  var errorMessage = '';
  var dockItemUuid = document.system_dock_subitem_add_form.dock_item_uuid.value;
  var systemDockTypeUuid = document.system_dock_subitem_add_form.system_dock_type_uuid.value;
  var securityClientTypeUuid = document.system_dock_subitem_add_form.security_client_type_uuid.value;
  var subitemName = document.system_dock_subitem_add_form.subitem_name.value;
  var displayName = document.system_dock_subitem_add_form.display_name.value;
  var description = document.system_dock_subitem_add_form.description.value;
  var weighting = document.system_dock_subitem_add_form.weighting.value;
  var icon = document.system_dock_subitem_add_form.icon.value;
  var subitemAction = document.system_dock_subitem_add_form.subitem_action.value;
  var isActive = 0;
  if (document.system_dock_subitem_add_form.is_active.checked === true) {
	isActive = 1;  
  }
  
  $('#error').hide();
  $('#warning').hide();
  $('#notice').hide();
  document.system_dock_subitem_add_form.submit.disabled = true;
  
  if (dockItemUuid === undefined || dockItemUuid === null || dockItemUuid === '') {
    errorMessage += '<br>* '+butr_i18n_DockItem;
  }
  if (systemDockTypeUuid === undefined || systemDockTypeUuid === null || systemDockTypeUuid === '') {
	errorMessage += '<br>* '+butr_i18n_SystemDockType;
  }
  if (securityClientTypeUuid === undefined || securityClientTypeUuid === null || securityClientTypeUuid === '') {
	errorMessage += '<br>* '+butr_i18n_SecurityClientType;
  }
  if (subitemName === undefined || subitemName === null || subitemName === '') {
	  errorMessage += '<br>* '+butr_i18n_SubitemName;
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
  if (icon === undefined || icon === null || icon === '') {
	icon = '';
  }
  if (subitemAction === undefined || subitemAction === null || subitemAction === '') {
	subitemAction = '';
  }
  
  if (errorMessage !== '') {
    $('#notice_message').html(butr_i18n_PleaseCheckThatYouHaveCompleted+':'+errorMessage);
    $('#notice').show();
    document.system_dock_subitem_add_form.submit.disabled = false;
    return false;
  }
  
  var form_body = '';
   
  form_body = 'security_client_type_uuid=' + escape(securityClientTypeUuid)
    + '&dock_item_uuid=' + escape(dockItemUuid)
    + '&system_dock_type_uuid=' + escape(systemDockTypeUuid)
    + '&subitem_name=' + escape(subitemName)
    + '&display_name=' + escape(displayName)
    + '&description=' + escape(description)
    + '&weighting=' + escape(weighting)
    + '&icon='+ escape(icon)
    + '&is_active=' + escape(isActive)
    + '&subitem_action=' + escape(subitemAction)
    + '&command=add_dock_subitem'
    + '&window_name=' + escape(window.name);
    
  $.ajax({
    url: 'ajax/system_dock_subitem.php',
    data: form_body,
    type: 'POST',
    contentType: 'application/x-www-form-urlencoded',
    success: function(data, textStatus, jqXHR) {
      'use strict';
      
      try {
        processSystemDockSubitemAddResponse(JSON.parse(jqXHR.responseText));
      } catch (e) {
        handleSystemDockSubitemAddError(jqXHR.responseText);
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      'use strict';
      
      handleSystemDockSubitemAddError(jqXHR.responseText);
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
function processSystemDockSubitemAddResponse(res) {
  'use strict';
  
  var responseStatus = '';
  var explanation = '';
  var dockSubitemUuid = '';

  if (res === undefined || res === null || typeof(res) !== 'object') {
    return handleSystemDockItemAddError(res);
  }
  
  if (res.result !== undefined) {
    if (res.result.status !== undefined && res.result.status !== null && res.result.status !== '') {
      responseStatus = res.result.status ;
    }
  }
  
  if (res.add_dock_subitem !== undefined) {
    if (res.add_dock_subitem.uuid !== undefined && res.add_dock_subitem.uuid !== null && res.add_dock_subitem.uuid !== '') {
      dockSubitemUuid = res.add_dock_subitem.uuid;
    }
  }
  
  if (responseStatus === 'OK' && dockSubitemUuid !== '') {
	document.butr_state_form.content.value = 'system_dock_subitem.php?a=fetch&uuid=' + escape(dockSubitemUuid) + '&success=ok_add';
	document.butr_state_form.submit();   
    return;
  }

  return handleSystemDockSubitemAddError(res);
}

/**
 * This checks the dock subitem form to ensure that the form has sensible information.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function processSystemDockSubitemModifyForm() {
  'use strict';
  
  var errorMessage = '';
  var uuid = document.system_dock_subitem_modify_form.uuid.value;
  var dockItemUuid = document.system_dock_subitem_modify_form.dock_item_uuid.value;
  var systemDockTypeUuid = document.system_dock_subitem_modify_form.system_dock_type_uuid.value;
  var securityClientTypeUuid = document.system_dock_subitem_modify_form.security_client_type_uuid.value;
  var subitemName = document.system_dock_subitem_modify_form.subitem_name.value;
  var displayName = document.system_dock_subitem_modify_form.display_name.value;
  var description = document.system_dock_subitem_modify_form.description.value;
  var weighting = document.system_dock_subitem_modify_form.weighting.value;
  var icon = document.system_dock_subitem_modify_form.icon.value;
  var subitemAction = document.system_dock_subitem_modify_form.subitem_action.value;
  var isActive = 0;
  if (document.system_dock_subitem_modify_form.is_active.checked === true) {
	isActive = 1;  
  }
  
  $('#error').hide();
  $('#warning').hide();
  $('#notice').hide();
  document.system_dock_subitem_modify_form.submit.disabled = true;
  
  if (uuid === undefined || uuid === null || uuid === '') {
	errorMessage += '<br>* '+butr_i18n_Uuid;
  }
  if (dockItemUuid === undefined || dockItemUuid === null || dockItemUuid === '') {
    errorMessage += '<br>* '+butr_i18n_DockItem;
  }
  if (systemDockTypeUuid === undefined || systemDockTypeUuid === null || systemDockTypeUuid === '') {
	errorMessage += '<br>* '+butr_i18n_SystemDockType;
  }
  if (securityClientTypeUuid === undefined || securityClientTypeUuid === null || securityClientTypeUuid === '') {
	errorMessage += '<br>* '+butr_i18n_SecurityClientType;
  }
  if (subitemName === undefined || subitemName === null || subitemName === '') {
	  errorMessage += '<br>* '+butr_i18n_SubitemName;
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
  if (icon === undefined || icon === null || icon === '') {
	icon = '';
  }
  if (subitemAction === undefined || subitemAction === null || subitemAction === '') {
	subitemAction = '';
  }
  
  if (errorMessage !== '') {
    $('#notice_message').html(butr_i18n_PleaseCheckThatYouHaveCompleted+':'+errorMessage);
    $('#notice').show();
    document.system_dock_subitem_modify_form.submit.disabled = false;
    return false;
  }
  
  var form_body = '';
   
  form_body = 'uuid=' + escape(uuid)
    + '&security_client_type_uuid=' + escape(securityClientTypeUuid)
    + '&dock_item_uuid=' + escape(dockItemUuid)
    + '&system_dock_type_uuid=' + escape(systemDockTypeUuid)
    + '&subitem_name=' + escape(subitemName)
    + '&display_name=' + escape(displayName)
    + '&description=' + escape(description)
    + '&weighting=' + escape(weighting)
    + '&icon='+ escape(icon)
    + '&is_active=' + escape(isActive)
    + '&subitem_action=' + escape(subitemAction)
    + '&command=modify_dock_subitem'
    + '&window_name=' + escape(window.name);
  
  $.ajax({
    url: 'ajax/system_dock_subitem.php',
    data: form_body,
    type: 'POST',
    contentType: 'application/x-www-form-urlencoded',
    success: function(data, textStatus, jqXHR) {
      'use strict';
      
      try {
        processSystemDockSubitemModifyResponse(JSON.parse(jqXHR.responseText));
      } catch (e) {
        handleSystemDockSubitemModifyError(jqXHR.responseText);
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      'use strict';

      handleSystemDockSubitemModifyError(jqXHR.responseText);
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
function processSystemDockSubitemModifyResponse(res) {
  'use strict';
  
  var responseStatus = '';
  var explanation = '';
  var dockSubitemUuid = '';

  if (res === undefined || res === null || typeof(res) !== 'object') {
    return handleSystemDockSubitemModifyError(res);
  }
  
  if (res.result !== undefined) {
    if (res.result.status !== undefined && res.result.status !== null && res.result.status !== '') {
      responseStatus = res.result.status;
    }
  }
  
  if (res.modify_dock_subitem !== undefined) {
    if (res.modify_dock_subitem.uuid !== undefined && res.modify_dock_subitem.uuid !== null && res.modify_dock_subitem.uuid !== '') {
      dockSubitemUuid = res.modify_dock_subitem.uuid;
    }
  }
  
  if (responseStatus === 'OK' && dockSubitemUuid !== '') {
    // refresh view to be the view dock and get it to pop a message to say dock
    // was modified.
    
    alert('Dock Subitem wth UUID = ' + dockSubitemUuid + ' was modified.');
    
    document.system_dock_subitem_modify_form.submit.disabled = false;
    
    return;
  }

  return handleSystemDockSubitemModifyError(res);
}

/**
 * This handles any errors and displays them in an error div.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param res
 *   - object or string containing the response from the server.
 */
function handleSystemDockSubitemAddError(res) {
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
    explanation = butr_i18n_CouldNotAddDockSubitem+'.';
  }

  if (responseStatus !== 'OK') {
    $('#error_message').html(explanation);
    $('#error').show();
  }
  
  document.system_dock_subitem_add_form.submit.disabled = false;
}

/**
 * This handles any errors and displays them in an error div.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param res
 *   - object or string containing the response from the server.
 */
function handleSystemDockSubitemModifyError(res) {
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
    explanation = butr_i18n_CouldNotModifyDockSubitem+'.';
  }

  if (responseStatus !== 'OK') {
    $('#error_message').html(explanation);
    $('#error').show();
  }
  
  document.system_dock_subitem_modify_form.submit.disabled = false;
}