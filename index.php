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
require_once('includes/uuid.inc');

$butr_authentication = new Butr\Authentication();
$butr_authentication->setSessionToken('');
$butr_authentication->setNonce(Butr\uuidSecure());

// Grab global language configuration settings
$butr_command = new Butr\CommandListGlobalLanguageConfigurations();
$butr_command->setAll(0, -1, Butr\SORT_DIRECTION_ASCENDING, Butr\SORT_ORDINAL_DEFAULT);
$butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
$butr_command->prepareCommand();
$json_global_language_configurations = $butr_command->sendCommand();
$json_object = json_decode($json_global_language_configurations, false);
$json_error = json_last_error();

$language_option_list = array();
if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
  for($i = 0; $i < sizeof($json_object->list_global_language_configurations->items); $i++) {
    if (isset($json_object->list_global_language_configurations->items[$i]->display_name)) {
      $language_option_list[] = "<option value=\"" . htmlspecialchars($json_object->list_global_language_configurations->items[$i]->language_code, ENT_COMPAT | ENT_HTML5)
        . "\">" . htmlspecialchars($json_object->list_global_language_configurations->items[$i]->display_label, ENT_COMPAT | ENT_HTML5)
        . "</option>\n";
    }
    else {
      $language_option_list[] = "<option value=\"" . htmlspecialchars($json_object->list_global_language_configurations->items[$i]->language_code, ENT_COMPAT | ENT_HTML5)
        . "\">" . htmlspecialchars($json_object->list_global_language_configurations->items[$i]->name_label, ENT_COMPAT | ENT_HTML5)
        . "</option>\n";
    }
  }
}
unset($json_global_language_configurations);
unset($json_object);
unset($butr_command);

// Fetch system branding
$butr_authentication->setNonce(Butr\uuidSecure());
$butr_command = new Butr\CommandFetchSystemBranding();
$butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
$butr_command->prepareCommand();
$json_global_configuration = $butr_command->sendCommand();
$json_object = json_decode($json_global_configuration, false);
$json_error = json_last_error();

if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
  $system_version = (isset($json_object->fetch_system_branding->system_version)) ? $json_object->fetch_system_branding->system_version : '';
  $company_name = (isset($json_object->fetch_system_branding->company_name)) ? $json_object->fetch_system_branding->company_name : gettext('Log in');
  $default_language = (isset($json_object->fetch_system_branding->default_language)) ? $json_object->fetch_system_branding->default_language : '';

  // Escape output
  $system_version = htmlspecialchars($system_version, ENT_COMPAT | ENT_HTML5);
  $company_name = htmlspecialchars($company_name, ENT_COMPAT | ENT_HTML5);
  $default_language = htmlspecialchars($default_language, ENT_COMPAT | ENT_HTML5);
}
if ($company_name == '') {
  $company_name = gettext('Log In');
}

// Instantiate page class for templated presentation.
$butr_page = new Butr\Page();

// Generate the top part of the page including buffering output.
$butr_page->generateHtmlTop($company_name, array('index.js'), array('index.css'));
?>
<noscript>
<?php
echo gettext('Butr requires Javascript. Please enable it, or download a better browser.');
echo "\n";
?>
</noscript>
<div id="log_in_box">
  <fieldset form="log_in_form" name="log_in_fieldset" id="log_in_fieldset">
    <legend><?php echo gettext('Log In'); ?></legend>
    <form name="log_in_form" method="post" onsubmit="javascript:return processLogInForm();">
      <label for="username" id="username_label"><?php echo gettext('Username'); ?>:</label>
      <input type="text" name="username" id="username" autofocus="autofocus" placeholder="<?php echo gettext('Username'); ?>"><br>
      <label for="password" id="password_label"><?php echo gettext('Password'); ?>:</label>
      <input type="password" name="password" id="password" placeholder="<?php echo gettext('Password'); ?>"><br>
      <label for="global_language" id="global_language_label"><?php echo gettext('Language'); ?>:</label>
      <select name="global_language">
        <option value=""><?php echo gettext('Default'); ?></option>
<?php echo implode($language_option_list, "\n") ?>
      </select><br>
      <label for="submit" id="submit_label">&nbsp;</label>
      <button type="submit" name="submit" id="submit" style="disabled: disabled;"><?php echo gettext('Log In'); ?></button><br>
      <input type="hidden" name="nonce" value="<?php echo Butr\uuidSecure(); ?>">
      <input type="hidden" name="authentication_method" value="local">
      <div id="system_version"><?php echo gettext('Version')?>:&nbsp;<?php echo $system_version; ?></div>
    </form>
  </fieldset>
</div><!-- /#log_in_box -->
<form name="log_in_done" action="butr.php" method="post">
  <input type="hidden" name="token" value="">
  <input type="hidden" name="window" value="<?php echo Butr\uuidSecure(); ?>">
</form>
<script type="text/javascript">
  window.name = '';
  testCapabilities();
</script>
<?php 
// Generate bottom part of the page including flushing the buffer.
$butr_page->generateHtmlBottom();
