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
$uuid = '';
$window_name = (isset($_POST['window_name'])) ? $_POST['window_name'] : '';
$session_token = fetchSessionCookie($window_name);

// Instantiate page fragment class for templated presentation.
$butr_pageTab = new Butr\PageTab();
$butr_pageFragment = new Butr\PageFragment();

// Generate the top part of the page fragment including buffering output.
$butr_pageFragment->generateHtmlTop(null, null);
$butr_pageTab->generateHtmlTab();
$butr_pageFragment->generateHtmlMiddle($language_code);
echo "<script type=\"text/javascript\">setHistoryDashboard();</script>\n";
?>
<div class="well" id="dashboard_details">
  	<div class="row-fluid">
  		<div class="span12">
  		  <span class="lbl">Congratulations! You are logged in with session
  			  token: <?php echo $session_token; ?></span>
  		</div><!-- end .span12 -->
  	</div><!-- end .row -fluid-->
  </div><!-- end .well -->
<?php
// Generate bottom part of the page including flushing the buffer.
$butr_pageFragment->generateHtmlBottom();
