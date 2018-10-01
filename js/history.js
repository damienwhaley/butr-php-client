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
 * This actually sets the history state
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param historyState
 *   - Object containing the histoy state.
 */
function setHistory(historyState) {
  'use strict';
  
  var content = '';
  
  if (historyState === undefined || historyState === null) {
	historyState = {};
	historyState.pageTitle = '';
	historyState.fragmentTitle = '';
	historyState.pageUrl = '';
	historyState.pageAttributes = '';
	historyState.pageWells = '';
  }
  
  if (historyState.language === undefined || historyState.language === null || historyState.language === '') {
	historyState.language = 'en-AU';
	if (butrSession !== undefined && butrSession !== null) {
	  if (butrSession.language !== undefined && butrSession !== null && butrSession.language !== '') {
	    historyState.language = butrSession.language;
	  }
    }; 
  }
  
  if (historyState.pageUrl !== undefined && historyState.pageUrl !== null
    && historyState.pageAttributes !== undefined && historyState.pageAttributes !== null
    && historyState.pageWells !== undefined && historyState.pageWells !== null) {
    content = escape(historyState.pageUrl) + '?' + historyState.pageAttributes;
  
    // Remove trailing ampersand
    if (content.charAt(content.length - 1) === '&') {
      content = content.substring(0, content.length - 1);
    }
    // Remove trailing question mark
    if (content.charAt(content.length - 1) === '?') {
      content = content.substring(0, content.length - 1);
    }
    if (historyState.pageWells !== undefined && historyState.pageWells !== null && historyState.pageWells !== '') {
      content += '&w=' + escape(historyState.pageWells);
    }
  }
  if (content !== undefined && content !== null && content !== '') {
	historyState.content = content;
  }
  else {
	historyState.content = '';
  }
  
  if (historyState.pageTitle === undefined || historyState.pageTitle === null) {
	historyState.pageTitle = '';
  }
  else {
	historyState.pageTitle = historyState.pageTitle+' | Butr | '
	  +butrGlobalConfigurations.company_name;
  }
  
  // Save the history state object
  document.butr_state_form.content.value = historyState.content;
  document.butr_state_form.page_title.value = historyState.pageTitle;
  document.butr_state_form.fragment_title.value = historyState.fragmentTitle;
  document.butr_state_form.page_wells = historyState.pageWells;
  document.butr_state_form.page_url = historyState.pageUrl;
  document.butr_state_form.page_attributes = historyState.pageAttributes;
  document.butr_state_form.language = historyState.language;
  
  document.title = historyState.pageTitle;
  $('#page-title').html(historyState.fragmentTitle);
  History.pushState(historyState, historyState.pageTitle, '?page=' + content);
}

/**
 * This is fired whenever there is a state change. This figures out the content
 * to load and calls insertContent with the correct parameters.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param state
 *   - Object containing the History state
 */
function handleHistoryStateChange(state) {
  'use strict';
  
  if (state === undefined || state === null) {
    // Nothing to do.
    return;
  }
  
  if (state.data === undefined || state.data === null) {
    // Nothing to do.
    return;
  }
  
  var content = '';
  
  if (state.data.content !== undefined && state.data.content !== null && state.data.content !== '') {
	content = state.data.content;
  }
  else {
	if (state.data.pageUrl !== undefined && state.data.pageUrl !== null
	  && state.data.pageAttributes !== undefined && state.data.pageAttributes !== null
	  && state.data.pageWells !== undefined && state.data.pageWells !== null) {
	  content = '?page=' + escape(state.data.pageUrl) + '&' + state.data.pageAttributes;
	 
	  // Remove trailing ampersand
	  if (content.charAt(content.length - 1) === '&') {
	    content = content.substring(0, content.length - 1);
	  }
	  if (state.data.pageWells !== undefined && state.data.pageWells !== null && state.data.pageWells !== '') {
	    content += '&w=' + escape(state.data.pageWells);
	  }
	}
  }
  
  if (content !== undefined && content !== null && content !== '') {
	// Save the history state object
	saveHistory(state.data.pageTitle, state.data.fragmentTitle,
	  state.data.pageUrl, state.data.pageAttributes,
	  state.data.pageWells, state.data.content);
	
	document.butr_state_form.language = state.data.language;
	
    insertPageFragment(content, false);
  }
}

/**
 * This saves the history sate object to the state form object.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param pageTitle
 *   - String containing the page title
 * @param fragmentTitle
 *   - String containing the fragment title
 * @param pageUrl
 *   - String containing the page to load
 * @param pageAttributes
 *   - String containing the attributes for the page load
 * @param pageWells
 *   - String containing the page wells which were open
 * @param content
 *   - String containing the pageUrl and pageAttributes combined
 */
function saveHistory(pageTitle, fragmentTitle, pageUrl, pageAttributes,
  pageWells, content) {
  'use strict';
  
  if (content === undefined || content === null || content === '') {
	var newContent = '';
	
	if (pageUrl !== undefined && pageUrl !== null
	  && pageAttributes !== undefined && pageAttributes !== null
	  && pageWells !== undefined && pageWells !== null) {
		newContent = '?page=' + escape(pageUrl) + '&' + pageAttributes;
	 
	  // Remove trailing ampersand
	  if (newContent.charAt(newContent.length - 1) === '&') {
		newContent = newContent.substring(0, newContent.length - 1);
	  }
	  if (pageWells !== undefined && pageWells !== null && pageWells !== '') {
		newContent += '&w=' + escape(pageWells);
	  }
	}
	  
	document.butr_state_form.content.value = newContent;
  }
  else {
    document.butr_state_form.content.value = content;
  }
  
  if (pageTitle === undefined || pageTitle === null || pageTitle === '') {
	document.butr_state_form.page_title.value = '';
  }
  else {
    document.butr_state_form.page_title.value = pageTitle;
  }
  
  if (fragmentTitle === undefined || fragmentTitle === null || fragmentTitle === '') {
	document.butr_state_form.fragment_title.value = '';
  }
  else {
    document.butr_state_form.fragment_title.value = fragmentTitle;
  }
  
  if (pageWells === undefined || pageWells === null || pageWells === '') {
	document.butr_state_form.page_wells = '';
  }
  else {
    document.butr_state_form.page_wells = pageWells;
  }
  
  if (pageUrl === undefined || pageUrl === null || pageUrl === '') {
	document.butr_state_form.page_url = '';
  }
  else {
    document.butr_state_form.page_url = pageUrl;
  }
  
  if (pageAttributes === undefined || pageAttributes === null || pageAttributes === '') {
	document.butr_state_form.page_attributes = '';
  }
  else {
    document.butr_state_form.page_attributes = pageAttributes;
  } 
}

/**
 * This set the history to allow back/forwards buttons. This is for the
 * country administration page.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function setHistoryLocationCountry() {
  'use strict';
  
  var content = '';
  var historyState = {};
  historyState.pageUrl = 'location_country.php';
  historyState.pageAttributes = '';
  historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_CountryAdministration;
  
  content = '?page=' + historyState.pageUrl + '&' + historyState.pageAttributes;

  // Remove trailing ampersand
  if (content.charAt(content.length - 1) === '&') {
	content = content.substring(0, content.length - 1);
  }

  document.title = historyState.pageTitle;
  $('#title').html(butr_i18n_CountryAdministration);
  document.butr_state_form.content.value = content;
  History.pushState(historyState, historyState.pageTitle, content);
}

/**
 * This set the history to allow back/forwards buttons. This is for the
 * global configuration administration page.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function setHistoryConfigurationGlobal() {
  'use strict';
  
  var content = '';
  var historyState = {};
  historyState.pageUrl = 'configuration_global.php';
  historyState.pageAttributes = '';
  historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_GlobalConfigurationAdministration;
  
  content = '?page=' + historyState.pageUrl + '&' + historyState.pageAttributes;

  // Remove trailing ampersand
  if (content.charAt(content.length - 1) === '&') {
	content = content.substring(0, content.length - 1);
  }

  document.title = historyState.pageTitle;
  $('#title').html(butr_i18n_GlobalConfigurationAdministration);
  document.butr_state_form.content.value = content;
  History.pushState(historyState, historyState.pageTitle, content);
}

/**
 * This set the history to allow back/forwards buttons. This is for the
 * global language configuration administration page.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function setHistoryConfigurationGlobalLanguage() {
  'use strict';
  
  var content = '';
  var historyState = {};
  historyState.pageUrl = 'configuration_global_language.php';
  historyState.pageAttributes = '';
  historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_GlobalLanguageConfigurationAdministration;
  
  content = '?page=' + historyState.pageUrl + '&' + historyState.pageAttributes;

  // Remove trailing ampersand
  if (content.charAt(content.length - 1) === '&') {
	content = content.substring(0, content.length - 1);
  }

  document.title = historyState.pageTitle;
  $('#title').html(butr_i18n_GlobalLanguageConfigurationAdministration);
  document.butr_state_form.content.value = content;
  History.pushState(historyState, historyState.pageTitle, content);
}

/**
 * This set the user history to allow back/forwards buttons. This is for the
 * user administration page.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function setHistoryUserUser() {
  'use strict';
  
  var historyState = {};
  historyState.pageUrl = 'user_user.php';
  historyState.pageAttributes = '';
  historyState.pageTitle = butr_i18n_UserAdministration;
  historyState.fragmentTitle = butr_i18n_UserAdministration;
  historyState.pageWells = '';
  
  setHistory(historyState);
}

/**
 * This set the user history to allow back/forwards buttons. This is for the
 * user administration page.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function setHistoryDashboard() {
  'use strict';
  
  var historyState = {};
  historyState.pageUrl = 'dashboard.php';
  historyState.pageAttributes = '';
  historyState.pageTitle = butr_i18n_Dashboard;
  historyState.fragmentTitle = butr_i18n_Dashboard;
  historyState.pageWells = '';
  
  setHistory(historyState);
}

/**
 * This set the history to allow back/forwards buttons. This is for the
 * global title configuration administration page.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function setHistoryConfigurationGlobalTitle() {
  'use strict';
  
  var content = '';
  var historyState = {};
  historyState.pageUrl = 'configuration_global_title.php';
  historyState.pageAttributes = '';
  historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_GlobalTitleConfigurationAdministration;
  
  content = '?page=' + historyState.pageUrl + '&' + historyState.pageAttributes;

  // Remove trailing ampersand
  if (content.charAt(content.length - 1) === '&') {
	content = content.substring(0, content.length - 1);
  }

  document.title = historyState.pageTitle;
  $('#title').html(butr_i18n_GlobalTitleConfigurationAdministration);
  document.butr_state_form.content.value = content;
  History.pushState(historyState, historyState.pageTitle, content);
}

/**
 * This set the message history to allow back/forwards buttons. This is for the
 * system message administration page.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function setHistorySystemMessage() {
  'use strict';
  
  var content = '';
  var historyState = {};
  historyState.pageUrl = 'system_message.php';
  historyState.pageAttributes = '';
  historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_MessageAdministration;
  
  content = '?page=' + historyState.pageUrl + '&' + historyState.pageAttributes;

  // Remove trailing ampersand
  if (content.charAt(content.length - 1) === '&') {
	content = content.substring(0, content.length - 1);
  }
  
  document.title = historyState.pageTitle;
  $('#title').html(butr_i18n_MessageAdministration);
  document.butr_state_form.content.value = content;
  History.pushState(historyState, historyState.pageTitle, content);
}

/**
 * This set the history to allow back/forwards buttons. This is for the
 * security authentication method configuration administration page.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function setHistoryConfigurationSecurityAuthenticationMethod() {
  'use strict';
  
  var content = '';
  var historyState = {};
  historyState.pageUrl = 'configuration_security_authentication_method.php';
  historyState.pageAttributes = '';
  historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_SecurityAuthenticationMethodConfigurationAdministration;
  
  content = '?page=' + historyState.pageUrl + '&' + historyState.pageAttributes;

  // Remove trailing ampersand
  if (content.charAt(content.length - 1) === '&') {
	content = content.substring(0, content.length - 1);
  }

  document.title = historyState.pageTitle;
  $('#title').html(butr_i18n_SecurityAuthenticationMethodConfigurationAdministration);
  document.butr_state_form.content.value = content;
  History.pushState(historyState, historyState.pageTitle, content);
}

/**
 * This set the history to allow back/forwards buttons. This is for the
 * global title configuration administration page.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function setHistoryConfigurationSecurityClientType() {
  'use strict';
  
  var content = '';
  var historyState = {};
  historyState.pageUrl = 'configuration_security_client_type.php';
  historyState.pageAttributes = '';
  historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_SecurityClientTypeConfigurationAdministration;
  
  content = '?page=' + historyState.pageUrl + '&' + historyState.pageAttributes;

  // Remove trailing ampersand
  if (content.charAt(content.length - 1) === '&') {
	content = content.substring(0, content.length - 1);
  }

  document.title = historyState.pageTitle;
  $('#title').html(butr_i18n_SecurityClientTypeConfigurationAdministration);
  document.butr_state_form.content.value = content;
  History.pushState(historyState, historyState.pageTitle, content);
}

/**
 * This set the history to allow back/forwards buttons. This is for the
 * system dock type configuration administration page.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function setHistoryConfigurationSystemDockType() {
  'use strict';
  
  var content = '';
  var historyState = {};
  historyState.pageUrl = 'configuration_system_dock_type.php';
  historyState.pageAttributes = '';
  historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_SystemDockTypeConfigurationAdministration;
  
  content = '?page=' + historyState.pageUrl + '&' + historyState.pageAttributes;

  // Remove trailing ampersand
  if (content.charAt(content.length - 1) === '&') {
	content = content.substring(0, content.length - 1);
  }

  document.title = historyState.pageTitle;
  $('#title').html(butr_i18n_SystemDockTypeConfigurationAdministration);
  document.butr_state_form.content.value = content;
  History.pushState(historyState, historyState.pageTitle, content);
}

/**
 * This set the history to allow back/forwards buttons. This is for the
 * system dock type configuration administration page.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function setHistoryConfigurationSystemLogType() {
  'use strict';
  
  var content = '';
  var historyState = {};
  historyState.pageUrl = 'configuration_system_log_type.php';
  historyState.pageAttributes = '';
  historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_SystemLogTypeConfigurationAdministration;
  
  content = '?page=' + historyState.pageUrl + '&' + historyState.pageAttributes;

  // Remove trailing ampersand
  if (content.charAt(content.length - 1) === '&') {
	content = content.substring(0, content.length - 1);
  }

  document.title = historyState.pageTitle;
  $('#title').html(butr_i18n_SystemDockTypeConfigurationAdministration);
  document.butr_state_form.content.value = content;
  History.pushState(historyState, historyState.pageTitle, content);
}

/**
 * This set the history to allow back/forwards buttons. This is for the
 * security permission administration page.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function setHistorySecurityPermission() {
  'use strict';
  
  var content = '';
  var historyState = {};
  historyState.pageUrl = 'security_permission.php';
  historyState.pageAttributes = '';
  historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_PermissionAdministration;
  
  content = '?page=' + historyState.pageUrl + '&' + historyState.pageAttributes;

  // Remove trailing ampersand
  if (content.charAt(content.length - 1) === '&') {
	content = content.substring(0, content.length - 1);
  }

  document.title = historyState.pageTitle;
  $('#title').html(butr_i18n_PermissionAdministration);
  document.butr_state_form.content.value = content;
  History.pushState(historyState, historyState.pageTitle, content);
}

/**
 * This set the history to allow back/forwards buttons. This is for the
 * user group administration page.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function setHistoryUserGroup() {
  'use strict';
  
  var content = '';
  var historyState = {};
  historyState.pageUrl = 'user_group.php';
  historyState.pageAttributes = '';
  historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_GroupAdministration;
  
  content = '?page=' + historyState.pageUrl + '&' + historyState.pageAttributes;

  // Remove trailing ampersand
  if (content.charAt(content.length - 1) === '&') {
	content = content.substring(0, content.length - 1);
  }

  document.title = historyState.pageTitle;
  $('#title').html(butr_i18n_GroupAdministration);
  document.butr_state_form.content.value = content;
  History.pushState(historyState, historyState.pageTitle, content);
}