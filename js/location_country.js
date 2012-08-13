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
 * location coutnry administration add country page.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function setHistoryLocationCountryAdd() {
  'use strict';
  
  var historyState = {};
  var content = '';
  historyState.pageUrl = 'location_country.php';
  historyState.pageAttributes = 'a=add';
  historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_CountryAdministration+' | '+butr_i18n_AddCountry;
  
  content = '?page=' + historyState.pageUrl + '&' + historyState.pageAttributes;

  // Remove trailing ampersand
  if (content.charAt(content.length - 1) === '&') {
	content = content.substring(0, content.length - 1);
  }

  document.title = historyState.pageTitle;
  $('#title').html(butr_i18n_CountryAdministration+' - '+butr_i18n_AddCountry);
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
function setHistoryLocationCountryFetch(uuid) {
  'use strict';
  
  var historyState = {};
  var content = '';
  historyState.pageUrl = 'location_country.php';
  historyState.pageAttributes = 'a=fetch&uuid=' + uuid;
  historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_CountryAdministration+' | '+butr_i18n_ModifyCountry;
  
  content = '?page=' + historyState.pageUrl + '&' + historyState.pageAttributes;

  // Remove trailing ampersand
  if (content.charAt(content.length - 1) === '&') {
	content = content.substring(0, content.length - 1);
  }
  
  document.title = historyState.pageTitle;
  $('#title').html(butr_i18n_CountryAdministration+' - '+butr_i18n_ModifyCountry);
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
function setHistoryLocationCountryList(offset, size, ordinal, direction) {
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
	  historyState.pageUrl = 'location_country.php';
	  historyState.pageAttributes = 'a=list&offset=' + escape(offset) + '&size=' + escape(size) + '&ordinal=' + escape(ordinal) + '&direction=' + escape(direction);
	  historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_CountryAdministration+' | '+butr_i18n_ListCountries;
	  
	  content = '?page=' + historyState.pageUrl + '&' + historyState.pageAttributes;

	  //remove trailing ampersand
	  if (content.charAt(content.length - 1) === '&') {
		content = content.substring(0, content.length - 1);
	  }
	  
	  document.title = historyState.pageTitle;
	  $('#title').html(butr_i18n_CountryAdministration  + ' - ' + butr_i18n_ListCountries);
	  document.butr_state_form.content.value = content;
	  History.pushState(historyState, historyState.pageTitle, content);
	}

/**
 * This checks the form to ensure that the form has sensible information.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function processLocationCountryAddForm() {
  'use strict';
  
  var errorMessage = '';
  var countryName = document.location_country_add_form.country_name.value;
  var displayName = document.location_country_add_form.display_name.value;
  var description = document.location_country_add_form.description.value;
  var countryCode = document.location_country_add_form.country_code.value;
  var alternateCode = document.location_country_add_form.alternate_code.value;
  var weighting = document.location_country_add_form.weighting.value;
  var isActive = 0;
  if (document.location_country_add_form.is_active.checked === true) {
	isActive = 1;  
  }
  
  $('#error').modal('hide');
  $('#warning').modal('hide');
  $('#notice').modal('hide');
  $('#debug').modal('hide');
  
  document.location_country_add_form.submit.disabled = true;
  
  if (countryName === undefined || countryName === null || countryName === '') {
    errorMessage += '<br>* '+butr_i18n_CountryName;
  }
  if (displayName === undefined || displayName === null || displayName === '') {
    displayName = '';
  }
  if (description === undefined || description === null || description === '') {
    description = '';
  }
  if (countryCode === undefined || countryCode === null || countryCode === '') {
    countryCode = '';
  }
  if (alternateCode === undefined || alternateCode === null || alternateCode === '') {
    alternateCode = '';
  }
  if (weighting === undefined || weighting === null || isNaN(weighting)) {
    weighting = '';
  }
  
  if (errorMessage !== '') {
    $('#notice_message').html(butr_i18n_PleaseCheckThatYouHaveCompleted+':'+errorMessage);
    $('#notice').modal('show');
    document.location_country_add_form.submit.disabled = false;
    return false;
  }
  
  var form_body = '';
   
  form_body = 'country_name=' + escape(countryName)
    + '&display_name=' + escape(displayName)
    + '&description=' + escape(description)
    + '&country_code=' + escape(countryCode)
    + '&alternate_code=' + escape(alternateCode)
    + '&weighting=' + escape(weighting)
    + '&is_active=' + escape(isActive)
    + '&command=add_country'
    + '&window_name=' + escape(window.name);
    
  $.ajax({
    url: 'ajax/location_country.php',
    data: form_body,
    type: 'POST',
    contentType: 'application/x-www-form-urlencoded',
    success: function(data, textStatus, jqXHR) {
      'use strict';
      
      try {
        processLocationCountryAddResponse(JSON.parse(jqXHR.responseText));
      } catch (e) {
        handleLocationCountryAddError(jqXHR.responseText);
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      'use strict';
      
      handleLocationCountryAddError(jqXHR.responseText);
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
function processLocationCountryAddResponse(res) {
  'use strict';
  
  var responseStatus = '';
  var explanation = '';
  var countryUuid = '';

  if (res === undefined || res === null || typeof(res) !== 'object') {
    return handleLocationCountryAddError(res);
  }
  
  if (res.result !== undefined) {
    if (res.result.status !== undefined && res.result.status !== null && res.result.status !== '') {
      responseStatus = res.result.status ;
    }
  }
  
  if (res.add_country !== undefined) {
    if (res.add_country.uuid !== undefined && res.add_country.uuid !== null && res.add_country.uuid !== '') {
      countryUuid = res.add_country.uuid;
    }
  }
  
  if (responseStatus === 'OK' && countryUuid !== '') {
	document.butr_state_form.content.value = 'location_country.php?a=fetch&uuid=' + escape(countryUuid) + '&success=ok_add';
	document.butr_state_form.submit();   
    return;
  }

  return handleLocationCountryAddError(res);
}

/**
 * This checks the form to ensure that the form has sensible information.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function processLocationCountryModifyForm() {
  'use strict';
  
  var errorMessage = '';
  var uuid = document.location_country_modify_form.uuid.value;
  var countryName = document.location_country_modify_form.country_name.value;
  var displayName = document.location_country_modify_form.display_name.value;
  var description = document.location_country_modify_form.description.value;
  var countryCode = document.location_country_modify_form.country_code.value;
  var alternateCode = document.location_country_modify_form.alternate_code.value;
  var weighting = document.location_country_modify_form.weighting.value;
  var isActive = 0;
  if (document.location_country_modify_form.is_active.checked === true) {
	isActive = 1;  
  }
  
  $('#error').modal('hide');
  $('#warning').modal('hide');
  $('#notice').modal('hide');
  $('#debug').modal('hide');
  
  document.location_country_modify_form.submit.disabled = true;
  
  if (countryName === undefined || countryName === null || countryName === '') {
    errorMessage += '<br>* '+butr_i18n_CountryName;
  }
  if (displayName === undefined || displayName === null || displayName === '') {
    displayName = '';
  }
  if (description === undefined || description === null || description === '') {
    description = '';
  }
  if (countryCode === undefined || countryCode === null || countryCode === '') {
    countryCode = '';
  }
  if (alternateCode === undefined || alternateCode === null || alternateCode === '') {
    alternateCode = '';
  }
  if (weighting === undefined || weighting === null || isNaN(weighting)) {
    weighting = '';
  }
  
  if (errorMessage !== '') {
    $('#notice_message').html(butr_i18n_PleaseCheckThatYouHaveCompleted+':'+errorMessage);
    $('#notice').modal('show');
    document.location_country_modify_form.submit.disabled = false;
    return false;
  }
  
  var form_body = '';
   
  form_body = 'uuid=' + escape(uuid)
    + '&country_name=' + escape(countryName)
    + '&display_name=' + escape(displayName)
    + '&description=' + escape(description)
    + '&country_code=' + escape(countryCode)
    + '&alternate_code=' + escape(alternateCode)
    + '&weighting=' + escape(weighting)
    + '&is_active=' + escape(isActive)
    + '&command=modify_country'
    + '&window_name=' + escape(window.name);
  
  $.ajax({
    url: 'ajax/location_country.php',
    data: form_body,
    type: 'POST',
    contentType: 'application/x-www-form-urlencoded',
    success: function(data, textStatus, jqXHR) {
      'use strict';
      
      try {   	  
        processLocationCountryModifyResponse(JSON.parse(jqXHR.responseText));
      } catch (e) {
        handleLocationCountryModifyError(jqXHR.responseText);
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      'use strict';
      
      handleLocationCountryModifyError(jqXHR.responseText);
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
function processLocationCountryModifyResponse(res) {
  'use strict';
  
  var responseStatus = '';
  var explanation = '';
  var countryUuid = '';
  
  if (res === undefined || res === null || typeof(res) !== 'object') {
    return handleLocationCountryModifyError(res);
  }
  
  if (res.result !== undefined) {
    if (res.result.status !== undefined && res.result.status !== null && res.result.status !== '') {
      responseStatus = res.result.status ;
    }
  }
  
  if (res.modify_country !== undefined) {
    if (res.modify_country.uuid !== undefined && res.modify_country.uuid !== null && res.modify_country.uuid !== '') {
      countryUuid = res.modify_country.uuid;
    }
  }
  
  if (responseStatus === 'OK' && countryUuid !== '') {
    // refresh view to be the fetch and get it to pop a message to say it
    // was modified.
    
    alert('Country wth UUID = ' + countryUuid + ' was modified.');
    
    document.location_country_modify_form.submit.disabled = false;
    
    return;
  }

  return handleLocationCountryModifyError(res);
}

/**
 * This handles any errors and displays them in an error div.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param res
 *   - object or string containing the response from the server.
 */
function handleLocationCountryAddError(res) {
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
    explanation = butr_i18n_CouldNotAddCountry+'.';
  }

  if (responseStatus !== 'OK') {
    $('#error_message').html(explanation);
    $('#error').modal('show');
  }
  
  document.location_country_add_form.submit.disabled = false;
}

/**
 * This handles any errors and displays them in an error div.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param res
 *   - object or string containing the response from the server.
 */
function handleLocationCountryModifyError(res) {
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
    explanation = butr_i18n_CouldNotModifyCountry+'.';
  }

  if (responseStatus !== 'OK') {
    $('#error_message').html(explanation);
    $('#error').modal('show');
  }
  
  document.location_country_modify_form.submit.disabled = false;
}