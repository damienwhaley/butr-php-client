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
require_once('includes/cookies.inc');

$language_code = isset($_POST['language']) ? $_POST['language'] : Butr\DEFAULT_LANGUAGE;
$window_name = (isset($_POST['window_name'])) ? $_POST['window_name'] : '';
$session_token = fetchSessionCookie($window_name);

$success = '';
$success_script = '';
$success = (isset($_POST['success'])) ? $_POST['success'] : '';
if ($success === '' && isset($_GET['success'])) {
  $success = $_GET['success'];
}

$alter_history = '';
$alter_history_script = '';
$alter_history = (isset($_POST['alter_history'])) ? $_POST['alter_history'] : '';
if ($alter_history === '' && isset($_GET['alter_history'])) {
  $alter_history = $_GET['alter_history'];
}

$user_uuid = '';
$user_uuid = (isset($_POST['uuid'])) ? $_POST['uuid'] : '';
if ($user_uuid === '' && isset($_GET['uuid'])) {
  $user_uuid = $_GET['uuid'];
}

$butr_authentication = new Butr\Authentication();
$butr_authentication->setSessionToken($session_token);

$action_mode = '';
if (isset($_POST['a'])) {
  switch ($_POST['a']) {
    case 'add':
      $action_mode = 'add';
      break;
    case 'edit':
      $action_mode = 'edit';
      break;
    case 'fetch':
      $action_mode = 'fetch';
      break;
    case 'list':
      $action_mode = 'list';
      break;
    case 'search_form':
      $action_mode = 'search_form';
      break;
    case 'search_results':
      $action_mode = 'search_results';
      break;
    default:
      $action_mode = '';
      if ($alter_history = '1') {
        $alter_history_script = "            "
          . " <script type=\"text/javascript\">setHistoryUserUser();</script>\n";
      }
      break;
  }
} else {
  $action_mode = '';
  if ($alter_history = '1') {
    $alter_history_script = "            "
      . "<script type=\"text/javascript\">setHistoryUserUser();</script>\n";
  }
}

switch($success) {
  case 'add_ok':
    $success_script = "            "
      . "<script type=\"text/javascript\">alert('add was a success!');</script>\n";
    if ($user_uuid !== '') {
      $alter_history_script = "            "
        . "<script type=\"text/javascript\">setHistoryUserUserFetch('" . $user_uuid . "');</script>\n";
    }
    break;
  default:
    $success_script = '';
    break;
}

if ($action_mode === '' || $action_mode === 'fetch') { 
  // Instantiate page fragment class for templated presentation.
  $butr_pageTab = new Butr\PageTab();
  $butr_pageFragment = new Butr\PageFragment();
  $butr_pageWell = new Butr\PageWell();
  
  // Grab user dock tabs
  $butr_command = new Butr\CommandListUserDockTabs();
  $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
  $butr_command->setMagic('user_user');
  $butr_command->prepareCommand();
  $json_user_tabs = $butr_command->sendCommand();
  $json_object = json_decode($json_user_tabs, false);
  $json_error = json_last_error();
  
  if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
    $butr_pageTab->setAll($json_object->list_user_dock_tabs, $language);
    $butr_pageWell->setAll($json_object->list_user_dock_tabs, $language, $user_uuid);
  }
  
  unset($json_object);
  unset($butr_command);
  
  $user = array();
  if ($user_uuid !== '') {
    // Fetch user
    $butr_command = new Butr\CommandFetchUser();
    $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
    $butr_command->setUuid($user_uuid);
    $butr_command->prepareCommand();
    $json_user = $butr_command->sendCommand();
    $json_object = json_decode($json_user, false);
    $json_error = json_last_error();
    
    if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
      $user['uuid'] = (isset($json_object->fetch_user->uuid)) ? $json_object->fetch_user->uuid : '';
      $user['global_title_label'] = (isset($json_object->fetch_user->global_title_display_label)) ? $json_object->fetch_user->global_title_display_label : '';
      if ($user['global_title_label'] == '') {
        $user['global_title_label'] = (isset($json_object->fetch_user->global_title_name_label)) ? $json_object->fetch_user->global_title_name_label : '';
      }
      $user['first_name'] = (isset($json_object->fetch_user->first_name)) ? $json_object->fetch_user->first_name : '';
      $user['last_name'] = (isset($json_object->fetch_user->first_name)) ? $json_object->fetch_user->last_name : '';
      $user['preferred_global_language_uuid'] = (isset($json_object->fetch_user->preferred_global_language_uuid)) ? $json_object->fetch_user->preferred_global_language_uuid : '';
      $user['username'] = (isset($json_object->fetch_user->username)) ? $json_object->fetch_user->username : '';
    
      // Escpe output
      $user['uuid'] = htmlspecialchars($user['uuid'], ENT_COMPAT | ENT_HTML5, 'UTF-8');
      $user['global_title_label'] = htmlspecialchars($user['global_title_label'], ENT_COMPAT | ENT_HTML5, 'UTF-8');
      $user['first_name'] = htmlspecialchars($user['first_name'], ENT_COMPAT | ENT_HTML5, 'UTF-8');
      $user['last_name'] = htmlspecialchars($user['last_name'], ENT_COMPAT | ENT_HTML5, 'UTF-8');
      $user['preferred_global_language_uuid'] = htmlspecialchars($user['preferred_global_language_uuid'], ENT_COMPAT | ENT_HTML5, 'UTF-8');
      $user['username'] = htmlspecialchars($user['username'], ENT_COMPAT | ENT_HTML5, 'UTF-8');
    }
    unset($json_object);
    unset($butr_command);
  }
  
  // Generate the top part of the page fragment including buffering output.
  $butr_pageFragment->generateHtmlTop(array('user_user.js'), null);
  $butr_pageTab->generateHtmlTab();
  $butr_pageFragment->generateHtmlMiddle($language_code);
  
  if ($alter_history_script !== '') {
    echo $alter_history_script;
  }
  if ($success_script !== '') {
    echo $success_script;
  }
  if ($user_uuid !== '') {
    echo "            <script type=\"text/javascript\">\n"
      . "              document.fragment_state_form.uuid.value = '"
      . htmlspecialchars($user_uuid, ENT_COMPAT | ENT_HTML5, 'UTF-8')
      . "';\n"
      . "              setTitlesUserUser();\n"
      . "            </script>\n";
  }
  else {
  	echo "            <script type=\"text/javascript\">\n"
  	  . "              setTitlesUserUser();\n"
  	  . "            </script>\n";
  }
?>
            <div class="well<?php if ($user_uuid === '') { echo " hide"; }?>" id="user_details">
              <hgroup>
                <h3 class="left"><?php echo gettext('User Information'); ?></h3>
                <ul class="actions">
                  <li><a href="javascript:void(0);" class="icon-cross"></a></li>
                  <li><a href="javascript:void(0);" class="icon-tick"></a></li>
                  <li><a href="javascript:void(0);" class="icon-star"></a></li>
                </ul><!-- end .actions -->
              </hgroup>
              <div class="row-fluid">
                <div class="span8">
                  <div class="col">
                    <span class="lbl"><?php echo gettext('ID'); ?></span>
                    <span class="data"><?php echo $user['uuid']; ?></span>
                  </div><!-- end .col -->
                  <div class="col">
                    <span class="lbl"><?php echo gettext('Title'); ?></span>
                    <span class="data"><?php echo $user['global_title_label']; ?></span>
                  </div><!-- end .col -->
                </div><!--  end .span8 -->
              </div><!-- end .row-fluid -->
              <div class="row-fluid">
                <div class="span8">
                  <div class="col">
                    <span class="lbl"><?php echo gettext('First Name'); ?></span>
                    <span class="data"><?php echo $user['first_name'] ?></span>
                  </div><!-- end .col -->
                  <div class="col">
                    <span class="lbl"><?php echo gettext('Last Name'); ?></span>
                    <span class="data"><?php echo $user['last_name']; ?></span>
                  </div><!-- end .col -->
                </div><!-- end .span8 -->
              </div><!-- end .row-fluid -->
            </div><!-- end .well -->
<?php
  $butr_pageWell->generateHtmlWell();

  // Generate bottom part of the page including flushing the buffer.
  $butr_pageFragment->generateHtmlBottom();
}

if ($action_mode === 'search_form') {
  // Grab global title configuration settings
  $butr_command = new Butr\CommandListGlobalTitleConfigurations();
  $butr_command->setAll(0, Butr\LIST_SIZE_ALL,
    Butr\SORT_DIRECTION_ASCENDING, Butr\SORT_ORDINAL_DEFAULT);
  $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
  $butr_command->prepareCommand();
  $json_global_title_configurations = $butr_command->sendCommand();
  $json_object = json_decode($json_global_title_configurations, false);
  $json_error = json_last_error();
  
  $title_option_list = array();
  if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
    for($i = 0; $i < sizeof($json_object->list_global_title_configurations->items); $i++) {
      if (isset($json_object->list_global_title_configurations->items[$i]->display_label)) {
        $title_option_list[] = "<option value=\""
        . htmlspecialchars($json_object->list_global_title_configurations->items[$i]->uuid, ENT_COMPAT | ENT_HTML5, 'UTF-8')
        . "\">" . htmlspecialchars($json_object->list_global_title_configurations->items[$i]->display_label, ENT_COMPAT | ENT_HTML5, 'UTF-8')
        . "</option>\n";
      } else {
        $title_option_list[] = "<option value=\""
        . htmlspecialchars($json_object->list_global_title_configurations->items[$i]->uuid, ENT_COMPAT | ENT_HTML5, 'UTF-8')
        . "\">" . htmlspecialchars($json_object->list_global_title_configurations->items[$i]->name_label, ENT_COMPAT | ENT_HTML5, 'UTF-8')
        . "</option>\n";
      }
    }
  }
  unset($json_global_title_configurations);
  unset($json_object);
  unset($butr_command);
?>
            <form class="form-inline">
              <fieldset>
                <div class="control-group span4">
                  <label><?php echo gettext('Title'); ?></label>
                  <select name="global_title_uuid" class="span8">
                    <option value=""><?php echo gettext('Please Select'); ?></option>
<?php echo implode($title_option_list, "\n") ?>
                  </select>
                </div><!-- end .control-group -->
                <div class="control-group span4">
                  <label><?php echo gettext('First Name'); ?></label>
                  <input type="text" name="first_name" class="span8">
                </div><!-- end .control-group -->
                <div class="control-group span4">
                  <label><?php echo gettext('Last Name'); ?></label>
                  <input type="text" name="last_name" id="last_name" class="span8">
                </div><!-- end .control-group -->
              </fieldset>
              <fieldset>
                <div class="control-group span12">
                  <a href="javascript:void(0);" id="search_form_submit"
                    class="btn btn-primary"><?php echo gettext('Search'); ?></a>
                </div><!-- end .control-group -->
              </fieldset>
              <div class="control-group span12" id="search_form_results"></div>
            </form>
<?php
}

if ($action_mode === 'add') {
  // Grab global title configuration settings
  $butr_command = new Butr\CommandListGlobalTitleConfigurations();
  $butr_command->setAll(0, Butr\LIST_SIZE_ALL, Butr\SORT_DIRECTION_ASCENDING,
    Butr\SORT_ORDINAL_DEFAULT);
  $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
  $butr_command->prepareCommand();
  $json_global_title_configurations = $butr_command->sendCommand();
  $json_object = json_decode($json_global_title_configurations, false);
  $json_error = json_last_error();

  $title_option_list = array();
  if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
    for($i = 0; $i < sizeof($json_object->list_global_title_configurations->items); $i++) {
      if (isset($json_object->list_global_title_configurations->items[$i]->display_label)) {
        $title_option_list[] = "<option value=\""
          . htmlspecialchars($json_object->list_global_title_configurations->items[$i]->uuid, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . "\">" . htmlspecialchars($json_object->list_global_title_configurations->items[$i]->display_label, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . "</option>\n";
      } else {
        $title_option_list[] = "<option value=\""
          . htmlspecialchars($json_object->list_global_title_configurations->items[$i]->uuid, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . "\">" . htmlspecialchars($json_object->list_global_title_configurations->items[$i]->name_label, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . "</option>\n";
      }
    }
  }
  unset($json_global_title_configurations);
  unset($json_object);
  unset($butr_command);

  // Grab global language configuration settings
  $butr_command = new Butr\CommandListGlobalLanguageConfigurations();
  $butr_command->setAll(0, Butr\LIST_SIZE_ALL,
    Butr\SORT_DIRECTION_ASCENDING, Butr\SORT_ORDINAL_DEFAULT);
  $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
  $butr_command->prepareCommand();
  $json_global_language_configurations = $butr_command->sendCommand();
  $json_object = json_decode($json_global_language_configurations, false);
  $json_error = json_last_error();

  $language_option_list = array();
  if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
    for($i = 0; $i < sizeof($json_object->list_global_language_configurations->items); $i++) {
      if (isset($json_object->list_global_language_configurations->items[$i]->display_label)) {
        $language_option_list[] = "<option value=\""
          . htmlspecialchars($json_object->list_global_language_configurations->items[$i]->uuid, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . "\">" . htmlspecialchars($json_object->list_global_language_configurations->items[$i]->display_label, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . "</option>\n";
      } else {
        $language_option_list[] = "<option value=\""
          . htmlspecialchars($json_object->list_global_language_configurations->items[$i]->uuid, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . "\">" . htmlspecialchars($json_object->list_global_language_configurations->items[$i]->language_name, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . "</option>\n";
      }
    }
  }
  unset($json_global_language_configurations);
  unset($json_object);
  unset($butr_command);
?>
            <form class="form-inline" name="user_user_add_form" method="post">
              <fieldset>
                <div class="control-group span4">
                  <label><?php echo gettext('Title'); ?></label>
                  <select name="global_title_uuid" class="span8">
                    <option value=""><?php echo gettext('Please Select'); ?></option>
<?php echo implode($title_option_list, "\n") ?>
                  </select>
                </div><!-- end .control-group -->
                <div class="control-group span4">
                  <label><?php echo gettext('First Name'); ?></label>
                  <input type="text" name="first_name" class="span8">
                </div><!-- end .control-group -->
                <div class="control-group span4">
                  <label><?php echo gettext('Last Name'); ?></label>
                  <input type="text" name="last_name" id="last_name" class="span8">
                </div><!-- end .control-group -->
              </fieldset>
              <fieldset>
                <div class="control-group span4">
                  <label><?php echo gettext('Username'); ?></label>
                  <input type="text" name="username" class="span8">
                </div><!-- end .control-group -->
                <div class="control-group span8">
                  <label><?php echo gettext('Preferred Language'); ?></label>
                  <select name="preferred_global_language_uuid" class="span10">
                    <option value=""><?php echo gettext('Please Select'); ?></option>
<?php echo implode($language_option_list, "\n") ?>
                  </select>
                </div><!-- end .control-group -->
              </fieldset>
              <fieldset>
                <div class="control-group span12">
                  <a href="javascript:void(0);" id="add_submit" type="submit"
                    onclick="javascript:processUserUserAddForm();"
                    class="btn btn-primary"><?php echo gettext('Add User'); ?></a>
                </div><!-- end .control-group -->
              </fieldset>
              <div class="control-group span12" id="search_form_results"></div>
            </form>
<?php
} elseif ($action_mode === 'edit') {
  // Grab global title configuration settings
  $butr_command = new Butr\CommandListGlobalTitleConfigurations();
  $butr_command->setAll(0, Butr\LIST_SIZE_ALL, Butr\SORT_DIRECTION_ASCENDING,
    Butr\SORT_ORDINAL_DEFAULT);
  $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
  $butr_command->prepareCommand();
  $json_global_title_configurations = $butr_command->sendCommand();
  $json_object = json_decode($json_global_title_configurations, false);
  $json_error = json_last_error();
  
  $title_option_list = array();
  if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
    for($i = 0; $i < sizeof($json_object->list_global_title_configurations->items); $i++) {
      if (isset($json_object->list_global_title_configurations->items[$i]->display_label)) {
        $title_option_list[] = "<option value=\""
          . htmlspecialchars($json_object->list_global_title_configurations->items[$i]->uuid, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . "\">" . htmlspecialchars($json_object->list_global_title_configurations->items[$i]->display_label, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . "</option>\n";
      } else {
        $title_option_list[] = "<option value=\""
          . htmlspecialchars($json_object->list_global_title_configurations->items[$i]->uuid, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . "\">" . htmlspecialchars($json_object->list_global_title_configurations->items[$i]->name_label, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . "</option>\n";
      }
    }
  }
  unset($json_global_title_configurations);
  unset($json_object);
  unset($butr_command);
  
  // Grab global language configuration settings
  $butr_command = new Butr\CommandListGlobalLanguageConfigurations();
  $butr_command->setAll(0, Butr\LIST_SIZE_ALL, Butr\SORT_DIRECTION_ASCENDING,
    Butr\SORT_ORDINAL_DEFAULT);
  $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
  $butr_command->prepareCommand();
  $json_global_language_configurations = $butr_command->sendCommand();
  $json_object = json_decode($json_global_language_configurations, false);
  $json_error = json_last_error();
  
  $language_option_list = array();
  if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
    for($i = 0; $i < sizeof($json_object->list_global_language_configurations->items); $i++) {
      if (isset($json_object->list_global_language_configurations->items[$i]->display_label)) {
        $language_option_list[] = "<option value=\""
          . htmlspecialchars($json_object->list_global_language_configurations->items[$i]->uuid, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . "\">" . htmlspecialchars($json_object->list_global_language_configurations->items[$i]->display_label, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . "</option>\n";
      } else {
        $language_option_list[] = "<option value=\""
          . htmlspecialchars($json_object->list_global_language_configurations->items[$i]->uuid, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . "\">" . htmlspecialchars($json_object->list_global_language_configurations->items[$i]->language_name, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . "</option>\n";
      }
    }
  }
  unset($json_global_language_configurations);
  unset($json_object);
  unset($butr_command);
  
  // Fetch user
  $butr_command = new Butr\CommandFetchUser();
  $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
  $butr_command->setUuid($user_uuid);
  $butr_command->prepareCommand();
  $json_user = $butr_command->sendCommand();
  $json_object = json_decode($json_user, false);
  $json_error = json_last_error();
  
  $user = array();
  if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
    $user['uuid'] = (isset($json_object->fetch_user->uuid)) ? $json_object->fetch_user->uuid : '';
    $user['global_title_uuid'] = (isset($json_object->fetch_user->global_title_uuid)) ? $json_object->fetch_user->global_title_uuid : '';
    $user['first_name'] = (isset($json_object->fetch_user->first_name)) ? $json_object->fetch_user->first_name : '';
    $user['last_name'] = (isset($json_object->fetch_user->first_name)) ? $json_object->fetch_user->last_name : '';
    $user['preferred_global_language_uuid'] = (isset($json_object->fetch_user->preferred_global_language_uuid)) ? $json_object->fetch_user->preferred_global_language_uuid : '';
    $user['username'] = (isset($json_object->fetch_user->username)) ? $json_object->fetch_user->username : '';

    // Escpe output
    $user['uuid'] = htmlspecialchars($user['uuid'], ENT_COMPAT | ENT_HTML5, 'UTF-8');
    $user['global_title_uuid'] = htmlspecialchars($user['global_title_uuid'], ENT_COMPAT | ENT_HTML5, 'UTF-8');
    $user['first_name'] = htmlspecialchars($user['first_name'], ENT_COMPAT | ENT_HTML5, 'UTF-8');
    $user['last_name'] = htmlspecialchars($user['last_name'], ENT_COMPAT | ENT_HTML5, 'UTF-8');
    $user['preferred_global_language_uuid'] = htmlspecialchars($user['preferred_global_language_uuid'], ENT_COMPAT | ENT_HTML5, 'UTF-8');
    $user['username'] = htmlspecialchars($user['username'], ENT_COMPAT | ENT_HTML5, 'UTF-8');
  }
  unset($json_object);
  unset($butr_command);
?>
            <form class="form-inline" name="user_user_modify_form" method="post">
              <fieldset>
                <div class="control-group span4">
                  <label><?php echo gettext('Title'); ?></label>
                  <select name="global_title_uuid" class="span8">
                    <option value=""><?php echo gettext('Please Select'); ?></option>
<?php echo implode($title_option_list, "\n") ?>
                  </select>
                </div><!-- end .control-group -->
                <div class="control-group span4">
                  <label><?php echo gettext('First Name'); ?></label>
                  <input type="text" name="first_name" class="span8" value="<?php echo $user['first_name']; ?>">
                </div><!-- end .control-group -->
                <div class="control-group span4">
                  <label><?php echo gettext('Last Name'); ?></label>
                  <input type="text" name="last_name" id="last_name" class="span8" value="<?php echo $user['last_name']; ?>">
                </div><!-- end .control-group -->
              </fieldset>
              <fieldset>
                <div class="control-group span4">
                  <label><?php echo gettext('Username'); ?></label>
                  <input type="text" name="username" class="span8" value="<?php echo $user['username']; ?>">
                </div><!-- end .control-group -->
                <div class="control-group span8">
                  <label><?php echo gettext('Preferred Language'); ?></label>
                  <select name="preferred_global_language_uuid" class="span10">
                    <option value=""><?php echo gettext('Please Select'); ?></option>
<?php echo implode($language_option_list, "\n") ?>
                  </select>
                </div><!-- end .control-group -->
              </fieldset>
              <fieldset>
                <div class="control-group span12">
                  <a href="javascript:void(0);" id="modify_submit" type="submit"
                    onclick="javascript:processUserUserModifyForm();"
                    class="btn btn-primary"><?php echo gettext('Modify User'); ?></a>
                </div><!-- end .control-group -->
              </fieldset>
              <div class="control-group span12" id="search_form_results"></div>
            </form>
            <script type="text/javascript">
              document.user_user_modify_form.global_title_uuid.value = '<?php echo $user['global_title_uuid']; ?>';
              document.user_user_modify_form.preferred_global_language_uuid.value = '<?php echo $user['preferred_global_language_uuid']; ?>';
            </script>
<?php
} elseif ($action_mode === 'list') {
  $alternate = true;
  $default_list_size = Butr\DEFAULT_LIST_SIZE;
  
  // Fetch global default_list_size configuration value
  $butr_command = new Butr\CommandFetchGlobalConfiguration();
  $butr_command->setMagic('default_list_size');
  $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
  $butr_command->setUuid($message_uuid);
  $butr_command->prepareCommand();
  $json_global_configuration = $butr_command->sendCommand();
  $json_object = json_decode($json_global_configuration, false);
  $json_error = json_last_error();
  
  if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
    $default_list_size = (isset($json_object->fetch_global_configuration->effective_setting)) ? $json_object->fetch_global_configuration->effective_setting : Butr\DEFAULT_LIST_SIZE;
  }
  
  unset($json_global_configuration);
  unset($json_object);
  unset($butr_command);
  
  $ordinal = isset($_POST['ordinal']) ? $_POST['ordinal'] : '';
  if ($ordinal === '') {
    $ordinal = isset($_GET['ordinal']) ? $_GET['ordinal'] : Butr\SORT_ORDINAL_DEFAULT;
  }
  $size = isset($_POST['size']) ? $_POST['size'] : -2;
  if ($size === -2) {
    $size = isset($_GET['size']) ? $_GET['size'] : $default_list_size;
  }
  $direction = isset($_POST['direction']) ? $_POST['direction'] : '';
  if ($direction === '') {
    $direction = isset($_GET['direction']) ? $_GET['direction'] : Butr\SORT_DIRECTION_ASCENDING;
  }
  $offset = isset($_POST['offset']) ? $_POST['offset'] : -1;
  if ($offset === -1) {
    $offset = isset($_GET['offset']) ? $_GET['offset'] : 0;
  }
  
  // Grab users
  $butr_command = new Butr\CommandListUsers();
  $butr_command->setAll($offset, $size, $direction, $ordinal);
  $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
  $butr_command->prepareCommand();
  $json_users = $butr_command->sendCommand();
  $json_object = json_decode($json_users, false);
  $json_error = json_last_error();
  
  if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
    $total_count = $json_object->list_users->total_count;
  }
  
  if ($total_count == '' || !isset($total_count)) {
    $total_count = 0;
  }
  
  $butr_pagination = new Butr\PagePagination();
  $butr_pagination->setAll($total_count, $size, $offset, $ordinal, $direction, $language_code,
      Butr\PAGINATION_TYPE_PAGE, 'setHistoryUserUserList');
  $butr_pagination->preparePagination();
?>
            <table class="table table-striped tablesorter">
              <thead>
                <tr>
                  <th><input type="checkbox" name="user_user_list_all"></th>
                  <th><?php echo gettext('Title'); ?></th>
                  <th><?php echo gettext('First Name'); ?></th>
                  <th><?php echo gettext('Last Name'); ?></th>
                  <th><?php echo gettext('Action'); ?></th>
                </tr>
              </thead>
              <tbody>
<?php
if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
  for($i = 0; $i < sizeof($json_object->list_users->items); $i++) {
?>
                <tr>
                  <td><input type="checkbox" name="list_item[]" value="<?php echo htmlspecialchars($json_object->list_users->items[$i]->uuid, ENT_COMPAT | ENT_HTML5, 'UTF-8'); ?>">
                  <td><?php echo htmlspecialchars($json_object->list_users->items[$i]->title_label, ENT_COMPAT | ENT_HTML5, 'UTF-8'); ?></td>
                  <td><?php echo htmlspecialchars($json_object->list_users->items[$i]->first_name, ENT_COMPAT | ENT_HTML5, 'UTF-8'); ?></td>
                  <td><?php echo htmlspecialchars($json_object->list_users->items[$i]->last_name, ENT_COMPAT | ENT_HTML5, 'UTF-8'); ?></td>
                  <td><a href="javascript:setHistoryUserUserFetch('<?php echo htmlspecialchars($json_object->list_users->items[$i]->uuid, ENT_COMPAT | ENT_HTML5, 'UTF-8'); ?>');"
                    title="<?php echo gettext('Modify'); ?>"><i class="icon-edit"></i></a></td>
                </tr>
<?php
  }
}
unset($json_users);
unset($json_object);
unset($butr_command);
?>  
              </tbody>
            </table>
<?php
  $butr_pagination->generatePagination();
}
