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

$dock_uuid = '';
$dock_uuid = (isset($_POST['uuid'])) ? $_POST['uuid'] : '';
if ($dock_uuid === '' && isset($_GET['uuid'])) {
  $dock_uuid = $_GET['uuid'];
}

$butr_authentication = new Butr\Authentication();
$butr_authentication->setSessionToken($session_token);

// Instantiate page fragment class for templated presentation.
$butr_page_fragment = new Butr\PageFragment();

// Generate the top part of the page fragment including buffering output.
$butr_page_fragment->generateHtmlTop(array('system_dock.js'), array('system_dock.css'), $language_code);

if (isset($_POST['a'])) {
  switch ($_POST['a']) {
    case 'add':
      echo "<script type=\"text/javascript\">setHistorySystemDockAdd();</script>\n";
      $action_mode = 'add';
      break;
    case 'fetch':
      $action_mode = 'fetch';
      break;
    case 'list':
      $action_mode = 'list';
      break;
    default:
      echo "<script type=\"text/javascript\">setHistorySystemDock();</script>\n";
      $action_mode = '';
      break;
  }
} else {
  // Same as default in the switch case above.
  echo "<script type=\"text/javascript\">setHistorySystemDock();</script>\n";
  $action_mode = '';
}
 
if ($action_mode === 'add') {
  // Grab security client type configuration settings
  $butr_command = new Butr\CommandListSecurityClientTypeConfigurations();
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
?>
<h1><?php echo gettext('Dock Administration'); ?></h1>
<div id="system_dock_add_box">
  <fieldset form="system_dock_add_form" name="system_dock_add_fieldset" id="system_dock_add_fieldset">
    <legend><?php echo gettext('Add Dock'); ?></legend>
    <form name="system_dock_add_form" method="post" onsubmit="javascript:return processSystemDockAddForm();">
      <label for="security_client_type_uuid" id="security_client_type_uuid"><?php echo gettext('Security Client Type'); ?>:</label>
      <select name="security_client_type_uuid">
        <option value=""><?php echo gettext('Please Select'); ?></option>
<?php echo implode($security_client_type_option_list, "\n") ?>
      </select><br>
      <label for="dock_name" id="dock_name_label"><?php echo gettext('Dock Name'); ?>:</label>
      <input type="text" name="dock_name" id="dock_name" value=""><br>
      <label for="display_name" id="display_name_label"><?php echo gettext('Display Name'); ?>:</label>
      <input type="text" name="display_name" id="display_name" value=""><br>
      <label for="description" id="description_label"><?php echo gettext('Description'); ?>:</label>
      <textarea name="description" id="description"></textarea><br>
      <label for="weighting" id="weighting_label"><?php echo gettext('Weighting'); ?>:</label>
      <input type="text" name="weighting" id="weighting" value=""><br>
      <label for="icon" id="icon_label"><?php echo gettext('Icon'); ?>:</label>
      <input type="text" name="icon" id="icon" value=""><br>
      <label for="is_active" id="is_active_label"><?php echo gettext('Is Active'); ?>:</label>
      <input type="checkbox" name="is_active" id="is_active" value="1" checked><br>
      <label for="submit">&nbsp;</label>
      <button type="submit" name="submit" id="submit"><?php echo gettext('Add Dock'); ?></button>      
    </form>
  </fieldset>
</div><!-- /#system_dock_add_box -->

<?php
} elseif ($action_mode === 'fetch') {
  // Grab security client type configuration settings
  $butr_command = new Butr\CommandListSecurityClientTypeConfigurations();
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
  
  // Fetch dock
  $butr_command = new Butr\CommandFetchDock();
  $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
  $butr_command->setUuid($dock_uuid);
  $butr_command->prepareCommand();
  $json_dock = $butr_command->sendCommand();
  $json_object = json_decode($json_dock, false);
  $json_error = json_last_error();
  
  $dock = array();
  if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
    $dock['uuid'] = (isset($json_object->fetch_dock->uuid)) ? $json_object->fetch_dock->uuid : '';
    $dock['security_client_type_uuid'] = (isset($json_object->fetch_dock->security_client_type_uuid)) ? $json_object->fetch_dock->security_client_type_uuid : '';
    $dock['dock_name'] = (isset($json_object->fetch_dock->dock_name)) ? $json_object->fetch_dock->dock_name : '';
    $dock['display_name'] = (isset($json_object->fetch_dock->display_name)) ? $json_object->fetch_dock->display_name : '';
    $dock['description'] = (isset($json_object->fetch_dock->description)) ? $json_object->fetch_dock->description : '';
    $dock['weighting'] = (isset($json_object->fetch_dock->weighting)) ? $json_object->fetch_dock->weighting : '';
    $dock['icon'] = (isset($json_object->fetch_dock->icon)) ? $json_object->fetch_dock->icon : '';
    $dock['is_actve'] = (isset($json_object->fetch_dock->is_active)) ? $json_object->fetch_dock->is_active : '';
    
    // Escape output
    $dock['uuid'] = htmlspecialchars($dock['uuid'], ENT_COMPAT | ENT_HTML5);
    $dock['security_client_type_uuid'] = htmlspecialchars($dock['security_client_type_uuid'], ENT_COMPAT | ENT_HTML5);
    $dock['dock_name'] = htmlspecialchars($dock['dock_name'], ENT_COMPAT | ENT_HTML5);
    $dock['display_name'] = htmlspecialchars($dock['display_name'], ENT_COMPAT | ENT_HTML5);
    $dock['description'] = htmlspecialchars($dock['description'], ENT_NOQUOTES | ENT_HTML5);
    $dock['weighting'] = htmlspecialchars($dock['weighting'], ENT_COMPAT | ENT_HTML5);
    $dock['icon'] = htmlspecialchars($dock['icon'], ENT_COMPAT | ENT_HTML5);
  }
  unset($json_dock);
  unset($json_object);
  unset($butr_command);
?>
<h1><?php echo gettext('Dock Administration'); ?></h1>
<div id="system_dock_modify_box">
  <fieldset form="system_dock_modify_form" name="system_dock_modify_fieldset" id="system_dock_modify_fieldset">
    <legend><?php echo gettext('Modify Dock'); ?></legend>
    <form name="system_dock_modify_form" method="post" onsubmit="javascript:return processSystemDockModifyForm();">
      <label for="security_client_type_uuid" id="security_client_type_uuid"><?php echo gettext('Security Client Type'); ?>:</label>
      <select name="security_client_type_uuid">
        <option value=""><?php echo gettext('Please Select'); ?></option>
<?php echo implode($security_client_type_option_list, "\n") ?>
      </select><br>
      <label for="dock_name" id="dock_name_label"><?php echo gettext('Dock Name'); ?>:</label>
      <input type="text" name="dock_name" id="dock_name" value="<?php echo $dock['dock_name']; ?>"><br>
      <label for="display_name" id="display_name_label"><?php echo gettext('Display Name'); ?>:</label>
      <input type="text" name="display_name" id="display_name" value="<?php echo $dock['display_name']; ?>"><br>
      <label for="description" id="description_label"><?php echo gettext('Description'); ?>:</label>
      <textarea name="description" id="description"><?php echo $dock['description']; ?></textarea><br>
      <label for="weighting" id="weighting_label"><?php echo gettext('Weighting'); ?>:</label>
      <input type="text" name="weighting" id="weighting" value="<?php echo $dock['weighting']; ?>"><br>
      <label for="icon" id="icon_label"><?php echo gettext('Icon'); ?>:</label>
      <input type="text" name="icon" id="icon" value="<?php echo $dock['icon']; ?>"><br>
      <label for="is_active" id="is_active_label"><?php echo gettext('Is Active'); ?>:</label>
      <input type="checkbox" name="is_active" id="is_active" value="1"<?php if ($dock['is_active'] == 1) { echo ' checked'; } ?>><br>
      <label for="submit">&nbsp;</label>
      <button type="submit" name="submit" id="submit"><?php echo gettext('Modify Dock'); ?></button>
      <input type="hidden" name="uuid" value="<?php echo $dock['uuid']; ?>">     
    </form>
  </fieldset>
</div><!-- /#system_dock_modify_box -->

<script type="text/javascript">
  document.system_dock_modify_form.security_client_type_uuid.value = '<?php echo $dock['security_client_type_uuid']; ?>';
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
  
  // Grab docks
  $butr_command = new Butr\CommandListDocks();
  $butr_command->setAll($offset, $size, $direction, $ordinal);
  $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
  $butr_command->prepareCommand();
  $json_docks = $butr_command->sendCommand();
  $json_object = json_decode($json_docks, false);
  $json_error = json_last_error();
  
  if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
    $total_count = $json_object->list_docks->total_count;
  }
  
  if ($total_count == '' || !isset($total_count)) {
    $total_count = 0;
  }
  
  $butr_pagination = new Butr\Pagination();
  $butr_pagination->setAll($total_count, $size, $offset, $ordinal, $direction, $language_code,
      Butr\PAGINATION_TYPE_PAGE, 'setHistorySystemDockList');
  $butr_pagination->preparePagination();
?>
<h1><?php echo gettext('Dock Administration'); ?></h1>
<table>
  <thead>
    <tr>
      <th><?php echo gettext('Security Client Type'); ?></th>
      <th><?php echo gettext('Dock Name'); ?></th>
      <th><?php echo gettext('Action'); ?></th>
    </tr>
  </thead>
  <tbody>
<?php
if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
  for($i = 0; $i < sizeof($json_object->list_docks); $i++) {
?>
    <tr class="<?php echo ($alternate = !$alternate) ? 'odd' : 'even'; ?>">
      <td><?php echo htmlspecialchars($json_object->list_docks[$i]->security_client_type_label, ENT_COMPAT | ENT_HTML5); ?></td>
      <td><?php echo htmlspecialchars($json_object->list_docks[$i]->dock_name, ENT_COMPAT | ENT_HTML5); ?></td>
      <td><button onclick="javascript:setHistorySystemDockFetch('<?php echo htmlspecialchars($json_object->list_docks[$i]->uuid, ENT_COMPAT | ENT_HTML5); ?>');"><?php echo gettext('Modify'); ?></button></td>
    </tr>
<?php
  }
}
unset($json_docks);
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
<h1><?php echo gettext('Dock Administration'); ?></h1>
<ul>
  <li><a href="javascript:insertContent('system_dock.php?a=add')"><?php echo gettext('Add Dock'); ?></a></li>
  <li><a href="javascript:setHistorySystemDockList(0, '<?php echo $default_list_size; ?>', '<?php echo Butr\SORT_ORDINAL_DEFAULT; ?>', '<?php echo Butr\SORT_DIRECTION_ASCENDING; ?>');"><?php echo gettext('List Docks'); ?></a></li>
</ul>
<?php
}
// Generate bottom part of the page including flushing the buffer.
$butr_page_fragment->generateHtmlBottom();