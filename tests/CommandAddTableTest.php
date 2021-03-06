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
 * This tests the CommandAddTable class
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
class CommandAddTableTest extends PHPUnit_Framework_TestCase
{
  protected $_testClass;
  protected $_table_name;
  
  public function setUp() {
    $this->_testClass = new Butr\CommandAddTable();
    $this->_table_name = 'table_name';
  }
  
  public function testResetAll() {
    $this->_testClass->resetAll();
    
    $this->assertEquals('', $this->_testClass->getTableName());
  }

  /**
   * @depends testResetAll
   */
  public function testSetTableName() {
    $this->_testClass->resetAll();
    $this->_testClass->setTableName($this->_table_name);
    $this->assertEquals($this->_table_name, $this->_testClass->getTableName());
  
    $this->_testClass->resetAll();
    $this->_testClass->setTableName(null);
    $this->assertEquals('', $this->_testClass->getTableName());
  }
  
  public function testCommandName() {
    $this->assertEquals('add_table', $this->_testClass->getCommandName());
  }
  
  public function tearDown() {
    unset($this->_testClass);
  }
}
