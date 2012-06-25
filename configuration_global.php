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

$global_uuid = '';
$global_uuid = (isset($_POST['uuid'])) ? $_POST['uuid'] : '';
if ($global_uuid === '' && isset($_GET['uuid'])) {
  $global_uuid = $_GET['uuid'];
}

$butr_authentication = new Butr\Authentication();
$butr_authentication->setSessionToken($session_token);

// Instantiate page fragment class for templated presentation.
$butr_page_fragment = new Butr\PageFragment();

// Generate the top part of the page fragment including buffering output.
$butr_page_fragment->generateHtmlTop(array('configuration_global.js'), array('configuration_global.css'), $language_code);

if (isset($_POST['a'])) {
  switch ($_POST['a']) {
    case 'add':
      //echo "<script type=\"text/javascript\">setHistoryConfigurationGlobalAdd();</script>\n";
      $action_mode = 'add';
      break;
    case 'fetch':
      $action_mode = 'fetch';
      break;
    case 'list':
      $action_mode = 'list';
      break;
    default:
      echo "<script type=\"text/javascript\">setHistoryConfigurationGlobal();</script>\n";
      $action_mode = '';
      break;
  }
} else {
  // Same as default in the switch case above.
  echo "<script type=\"text/javascript\">setHistoryConfigurationGlobal();</script>\n";
  $action_mode = '';
}
 
if ($action_mode === 'add') {
?>
<h1><?php echo gettext('Global Configuration Administration'); ?></h1>
<div id="configuration_global_add_box">
  <fieldset form="configuration_global_add_form" name="configuration_global_add_fieldset" id="configuration_global_add_fieldset">
    <legend><?php echo gettext('Add Global Configuration'); ?></legend>
    <form name="configuration_global_add_form" method="post" onsubmit="javascript:return processConfigurationGlobalAddForm();">
      <label for="name_label" id="name_label_label"><?php echo gettext('Name Label'); ?>:</label>
      <input type="text" name="name_label" id="name_label" value=""><br>
      <label for="display_label" id="display_label_label"><?php echo gettext('Display Label'); ?>:</label>
      <input type="text" name="display_label" id="display_label" value=""><br>
      <label for="magic" id="magic_label"><?php echo gettext('Magic'); ?>:</label>
      <input type="text" name="magic" id="magic" value=""><br>
      <label for="description" id="description_label"><?php echo gettext('Description'); ?>:</label>
      <textarea name="description" id="description"></textarea><br>
      <label for="text_setting" id="text_setting_label"><?php echo gettext('Text Setting'); ?>:</label>
      <textarea name="text_setting" id="text_setting" onblur="javascript:displayEffectiveSettingAdd();"></textarea><br>
      <label for="integer_setting" id="integer_setting_label"><?php echo gettext('Integer Setting'); ?>:</label>
      <input type="number" name="integer_setting" id="integer_setting" value="" onblur="javascript:displayEffectiveSettingAdd()";><br>
      <label for="float_setting" id="float_setting_label"><?php echo gettext('Float Setting'); ?>:</label>
      <input type="number" name="float_setting" id="float_setting" value="" onblur="javascript:displayEffectiveSettingAdd();"><br>
      <label for="datetime_setting" id="datetime_setting_label"><?php echo gettext('Date Time Setting'); ?>:</label>
      <input type="datetime" name="datetime_setting" id="datetime_setting" value="" onblur="javascript:datetimeCheckAdd();"><br>
      <label for="uuid_setting" id="uuid_setting_label"><?php echo gettext('UUID Setting'); ?>:</label>
      <input type="text" name="uuid_setting" id="uuid_setting" value="" onblur="javascript:displayEffectiveSettingAdd();"><br>
      <label for="bit_setting" id="bit_setting_label"><?php echo gettext('Bit Setting'); ?>:</label>
      <input type="checkbox" name="bit_setting" id="bit_setting" value="1" onblur="javascript:displayEffectiveSettingAdd();"><br>
      <label for="effective_setting" id="effective_setting_label"><?php echo gettext('Effective Setting')?>:</label>
      <div id="effective_setting">&nbsp;</div>
      <label for="submit">&nbsp;</label>
      <button type="submit" name="submit" id="submit"><?php echo gettext('Add Global Configuration'); ?></button>      
    </form>
  </fieldset>
</div><!-- /#configuration_global_add_box -->
<script type="text/javascript">
  datetimeCheckAdd();
</script>


<?php
} elseif ($action_mode === 'fetch') {
  // Fetch global configuration
  $butr_command = new Butr\CommandFetchGlobalConfiguration();
  $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
  $butr_command->setUuid($global_uuid);
  $butr_command->prepareCommand();
  $json_global = $butr_command->sendCommand();
  $json_object = json_decode($json_global, false);
  $json_error = json_last_error();
  
  $global = array();
  if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
    $global['uuid'] = (isset($json_object->fetch_global_configuration->uuid)) ? $json_object->fetch_global_configuration->uuid : '';
    $global['name_label'] = (isset($json_object->fetch_global_configuration->name_label)) ? $json_object->fetch_global_configuration->name_label : '';
    $global['display_label'] = (isset($json_object->fetch_global_configuration->display_label)) ? $json_object->fetch_global_configuration->display_label : '';
    $global['description'] = (isset($json_object->fetch_global_configuration->description)) ? $json_object->fetch_global_configuration->description : '';
    $global['magic'] = (isset($json_object->fetch_global_configuration->magic)) ? $json_object->fetch_global_configuration->magic : '';
    $global['text_setting'] = (isset($json_object->fetch_global_configuration->text_setting)) ? $json_object->fetch_global_configuration->text_setting : '';
    $global['integer_setting'] = (isset($json_object->fetch_global_configuration->integer_setting)) ? $json_object->fetch_global_configuration->integer_setting : '';
    $global['float_setting'] = (isset($json_object->fetch_global_configuration->float_setting)) ? $json_object->fetch_global_configuration->float_setting : '';
    $global['datetime_setting'] = (isset($json_object->fetch_global_configuration->datetime_setting)) ? $json_object->fetch_global_configuration->datetime_setting : '';
    $global['uuid_setting'] = (isset($json_object->fetch_global_configuration->uuid_setting)) ? $json_object->fetch_global_configuration->uuid_setting : '';
    $global['bit_setting'] = (isset($json_object->fetch_global_configuration->bit_setting)) ? $json_object->fetch_global_configuration->bit_setting : '';
    
    // Escape output
    $global['uuid'] = htmlspecialchars($global['uuid'], ENT_COMPAT | ENT_HTML5);
    $global['name_label'] = htmlspecialchars($global['name_label'], ENT_COMPAT | ENT_HTML5);
    $global['display_label'] = htmlspecialchars($global['display_label'], ENT_COMPAT | ENT_HTML5);
    $global['description'] = htmlspecialchars($global['description'], ENT_NOQUOTES | ENT_HTML5);
    $global['magic'] = htmlspecialchars($global['magic'], ENT_COMPAT | ENT_HTML5);
    $global['text_setting'] = htmlspecialchars($global['text_setting'], ENT_NOQUOTES | ENT_HTML5);
    $global['integer_setting'] = htmlspecialchars($global['integer_setting'], ENT_COMPAT | ENT_HTML5);
    $global['float_setting'] = htmlspecialchars($global['float_setting'], ENT_COMPAT | ENT_HTML5);
    $global['datetime_setting'] = htmlspecialchars($global['datetime_setting'], ENT_COMPAT | ENT_HTML5);
    $global['uuid_setting'] = htmlspecialchars($global['uudi_setting'], ENT_COMPAT | ENT_HTML5);
  }
  
  unset($json_global);
  unset($json_object);
  unset($butr_command);
?>
<h1><?php echo gettext('Global Configuration Administration'); ?></h1>
<div id="configuration_global_modify_box">
  <fieldset form="configuration_global_modify_form" name="configuration_global_modify_fieldset" id="location_country_modify_fieldset">
    <legend><?php echo gettext('Modify Global Configuration'); ?></legend>
    <form name="configuration_global_modify_form" method="post" onsubmit="javascript:return processConfigurationGlobalModifyForm();">
      <label for="name_label" id="name_label_label"><?php echo gettext('Name Label'); ?>:</label>
      <input type="text" name="name_label" id="name_label" value="<?php echo $global['name_label']; ?>"><br>
      <label for="display_label" id="display_label_label"><?php echo gettext('Display Label'); ?>:</label>
      <input type="text" name="display_label" id="display_label" value="<?php echo $global['display_label']; ?>"><br>
      <label for="magic" id="magic_label"><?php echo gettext('Magic'); ?>:</label>
      <input type="text" name="magic" id="magic" value="<?php echo $global['magic']; ?>"><br>
      <label for="description" id="description_label"><?php echo gettext('Description'); ?>:</label>
      <textarea name="description" id="description"><?php echo $global['description']; ?></textarea><br>
      <label for="text_setting" id="text_setting_label"><?php echo gettext('Text Setting'); ?>:</label>
      <textarea name="text_setting" id="text_setting" onblur="javascript:displayEffectiveSettingModify();"><?php echo $global['text_setting']; ?></textarea><br>
      <label for="integer_setting" id="integer_setting_label"><?php echo gettext('Integer Setting'); ?>:</label>
      <input type="number" name="integer_setting" id="integer_setting" value="<?php echo $global['integer_setting']; ?>" onblur="javascript:displayEffectiveSettingModify();"><br>
      <label for="float_setting" id="float_setting_label"><?php echo gettext('Float Setting'); ?>:</label>
      <input type="number" name="float_setting" id="float_setting" value="<?php echo $global['float_setting']; ?>" onblur="javascript:displayEffectiveSettingModify();"><br>
      <label for="datetime_setting" id="datetime_setting_label"><?php echo gettext('Date Time Setting'); ?>:</label>
      <input type="datetime" name="datetime_setting" id="datetime_setting" value="<?php echo $global['datetime_setting']; ?>" onblur="javascript:datetimeCheckModify();"><br>
      <label for="uuid_setting" id="uuid_setting_label"><?php echo gettext('UUID Setting'); ?>:</label>
      <input type="text" name="uuid_setting" id="uuid_setting" value="<?php echo $global['uuid_setting']; ?>" onblur="javascript:displayEffectiveSettingModify();"><br>
      <label for="bit_setting" id="bit_setting_label"><?php echo gettext('Bit Setting'); ?>:</label>
      <input type="checkbox" name="bit_setting" id="bit_setting" value="1"<?php if ($global['is_actve'] == 1) { echo ' checked'; } ?> onblur="javascript:displayEffectiveSettingModify();"><br>
      <label for="effective_setting" id="effective_setting_label"><?php echo gettext('Effective Setting')?>:</label>
      <div id="effective_setting">&nbsp;</div>
      <label for="submit">&nbsp;</label>
      <button type="submit" name="submit" id="submit"><?php echo gettext('Modify Global Configuration'); ?></button>
      <input type="hidden" name="uuid" value="<?php echo $global['uuid']; ?>">    
    </form>
  </fieldset>
</div><!-- /#configuration_global_modify_box -->
<script type="text/javascript">
  datetimeCheckModify();
</script>

<?php
} elseif ($action_mode === 'list') {
  $alternate = true;
  $default_list_size = Butr\DEFAULT_LIST_SIZE;
  
  // Fetch global default_list_size configuration value
  $butr_command = new Butr\CommandFetchGlobalConfiguration();
  $butr_command->setMagic('default_list_size');
  $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
  $butr_command->setUuid($country_uuid);
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
  
  // Grab global configurations
  $butr_command = new Butr\CommandListGlobalConfigurations();
  $butr_command->setAll($offset, $size, $direction, $ordinal);
  $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
  $butr_command->prepareCommand();
  $json_globals = $butr_command->sendCommand();
  $json_object = json_decode($json_globals, false);
  $json_error = json_last_error();
  
  if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
    $total_count = $json_object->list_global_configurations->total_count;
  }
  
  if ($total_count == '' || !isset($total_count)) {
    $total_count = 0;
  }
  
  $butr_pagination = new Butr\Pagination();
  $butr_pagination->setAll($total_count, $size, $offset, $ordinal, $direction, $language_code,
    Butr\PAGINATION_TYPE_PAGE, 'setHistoryConfigurationGlobalList');
  $butr_pagination->preparePagination();
?>
<h1><?php echo gettext('Global Configuration Administration'); ?></h1>
<table>
  <thead>
    <tr>
      <th><?php echo gettext('Name Label'); ?></th>
      <th><?php echo gettext('Magic'); ?></th>
      <th><?php echo gettext('Effective Setting'); ?></th>
      <th><?php echo gettext('Action'); ?></th>
    </tr>
  </thead>
  <tbody>
<?php
if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
  for($i = 0; $i < sizeof($json_object->list_global_configurations->items); $i++) {
?>
    <tr class="<?php echo ($alternate = !$alternate) ? 'odd' : 'even'; ?>">
      <td><?php echo htmlspecialchars($json_object->list_global_configurations->items[$i]->name_label, ENT_COMPAT | ENT_HTML5); ?></td>
      <td><?php echo htmlspecialchars($json_object->list_global_configurations->items[$i]->magic, ENT_COMPAT | ENT_HTML5); ?></td>
      <td><?php echo htmlspecialchars($json_object->list_global_configurations->items[$i]->effective_setting, ENT_COMPAT | ENT_HTML5); ?></td>
      <td><button onclick="javascript:setHistoryConfigurationGlobalFetch('<?php echo htmlspecialchars($json_object->list_global_configurations->items[$i]->uuid, ENT_COMPAT | ENT_HTML5); ?>');"><?php echo gettext('Modify'); ?></button></td>
    </tr>
<?php
  }
}
unset($json_globals);
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
  $butr_command->setUuid($country_uuid);
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
<h1><?php echo gettext('Global Configuration Administration'); ?></h1>
<ul>
  <li><a href="javascript:setHistoryConfigurationGlobalAdd();"><?php echo gettext('Add Global Configuration'); ?></a></li>
  <li><a href="javascript:setHistoryConfigurationGlobalList(0, '<?php echo $default_list_size; ?>', '<?php echo Butr\SORT_ORDINAL_DEFAULT; ?>', '<?php echo Butr\SORT_DIRECTION_ASCENDING; ?>');"><?php echo gettext('List Global Configuration'); ?></a></li>
</ul>
<?php
}
// Generate bottom part of the page including flushing the buffer.
$butr_page_fragment->generateHtmlBottom();