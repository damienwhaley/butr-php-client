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
 * This tests the CommandModifyDockItem class
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
class SelectEqualsTest extends PHPUnit_Framework_TestCase
{
  protected $_testClass;
  protected $_uuid;
  protected $_dock_uuid;
  protected $_system_dock_type_uuid;
  protected $_security_client_type_uuid;
  protected $_item_name;
  protected $_display_name;
  protected $_description;
  protected $_weighting;
  protected $_picture_path;
  protected $_item_action;
  protected $_is_active;
  
  public function setUp() {
    $this->_testClass = new Butr\CommandModifyDockItem();
    $this->_uuid = Butr\uuidSecure();
    $this->_dock_uuid = Butr\uuidSecure();
    $this->_system_dock_type_uuid = Butr\uuidSecure();
    $this->_security_client_type_uuid = Butr\uuidSecure();
    $this->_item_name = 'item_name';
    $this->_display_name = 'display_name';
    $this->_description = 'description';
    $this->_weighting = 10;
    $this->_picture_path = 'picture_path';
    $this->_item_action = 'item_action';
    $this->_is_active = 1;
  }
  
  public function testSetAll() {
    $this->_testClass->resetAll();
    
    $this->_testClass->setAll($this->_uuid, $this->_dock_uuid, $this->_system_dock_type_uuid,
      $this->_security_client_type_uuid, $this->_item_name, $this->_display_name,
      $this->_description, $this->_weighting, $this->_picture_path,
      $this->_item_action, $this->_is_active);
    
    $this->assertEquals($this->_uuid, $this->_testClass->getUuid());
    $this->assertEquals($this->_dock_uuid, $this->_testClass->getDockUuid());
    $this->assertEquals($this->_system_dock_type_uuid, $this->_testClass->getSystemDockTypeUuid());
    $this->assertEquals($this->_security_client_type_uuid, $this->_testClass->getSecurityClientTypeUuid());
    $this->assertEquals($this->_item_name, $this->_testClass->getItemName());
    $this->assertEquals($this->_display_name, $this->_testClass->getDisplayName());
    $this->assertEquals($this->_description, $this->_testClass->getDescription());
    $this->assertEquals($this->_weighting, $this->_testClass->getWeighting());
    $this->assertEquals($this->_picture_path, $this->_testClass->getPicturePath());
    $this->assertEquals($this->_item_action, $this->_testClass->getItemAction());
    $this->assertEquals($this->_is_active, $this->_testClass->getIsActive()); 
  }

  public function testSetUuid() {
    $this->_testClass->resetAll();
    $this->_testClass->setUuid($this->_uuid);
    $this->assertEquals($this->_uuid, $this->_testClass->getUuid());
  
    $this->_testClass->resetAll();
    $this->_testClass->setUuid('not-a-uuid');
    $this->assertEquals('', $this->_testClass->getUuid());
  }
  
  public function testSetDockUuid() {
    $this->_testClass->resetAll();
    $this->_testClass->setDockUuid($this->_dock_uuid);
    $this->assertEquals($this->_dock_uuid, $this->_testClass->getDockUuid());
  
    $this->_testClass->resetAll();
    $this->_testClass->setDockUuid('not-a-uuid');
    $this->assertEquals('', $this->_testClass->getDockUuid());
  }
  
  public function testSetSystemDockTypeUuid() {
    $this->_testClass->resetAll();
    $this->_testClass->setSystemDockTypeUuid($this->_system_dock_type_uuid);
    $this->assertEquals($this->_system_dock_type_uuid, $this->_testClass->getSystemDockTypeUuid());
  
    $this->_testClass->resetAll();
    $this->_testClass->setSystemDockTypeUuid('not-a-uuid');
    $this->assertEquals('', $this->_testClass->getSystemDockTypeUuid());
  }
  
  public function testSetSecurityClientTypeUuid() {
    $this->_testClass->resetAll();
    $this->_testClass->setSecurityClientTypeUuid($this->_security_client_type_uuid);
    $this->assertEquals($this->_security_client_type_uuid, $this->_testClass->getSecurityClientTypeUuid());
  
    $this->_testClass->resetAll();
    $this->_testClass->setSecurityClientTypeUuid('not-a-uuid');
    $this->assertEquals('', $this->_testClass->getSecurityClientTypeUuid());
  }
  
  public function testSetItemName() {
    $this->_testClass->resetAll();
    $this->_testClass->setItemName($this->_item_name);
    $this->assertEquals($this->_item_name, $this->_testClass->getItemName());
    
    $this->_testClass->resetAll();
    $this->_testClass->setItemName(null);
    $this->assertEquals('', $this->_testClass->getItemName());
  }
  
  public function testSetDisplayName() {
    $this->_testClass->resetAll();
    $this->_testClass->setDisplayName($this->_display_name);
    $this->assertEquals($this->_display_name, $this->_testClass->getDisplayName());
  
    $this->_testClass->resetAll();
    $this->_testClass->setDisplayName(null);
    $this->assertEquals('', $this->_testClass->getDisplayName());
  }
  
  public function testSetDescription() {
    $this->_testClass->resetAll();
    $this->_testClass->setDescription($this->_description);
    $this->assertEquals($this->_description, $this->_testClass->getDescription());
  
    $this->_testClass->resetAll();
    $this->_testClass->setDescription(null);
    $this->assertEquals('', $this->_testClass->getDescription());
  }
  
  public function testSetWeighting() {
    $this->_testClass->resetAll();
    $this->_testClass->setWeighting($this->_weighting);
    $this->assertEquals($this->_weighting, $this->_testClass->getWeighting());
  
    $this->_testClass->resetAll();
    $this->_testClass->setWeighting(null);
    $this->assertNull($this->_testClass->getWeighting());
  
    $this->_testClass->resetAll();
    $this->_testClass->setWeighting('apple');
    $this->assertNull($this->_testClass->getWeighting());
    $this->assertEquals('', $this->_testClass->getWeighting());
  
    $this->_testClass->resetAll();
    $this->_testClass->setWeighting(-10);
    $this->assertEquals(-10, $this->_testClass->getWeighting());
  }
  
  public function testSetPicturePath() {
    $this->_testClass->resetAll();
    $this->_testClass->setPicturePath($this->_picture_path);
    $this->assertEquals($this->_picture_path, $this->_testClass->getPicturePath());
  
    $this->_testClass->resetAll();
    $this->_testClass->setPicturePath(null);
    $this->assertEquals('', $this->_testClass->getPicturePath());
  }
  
  public function testSetItemAction() {
    $this->_testClass->resetAll();
    $this->_testClass->setItemAction($this->_item_action);
    $this->assertEquals($this->_item_action, $this->_testClass->getItemAction());
  
    $this->_testClass->resetAll();
    $this->_testClass->setItemAction(null);
    $this->assertEquals('', $this->_testClass->getItemAction());
  }

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
    $this->assertEquals('modify_dock_item', $this->_testClass->getCommandName());
  }
  
  public function tearDown() {
    unset($this->_testClass);
  }
}
