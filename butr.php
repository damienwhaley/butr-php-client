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

// Instantiate page classes for templated presentation.
$butr_page = new Butr\Page();
$butr_pageNavigation = new Butr\PageNavigation();
$butr_pageDock = new Butr\PageDock();

$window_name = isset($_POST['window']) ? $_POST['window'] : '';
$session_token = $butr_page->fetchSessionCookie($window_name);

// Figure out the content to reload if the page is refreshed.
$state = array();
$state['content'] = isset($_POST['content']) ? $_POST['content'] : '';
if ($state['content'] === '' && isset($_SERVER['QUERY_STRING'])) {
  $state['content'] = $_SERVER['QUERY_STRING'];
}
if ($state['content'] == '') {
  $state['content'] = 'dashboard.php';
}
else {
  if (strlen($state['content']) >= 1) {
    if (substr($state['content'], 0, 1) === '?') {
      $state['content'] = substr($state['content'], 1, strlen($state['content']) - 1);
    }
  }
  if (strlen($state['content']) >= 5) {
    if (substr($state['content'], 0, 5) === 'page=') {      
      $state['content'] = substr($state['content'], 5, strlen($state['content']) - 5);
    }
  }
  if (strlen($state['content']) >= 5) {
    if (strpos($state['content'], '.php&')) {
      $state['content'] = str_replace('.php&', '.php?', $state['content']);
    }
  }
}

$state['page_title'] = isset($_POST['page_title']) ? $_POST['page_title'] : '';
$state['fragment_title'] = isset($_POST['fragment_title']) ? $_POST['fragment_title'] : '';
$state['page_wells'] = isset($_POST['page_wells']) ? $_POST['page_wells'] : '';
$state['page_url'] = isset($_POST['page_url']) ? $_POST['page_url'] : '';
$state['page_attributes'] = isset($_POST['page_attributes']) ? $_POST['page_attributes'] : '';

$state['page_title'] = htmlspecialchars($state['page_title'], ENT_COMPAT | ENT_HTML5, 'UTF-8');
$state['fragment_title'] = htmlspecialchars($state['fragment_title'], ENT_COMPAT | ENT_HTML5, 'UTF-8');
$state['page_wells'] = htmlspecialchars($state['page_wells'], ENT_COMPAT | ENT_HTML5, 'UTF-8');
$state['page_url'] = htmlspecialchars($state['page_url'], ENT_COMPAT | ENT_HTML5, 'UTF-8');
$state['page_attributes'] = htmlspecialchars($state['page_attributes'], ENT_COMPAT | ENT_HTML5, 'UTF-8');

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

if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
  $butr_pageDock->buildDock($json_object->list_user_docks);
}
unset($json_object);
unset($butr_command);

if (isset($butr_session->data->modules)) {
  $butr_pageDock->buildModule($butr_session->data->modules);
}

$company_name = isset($butr_global_configurations['company_name']) ? $butr_global_configurations['company_name'] : '';
$language = isset($butr_session->data->language) ? $butr_session->data->language: Butr\DEFAULT_LANGUAGE;
$user_first_name = isset($butr_session->data->user->first_name) ? $butr_session->data->user->first_name: '';

// Escape output
$company_name = htmlspecialchars($company_name, ENT_COMPAT | ENT_HTML5, 'UTF-8');
$language = htmlspecialchars($language_code, ENT_COMPAT | ENT_HTML5, 'UTF-8');
$user_first_name = htmlspecialchars($user_first_name, ENT_COMPAT | ENT_HTML5, 'UTF-8');

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
    
      $(document).ready(function () {
        'use strict';
        
        $(window)._scrollable();
        moment.lang(butrSession.language);

        // Make sure session is active (long polling).
        checkSessionAlive();
      });
    </script>
    <div id="fixed-wrapper">
<?php 
$butr_pageNavigation->setAll($company_name, $company_picture_path, $user_first_name, $language);
$butr_pageNavigation->generateHtml();
$butr_pageDock->generateHtmlDock();
?>
      <div id="heading" class="container-fluid">
        <div class="row-fluid">
          <div class="span12">
            <hgroup class="title">
              <h1 id="page-title">&nbsp;</h1>
              <ul class="btns right" id="page-title-buttons">
              </ul><!-- end .right -->
            </hgroup><!-- end .title -->
          </div><!-- end .span12 -->
        </div><!-- end .row-fluid -->
      </div><!-- end .container-fluid -->
    </div><!-- end #fixed-wrapper -->
    <section id="page">    
    </section><!-- end #page -->
    <form name="butr_state_form" action="butr.php" method="post">
      <input type="hidden" name="window" value="">
      <input type="hidden" name="language" value="">
      <input type="hidden" name="content" value="page=<?php echo htmlspecialchars($state['content'], ENT_COMPAT | ENT_HTML5, 'UTF-8'); ?>">
      <input type="hidden" name="page_title" value="<?php echo $state['page_title']; ?>">
      <input type="hidden" name="fragment_title" value="<?php echo $state['fragment_title']; ?>">
      <input type="hidden" name="page_url" value="<?php echo $state['page_url']; ?>">
      <input type="hidden" name="page_attributes" value="<?php echo $state['page_attributes']; ?>">
      <input type="hidden" name="page_wells" value="<?php echo $state['page_wells']; ?>">
    </form>
    <script type="text/javascript">
      document.butr_state_form.window.value = window.name;
      document.butr_state_form.language = butrSession.language;
<?php 
if ($state['content'] !== '') {
?>
      $(document).ready(function () {
        'use strict';
        
        insertPageFragment('<?php echo $state['content']; ?>', true);
      });
<?php
}
?>
    </script>
<?php 
// Generate bottom part of the page including flushing the buffer.
$butr_page->generateHtmlBottom();
