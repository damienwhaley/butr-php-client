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

$basedir = dirname(__FILE__);
$basedir = substr($basedir, 0, strlen($basedir)-5);
require_once($basedir . 'includes/autoload.inc');
require_once($basedir . 'includes/uuid.inc');
require_once($basedir . 'includes/settings.inc');

/**
 * This tests the Authentication class
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
class AuthenticationTest extends PHPUnit_Framework_TestCase
{
  protected $_testClass;
  private $_nonce;
  private $_authentication_method;
  private $_username;
  private $_password;
  private $_session_token;
  private $_window_name;
  
  public function setUp() {
    $this->_testClass = new Butr\Authentication();
    $this->_nonce = Butr\uuidSecure();
    $this->_authentication_method = 'authentication_method';
    $this->_username = 'username';
    $this->_password = '824055186b70c92d637426f36dbf4806ec5962dc8580b980cff02213f89c6802';
    $this->_session_token = Butr\uuidSecure();
    $this->_window_name = Butr\uuidSecure();
    
    $_COOKIE['Butr|'.$this->_window_name] = $this->_session_token;
  }
  
  public function testResetAll() {
    $this->_testClass->resetAll();
    
    $this->assertEquals('', $this->_testClass->getNonce());
    $this->assertEquals(Butr\API_KEY, $this->_testClass->getApiKey());
    $this->assertEquals(Butr\API_SECRET, $this->_testClass->getApiSecret());
    $this->assertEquals('', $this->_testClass->getAuthenticationMethod());
    $this->assertEquals('', $this->_testClass->getUsername());
    $this->assertEquals('', $this->_testClass->getPassword());
    $this->assertEquals('', $this->_testClass->getSessionToken());
  }
  
  /**
   * @depends testResetAll
   */
  public function testSetAll() {
    $this->_testClass->resetAll();
    
    $this->_testClass->setAll($this->_nonce, $this->_authentication_method,
      $this->_username, $this->_password);

    $this->assertEquals($this->_nonce, $this->_testClass->getNonce());
    $this->assertEquals(Butr\API_KEY, $this->_testClass->getApiKey());
    $this->assertEquals(Butr\API_SECRET, $this->_testClass->getApiSecret());
    $this->assertEquals($this->_authentication_method, $this->_testClass->getAuthenticationMethod());
    $this->assertEquals($this->_username, $this->_testClass->getUsername());
    $this->assertEquals($this->_password, $this->_testClass->getPassword());
  }
  
  /**
   * @depends testResetAll
   */
  public function testSetSessionToken() {
    $this->_testClass->resetAll();
    $this->_testClass->setSessionToken($this->_session_token);
    $this->assertEquals($this->_session_token, $this->_testClass->getSessionToken());
  
    $this->_testClass->resetAll();
    $this->_testClass->setSessionToken('not-a-uuid');
    $this->assertEquals('', $this->_testClass->getSessionToken());
  
    $this->_testClass->resetAll();
    $this->_testClass->setSessionToken(null);
    $this->assertEquals('', $this->_testClass->getSessionToken());
  
    $this->_testClass->resetAll();
    $this->_testClass->setSessionToken(200);
    $this->assertEquals('', $this->_testClass->getSessionToken());
  }
  
  /**
   * @depends testResetAll
   */
  public function testSetNonce() {
    $this->_testClass->resetAll();
    $this->_testClass->setNonce($this->_nonce);
    $this->assertEquals($this->_nonce, $this->_testClass->getNonce());
  
    $this->_testClass->resetAll();
    $this->_testClass->setNonce('not-a-uuid');
    $this->assertEquals('', $this->_testClass->getNonce());
  
    $this->_testClass->resetAll();
    $this->_testClass->setNonce(null);
    $this->assertEquals('', $this->_testClass->getNonce());
  
    $this->_testClass->resetAll();
    $this->_testClass->setNonce(200);
    $this->assertEquals('', $this->_testClass->getNonce());
  }
  
  /**
   * @depends testResetAll
   */
  public function testSetCountryCode() {
    $this->_testClass->resetAll();
    $this->_testClass->setAuthenticationMethod($this->_authentication_method);
    $this->assertEquals($this->_authentication_method, $this->_testClass->getAuthenticationMethod());
    
    $this->_testClass->resetAll();
    $this->_testClass->setAuthenticationMethod(null);
    $this->assertEquals('', $this->_testClass->getAuthenticationMethod());
  }
  
  /**
   * @depends testResetAll
   */
  public function testSetUsername() {
    $this->_testClass->resetAll();
    $this->_testClass->setUsername($this->_username);
    $this->assertEquals($this->_username, $this->_testClass->getUsername());
  
    $this->_testClass->resetAll();
    $this->_testClass->setUsername(null);
    $this->assertEquals('', $this->_testClass->getUsername());
  }
  
  /**
   * @depends testResetAll
   */
  public function testSetPassword() {
    $this->_testClass->resetAll();
    $this->_testClass->setPassword($this->_password);
    $this->assertEquals($this->_password, $this->_testClass->getPassword());
  
    $this->_testClass->resetAll();
    $this->_testClass->setPassword('not-a-valid-password');
    $this->assertEquals('', $this->_testClass->getPassword());
    
    $this->_testClass->resetAll();
    $this->_testClass->setPassword(null);
    $this->assertEquals('', $this->_testClass->getPassword());
    
    $this->_testClass->resetAll();
    $this->_testClass->setPassword(200);
    $this->assertEquals('', $this->_testClass->getPassword());
  }
  
  public function testFetchSessionCookie() {
    $this->assertEquals($this->_session_token, $this->_testClass->fetchSessionCookie($this->_window_name));
    $this->assertEquals('', $this->_testClass->fetchSessionCookie('not a window name'));
  }
  
  public function tearDown() {
    unset($this->_testClass);
    unset($_COOKIE['Butr|'.$this->_window_name]);
  }
}
