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

$security_client_type_uuid = '';
$security_client_type_uuid = (isset($_POST['uuid'])) ? $_POST['uuid'] : '';
if ($security_client_type_uuid === '' && isset($_GET['uuid'])) {
  $security_client_type_uuid = $_GET['uuid'];
}

$butr_authentication = new Butr\Authentication();
$butr_authentication->setSessionToken($session_token);

// Instantiate page fragment class for templated presentation.
$butr_page_fragment = new Butr\PageFragment();

// Generate the top part of the page fragment including buffering output.
$butr_page_fragment->generateHtmlTop(array('configuration_security_client_type.js'), array('configuration_security_client_type.css'), $language_code);

if (isset($_POST['a'])) {
  switch ($_POST['a']) {
    case 'add':
      echo "<script type=\"text/javascript\">setHistoryConfigurationSecurityClientTypeAdd();</script>\n";
      $action_mode = 'add';
      break;
    case 'fetch':
      $action_mode = 'fetch';
      break;
    case 'list':
      $action_mode = 'list';
      break;
    default:
      echo "<script type=\"text/javascript\">setHistoryConfigurationSecurityClientType();</script>\n";
      $action_mode = '';
      break;
  }
} else {
  // Same as default in the switch case above.
  echo "<script type=\"text/javascript\">setHistoryConfigurationSecurityClientType();</script>\n";
  $action_mode = '';
}
?>
<h1><?php echo gettext('Security Client Type Configuration Administration'); ?></h1>
<?php
if ($action_mode === 'add') {
  // TODO: from here
  
?>
<div id="configuration_security_client_type_add_box">
  <fieldset form="configuration_security_client_type_add_form" name="configuration_security_client_type_add_fieldset" id="configuration_security_client_type_add_fieldset">
    <legend><?php echo gettext('Add Security Client Type Configuration'); ?></legend>
    <form name="configuration_security_client_type_add_form" method="post" onsubmit="javascript:return processConfigurationSecurityClientTypeAddForm();">
      <label for="name_label" id="name_label_label"><?php echo gettext('Name Label'); ?>:</label>
      <input type="text" name="name_label" id="name_label" value=""><br>
      <label for="display_label" id="display_label_label"><?php echo gettext('Display Label'); ?>:</label>
      <input type="text" name="display_label" id="display_label" value=""><br>
      <label for="description" id="description_label"><?php echo gettext('Description'); ?>:</label>
      <textarea type="text" name="description" id="description"></textarea><br>
      <label for="magic" id="magic_label"><?php echo gettext('Magic'); ?>:</label>
      <input type="text" name="magic" id="magic" value=""><br>
      <label for="weighting" id="weighting_label"><?php echo gettext('Weighting'); ?>:</label>
      <input type="text" name="weighting" id="weighting" value=""><br>
      <label for="is_active" id="is_active_label"><?php echo gettext('Is Active'); ?>:</label>
      <input type="checkbox" name="is_active" id="is_active" value="1" checked><br>
      <label for="submit">&nbsp;</label>
      <button type="submit" name="submit" id="submit"><?php echo gettext('Add Security Client Type Configuration'); ?></button>      
    </form>
  </fieldset>
</div><!-- /#configuration_security_client_type_add_box -->

<?php
} elseif ($action_mode === 'fetch') {
  // Fetch security client type configuration
  $butr_command = new Butr\CommandFetchSecurityClientTypeConfiguration();
  $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
  $butr_command->setUuid($security_client_type_uuid);
  $butr_command->prepareCommand();
  $json_security_client_type = $butr_command->sendCommand();
  $json_object = json_decode($json_security_client_type, false);
  $json_error = json_last_error();
  
  $securityClientType = array();
  if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
    $securityClientType['uuid'] = (isset($json_object->fetch_security_client_type_configuration->uuid)) ? $json_object->fetch_security_client_type_configuration->uuid : '';
    $securityClientType['name_label'] = (isset($json_object->fetch_security_client_type_configuration->name_label)) ? $json_object->fetch_security_client_type_configuration->name_label : '';
    $securityClientType['display_label'] = (isset($json_object->fetch_security_client_type_configuration->display_label)) ? $json_object->fetch_security_client_type_configuration->display_label : '';
    $securityClientType['description'] = (isset($json_object->fetch_security_client_type_configuration->description)) ? $json_object->fetch_security_client_type_configuration->description : '';
    $securityClientType['magic'] = (isset($json_object->fetch_security_client_type_configuration->magic)) ? $json_object->fetch_security_client_type_configuration->magic : '';
    $securityClientType['weighting'] = (isset($json_object->fetch_security_client_type_configuration->weighting)) ? $json_object->fetch_security_client_type_configuration->weighting : '';
    $securityClientType['is_active'] = (isset($json_object->fetch_security_client_type_configuration->is_active)) ? $json_object->fetch_security_client_type_configuration->is_active : '';
    
    // Escape output
    $securityClientType['uuid'] = htmlspecialchars($securityClientType['uuid'], ENT_COMPAT | ENT_HTML5, 'UTF-8');
    $securityClientType['name_label'] = htmlspecialchars($securityClientType['name_label'], ENT_COMPAT | ENT_HTML5, 'UTF-8');
    $securityClientType['description'] = htmlspecialchars($securityClientType['description'], ENT_NOQUOTES | ENT_HTML5, 'UTF-8');
    $securityClientType['magic'] = htmlspecialchars($securityClientType['magic'], ENT_NOQUOTES | ENT_HTML5, 'UTF-8');
    $securityClientType['weighting'] = htmlspecialchars($securityClientType['weighting'], ENT_COMPAT | ENT_HTML5, 'UTF-8');
  }
  
  unset($json_security_client_type);
  unset($json_object);
  unset($butr_command);  
?>
<div id="configuration_security_client_type_modify_box">
  <fieldset form="configuration_security_client_type_modify_form" name="configuration_security_client_type_modify_fieldset" id="configuration_security_client_type_modify_fieldset">
    <legend><?php echo gettext('Modify Security Client Type Configuration'); ?></legend>
    <form name="configuration_security_client_type_modify_form" method="post" onsubmit="javascript:return processConfigurationSecurityClientTypeModifyForm();">
      <label for="name_label" id="name_label_label"><?php echo gettext('Name Label'); ?>:</label>
      <input type="text" name="name_label" id="name_label" value="<?php echo $securityClientType['name_label']; ?>"><br>
      <label for="display_label" id="display_label_label"><?php echo gettext('Display Label'); ?>:</label>
      <input type="text" name="display_label" id="display_label" value="<?php echo $securityClientType['display_label']; ?>"><br>
      <label for="description" id="description_label"><?php echo gettext('Description'); ?>:</label>
      <textarea type="text" name="description" id="description"><?php echo $securityClientType['description']; ?></textarea><br>      
      <label for="magic" id="magic_label"><?php echo gettext('Magic'); ?>:</label>
      <input type="text" name="magic" id="magic" value="<?php echo $securityClientType['magic']; ?>"><br>
      <label for="weighting" id="weighting_label"><?php echo gettext('Weighting'); ?>:</label>
      <input type="text" name="weighting" id="weighting" value="<?php echo $securityClientType['weighting']; ?>"><br>
      <label for="is_active" id="is_active_label"><?php echo gettext('Is Active'); ?>:</label>
      <input type="checkbox" name="is_active" id="is_active" value="1"<?php if ($securityClientType['is_active'] == 1) { echo ' checked'; } ?>><br>
      <label for="submit">&nbsp;</label>
      <button type="submit" name="submit" id="submit"><?php echo gettext('Modify Security Client Type Configuration'); ?></button>
      <input type="hidden" name="uuid" value="<?php echo $securityClientType['uuid']; ?>">
    </form>
  </fieldset>
</div><!-- /#configuration_security_client_type_modify_box -->

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
  
  // Grab security client types
  $butr_command = new Butr\CommandListSecurityClientTypeConfigurations();
  $butr_command->setAll($offset, $size, $direction, $ordinal);
  $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
  $butr_command->prepareCommand();
  $json_users = $butr_command->sendCommand();
  $json_object = json_decode($json_users, false);
  $json_error = json_last_error();
  
  if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
    $total_count = $json_object->list_security_client_type_configurations->total_count;
  }
  
  if ($total_count == '' || !isset($total_count)) {
    $total_count = 0;
  }
  
  $butr_pagination = new Butr\Pagination();
  $butr_pagination->setAll($total_count, $size, $offset, $ordinal, $direction, $language_code,
      Butr\PAGINATION_TYPE_PAGE, 'setHistoryConfigurationSecurityClientTypeList');
  $butr_pagination->preparePagination();
?>
<table>
  <thead>
    <tr>
      <th><?php echo gettext('Name Label'); ?></th>
      <th><?php echo gettext('Action')?></th>
    </tr>
  </thead>
  <tbody>
<?php
if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
  for($i = 0; $i < sizeof($json_object->list_security_client_type_configurations->items); $i++) {
?>
    <tr class="<?php echo ($alternate = !$alternate) ? 'odd' : 'even'; ?>">
      <td><?php echo htmlspecialchars($json_object->list_security_client_type_configurations->items[$i]->name_label, ENT_COMPAT | ENT_HTML5, 'UTF-8'); ?></td>
      <td><button onclick="javascript:setHistoryConfigurationSecurityClientTypeFetch('<?php echo htmlspecialchars($json_object->list_security_client_type_configurations->items[$i]->uuid, ENT_COMPAT | ENT_HTML5, 'UTF-8'); ?>');"><?php echo gettext('Modify'); ?></button></td>
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
  <li><a href="javascript:setHistoryConfigurationSecurityClientTypeAdd();"><?php echo gettext('Add Security Client Type Configuration'); ?></a></li>
  <li><a href="javascript:setHistoryConfigurationSecurityClientTypeList(0, '<?php echo $default_list_size; ?>', '<?php echo Butr\SORT_ORDINAL_DEFAULT; ?>', '<?php echo Butr\SORT_DIRECTION_ASCENDING; ?>');"><?php echo gettext('List Security Client Type Configurations'); ?></a></li>
</ul>
<?php
}
// Generate bottom part of the page including flushing the buffer.
$butr_page_fragment->generateHtmlBottom();