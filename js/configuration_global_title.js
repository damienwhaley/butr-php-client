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
 * global title configuration administration add global title configuration page.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function setHistoryConfigurationGlobalTitleAdd() {
  'use strict';
  
  var historyState = {};
  var content = '';
  historyState.pageUrl = 'configuration_global_title.php';
  historyState.pageAttributes = 'a=add';
  historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_GlobalTitleConfigurationAdministration+' | '+butr_i18n_AddGlobalTitleConfiguration;
  
  content = '?page=' + historyState.pageUrl + '&' + historyState.pageAttributes;

  // Remove trailing ampersand
  if (content.charAt(content.length - 1) === '&') {
	  content = content.substring(0, content.length - 1);
  }
  
  document.title = historyState.pageTitle;
  $('#title').html(butr_i18n_GlobalTitleConfigurationAdministration+' - '+butr_i18n_AddGlobalTitleConfiguration);
  document.butr_state_form.content.value = content;
  History.pushState(historyState, historyState.pageTitle, content);
}

/**
 * This set the history to allow back/forwards buttons. This is for the
 * global title configuration administration fetch global title configuration page.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param uuid
 *   - string containing the uuid of the global title configuration record.
 */
function setHistoryConfigurationGlobalTitleFetch(uuid) {
  'use strict';
  
  var historyState = {};
  var content = '';
  historyState.pageUrl = 'configuration_global_title.php';
  historyState.pageAttributes = 'a=fetch&uuid=' + uuid;
  historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_GlobalTitleConfigurationAdministration+' | '+butr_i18n_ModifyGlobalTitleConfiguration;
  
  content = '?page=' + historyState.pageUrl + '&' + historyState.pageAttributes;

  // Remove trailing ampersand
  if (content.charAt(content.length - 1) === '&') {
	  content = content.substring(0, content.length - 1);
  }
  
  document.title = historyState.pageTitle;
  $('#title').html(butr_i18n_GlobalTitleConfigurationAdministration+' - '+butr_i18n_ModifyGlobalTitleConfiguration);
  document.butr_state_form.content.value = content;
  History.pushState(historyState, historyState.pageTitle, content);
}

/**
 * This set the history to allow back/forwards buttons. This is for the
 * global title configuration administration list global title configurations page.
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
function setHistoryConfigurationGlobalTitleList(offset, size, ordinal, direction) {
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
	  historyState.pageUrl = 'configuration_global_title.php';
	  historyState.pageAttributes = 'a=list&offset=' + escape(offset) + '&size=' + escape(size) + '&ordinal=' + escape(ordinal) + '&direction=' + escape(direction);
	  historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_GlobalTitleConfigurationAdministration+' | '+butr_i18n_ListGlobalTitleConfigurations;
	  
	  content = '?page=' + historyState.pageUrl + '&' + historyState.pageAttributes;

	  // Remove trailing ampersand
	  if (content.charAt(content.length - 1) === '&') {
		  content = content.substring(0, content.length - 1);
	  }
	  
	  document.title = historyState.pageTitle;
	  $('#title').html(butr_i18n_GlobalTitleConfigurationAdministration + ' - ' + butr_i18n_ListGlobalTitleConfigurations);
	  document.butr_state_form.content.value = content;
	  History.pushState(historyState, historyState.pageTitle, content);
	}

/**
 * This checks the form to ensure that the form has sensible information.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function processConfigurationGlobalTitleAddForm() {
  'use strict';
  
  var errorMessage = '';
  var nameLabel = document.configuration_global_title_add_form.name_label.value;
  var displayLabel = document.configuration_global_title_add_form.display_label.value;
  var description = document.configuration_global_title_add_form.description.value;
  var weighting = document.configuration_global_title_add_form.weighting.value;
  var isActive = 0;
  if (document.configuration_global_title_add_form.is_active.checked === true) {
	isActive = 1;  
  }
  
  $('#error').hide();
  $('#warning').hide();
  $('#notice').hide();
  document.configuration_global_title_add_form.submit.disabled = true;
  
  if (nameLabel === undefined || nameLabel === null || nameLabel === '') {
    errorMessage += '<br>* '+butr_i18n_NameLabel;
  }
  if (displayLabel === undefined || displayLabel === null || displayLabel === '') {
    displayLabel = '';
  }
  if (description === undefined || description === null || description === '') {
    description = '';
  }
  if (weighting === undefined || weighting === null || isNaN(weighting)) {
	weighting = '';
  }
  
  if (errorMessage !== '') {
    $('#notice_message').html(butr_i18n_PleaseCheckThatYouHaveCompleted+':'+errorMessage);
    $('#notice').show();
    document.configuration_global_title_add_form.submit.disabled = false;
    return false;
  }
  
  var form_body = '';
   
  form_body = 'name_label=' + escape(nameLabel)
    + '&display_label=' + escape(displayLabel)
    + '&description=' + escape(description)
    + '&weighting=' + escape(weighting)
    + '&is_active=' + escape(isActive)
    + '&command=add_global_title_configuration'
    + '&window_name=' + escape(window.name);
    
  $.ajax({
    url: 'ajax/configuration_global_title.php',
    data: form_body,
    type: 'POST',
    contentType: 'application/x-www-form-urlencoded',
    success: function(data, textStatus, jqXHR) {
      'use strict';
      
      try {
        processConfigurationGlobalTitleAddResponse(JSON.parse(jqXHR.responseText));
      } catch (e) {
        handleConfigurationGlobalTitleAddError(jqXHR.responseText);
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      'use strict';
      
      handleConfigurationGlobalTitleAddError(jqXHR.responseText);
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
function processConfigurationGlobalTitleAddResponse(res) {
  'use strict';
  
  var responseStatus = '';
  var explanation = '';
  var globalTitleUuid = '';

  if (res === undefined || res === null || typeof(res) !== 'object') {
    return handleConfigurationGlobalTitleAddError(res);
  }
  
  if (res.result !== undefined) {
    if (res.result.status !== undefined
      && res.result.status !== null
      && res.result.status !== '') {
      responseStatus = res.result.status ;
    }
  }
  
  if (res.add_global_title_configuration !== undefined) {
    if (res.add_global_title_configuration.uuid !== undefined
      && res.add_global_title_configuration.uuid !== null
      && res.add_global_title_configuration.uuid !== '') {
      globalTitleUuid = res.add_global_title_configuration.uuid;
    }
  }
  
  if (responseStatus === 'OK' && globalTitleUuid !== '') {
	return setHistoryConfigurationGlobalTitleFetch(globalTitleUuid);
  }

  return handleConfigurationGlobalTitleAddError(res);
}

/**
 * This checks the form to ensure that the form has sensible information.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function processConfigurationGlobalTitleModifyForm() {
  'use strict';
  
  var errorMessage = '';
  var uuid = document.configuration_global_title_modify_form.uuid.value;
  var nameLabel = document.configuration_global_title_modify_form.name_label.value;
  var displayLabel = document.configuration_global_title_modify_form.display_label.value;
  var description = document.configuration_global_title_modify_form.description.value;
  var weighting = document.configuration_global_title_modify_form.weighting.value;
  var isActive = 0;
  if (document.configuration_global_title_modify_form.is_active.checked === true) {
	isActive = 1;  
  }
  
  $('#error').hide();
  $('#warning').hide();
  $('#notice').hide();
  document.configuration_global_title_modify_form.submit.disabled = true;
  
  if (nameLabel === undefined || nameLabel === null || nameLabel === '') {
    errorMessage += '<br>* '+butr_i18n_NameLabel;
  }
  if (displayLabel === undefined || displayLabel === null || displayLabel === '') {
    displayLabel = '';
  }
  if (description === undefined || description === null || description === '') {
    description = '';
  }
  if (weighting === undefined || weighting === null || isNaN(weighting)) {
	weighting = '';
  }
  
  if (errorMessage !== '') {
    $('#notice_message').html(butr_i18n_PleaseCheckThatYouHaveCompleted+':'+errorMessage);
    $('#notice').show();
    document.configuration_global_title_modify_form.submit.disabled = false;
    return false;
  }
  
  var form_body = '';
  
  form_body = 'uuid=' + escape(uuid)
	+ '&name_label=' + escape(nameLabel)
    + '&display_label=' + escape(displayLabel)
    + '&description=' + escape(description)
    + '&weighting=' + escape(weighting)
    + '&is_active=' + escape(isActive)
    + '&command=modify_global_title_configuration'
    + '&window_name=' + escape(window.name);
    
  $.ajax({
    url: 'ajax/configuration_global_title.php',
    data: form_body,
    type: 'POST',
    contentType: 'application/x-www-form-urlencoded',
    success: function(data, textStatus, jqXHR) {
      'use strict';
      
      try {
        processConfigurationGlobalTitleModifyResponse(JSON.parse(jqXHR.responseText));
      } catch (e) {
        handleConfigurationGlobalTitleModifyError(jqXHR.responseText);
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      'use strict';
      
      handleConfigurationGlobalTitleModifyError(jqXHR.responseText);
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
function processConfigurationGlobalTitleModifyResponse(res) {
  'use strict';
  
  var responseStatus = '';
  var explanation = '';
  var globalTitleUuid = '';

  if (res === undefined || res === null || typeof(res) !== 'object') {
    return handleConfigurationGlobalTitleModifyError(res);
  }
  
  if (res.result !== undefined) {
    if (res.result.status !== undefined
      && res.result.status !== null
      && res.result.status !== '') {
      responseStatus = res.result.status ;
    }
  }
  
  if (res.modify_global_title_configuration !== undefined) {
    if (res.modify_global_title_configuration.uuid !== undefined
      && res.modify_global_title_configuration.uuid !== null
      && res.modify_global_title_configuration.uuid !== '') {
      globalTitleUuid = res.modify_global_title_configuration.uuid;
    }
  }
  
  if (responseStatus === 'OK' && globalTitleUuid !== '') {
    // refresh view to be the view and get it to pop a message to say record
    // was added.
    
    alert('Global Title wth UUID = ' + globalTitleUuid + ' was modified.');
    
    document.configuration_global_title_modify_form.submit.disabled = false;
    
    return;
  }

  return handleConfigrationGlobalTitleModifyError(res);
}

/**
 * This handles any errors and displays them in an error div.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param res
 *   - object or string containing the response from the server.
 */
function handleConfigurationGlobalTitleAddError(res) {
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
    explanation = butr_i18n_CouldNotAddGlobalTitleConfiguration+'.';
  }

  if (responseStatus !== 'OK') {
    $('#error_message').html(explanation);
    $('#error').show();
  }
  
  document.configuration_global_title_add_form.submit.disabled = false;
}

/**
 * This handles any errors and displays them in an error div.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param res
 *   - object or string containing the response from the server.
 */
function handleConfigurationGlobalTitleModifyError(res) {
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
    explanation = butr_i18n_CouldNotModifyGlobalTitleConfiguration+'.';
  }

  if (responseStatus !== 'OK') {
    $('#error_message').html(explanation);
    $('#error').show();
  }
  
  document.configuration_global_title_modify_form.submit.disabled = false;
}