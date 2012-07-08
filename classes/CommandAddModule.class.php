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
  * CommandAddModule class.
  * This implements the functionality required to call the
  * add_group message.
  */
class CommandAddModule extends BaseCommand {
  
  /**
   * String containing the group_name for the record to be added.
   * @var string
   */
  private $_module_name;
  
  /**
   * String containing the magic for the record to be added.
   * @var string
   */
  private $_magic;
  
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
    $this->_command_name = 'add_module';
    $this->resetAll();
  }
  
  /**
   * This generates the command part of the snippet.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - String containing the command snippet.
   */
  public function generateSnippet() {
    return '"' . $this->_command_name . '":{"module_name":"'. $this->_module_name
     . '","magic":"' . $this->_magic
     . '","description":"' . $this->_description
     . '","is_active":"' . $this->_is_active . '"}';
  }
  
  /**
   * Sets the module_name for the record to be added.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $module_name
   *   - The module_name for the record to be added.
   */
  public function setModuleName($module_name) {
    if (isset($module_name)) {
      $this->_module_name = $module_name;
    } else {
      $this->_module_name = '';
    }
  }
  
  /**
   * Gets the module_name for the record to be added.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - The module_name for the record to be added.
   */
  public function getModuleName() {
    return $this->_module_name;
  }
  
  /**
   * Sets the magic for the record to be added.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $magic
   *   - The magic for the record to be added.
   */
  public function setMagic($magic) {
    if (isset($magic)) {
      $this->_magic = $magic;
    } else {
      $this->_magic = '';
    }
  }
  
  /**
   * Gets the magic for the record to be added.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - The magic for the record to be added.
   */
  public function getMagic() {
    return $this->_magic;
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
   * This sets all the fields in one method call.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $module_name
   *   - The module_name for the record to be added.
   * @param string $magic
   *   - The magic for the record to be added.
   * @param string $description
   *   - The description for the record to be added.
   * @param integer $is_active
   *   - The is_active for the record to be added.
   */
  public function setAll($module_name, $magic, $description, $is_active){
    $this->setModuleName($module_name);
    $this->setMagic($magic);
    $this->setDescription($description);
    $this->setIsActive($is_active);
  }
  
  /**
   * This resets all the values back to the defaults.
   * @author Damien Whaley <damien@whalebonestudios.com>
   */
  public function resetAll() {
    $this->_module_name = '';
    $this->_magic = '';
    $this->_description = '';
    $this->_is_active = 0;
  }
}