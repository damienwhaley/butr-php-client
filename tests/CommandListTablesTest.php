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
 * This tests the CommandListTables class
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
class SelectEqualsTest extends PHPUnit_Framework_TestCase
{
  protected $_testClass;
  protected $_direction;
  protected $_size;
  protected $_ordinal;
  protected $_offset;
  
  public function setUp() {
    $this->_testClass = new Butr\CommandListTables();
    $this->_offset = 10;
    $this->_size = Butr\LIST_SIZE_ALL;
    $this->_direction = Butr\SORT_DIRECTION_DESCENDING;
    $this->_ordinal = 'some column';
  }
  
  public function testResetAll() {
    $this->_testClass->resetAll();
  
    $this->assertEquals(0, $this->_testClass->getOffset());
    $this->assertEquals(Butr\LIST_SIZE_ALL, $this->_testClass->getSize());
    $this->assertEquals(Butr\SORT_DIRECTION_ASCENDING, $this->_testClass->getDirection());
    $this->assertEquals(Butr\SORT_ORDINAL_DEFAULT, $this->_testClass->getOrdinal());
  }
  
  public function testSetAll() {
    $this->_testClass->resetAll();
    $this->_testClass->setAll($this->_offset, $this->_size, $this->_direction, $this->_ordinal);
    
    $this->assertEquals($this->_offset, $this->_testClass->getOffset());
    $this->assertEquals($this->_size, $this->_testClass->getSize());
    $this->assertEquals($this->_direction, $this->_testClass->getDirection());
    $this->assertEquals($this->_ordinal, $this->_testClass->getOrdinal());
  }
  
  public function testSetOffset() {
    $this->_testClass->resetAll();
    $this->_testClass->setOffset(-10);
    $this->assertEquals(0, $this->_testClass->getOffset());
    
    $this->_testClass->resetAll();
    $this->_testClass->setOffset(20);
    $this->assertEquals(20, $this->_testClass->getOffset());
    
    $this->_testClass->resetAll();
    $this->_testClass->setOffset(null);
    $this->assertEquals(0, $this->_testClass->getOffset());
    
    $this->_testClass->resetAll();
    $this->_testClass->setOffset('apple');
    $this->assertEquals(0, $this->_testClass->getOffset());
  }
  
  public function testSetSize() {
    $this->_testClass->resetAll();
    $this->_testClass->setSize(-10);
    $this->assertEquals(Butr\LIST_SIZE_ALL, $this->_testClass->getSize());
  
    $this->_testClass->resetAll();
    $this->_testClass->setSize(20);
    $this->assertEquals(20, $this->_testClass->getSize());
  
    $this->_testClass->resetAll();
    $this->_testClass->setSize(null);
    $this->assertEquals(Butr\LIST_SIZE_ALL, $this->_testClass->getSize());
    
    $this->_testClass->resetAll();
    $this->_testClass->setSize('apple');
    $this->assertEquals(Butr\LIST_SIZE_ALL, $this->_testClass->getSize());
  }
  
  public function testSetDirection() {
    $this->_testClass->resetAll();
    $this->_testClass->setDirection(-10);
    $this->assertEquals(Butr\SORT_DIRECTION_ASCENDING, $this->_testClass->getDirection());
  
    $this->_testClass->resetAll();
    $this->_testClass->setDirection(20);
    $this->assertEquals(Butr\SORT_DIRECTION_ASCENDING, $this->_testClass->getDirection());
  
    $this->_testClass->resetAll();
    $this->_testClass->setDirection(null);
    $this->assertEquals(Butr\SORT_DIRECTION_ASCENDING, $this->_testClass->getDirection());
  
    $this->_testClass->resetAll();
    $this->_testClass->setDirection('apple');
    $this->assertEquals(Butr\SORT_DIRECTION_ASCENDING, $this->_testClass->getDirection());
    
    $this->_testClass->resetAll();
    $this->_testClass->setDirection(Butr\SORT_DIRECTION_ASCENDING);
    $this->assertEquals(Butr\SORT_DIRECTION_ASCENDING, $this->_testClass->getDirection());
    
    $this->_testClass->resetAll();
    $this->_testClass->setDirection(Butr\SORT_DIRECTION_DESCENDING);
    $this->assertEquals(Butr\SORT_DIRECTION_DESCENDING, $this->_testClass->getDirection());
  }
  
  public function testSetOrdinal() {
    $this->_testClass->resetAll();
    $this->_testClass->setOrdinal('a_column');
    $this->assertEquals('a_column', $this->_testClass->getOrdinal());
  
    $this->_testClass->resetAll();
    $this->_testClass->setSize(null);
    $this->assertEquals(Butr\SORT_ORDINAL_DEFAULT, $this->_testClass->getOrdinal());
  }
  
  public function testCommandName() {
    $this->assertEquals('list_tables', $this->_testClass->getCommandName());
  }
  
  public function tearDown() {
    unset($this->_testClass);
  }
}
