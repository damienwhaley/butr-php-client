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
 * This tests the CommandModifyRole class
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
class SelectEqualsTest extends PHPUnit_Framework_TestCase
{
  protected $_testClass;
  protected $_uuid;
  protected $_partition_uuid;
  protected $_role_name;
  protected $_description;
  protected $_is_active;
  
  public function setUp() {
    $this->_testClass = new Butr\CommandModifyRole();
    $this->_uuid = Butr\uuidSecure();
    $this->_partition_uuid = Butr\uuidSecure();
    $this->_role_name = 'role_name';
    $this->_description = 'description';
    $this->_is_active = 1;
  }
  
  public function testResetAll() {
    $this->_testClass->resetAll();
    
    $this->assertEquals('', $this->_testClass->getUuid());
    $this->assertEquals('', $this->_testClass->getPartitionUuid());
    $this->assertEquals('', $this->_testClass->getRoleName());
    $this->assertEquals('', $this->_testClass->getDescription());
    $this->assertEquals(0, $this->_testClass->getIsActive()); 
  }
  
  /**
   * @depends testResetAll
   */
  public function testSetAll() {
    $this->_testClass->resetAll();
    
    $this->_testClass->setAll($this->_uuid, $this->_partition_uuid, $this->_role_name,
      $this->_description, $this->_is_active);

    $this->assertEquals($this->_uuid, $this->_testClass->getUuid());
    $this->assertEquals($this->_partition_uuid, $this->_testClass->getPartitionUuid());
    $this->assertEquals($this->_role_name, $this->_testClass->getRoleName());
    $this->assertEquals($this->_description, $this->_testClass->getDescription());
    $this->assertEquals($this->_is_active, $this->_testClass->getIsActive());
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
  public function testSetPartitionUuid() {
    $this->_testClass->resetAll();
    $this->_testClass->setPartitionUuid($this->_partition_uuid);
    $this->assertEquals($this->_partition_uuid, $this->_testClass->getPartitionUuid());
    
    $this->_testClass->resetAll();
    $this->_testClass->setPartitionUuid('not-a-uuid');
    $this->assertEquals('', $this->_testClass->getPartitionUuid());
    
    $this->_testClass->resetAll();
    $this->_testClass->setPartitionUuid(null);
    $this->assertEquals('', $this->_testClass->getPartitionUuid());
    
    $this->_testClass->resetAll();
    $this->_testClass->setPartitionUuid(200);
    $this->assertEquals('', $this->_testClass->getPartitionUuid());
  }
  
  /**
   * @depends testResetAll
   */
  public function testSetRoleName() {
    $this->_testClass->resetAll();
    $this->_testClass->setRoleName($this->_role_name);
    $this->assertEquals($this->_role_name, $this->_testClass->getRoleName());
  
    $this->_testClass->resetAll();
    $this->_testClass->setRoleName(null);
    $this->assertEquals('', $this->_testClass->getRoleName());
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
    $this->assertEquals('modify_role', $this->_testClass->getCommandName());
  }
  
  public function tearDown() {
    unset($this->_testClass);
  }
}
