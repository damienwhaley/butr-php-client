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
require_once($basedir . 'includes/constants.inc');
require_once($basedir . 'includes/uuid.inc');

// @todo more tests about the setting of wells

/**
 * This tests the PageWell class
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
class PageWellTest extends PHPUnit_Framework_TestCase
{
  protected $_testClass;
  protected $_well;
  protected $_language_code;
  protected $_uuid;
  
  public function setUp() {
    $this->_testClass = new Butr\PageWell();
    $this->_well = array();
    $this->_language_code = 'en-GB';
    $this->_uuid = Butr\uuidSecure();
  }
  
  public function testResetAll() {   
    $this->_testClass->resetAll();
  
    $this->assertEquals(Butr\DEFAULT_LANGUAGE, $this->_testClass->getLanguageCode());
  }
  
  /**
   * @depends testResetAll
   */
  public function testSetAll() {   
    $this->_testClass->resetAll();
  
    $this->_testClass->setAll($this->_well, $this->_language_code, $this->_uuid);
    
    $this->assertEquals($this->_language_code, $this->_testClass->getLanguageCode());
    $this->assertEquals($this->_uuid, $this->_testClass->getUuid());
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
    $this->assertEquals(Butr\DEFAULT_LANGUAGE, $this->_testClass->getLanguageCode());
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
  
  public function tearDown() {
    unset($this->_testClass);
  }
}
