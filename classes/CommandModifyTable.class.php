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
  * CommandModifyTable class.
  * This implements the functionality required to call the
  * modify_table message.
  */
class CommandModifyTable extends BaseCommand {
  
  /**
   * String containing the uuid for the record to be modified.
   * @var string
   */
  private $_uuid;
  
  /**
   * String containing the table_name for the record to be modified.
   * @var string
   */
  private $_table_name;
  
  /**
   * Default constructor.
   */
  public function __construct() {
    parent::__construct();
    $this->_command_name = 'modify_table';
    $this->resetAll();
  }
  
  /**
   * This generates the command part of the snippet.
   * @return string
   *   - String containing the command snippet.
   */
  public function generateSnippet() {
    return '"' . $this->_command_name . '":{"table_name":"'. $this->_table_name
     . '","uuid":"' . $this->_uuid . '"}';
  }
  
  /**
   * Sets the uuid for the record to be modified.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $uuid
   *   - The dock_uuid for the record to be modified.
   */
  public function setUuid($uuid) {
    if (isset($uuid) && uuidIsValid($uuid)) {
      $this->_uuid = $uuid;
    } else {
      $this->_uuid = '';
    }
  }
  
  /**
   * Gets the uuid for the record to be modified.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - The dock_uuid for the record to be modified.
   */
  public function getUuid() {
    return $this->_uuid;
  }
  
  /**
   * Sets the table_name for the record to be modified.
   * @param string $table_name
   *   - The table_name for the record to be modified.
   */
  public function setTableName($table_name) {
    if (isset($table_name)) {
      $this->_table_name = $table_name;
    } else {
      $this->_table_name = '';
    }
  }
  
  /**
   * Gets the table_name for the record to be modified.
   * @return string
   *   - String containing the table_name for the record to be modified.
   */
  public function getTableName() {
    return $this->_table_name;
  }
  
  /**
   * This sets all the fields in one method call.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $uuid
   *   - The UUID for the record to be modified.
   * @param string $table_name
   *   - The table_name for the record to be modified.
   */
  public function setAll($uuid, $table_name){
    $this->setUuid($uuid);
    $this->setTableName($table_name);
  }
  
  /**
   * This resets all the values back to the defaults.
   * @author Damien Whaley <damien@whalebonestudios.com>
   */
  public function resetAll() {
    $this->_uuid = '';
    $this->_table_name = '';
  }
}