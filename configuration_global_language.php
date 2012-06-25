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

$global_language_uuid = '';
$global_language_uuid = (isset($_POST['uuid'])) ? $_POST['uuid'] : '';
if ($global_language_uuid === '' && isset($_GET['uuid'])) {
  $global_language_uuid = $_GET['uuid'];
}

$butr_authentication = new Butr\Authentication();
$butr_authentication->setSessionToken($session_token);

// Instantiate page fragment class for templated presentation.
$butr_page_fragment = new Butr\PageFragment();

// Generate the top part of the page fragment including buffering output.
$butr_page_fragment->generateHtmlTop(array('configuration_global_language.js'), array('configuration_global_language.css'), $language_code);

if (isset($_POST['a'])) {
  switch ($_POST['a']) {
    case 'add':
      echo "<script type=\"text/javascript\">setHistoryConfigurationGlobalLanguageAdd();</script>\n";
      $action_mode = 'add';
      break;
    case 'fetch':
      $action_mode = 'fetch';
      break;
    case 'list':
      $action_mode = 'list';
      break;
    default:
      echo "<script type=\"text/javascript\">setHistoryConfigurationGlobalLanguage();</script>\n";
      $action_mode = '';
      break;
  }
} else {
  // Same as default in the switch case above.
  echo "<script type=\"text/javascript\">setHistoryConfigurationGlobalLanguage();</script>\n";
  $action_mode = '';
}
?>
<h1><?php echo gettext('Global Language Configuration Administration'); ?></h1>
<?php
if ($action_mode === 'add') {
  // Grab country list
  $butr_command = new Butr\CommandListCountries();
  $butr_command->setAll(0, -1, Butr\SORT_DIRECTION_ASCENDING, Butr\SORT_ORDINAL_DEFAULT);
  $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
  $butr_command->prepareCommand();
  $json_countries = $butr_command->sendCommand();
  $json_object = json_decode($json_countries, false);
  $json_error = json_last_error();

  $country_option_list = array();
  if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
    for($i = 0; $i < sizeof($json_object->list_countries->items); $i++) {
      if (isset($json_object->list_countries->items[$i]->display_name)) {
        $country_option_list[] = "<option value=\""
          . htmlspecialchars($json_object->list_countries->items[$i]->uuid, ENT_COMPAT | ENT_HTML5)
          . "\">" . htmlspecialchars($json_object->list_countries->items[$i]->display_name, ENT_COMPAT | ENT_HTML5)
          . "</option>\n";
      } else {
        $country_option_list[] = "<option value=\""
          . htmlspecialchars($json_object->list_countries->items[$i]->uuid, ENT_COMPAT | ENT_HTML5)
          . "\">" . htmlspecialchars($json_object->list_countries->items[$i]->country_name, ENT_COMPAT | ENT_HTML5)
          . "</option>\n";
      }
    }
  }
  
  unset($json_countries);
  unset($json_object);
  unset($butr_command);
?>
<div id="configuration_global_language_add_box">
  <fieldset form="configuration_global_language_add_form" name="configuration_global_language_add_fieldset" id="configuration_global_language_add_fieldset">
    <legend><?php echo gettext('Add Global Language Configuration'); ?></legend>
    <form name="configuration_global_language_add_form" method="post" onsubmit="javascript:return processConfigurationGlobalLanguageAddForm();">
      <label for="name_label" id="name_label_label"><?php echo gettext('Name Label'); ?>:</label>
      <input type="text" name="name_label" id="name_label" value=""><br>
      <label for="display_label" id="display_label_label"><?php echo gettext('Display Label'); ?>:</label>
      <input type="text" name="display_label" id="display_label" value=""><br>
      <label for="description" id="description_label"><?php echo gettext('Description'); ?>:</label>
      <textarea type="text" name="description" id="description"></textarea><br>
      <label for="language_code" id="language_code_label"><?php echo gettext('Language Code'); ?>:</label>
      <input type="text" name="language_code" id="language_code" value=""><br>
      <label for="language_family" id="language_family_label"><?php echo gettext('Language Family'); ?>:</label>
      <input type="text" name="language_family" id="language_family" value=""><br>
      <label for="country_uuid" id="country_uuid_label"><?php echo gettext('Country'); ?>:</label>
      <select name="country_uuid">
        <option value=""><?php echo gettext('Please Select'); ?></option>
<?php echo implode($country_option_list, "\n") ?>
      </select><br>
      <label for="weighting" id="weighting_label"><?php echo gettext('Weighting'); ?>:</label>
      <input type="text" name="weighting" id="weighting" value=""><br>
      <label for="is_active" id="is_active_label"><?php echo gettext('Is Active'); ?>:</label>
      <input type="checkbox" name="is_active" id="is_active" value="1" checked><br>
      <label for="submit">&nbsp;</label>
      <button type="submit" name="submit" id="submit"><?php echo gettext('Add Global Language Configuration'); ?></button>      
    </form>
  </fieldset>
</div><!-- /#configuration_global_language_add_box -->

<?php
} elseif ($action_mode === 'fetch') {
  // Grab country list
  $butr_command = new Butr\CommandListCountries();
  $butr_command->setAll(0, -1, Butr\SORT_DIRECTION_ASCENDING, Butr\SORT_ORDINAL_DEFAULT);
  $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
  $butr_command->prepareCommand();
  $json_countries = $butr_command->sendCommand();
  $json_object = json_decode($json_countries, false);
  $json_error = json_last_error();

  $country_option_list = array();
  if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
    for($i = 0; $i < sizeof($json_object->list_countries->items); $i++) {
      if (isset($json_object->list_countries->items[$i]->display_name)) {
        $country_option_list[] = "<option value=\""
          . htmlspecialchars($json_object->list_countries->items[$i]->uuid, ENT_COMPAT | ENT_HTML5)
          . "\">" . htmlspecialchars($json_object->list_countries->items[$i]->display_name, ENT_COMPAT | ENT_HTML5)
          . "</option>\n";
      } else {
        $country_option_list[] = "<option value=\""
          . htmlspecialchars($json_object->list_countries->items[$i]->uuid, ENT_COMPAT | ENT_HTML5)
          . "\">" . htmlspecialchars($json_object->list_countries->items[$i]->country_name, ENT_COMPAT | ENT_HTML5)
          . "</option>\n";
      }
    }
  }
  
  unset($json_countries);
  unset($json_object);
  unset($butr_command);
  
  // Fetch global language configuration
  $butr_command = new Butr\CommandFetchGlobalLanguageConfiguration();
  $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
  $butr_command->setUuid($global_language_uuid);
  $butr_command->prepareCommand();
  $json_global_language = $butr_command->sendCommand();
  $json_object = json_decode($json_global_language, false);
  $json_error = json_last_error();
  
  $globalLanguage = array();
  if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
    $globalLanguage['uuid'] = (isset($json_object->fetch_global_language_configuration->uuid)) ? $json_object->fetch_global_language_configuration->uuid : '';
    $globalLanguage['name_label'] = (isset($json_object->fetch_global_language_configuration->name_label)) ? $json_object->fetch_global_language_configuration->name_label : '';
    $globalLanguage['display_label'] = (isset($json_object->fetch_global_language_configuration->display_label)) ? $json_object->fetch_global_language_configuration->display_label : '';
    $globalLanguage['description'] = (isset($json_object->fetch_global_language_configuration->description)) ? $json_object->fetch_global_language_configuration->description : '';
    $globalLanguage['language_code'] = (isset($json_object->fetch_global_language_configuration->language_code)) ? $json_object->fetch_global_language_configuration->language_code : '';
    $globalLanguage['language_family'] = (isset($json_object->fetch_global_language_configuration->language_family)) ? $json_object->fetch_global_language_configuration->language_family : '';
    $globalLanguage['country_uuid'] = (isset($json_object->fetch_global_language_configuration->country_uuid)) ? $json_object->fetch_global_language_configuration->country_uuid : '';
    $globalLanguage['weighting'] = (isset($json_object->fetch_global_language_configuration->weighting)) ? $json_object->fetch_global_language_configuration->weighting : '';
    $globalLanguage['is_active'] = (isset($json_object->fetch_global_language_configuration->is_active)) ? $json_object->fetch_global_language_configuration->is_active : '';
    
    // Escape output
    $globalLanguage['uuid'] = htmlspecialchars($globalLanguage['uuid'], ENT_COMPAT | ENT_HTML5);
    $globalLanguage['name_label'] = htmlspecialchars($globalLanguage['name_label'], ENT_COMPAT | ENT_HTML5);
    $globalLanguage['description'] = htmlspecialchars($globalLanguage['description'], ENT_NOQUOTES | ENT_HTML5);
    $globalLanguage['language_code'] = htmlspecialchars($globalLanguage['language_code'], ENT_COMPAT | ENT_HTML5);
    $globalLanguage['language_family'] = htmlspecialchars($globalLanguage['language_family'], ENT_COMPAT | ENT_HTML5);
    $globalLanguage['country_uuid'] = htmlspecialchars($globalLanguage['country_uuid'], ENT_COMPAT | ENT_HTML5);
    $globalLanguage['weighting'] = htmlspecialchars($globalLanguage['weighting'], ENT_COMPAT | ENT_HTML5);
  }
  
  unset($json_global_language);
  unset($json_object);
  unset($butr_command);  
?>
<div id="configuration_global_language_modify_box">
  <fieldset form="configuration_global_language_modify_form" name="configuration_global_language_modify_fieldset" id="configuration_global_language_modify_fieldset">
    <legend><?php echo gettext('Modify Global Language Configuration'); ?></legend>
    <form name="configuration_global_language_modify_form" method="post" onsubmit="javascript:return processConfigurationGlobalLanguageModifyForm();">
      <label for="name_label" id="name_label_label"><?php echo gettext('Name Label'); ?>:</label>
      <input type="text" name="name_label" id="name_label" value="<?php echo $globalLanguage['name_label']; ?>"><br>
      <label for="display_label" id="display_label_label"><?php echo gettext('Display Label'); ?>:</label>
      <input type="text" name="display_label" id="display_label" value="<?php echo $globalLanguage['display_label']; ?>"><br>
      <label for="description" id="description_label"><?php echo gettext('Description'); ?>:</label>
      <textarea type="text" name="description" id="description"><?php echo $globalLanguage['description']; ?></textarea><br>
      <label for="language_code" id="language_code_label"><?php echo gettext('Language Code'); ?>:</label>
      <input type="text" name="language_code" id="language_code" value="<?php echo $globalLanguage['language_code']; ?>"><br>
      <label for="language_family" id="language_family_label"><?php echo gettext('Language Family'); ?>:</label>
      <input type="text" name="language_family" id="language_family" value="<?php echo $globalLanguage['language_family']; ?>"><br>
      <label for="country_uuid" id="country_uuid_label"><?php echo gettext('Country'); ?>:</label>
      <select name="country_uuid">
        <option value=""><?php echo gettext('Please Select'); ?></option>
<?php echo implode($country_option_list, "\n") ?>
      </select><br>
      <label for="weighting" id="weighting_label"><?php echo gettext('Weighting'); ?>:</label>
      <input type="text" name="weighting" id="weighting" value="<?php echo $globalLanguage['weighting']; ?>"><br>
      <label for="is_active" id="is_active_label"><?php echo gettext('Is Active'); ?>:</label>
      <input type="checkbox" name="is_active" id="is_active" value="1"<?php if ($globalLanguage['is_active'] == 1) { echo ' checked'; } ?>><br>
      <label for="submit">&nbsp;</label>
      <button type="submit" name="submit" id="submit"><?php echo gettext('Modify Global Language Configuration'); ?></button>
      <input type="hidden" name="uuid" value="<?php echo $globalLanguage['uuid']; ?>">
    </form>
  </fieldset>
</div><!-- /#configuration_global_language_modify_box -->

<script type="text/javascript">
  document.configuration_global_language_modify_form.country_uuid.value = '<?php echo $globalLanguage['country_uuid']; ?>';
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
  
  // Grab global languages
  $butr_command = new Butr\CommandListGlobalLanguageConfigurations();
  $butr_command->setAll($offset, $size, $direction, $ordinal);
  $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
  $butr_command->prepareCommand();
  $json_users = $butr_command->sendCommand();
  $json_object = json_decode($json_users, false);
  $json_error = json_last_error();
  
  if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
    $total_count = $json_object->list_global_language_configurations->total_count;
  }
  
  if ($total_count == '' || !isset($total_count)) {
    $total_count = 0;
  }
  
  $butr_pagination = new Butr\Pagination();
  $butr_pagination->setAll($total_count, $size, $offset, $ordinal, $direction, $language_code,
      Butr\PAGINATION_TYPE_PAGE, 'setHistoryConfigurationGlobalLanguageList');
  $butr_pagination->preparePagination();
?>
<table>
  <thead>
    <tr>
      <th><?php echo gettext('Name Label'); ?></th>
      <th><?php echo gettext('Language Code'); ?></th>
      <th><?php echo gettext('Action')?></th>
    </tr>
  </thead>
  <tbody>
<?php
if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
  for($i = 0; $i < sizeof($json_object->list_global_language_configurations->items); $i++) {
?>
    <tr class="<?php echo ($alternate = !$alternate) ? 'odd' : 'even'; ?>">
      <td><?php echo htmlspecialchars($json_object->list_global_language_configurations->items[$i]->name_label, ENT_COMPAT | ENT_HTML5); ?></td>
      <td><?php echo htmlspecialchars($json_object->list_global_language_configurations->items[$i]->country_code, ENT_COMPAT | ENT_HTML5); ?></td>
      <td><button onclick="javascript:setHistoryConfigurationGlobalLanguageFetch('<?php echo htmlspecialchars($json_object->list_global_language_configurations->items[$i]->uuid, ENT_COMPAT | ENT_HTML5); ?>');"><?php echo gettext('Modify'); ?></button></td>
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
  <li><a href="javascript:setHistoryConfigurationGlobalLanguageAdd();"><?php echo gettext('Add Global Language Configuration'); ?></a></li>
  <li><a href="javascript:setHistoryConfigurationGlobalLanguageList(0, '<?php echo $default_list_size; ?>', '<?php echo Butr\SORT_ORDINAL_DEFAULT; ?>', '<?php echo Butr\SORT_DIRECTION_ASCENDING; ?>');"><?php echo gettext('List Global Language Configurations'); ?></a></li>
</ul>
<?php
}
// Generate bottom part of the page including flushing the buffer.
$butr_page_fragment->generateHtmlBottom();