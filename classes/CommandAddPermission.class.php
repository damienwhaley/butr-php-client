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
  * CommandAddPermission class.
  * This implements the functionality required to call the
  * add_permission message.
  */
class CommandAddPermission extends BaseCommand {
  
  /**
   * String containing the module_uuid for the record to be added.
   * @var string
   */
  private $_module_uuid;
  
  /**
   * String containing the permission_name for the record to be added.
   * @var string
   */
  private $_permission_name;
  
  /**
   * String containing the description for the record to be added.
   * @var string
   */
  private $_description;
  
  /**
   * String containing the magic for the record to be added.
   * @var string
   */
  private $_magic;
  
  /**
   * String containing the username for the record to be added.
   * @var integer
   */
  private $_importance;
  
  /**
   * Default constructor.
   */
  public function __construct() {
    parent::__construct();
    $this->_command_name = 'add_permission';
    $this->_module_uuid = '';
    $this->_permission_name = '';
    $this->_description = '';
    $this->_magic = '';
    $this->_importance = null;
  }
  
  /**
   * This generates the command part of the snippet.
   * @return string
   *   - String containing the command snippet.
   */
  public function generateSnippet() {
    return '"' . $this->_command_name . '":{"module_uuid":"' . $this->_module_uuid
      . '","permission_name":"' . $this->_permission_name
      . '","description":"' . $this->_description
      . '","magic":"' . $this->_magic
      . '","importance":"' . $this->_importance . '"}';
  }
  
  /**
   * Prepare the command ready to be sent.
   */
  public function prepareCommand() {  
    $this->setCommandSnippet($this->generateSnippet());
  }
  
  /**
   * Sets the module_uuid for the record to be added.
   * @param string $module_uuid
   *   - The module_uuid for the record to be added.
   */
  public function setModuleUuid($module_uuid) {
    $this->_module_uuid = $module_uuid;
  }
  
  /**
   * Sets the permission_name for the record to be added.
   * @param string $permission_name
   *   - The permission_name for the record to be added.
  */
  public function setPermissionName($permission_name) {
    $this->_permission_name = $permission_name;
  }
  
  /**
  * Sets the description for the record to be added.
  * @param string $description
  *   - The description for the record to be added.
  */
  public function setDescription($description) {
    $this->_description = $description;
  }
  
  /**
  * Sets the magic for the record to be added.
  * @param string $magic
  *   - The preferred_global_language_uuid for the record to be added.
  */
  public function setMagic($magic) {
    $this->_magic = $magic;
  }
  
  /**
  * Sets the importance for the record to be added.
  * @param integer $importance
  *   - The importance for the record to be added.
  */
  public function setImportance($importance) {
    $this->_importance = $importance;
  }
  
  /**
   * This sets all the parameters for the message in one shot.
   * @param string $module_uuid
   *   - The UUID for the module for the record to be added.
   * @param string $permission_name
   *   - The permission_name for the record to be added.
   * @param string $description
   *   - The description for the record to be added.
   * @param string $magic
   *   - The magic for the record to be added.
   * @param integer $importance
   *   - The username for the record to be added.
   */
  public function setAll($module_uuid, $permission_name, $description, $magic, $importance) {
    $this->setModuleUuid($module_uuid);
    $this->setPermissionName($permission_name);
    $this->setDescription($description);
    $this->setMagic($magic);
    $this->setImportance($importance);
  }
}