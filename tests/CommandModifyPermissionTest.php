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
 * This tests the CommandModifyPermission class
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
class SelectEqualsTest extends PHPUnit_Framework_TestCase
{
  protected $_testClass;
  protected $_uuid;
  protected $_module_uuid;
  protected $_permission_name;
  protected $_description;
  protected $_magic;
  protected $_importance;
  
  public function setUp() {
    $this->_testClass = new Butr\CommandModifyPermission();
    $this->_uuid = Butr\uuidSecure();
    $this->_module_uuid = Butr\uuidSecure();
    $this->_permission_name = 'permission_name';
    $this->_description = 'description';
    $this->_magic = 'magic';
    $this->_importance = 20;
  }
  
  public function testResetAll() {
    $this->_testClass->resetAll();
    
    $this->assertEquals('', $this->_testClass->getUuid());
    $this->assertEquals('', $this->_testClass->getModuleUuid());
    $this->assertEquals('', $this->_testClass->getPermissionName());
    $this->assertEquals('', $this->_testClass->getDescription());
    $this->assertEquals('', $this->_testClass->getMagic());
    $this->assertNull($this->_testClass->getImportance()); 
  }
  
  /**
   * @depends testResetAll
   */
  public function testSetAll() {
    $this->_testClass->resetAll();
    
    $this->_testClass->setAll($this->_uuid, $this->_module_uuid, $this->_permission_name, 
      $this->_description, $this->_magic, $this->_importance);

    $this->assertEquals($this->_uuid, $this->_testClass->getUuid());
    $this->assertEquals($this->_module_uuid, $this->_testClass->getModuleUuid());
    $this->assertEquals($this->_permission_name, $this->_testClass->getPermissionName());
    $this->assertEquals($this->_description, $this->_testClass->getDescription());
    $this->assertEquals($this->_magic, $this->_testClass->getMagic());
    $this->assertEquals($this->_importance, $this->_testClass->getImportance()); 
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
  public function testSetModuleUuid() {
    $this->_testClass->resetAll();
    $this->_testClass->setModuleUuid($this->_module_uuid);
    $this->assertEquals($this->_module_uuid, $this->_testClass->getModuleUuid());
  
    $this->_testClass->resetAll();
    $this->_testClass->setModuleUuid('not-a-uuid');
    $this->assertEquals('', $this->_testClass->getModuleUuid());
  
    $this->_testClass->resetAll();
    $this->_testClass->setModuleUuid(null);
    $this->assertEquals('', $this->_testClass->getModuleUuid());
  
    $this->_testClass->resetAll();
    $this->_testClass->setModuleUuid(200);
    $this->assertEquals('', $this->_testClass->getModuleUuid());
  }
  
  /**
   * @depends testResetAll
   */
  public function testSetPermissionName() {
    $this->_testClass->resetAll();
    $this->_testClass->setPermissionName($this->_permission_name);
    $this->assertEquals($this->_permission_name, $this->_testClass->getPermissionName());
  
    $this->_testClass->resetAll();
    $this->_testClass->setPermissionName(null);
    $this->assertEquals('', $this->_testClass->getPermissionName());
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
  public function testSetMagic() {
    $this->_testClass->resetAll();
    $this->_testClass->setMagic($this->_magic);
    $this->assertEquals($this->_magic, $this->_testClass->getMagic());
  
    $this->_testClass->resetAll();
    $this->_testClass->setMagic(null);
    $this->assertEquals('', $this->_testClass->getMagic());
  }
  
  /**
   * @depends testResetAll
   */
public function testSetImportance() {
    $this->_testClass->resetAll();
    $this->_testClass->setImportance($this->_importance);
    $this->assertEquals($this->_importance, $this->_testClass->getImportance());
  
    $this->_testClass->resetAll();
    $this->_testClass->setImportance(null);
    $this->assertNull($this->_testClass->getImportance());
  
    $this->_testClass->resetAll();
    $this->_testClass->setImportance('apple');
    $this->assertNull($this->_testClass->getImportance());
  
    $this->_testClass->resetAll();
    $this->_testClass->setImportance(-10);
    $this->assertEquals(-10, $this->_testClass->getImportance());
  }
  
  public function testCommandName() {
    $this->assertEquals('modify_permission', $this->_testClass->getCommandName());
  }
  
  public function tearDown() {
    unset($this->_testClass);
  }
}
