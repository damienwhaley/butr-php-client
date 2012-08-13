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

$group_uuid = '';
$group_uuid = (isset($_POST['uuid'])) ? $_POST['uuid'] : '';
if ($group_uuid === '' && isset($_GET['uuid'])) {
  $group_uuid = $_GET['uuid'];
}

$butr_authentication = new Butr\Authentication();
$butr_authentication->setSessionToken($session_token);

// Instantiate page fragment class for templated presentation.
$butr_page_fragment = new Butr\PageFragment();

// Generate the top part of the page fragment including buffering output.
$butr_page_fragment->generateHtmlTop(array('user_group.js'), array('user_group.css'), $language_code);

if (isset($_POST['a'])) {
  switch ($_POST['a']) {
    case 'add':
      $action_mode = 'add';
      break;
    case 'fetch':
      $action_mode = 'fetch';
      break;
    case 'list':
      $action_mode = 'list';
      break;
    default:
      echo "<script type=\"text/javascript\">setHistoryUserGroup();</script>\n";
      $action_mode = '';
      break;
  }
} else {
  // Same as default in the switch case above.
  echo "<script type=\"text/javascript\">setHistoryUserGroup();</script>\n";
  $action_mode = '';
}
?>
<h1><?php echo gettext('Group Administration'); ?></h1>
<?php
if ($action_mode === 'add') {
?>
<div id="user_group_add_box">
  <fieldset form="user_group_add_form" name="user_group_add_fieldset" id="user_group_add_fieldset">
    <legend><?php echo gettext('Add Group'); ?></legend>
    <form name="user_group_add_form" method="post" onsubmit="javascript:return processUserGroupAddForm();">
      <label for="group_name" id="group_name_label"><?php echo gettext('Group Name'); ?>:</label>
      <input type="text" name="group_name" id="group_name" value=""><br>
      <label for="display_name" id="display_name_label"><?php echo gettext('Display Name'); ?>:</label>
      <input type="text" name="display_name" id="display_name" value=""><br>
      <label for="description" id="description_label"><?php echo gettext('Description'); ?>:</label>
      <textarea type="text" name="description" id="description"></textarea><br>
      <label for="is_active" id="is_active_label"><?php echo gettext('Is Active'); ?>:</label>
      <input type="checkbox" name="is_active" id="is_active" value="1" checked><br>
      <label for="submit">&nbsp;</label>
      <button type="submit" name="submit" id="submit"><?php echo gettext('Add Group'); ?></button>      
    </form>
  </fieldset>
</div><!-- /#user_group_add_box -->

<?php
} elseif ($action_mode === 'fetch') {
  // Fetch group
  $butr_command = new Butr\CommandFetchGroup();
  $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
  $butr_command->setUuid($group_uuid);
  $butr_command->prepareCommand();
  $json_group = $butr_command->sendCommand();
  $json_object = json_decode($json_group, false);
  $json_error = json_last_error();
  
  $group = array();
  if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
    $group['uuid'] = (isset($json_object->fetch_group->uuid)) ? $json_object->fetch_group->uuid : '';
    $group['group_name'] = (isset($json_object->fetch_group->group_name)) ? $json_object->fetch_group->group_name : '';
    $group['display_name'] = (isset($json_object->fetch_group->display_name)) ? $json_object->fetch_group->display_name : '';
    $group['description'] = (isset($json_object->fetch_group->description)) ? $json_object->fetch_group->description : '';
    $group['is_active'] = (isset($json_object->fetch_group->is_active)) ? $json_object->fetch_group->is_active : '';
    
    // Escape output
    $group['uuid'] = htmlspecialchars($group['uuid'], ENT_COMPAT | ENT_HTML5, 'UTF-8');
    $group['group_name'] = htmlspecialchars($group['group_name'], ENT_COMPAT | ENT_HTML5, 'UTF-8');
    $group['display_name'] = htmlspecialchars($group['display_name'], ENT_COMPAT | ENT_HTML5, 'UTF-8');
    $group['description'] = htmlspecialchars($group['description'], ENT_NOQUOTES | ENT_HTML5, 'UTF-8');
  }
  
  unset($json_group);
  unset($json_object);
  unset($butr_command);  
?>
<div id="user_group_modify_box">
  <fieldset form="user_group_modify_form" name="user_group_modify_fieldset" id="user_group_modify_fieldset">
    <legend><?php echo gettext('Modify Group'); ?></legend>
    <form name="user_group_modify_form" method="post" onsubmit="javascript:return processUserGroupModifyForm();">
      <label for="group_name" id="group_name_label"><?php echo gettext('Group Name'); ?>:</label>
      <input type="text" name="group_name" id="group_name" value="<?php echo $group['group_name']; ?>"><br>
      <label for="display_name" id="display_name_label"><?php echo gettext('Display Name'); ?>:</label>
      <input type="text" name="display_name" id="display_name" value="<?php echo $group['display_name']; ?>"><br>
      <label for="description" id="description_label"><?php echo gettext('Description'); ?>:</label>
      <textarea type="text" name="description" id="description"><?php echo $group['description']; ?></textarea><br>
      <label for="is_active" id="is_active_label"><?php echo gettext('Is Active'); ?>:</label>
      <input type="checkbox" name="is_active" id="is_active" value="1"<?php if ($group['is_active'] == 1) { echo ' checked'; } ?>><br>
      <label for="submit">&nbsp;</label>
      <button type="submit" name="submit" id="submit"><?php echo gettext('Modify Group'); ?></button>
      <input type="hidden" name="uuid" value="<?php echo $group['uuid']; ?>">
    </form>
  </fieldset>
</div><!-- /#user_group_modify_box -->

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
  
  // Grab groups
  $butr_command = new Butr\CommandListGroups();
  $butr_command->setAll($offset, $size, $direction, $ordinal);
  $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
  $butr_command->prepareCommand();
  $json_groups = $butr_command->sendCommand();
  $json_object = json_decode($json_groups, false);
  $json_error = json_last_error();
  
  if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
    $total_count = $json_object->list_groups->total_count;
  }
  
  if ($total_count == '' || !isset($total_count)) {
    $total_count = 0;
  }
  
  $butr_pagination = new Butr\Pagination();
  $butr_pagination->setAll($total_count, $size, $offset, $ordinal, $direction, $language_code,
      Butr\PAGINATION_TYPE_PAGE, 'setHistoryUserGroupList');
  $butr_pagination->preparePagination();
?>
<table>
  <thead>
    <tr>
      <th><?php echo gettext('Group Name'); ?></th>
      <th><?php echo gettext('Action')?></th>
    </tr>
  </thead>
  <tbody>
<?php
if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
  for($i = 0; $i < sizeof($json_object->list_groups->items); $i++) {
?>
    <tr class="<?php echo ($alternate = !$alternate) ? 'odd' : 'even'; ?>">
      <td><?php echo htmlspecialchars($json_object->list_groups->items[$i]->group_name, ENT_COMPAT | ENT_HTML5, 'UTF-8'); ?></td>
      <td><button onclick="javascript:setHistoryUserGroupFetch('<?php echo htmlspecialchars($json_object->list_groups->items[$i]->uuid, ENT_COMPAT | ENT_HTML5, 'UTF-8'); ?>');"><?php echo gettext('Modify'); ?></button></td>
    </tr>
<?php
  }
}
unset($json_groups);
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
<ul>
  <li><a href="javascript:setHistoryUserGroupAdd();"><?php echo gettext('Add Group'); ?></a></li>
  <li><a href="javascript:setHistoryUserGroupList(0, '<?php echo $default_list_size; ?>', '<?php echo Butr\SORT_ORDINAL_DEFAULT; ?>', '<?php echo Butr\SORT_DIRECTION_ASCENDING; ?>');"><?php echo gettext('List Groups'); ?></a></li>
</ul>
<?php
}
// Generate bottom part of the page including flushing the buffer.
$butr_page_fragment->generateHtmlBottom();