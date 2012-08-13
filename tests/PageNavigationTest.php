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

/**
 * This tests the PageNavigaton class
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
class PageNavigatonTest extends PHPUnit_Framework_TestCase
{
  protected $_testClass;
  protected $_company_name;
  protected $_company_picture_path;
  protected $_user_first_name;
  protected $_language_code;
  
  public function setUp() {
    $this->_testClass = new Butr\PageNavigation();
    $this->_company_name = 'company_name';
    $this->_company_picture_path = 'company_picture_path';
    $this->_user_first_name = 'user_first_name';
    $this->_language_code = 'en-GB';
  }
  
  public function testResetAll() {
    // i18n Settings
    putenv('LANG='.str_replace('-', '_', Butr\DEFAULT_LANGUAGE).'.UTF-8');
    setlocale(LC_ALL, str_replace('-', '_', Butr\DEFAULT_LANGUAGE).'.UTF-8');
    $domain = 'messages';
    bindtextdomain($domain, realpath($_SERVER["DOCUMENT_ROOT"]) . '/locale');
    textdomain($domain);
    
    $default_first_name = gettext('Back');
    
    $this->_testClass->resetAll();
  
    $this->assertEquals('', $this->_testClass->getCompanyName());
    $this->assertEquals('', $this->_testClass->getCompanyPicturePath());
    $this->assertEquals($default_first_name, $this->_testClass->getUserFirstName());
    $this->assertEquals(Butr\DEFAULT_LANGUAGE, $this->_testClass->getLanguageCode());
  }
  
  /**
   * @depends testResetAll
   */
  public function testSetAll() {   
    $this->_testClass->resetAll();
  
    $this->_testClass->setAll($this->_company_name,
      $this->_company_picture_path, $this->_user_first_name,
      $this->_language_code);
    
    $this->assertEquals($this->_company_name, $this->_testClass->getCompanyName());
    $this->assertEquals($this->_company_picture_path, $this->_testClass->getCompanyPicturePath());
    $this->assertEquals($this->_user_first_name, $this->_testClass->getUserFirstName());
    $this->assertEquals($this->_language_code, $this->_testClass->getLanguageCode());
  }
  
  /**
   * @depends testResetAll
   */
  public function testSetCompanyName() {
    $this->_testClass->resetAll();
    $this->_testClass->setCompanyName($this->_company_name);
    $this->assertEquals($this->_company_name, $this->_testClass->getCompanyName());
  
    $this->_testClass->resetAll();
    $this->_testClass->setCompanyName(null);
    $this->assertEquals('', $this->_testClass->getCompanyName());
  }
  
  /**
   * @depends testResetAll
   */
  public function testSetCompanyPicturePath() {
    $this->_testClass->resetAll();
    $this->_testClass->setCompanyPicturePath($this->_company_picture_path);
    $this->assertEquals($this->_company_picture_path, $this->_testClass->getCompanyPicturePath());
  
    $this->_testClass->resetAll();
    $this->_testClass->setCompanyPicturePath(null);
    $this->assertEquals('', $this->_testClass->getCompanyPicturePath());
  }
  
  /**
   * @depends testResetAll
   */
  public function testSetUserFirstName() {
    // i18n Settings
    putenv('LANG='.str_replace('-', '_', $this->_language_code).'.UTF-8');
    setlocale(LC_ALL, str_replace('-', '_', $this->_language_code).'.UTF-8');
    $domain = 'messages';
    bindtextdomain($domain, realpath($_SERVER["DOCUMENT_ROOT"]) . '/locale');
    textdomain($domain);
    
    $default_first_name = gettext('Back');
    
    $this->_testClass->resetAll();
    $this->_testClass->setUserFirstName($this->_user_first_name);
    $this->assertEquals($this->_user_first_name, $this->_testClass->getUserFirstName());
  
    $this->_testClass->resetAll();
    $this->_testClass->setUserFirstName(null);
    $this->assertEquals($default_first_name, $this->_testClass->getUserFirstName());
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
  
  public function tearDown() {
    unset($this->_testClass);
  }
}
