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

$country_uuid = '';
$country_uuid = (isset($_POST['uuid'])) ? $_POST['uuid'] : '';
if ($country_uuid === '' && isset($_GET['uuid'])) {
  $country_uuid = $_GET['uuid'];
}

$butr_authentication = new Butr\Authentication();
$butr_authentication->setSessionToken($session_token);

// Instantiate page fragment class for templated presentation.
$butr_page_fragment = new Butr\PageFragment();

// Generate the top part of the page fragment including buffering output.
$butr_page_fragment->generateHtmlTop(array('location_country.js'), array('location_country.css'), $language_code);

if (isset($_POST['a'])) {
  switch ($_POST['a']) {
    case 'add':
      echo "<script type=\"text/javascript\">setHistoryLocationCountryAdd();</script>\n";
      $action_mode = 'add';
      break;
    case 'fetch':
      $action_mode = 'fetch';
      break;
    case 'list':
      $action_mode = 'list';
      break;
    default:
      echo "<script type=\"text/javascript\">setHistoryLocationCountry();</script>\n";
      $action_mode = '';
      break;
  }
} else {
  // Same as default in the switch case above.
  echo "<script type=\"text/javascript\">setHistoryLocationCountry();</script>\n";
  $action_mode = '';
}
 
if ($action_mode === 'add') {
?>
<h1><?php echo gettext('Country Administration'); ?></h1>
<div id="location_country_add_box">
  <fieldset form="location_country_add_form" name="location_country_add_fieldset" id="location_country_add_fieldset">
    <legend><?php echo gettext('Add Country'); ?></legend>
    <form name="location_country_add_form" method="post" onsubmit="javascript:return processLocationCountryAddForm();">
      <label for="country_name" id="country_name_label"><?php echo gettext('Country Name'); ?>:</label>
      <input type="text" name="country_name" id="country_name" value=""><br>
      <label for="display_name" id="display_name_label"><?php echo gettext('Display Name'); ?>:</label>
      <input type="text" name="display_name" id="display_name" value=""><br>
      <label for="description" id="description_label"><?php echo gettext('Description'); ?>:</label>
      <textarea name="description" id="description"></textarea><br>
      <label for="country_code" id="country_code_label"><?php echo gettext('Country Code'); ?>:</label>
      <input type="text" name="country_code" id="country_code" value=""><br>
      <label for="alternate_code" id="alternate_code_label"><?php echo gettext('Alternate Code'); ?>:</label>
      <input type="text" name="alternate_code" id="alternate_code" value=""><br>
      <label for="weighting" id="weighting_label"><?php echo gettext('Weighting'); ?>:</label>
      <input type="text" name="weighting" id="weighting" value=""><br>
      <label for="is_active" id="is_active_label"><?php echo gettext('Is Active'); ?>:</label>
      <input type="checkbox" name="is_active" id="is_active" value="1" checked><br>
      <label for="submit">&nbsp;</label>
      <button type="submit" name="submit" id="submit"><?php echo gettext('Add Country'); ?></button>      
    </form>
  </fieldset>
</div><!-- /#location_country_add_box -->

<?php
} elseif ($action_mode === 'fetch') {
  // Fetch country
  $butr_command = new Butr\CommandFetchCountry();
  $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
  $butr_command->setUuid($country_uuid);
  $butr_command->prepareCommand();
  $json_country = $butr_command->sendCommand();
  $json_object = json_decode($json_country, false);
  $json_error = json_last_error();
  
  $country = array();
  if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
    $country['uuid'] = (isset($json_object->fetch_country->uuid)) ? $json_object->fetch_country->uuid : '';
    $country['country_name'] = (isset($json_object->fetch_country->country_name)) ? $json_object->fetch_country->country_name : '';
    $country['description'] = (isset($json_object->fetch_country->description)) ? $json_object->fetch_country->description : '';
    $country['country_code'] = (isset($json_object->fetch_country->country_code)) ? $json_object->fetch_country->country_code : '';
    $country['alternate_code'] = (isset($json_object->fetch_country->alternate_code)) ? $json_object->fetch_country->alternate_code : '';
    $country['weighting'] = (isset($json_object->fetch_country->weighting)) ? $json_object->fetch_country->weighting : '';
    $country['is_actve'] = (isset($json_object->fetch_country->is_active)) ? $json_object->fetch_country->is_active : '';
    $country['display_name'] = (isset($json_object->fetch_country->display_name)) ? $json_object->fetch_country->display_name : '';
    
    // Escape output
    $country['uuid'] = htmlspecialchars($country['uuid'], ENT_COMPAT | ENT_HTML5, 'UTF-8');
    $country['country_name'] = htmlspecialchars($country['country_name'], ENT_COMPAT | ENT_HTML5, 'UTF-8');
    $country['description'] = htmlspecialchars($country['description'], ENT_NOQUOTES | ENT_HTML5, 'UTF-8');
    $country['country_code'] = htmlspecialchars($country['country_code'], ENT_COMPAT | ENT_HTML5, 'UTF-8');
    $country['alterate_code'] = htmlspecialchars($country['alternate_code'], ENT_COMPAT | ENT_HTML5, 'UTF-8');
    $country['weighting'] = htmlspecialchars($country['weighting'], ENT_COMPAT | ENT_HTML5, 'UTF-8');
    $country['display_name'] = htmlspecialchars($country['display_name'], ENT_COMPAT | ENT_HTML5, 'UTF-8');
  }
  
  unset($json_country);
  unset($json_object);
  unset($butr_command);
?>
<h1><?php echo gettext('Country Administration'); ?></h1>
<div id="location_country_modify_box">
  <fieldset form="location_country_modify_form" name="location_country_modify_fieldset" id="location_country_modify_fieldset">
    <legend><?php echo gettext('Modify Country'); ?></legend>
    <form name="location_country_modify_form" method="post" onsubmit="javascript:return processLocationCountryModifyForm();">
      <label for="country_name" id="country_name_label"><?php echo gettext('Country Name'); ?>:</label>
      <input type="text" name="country_name" id="country_name" value="<?php echo $country['country_name']; ?>"><br>
      <label for="display_name" id="display_name_label"><?php echo gettext('Display Name'); ?>:</label>
      <input type="text" name="display_name" id="display_name" value="<?php echo $country['display_name']; ?>"><br>
      <label for="description" id="description_label"><?php echo gettext('Description'); ?>:</label>
      <textarea name="description" id="description"><?php echo $country['description']; ?></textarea><br>
      <label for="country_code" id="country_code_label"><?php echo gettext('Country Code'); ?>:</label>
      <input type="text" name="country_code" id="country_code" value="<?php echo $country['country_code']; ?>"><br>
      <label for="alternate_code" id="alternate_code_label"><?php echo gettext('Alternate Code'); ?>:</label>
      <input type="text" name="alternate_code" id="alternate_code" value="<?php echo $country['alternate_code']; ?>"><br>
      <label for="weighting" id="weighting_label"><?php echo gettext('Weighting'); ?>:</label>
      <input type="text" name="weighting" id="weighting" value="<?php echo $country['weighting']; ?>"><br>
      <label for="is_active" id="is_active_label"><?php echo gettext('Is Active'); ?>:</label>
      <input type="checkbox" name="is_active" id="is_active" value="1"<?php if ($country['is_actve'] == 1) { echo ' checked'; } ?>><br>
      <label for="submit">&nbsp;</label>
      <button type="submit" name="submit" id="submit"><?php echo gettext('Modify Country'); ?></button>
      <input type="hidden" name="uuid" value="<?php echo $country['uuid']; ?>">    
    </form>
  </fieldset>
</div><!-- /#location_country_modify_box -->

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
  
  // Grab countries
  $butr_command = new Butr\CommandListCountries();
  $butr_command->setAll($offset, $size, $direction, $ordinal);
  $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
  $butr_command->prepareCommand();
  $json_countries = $butr_command->sendCommand();
  $json_object = json_decode($json_countries, false);
  $json_error = json_last_error();
  
  if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
    $total_count = $json_object->list_countries->total_count;
  }
  
  if ($total_count == '' || !isset($total_count)) {
    $total_count = 0;
  }
  
  $butr_pagination = new Butr\Pagination();
  $butr_pagination->setAll($total_count, $size, $offset, $ordinal, $direction, $language_code,
    Butr\PAGINATION_TYPE_PAGE, 'setHistoryLocationCountryList');
  $butr_pagination->preparePagination();
?>
<h1><?php echo gettext('Country Administration'); ?></h1>
<table>
  <thead>
    <tr>
      <th><?php echo gettext('Country Name'); ?></th>
      <th><?php echo gettext('Action'); ?></th>
    </tr>
  </thead>
  <tbody>
<?php
if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
  for($i = 0; $i < sizeof($json_object->list_countries->items); $i++) {
?>
    <tr class="<?php echo ($alternate = !$alternate) ? 'odd' : 'even'; ?>">
      <td><?php echo htmlspecialchars($json_object->list_countries->items[$i]->country_name, ENT_COMPAT | ENT_HTML5, 'UTF-8'); ?></td>
      <td><button onclick="javascript:setHistoryLocationCountryFetch('<?php echo htmlspecialchars($json_object->list_countries->items[$i]->uuid, ENT_COMPAT | ENT_HTML5, 'UTF-8'); ?>');"><?php echo gettext('Modify'); ?></button></td>
    </tr>
<?php
  }
}
unset($json_countries);
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
<h1><?php echo gettext('Country Administration'); ?></h1>
<ul>
  <li><a href="javascript:insertContent('location_country.php?a=add')"><?php echo gettext('Add Country'); ?></a></li>
  <li><a href="javascript:setHistoryLocationCountryList(0, '<?php echo $default_list_size; ?>', '<?php echo Butr\SORT_ORDINAL_DEFAULT; ?>', '<?php echo Butr\SORT_DIRECTION_ASCENDING; ?>');"><?php echo gettext('List Countries'); ?></a></li>
</ul>
<?php
}
// Generate bottom part of the page including flushing the buffer.
$butr_page_fragment->generateHtmlBottom();