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

namespace Butr;

// Requires and includes
$document_root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once($document_root . '/includes/uuid.inc');

/**
  * Authentication class.
  */
class Authentication {
  
  /**
   * The shared API key.
   * @var string
   */
  private $_api_key;
  
  /**
   * The API secret, SHA256 hashed, then SHA256 hashed using nonce as salt, hex encoded.
   * @var string
   */
  private $_api_secret;
  
  /**
   * The nonce used for one-time hashing.
   * @var string
   *   - A UUID.
   */
  private $_nonce;
  
  /**
   * The authentication method.
   * @var string
   */
  private $_authentication_method;
  
  /**
   * The username of the person logging in.
   * @var string
   */
  private $_username;
  
  /**
   * The password, SHA256 hashed, then SHA256 hased using nonce as salt, hex encoded.
   * @var string
   */
  private $_password;
  
  /**
   * The token for an existing session. You can just provide this instead of all the others.
   * @var string
   *   - A UUID.
   */
  private $_session_token;
  
  /**
   * Default constructor.
   */
  public function __construct() {
    $this->_nonce = uuidSecure();
    $this->_api_key = API_KEY;
    $this->_api_secret = API_SECRET;
    $this->_authentication_method = '';
    $this->_username = '';
    $this->_password = '';
    $this->_session_token = '';
  }
  
  /**
   * This generates the snippet for the authentication attempt.
   * @return string
   *   - The JSON snippet for this authentication attempt.
   */
  public function generateSnippet() {
    $authentication = array();
    
    if($this->_session_token && strlen($this->_session_token) === 36) {
      // There's a session token, so just use that.
      $authentication = array('"authentication":{"session_token":"',
        $this->_session_token,
        '"}');
    } else {
      // Create a new session.
      $api_secret = hash_hmac('sha256', $this->_api_secret, $this->_nonce);
      
      $authentication = array('"authentication":{"api_key":"',
        $this->_api_key,
        '","api_secret":"',
        $api_secret,
        '","nonce":"',
        $this->_nonce,
        '","method":"',
        $this->_authentication_method,
        '","username":"',
        $this->_username,
        '","password":"',
        $this->_password,
        '"}');
    }
    
    if (sizeof($authentication) > 0) {
      return implode('', $authentication);
    } else {
      return '';
    }
  }
  
  /**
   * This returns the nonce used.
   * @return string
   *   - The uuid nonce generated for this authentication.
   */
  public function getNonce() {
    return $this->_nonce;
  }
  
  /**
   * This sets the nonce to generate the hashes correctly.
   * @param string $nonce
   *   - The UUID nonce to use.
   */
  public function setNonce($nonce) {
    if ($nonce && $nonce !== '') {
      $this->_nonce = $nonce;
    }
  }
  
  /**
   * This returns the username used.
   * @return string
   *   - The username for this authentication.
   */
  public function getUsername() {
    return $this->_username;
  }
  
  /**
   * This sets the username to generate the login correctly.
   * @param string $username
   *   - The string for the username.
  */
  public function setUsername($username) {
    if ($username && $username !== '') {
      $this->_username = $username;
    }
  }
  
  /**
   * This returns the authentication method used.
   * @return string
   *   - The method for this authentication.
   */
  public function getAuthenticationMethod() {
  return $this->_authentication_method;
  }
  
  /**
  * This sets the authentication method to generate the login correctly.
  * @param string $username
  *   - The string for the username.
  */
  public function setAuthenticationMethod($authentication_method) {
  if ($authentication_method && $authentication_method !== '') {
    $this->_authentication_method = $authentication_method;
      }
  }
  
  /**
   * This returns the session token used.
   * @return string
   *   - The session token for this authentication.
   */
  public function getSessionToken() {
  return $this->_session_token;
  }
  
  /**
  * This sets the username to generate the login correctly.
  * @param string $username
  *   - The string for the session token.
  */
  public function setSessionToken($session_token) {
  if ($session_token && $session_token !== '') {
    $this->_session_token = $session_token;
      }
  }
  
  /**
   * This sets the password to generate the login correctly.
   * @param string $password_hash
   *   - The string for the hashed password which was passed
   *     over the wire.
   */
  public function setPassword($password_hash) {
    if ($password_hash && strlen($password_hash) === 64) {
      $this->_password = $password_hash;
    }
  }
  
  
  /**
  * This fetches the session cookie.
   * @author Damien Whaley <damien@whalebonestudios.com>
  * @param string $window_name
  *   - String containing the name of the window (used to allow multiple windows
  *     each with different sessions).
  */
  public function fetchSessionCookie($window_name) {
  if (isset($_COOKIE['Butr|'.$window_name])) {
  return $_COOKIE['Butr|'.$window_name];
      }
      return '';
  }
}
