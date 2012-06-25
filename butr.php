<?php 
/*
 * Butr Universal Travel Reservations
 * A bleeding edge business management system for the travel industry.
 *
 * Copyright (C) 2012 Whalebone Studios and contributors.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 *  published by the Free Software Foundation, either version 3 of the
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

// Include and requires.
require_once('includes/butr.inc');

// Instantiate page class for templated presentation.
$butr_page = new Butr\Page();

$window_name = isset($_POST['window']) ? $_POST['window'] : '';
$session_token = $butr_page->fetchSessionCookie($window_name);

// Figure out the content to reload if the page is refreshed.
$content = isset($_POST['content']) ? $_POST['content'] : '';
if ($content === '' && isset($_SERVER['QUERY_STRING'])) {
  $content = $_SERVER['QUERY_STRING'];
  $patterns = array(0 => '/&a=/', 1 => '/^page=/');
  $replacements = array(0 => '?a=', 1 => '');
  $content = preg_replace($patterns, $replacements, $content);
  $patterns = null;
  $replacements = null;
}
if ($content == '') {
  $content = 'dashboard.php';
}

$butr_authentication = new Butr\Authentication();
$butr_authentication->setSessionToken($session_token);

// Grab session details
$butr_command = new Butr\CommandFetchSession();
$butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
$butr_command->prepareCommand();
$json_session = $butr_command->sendCommand();
$json_object = json_decode($json_session, false);
$json_error = json_last_error();

$butr_session = array();
if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
  $butr_session = $json_object->fetch_session;
}
unset($json_object);
unset($butr_command);

// Grab global configuration settings
$butr_command = new Butr\CommandListGlobalConfigurations();
$butr_command->setAll(0, -1, Butr\SORT_DIRECTION_ASCENDING, Butr\SORT_ORDINAL_DEFAULT);
$butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
$butr_command->prepareCommand();
$json_global_configuration = $butr_command->sendCommand();
$json_object = json_decode($json_global_configuration, false);
$json_error = json_last_error();

$butr_global_configurations = array();
if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
  for($i = 0; $i < sizeof($json_object->list_global_configurations->items); $i++) {
    $butr_global_configurations[$json_object->list_global_configurations->items[$i]->magic] = $json_object->list_global_configurations->items[$i]->effective_setting;
  }
}
unset($json_object);
unset($butr_command);

// Grab user docks
$butr_command = new Butr\CommandListUserDocks();
$butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
$butr_command->prepareCommand();
$json_user_docks = $butr_command->sendCommand();
$json_object = json_decode($json_user_docks, false);
$json_error = json_last_error();

$butr_dock = new Butr\Dock();
if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
  $butr_dock->buildDock($json_object->list_user_docks);
}

unset($json_object);
unset($butr_command);

// Grab user tabs
$butr_command = new Butr\CommandListUserDockTabs();
$butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
$butr_command->prepareCommand();
$json_user_dock_tabs = $butr_command->sendCommand();
$json_object = json_decode($json_user_dock_tabs, false);
$json_error = json_last_error();

if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
	$butr_dock->buildTab($json_object->list_user_dock_tabs);
}

unset($json_object);
unset($butr_command);

$company_name = isset($butr_global_configurations['company_name']) ? $butr_global_configurations['company_name'] : '';
$language = isset($butr_session->data->language) ? $butr_session->data->language: Butr\DEFAULT_LANGUAGE;

// Escape output
$company_name = htmlspecialchars($company_name, ENT_COMPAT | ENT_HTML5);
$language = htmlspecialchars($language_code, ENT_COMPAT | ENT_HTML5);

// Generate the top part of the page including buffering output.
$butr_page->generateHtmlTop($company_name, array('butr.js'), array('butr.css'), $language);
?>
<script type="text/javascript">
  'use strict';
  
  var History = window.History;

  History.Adapter.bind(window, 'statechange', function(){
    'use strict';
    
    handleHistoryStateChange(History.getState());
  });
  
  var globalJson = '<?php echo str_replace("\n", "", $json_global_configuration); ?>';
  var butrGlobalConfigurations = parseGlobalConfiguration(globalJson);
  globalJson = null;
  var sessionJson = '<?php echo str_replace("\n", "", $json_session); ?>';
  var butrSession = parseSession(sessionJson);
  sessionJson = null;

  // Make sure the session is active.
  $(document).ready(checkSessionAlive);
</script>

<div id="wrap">
  <div id="header">
  </div><!--  /#header -->
  <div id="title">
    Title / Menus / Action Bar goes here.
  </div><!-- /#title -->
  <div id="tray">
    <div id="tray-notification" class="tray-tile">
      <a href="javascript:void(0);" class="tray-link"><img src="/images/icons/tray-notification-icon.png" title="<?php echo gettext('Notification'); ?>" alt="<?php echo gettext('Notification'); ?>" class="tray-icon"></a>
    </div><!-- /#tray-notification -->
    <div id="tray-history" class="tray-tile">
      <a href="javascript:void(0);" class="tray-link"><img src="/images/icons/tray-history-icon.png" title="<?php echo gettext('Recently Accessed'); ?>" alt="<?php echo gettext('Recently Accessed'); ?>" class="tray-icon"></a>
    </div><!-- /#tray-history -->
    <div id="tray-undo" class="tray-tile">
      <a href="javascript:void(0);" class="tray-link"><img src="/images/icons/tray-undo-icon.png" title="<?php echo gettext('Undo'); ?>" alt="<?php echo gettext('Undo'); ?>" class="tray-icon"></a>
    </div><!-- /#tray-undo -->
    <div id="tray-help" class="tray-tile">
      <a href="javascript:void(0);" class="tray-link"><img src="/images/icons/tray-help-icon.png" title="<?php echo gettext('Help'); ?>" alt="<?php echo gettext('Help'); ?>" class="tray-icon"></a>
    </div><!-- /#tray-help -->
    <div id="tray-search" class="tray-tile">
      <a href="javascript:void(0);" class="tray-link"><img src="/images/icons/tray-search-icon.png" title="<?php echo gettext('Search'); ?>" alt="<?php echo gettext('Search'); ?>" class="tray-icon"></a>
    </div><!-- /#tray-search -->
    <div id="tray-logout" class="tray-tile">
      <a href="javascript:logOut();" class="tray-link"><img src="/images/icons/tray-log_out-icon.png" title="<?php echo gettext('Log Out'); ?>" alt="<?php echo gettext('Log Out'); ?>" class="tray-icon"></a>
    </div><!-- /#tray-logout -->
  </div><!-- /#tray -->
  <div id="content">
  </div><!-- /#content -->
  <div id="tab">
<?php 
$butr_dock->printDockTab();
?>
  </div><!-- /#tab -->
</div><!-- /#wrap -->
<div id="dock">
<?php
$butr_dock->printDock();
$butr_dock->printDockItems();
$butr_dock->printDockSubitems();
?>
</div><!-- /#dock -->
<form name="butr_state_form" action="butr.php" method="post">
  <input type="hidden" name="window" value="" />
  <input type="hidden" name="content" value="" />
  <input type="hidden" name="language" value="" />
</form>
<script type="text/javascript">
  document.butr_state_form.window.value = window.name;
<?php 
if ($content !== '') {
?>
  $(document).ready(function () {
    insertContent('<?php echo $content; ?>');
  });
<?php
  echo 'moment.lang(butrSession.language);';
}
?>
</script>
<?php 
// Generate bottom part of the page including flushing the buffer.
$butr_page->generateHtmlBottom();
