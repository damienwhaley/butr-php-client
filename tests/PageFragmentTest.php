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

// @todo - more tests for constructors

/**
 * This tests the PageFragment class
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
class PageFragmentTest extends PHPUnit_Framework_TestCase
{
  protected $_testClass;
  protected $_css;
  protected $_css_file;
  protected $_css_include;
  protected $_js;
  protected $_js_file;
  protected $_js_include;
  protected $_language_code;
  
  public function setUp() {
    $this->_testClass = new Butr\PageFragment();
    $this->_css_file = 'damien.css';
    $this->_css_include = "    <link rel=\"stylesheet\" href=\"css/"
      . trim($this->_css_file) . "\" />\n";
    $this->_js_file = 'damien.js';
    $this->_js_include = "    <script type=\"text/javascript\" src=\"js/"
      . trim($this->_js_file) . "\"></script>\n";
    $this->_css = array($this->_css_file);
    $this->_js = array($this->_js_file);
    $this->_language_code = 'en-GB';
  }
  
  public function testResetAll() {   
    $this->_testClass->resetAll();
  
    $this->assertEmpty($this->_testClass->getCss());
    $this->assertEmpty($this->_testClass->getJs());
    $this->assertEquals(Butr\DEFAULT_LANGUAGE, $this->_testClass->getLanguageCode());
  }
  
  /**
   * @depends testResetAll
   */
  public function testSetAll() {   
    $this->_testClass->resetAll();
  
    $this->_testClass->setAll($this->_js, $this->_css, $this->_language_code);
    
    $this->assertContains($this->_js_include, $this->_testClass->getJs());
    $this->assertContains($this->_css_include, $this->_testClass->getCss());
    $this->assertEquals($this->_language_code, $this->_testClass->getLanguageCode());
  }
  
  /**
   * @depends testResetAll
   */
  public function testAddJs() {
    $this->_testClass->resetAll();
    
    $this->_testClass->addJs($this->_js);
    $this->assertContains($this->_js_include, $this->_testClass->getJs());
  
    $this->_testClass->resetAll();
    $this->_testClass->addJs(null);
    $this->assertEmpty($this->_testClass->getJs());
    
    $this->_testClass->resetAll();
    $this->_testClass->addJs('somestring.js');
    $this->assertEmpty($this->_testClass->getJs());
    
    $this->_testClass->resetAll();
    $this->_testClass->addJs(42);
    $this->assertEmpty($this->_testClass->getJs());
  }
  
  /**
   * @depends testResetAll
   */
public function testAddCss() {
    $this->_testClass->resetAll();
    
    $this->_testClass->addCss($this->_css);
    $this->assertContains($this->_css_include, $this->_testClass->getCss());
  
    $this->_testClass->resetAll();
    $this->_testClass->addCss(null);
    $this->assertEmpty($this->_testClass->getCss());
    
    $this->_testClass->resetAll();
    $this->_testClass->addCss('somestring.css');
    $this->assertEmpty($this->_testClass->getCss());
    
    $this->_testClass->resetAll();
    $this->_testClass->addCss(42);
    $this->assertEmpty($this->_testClass->getCss());
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
