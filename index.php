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
  $company_name_title = (isset($json_object->fetch_system_branding->company_name)) ? $json_object->fetch_system_branding->company_name : gettext('Log in');
  $default_language = (isset($json_object->fetch_system_branding->default_language)) ? $json_object->fetch_system_branding->default_language : '';

  // Escape output
  $system_version = htmlspecialchars($system_version, ENT_COMPAT | ENT_HTML5, 'UTF-8');
  $company_name = htmlspecialchars($company_name, ENT_COMPAT | ENT_HTML5, 'UTF-8');
  $default_language = htmlspecialchars($default_language, ENT_COMPAT | ENT_HTML5, 'UTF-8');
}
if ($company_name == '') {
  $company_name = gettext('Log In');
  $company_name_title = '';
}

// Instantiate page class for templated presentation.
$butr_page = new Butr\Page();

// Generate the top part of the page including buffering output.
$butr_page->generateHtmlTop($company_name, array('index.js'), null);
?>
<noscript>
<?php
echo gettext('Butr requires Javascript. Please enable it, or download a better browser.');
echo "\n";
?>
</noscript>
<div class="container-fluid">
	<div id="login">
			<h1><?php echo $company_name_title; ?>&nbsp;<?php echo gettext('Butr Log In'); ?></h1>
			<div class="well">
				<form name="log_in_form" action="#" method="post" accept-charset="utf-8" onsubmit="javascript:return processLogInForm();">
				  <input type="hidden" name="nonce" value="<?php echo Butr\uuidSecure(); ?>">
          <input type="hidden" name="authentication_method" value="local">
          <input type="hidden" name="global_language" value="">
					<div class="row-fluid">
						<div class="control-group span12">
							<label for="username" id="username_label"><?php echo gettext('Username'); ?></label>
							<input type="text" class="span12" id="username" name="username" value="" autofocus="autofocus" placeholder="<?php echo gettext('Username'); ?>">
						</div><!-- end .control-group -->
					</div><!-- end .row-fluid -->
					<div class="row-fluid">
						<div class="control-group span12">
							<label for="password" id="password_label"><?php echo gettext('Password'); ?></label>
							<input type="password" class="span12" id="password" name="password" value="" placeholder="<?php echo gettext('Password'); ?>">
						</div><!-- end .control-group -->
					</div><!-- end .row-fluid -->
					<div class="row-fluid">
						<div class="control-group span12">
							<button type="submit" class="btn btn-primary disabled" style="disabled: disabled;"><?php echo gettext('Log In'); ?></button>
						</div><!-- end .control-group -->
					</div><!-- end .row-fluid -->
					<div class="clearfix"></div>
				</form>
				<form name="log_in_done" action="butr.php" method="post">
          <input type="hidden" name="token" value="">
          <input type="hidden" name="window" value="<?php echo Butr\uuidSecure(); ?>">
        </form>
			</div><!-- end .well -->
			<p class="alignright help-text"><?php echo gettext('Version')?>:&nbsp;<?php echo $system_version; ?></p>
		</div><!-- end #login -->
</div><!-- end .container-fluid -->
<script type="text/javascript">
  $(document).ready(function () {
    'use strict';
    window.name = '';
    testCapabilities();
  }
</script>
<?php 
// Generate bottom part of the page including flushing the buffer.
$butr_page->generateHtmlBottom();
