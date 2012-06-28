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

$dock_subitem_uuid = '';
$dock_subitem_uuid = (isset($_POST['uuid'])) ? $_POST['uuid'] : '';
if ($dock_subitem_uuid === '' && isset($_GET['uuid'])) {
  $dock_subitem_uuid = $_GET['uuid'];
}

$butr_authentication = new Butr\Authentication();
$butr_authentication->setSessionToken($session_token);

// Instantiate page fragment class for templated presentation.
$butr_page_fragment = new Butr\PageFragment();

// Generate the top part of the page fragment including buffering output.
$butr_page_fragment->generateHtmlTop(array('system_dock_subitem.js'), array('system_dock_subitem.css'), $language_code);

if (isset($_POST['a'])) {
  switch ($_POST['a']) {
    case 'add':
      echo "<script type=\"text/javascript\">setHistorySystemDockSubitemAdd();</script>\n";
      $action_mode = 'add';
      break;
    case 'fetch':
      $action_mode = 'fetch';
      break;
    case 'list':
      $action_mode = 'list';
      break;
    default:
      echo "<script type=\"text/javascript\">setHistorySystemDockSubitem();</script>\n";
      $action_mode = '';
      break;
  }
} else {
  // Same as default in the switch case above.
  echo "<script type=\"text/javascript\">setHistorySystemDockSubitem();</script>\n";
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
          . htmlspecialchars($json_object->list_security_client_type_configurations->items[$i]->uuid, ENT_COMPAT | ENT_HTML5)
          . "\">" . htmlspecialchars($json_object->list_security_client_type_configurations->items[$i]->display_label, ENT_COMPAT | ENT_HTML5)
          . "</option>\n";
      } else {
        $security_client_type_option_list[] = "<option value=\""
          . htmlspecialchars($json_object->list_security_client_type_configurations->items[$i]->uuid, ENT_COMPAT | ENT_HTML5)
          . "\">" . htmlspecialchars($json_object->list_security_client_type_configurations->items[$i]->name_label, ENT_COMPAT | ENT_HTML5)
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
          . htmlspecialchars($json_object->list_system_dock_type_configurations->items[$i]->uuid, ENT_COMPAT | ENT_HTML5)
          . "\">" . htmlspecialchars($json_object->list_system_dock_type_configurations->items[$i]->display_label, ENT_COMPAT | ENT_HTML5)
          . "</option>\n";
      } else {
        $system_dock_type_option_list[] = "<option value=\""
          . htmlspecialchars($json_object->list_system_dock_type_configurations->items[$i]->uuid, ENT_COMPAT | ENT_HTML5)
          . "\">" . htmlspecialchars($json_object->list_system_dock_type_configurations->items[$i]->name_label, ENT_COMPAT | ENT_HTML5)
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
          . $json_object->list_dock_items->items[$i]->uuid
          . "\">" . htmlspecialchars($json_object->list_dock_items->items[$i]->display_name, ENT_COMPAT | ENT_HTML5)
          . " (" . htmlspecialchars($json_object->list_dock_items->items[$i]->security_client_type_label, ENT_COMPAT | ENT_HTML5) . ")"
          . "</option>\n";
      } else {
        $dock_item_option_list[] = "<option value=\""
          . $json_object->list_dock_items->items[$i]->uuid
          . "\">" . htmlspecialchars($json_object->list_dock_items->items[$i]->item_name, ENT_COMPAT | ENT_HTML5)
          . " (" . htmlspecialchars($json_object->list_dock_items->items[$i]->security_client_type_label, ENT_COMPAT | ENT_HTML5) . ")"
          . "</option>\n";
      }
    }
  }
  unset($json_dock_items);
  unset($json_object);
  unset($butr_command);
?>
<h1><?php echo gettext('Dock Subitem Administration'); ?></h1>
<div id="system_dock_subitem_add_box">
  <fieldset form="system_dock_subitem_add_form" name="system_dock_subitem_add_fieldset" id="system_dock_subitem_add_fieldset">
    <legend><?php echo gettext('Add Dock Subitem'); ?></legend>
    <form name="system_dock_subitem_add_form" method="post" onsubmit="javascript:return processSystemDockSubitemAddForm();">
      <label for="dock_item_uuid" id="dock_item_uuid"><?php echo gettext('Dock Item'); ?>:</label>
      <select name="dock_item_uuid">
        <option value=""><?php echo gettext('Please Select'); ?></option>
<?php echo implode($dock_item_option_list, "\n") ?>
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
      <label for="subitem_name" id="subitem_name_label"><?php echo gettext('Subitem Name'); ?>:</label>
      <input type="text" name="subitem_name" id="subitem_name" value=""><br>
      <label for="display_name" id="display_name_label"><?php echo gettext('Display Name'); ?>:</label>
      <input type="text" name="Display_name" id="display_name" value=""><br>
      <label for="description" id="description_label"><?php echo gettext('Description'); ?>:</label>
      <textarea name="description" id="description"></textarea><br>
      <label for="weighting" id="weighting_label"><?php echo gettext('Weighting'); ?>:</label>
      <input type="text" name="weighting" id="weighting" value=""><br>
      <label for="picture_path" id="picture_path_label"><?php echo gettext('Picture Path'); ?>:</label>
      <input type="text" name="picture_path" id="picture_path" value=""><br>
      <label for="subitem_action" id="subitem_action_label"><?php echo gettext('Subitem Action'); ?>:</label>
      <input type="text" name="subitem_action" id="item_action" value=""><br>
      <label for="is_active" id="is_active_label"><?php echo gettext('Is Active'); ?>:</label>
      <input type="checkbox" name="is_active" id="is_active" value="1" checked><br>
      <label for="submit">&nbsp;</label>
      <button type="submit" name="submit" id="submit"><?php echo gettext('Add Dock Subitem'); ?></button>      
    </form>
  </fieldset>
</div><!-- /#system_dock_subitem_add_box -->

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
          . htmlspecialchars($json_object->list_security_client_type_configurations->items[$i]->uuid, ENT_COMPAT | ENT_HTML5)
          . "\">" . htmlspecialchars($json_object->list_security_client_type_configurations->items[$i]->display_label, ENT_COMPAT | ENT_HTML5)
          . "</option>\n";
      } else {
        $security_client_type_option_list[] = "<option value=\""
          . htmlspecialchars($json_object->list_security_client_type_configurations->items[$i]->uuid, ENT_COMPAT | ENT_HTML5)
          . "\">" . htmlspecialchars($json_object->list_security_client_type_configurations->items[$i]->name_label, ENT_COMPAT | ENT_HTML5)
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
          . htmlspecialchars($json_object->list_system_dock_type_configurations->items[$i]->uuid, ENT_COMPAT | ENT_HTML5)
          . "\">" . htmlspecialchars($json_object->list_system_dock_type_configurations->items[$i]->display_label, ENT_COMPAT | ENT_HTML5)
          . "</option>\n";
      } else {
        $system_dock_type_option_list[] = "<option value=\""
          . htmlspecialchars($json_object->list_system_dock_type_configurations->items[$i]->uuid, ENT_COMPAT | ENT_HTML5)
          . "\">" . htmlspecialchars($json_object->list_system_dock_type_configurations->items[$i]->name_label, ENT_COMPAT | ENT_HTML5)
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
          . htmlspecialchars($json_object->list_dock_items->items[$i]->uuid, ENT_COMPAT | ENT_HTML5)
          . "\">" . htmlspecialchars($json_object->list_dock_items->items[$i]->display_name, ENT_COMPAT | ENT_HTML5)
          . " (" . htmlspecialchars($json_object->list_dock_items->items[$i]->security_client_type_label, ENT_COMPAT | ENT_HTML5) . ")"
          . "</option>\n";
      } else {
        $dock_item_option_list[] = "<option value=\""
          . htmlspecialchars($json_object->list_dock_items->items[$i]->uuid, ENT_COMPAT | ENT_HTML5)
          . "\">" . htmlspecialchars($json_object->list_dock_items->items[$i]->item_name, ENT_COMPAT | ENT_HTML5)
          . " (" . htmlspecialchars($json_object->list_dock_items->items[$i]->security_client_type_label, ENT_COMPAT | ENT_HTML5) . ")"
          . "</option>\n";
      }
    }
  }
  unset($json_dock_items);
  unset($json_object);
  unset($butr_command);
  
  // Fetch dock subitem
  $butr_command = new Butr\CommandFetchDockSubitem();
  $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
  $butr_command->setUuid($dock_subitem_uuid);
  $butr_command->prepareCommand();
  $json_dock_subitem = $butr_command->sendCommand();
  $json_object = json_decode($json_dock_subitem, false);
  $json_error = json_last_error();
  
  $dockSubitem = array();
  if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
    $dockSubitem['uuid'] = (isset($json_object->fetch_dock_subitem->uuid)) ? $json_object->fetch_dock_subitem->uuid : '';
    $dockSubitem['system_dock_type_uuid'] = (isset($json_object->fetch_dock_subitem->system_dock_type_uuid)) ? $json_object->fetch_dock_subitem->system_dock_type_uuid : '';
    $dockSubitem['dock_item_uuid'] = (isset($json_object->fetch_dock_subitem->dock_item_uuid)) ? $json_object->fetch_dock_subitem->dock_item_uuid : '';
    $dockSubitem['security_client_type_uuid'] = (isset($json_object->fetch_dock_subitem->security_client_type_uuid)) ? $json_object->fetch_dock_subitem->security_client_type_uuid : '';
    $dockSubitem['subitem_name'] = (isset($json_object->fetch_dock_subitem->subitem_name)) ? $json_object->fetch_dock_subitem->subitem_name : '';
    $dockSubitem['display_name'] = (isset($json_object->fetch_dock_subitem->display_name)) ? $json_object->fetch_dock_subitem->display_name : '';
    $dockSubitem['description'] = (isset($json_object->fetch_dock_subitem->description)) ? $json_object->fetch_dock_subitem->description : '';
    $dockSubitem['weighting'] = (isset($json_object->fetch_dock_item->weighting)) ? $json_object->fetch_dock_item->weighting : '';
    $dockSubitem['picture_path'] = (isset($json_object->fetch_dock_subitem->picture_path)) ? $json_object->fetch_dock_subitem->picture_path : '';
    $dockSubitem['subitem_action'] = (isset($json_object->fetch_dock_subitem->subitem_action)) ? $json_object->fetch_dock_subitem->subitem_action : '';
    $dockSubitem['is_actve'] = (isset($json_object->fetch_dock_subitem->is_active)) ? $json_object->fetch_dock_subitem->is_active : '';
    
    // Escape output
    $dockSubitem['uuid'] = htmlspecialchars($dockSubitem['uuid'], ENT_COMPAT | ENT_HTML5);
    $dockSubitem['system_dock_type_uuid'] = htmlspecialchars($dockSubitem['system_dock_type_uuid'], ENT_COMPAT | ENT_HTML5);
    $dockSubitem['dock_item_uuid'] = htmlspecialchars($dockSubitem['dock_item_uuid'], ENT_COMPAT | ENT_HTML5);
    $dockSubitem['security_client_type_uuid'] = htmlspecialchars($dockSubitem['security_client_type_uuid'], ENT_COMPAT | ENT_HTML5);
    $dockSubitem['subitem_name'] = htmlspecialchars($dockSubitem['subitem_name'], ENT_COMPAT | ENT_HTML5);
    $dockSubitem['display_name'] = htmlspecialchars($dockSubitem['display_name'], ENT_COMPAT | ENT_HTML5);
    $dockSubitem['description'] = htmlspecialchars($dockSubitem['description'], ENT_NOQUOTES | ENT_HTML5);
    $dockSubitem['weighting'] = htmlspecialchars($dockSubitem['weighting'], ENT_COMPAT | ENT_HTML5);
    $dockSubitem['picture_path'] = htmlspecialchars($dockSubitem['picture_path'], ENT_COMPAT | ENT_HTML5);
    $dockSubitem['subitem_action'] = htmlspecialchars($dockSubitem['subitem_action'], ENT_COMPAT | ENT_HTML5);
  }
    
  unset($json_dock_subitem);
  unset($json_object);
  unset($butr_command);
?>
<h1><?php echo gettext('Dock Subitem Administration'); ?></h1>
<div id="system_dock_subitem_modify_box">
  <fieldset form="system_dock_subitem_modify_form" name="system_dock_subitem_modify_fieldset" id="system_dock_subitem_modify_fieldset">
    <legend><?php echo gettext('Modify Dock Subitem'); ?></legend>
    <form name="system_dock_subitem_modify_form" method="post" onsubmit="javascript:return processSystemDockSubitemModifyForm();">
      <label for="dock_item_uuid" id="dock_item_uuid"><?php echo gettext('Dock Item'); ?>:</label>
      <select name="dock_item_uuid">
        <option value=""><?php echo gettext('Please Select'); ?></option>
<?php echo implode($dock_item_option_list, "\n") ?>
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
      <label for="subitem_name" id="subitem_name_label"><?php echo gettext('Subitem Name'); ?>:</label>
      <input type="text" name="subitem_name" id="subitem_name" value="<?php echo $dockSubitem['subitem_name']; ?>"><br>
      <label for="display_name" id="display_name_label"><?php echo gettext('Display Name'); ?>:</label>
      <input type="text" name="display_name" id="display_name" value="<?php echo $dockSubitem['display_name']; ?>"><br>
      <label for="description" id="description_label"><?php echo gettext('Description'); ?>:</label>
      <textarea name="description" id="description"><?php echo $dockSubitem['description']; ?></textarea><br>
      <label for="weighting" id="weighting_label"><?php echo gettext('Weighting'); ?>:</label>
      <input type="text" name="weighting" id="weighting" value="<?php echo $dockSubitem['weighting']; ?>"><br>
      <label for="picture_path" id="picture_path_label"><?php echo gettext('Picture Path'); ?>:</label>
      <input type="text" name="picture_path" id="picture_path" value="<?php echo $dockSubitem['picture_path']; ?>"><br>
      <label for="subitem_action" id="subitem_action"><?php echo gettext('Subitem Action'); ?>:</label>
      <input type="text" name="subitem_action" id="subitem_action" value="<?php echo $dockSubitem['subitem_action']; ?>"><br>
      <label for="is_active" id="is_active_label"><?php echo gettext('Is Active'); ?>:</label>
      <input type="checkbox" name="is_active" id="is_active" value="1"<?php if ($dockSubitem['is_actve'] == 1) { echo ' checked'; } ?>><br>
      <label for="submit">&nbsp;</label>
      <button type="submit" name="submit" id="submit"><?php echo gettext('Modify Dock Subitem'); ?></button>
      <input type="hidden" name="uuid" value="<?php echo $dockSubitem['uuid']; ?>">     
    </form>
  </fieldset>
</div><!-- /#system_dock_subitem_modify_box -->

<script type="text/javascript">
  document.system_dock_subitem_modify_form.dock_item_uuid.value = '<?php echo $dockSubitem['dock_item_uuid']; ?>';
  document.system_dock_subitem_modify_form.system_dock_type_uuid.value = '<?php echo $dockSubitem['system_dock_type_uuid']; ?>';
  document.system_dock_subitem_modify_form.security_client_type_uuid.value = '<?php echo $dockSubitem['security_client_type_uuid']; ?>';
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
  
  // Grab dock subitems
  $butr_command = new Butr\CommandListDockSubitems();
  $butr_command->setAll($offset, $size, $direction, $ordinal);
  $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
  $butr_command->prepareCommand();
  $json_dock_subitems = $butr_command->sendCommand();
  $json_object = json_decode($json_dock_subitems, false);
  $json_error = json_last_error();
  
  if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
    $total_count = $json_object->list_dock_subitems->total_count;
  }
  
  if ($total_count == '' || !isset($total_count)) {
    $total_count = 0;
  }
  
  $butr_pagination = new Butr\Pagination();
  $butr_pagination->setAll($total_count, $size, $offset, $ordinal, $direction, $language_code,
      Butr\PAGINATION_TYPE_PAGE, 'setHistorySystemMessageList');
  $butr_pagination->preparePagination();
?>
<h1><?php echo gettext('Dock Subitem Administration'); ?></h1>
<table>
  <thead>
    <tr>
      <th><?php echo gettext('Dock Item'); ?></th>
      <th><?php echo gettext('System Dock Type'); ?></th>
      <th><?php echo gettext('Security Client Type'); ?></th>
      <th><?php echo gettext('Subitem Name'); ?></th>
      <th><?php echo gettext('Action'); ?></th>
    </tr>
  </thead>
  <tbody>
<?php
if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
  for($i = 0; $i < sizeof($json_object->list_dock_subitems->items); $i++) {
?>
    <tr class="<?php echo ($alternate = !$alternate) ? 'odd' : 'even'; ?>">
      <td><?php echo htmlspecialchars($json_object->list_dock_subitems->items[$i]->dock_item_name, ENT_COMPAT | ENT_HTML5); ?></td>
      <td><?php echo htmlspecialchars($json_object->list_dock_subitems->items[$i]->system_dock_type_label, ENT_COMPAT | ENT_HTML5); ?></td>
      <td><?php echo htmlspecialchars($json_object->list_dock_subitems->items[$i]->security_client_type_label, ENT_COMPAT | ENT_HTML5); ?></td>
      <td><?php echo htmlspecialchars($json_object->list_dock_sinitems->items[$i]->subitem_name, ENT_COMPAT | ENT_HTML5); ?></td>
      <td><button onclick="javascript:setHistorySystemDockSubitemFetch('<?php echo htmlspecialchars($json_object->list_dock_subitems->items[$i]->uuid, ENT_COMPAT | ENT_HTML5); ?>');"><?php echo gettext('Modify'); ?></button></td>
    </tr>
<?php
  }
}
unset($json_dock_subitems);
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
<h1><?php echo gettext('Dock Subitem Administration'); ?></h1>
<ul>
  <li><a href="javascript:insertContent('system_dock_subitem.php?a=add')"><?php echo gettext('Add Dock Subitem'); ?></a></li>
  <li><a href="javascript:setHistorySystemDockSubitemList(0, '<?php echo $default_list_size; ?>', '<?php echo Butr\SORT_ORDINAL_DEFAULT; ?>', '<?php echo Butr\SORT_DIRECTION_ASCENDING; ?>');"><?php echo gettext('List Dock Subitems'); ?></a></li>
</ul>
<?php
}
// Generate bottom part of the page including flushing the buffer.
$butr_page_fragment->generateHtmlBottom();