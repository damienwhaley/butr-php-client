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
  
  var content = '';
  var historyState = {};
  historyState.pageUrl = 'user_user.php';
  historyState.pageAttributes = '';
  historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_UserAdministration;
  
  content = '?page=' + historyState.pageUrl + '&' + historyState.pageAttributes;

  // Remove trailing ampersand
  if (content.charAt(content.length - 1) === '&') {
	  content = content.substring(0, content.length - 1);
  }
  
  document.title = historyState.pageTitle;
  $('#title').html(butr_i18n_UserAdministration);
  document.butr_state_form.content.value = content;
  History.pushState(historyState, historyState.pageTitle, content);
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