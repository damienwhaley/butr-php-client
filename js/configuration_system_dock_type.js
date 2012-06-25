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
 * system dock type configuration administration add system dock type configuration page.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function setHistoryConfigurationSystemDockTypeAdd() {
  'use strict';
  
  var historyState = {};
  var content = '';
  historyState.pageUrl = 'configuration_system_dock_type.php';
  historyState.pageAttributes = 'a=add';
  historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_SystemDockTypeConfigurationAdministration+' | '+butr_i18n_AddSystemDockTypeConfiguration;
  
  content = '?page=' + historyState.pageUrl + '&' + historyState.pageAttributes;

  // Remove trailing ampersand
  if (content.charAt(content.length - 1) === '&') {
	  content = content.substring(0, content.length - 1);
  }
  
  document.title = historyState.pageTitle;
  $('#title').html(butr_i18n_SystemDockTypeConfigurationAdministration+' - '+butr_i18n_AddSystemDockTypeConfiguration);
  document.butr_state_form.content.value = content;
  History.pushState(historyState, historyState.pageTitle, content);
}

/**
 * This set the history to allow back/forwards buttons. This is for the
 * system dock type configuration administration fetch system dock type configuration page.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param uuid
 *   - string containing the uuid of the system dock type configuration record.
 */
function setHistoryConfigurationSystemDockTypeFetch(uuid) {
  'use strict';
  
  var historyState = {};
  var content = '';
  historyState.pageUrl = 'configuration_system_dock_type.php';
  historyState.pageAttributes = 'a=fetch&uuid=' + uuid;
  historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_SystemDockTypeConfigurationAdministration+' | '+butr_i18n_ModifySystemDockTypeConfiguration;
  
  content = '?page=' + historyState.pageUrl + '&' + historyState.pageAttributes;

  // Remove trailing ampersand
  if (content.charAt(content.length - 1) === '&') {
	  content = content.substring(0, content.length - 1);
  }
  
  document.title = historyState.pageTitle;
  $('#title').html(butr_i18n_SystemDockTypeConfigurationAdministration+' - '+butr_i18n_ModifySystemDockTypeConfiguration);
  document.butr_state_form.content.value = content;
  History.pushState(historyState, historyState.pageTitle, content);
}

/**
 * This set the history to allow back/forwards buttons. This is for the
 * system dock type configuration administration list system dock type configurations page.
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
function setHistoryConfigurationSystemDockTypeList(offset, size, ordinal, direction) {
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
	  historyState.pageUrl = 'configuration_system_dock_type.php';
	  historyState.pageAttributes = 'a=list&offset=' + escape(offset) + '&size=' + escape(size) + '&ordinal=' + escape(ordinal) + '&direction=' + escape(direction);
	  historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_SystemDockTypeConfigurationAdministration+' | '+butr_i18n_ListSystemDockTypeConfigurations;
	  
	  content = '?page=' + historyState.pageUrl + '&' + historyState.pageAttributes;

	  // Remove trailing ampersand
	  if (content.charAt(content.length - 1) === '&') {
		  content = content.substring(0, content.length - 1);
	  }
	  
	  document.title = historyState.pageTitle;
	  $('#title').html(butr_i18n_SystemDockTypeConfigurationAdministration + ' - ' + butr_i18n_ListSystemDockTypeConfigurations);
	  document.butr_state_form.content.value = content;
	  History.pushState(historyState, historyState.pageTitle, content);
	}

/**
 * This checks the form to ensure that the form has sensible information.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function processConfigurationSystemDockTypeAddForm() {
  'use strict';
  
  var errorMessage = '';
  var nameLabel = document.configuration_system_dock_type_add_form.name_label.value;
  var displayLabel = document.configuration_system_dock_type_add_form.display_label.value;
  var description = document.configuration_system_dock_type_add_form.description.value;
  var magic = document.configuration_system_dock_type_add_form.magic.value;
  var weighting = document.configuration_system_dock_type_add_form.weighting.value;
  var isActive = 0;
  if (document.configuration_system_dock_type_add_form.is_active.checked === true) {
	isActive = 1;  
  }
  
  $('#error').hide();
  $('#warning').hide();
  $('#notice').hide();
  document.configuration_system_dock_type_add_form.submit.disabled = true;
  
  if (nameLabel === undefined || nameLabel === null || nameLabel === '') {
    errorMessage += '<br>* '+butr_i18n_NameLabel;
  }
  if (displayLabel === undefined || displayLabel === null || displayLabel === '') {
    displayLabel = '';
  }
  if (description === undefined || description === null || description === '') {
    description = '';
  }
  if (magic === undefined || magic === null || magic === '') {
	  errorMessage += '<br>* '+butr_i18n_Magic;
  }
  if (weighting === undefined || weighting === null || isNaN(weighting)) {
	weighting = '';
  }
  
  if (errorMessage !== '') {
    $('#notice_message').html(butr_i18n_PleaseCheckThatYouHaveCompleted+':'+errorMessage);
    $('#notice').show();
    document.configuration_system_dock_type_add_form.submit.disabled = false;
    return false;
  }
  
  var form_body = '';
   
  form_body = 'name_label=' + escape(nameLabel)
    + '&display_label=' + escape(displayLabel)
    + '&description=' + escape(description)
    + '&weighting=' + escape(weighting)
    + '&magic=' + escape(magic)
    + '&is_active=' + escape(isActive)
    + '&command=add_system_dock_type_configuration'
    + '&window_name=' + escape(window.name);
    
  $.ajax({
    url: 'ajax/configuration_system_dock_type.php',
    data: form_body,
    type: 'POST',
    contentType: 'application/x-www-form-urlencoded',
    success: function(data, textStatus, jqXHR) {
      'use strict';
      
      try {
        processConfigurationSystemDockTypeAddResponse(JSON.parse(jqXHR.responseText));
      } catch (e) {
        handleConfigurationSystemDockTypeAddError(jqXHR.responseText);
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      'use strict';
      
      handleConfigurationSystemDockTypeAddError(jqXHR.responseText);
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
function processConfigurationSystemDockTypeAddResponse(res) {
  'use strict';
  
  var responseStatus = '';
  var explanation = '';
  var systemDockTypeUuid = '';

  if (res === undefined || res === null || typeof(res) !== 'object') {
    return handleConfigurationSystemDockTypeAddError(res);
  }
  
  if (res.result !== undefined) {
    if (res.result.status !== undefined
      && res.result.status !== null
      && res.result.status !== '') {
      responseStatus = res.result.status ;
    }
  }
  
  if (res.add_system_dock_type_configuration !== undefined) {
    if (res.add_system_dock_type_configuration.uuid !== undefined
      && res.add_system_dock_type_configuration.uuid !== null
      && res.add_system_dock_type_configuration.uuid !== '') {
    	systemDockTypeUuid = res.add_system_dock_type_configuration.uuid;
    }
  }
  
  if (responseStatus === 'OK' && systemDockTypeUuid !== '') {
	return setHistoryConfigurationSystemDockTypeFetch(systemDockTypeUuid);
  }

  return handleConfigurationSystemDockTypeAddError(res);
}

/**
 * This checks the form to ensure that the form has sensible information.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function processConfigurationSystemDockTypeModifyForm() {
  'use strict';
  
  var errorMessage = '';
  var uuid = document.configuration_system_dock_type_modify_form.uuid.value;
  var nameLabel = document.configuration_system_dock_type_modify_form.name_label.value;
  var displayLabel = document.configuration_system_dock_type_modify_form.display_label.value;
  var description = document.configuration_system_dock_type_modify_form.description.value;
  var magic = document.configuration_system_dock_type_modify_form.magic.value;
  var weighting = document.configuration_system_dock_type_modify_form.weighting.value;
  var isActive = 0;
  if (document.configuration_system_dock_type_modify_form.is_active.checked === true) {
	isActive = 1;  
  }
  
  $('#error').hide();
  $('#warning').hide();
  $('#notice').hide();
  document.configuration_system_dock_type_modify_form.submit.disabled = true;
  
  if (nameLabel === undefined || nameLabel === null || nameLabel === '') {
    errorMessage += '<br>* '+butr_i18n_NameLabel;
  }
  if (displayLabel === undefined || displayLabel === null || displayLabel === '') {
    displayLabel = '';
  }
  if (description === undefined || description === null || description === '') {
    description = '';
  }
  if (magic === undefined || magic === null || magic === '') {
    errorMessage += '<br>* '+butr_i18n_Magic;
  }
  if (weighting === undefined || weighting === null || isNaN(weighting)) {
	weighting = '';
  }
  
  if (errorMessage !== '') {
    $('#notice_message').html(butr_i18n_PleaseCheckThatYouHaveCompleted+':'+errorMessage);
    $('#notice').show();
    document.configuration_system_dock_type_modify_form.submit.disabled = false;
    return false;
  }
  
  var form_body = '';
  
  form_body = 'uuid=' + escape(uuid)
	+ '&name_label=' + escape(nameLabel)
    + '&display_label=' + escape(displayLabel)
    + '&description=' + escape(description)
    + '&weighting=' + escape(weighting)
    + '&magic=' + escape(magic)
    + '&is_active=' + escape(isActive)
    + '&command=modify_system_dock_type_configuration'
    + '&window_name=' + escape(window.name);
    
  $.ajax({
    url: 'ajax/configuration_system_dock_type.php',
    data: form_body,
    type: 'POST',
    contentType: 'application/x-www-form-urlencoded',
    success: function(data, textStatus, jqXHR) {
      'use strict';
      
      try {
        processConfigurationSystemDockTypeModifyResponse(JSON.parse(jqXHR.responseText));
      } catch (e) {
        handleConfigurationSystemDockTypeModifyError(jqXHR.responseText);
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      'use strict';
      
      handleConfigurationSystemDockTypeModifyError(jqXHR.responseText);
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
function processConfigurationSystemDockTypeModifyResponse(res) {
  'use strict';
  
  var responseStatus = '';
  var explanation = '';
  var systemDockTypeUuid = '';

  if (res === undefined || res === null || typeof(res) !== 'object') {
    return handleConfigurationSystemDockTypeModifyError(res);
  }
  
  if (res.result !== undefined) {
    if (res.result.status !== undefined
      && res.result.status !== null
      && res.result.status !== '') {
      responseStatus = res.result.status ;
    }
  }
  
  if (res.modify_system_dock_type_configuration !== undefined) {
    if (res.modify_system_dock_type_configuration.uuid !== undefined
      && res.modify_system_dock_type_configuration.uuid !== null
      && res.modify_system_dock_type_configuration.uuid !== '') {
    	systemDockTypeUuid = res.modify_system_dock_type_configuration.uuid;
    }
  }
  
  if (responseStatus === 'OK' && systemDockTypeUuid !== '') {
    // refresh view to be the view and get it to pop a message to say record
    // was added.
    
    alert('System Dock Type wth UUID = ' + systemDockTypeUuid + ' was modified.');
    
    document.configuration_system_dock_type_modify_form.submit.disabled = false;
    
    return;
  }

  return handleConfigrationSystemDockTypeModifyError(res);
}

/**
 * This handles any errors and displays them in an error div.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param res
 *   - object or string containing the response from the server.
 */
function handleConfigurationSystemDockTypeAddError(res) {
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
    explanation = butr_i18n_CouldNotAddSystemDockTypeConfiguration+'.';
  }

  if (responseStatus !== 'OK') {
    $('#error_message').html(explanation);
    $('#error').show();
  }
  
  document.configuration_system_dock_type_add_form.submit.disabled = false;
}

/**
 * This handles any errors and displays them in an error div.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param res
 *   - object or string containing the response from the server.
 */
function handleConfigurationSystemDockTypeModifyError(res) {
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
    explanation = butr_i18n_CouldNotModifySystemDockTypeConfiguration+'.';
  }

  if (responseStatus !== 'OK') {
    $('#error_message').html(explanation);
    $('#error').show();
  }
  
  document.configuration_system_dock_type_modify_form.submit.disabled = false;
}