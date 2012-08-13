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

$language_code = isset($_POST['language']) ? $_POST['language'] : Butr\DEFAULT_LANGUAGE; // or read from butrSession json object
$action_mode = '';
$window_name = (isset($_POST['window_name'])) ? $_POST['window_name'] : '';
$session_token = fetchSessionCookie($window_name);

$dock_tab_uuid = '';
$dock_tab_uuid = (isset($_POST['uuid'])) ? $_POST['uuid'] : '';
if ($dock_tab_uuid === '' && isset($_GET['uuid'])) {
  $dock_tab_uuid = $_GET['uuid'];
}

$butr_authentication = new Butr\Authentication();
$butr_authentication->setSessionToken($session_token);

// Instantiate page fragment class for templated presentation.
$butr_page_fragment = new Butr\PageFragment();

// Generate the top part of the page fragment including buffering output.
$butr_page_fragment->generateHtmlTop(array('system_dock_tab.js'), array('system_dock_tab.css'), $language_code);

if (isset($_POST['a'])) {
  switch ($_POST['a']) {
    case 'add':
      echo "<script type=\"text/javascript\">setHistorySystemDockTabAdd();</script>\n";
      $action_mode = 'add';
      break;
    case 'fetch':
      $action_mode = 'fetch';
      break;
    case 'list':
      $action_mode = 'list';
      break;
    default:
      echo "<script type=\"text/javascript\">setHistorySystemDockTab();</script>\n";
      $action_mode = '';
      break;
  }
} else {
  // Same as default in the switch case above.
  echo "<script type=\"text/javascript\">setHistorySystemDockTab();</script>\n";
  $action_mode = '';
}
 
if ($action_mode === 'add') {
  // Grab security client type configuration settings
  $butr_command = new Butr\CommandListSecurityClientTypeConfigurations();
  $butr_command->setAll(0, -1, Butr\SORT_DIRECTION_ASCENDING, Butr\SORT_ORDINAL_DEFAULT);
  $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
  $butr_command->prepareCommand();
  $json_security_client_type_configurations = $butr_command->sendCommand();
  $json_object = json_decode($json_security_client_type_configurations, false);
  $json_error = json_last_error();

  $security_client_type_option_list = array();
  if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
    for($i = 0; $i < sizeof($json_object->list_security_client_type_configurations->items); $i++) {
      if (isset($json_object->list_security_client_type_configurations->items[$i]->display_label)) {
        $security_client_type_option_list[] = "<option value=\""
          . htmlspecialchars($json_object->list_security_client_type_configurations->items[$i]->uuid, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . "\">" . htmlspecialchars($json_object->list_security_client_type_configurations->items[$i]->display_label, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . "</option>\n";
      } else {
        $security_client_type_option_list[] = "<option value=\""
          . htmlspecialchars($json_object->list_security_client_type_configurations->items[$i]->uuid, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . "\">" . htmlspecialchars($json_object->list_security_client_type_configurations->items[$i]->name_label, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . "</option>\n";
      }
    }
  }
  unset($json_security_client_type_configurations);
  unset($json_object);
  unset($butr_command);
  
  // Grab system dock type configuration settings
  $butr_command = new Butr\CommandListSystemDockTypeConfigurations();
  $butr_command->setAll(0, -1, Butr\SORT_DIRECTION_ASCENDING, Butr\SORT_ORDINAL_DEFAULT);
  $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
  $butr_command->prepareCommand();
  $json_system_dock_type_configurations = $butr_command->sendCommand();
  $json_object = json_decode($json_system_dock_type_configurations, false);
  $json_error = json_last_error();
  
  $system_dock_type_option_list = array();
  if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
    for($i = 0; $i < sizeof($json_object->list_system_dock_type_configurations->items); $i++) {
      if (isset($json_object->list_system_dock_type_configurations->items[$i]->display_label)) {
        $system_dock_type_option_list[] = "<option value=\""
          . htmlspecialchars($json_object->list_system_dock_type_configurations->items[$i]->uuid, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . "\">" . htmlspecialchars($json_object->list_system_dock_type_configurations->items[$i]->display_label, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . "</option>\n";
      } else {
        $system_dock_type_option_list[] = "<option value=\""
          . htmlspecialchars($json_object->list_system_dock_type_configurations->items[$i]->uuid, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . "\">" . htmlspecialchars($json_object->list_system_dock_type_configurations->items[$i]->name_label, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . "</option>\n";
      }
    }
  }
  unset($json_system_dock_type_configurations);
  unset($json_object);
  unset($butr_command);
  
  // Grab dock items
  $butr_command = new Butr\CommandListDockItems();
  $butr_command->setAll(0, -1, Butr\SORT_DIRECTION_ASCENDING, Butr\SORT_ORDINAL_DEFAULT);
  $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
  $butr_command->prepareCommand();
  $json_dock_items = $butr_command->sendCommand();
  $json_object = json_decode($json_dock_items, false);
  $json_error = json_last_error();
  
  $dock_item_option_list = array();
  if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
    for($i = 0; $i < sizeof($json_object->list_dock_items->items); $i++) {
      if (isset($json_object->list_dock_items->items[$i]->display_name)) {
        $dock_item_option_list[] = "<option value=\""
          . htmlspecialchars($json_object->list_dock_items->items[$i]->uuid, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . "\">" . htmlspecialchars($json_object->list_dock_items->items[$i]->display_name, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . " (" .htmlspecialchars( $json_object->list_dock_items->items[$i]->security_client_type_label, ENT_COMPAT | ENT_HTML5, 'UTF-8') . ")"
          . "</option>\n";
      } else {
        $dock_item_option_list[] = "<option value=\""
          . htmlspecialchars($json_object->list_dock_items->items[$i]->uuid, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . "\">" . htmlspecialchars($json_object->list_dock_items->items[$i]->item_name, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . " (" . htmlspecialchars($json_object->list_dock_items->items[$i]->security_client_type_label, ENT_COMPAT | ENT_HTML5, 'UTF-8') . ")"
          . "</option>\n";
      }
    }
  }
  unset($json_dock_items);
  unset($json_object);
  unset($butr_command);
  
  // Grab dock subitems
  $butr_command = new Butr\CommandListDockSubitems();
  $butr_command->setAll(0, -1, Butr\SORT_DIRECTION_ASCENDING, Butr\SORT_ORDINAL_DEFAULT);
  $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
  $butr_command->prepareCommand();
  $json_dock_subitems = $butr_command->sendCommand();
  $json_object = json_decode($json_dock_subitems, false);
  $json_error = json_last_error();
  
  $dock_subitem_option_list = array();
  if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
    for($i = 0; $i < sizeof($json_object->list_dock_subitems); $i++) {
      if (isset($json_object->list_dock_subitems->items[$i]->display_name)) {
        $dock_subitem_option_list[] = "<option value=\""
          . htmlspecialchars($json_object->list_dock_subitems->items[$i]->uuid, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . "\">" . htmlspecialchars($json_object->list_dock_subitems->items[$i]->display_name, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . " (" . htmlspecialchars($json_object->list_dock_subitems->items[$i]->security_client_type_label, ENT_COMPAT | ENT_HTML5, 'UTF-8') . ")"
        . "</option>\n";
      } else {
        $dock_subitem_option_list[] = "<option value=\""
          . htmlspecialchars($json_object->list_dock_subitems->items[$i]->uuid, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . "\">" . htmlspecialchars($json_object->list_dock_subitems->items[$i]->dock_name, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . " (" . htmlspecialchars($json_object->list_dock_subitems->items[$i]->security_client_type_label, ENT_COMPAT | ENT_HTML5, 'UTF-8') . ")"
          . "</option>\n";
      }
    }
  }
  unset($json_dock_subitems);
  unset($json_object);
  unset($butr_command);
?>
<h1><?php echo gettext('Dock Tab Administration'); ?></h1>
<div id="system_dock_tab_add_box">
  <fieldset form="system_dock_tab_add_form" name="system_dock_tab_add_fieldset" id="system_dock_tab_add_fieldset">
    <legend><?php echo gettext('Add Dock Tab'); ?></legend>
    <form name="system_dock_tab_add_form" method="post" onsubmit="javascript:return processSystemDockTabAddForm();">
      <label for="dock_item_uuid" id="dock_item_uuid"><?php echo gettext('Dock Item'); ?>:</label>
      <select name="dock_item_uuid">
        <option value=""><?php echo gettext('Please Select'); ?></option>
<?php echo implode($dock_item_option_list, "\n") ?>
      </select><br>
      <label for="dock_subitem_uuid" id="dock_subitem_uuid"><?php echo gettext('Dock Subitem'); ?>:</label>
      <select name="dock_subitem_uuid">
        <option value=""><?php echo gettext('Please Select'); ?></option>
<?php echo implode($dock_subitem_option_list, "\n") ?>
      </select><br>
      <label for="system_dock_type_uuid" id="system_dock_type_uuid"><?php echo gettext('System Dock Type'); ?>:</label>
      <select name="system_dock_type_uuid">
        <option value=""><?php echo gettext('Please Select'); ?></option>
<?php echo implode($system_dock_type_option_list, "\n") ?>
      </select><br>
      <label for="security_client_type_uuid" id="security_client_type_uuid"><?php echo gettext('Security Client Type'); ?>:</label>
      <select name="security_client_type_uuid">
        <option value=""><?php echo gettext('Please Select'); ?></option>
<?php echo implode($security_client_type_option_list, "\n") ?>
      </select><br>
      <label for="tab_name" id="tab_name_label"><?php echo gettext('Tab Name'); ?>:</label>
      <input type="text" name="tab_name" id="tab_name" value=""><br>
      <label for="display_name" id="display_name_label"><?php echo gettext('Display Name'); ?>:</label>
      <input type="text" name="Display_name" id="display_name" value=""><br>
      <label for="description" id="description_label"><?php echo gettext('Description'); ?>:</label>
      <textarea name="description" id="description"></textarea><br>
      <label for="weighting" id="weighting_label"><?php echo gettext('Weighting'); ?>:</label>
      <input type="text" name="weighting" id="weighting" value=""><br>
      <label for="picture_path" id="picture_path_label"><?php echo gettext('Picture Path'); ?>:</label>
      <input type="text" name="picture_path" id="picture_path" value=""><br>
      <label for="tab_action" id="tab_action_label"><?php echo gettext('Tab Action'); ?>:</label>
      <input type="text" name="tab_action" id="tab_action" value=""><br>
      <label for="is_active" id="is_active_label"><?php echo gettext('Is Active'); ?>:</label>
      <input type="checkbox" name="is_active" id="is_active" value="1" checked><br>
      <label for="submit">&nbsp;</label>
      <button type="submit" name="submit" id="submit"><?php echo gettext('Add Dock Tab'); ?></button>      
    </form>
  </fieldset>
</div><!-- /#system_dock_tab_add_box -->

<?php
} elseif ($action_mode === 'fetch') {
  // Grab security client type configuration settings
  $butr_command = new Butr\CommandListSecurityClientTypeConfigurations();
  $butr_command->setAll(0, -1, Butr\SORT_DIRECTION_ASCENDING, Butr\SORT_ORDINAL_DEFAULT);
  $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
  $butr_command->prepareCommand();
  $json_security_client_type_configurations = $butr_command->sendCommand();
  $json_object = json_decode($json_security_client_type_configurations, false);
  $json_error = json_last_error();

  $security_client_type_option_list = array();
  if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
    for($i = 0; $i < sizeof($json_object->list_security_client_type_configurations->items); $i++) {
      if (isset($json_object->list_security_client_type_configurations->items[$i]->display_label)) {
        $security_client_type_option_list[] = "<option value=\""
          . htmlspecialchars($json_object->list_security_client_type_configurations->items[$i]->uuid, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . "\">" . htmlspecialchars($json_object->list_security_client_type_configurations->items[$i]->display_label, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . "</option>\n";
      } else {
        $security_client_type_option_list[] = "<option value=\""
          . htmlspecialchars($json_object->list_security_client_type_configurations->items[$i]->uuid, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . "\">" . htmlspecialchars($json_object->list_security_client_type_configurations->items[$i]->name_label, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . "</option>\n";
      }
    }
  }
  unset($json_security_client_type_configurations);
  unset($json_object);
  unset($butr_command);
  
  // Grab system dock type configuration settings
  $butr_command = new Butr\CommandListSystemDockTypeConfigurations();
  $butr_command->setAll(0, -1, Butr\SORT_DIRECTION_ASCENDING, Butr\SORT_ORDINAL_DEFAULT);
  $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
  $butr_command->prepareCommand();
  $json_system_dock_type_configurations = $butr_command->sendCommand();
  $json_object = json_decode($json_system_dock_type_configurations, false);
  $json_error = json_last_error();
  
  $system_dock_type_option_list = array();
  if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
    for($i = 0; $i < sizeof($json_object->list_system_dock_type_configurations->items); $i++) {
      if (isset($json_object->list_system_dock_type_configurations->items[$i]->display_label)) {
        $system_dock_type_option_list[] = "<option value=\""
          . htmlspecialchars($json_object->list_system_dock_type_configurations->items[$i]->uuid, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . "\">" . htmlspecialchars($json_object->list_system_dock_type_configurations->items[$i]->display_label, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . "</option>\n";
      } else {
        $system_dock_type_option_list[] = "<option value=\""
          . htmlspecialchars($json_object->list_system_dock_type_configurations->items[$i]->uuid, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . "\">" . htmlspecialchars($json_object->list_system_dock_type_configurations->items[$i]->name_label, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . "</option>\n";
      }
    }
  }
  unset($json_system_dock_type_configurations);
  unset($json_object);
  unset($butr_command);
  
  // Grab dock items
  $butr_command = new Butr\CommandListDockItems();
  $butr_command->setAll(0, -1, Butr\SORT_DIRECTION_ASCENDING, Butr\SORT_ORDINAL_DEFAULT);
  $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
  $butr_command->prepareCommand();
  $json_dock_items = $butr_command->sendCommand();
  $json_object = json_decode($json_dock_items, false);
  $json_error = json_last_error();
  
  $dock_item_option_list = array();
  if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
    for($i = 0; $i < sizeof($json_object->list_dock_items->items); $i++) {
      if (isset($json_object->list_dock_items->items[$i]->display_name)) {
        $dock_item_option_list[] = "<option value=\""
          . htmlspecialchars($json_object->list_dock_items->items[$i]->uuid, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . "\">" . htmlspecialchars($json_object->list_dock_items->items[$i]->display_name, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . " (" . htmlspecialchars($json_object->list_dock_items->items[$i]->security_client_type_label, ENT_COMPAT | ENT_HTML5, 'UTF-8') . ")"
          . "</option>\n";
      } else {
        $dock_item_option_list[] = "<option value=\""
          . htmlspecialchars($json_object->list_dock_items->items[$i]->uuid, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . "\">" . htmlspecialchars($json_object->list_dock_items->items[$i]->item_name, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . " (" . htmlspecialchars($json_object->list_dock_items->items[$i]->security_client_type_label, ENT_COMPAT | ENT_HTML5, 'UTF-8') . ")"
          . "</option>\n";
      }
    }
  }
  unset($json_dock_items);
  unset($json_object);
  unset($butr_command);
  
  // Grab dock subitems
  $butr_command = new Butr\CommandListDockSubitems();
  $butr_command->setAll(0, -1, Butr\SORT_DIRECTION_ASCENDING, Butr\SORT_ORDINAL_DEFAULT);
  $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
  $butr_command->prepareCommand();
  $json_dock_subitems = $butr_command->sendCommand();
  $json_object = json_decode($json_dock_subitems, false);
  $json_error = json_last_error();
  
  $dock_subitem_option_list = array();
  if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
    for($i = 0; $i < sizeof($json_object->list_dock_subitems->items); $i++) {
      if (isset($json_object->list_dock_subitems->items[$i]->display_name)) {
        $dock_subitem_option_list[] = "<option value=\""
          . htmlspecialchars($json_object->list_dock_subitems->items[$i]->uuid, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . "\">" . htmlspecialchars($json_object->list_dock_subitems->items[$i]->display_name, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . " (" . htmlspecialchars($json_object->list_dock_subitems->items[$i]->security_client_type_label, ENT_COMPAT | ENT_HTML5, 'UTF-8') . ")"
          . "</option>\n";
      } else {
        $dock_subitem_option_list[] = "<option value=\""
          . htmlspecialchars($json_object->list_dock_subitems->items[$i]->uuid, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . "\">" . htmlspecialchars($json_object->list_dock_subitems->items[$i]->dock_name, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . " (" . htmlspecialchars($json_object->list_dock_subitems->items[$i]->security_client_type_label, ENT_COMPAT | ENT_HTML5, 'UTF-8') . ")"
          . "</option>\n";
      }
    }
  }
  unset($json_dock_subitems);
  unset($json_object);
  unset($butr_command);
  
  // Fetch dock tab
  $butr_command = new Butr\CommandFetchDockTab();
  $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
  $butr_command->setUuid($dock_tab_uuid);
  $butr_command->prepareCommand();
  $json_dock_tab = $butr_command->sendCommand();
  $json_object = json_decode($json_dock_tab, false);
  $json_error = json_last_error();
  
  $dockTab = array();
  if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
    $dockTab['uuid'] = (isset($json_object->fetch_dock_tab->uuid)) ? $json_object->fetch_dock_tab->uuid : '';
    $dockTab['system_dock_type_uuid'] = (isset($json_object->fetch_dock_tab->system_dock_type_uuid)) ? $json_object->fetch_dock_tab->system_dock_type_uuid : '';
    $dockTab['dock_item_uuid'] = (isset($json_object->fetch_dock_tab->dock_item_uuid)) ? $json_object->fetch_dock_tab->dock_item_uuid : '';
    $dockTab['dock_subitem_uuid'] = (isset($json_object->fetch_dock_tab->dock_subitem_uuid)) ? $json_object->fetch_dock_tab->dock_subitem_uuid : '';
    $dockTab['security_client_type_uuid'] = (isset($json_object->fetch_dock_tab->security_client_type_uuid)) ? $json_object->fetch_dock_tab->security_client_type_uuid : '';
    $dockTab['tab_name'] = (isset($json_object->fetch_dock_tab->tab_name)) ? $json_object->fetch_dock_tab->tab_name : '';
    $dockTab['display_name'] = (isset($json_object->fetch_dock_tab->display_name)) ? $json_object->fetch_dock_tab->display_name : '';
    $dockTab['description'] = (isset($json_object->fetch_dock_tab->description)) ? $json_object->fetch_dock_tab->description : '';
    $dockTab['weighting'] = (isset($json_object->fetch_dock_tab->weighting)) ? $json_object->fetch_dock_tab->weighting : '';
    $dockTab['picture_path'] = (isset($json_object->fetch_dock_tab->picture_path)) ? $json_object->fetch_dock_tab->picture_path : '';
    $dockTab['tab_action'] = (isset($json_object->fetch_dock_tab->tab_action)) ? $json_object->fetch_dock_tab->tab_action : '';
    $dockTab['is_actve'] = (isset($json_object->fetch_dock_tab->is_active)) ? $json_object->fetch_dock_tab->is_active : '';

    // Escape output
    $dockTab['uuid'] = htmlspecialchars($dockTab['uuid'], ENT_COMPAT | ENT_HTML5, 'UTF-8');
    $dockTab['system_dock_type_uuid'] = htmlspecialchars($dockTab['system_dock_type_uuid'], ENT_COMPAT | ENT_HTML5, 'UTF-8');
    $dockTab['dock_item_uuid'] = htmlspecialchars($dockTab['dock_item_uuid'], ENT_COMPAT | ENT_HTML5, 'UTF-8');
    $dockTab['dock_subitem_uuid'] = htmlspecialchars($dockTab['dock_subitem_uuid'], ENT_COMPAT | ENT_HTML5, 'UTF-8');
    $dockTab['security_client_type_uuid'] = htmlspecialchars($dockTab['security_client_type_uuid'], ENT_COMPAT | ENT_HTML5, 'UTF-8');
    $dockTab['tab_name'] = htmlspecialchars($dockTab['tab_name'], ENT_COMPAT | ENT_HTML5, 'UTF-8');
    $dockTab['display_name'] = htmlspecialchars($dockTab['display_name'], ENT_COMPAT | ENT_HTML5, 'UTF-8');
    $dockTab['description'] = htmlspecialchars($dockTab['description'], ENT_NOQUOTES | ENT_HTML5, 'UTF-8');
    $dockTab['weighting'] = htmlspecialchars($dockTab['weighting'], ENT_COMPAT | ENT_HTML5, 'UTF-8');
    $dockTab['picture_path'] = htmlspecialchars($dockTab['picture_path'], ENT_COMPAT | ENT_HTML5, 'UTF-8');
    $dockTab['tab_action'] = htmlspecialchars($dockTab['tab_action'], ENT_COMPAT | ENT_HTML5, 'UTF-8');
  }
    
  unset($json_dock_tab);
  unset($json_object);
  unset($butr_command);
?>
<h1><?php echo gettext('Dock Tab Administration'); ?></h1>
<div id="system_dock_tab_modify_box">
  <fieldset form="system_dock_tab_modify_form" name="system_dock_tab_modify_fieldset" id="system_dock_tab_modify_fieldset">
    <legend><?php echo gettext('Modify Dock Tab'); ?></legend>
    <form name="system_dock_tab_modify_form" method="post" onsubmit="javascript:return processSystemDockTabModifyForm();">
      <label for="dock_item_uuid" id="dock_item_uuid"><?php echo gettext('Dock Item'); ?>:</label>
      <select name="dock_item_uuid">
        <option value=""><?php echo gettext('Please Select'); ?></option>
<?php echo implode($dock_item_option_list, "\n") ?>
      </select><br>
      <label for="dock_subitem_uuid" id="dock_subitem_uuid"><?php echo gettext('Dock Subitem'); ?>:</label>
      <select name="dock_subitem_uuid">
        <option value=""><?php echo gettext('Please Select'); ?></option>
<?php echo implode($dock_subitem_option_list, "\n") ?>
      </select><br>
      <label for="system_dock_type_uuid" id="system_dock_type_uuid"><?php echo gettext('System Dock Type'); ?>:</label>
      <select name="system_dock_type_uuid">
        <option value=""><?php echo gettext('Please Select'); ?></option>
<?php echo implode($system_dock_type_option_list, "\n") ?>
      </select><br>
      <label for="security_client_type_uuid" id="security_client_type_uuid"><?php echo gettext('Security Client Type'); ?>:</label>
      <select name="security_client_type_uuid">
        <option value=""><?php echo gettext('Please Select'); ?></option>
<?php echo implode($security_client_type_option_list, "\n") ?>
      </select><br>
      <label for="tab_name" id="tab_name_label"><?php echo gettext('Tab Name'); ?>:</label>
      <input type="text" name="tab_name" id="tab_name" value="<?php echo $dockTab['tab_name']; ?>"><br>
      <label for="display_name" id="display_name_label"><?php echo gettext('Display Name'); ?>:</label>
      <input type="text" name="Display_name" id="display_name" value="<?php echo $dockTab['display_name']; ?>"><br>
      <label for="description" id="description_label"><?php echo gettext('Description'); ?>:</label>
      <textarea name="description" id="description"><?php echo $dockTab['description']; ?></textarea><br>
      <label for="weighting" id="weighting_label"><?php echo gettext('Weighting'); ?>:</label>
      <input type="text" name="weighting" id="weighting" value="<?php echo $dockTab['weighting']; ?>"><br>
      <label for="picture_path" id="picture_path_label"><?php echo gettext('Picture Path'); ?>:</label>
      <input type="text" name="picture_path" id="picture_path" value="<?php echo $dockTab['picture_path']; ?>"><br>
      <label for="tab_action" id="tab_action"><?php echo gettext('Tab Action'); ?>:</label>
      <input type="text" name="tab_action" id="item_action" value="<?php echo $dockTab['tab_action']; ?>"><br>
      <label for="is_active" id="is_active_label"><?php echo gettext('Is Active'); ?>:</label>
      <input type="checkbox" name="is_active" id="is_active" value="1"<?php if ($dockTab['is_actve'] == 1) { echo ' checked'; } ?>><br>
      <label for="submit">&nbsp;</label>
      <button type="submit" name="submit" id="submit"><?php echo gettext('Modify Dock Tab'); ?></button>
      <input type="hidden" name="uuid" value="<?php echo $dockTab['uuid']; ?>">     
    </form>
  </fieldset>
</div><!-- /#system_dock_tab_modify_box -->

<script type="text/javascript">
  document.system_dock_tab_modify_form.dock_item_uuid.value = '<?php echo $dockTab['dock_item_uuid']; ?>';
  document.system_dock_tab_modify_form.dock_subitem_uuid.value = '<?php echo $dockTab['dock_subitem_uuid']; ?>';
  document.system_dock_tab_modify_form.system_dock_type_uuid.value = '<?php echo $dockTab['system_dock_type_uuid']; ?>';
  document.system_dock_tab_modify_form.security_client_type_uuid.value = '<?php echo $dockTab['security_client_type_uuid']; ?>';
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
  
  // Grab dock items
  $butr_command = new Butr\CommandListDockTabs();
  $butr_command->setAll($offset, $size, $direction, $ordinal);
  $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
  $butr_command->prepareCommand();
  $json_dock_tabs = $butr_command->sendCommand();
  $json_object = json_decode($json_dock_tabs, false);
  $json_error = json_last_error();
  
  if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
    $total_count = $json_object->list_dock_tabs->total_count;
  }
  
  if ($total_count == '' || !isset($total_count)) {
    $total_count = 0;
  }
  
  $butr_pagination = new Butr\Pagination();
  $butr_pagination->setAll($total_count, $size, $offset, $ordinal, $direction, $language_code,
      Butr\PAGINATION_TYPE_PAGE, 'setHistorySystemDockTabList');
  $butr_pagination->preparePagination();
?>
<h1><?php echo gettext('Dock Tab Administration'); ?></h1>
<table>
  <thead>
    <tr>
      <th><?php echo gettext('Dock Item'); ?></th>
      <th><?php echo gettext('Dock Subitem'); ?></th>
      <th><?php echo gettext('System Dock Type'); ?></th>
      <th><?php echo gettext('Security Client Type'); ?></th>
      <th><?php echo gettext('Tab Name'); ?></th>
      <th><?php echo gettext('Action'); ?></th>
    </tr>
  </thead>
  <tbody>
<?php
if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
  for($i = 0; $i < sizeof($json_object->list_dock_tabs->items); $i++) {
?>
    <tr class="<?php echo ($alternate = !$alternate) ? 'odd' : 'even'; ?>">
      <td><?php echo htmlspecialchars($json_object->list_dock_tabs->items[$i]->dock_item_name, ENT_COMPAT | ENT_HTML5, 'UTF-8'); ?></td>
      <td><?php echo htmlspecialchars($json_object->list_dock_tabs->items[$i]->dock_subitem_name, ENT_COMPAT | ENT_HTML5, 'UTF-8'); ?></td>
      <td><?php echo htmlspecialchars($json_object->list_dock_tabs->items[$i]->system_dock_type_label, ENT_COMPAT | ENT_HTML5, 'UTF-8'); ?></td>
      <td><?php echo htmlspecialchars($json_object->list_dock_tabs->items[$i]->security_client_type_label, ENT_COMPAT | ENT_HTML5, 'UTF-8'); ?></td>
      <td><?php echo htmlspecialchars($json_object->list_dock_tabs->items[$i]->tab_name, ENT_COMPAT | ENT_HTML5, 'UTF-8'); ?></td>
      <td><button onclick="javascript:setHistorySystemDockTabFetch('<?php echo htmlspecialchars($json_object->list_dock_tabs->items[$i]->uuid, ENT_COMPAT | ENT_HTML5, 'UTF-8'); ?>');"><?php echo gettext('Modify'); ?></button></td>
    </tr>
<?php
  }
}
unset($json_dock_tabs);
unset($json_object);
unset($butr_command);
?>  
  </tbody>
</table>
<?php
  $butr_pagination->generatePagination();
} else {
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
?>
<h1><?php echo gettext('Dock Tab Administration'); ?></h1>
<ul>
  <li><a href="javascript:insertContent('system_dock_tab.php?a=add')"><?php echo gettext('Add Dock Tab'); ?></a></li>
  <li><a href="javascript:setHistorySystemDockTabList(0, '<?php echo $default_list_size; ?>', '<?php echo Butr\SORT_ORDINAL_DEFAULT; ?>', '<?php echo Butr\SORT_DIRECTION_ASCENDING; ?>');"><?php echo gettext('List Dock Tabs'); ?></a></li>
</ul>
<?php
}
// Generate bottom part of the page including flushing the buffer.
$butr_page_fragment->generateHtmlBottom();