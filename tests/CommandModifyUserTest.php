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
 * This tests the CommandModifyUser class
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
class SelectEqualsTest extends PHPUnit_Framework_TestCase
{
  protected $_testClass;
  protected $_uuid;
  protected $_global_title_uuid;
  protected $_first_name;
  protected $_last_name;
  protected $_preferred_global_language_uuid;
  protected $_username;
  
  public function setUp() {
    $this->_testClass = new Butr\CommandModifyUser();
    $this->_global_title_uuid = Butr\uuidSecure();
    $this->_first_name = 'first_name';
    $this->_last_name = 'last_name';
    $this->_preferred_global_language_uuid = Butr\uuidSecure();
    $this->_username = 'username';
  }
  
  public function testResetAll() {
    $this->_testClass->resetAll();
    
    $this->assertEquals('', $this->_testClass->getUuid());
    $this->assertEquals('', $this->_testClass->getGlobalTitleUuid());
    $this->assertEquals('', $this->_testClass->getFirstName());
    $this->assertEquals('', $this->_testClass->getLastName());
    $this->assertEquals('', $this->_testClass->getPreferredGlobalLanguageUuid());
    $this->assertEquals('', $this->_testClass->getUsername()); 
  }
  
  /**
   * @depends testResetAll
   */
  public function testSetAll() {
    $this->_testClass->resetAll();
    
    $this->_testClass->setAll($this->_uuid, $this->_global_title_uuid, $this->_first_name,
      $this->_last_name, $this->_preferred_global_language_uuid,
      $this->_username);

    $this->assertEquals($this->_uuid, $this->_testClass->getUuid());
    $this->assertEquals($this->_global_title_uuid, $this->_testClass->getGlobalTitleUuid());
    $this->assertEquals($this->_first_name, $this->_testClass->getFirstName());
    $this->assertEquals($this->_last_name, $this->_testClass->getLastName());
    $this->assertEquals($this->_preferred_global_language_uuid, $this->_testClass->getPreferredGlobalLanguageUuid());
    $this->assertEquals($this->_username, $this->_testClass->getUsername()); 
  }

  /**
   * @depends testResetAll
   */
  public function testSetUuid() {
    $this->_testClass->resetAll();
    $this->_testClass->setUuid($this->_uuid);
    $this->assertEquals($this->_uuid, $this->_testClass->getUuid());
  
    $this->_testClass->resetAll();
    $this->_testClass->setUuid('not-a-uuid');
    $this->assertEquals('', $this->_testClass->getUuid());
  
    $this->_testClass->resetAll();
    $this->_testClass->setUuid(null);
    $this->assertEquals('', $this->_testClass->getUuid());
  
    $this->_testClass->resetAll();
    $this->_testClass->setUuid(200);
    $this->assertEquals('', $this->_testClass->getUuid());
  }
  
  /**
   * @depends testResetAll
   */
  public function testSetGlobalTitleUuid() {
    $this->_testClass->resetAll();
    $this->_testClass->setGlobalTitleUuid($this->_global_title_uuid);
    $this->assertEquals($this->_global_title_uuid, $this->_testClass->getGlobalTitleUuid());
    
    $this->_testClass->resetAll();
    $this->_testClass->setGlobalTitleUuid('not-a-uuid');
    $this->assertEquals('', $this->_testClass->getGlobalTitleUuid());
    
    $this->_testClass->resetAll();
    $this->_testClass->setGlobalTitleUuid(null);
    $this->assertEquals('', $this->_testClass->getGlobalTitleUuid());
    
    $this->_testClass->resetAll();
    $this->_testClass->setGlobalTitleUuid(200);
    $this->assertEquals('', $this->_testClass->getGlobalTitleUuid());
  }
  
  /**
   * @depends testResetAll
   */
  public function testSetFirstName() {
    $this->_testClass->resetAll();
    $this->_testClass->setFirstName($this->_first_name);
    $this->assertEquals($this->_first_name, $this->_testClass->getFirstName());
  
    $this->_testClass->resetAll();
    $this->_testClass->setFirstName(null);
    $this->assertEquals('', $this->_testClass->getFirstName());
  }
  
  /**
   * @depends testResetAll
   */
  public function testSetLastName() {
    $this->_testClass->resetAll();
    $this->_testClass->setLastName($this->_last_name);
    $this->assertEquals($this->_last_name, $this->_testClass->getLastName());
  
    $this->_testClass->resetAll();
    $this->_testClass->setLastName(null);
    $this->assertEquals('', $this->_testClass->getLastName());
  }
  
  /**
   * @depends testResetAll
   */
  public function testSetPreferredGlobalLanguageUuid() {
    $this->_testClass->resetAll();
    $this->_testClass->setPreferredGlobalLanguageUuid($this->_preferred_global_language_uuid);
    $this->assertEquals($this->_preferred_global_language_uuid, $this->_testClass->getPreferredGlobalLanguageUuid());
  
    $this->_testClass->resetAll();
    $this->_testClass->setPreferredGlobalLanguageUuid('not-a-uuid');
    $this->assertEquals('', $this->_testClass->getPreferredGlobalLanguageUuid());
  
    $this->_testClass->resetAll();
    $this->_testClass->setPreferredGlobalLanguageUuid(null);
    $this->assertEquals('', $this->_testClass->getPreferredGlobalLanguageUuid());
  
    $this->_testClass->resetAll();
    $this->_testClass->setPreferredGlobalLanguageUuid(200);
    $this->assertEquals('', $this->_testClass->getPreferredGlobalLanguageUuid());
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
  
  public function testCommandName() {
    $this->assertEquals('modify_user', $this->_testClass->getCommandName());
  }
  
  public function tearDown() {
    unset($this->_testClass);
  }
}
