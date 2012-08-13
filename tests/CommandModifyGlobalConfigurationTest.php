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
 * This tests the CommandModifyGlobalConfiguration class
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
class CommandModifyGlobalConfigurationTest extends PHPUnit_Framework_TestCase
{
  protected $_testClass;
  protected $_uuid;
  protected $_name_label;
  protected $_display_label;
  protected $_magic;
  protected $_description;
  protected $_text_setting;
  protected $_integer_setting;
  protected $_float_setting;
  protected $_datetime_setting;
  protected $_uuid_setting;
  protected $_bit_setting;
  
  public function setUp() {
    $this->_testClass = new Butr\CommandModifyGlobalConfiguration();
    $this->_uuid = Butr\uuidSecure();
    $this->_name_label = '';
    $this->_display_label = '';
    $this->_magic = '';
    $this->_description = '';
    $this->_text_setting = 'text_setting';
    $this->_integer_setting = 20;
    $this->_float_setting = 1.1;
    $this->_datetime_setting = '1975-09-06 12:30:56';
    $this->_uuid_setting = Butr\uuidSecure();
    $this->_bit_setting = 1;
  }
  
  public function testResetAll() {
    $this->_testClass->resetAll();
    
    $this->assertEquals('', $this->_testClass->getUuid());
    $this->assertEquals('', $this->_testClass->getNameLabel());
    $this->assertEquals('', $this->_testClass->getDisplayLabel());
    $this->assertEquals('', $this->_testClass->getMagic());
    $this->assertEquals('', $this->_testClass->getDescription());
    $this->assertEquals('', $this->_testClass->getTextSetting());
    $this->assertNull($this->_testClass->getIntegerSetting());
    $this->assertNull($this->_testClass->getFloatSetting());
    $this->assertNull($this->_testClass->getDatetimeSetting());
    $this->assertEquals('', $this->_testClass->getUuidSetting());
    $this->assertEquals(0, $this->_testClass->getBitSetting());
  }
  
  /**
   * @depends testResetAll
   */
  public function testSetAll() {
    $datetime = DateTime::createFromFormat('Y-m-d H:i:s', $this->_datetime_setting);
    
    $this->_testClass->resetAll();
    
    $this->_testClass->setAll($this->_uuid, $this->_name_label, $this->_display_label,
      $this->_magic, $this->_description, $this->_text_setting,
      $this->_integer_setting, $this->_float_setting, $this->_datetime_setting,
      $this->_uuid_setting, $this->_bit_setting);

    $this->assertEquals($this->_uuid, $this->_testClass->getUuid());
    $this->assertEquals($this->_name_label, $this->_testClass->getNameLabel());
    $this->assertEquals($this->_display_label, $this->_testClass->getDisplayLabel());
    $this->assertEquals($this->_magic, $this->_testClass->getMagic());
    $this->assertEquals($this->_description, $this->_testClass->getDescription());
    $this->assertEquals($this->_text_setting, $this->_testClass->getTextSetting());
    $this->assertEquals($this->_integer_setting, $this->_testClass->getIntegerSetting());
    $this->assertEquals($this->_float_setting, $this->_testClass->getFloatSetting());
    $this->assertEquals($datetime, $this->_testClass->getDatetimeSetting());
    $this->assertEquals($this->_uuid_setting, $this->_testClass->getUuidSetting());
    $this->assertEquals($this->_bit_setting, $this->_testClass->getBitSetting());
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
  public function testSetTextSetting() {
    $this->_testClass->resetAll();
    $this->_testClass->setTextSetting($this->_text_setting);
    $this->assertEquals($this->_text_setting, $this->_testClass->getTextSetting());
  
    $this->_testClass->resetAll();
    $this->_testClass->setTextSetting(null);
    $this->assertEquals('', $this->_testClass->getTextSetting());
  }
  
  /**
   * @depends testResetAll
   */
  public function testSetIntegerSetting() {
    $this->_testClass->resetAll();
    $this->_testClass->setIntegerSetting($this->_integer_setting);
    $this->assertEquals($this->_integer_setting, $this->_testClass->getIntegerSetting());
  
    $this->_testClass->resetAll();
    $this->_testClass->setIntegerSetting(null);
    $this->assertNull($this->_testClass->getIntegerSetting());
  
    $this->_testClass->resetAll();
    $this->_testClass->setIntegerSetting('apple');
    $this->assertNull($this->_testClass->getIntegerSetting());
  
    $this->_testClass->resetAll();
    $this->_testClass->setIntegerSetting(-10);
    $this->assertEquals(-10, $this->_testClass->getIntegerSetting());
  }
  
  /**
   * @depends testResetAll
   */
  public function testSetFloatSetting() {
    $this->_testClass->resetAll();
    $this->_testClass->setFloatSetting($this->_float_setting);
    $this->assertEquals($this->_float_setting, $this->_testClass->getFloatSetting());
  
    $this->_testClass->resetAll();
    $this->_testClass->setFloatSetting(null);
    $this->assertNull($this->_testClass->getFloatSetting());
  
    $this->_testClass->resetAll();
    $this->_testClass->setFloatSetting('apple');
    $this->assertNull($this->_testClass->getFloatSetting());
  
    $this->_testClass->resetAll();
    $this->_testClass->setFloatSetting(-10.4);
    $this->assertEquals(-10.4, $this->_testClass->getFloatSetting());
  }
  
  /**
   * @depends testResetAll
   */
  public function testSetDatetimeSetting() {
    $datetime = DateTime::createFromFormat('Y-m-d H:i:s', $this->_datetime_setting);
    
    $this->_testClass->resetAll();
    $this->_testClass->setDatetimeSetting($this->_datetime_setting);
    $this->assertEquals($datetime, $this->_testClass->getDatetimeSetting());
  
    $this->_testClass->resetAll();
    $this->_testClass->setDatetimeSetting(null);
    $this->assertNull($this->_testClass->getDatetimeSetting());
  
    $this->_testClass->resetAll();
    $this->_testClass->setDatetimeSetting('apple');
    $this->assertNull($this->_testClass->getDatetimeSetting());
  
    $this->_testClass->resetAll();
    $this->_testClass->setDatetimeSetting('06 Sep 1975 12:30:56');
    $this->assertNull($this->_testClass->getFloatSetting());
  }
  
  /**
   * @depends testResetAll
   */
  public function testSetUuidSetting() {
    $this->_testClass->resetAll();
    $this->_testClass->setUuidSetting($this->_uuid_setting);
    $this->assertEquals($this->_uuid_setting, $this->_testClass->getUuidSetting());
  
    $this->_testClass->resetAll();
    $this->_testClass->setUuidSetting('not-a-uuid');
    $this->assertEquals('', $this->_testClass->getUuidSetting());
    
    $this->_testClass->resetAll();
    $this->_testClass->setUuidSetting(null);
    $this->assertEquals('', $this->_testClass->getUuidSetting());
    
    $this->_testClass->resetAll();
    $this->_testClass->setUuidSetting(200);
    $this->assertEquals('', $this->_testClass->getUuidSetting());
  }
  
  /**
   * @depends testResetAll
   */
  public function testSetBitSetting() {
    $this->_testClass->resetAll();
    $this->_testClass->setBitSetting($this->_bit_setting);
    $this->assertEquals($this->_bit_setting, $this->_testClass->getBitSetting());
  
    $this->_testClass->resetAll();
    $this->_testClass->setBitSetting(null);
    $this->assertEquals(0, $this->_testClass->getBitSetting());
  
    $this->_testClass->resetAll();
    $this->_testClass->setBitSetting('apple');
    $this->assertEquals(0, $this->_testClass->getBitSetting());
  
    $this->_testClass->resetAll();
    $this->_testClass->setBitSetting(-10);
    $this->assertEquals(1, $this->_testClass->getBitSetting());
  
    $this->_testClass->resetAll();
    $this->_testClass->setBitSetting(10);
    $this->assertEquals(1, $this->_testClass->getBitSetting());
  
    $this->_testClass->resetAll();
    $this->_testClass->setBitSetting(0);
    $this->assertEquals(0, $this->_testClass->getBitSetting());
  }
  
  public function testCommandName() {
    $this->assertEquals('modify_global_configuration', $this->_testClass->getCommandName());
  }
  
  public function tearDown() {
    unset($this->_testClass);
  }
}
