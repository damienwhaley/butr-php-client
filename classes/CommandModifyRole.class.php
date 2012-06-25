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
  * CommandModifyRole class.
  * This implements the functionality required to call the
  * modify_message message.
  */
class CommandModifyRole extends BaseCommand {
  
  /**
   * String containing the uuid for the record to be modified.
   * @var string
   */
  private $_uuid;
  
  /**
   * String containing the partition_uuid for the record to be modified.
   * @var string
   */
  private $_partition_uuid;
  
  /**
   * String containing the role_name for the record to be modified.
   * @var string
   */
  private $_role_name;
  
  /**
   * String containing the description for the record to be modified.
   * @var string
   */
  private $_description;
  
  /**
   * Integer containing the is_active for the record to be modified.
   * @var integer
   */
  private $_is_active;
  
  /**
   * Default constructor.
   */
  public function __construct() {
    parent::__construct();
    $this->_uuid = '';
    $this->_command_name = 'modify_role';
    $this->_partition_uuid = '';
    $this->_role_name = '';
    $this->_description = '';
    $this->_is_active = 0;
  }
  
  /**
   * This generates the command part of the snippet.
   * @return string
   *   - String containing the command snippet.
   */
  public function generateSnippet() {
    return '"' . $this->_command_name . '":{"partition_uuid":"' . $this->_partition_uuid
      . '","uuid":"' . $this->_uuid
      . '","role_name":"' . $this->_role_name
      . '","description":"' . $this->_description
      . '","is_active":"' . $this->_is_active . '"}';
  }
  
  /**
   * Prepare the command ready to be sent.
   */
  public function prepareCommand() {  
    $this->setCommandSnippet($this->generateSnippet());
  }
  
  /**
   * Sets the module for the record to be modified.
   * @param string $uuid
   *   - The uuid for the record to be modified.
   */
  public function setUuid($uuid) {
    $this->_uuid = $uuid;
  }
  
  /**
   * Sets the parition uuid for the record to be modified.
   * @param string $parition_uuid
   *   - The partition_uuid for the record to be modified.
   */
  public function setPartitionUuid($partition_uuid) {
    $this->_partition_uuid = $partition_uuid;
  }
  
  /**
   * Sets the role_name for the record to be modified.
   * @param string $role_name
   *   - The message_name for the record to be modified.
  */
  public function setRoleName($role_name) {
    $this->_role_name = $role_name;
  }
  
  /**
  * Sets the description for the record to be modified.
  * @param string $description
  *   - The description for the record to be modified.
  */
  public function setDescription($description) {
    $this->_description = $description;
  }
  
  /**
   * Sets the is_active for the record to be modified.
   * @param integer $is_active
   *   - The description for the record to be modified.
   */
  public function setIsActive($is_active) {
    $this->_is_active = $is_active;
  }
  
  /**
   * This sets all the parameters for the message in one shot.
   * @param string $uuid
   *   - The UUID for the uuid for the record to be modified.
   * @param string $partition_uuid
   *   - The UUID for the partition_uuid for the record to be modified.
   * @param string $role_name
   *   - The role_name for the record to be modified.
   * @param string $description
   *   - The description for the record to be modfied.
   * @param integer $is_active
   *   - The is active boolean flag for the record to be modified.
   */
  public function setAll($uuid, $partition_uuid, $role_name, $description, $is_active) {
    $this->setUuid($uuid);
    $this->setPartitionUuid($partition_uuid);
    $this->setRoleName($role_name);
    $this->setDescription($description);
    $this->setIsActive($is_active);
  }
}