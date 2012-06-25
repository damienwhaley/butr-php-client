<?php 
/*
* Butr Universal Travel Reservations
* A bleeding edge business management system for the travel industry.
*
* Copyright (C) 2012 Whalebone Studios and contributors.
*
* This program is free software: you can redistribute it and/or modify
* it under the terms of the GNU Affero General Public License as
* published by the Free Software Foundation, either version 3 of the
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

// Instantiate page class for templated presentation.
$butr_page = new Butr\Page();

// Generate the top part of the page including buffering output.
$butr_page->generate_html_top('Test for login', NULL, NULL);

// ------
$nonce = isset($_POST['nonce']) ? $_POST['nonce'] : Butr\uuidSecure();
$hashed_password = isset($_POST['hashed_password']) ? $_POST['hashed_password'] : '';
$hashed_api = isset($_POST['hashed_api']) ? $_POST['hashed_api'] : '';

echo "&gt;&gt;" . $_POST['hashed_api'] . '&lt;&lt;<br>';

$butr_authentication = new Butr\Authentication();

$butr_authentication->setNonce($nonce);
$butr_authentication->setUsername('damien');

$butr_authentication->setAuthenticationMethod('local');

$authentication_snippet = $butr_authentication->generateSnippet();
?>
<form name="login_form" action="test.php" method="post" onsubmit="javascript:return makePassword();">
 Username: <input type="text" name="username" value="damien"><br>
 Password: <input type="password" name="password" value=""><br>
 Nonce: <input type="text" name="nonce" value="<?php echo $nonce; ?>" size="50"><br>
 <input type="hidden" name="hashed_password" value="">
 <input type="hidden" name="hashed_api" value="">
 <input type="button" onclick="javascript:doCompare();" value="Compare">
 <input type="hidden" name="api" value="<?php echo Butr\API_SECRET; ?>">
 <input type="submit" value="Submit">
</form>
<form name="results">
 Javascript:<br>
 API Key: <span id="javascript_apikey"></span><br>
 API Secret: <span id="javascript_apisecret"></span><br>
 Username: <span id="javascript_username"></span><br>
 Password: <span id="javascript_password"></span><br>
 Nonce: <span id="javascript_nonce"></span><br>
 <hr>
<?php 
$butr_authentication->setPassword($hashed_password);

$hashed_api_key = hash_hmac('sha256', utf8_encode(Butr\API_SECRET), utf8_encode($nonce), false);

?>  
 PHP:<br>
 API Key: <span id="php_apikey"><?php echo Butr\API_KEY; ?></span><br>
 API Secret: <span id="php_apisecret"><?php echo $hashed_api_key; ?> / <?php echo $hashed_api; ?></span><br>
 Username: <span id="php_username">damien</span><br>
 Password: <span id="php_password"><?php echo $hashed_password;?></span><br>
 Nonce: <span id="php_nonce"><?php echo $nonce; ?></span><br>
 <hr>
 
</form>
<?php echo '??????????' . $hashed_api . '????????????'; ?>
<script type="text/javascript">
function doCompare() {
  'use strict';

  var SHA256 =  new Hashes.SHA256;
  
  var username = document.login_form.username.value;
  var password = document.login_form.password.value;
  var nonce = document.login_form.nonce.value;
  var apiKey = '9da7feb8-5f5c-11e1-8107-001c421dce29';
  var apiSecret = '9e9c3b093fd71f372823cd6d4ea8cc5ddd302aaf7df53b2dcd0f70c5d5a2508a';

  var hashed_api_secret = SHA256.hex_hmac(apiSecret, nonce);
  
  if (nonce === undefined || nonce === null || nonce === '') {
    nonce = uuid.v4();
    document.login_form.nonce.value = nonce;
  }

  var passwordHash = SHA256.hex_hmac(SHA256.hex_hmac(username, password), nonce);

  $('#javascript_apikey').html(apiKey);
  $('#javascript_apisecret').html(hashed_api_secret);
  $('#javascript_nonce').html(nonce);
  $('#javascript_username').html(username);
  $('#javascript_password').html(passwordHash); 
}

function makePassword() {
  'use strict';
  var SHA256 =  new Hashes.SHA256;
  
  var nonce = document.login_form.nonce.value;
  var username = document.login_form.username.value;
  var password = document.login_form.password.value;
  var hashed_password = SHA256.hex_hmac(SHA256.hex_hmac(username, password), nonce);

  var hashed_api = SHA256.hex_hmac(document.login_form.api.value, nonce);

  document.login_form.hashed_password.value = hashed_password;
  document.login_form.hashed_api.value = hashed_api;

  return true;
}


</script>



<?php 
// Generate bottom part of the page including flushing the buffer.
$butr_page->generate_html_bottom();
