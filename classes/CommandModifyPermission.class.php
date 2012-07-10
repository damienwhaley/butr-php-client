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
  * CommandModifyPermission class.
  * This implements the functionality required to call the
  * modify_permission message.
  */
class CommandModifyPermission extends BaseCommand {
  
  /**
   * String containing the UUID for the record to be modified.
   * @var string
   */
  private $_uuid;
  
  /**
   * String containing the module_uuid for the record to be modified.
   * @var string
   */
  private $_module_uuid;
  
  /**
   * String containing the permission_name for the record to be modified.
   * @var string
   */
  private $_permission_name;
  
  /**
   * String containing the description for the record to be modified.
   * @var string
   */
  private $_description;
  
  /**
   * String containing the magic for the record to be modified.
   * @var string
   */
  private $_magic;
  
  /**
   * String containing the username for the record to be modified.
   * @var integer
   */
  private $_importance;
  
  /**
   * Default constructor.
   */
  public function __construct() {
    parent::__construct();
    $this->_command_name = 'modify_permission';
    $this->resetAll();
  }
  
  /**
   * This generates the command part of the snippet.
   * @return string
   *   - String containing the command snippet.
   */
  public function generateSnippet() {
    return '"' . $this->_command_name . '":{"uuid":"' . $this->_uuid
      . '","module_uuid":"' . $this->_module_uuid
      . '","permission_name":"' . $this->_permission_name
      . '","description":"' . $this->_description
      . '","magic":"' . $this->_magic
      . '","importance":"' . $this->_importance . '"}';
  }
  
  /**
   * Sets the uuid for the record to be modified.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $uuid
   *   - The uuid for the record to be modified.
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
   *   - The uuid for the record to be modified.
   */
  public function getUuid() {
    return $this->_uuid;
  }
  
  /**
   * Sets the module_uuid for the record to be modified.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $module_uuid
   *   - The module_uuid for the record to be modified.
   */
  public function setModuleUuid($module_uuid) {
    if (isset($module_uuid) && uuidIsValid($module_uuid)) {
      $this->_module_uuid = $module_uuid;
    } else {
      $this->_module_uuid = '';
    }
  }
  
  /**
   * Gets the module_uuid for the record to be modified.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - The module_uuid for the record to be modified.
   */
  public function getModuleUuid() {
    return $this->_module_uuid;
  }
  
  /**
   * Sets the permission_name for the record to be modified.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $permission_name
   *   - The permission_name for the record to be modified.
  */
  public function setPermissionName($permission_name) {
    if (isset($permission_name)) {
      $this->_permission_name = $permission_name;
    } else {
      $this->_permission_name = '';
    }
  }
  /**
   * Gets the permission_name for the record to be modified.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - The permission_name for the record to be modified.
   */
  public function getPermissionName() {
    return $this->_permission_name;
  }
  
  /**
   * Sets the description for the record to be modified.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $description
   *   - The description for the record to be modified.
   */
  public function setDescription($description) {
    if (isset($description)) {
      $this->_description = $description;
    } else {
      $this->_description = '';
    }
  }
  
  /**
   * Gets the description for the record to be modified.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - The description for the record to be modified.
   */
  public function getDescription() {
    return $this->_description;
  }
  
  /**
   * Sets the magic for the record to be modified.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $magic
   *   - The magic for the record to be modified.
   */
  public function setMagic($magic) {
    if (isset($magic)) {
      $this->_magic = $magic;
    } else {
      $this->_magic = '';
    }
  }
  
  /**
   * Gets the magic for the record to be modified.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - The magic for the record to be modified.
   */
  public function getMagic() {
    return $this->_magic;
  }
  
  /**
   * Sets the importance for the record to be modified.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param integer $importance
   *   - The importance for the record to be modified.
   */
  public function setImportance($importance) {
    if (isset($importance) && is_numeric($importance)) {
      $this->_importance = intval(floor($importance));
    } else {
      $this->_importance = null;
    }
  }
  
  /**
   * Gets the importance for the record to be modified.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return integer
   *   - The importance for the record to be modified.
   */
  public function getImportance() {
    return $this->_importance;
  }
  
  /**
   * This sets all the parameters for the message in one shot.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $uuid
   *   - The UUID for the record to be modified.
   * @param string $module_uuid
   *   - The UUID for the module for the record to be modified.
   * @param string $permission_name
   *   - The permission_name for the record to be modified.
   * @param string $description
   *   - The description for the record to be modified.
   * @param string $magic
   *   - The magic for the record to be modified.
   * @param integer $importance
   *   - The username for the record to be modified.
   */
  public function setAll($uuid, $module_uuid, $permission_name, $description, $magic, $importance) {
    $this->setUuid($uuid);
    $this->setModuleUuid($module_uuid);
    $this->setPermissionName($permission_name);
    $this->setDescription($description);
    $this->setMagic($magic);
    $this->setImportance($importance);
  }
  
  /**
   * This resets all the values back to the defaults.
   * @author Damien Whaley <damien@whalebonestudios.com>
   */
  public function resetAll() {
    $this->_uuid = '';
    $this->_module_uuid = '';
    $this->_permission_name = '';
    $this->_description = '';
    $this->_magic = '';
    $this->_importance = null;
  }
}