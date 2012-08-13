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

/**
 * This tests the CommandAddRegistration class
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
class CommandAddRegistrationTest extends PHPUnit_Framework_TestCase
{
  protected $_testClass;
  protected $_api_public;
  protected $_api_private;
  protected $_description;
  protected $security_client_type_uuid;
  protected $_is_active;
  
  public function setUp() {
    $this->_testClass = new Butr\CommandAddRegistration();
    $this->_api_public = Butr\uuidSecure();
    $this->_api_private = 'aed93600e8504ce0b2475b8f21c8085074b432a0cb226a6e0e1135945876854d';
    $this->_description = 'description';
    $this->_security_client_type_uuid = Butr\uuidSecure();
    $this->_is_active = 1;
  }
  
  public function testResetAll() {
    $this->_testClass->resetAll();
    
    $this->assertEquals('', $this->_testClass->getApiPublic());
    $this->assertEquals('', $this->_testClass->getApiPrivate());
    $this->assertEquals('', $this->_testClass->getDescription());
    $this->assertEquals('', $this->_testClass->getSecurityClientTypeUuid());
    $this->assertEquals(0, $this->_testClass->getIsActive()); 
  }
  
  /**
   * @depends testResetAll
   */
  public function testSetAll() {
    $this->_testClass->resetAll();
    
    $this->_testClass->setAll($this->_api_public, $this->_api_private,
        $this->_security_client_type_uuid, $this->_description,
        $this->_is_active);

    $this->assertEquals($this->_api_public, $this->_testClass->getApiPublic());
    $this->assertEquals($this->_api_private, $this->_testClass->getApiPrivate());
    $this->assertEquals($this->_description, $this->_testClass->getDescription());
    $this->assertEquals($this->_security_client_type_uuid, $this->_testClass->getSecurityClientTypeUuid());
    $this->assertEquals($this->_is_active, $this->_testClass->getIsActive()); 
  }

  /**
   * @depends testResetAll
   */
  public function testSetApiPublic() {
    $this->_testClass->resetAll();
    $this->_testClass->setApiPublic($this->_api_public);
    $this->assertEquals($this->_api_public, $this->_testClass->getApiPublic());
    
    $this->_testClass->resetAll();
    $this->_testClass->setApiPublic('not-a-uuid');
    $this->assertEquals('', $this->_testClass->getApiPublic());
    
    $this->_testClass->resetAll();
    $this->_testClass->setApiPublic(null);
    $this->assertEquals('', $this->_testClass->getApiPublic());
    
    $this->_testClass->resetAll();
    $this->_testClass->setApiPublic(200);
    $this->assertEquals('', $this->_testClass->getApiPublic());
  }
  
  /**
   * @depends testResetAll
   */
  public function testSetApiPrivate() {
    $this->_testClass->resetAll();
    $this->_testClass->setApiPrivate($this->_api_private);
    $this->assertEquals($this->_api_private, $this->_testClass->getApiPrivate());
    
    $this->_testClass->resetAll();
    $this->_testClass->setApiPrivate('not-a-sha256');
    $this->assertEquals('', $this->_testClass->getApiPrivate());
    
    $this->_testClass->resetAll();
    $this->_testClass->setApiPrivate(null);
    $this->assertEquals('', $this->_testClass->getApiPrivate());
    
    $this->_testClass->resetAll();
    $this->_testClass->setApiPrivate(200);
    $this->assertEquals('', $this->_testClass->getApiPrivate());
  }
  
  /**
   * @depends testResetAll
   */
  public function testSetDescription() {
    $this->_testClass->resetAll();
    $this->_testClass->setDescription($this->_description);
    $this->assertEquals($this->_description, $this->_testClass->getDescription());
  
    $this->_testClass->resetAll();
    $this->_testClass->setDescription(null);
    $this->assertEquals('', $this->_testClass->getDescription());
  }

  /**
   * @depends testResetAll
   */
  public function testSetSecurityClientTypeUuid() {
    $this->_testClass->resetAll();
    $this->_testClass->setSecurityClientTypeUuid($this->_security_client_type_uuid);
    $this->assertEquals($this->_security_client_type_uuid, $this->_testClass->getSecurityClientTypeUuid());
  
    $this->_testClass->resetAll();
    $this->_testClass->setSecurityClientTypeUuid('not-a-uuid');
    $this->assertEquals('', $this->_testClass->getSecurityClientTypeUuid());
  
    $this->_testClass->resetAll();
    $this->_testClass->setSecurityClientTypeUuid(null);
    $this->assertEquals('', $this->_testClass->getSecurityClientTypeUuid());
  
    $this->_testClass->resetAll();
    $this->_testClass->setSecurityClientTypeUuid(200);
    $this->assertEquals('', $this->_testClass->getSecurityClientTypeUuid());
  }
  
  /**
   * @depends testResetAll
   */
  public function testSetIsActive() {
    $this->_testClass->resetAll();
    $this->_testClass->setIsActive($this->_is_active);
    $this->assertEquals($this->_is_active, $this->_testClass->getIsActive());
  
    $this->_testClass->resetAll();
    $this->_testClass->setIsActive(null);
    $this->assertEquals(0, $this->_testClass->getIsActive());
  
    $this->_testClass->resetAll();
    $this->_testClass->setIsActive('apple');
    $this->assertEquals(0, $this->_testClass->getIsActive());
  
    $this->_testClass->resetAll();
    $this->_testClass->setIsActive(-10);
    $this->assertEquals(1, $this->_testClass->getIsActive());
    
    $this->_testClass->resetAll();
    $this->_testClass->setIsActive(10);
    $this->assertEquals(1, $this->_testClass->getIsActive());
    
    $this->_testClass->resetAll();
    $this->_testClass->setIsActive(0);
    $this->assertEquals(0, $this->_testClass->getIsActive());
  }
  
  public function testCommandName() {
    $this->assertEquals('add_registration', $this->_testClass->getCommandName());
  }
  
  public function tearDown() {
    unset($this->_testClass);
  }
}
