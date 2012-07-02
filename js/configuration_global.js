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
 * This set the country history to allow back/forwards buttons. This is for the
 * configuration global administration add country page.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function setHistoryConfigurationGlobalAdd() {
  'use strict';
  
  var historyState = {};
  var content = '';
  historyState.pageUrl = 'configuration_global.php';
  historyState.pageAttributes = 'a=add';
  historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_GlobalConfigurationAdministration+' | '+butr_i18n_AddGlobalConfiguration;
  
  content = '?page=' + historyState.pageUrl + '&' + historyState.pageAttributes;

  // Remove trailing ampersand
  if (content.charAt(content.length - 1) === '&') {
	content = content.substring(0, content.length - 1);
  }

  document.title = historyState.pageTitle;
  $('#title').html(butr_i18n_GlobalConfigurationAdministration+' - '+butr_i18n_AddGlobalConfiguration);
  document.butr_state_form.content.value = content;
  History.pushState(historyState, historyState.pageTitle, content);
}

/**
 * This set the history to allow back/forwards buttons. This is for the
 * country administration fetch country page.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param uuid
 *   - string containing the uuid of the country record.
 */
function setHistoryConfigurationGlobalFetch(uuid) {
  'use strict';
  
  var historyState = {};
  var content = '';
  historyState.pageUrl = 'configuration_global.php';
  historyState.pageAttributes = 'a=fetch&uuid=' + uuid;
  historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_GlobalConfigurationAdministration+' | '+butr_i18n_ModifyGlobalConfguration;
  
  content = '?page=' + historyState.pageUrl + '&' + historyState.pageAttributes;

  // Remove trailing ampersand
  if (content.charAt(content.length - 1) === '&') {
	content = content.substring(0, content.length - 1);
  }
  
  document.title = historyState.pageTitle;
  $('#title').html(butr_i18n_GlobalConfigurationAdministration+' - '+butr_i18n_ModifyGlobalConfguration);
  document.butr_state_form.content.value = content;
  History.pushState(historyState, historyState.pageTitle, content);
}

/**
 * This set the history to allow back/forwards buttons. This is for the
 * country administration list country page.
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
function setHistoryConfigurationGlobalList(offset, size, ordinal, direction) {
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
	  historyState.pageUrl = 'configuration_global.php';
	  historyState.pageAttributes = 'a=list&offset=' + escape(offset) + '&size=' + escape(size) + '&ordinal=' + escape(ordinal) + '&direction=' + escape(direction);
	  historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_GlobalConfigurationAdministration+' | '+butr_i18n_ListGlobalConfigurations;
	  
	  content = '?page=' + historyState.pageUrl + '&' + historyState.pageAttributes;

	  //remove trailing ampersand
	  if (content.charAt(content.length - 1) === '&') {
		content = content.substring(0, content.length - 1);
	  }
	  
	  document.title = historyState.pageTitle;
	  $('#title').html(butr_i18n_GlobalConfigurationAdministration  + ' - ' + butr_i18n_ListGlobalConfigurations);
	  document.butr_state_form.content.value = content;
	  History.pushState(historyState, historyState.pageTitle, content);
	}

/**
 * This checks the form to ensure that the form has sensible information.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function processConfigurationGlobalAddForm() {
  'use strict';
  
  var errorMessage = '';
  var nameLabel = document.configuration_global_add_form.name_label.value;
  var displayLabel = document.configuration_global_add_form.display_label.value;
  var description = document.configuration_global_add_form.description.value;
  var magic = document.configuration_global_add_form.magic.value;
  var textSetting = document.configuration_global_add_form.text_setting.value;
  var integerSetting = document.configuration_global_add_form.integer_setting.value;
  var floatSetting = document.configuration_global_add_form.float_setting.value;
  var datetimeSetting = document.configuration_global_add_form.datetime_setting.value;
  var uuidSetting = document.configuration_global_add_form.uuid_setting.value;
  var bitSetting = 0;
  if (document.configuration_global_add_form.bit_setting.checked === true) {
	bitSetting = 1;  
  }
  
  $('#error').hide();
  $('#warning').hide();
  $('#notice').hide();
  document.configuration_global_add_form.submit.disabled = true;
  
  if (nameLabel === undefined || nameLabel === null || nameLabel === '') {
    errorMessage += '<br>* '+butr_i18n_NameLabel;
  }
  if (displayLabel === undefined || displayLabel === null || displayLabel === '') {
    displayLabel = '';
  }
  if (magic === undefined || magic === null || magic === '') {
	errorMessage += '<br>* '+butr_i18n_Magic;
  }
  if (description === undefined || description === null || description === '') {
    description = '';
  }
  if (textSetting === undefined || textSetting === null || textSetting === '') {
    textSetting = '';
  }
  if (integerSetting === undefined || integerSetting === null || isNaN(integerSetting)) {
    integerSetting = '';
  }
  if (floatSetting === undefined || floatSetting === null || isNaN(floatSetting)) {
    floatSetting = '';
  }
  
  if (datetimeSetting === undefined || datetimeSetting === null || datetimeSetting === '') {
    datetimeSetting = '';
  }
  else {
	var dt = moment(datetimeSetting);
	if (dt !== undefined && dt !== null && !isNaN(dt.valueOf())) {
	  datetimeSetting = dt.format('YYYY-MM-DD HH:mm:ss');
	}
	else {
	  datetimeSetting = '';
	}
  }
  if (uuidSetting === undefined || uuidSetting === null || uuidSetting === '') {
    uuidSetting = '';
  }  
  
  if (errorMessage !== '') {
    $('#notice_message').html(butr_i18n_PleaseCheckThatYouHaveCompleted+':'+errorMessage);
    $('#notice').show();
    document.configuration_global_add_form.submit.disabled = false;
    return false;
  }
  
  var form_body = '';
   
  form_body = 'name_label=' + escape(nameLabel)
    + '&display_label=' + escape(displayLabel)
    + '&description=' + escape(description)
    + '&magic=' + escape(magic)
    + '&text_setting=' + escape(textSetting)
    + '&integer_setting=' + escape(integerSetting)
    + '&float_setting=' + escape(floatSetting)
    + '&datetime_setting=' + escape(datetimeSetting)
    + '&uuid_setting=' + escape(uuidSetting)
    + '&bit_setting=' + escape(bitSetting)
    + '&command=add_global_configuration'
    + '&window_name=' + escape(window.name);
  
  $.ajax({
    url: 'ajax/configuration_global.php',
    data: form_body,
    type: 'POST',
    contentType: 'application/x-www-form-urlencoded',
    success: function(data, textStatus, jqXHR) {
      'use strict';
      
      try {
        processConfigurationGlobalAddResponse(JSON.parse(jqXHR.responseText));
      } catch (e) {
        handleConfigurationGlobalAddError(jqXHR.responseText);
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      'use strict';
      
      handleConfigurationGlobalAddError(jqXHR.responseText);
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
function processConfigurationGlobalAddResponse(res) {
  'use strict';
  
  var responseStatus = '';
  var explanation = '';
  var globalConfgurationUuid = '';

  if (res === undefined || res === null || typeof(res) !== 'object') {
    return handleConfigurationGlobalAddError(res);
  }
  
  if (res.result !== undefined) {
    if (res.result.status !== undefined && res.result.status !== null && res.result.status !== '') {
      responseStatus = res.result.status ;
    }
  }
  
  if (res.add_global_configuration !== undefined) {
    if (res.add_global_configuration.uuid !== undefined && res.add_global_configuration.uuid !== null && res.add_global_configuration.uuid !== '') {
    	globalConfgurationUuid = res.add_global_configuration.uuid;
    }
  }
  
  if (responseStatus === 'OK' && globalConfgurationUuid !== '') {
	document.butr_state_form.content.value = 'configuration_global.php?a=fetch&uuid=' + escape(globalConfgurationUuid) + '&success=ok_add';
	document.butr_state_form.submit();   
    return;
  }

  return handleConfigurationGlobalAddError(res);
}

/**
 * This checks the form to ensure that the form has sensible information.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function processConfigurationGlobalModifyForm() {
  'use strict';
  
  var errorMessage = '';
  var uuid = document.configuration_global_modify_form.uuid.value;
  var nameLabel = document.configuration_global_modify_form.name_label.value;
  var displayLabel = document.configuration_global_modify_form.display_label.value;
  var description = document.configuration_global_modify_form.description.value;
  var magic = document.configuration_global_modify_form.magic.value;
  var textSetting = document.configuration_global_modify_form.text_setting.value;
  var integerSetting = document.configuration_global_modify_form.integer_setting.value;
  var floatSetting = document.configuration_global_modify_form.float_setting.value;
  var datetimeSetting = document.configuration_global_modify_form.datetime_setting.value;
  var uuidSetting = document.configuration_global_modify_form.uuid_setting.value;
  var bitSetting = 0;
  if (document.configuration_global_modify_form.bit_setting.checked === true) {
	bitSetting = 1;  
  }
  
  $('#error').hide();
  $('#warning').hide();
  $('#notice').hide();
  document.configuration_global_modify_form.submit.disabled = true;
  
  if (nameLabel === undefined || nameLabel === null || nameLabel === '') {
    errorMessage += '<br>* '+butr_i18n_NameLabel;
  }
  if (displayLabel === undefined || displayLabel === null || displayLabel === '') {
    displayLabel = '';
  }
  if (magic === undefined || magic === null || magic === '') {
	errorMessage += '<br>* '+butr_i18n_Magic;
  }
  if (description === undefined || description === null || description === '') {
    description = '';
  }
  if (textSetting === undefined || textSetting === null || textSetting === '') {
    textSetting = '';
  }
  if (integerSetting === undefined || integerSetting === null || isNaN(integerSetting)) {
    integerSetting = '';
  }
  if (floatSetting === undefined || floatSetting === null || isNaN(floatSetting)) {
    floatSetting = '';
  }
  
  if (datetimeSetting === undefined || datetimeSetting === null || datetimeSetting === '') {
    datetimeSetting = '';
  }
  else {
	var dt = moment(datetimeSetting);
	if (dt !== undefined && dt !== null && !isNaN(dt.valueOf())) {
	  datetimeSetting = dt.format('YYYY-MM-DD HH:mm:ss');
	}
	else {
	  datetimeSetting = '';
	}
  }
  if (uuidSetting === undefined || uuidSetting === null || uuidSetting === '') {
    uuidSetting = '';
  }
  
  if (errorMessage !== '') {
    $('#notice_message').html(butr_i18n_PleaseCheckThatYouHaveCompleted+':'+errorMessage);
    $('#notice').show();
    document.configuration_global_modify_form.submit.disabled = false;
    return false;
  }
  
  var form_body = '';
   
  form_body = 'uuid=' + escape(uuid)
    + '&name_label=' + escape(nameLabel)
    + '&display_label=' + escape(displayLabel)
    + '&description=' + escape(description)
    + '&magic=' + escape(magic)
    + '&text_setting=' + escape(textSetting)
    + '&integer_setting=' + escape(integerSetting)
    + '&float_setting=' + escape(floatSetting)
    + '&datetime_setting=' + escape(datetimeSetting)
    + '&uuid_setting=' + escape(uuidSetting)
    + '&bit_setting=' + escape(bitSetting)
    + '&command=modify_global_configuration'
    + '&window_name=' + escape(window.name);
  
  $.ajax({
    url: 'ajax/configuration_global.php',
    data: form_body,
    type: 'POST',
    contentType: 'application/x-www-form-urlencoded',
    success: function(data, textStatus, jqXHR) {
      'use strict';
      
      try {   	  
        processConfigurationGlobalModifyResponse(JSON.parse(jqXHR.responseText));
      } catch (e) {
        handleConfigurationGlobalModifyError(jqXHR.responseText);
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      'use strict';
      
      handleConfigurationGlobalModifyError(jqXHR.responseText);
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
function processConfigurationGlobalModifyResponse(res) {
  'use strict';
  
  var responseStatus = '';
  var explanation = '';
  var globalConfigurationUuid = '';
  
  if (res === undefined || res === null || typeof(res) !== 'object') {
    return handleConfigurationGlobalModifyError(res);
  }
  
  if (res.result !== undefined) {
    if (res.result.status !== undefined && res.result.status !== null && res.result.status !== '') {
      responseStatus = res.result.status ;
    }
  }
  
  if (res.modify_global_configuration !== undefined) {
    if (res.modify_global_configuration.uuid !== undefined && res.modify_global_configuration.uuid !== null && res.modify_global_configuration.uuid !== '') {
      globalConfigurationUuid = res.modify_global_configuration.uuid;
    }
  }
  
  if (responseStatus === 'OK' && globalConfigurationUuid !== '') {
    // refresh view to be the fetch and get it to pop a message to say it
    // was modified.
    
    alert('Global Configuration wth UUID = ' + globalConfigurationUuid + ' was modified.');
    
    document.configuration_global_modify_form.submit.disabled = false;
    
    return;
  }

  return handleConfigurationGlobalModifyError(res);
}

/**
 * This handles any errors and displays them in an error div.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param res
 *   - object or string containing the response from the server.
 */
function handleConfigurationGlobalAddError(res) {
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
    explanation = butr_i18n_CouldNotAddGobalConfiguration+'.';
  }

  if (responseStatus !== 'OK') {
    $('#error_message').html(explanation);
    $('#error').show();
  }
  
  document.configuration_global_add_form.submit.disabled = false;
}

/**
 * This handles any errors and displays them in an error div.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param res
 *   - object or string containing the response from the server.
 */
function handleConfigurationGlobalModifyError(res) {
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
    explanation = butr_i18n_CouldNotModifyGlobalConfiguration+'.';
  }

  if (responseStatus !== 'OK') {
    $('#error_message').html(explanation);
    $('#error').show();
  }
  
  document.configuration_global_modify_form.submit.disabled = false;
}

/**
 * This populates the effective setting divs to the user has feeback about
 * what the effective setting will be. This is for the modify form.
 */
function displayEffectiveSettingModify() {
  var textSetting = document.configuration_global_modify_form.text_setting.value;
  var integerSetting = document.configuration_global_modify_form.integer_setting.value;
  var floatSetting = document.configuration_global_modify_form.float_setting.value;
  var datetimeSetting = document.configuration_global_modify_form.datetime_setting.value;
  var uuidSetting = document.configuration_global_modify_form.uuid_setting.value;
  var bitSetting = 'False';
  if (document.configuration_global_modify_form.bit_setting.checked === true) {
	bitSetting = 'True';  
  }
  var effectiveSetting = '';
  var foundSetting = false;
	
  if (textSetting === undefined || textSetting === null || textSetting === '') {
    textSetting = '';
  }
  if (integerSetting === undefined || integerSetting === null || isNaN(integerSetting)) {
    integerSetting = '';
  }
  if (floatSetting === undefined || floatSetting === null || isNaN(floatSetting)) {
    floatSetting = '';
  }
  
  if (datetimeSetting === undefined || datetimeSetting === null || datetimeSetting === '') {
    datetimeSetting = '';
  }
  else {
	var dt = moment(datetimeSetting);
	if (dt !== undefined && dt !== null && !isNaN(dt.valueOf())) {
	  datetimeSetting = dt.format('D MMM YYYY HH:mm:ss');
	}
	else {
	  datetimeSetting = '';
	}
  }
  if (uuidSetting === undefined || uuidSetting === null || uuidSetting === '') {
    uuidSetting = '';
  }
  
  if (textSetting !== '' && foundSetting === false) {
	effectiveSetting = textSetting;
	foundSetting = true;
  }
  if (integerSetting !== '' && foundSetting === false) {
	effectiveSetting = integerSetting;
	foundSetting = true;
  }
  if (floatSetting !== '' && foundSetting === false) {
	effectiveSetting = floatSetting;
	foundSetting = true;
  }
  if (datetimeSetting !== '' && foundSetting === false) {
	effectiveSetting = datetimeSetting;
	foundSetting = true;
  }
  if (uuidSetting !== '' && foundSetting === false) {
	effectiveSetting = uuidSetting;
	foundSetting = true;
  }
  if (bitSetting !== '' && foundSetting === false) {
	effectiveSetting = bitSetting;
	foundSetting = true;
  }
  if (effectiveSetting === '') {
	effectiveSetting = '&nbsp;';
  }
  
  var effectiveSettingDiv = $('#effective_setting');
  
  if(effectiveSettingDiv !== undefined && effectiveSettingDiv !== null) {
    effectiveSettingDiv.html(effectiveSetting);
  }
}

/**
 * This populates the effective setting divs to the user has feeback about
 * what the effective setting will be. This is for the add form.
 */
function displayEffectiveSettingAdd() {
  var textSetting = document.configuration_global_add_form.text_setting.value;
  var integerSetting = document.configuration_global_add_form.integer_setting.value;
  var floatSetting = document.configuration_global_add_form.float_setting.value;
  var datetimeSetting = document.configuration_global_add_form.datetime_setting.value;
  var uuidSetting = document.configuration_global_add_form.uuid_setting.value;
  var bitSetting = 'False';
  if (document.configuration_global_add_form.bit_setting.checked === true) {
	bitSetting = 'True';  
  }
  var effectiveSetting = '';
  var foundSetting = false;
	
  if (textSetting === undefined || textSetting === null || textSetting === '') {
    textSetting = '';
  }
  if (integerSetting === undefined || integerSetting === null || isNaN(integerSetting)) {
    integerSetting = '';
  }
  if (floatSetting === undefined || floatSetting === null || isNaN(floatSetting)) {
    floatSetting = '';
  }
  
  if (datetimeSetting === undefined || datetimeSetting === null || datetimeSetting === '') {
    datetimeSetting = '';
  }
  else {
	var dt = moment(datetimeSetting);
	if (dt !== undefined && dt !== null && !isNaN(dt.valueOf())) {
	  datetimeSetting = dt.format('D MMM YYYY HH:mm:ss');
	}
	else {
	  datetimeSetting = '';
	}
  }
  if (uuidSetting === undefined || uuidSetting === null || uuidSetting === '') {
    uuidSetting = '';
  }
  
  if (textSetting !== '' && foundSetting === false) {
	effectiveSetting = textSetting;
	foundSetting = true;
  }
  if (integerSetting !== '' && foundSetting === false) {
	effectiveSetting = integerSetting;
	foundSetting = true;
  }
  if (floatSetting !== '' && foundSetting === false) {
	effectiveSetting = floatSetting;
	foundSetting = true;
  }
  if (datetimeSetting !== '' && foundSetting === false) {
	effectiveSetting = datetimeSetting;
	foundSetting = true;
  }
  if (uuidSetting !== '' && foundSetting === false) {
	effectiveSetting = uuidSetting;
	foundSetting = true;
  }
  if (bitSetting !== '' && foundSetting === false) {
	effectiveSetting = bitSetting;
	foundSetting = true;
  }
  if (effectiveSetting === '') {
	effectiveSetting = '&nbsp;';
  }
  
  var effectiveSettingDiv = $('#effective_setting');
  
  if(effectiveSettingDiv !== undefined && effectiveSettingDiv !== null) {
    effectiveSettingDiv.html(effectiveSetting);
  }
}

/**
 * This checks to see if the date is valid and formats it or clears it.
 */
function datetimeCheckAdd() {
  var datetimeSetting = document.configuration_global_add_form.datetime_setting.value;
  
  if (datetimeSetting === undefined || datetimeSetting === null || datetimeSetting === '') {
	    datetimeSetting = '';
  }
  else {
	var dt = moment(datetimeSetting);
	
	if (dt !== undefined && dt !== null && !isNaN(dt.valueOf())) {
	  datetimeSetting = dt.format('D MMM YYYY HH:mm:ss');
	}
	else {
	  datetimeSetting = '';
	}
  }
  document.configuration_global_add_form.datetime_setting.value = datetimeSetting;
  
  displayEffectiveSettingAdd();
}

/**
 * This checks to see if the date is valid and formats it or clears it.
 */
function datetimeCheckModify() {
  var datetimeSetting = document.configuration_global_modify_form.datetime_setting.value;
  
  if (datetimeSetting === undefined || datetimeSetting === null || datetimeSetting === '') {
	    datetimeSetting = '';
  }
  else {
	var dt = moment(datetimeSetting);
	if (dt !== undefined && dt !== null && !isNaN(dt.valueOf())) {
	  datetimeSetting = dt.format('D MMM YYYY HH:mm:ss');
	}
	else {
	  datetimeSetting = '';
	}
  }
  document.configuration_global_modify_form.datetime_setting.value = datetimeSetting;
  
  displayEffectiveSettingModify();
}