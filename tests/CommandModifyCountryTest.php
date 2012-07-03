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
 * This tests the CommandModifyCountry class
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
class SelectEqualsTest extends PHPUnit_Framework_TestCase
{
  protected $_testClass;
  protected $_uuid;
  protected $_country_name;
  protected $_display_name;
  protected $_description;
  protected $_country_code;
  protected $_alternate_code;
  protected $_weighting;
  protected $_is_active;
  
  public function setUp() {
    $this->_testClass = new Butr\CommandModifyCountry();
    $this->_uuid = Butr\uuidSecure();
    $this->_country_name = 'country_name';
    $this->_display_name = 'display_name';
    $this->_description = 'description';
    $this->_country_code = 'country_code';
    $this->_alternate_code = 'alternate_code';
    $this->_weighting = 10;
    $this->_is_active = 1;
  }
  
  public function testResetAll() {
    $this->_testClass->resetAll();
    
    $this->assertEquals('', $this->_testClass->getUuid());
    $this->assertEquals('', $this->_testClass->getCountryName());
    $this->assertEquals('', $this->_testClass->getCountryCode());
    $this->assertEquals('', $this->_testClass->getDisplayName());
    $this->assertEquals('', $this->_testClass->getDescription());
    $this->assertEquals('', $this->_testClass->getAlternateCode());
    $this->assertNull($this->_testClass->getWeighting());
    $this->assertEquals(0, $this->_testClass->getIsActive());
  }
  
  public function testSetAll() {
    $this->_testClass->resetAll();
    $this->_testClass->setAll($this->_uuid, $this->_country_name, $this->_display_name, $this->_description,
      $this->_country_code, $this->_alternate_code, $this->_weighting, $this->_is_active);

    $this->assertEquals($this->_uuid, $this->_testClass->getUuid());
    $this->assertEquals($this->_country_name, $this->_testClass->getCountryName());
    $this->assertEquals($this->_country_code, $this->_testClass->getCountryCode());
    $this->assertEquals($this->_display_name, $this->_testClass->getDisplayName());
    $this->assertEquals($this->_description, $this->_testClass->getDescription());
    $this->assertEquals($this->_alternate_code, $this->_testClass->getAlternateCode());
    $this->assertEquals($this->_weighting, $this->_testClass->getWeighting());
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
  
  public function testSetCountryName() {
    $this->_testClass->resetAll();
    $this->_testClass->setCountryName($this->_country_name);
    $this->assertEquals($this->_country_name, $this->_testClass->getCountryName());
    
    $this->_testClass->resetAll();
    $this->_testClass->setCountryName(null);
    $this->assertEquals('', $this->_testClass->getCountryName());
  }
  
  public function testSetCountryCode() {
    $this->_testClass->resetAll();
    $this->_testClass->setCountryCode($this->_country_code);
    $this->assertEquals($this->_country_code, $this->_testClass->getCountryCode());
    
    $this->_testClass->resetAll();
    $this->_testClass->setCountryCode(null);
    $this->assertEquals('', $this->_testClass->getCountryCode());
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
  
  public function testSetAlternateCode() {
    $this->_testClass->resetAll();
    $this->_testClass->setAlternateCode($this->_alternate_code);
    $this->assertEquals($this->_alternate_code, $this->_testClass->getAlternateCode());
  
    $this->_testClass->resetAll();
    $this->_testClass->setAlternateCode(null);
    $this->assertEquals('', $this->_testClass->getAlternateCode());
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
    
    $this->_testClass->resetAll();
    $this->_testClass->setWeighting(-10);
    $this->assertEquals(-10, $this->_testClass->getWeighting());
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
    $this->assertEquals('modify_country', $this->_testClass->getCommandName());
  }
  
  public function tearDown() {
    unset($this->_testClass);
  }
}
