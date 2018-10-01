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

/**
 * This checks the login form to ensure that the fields are populated
 * before the form is submitted. It also hashes the password and
 * clears the password field so that the user's password is not
 * transmitted over the wire in clear text.
 * @author Damien Whaley <damien@whelbonestudios.com>
 */
function processLogInForm() {
  'use strict';
  
  var errorMessage = '';
  var username = document.log_in_form.username.value;
  var password = document.log_in_form.password.value;
  var nonce = document.log_in_form.nonce.value;
  var globalLanguage = document.log_in_form.global_language.value;
  var authenticationMethod = document.log_in_form.authentication_method.value;
  
  hideAllModalsAndAlerts();
  
  $('#submit').prop('disabled', 'disabled');
  
  if (username === undefined || username === null || username === '') {
    errorMessage += '<br>* '+butr_i18n_Username;
  }
  if (password === undefined || password === null || password === '') {
    errorMessage += '<br>* '+butr_i18n_Password;
  }
  if (nonce === undefined || nonce === null || nonce === '') {
    nonce = uuid.v4();
    document.log_in_form.nonce.value = nonce;
  }
  if (globalLanguage === undefined || globalLanguage === null) {
    globalLanguage = '';
  }
  if (authenticationMethod === undefined || authenticationMethod === null || authenticationMethod === '') {
    errorMessage += '<br>* '+butr_i18n_AuthenticationMethod;
  }
  
  if (errorMessage !== '') {
    $('#warning_alert_message').html(butr_i18n_PleaseCheckThatYouHaveCompleted+':'+errorMessage);
    $('#warning_alert').show();
    $('#submit').removeProp('disabled');
    return false;
  }
  
  var form_body = '';
  var passwordHash = Crypto.util.bytesToHex(Crypto.HMAC(Crypto.SHA256, Crypto.util.bytesToHex(Crypto.HMAC(Crypto.SHA256, username, password, { asBytes: true })), nonce, { asBytes: true }));
  
  document.log_in_form.password.value = '';
  
  form_body = 'username=' + escape(username)
    + '&password_hash=' + escape(passwordHash)
    + '&nonce=' + escape(nonce)
    + '&authentication_method=' + escape(authenticationMethod)
    + '&language=' + escape(globalLanguage)
    + '&command=create_session'
    + '&window_name=' + escape(window.name);
    
  $.ajax({
    url: 'ajax/index.php',
    data: form_body,
    type: 'POST',
    contentType: 'application/x-www-form-urlencoded',
    success: function(data, textStatus, jqXHR) {
      try {
        processLogInResponse(JSON.parse(jqXHR.responseText));
      } catch (e) {
        handleLogInError(jqXHR.responseText);
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      handleLogInError(jqXHR.responseText);
    }
  });
  
  return false;
}

/**
 * This function handles the log in and then posts to the next system screen.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param res
 *   - object containing the JSON response from the Butr server.
 */
function processLogInResponse(res) {
  'use strict';
  
  var responseStatus = '';
  var sessionToken = '';
  var explanation = '';

  if (res === undefined || res === null || typeof(res) !== 'object') {
    return handleLogInError(res);
  }
  
  if (res.result !== undefined) {
    if (res.result.status !== undefined && res.result.status !== null && res.result.status !== '') {
      responseStatus = res.result.status ;
    }
  }

  if (res.authentication !== undefined) {
    if (res.authentication.session_token !== undefined && res.authentication.session_token !== null && res.authentication.sesion_token !== '') {
      sessionToken = res.authentication.session_token;
    }
  }
  
  if (responseStatus === 'OK' && sessionToken !== '') {
    // Set window name to allow different sessions in different
    // tabs in the same browser.
    var cookieName = 'Butr|' + document.log_in_done.window.value;
    
    window.name = document.log_in_done.window.value;

    createCookie(cookieName, sessionToken, null);
    
    document.log_in_done.token.value = sessionToken;
    document.log_in_done.submit();
    return;
  }

  return handleLogInError(res);
}

/**
 * This handles any errors and displays them in an error div.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param res
 *   - object or string containing the response from the server.
 */
function handleLogInError(res) {
  'use strict';
  
  var responseStatus = '';
  var explanation = '';
  
  try {
    res = JSON.parse(res);
  }
  catch (e) {
    // Do nothing.
  }

  if (res !== null && res !== undefined && typeof(res) === 'object') {
    if (res.result !== undefined) {
      if (res.result.status !== undefined && res.result.status !== null && res.result.status !== '') {
        responseStatus = res.result.status ;
      }
    }

    if (responseStatus !== 'OK') {
      if (res.result !== undefined) {
        if (res.result.explanation !== undefined && res.result.explanation !== null && res.result.explanation !== '') {
          explanation = res.result.explanation;
        }
      }
    }
  }
  
  if (explanation === '') {
    explanation = butr_i18n_CouldNotLogIn+'.';
  }

  if (responseStatus !== 'OK') {
    $('#error_modal_message').html(explanation);
    $('#error_modal').modal('show');
  }
  
  $('#submit').removeProp('disabled');
}

/**
 * This tests the capability of the browser to make sure it is sufficient.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function testCapabilities() {
  'use strict';
  
  var missing = '';
  
  hideAllModalsAndAlerts();
  
  $('#submit').removeProp('disabled');
  $('#submit').prop('class', 'btn btn-primary');
  
  if (!Modernizr.history) {
    missing += '<br>* '+butr_i18n_HistoryApi;
  }
  
  if (missing != '') {
    missing = butr_i18n_YourBrowserDoesNotHave+':'+missing;
    $('#submit').prop('disabled', 'disabled');
    $('#error_modal_message').html(missing);
    $('#error_modal').modal('show');
  } else {
	// Check we can communicate with server.
    processPing();
  }
}

/**
 * This pings the butr server to make sure that it is up.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function processPing() {
  'use strict';
  
  var form_body = '';
  
  form_body = 'command=ping'
    + '&window_name=' + escape(window.name);
  
  $.ajax({
    url: 'ajax/index.php',
    data: form_body,
    type: 'POST',
    contentType: 'application/x-www-form-urlencoded',
    success: function(data, textStatus, jqXHR) {
      try {
        processPingResponse(JSON.parse(jqXHR.responseText));
      } catch (e) {
        handlePingError(jqXHR.responseText);
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      handlePingError(jqXHR.responseText);
    }
  });
}


/**
 * This function handles the ping response and enables the form
 * submission.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param res
 *   - object containing the JSON response from the Butr server.
 */
function processPingResponse(res) {
  'use strict';
  
  var responseStatus = '';

  if (res === undefined || res === null || typeof(res) !== 'object') {
    return handlePingError(res);
  }
  
  if (res.result !== undefined) {
    if (res.result.status !== undefined && res.result.status !== null && res.result.status !== '') {
      responseStatus = res.result.status ;
    }
  }
  
  if (responseStatus === 'OK') {
	// Can communicate with server so allow user to log in.
	$('#submit').removeProp('disabled');
    return;
  }

  return handlePingError(res);
}

/**
 * This handles any errors and displays them in an error div.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param res
 *   - object or string containing the response from the server.
 */
function handlePingError(res) {
  'use strict';
  
  var responseStatus = '';
  var explanation = '';
  
  try {
    res = JSON.parse(res);
  }
  catch (e) {
    // Do nothing.
  }

  if (res !== null && res !== undefined && typeof(res) === 'object') {
    if (res.result !== undefined) {
      if (res.result.status !== undefined && res.result.status !== null && res.result.status !== '') {
        responseStatus = res.result.status ;
      }
    }

    if (responseStatus !== 'OK') {
      if (res.result !== undefined) {
        if (res.result.explanation !== undefined && res.result.explanation !== null && res.result.explanation !== '') {
          explanation = res.result.explanation;
        }
      }
    }
  }
  
  if (explanation === '') {
    explanation = butr_i18n_CouldNotCommunicate+'. '+butr_i18n_PleaseCheckAndRefreshPage+'.';
  }

  if (responseStatus !== 'OK') {
    $('#error_modal_message').html(explanation);
    $('#error_modal').modal('show');
  }
  
  $('#submit').prop('disabled', 'disabled');
}