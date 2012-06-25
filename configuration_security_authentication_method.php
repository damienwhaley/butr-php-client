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

$security_authentication_method_uuid = '';
$security_authentication_method_uuid = (isset($_POST['uuid'])) ? $_POST['uuid'] : '';
if ($security_authentication_method_uuid === '' && isset($_GET['uuid'])) {
  $security_authentication_method_uuid = $_GET['uuid'];
}

$butr_authentication = new Butr\Authentication();
$butr_authentication->setSessionToken($session_token);

// Instantiate page fragment class for templated presentation.
$butr_page_fragment = new Butr\PageFragment();

// Generate the top part of the page fragment including buffering output.
$butr_page_fragment->generateHtmlTop(array('configuration_security_authentication_method.js'), array('configuration_security_authentication_method.css'), $language_code);

if (isset($_POST['a'])) {
  switch ($_POST['a']) {
    case 'add':
      echo "<script type=\"text/javascript\">setHistoryConfigurationSecurityAuthenticationMethoAdd();</script>\n";
      $action_mode = 'add';
      break;
    case 'fetch':
      $action_mode = 'fetch';
      break;
    case 'list':
      $action_mode = 'list';
      break;
    default:
      echo "<script type=\"text/javascript\">setHistoryConfigurationSecurityAuthenticationMethod();</script>\n";
      $action_mode = '';
      break;
  }
} else {
  // Same as default in the switch case above.
  echo "<script type=\"text/javascript\">setHistoryConfigurationSecurityAuthenticationMethod();</script>\n";
  $action_mode = '';
}
?>
<h1><?php echo gettext('Security Authentication Method Configuration Administration'); ?></h1>
<?php
if ($action_mode === 'add') {
?>
<div id="configuration_security_authentication_method_add_box">
  <fieldset form="configuration_security_authentication_method_add_form" name="configuration_security_authentication_method_add_fieldset" id="configuration_security_authentication_method_add_fieldset">
    <legend><?php echo gettext('Add Security Authentication Method Configuration'); ?></legend>
    <form name="configuration_security_authentication_method_add_form" method="post" onsubmit="javascript:return processConfigurationSecurityAuthenticationMethodAddForm();">
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
      <button type="submit" name="submit" id="submit"><?php echo gettext('Add Security Authentication Method Configuration'); ?></button>      
    </form>
  </fieldset>
</div><!-- /#configuration_security_authentication_method_add_box -->

<?php
} elseif ($action_mode === 'fetch') {
  // Fetch security authentication method configuration
  $butr_command = new Butr\CommandFetchSecurityAuthenticationMethodConfiguration();
  $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
  $butr_command->setUuid($security_authentication_method_uuid);
  $butr_command->prepareCommand();
  $json_security_authentication_method = $butr_command->sendCommand();
  $json_object = json_decode($json_security_authentication_method, false);
  $json_error = json_last_error();
  
  $securityAuthenticationMethod = array();
  if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
    $securityAuthenticationMethod['uuid'] = (isset($json_object->fetch_security_authentication_method_configuration->uuid)) ? $json_object->fetch_security_authentication_method_configuration->uuid : '';
    $securityAuthenticationMethod['name_label'] = (isset($json_object->fetch_security_authentication_method_configuration->name_label)) ? $json_object->fetch_security_authentication_method_configuration->name_label : '';
    $securityAuthenticationMethod['display_label'] = (isset($json_object->fetch_security_authentication_method_configuration->display_label)) ? $json_object->fetch_security_authentication_method_configuration->display_label : '';
    $securityAuthenticationMethod['description'] = (isset($json_object->fetch_security_authentication_method_configuration->description)) ? $json_object->fetch_security_authentication_method_configuration->description : '';
    $securityAuthenticationMethod['magic'] = (isset($json_object->fetch_security_authentication_method_configuration->magic)) ? $json_object->fetch_security_authentication_method_configuration->magic : '';
    $securityAuthenticationMethod['weighting'] = (isset($json_object->fetch_security_authentication_method_configuration->weighting)) ? $json_object->fetch_security_authentication_method_configuration->weighting : '';
    $securityAuthenticationMethod['is_active'] = (isset($json_object->fetch_security_authentication_method_configuration->is_active)) ? $json_object->fetch_security_authentication_method_configuration->is_active : '';
    
    // Escape output
    $securityAuthenticationMethod['uuid'] = htmlspecialchars($securityAuthenticationMethod['uuid'], ENT_COMPAT | ENT_HTML5);
    $securityAuthenticationMethod['name_label'] = htmlspecialchars($securityAuthenticationMethod['name_label'], ENT_COMPAT | ENT_HTML5);
    $securityAuthenticationMethod['display_label'] = htmlspecialchars($securityAuthenticationMethod['display_label'], ENT_COMPAT | ENT_HTML5);
    $securityAuthenticationMethod['description'] = htmlspecialchars($securityAuthenticationMethod['description'], ENT_NOQUOTES | ENT_HTML5);
    $securityAuthenticationMethod['magic'] = htmlspecialchars($securityAuthenticationMethod['magic'], ENT_NOQUOTES | ENT_HTML5);
    $securityAuthenticationMethod['weighting'] = htmlspecialchars($securityAuthenticationMethod['weighting'], ENT_COMPAT | ENT_HTML5);
  }
  
  unset($json_security_authentication_method);
  unset($json_object);
  unset($butr_command);  
?>
<div id="configuration_security_authentication_method_modify_box">
  <fieldset form="configuration_security_authentication_method_modify_form" name="configuration_security_authentication_method_modify_fieldset" id="configuration_security_authentication_method_modify_fieldset">
    <legend><?php echo gettext('Modify Security Authentication Method Configuration'); ?></legend>
    <form name="configuration_security_authentication_method_modify_form" method="post" onsubmit="javascript:return processConfigurationSecurityAutenticationMethodModifyForm();">
      <label for="name_label" id="name_label_label"><?php echo gettext('Name Label'); ?>:</label>
      <input type="text" name="name_label" id="name_label" value="<?php echo $securityAuthenticationMethod['name_label']; ?>"><br>
      <label for="display_label" id="display_label_label"><?php echo gettext('Display Label'); ?>:</label>
      <input type="text" name="display_label" id="display_label" value="<?php echo $securityAuthenticationMethod['display_label']; ?>"><br>
      <label for="description" id="description_label"><?php echo gettext('Description'); ?>:</label>
      <textarea type="text" name="description" id="description"><?php echo $securityAuthenticationMethod['description']; ?></textarea><br>
      <label for="magic" id="magic_label"><?php echo gettext('Magic'); ?>:</label>
      <input type="text" name="magic" id="magic" value="<?php echo $securityAuthenticationMethod['magic']; ?>"><br>
      <label for="weighting" id="weighting_label"><?php echo gettext('Weighting'); ?>:</label>
      <input type="text" name="weighting" id="weighting" value="<?php echo $securityAuthenticationMethod['weighting']; ?>"><br>
      <label for="is_active" id="is_active_label"><?php echo gettext('Is Active'); ?>:</label>
      <input type="checkbox" name="is_active" id="is_active" value="1"<?php if ($securityAuthenticationMethod['is_active'] == 1) { echo ' checked'; } ?>><br>
      <label for="submit">&nbsp;</label>
      <button type="submit" name="submit" id="submit"><?php echo gettext('Modify Security Authentication Method Configuration'); ?></button>
      <input type="hidden" name="uuid" value="<?php echo $securityAuthenticationMethod['uuid']; ?>">
    </form>
  </fieldset>
</div><!-- /#configuration_security_authentication_method_modify_box -->

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
  
  // Grab global titles
  $butr_command = new Butr\CommandListSecurityAuthenticationMethodConfigurations();
  $butr_command->setAll($offset, $size, $direction, $ordinal);
  $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
  $butr_command->prepareCommand();
  $json_users = $butr_command->sendCommand();
  $json_object = json_decode($json_users, false);
  $json_error = json_last_error();
  
  if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
    $total_count = $json_object->list_security_authentication_method_configurations->total_count;
  }
  
  if ($total_count == '' || !isset($total_count)) {
    $total_count = 0;
  }
  
  $butr_pagination = new Butr\Pagination();
  $butr_pagination->setAll($total_count, $size, $offset, $ordinal, $direction, $language_code,
      Butr\PAGINATION_TYPE_PAGE, 'setHistoryConfigurationSecurityAuthenticationMethodList');
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
  for($i = 0; $i < sizeof($json_object->list_security_authentication_method_configurations->items); $i++) {
?>
    <tr class="<?php echo ($alternate = !$alternate) ? 'odd' : 'even'; ?>">
      <td><?php echo htmlspecialchars($json_object->list_security_authentication_method_configurations->items[$i]->name_label, ENT_COMPAT | ENT_HTML5); ?></td>
      <td><button onclick="javascript:setHistoryConfigurationSecurityAuthenticationMethodFetch('<?php echo htmlspecialchars($json_object->list_security_authentication_method_configurations->items[$i]->uuid, ENT_COMPAT | ENT_HTML5); ?>');"><?php echo gettext('Modify'); ?></button></td>
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
  <li><a href="javascript:setHistoryConfigurationSecurityAuthenticationMethodAdd();"><?php echo gettext('Add Security Authentication Method Configuration'); ?></a></li>
  <li><a href="javascript:setHistoryConfigurationSecurityAuthenticationMethodList(0, '<?php echo $default_list_size; ?>', '<?php echo Butr\SORT_ORDINAL_DEFAULT; ?>', '<?php echo Butr\SORT_DIRECTION_ASCENDING; ?>');"><?php echo gettext('List Security Authentication Method Configurations'); ?></a></li>
</ul>
<?php
}
// Generate bottom part of the page including flushing the buffer.
$butr_page_fragment->generateHtmlBottom();