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

$permission_uuid = '';
$permission_uuid = (isset($_POST['uuid'])) ? $_POST['uuid'] : '';
if ($permission_uuid === '' && isset($_GET['uuid'])) {
  $permission_uuid = $_GET['uuid'];
}

$butr_authentication = new Butr\Authentication();
$butr_authentication->setSessionToken($session_token);

// Instantiate page fragment class for templated presentation.
$butr_page_fragment = new Butr\PageFragment();

// Generate the top part of the page fragment including buffering output.
$butr_page_fragment->generateHtmlTop(array('security_permission.js'), array('security_permission.css'), $language_code);

if (isset($_POST['a'])) {
  switch ($_POST['a']) {
    case 'add':
      //echo "<script type=\"text/javascript\">setHistorySecurityPermissionAdd();</script>\n";
      $action_mode = 'add';
      break;
    case 'fetch':
      $action_mode = 'fetch';
      break;
    case 'list':
      $action_mode = 'list';
      break;
    default:
      echo "<script type=\"text/javascript\">setHistorySecurityPermission();</script>\n";
      $action_mode = '';
      break;
  }
} else {
  // Same as default in the switch case above.
  echo "<script type=\"text/javascript\">setHistorySecurityPermission();</script>\n";
  $action_mode = '';
}
 
if ($action_mode === 'add') {
  // Grab module list
  $butr_command = new Butr\CommandListModules();
  $butr_command->setAll(0, -1, Butr\SORT_DIRECTION_ASCENDING, Butr\SORT_ORDINAL_DEFAULT);
  $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
  $butr_command->prepareCommand();
  $json_modules = $butr_command->sendCommand();
  $json_object = json_decode($json_modules, false);
  $json_error = json_last_error();

  $module_option_list = array();
  if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
    for($i = 0; $i < sizeof($json_object->list_modules->items); $i++) {
      $module_option_list[] = "<option value=\""
        . htmlspecialchars($json_object->list_modules->items[$i]->uuid, ENT_COMPAT | ENT_HTML5, 'UTF-8')
        . "\">" . htmlspecialchars($json_object->list_modules->items[$i]->module_name, ENT_COMPAT | ENT_HTML5, 'UTF-8')
        . "</option>\n";
    }
  }
  unset($json_modules);
  unset($json_object);
  unset($butr_command);
?>
<h1><?php echo gettext('Permission Administration'); ?></h1>
<div id="security_permission_add_box">
  <fieldset form="security_permission_add_form" name="security_permission_add_fieldset" id="security_permission_add_fieldset">
    <legend><?php echo gettext('Add Permission'); ?></legend>
    <form name="security_permission_add_form" method="post" onsubmit="javascript:return processSecurityPermissionAddForm();">
      <label for="module_uuid" id="module_uuid_label"><?php echo gettext('Module'); ?>:</label>
      <select name="module_uuid">
        <option value=""><?php echo gettext('Please Select'); ?></option>
<?php echo implode($module_option_list, "\n") ?>
      </select><br>
      <label for="permission_name" id="permission_name_label"><?php echo gettext('Permission Name'); ?>:</label>
      <input type="text" name="permission_name" id="permission_name" value=""><br>
      <label for="description" id="description_label"><?php echo gettext('Description'); ?>:</label>
      <textarea name="description" id="description"></textarea><br>
      <label for="magic" id="magic_label"><?php echo gettext('Magic'); ?>:</label>
      <input type="text" name="magic" id="magic" value=""><br>
      <label for="importance" id="importance_label"><?php echo gettext('Importance'); ?>:</label>
      <input type="number" name="importance" id="importance" value=""><br>
      <label for="submit">&nbsp;</label>
      <button type="submit" name="submit" id="submit"><?php echo gettext('Add Permission'); ?></button>      
    </form>
  </fieldset>
</div><!-- /#security_permission_add_box -->

<?php
} elseif ($action_mode === 'fetch') {
  // Grab module list
  $butr_command = new Butr\CommandListModules();
  $butr_command->setAll(0, -1, Butr\SORT_DIRECTION_ASCENDING, Butr\SORT_ORDINAL_DEFAULT);
  $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
  $butr_command->prepareCommand();
  $json_modules = $butr_command->sendCommand();
  $json_object = json_decode($json_modules, false);
  $json_error = json_last_error();

  $module_option_list = array();
  if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
    for($i = 0; $i < sizeof($json_object->list_modules->items); $i++) {
      $module_option_list[] = "<option value=\""
        . htmlspecialchars($json_object->list_modules->items[$i]->uuid, ENT_COMPAT | ENT_HTML5, 'UTF-8')
        . "\">" . htmlspecialchars($json_object->list_modules->items[$i]->module_name, ENT_COMPAT | ENT_HTML5, 'UTF-8')
        . "</option>\n";
    }
  }
  unset($json_modules);
  unset($json_object);
  unset($butr_command);
  
  // Fetch permission
  $butr_command = new Butr\CommandFetchPermission();
  $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
  $butr_command->setUuid($permission_uuid);
  $butr_command->prepareCommand();
  $json_permission = $butr_command->sendCommand();
  $json_object = json_decode($json_permission, false);
  $json_error = json_last_error();
  
  $permission = array();
  if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
    $permission['uuid'] = (isset($json_object->fetch_permission->uuid)) ? $json_object->fetch_permission->uuid : '';
    $permission['module_uuid'] = (isset($json_object->fetch_permission->module_uuid)) ? $json_object->fetch_permission->module_uuid : '';
    $permission['permission_name'] = (isset($json_object->fetch_permission->permission_name)) ? $json_object->fetch_permission->permission_name : '';
    $permission['description'] = (isset($json_object->fetch_permission->description)) ? $json_object->fetch_permission->description : '';
    $permission['magic'] = (isset($json_object->fetch_permission->magic)) ? $json_object->fetch_permission->magic : '';
    $permission['importance'] = (isset($json_object->fetch_permission->importance)) ? $json_object->fetch_permission->importance : '';

    // Escpe output
    $permission['uuid'] = htmlspecialchars($permission['uuid'], ENT_COMPAT | ENT_HTML5, 'UTF-8');
    $permission['module_uuid'] = htmlspecialchars($permission['module_uuid'], ENT_COMPAT | ENT_HTML5, 'UTF-8');
    $permission['permission_name'] = htmlspecialchars($permission['permission_name'], ENT_COMPAT | ENT_HTML5, 'UTF-8');
    $permission['description'] = htmlspecialchars($permission['description'], ENT_NOQUOTES | ENT_HTML5, 'UTF-8');
    $permission['magic'] = htmlspecialchars($permission['magic'], ENT_COMPAT | ENT_HTML5, 'UTF-8');
    $permission['importance'] = htmlspecialchars($permission['importance'], ENT_COMPAT | ENT_HTML5, 'UTF-8');
  }
  unset($json_permission);
  unset($json_object);
  unset($butr_command);
?>
<h1><?php echo gettext('Permission Administration'); ?></h1>
<div id="security_permission_modify_box">
  <fieldset form="security_permission_modify_form" name="security_permission_modify_fieldset" id="security_permission_modify_fieldset">
    <legend><?php echo gettext('Modify Permission'); ?></legend>
    <form name="security_permission_modify_form" method="post" onsubmit="javascript:return processSecurityPermissionModifyForm();">
      <label for="module_uuid" id="module_uuid_label"><?php echo gettext('Module'); ?>:</label>
      <select name="module_uuid">
        <option value=""><?php echo gettext('Please Select'); ?></option>
<?php echo implode($module_option_list, "\n") ?>
      </select><br>
      <label for="permission_name" id="permission_name_label"><?php echo gettext('Permission Name'); ?>:</label>
      <input type="text" name="permission_name" id="permission_name"  value="<?php echo $permission['permission_name']; ?>"><br>
      <label for="description" id="description_label"><?php echo gettext('Description'); ?>:</label>
      <textarea name="description" id="description"><?php echo $permission['description']; ?></textarea><br>
      <label for="magic" id="magic_label"><?php echo gettext('Magic'); ?>:</label>
      <input type="text" name="magic" id="magic" value="<?php echo $permission['magic']; ?>"><br>
      <label for="importance" id="importance_label"><?php echo gettext('Importance'); ?>:</label>
      <input type="number" name="importance" id="importance" value="<?php echo $permission['importance']; ?>"><br>
      <label for="submit">&nbsp;</label>
      <button type="submit" name="submit" id="submit"><?php echo gettext('Modify Permission'); ?></button>
      <input type="hidden" name="uuid" value="<?php echo $permission['uuid']; ?>">
    </form>
  </fieldset>
</div><!-- /#security_permission_modify_box -->

<script type="text/javascript">
  document.security_permission_modify_form.module_uuid.value = '<?php echo $permission['module_uuid']; ?>';
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
  
  // Grab permissions
  $butr_command = new Butr\CommandListPermissions();
  $butr_command->setAll($offset, $size, $direction, $ordinal);
  $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
  $butr_command->prepareCommand();
  $json_permissions = $butr_command->sendCommand();
  $json_object = json_decode($json_permissions, false);
  $json_error = json_last_error();
  
  if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
    $total_count = $json_object->list_permissions->total_count;
  }
  
  if ($total_count == '' || !isset($total_count)) {
    $total_count = 0;
  }
  
  $butr_pagination = new Butr\Pagination();
  $butr_pagination->setAll($total_count, $size, $offset, $ordinal, $direction, $language_code,
      Butr\PAGINATION_TYPE_PAGE, 'setHistorySecurityPermissionList');
  $butr_pagination->preparePagination();
?>
<h1><?php echo gettext('Permission Administration'); ?></h1>
<table>
  <thead>
    <tr>
      <th><?php echo gettext('Module'); ?></th>
      <th><?php echo gettext('Permission Name'); ?></th>
      <th><?php echo gettext('Action'); ?></th>
    </tr>
  </thead>
  <tbody>
<?php
if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
  for($i = 0; $i < sizeof($json_object->list_permissions->items); $i++) {
?>
    <tr class="<?php echo ($alternate = !$alternate) ? 'odd' : 'even'; ?>">
      <td><?php echo htmlspecialchars($json_object->list_permissions->items[$i]->module_name, ENT_COMPAT | ENT_HTML5, 'UTF-8'); ?></td>
      <td><?php echo htmlspecialchars($json_object->list_permissions->items[$i]->permission_name, ENT_COMPAT | ENT_HTML5, 'UTF-8'); ?></td>
      <td><button onclick="javascript:setHistorySecurityPermissionFetch('<?php echo htmlspecialchars($json_object->list_permissions->items[$i]->uuid, ENT_COMPAT | ENT_HTML5, 'UTF-8'); ?>');"><?php echo gettext('Modify'); ?></button></td>
    </tr>
<?php
  }
}
unset($json_permissions);
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
<h1><?php echo gettext('Permission Administration'); ?></h1>
<ul>
  <li><a href="javascript:setHistorySecurityPermissionAdd();"><?php echo gettext('Add Permission'); ?></a></li>
  <li><a href="javascript:setHistorySecurityPermissionList(0, '<?php echo $default_list_size; ?>', '<?php echo Butr\SORT_ORDINAL_DEFAULT; ?>', '<?php echo Butr\SORT_DIRECTION_ASCENDING; ?>');"><?php echo gettext('List Permissions'); ?></a></li>
</ul>
<?php
}
// Generate bottom part of the page including flushing the buffer.
$butr_page_fragment->generateHtmlBottom();