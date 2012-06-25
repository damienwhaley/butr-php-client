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
 * global language configuration administration add global language configuration page.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function setHistoryConfigurationGlobalLanguageAdd() {
  'use strict';
  
  var historyState = {};
  var content = '';
  historyState.pageUrl = 'configuration_global_language.php';
  historyState.pageAttributes = 'a=add';
  historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_GlobalLanguageConfigurationAdministration+' | '+butr_i18n_AddGlobalLanguageConfiguration;
  
  content = '?page=' + historyState.pageUrl + '&' + historyState.pageAttributes;

  // Remove trailing ampersand
  if (content.charAt(content.length - 1) === '&') {
	  content = content.substring(0, content.length - 1);
  }
  
  document.title = historyState.pageTitle;
  $('#title').html(butr_i18n_GlobalLanguageConfigurationAdministration+' - '+butr_i18n_AddGlobalLanguageConfiguration);
  document.butr_state_form.content.value = content;
  History.pushState(historyState, historyState.pageTitle, content);
}

/**
 * This set the history to allow back/forwards buttons. This is for the
 * global language configuration administration fetch globa language configuration page.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param uuid
 *   - string containing the uuid of the global language configuration record.
 */
function setHistoryConfigurationGlobalLanguageFetch(uuid) {
  'use strict';
  
  var historyState = {};
  var content = '';
  historyState.pageUrl = 'configuration_global_language.php';
  historyState.pageAttributes = 'a=fetch&uuid=' + uuid;
  historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_GlobalLanguageConfigurationAdministration+' | '+butr_i18n_ModifyGlobalLanguageConfiguration;
  
  content = '?page=' + historyState.pageUrl + '&' + historyState.pageAttributes;

  // Remove trailing ampersand
  if (content.charAt(content.length - 1) === '&') {
	  content = content.substring(0, content.length - 1);
  }
  
  document.title = historyState.pageTitle;
  $('#title').html(butr_i18n_GlobalLanguageConfigurationAdministration+' - '+butr_i18n_ModifyGlobalLanguageConfiguration);
  document.butr_state_form.content.value = content;
  History.pushState(historyState, historyState.pageTitle, content);
}

/**
 * This set the history to allow back/forwards buttons. This is for the
 * global language configuration administration list global language configurations page.
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
function setHistoryConfigurationGlobalLanguageList(offset, size, ordinal, direction) {
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
	  historyState.pageUrl = 'configuration_global_language.php';
	  historyState.pageAttributes = 'a=list&offset=' + escape(offset) + '&size=' + escape(size) + '&ordinal=' + escape(ordinal) + '&direction=' + escape(direction);
	  historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_GlobalLanguageConfigurationAdministration+' | '+butr_i18n_ListGlobalLanguageConfigurations;
	  
	  content = '?page=' + historyState.pageUrl + '&' + historyState.pageAttributes;

	  // Remove trailing ampersand
	  if (content.charAt(content.length - 1) === '&') {
		  content = content.substring(0, content.length - 1);
	  }
	  
	  document.title = historyState.pageTitle;
	  $('#title').html(butr_i18n_GlobalLanguageConfigurationAdministration + ' - ' + butr_i18n_ListGlobalLanguageConfigurations);
	  document.butr_state_form.content.value = content;
	  History.pushState(historyState, historyState.pageTitle, content);
	}

/**
 * This checks the form to ensure that the form has sensible information.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function processConfigurationGlobalLanguageAddForm() {
  'use strict';
  
  var errorMessage = '';
  var nameLabel = document.configuration_global_language_add_form.name_label.value;
  var displayLabel = document.configuration_global_language_add_form.display_label.value;
  var description = document.configuration_global_language_add_form.description.value;
  var languageCode = document.configuration_global_language_add_form.language_code.value;
  var languageFamily = document.configuration_global_language_add_form.language_family.value;
  var countryUuid = document.configuration_global_language_add_form.country_uuid.value;
  var weighting = document.configuration_global_language_add_form.weighting.value;
  var isActive = 0;
  if (document.configuration_global_language_add_form.is_active.checked === true) {
	isActive = 1;  
  }
  
  $('#error').hide();
  $('#warning').hide();
  $('#notice').hide();
  document.configuration_global_language_add_form.submit.disabled = true;
  
  if (nameLabel === undefined || nameLabel === null || nameLabel === '') {
    errorMessage += '<br>* '+butr_i18n_NameLabel;
  }
  if (displayLabel === undefined || displayLabel === null || displayLabel === '') {
    displayLabel = '';
  }
  if (description === undefined || description === null || description === '') {
    description = '';
  }
  if (languageCode === undefined || languageCode === null || languageCode === '') {
	errorMessage += '<br>* '+butr_i18n_LanguageCode;
  }
  if (languageFamily === undefined || languageFamily === null || languageFamily === '') {
    languageFamily = '';
  }
  if (countryUuid === undefined || countryUuid === null || countryUuid === '') {
	errorMessage += '<br>* '+butr_i18n_Country;
  }
  if (weighting === undefined || weighting === null || isNaN(weighting)) {
	weighting = '';
  }
  
  if (errorMessage !== '') {
    $('#notice_message').html(butr_i18n_PleaseCheckThatYouHaveCompleted+':'+errorMessage);
    $('#notice').show();
    document.configuration_global_language_add_form.submit.disabled = false;
    return false;
  }
  
  var form_body = '';
   
  form_body = 'name_label=' + escape(nameLabel)
    + '&display_label=' + escape(displayLabel)
    + '&description=' + escape(description)
    + '&language_code=' + escape(languageCode)
    + '&language_family=' + escape(languageFamily)
    + '&country_uuid=' + escape(countryUuid)
    + '&weighting=' + escape(weighting)
    + '&is_active=' + escape(isActive)
    + '&command=add_global_language_configuration'
    + '&window_name=' + escape(window.name);
    
  $.ajax({
    url: 'ajax/configuration_global_language.php',
    data: form_body,
    type: 'POST',
    contentType: 'application/x-www-form-urlencoded',
    success: function(data, textStatus, jqXHR) {
      'use strict';
      
      try {
        processConfigurationGlobalLanguageAddResponse(JSON.parse(jqXHR.responseText));
      } catch (e) {
        handleConfigurationGlobalLanguageAddError(jqXHR.responseText);
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      'use strict';
      
      handleConfigurationGlobalLanguageAddError(jqXHR.responseText);
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
function processConfigurationGlobalLanguageAddResponse(res) {
  'use strict';
  
  var responseStatus = '';
  var explanation = '';
  var globalLanguageUuid = '';

  if (res === undefined || res === null || typeof(res) !== 'object') {
    return handleConfigurationGlobalLanguageAddError(res);
  }
  
  if (res.result !== undefined) {
    if (res.result.status !== undefined && res.result.status !== null && res.result.status !== '') {
      responseStatus = res.result.status ;
    }
  }
  
  if (res.add_global_language_configuration !== undefined) {
    if (res.add_global_language_configuration.uuid !== undefined && res.add_global_language_configuration.uuid !== null && res.add_global_language_configuration.uuid !== '') {
      globalLanguageUuid = res.add_global_language_configuration.uuid;
    }
  }
  
  if (responseStatus === 'OK' && globalLanguageUuid !== '') {
	return setHistoryConfigurationGlobalLanguageFetch(globalLanguageUuid);
	//document.butr_state_form.content.value = 'user_user.php?a=fetch&uuid=' + escape(userUuid) + '&success=ok_add';
	//document.butr_state_form.submit();   
    // return
  }

  return handleConfigurationGlobalLanguageAddError(res);
}

/**
 * This checks the form to ensure that the form has sensible information.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function processConfigurationGlobalLanguageModifyForm() {
  'use strict';
  
  var errorMessage = '';
  var uuid = document.configuration_global_language_modify_form.uuid.value;
  var nameLabel = document.configuration_global_language_modify_form.name_label.value;
  var displayLabel = document.configuration_global_language_modify_form.display_label.value;
  var description = document.configuration_global_language_modify_form.description.value;
  var languageCode = document.configuration_global_language_modify_form.language_code.value;
  var languageFamily = document.configuration_global_language_modify_form.language_family.value;
  var countryUuid = document.configuration_global_language_modify_form.country_uuid.value;
  var weighting = document.configuration_global_language_modify_form.weighting.value;
  var isActive = 0;
  if (document.configuration_global_language_modify_form.is_active.checked === true) {
	isActive = 1;  
  }
  
  $('#error').hide();
  $('#warning').hide();
  $('#notice').hide();
  document.configuration_global_language_modify_form.submit.disabled = true;
  
  if (nameLabel === undefined || nameLabel === null || nameLabel === '') {
    errorMessage += '<br>* '+butr_i18n_NameLabel;
  }
  if (displayLabel === undefined || displayLabel === null || displayLabel === '') {
    displayLabel = '';
  }
  if (description === undefined || description === null || description === '') {
    description = '';
  }
  if (languageCode === undefined || languageCode === null || languageCode === '') {
	errorMessage += '<br>* '+butr_i18n_LanguageCode;
  }
  if (languageFamily === undefined || languageFamily === null || languageFamily === '') {
    languageFamily = '';
  }
  if (countryUuid === undefined || countryUuid === null || countryUuid === '') {
	errorMessage += '<br>* '+butr_i18n_Country;
  }
  if (weighting === undefined || weighting === null || isNaN(weighting)) {
	weighting = '';
  }
  
  if (errorMessage !== '') {
    $('#notice_message').html(butr_i18n_PleaseCheckThatYouHaveCompleted+':'+errorMessage);
    $('#notice').show();
    document.configuration_global_language_modify_form.submit.disabled = false;
    return false;
  }
  
  var form_body = '';
  
  form_body = 'uuid=' + escape(uuid)
	+ '&name_label=' + escape(nameLabel)
    + '&display_label=' + escape(displayLabel)
    + '&description=' + escape(description)
    + '&language_code=' + escape(languageCode)
    + '&language_family=' + escape(languageFamily)
    + '&country_uuid=' + escape(countryUuid)
    + '&weighting=' + escape(weighting)
    + '&is_active=' + escape(isActive)
    + '&command=modify_global_language_configuration'
    + '&window_name=' + escape(window.name);
    
  $.ajax({
    url: 'ajax/configuration_global_language.php',
    data: form_body,
    type: 'POST',
    contentType: 'application/x-www-form-urlencoded',
    success: function(data, textStatus, jqXHR) {
      'use strict';
      
      try {
        processConfigurationGlobalLanguageModifyResponse(JSON.parse(jqXHR.responseText));
      } catch (e) {
        handleConfigurationGlobalLanguageModifyError(jqXHR.responseText);
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      'use strict';
      
      handleConfigurationGlobalLanguageModifyError(jqXHR.responseText);
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
function processConfigurationGlobalLanguageModifyResponse(res) {
  'use strict';
  
  var responseStatus = '';
  var explanation = '';
  var globalLanguageUuid = '';

  if (res === undefined || res === null || typeof(res) !== 'object') {
    return handleConfigurationGlobalLanguageModifyError(res);
  }
  
  if (res.result !== undefined) {
    if (res.result.status !== undefined && res.result.status !== null && res.result.status !== '') {
      responseStatus = res.result.status ;
    }
  }
  
  if (res.modify_global_language_configuration !== undefined) {
    if (res.modify_global_language_configuration.uuid !== undefined && res.modify_global_language_configuration.uuid !== null && res.modify_global_language_configuration.uuid !== '') {
    	globalLanguageUuid = res.modify_global_language_configuration.uuid;
    }
  }
  
  if (responseStatus === 'OK' && globalLanguageUuid !== '') {
    // refresh view to be the view and get it to pop a message to say user
    // was added.
    
    alert('Global Language wth UUID = ' + globalLanguageUuid + ' was modified.');
    
    document.configuration_global_language_modify_form.submit.disabled = false;
    
    return;
  }

  return handleConfigrationGlobalLanguageModifyError(res);
}

/**
 * This handles any errors and displays them in an error div.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param res
 *   - object or string containing the response from the server.
 */
function handleConfigurationGlobalLanguageAddError(res) {
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
    explanation = butr_i18n_CouldNotAddGlobalLanguageConfiguration+'.';
  }

  if (responseStatus !== 'OK') {
    $('#error_message').html(explanation);
    $('#error').show();
  }
  
  document.configuration_global_language_add_form.submit.disabled = false;
}

/**
 * This handles any errors and displays them in an error div.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param res
 *   - object or string containing the response from the server.
 */
function handleConfigurationGlobalLanguageModifyError(res) {
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
    explanation = butr_i18n_CouldNotModifyGlobalLanguageConfiguration+'.';
  }

  if (responseStatus !== 'OK') {
    $('#error_message').html(explanation);
    $('#error').show();
  }
  
  document.configuration_global_language_modify_form.submit.disabled = false;
}