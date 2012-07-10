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

namespace Butr;

/**
  * CommandAddTable class.
  * This implements the functionality required to call the
  * add_table message.
  */
class CommandAddTable extends BaseCommand {
  
  /**
   * String containing the group_name for the record to be added.
   * @var string
   */
  private $_table_name;
  
  /**
   * Default constructor.
   */
  public function __construct() {
    parent::__construct();
    $this->_command_name = 'add_table';
    $this->resetAll();
  }
  
  /**
   * This generates the command part of the snippet.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - String containing the command snippet.
   */
  public function generateSnippet() {
    return '"' . $this->_command_name . '":{"table_name":"'. $this->_table_name . '"}';
  }
  
  /**
   * Sets the table_name for the record to be added.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $table_name
   *   - The table_name for the record to be added.
   */
  public function setTableName($table_name) {
    if (isset($table_name)) {
    $this->_table_name = $table_name;
    } else {
      $this->_table_name = '';
    }
  }
  
  /**
   * Gets the table_name for the record to be added.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - The table_name for the record to be added.
   */
  public function getTableName() {
    return $this->_table_name;
  }
  
  /**
   * This resets all the values back to the defaults.
   * @author Damien Whaley <damien@whalebonestudios.com>
   */
  public function resetAll() {
    $this->_table_name = '';
  }
}