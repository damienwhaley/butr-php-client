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
 * This tests the CommandModifyGlobalLanguageConfiguration class
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
class CommandModifyGlobalLanguageConfigurationTest extends PHPUnit_Framework_TestCase
{
  protected $_testClass;
  protected $_uuid;
  protected $_name_label;
  protected $_display_label;
  protected $_description;
  protected $_language_code;
  protected $_language_family;
  protected $_country_uuid;
  protected $_weighting;
  protected $_is_active;
  
  public function setUp() {
    $this->_testClass = new Butr\CommandModifyGlobalLanguageConfiguration();
    $this->_uuid = Butr\uuidSecure();
    $this->_name_label = 'name_label';
    $this->_display_label = 'display_label';
    $this->_description = 'description';
    $this->_language_code = 'language_code';
    $this->_language_family = 'language_family';
    $this->_country_uuid = Butr\uuidSecure();
    $this->_weighting = 20;
    $this->_is_active = 1;
  }
  
  public function testResetAll() {
    $this->_testClass->resetAll();
    
    $this->assertEquals('', $this->_testClass->getUuid());
    $this->assertEquals('', $this->_testClass->getNameLabel());
    $this->assertEquals('', $this->_testClass->getDisplayLabel());
    $this->assertEquals('', $this->_testClass->getDescription());
    $this->assertEquals('', $this->_testClass->getLanguageCode());
    $this->assertEquals('', $this->_testClass->getLanguageFamily());
    $this->assertEquals('', $this->_testClass->getCountryUuid());
    $this->assertNull($this->_testClass->getWeighting());
    $this->assertEquals(0, $this->_testClass->getIsActive()); 
  }
  
  /**
   * @depends testResetAll
   */
  public function testSetAll() {
    $this->_testClass->resetAll();
    
    $this->_testClass->setAll($this->_uuid, $this->_name_label, $this->_display_label,
      $this->_description, $this->_language_code, $this->_language_family,
      $this->_country_uuid, $this->_weighting, $this->_is_active);

    $this->assertEquals($this->_uuid, $this->_testClass->getUuid());
    $this->assertEquals($this->_name_label, $this->_testClass->getNameLabel());
    $this->assertEquals($this->_display_label, $this->_testClass->getDisplayLabel());
    $this->assertEquals($this->_description, $this->_testClass->getDescription());
    $this->assertEquals($this->_language_code, $this->_testClass->getLanguageCode());
    $this->assertEquals($this->_language_family, $this->_testClass->getLanguageFamily());
    $this->assertEquals($this->_country_uuid, $this->_testClass->getCountryUuid());
    $this->assertEquals($this->_weighting, $this->_testClass->getWeighting());
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
  public function testSetLanguageCode() {
    $this->_testClass->resetAll();
    $this->_testClass->setLanguageCode($this->_language_code);
    $this->assertEquals($this->_language_code, $this->_testClass->getLanguageCode());
  
    $this->_testClass->resetAll();
    $this->_testClass->setLanguageCode(null);
    $this->assertEquals('', $this->_testClass->getLanguageCode());
  }
  
  /**
   * @depends testResetAll
   */
  public function testSetLanguageFamily() {
    $this->_testClass->resetAll();
    $this->_testClass->setLanguageFamily($this->_language_family);
    $this->assertEquals($this->_language_family, $this->_testClass->getLanguageFamily());
  
    $this->_testClass->resetAll();
    $this->_testClass->setLanguageFamily(null);
    $this->assertEquals('', $this->_testClass->getLanguageFamily());
  }
  
  /**
   * @depends testResetAll
   */
  public function testSetCountryUuid() {
    $this->_testClass->resetAll();
    $this->_testClass->setCountryUuid($this->_country_uuid);
    $this->assertEquals($this->_country_uuid, $this->_testClass->getCountryUuid());
  
    $this->_testClass->resetAll();
    $this->_testClass->setCountryUuid('not-a-uuid');
    $this->assertEquals('', $this->_testClass->getCountryUuid());
    
    $this->_testClass->resetAll();
    $this->_testClass->setCountryUuid(null);
    $this->assertEquals('', $this->_testClass->getCountryUuid());
    
    $this->_testClass->resetAll();
    $this->_testClass->setCountryUuid(200);
    $this->assertEquals('', $this->_testClass->getCountryUuid());
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
    $this->assertEquals('modify_global_language_configuration', $this->_testClass->getCommandName());
  }
  
  public function tearDown() {
    unset($this->_testClass);
  }
}
