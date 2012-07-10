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
  * CommandAddRole class.
  * This implements the functionality required to call the
  * add_role message.
  */
class CommandAddRole extends BaseCommand {
  
  /**
   * String containing the partition_uuid for the record to be added.
   * @var string
   */
  private $_partition_uuid;
  
  /**
   * String containing the role_name for the record to be added.
   * @var string
   */
  private $_role_name;
  
  /**
   * String containing the description for the record to be added.
   * @var string
   */
  private $_description;
  
  /**
   * Integer containing the is_active for the record to be added.
   * @var integer
   */
  private $_is_active;
  
  /**
   * Default constructor.
   */
  public function __construct() {
    parent::__construct();
    $this->_command_name = 'add_role';
    $this->resetAll();
  }
  
  /**
   * This generates the command part of the snippet.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - String containing the command snippet.
   */
  public function generateSnippet() {
    return '"' . $this->_command_name . '":{"partition_uuid":"' . $this->_partition_uuid
      . '","role_name":"' . $this->_role_name
      . '","description":"' . $this->_description
      . '","is_active":"' . $this->_is_active . '"}';
  }
  
  /**
   * Sets the partition for the record to be added.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $partition_uuid
   *   - The partition_uuid for the record to be added.
   */
  public function setPartitionUuid($partition_uuid) {
    if (isset($partition_uuid) && uuidIsValid($partition_uuid)) {
      $this->_partition_uuid = $partition_uuid;
    } else {
      $this->_partition_uuid = '';
    }
  }
  
  /**
   * Gets the partition for the record to be added.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - The partition_uuid for the record to be added.
   */
  public function getPartitionUuid() {
    return $this->_partition_uuid;
  }
  
  /**
   * Sets the role_name for the record to be added.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $role_name
   *   - The role_name for the record to be added.
   */
  public function setRoleName($role_name) {
    if (isset($role_name)) {
      $this->_role_name = $role_name;
    } else {
      $this->_role_name = '';
    }
  }
  
  /**
   * Gets the role_name for the record to be added.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - The role_name for the record to be added.
   */
  public function getRoleName() {
    return $this->_role_name;
  }
  
  /**
   * Sets the description for the record to be added.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $description
   *   - The description for the record to be added.
   */
  public function setDescription($description) {
    if (isset($description)) {
      $this->_description = $description;
    } else {
      $this->_description = '';
    }
  }
  
  /**
   * Gets the description for the record to be added.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - The description for the record to be added.
   */
  public function getDescription() {
    return $this->_description;
  }
  
  /**
   * Sets the is_active for the record to be added.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param integer $is_active
   *   - The is_active for the record to be added.
   */
  public function setIsActive($is_active) {
    if (isset($is_active) && is_numeric($is_active)) {
      if ($is_active == 0) {
        $this->_is_active = 0;
      } else {
        $this->_is_active = 1;
      }
    } else {
      $this->_is_active = 0;
    }
  }
  
  /**
   * Gets the is_active for the record to be added.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return integer
   *   - The is_active for the record to be added.
   */
  public function getIsActive() {
    return $this->_is_active;
  }
  
  /**
   * This sets all the parameters for the message in one shot.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $partition_uuid
   *   - The UUID for the partiton_uuid for the record to be added.
   * @param string $role_name
   *   - The role_name for the record to be added.
   * @param string $description
   *   - The description for the record to be added.
   * @param integer $is_active
   *   - The is active boolean flag for the record to be added.
   */
  public function setAll($partition_uuid, $role_name, $description, $is_active) {
    $this->setPartitionUuid($partition_uuid);
    $this->setRoleName($role_name);
    $this->setDescription($description);
    $this->setIsActive($is_active);
  }
  
  /**
   * This resets all the values back to the defaults.
   * @author Damien Whaley <damien@whalebonestudios.com>
   */
  public function resetAll() {
    $this->_partition_uuid = '';
    $this->_role_name = '';
    $this->_description = '';
    $this->_is_active = 0;
  }
}