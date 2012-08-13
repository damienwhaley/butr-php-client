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

/**
 * This tests the CommandAddSystemDockTypeConfiguration class
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
class CommandAddSystemDockTypeConfigurationTest extends PHPUnit_Framework_TestCase
{
  protected $_testClass;
  protected $_name_label;
  protected $_display_label;
  protected $_description;
  protected $magic;
  protected $_weighting;
  protected $_is_active;
  
  public function setUp() {
    $this->_testClass = new Butr\CommandAddSystemDockTypeConfiguration();
    $this->_name_label = 'name_label';
    $this->_display_label = 'display_label';
    $this->_description = 'description';
    $this->_magic = 'magic';
    $this->_weighting = 20;
    $this->_is_active = 1;
  }
  
  public function testResetAll() {
    $this->_testClass->resetAll();
    
    $this->assertEquals('', $this->_testClass->getNameLabel());
    $this->assertEquals('', $this->_testClass->getDisplayLabel());
    $this->assertEquals('', $this->_testClass->getDescription());
    $this->assertEquals('', $this->_testClass->getMagic());
    $this->assertNull($this->_testClass->getWeighting());
    $this->assertEquals(0, $this->_testClass->getIsActive()); 
  }
  
  /**
   * @depends testResetAll
   */
  public function testSetAll() {
    $this->_testClass->resetAll();
    
    $this->_testClass->setAll($this->_name_label, $this->_display_label,
      $this->_description, $this->_magic, $this->_weighting, $this->_is_active);

    $this->assertEquals($this->_name_label, $this->_testClass->getNameLabel());
    $this->assertEquals($this->_display_label, $this->_testClass->getDisplayLabel());
    $this->assertEquals($this->_description, $this->_testClass->getDescription());
    $this->assertEquals($this->_magic, $this->_testClass->getMagic());
    $this->assertEquals($this->_weighting, $this->_testClass->getWeighting());
    $this->assertEquals($this->_is_active, $this->_testClass->getIsActive()); 
  }

  /**
   * @depends testResetAll
   */
  public function testSetNameLabel() {
    $this->_testClass->resetAll();
    $this->_testClass->setNameLabel($this->_name_label);
    $this->assertEquals($this->_name_label, $this->_testClass->getNameLabel());
  
    $this->_testClass->resetAll();
    $this->_testClass->setNameLabel(null);
    $this->assertEquals('', $this->_testClass->getNameLabel());
  }
  
  /**
   * @depends testResetAll
   */
  public function testSetDisplayLabel() {
    $this->_testClass->resetAll();
    $this->_testClass->setDisplayLabel($this->_display_label);
    $this->assertEquals($this->_display_label, $this->_testClass->getDisplayLabel());
    
    $this->_testClass->resetAll();
    $this->_testClass->setDisplayLabel(null);
    $this->assertEquals('', $this->_testClass->getDisplayLabel());
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
  
    $this->_testClass->resetAll();
    $this->_testClass->setWeighting(-10);
    $this->assertEquals(-10, $this->_testClass->getWeighting());
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
    $this->assertEquals('add_system_dock_type_configuration', $this->_testClass->getCommandName());
  }
  
  public function tearDown() {
    unset($this->_testClass);
  }
}
