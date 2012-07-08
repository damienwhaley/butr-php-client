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
  * CommandAddGroup class.
  * This implements the functionality required to call the
  * add_group message.
  */
class CommandAddGroup extends BaseCommand {
  
  /**
   * String containing the group_name for the record to be added.
   * @var string
   */
  private $_group_name;
  
  /**
   * String containing the display_name for the record to be added.
   * @var string
   */
  private $_display_name;
  
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
    $this->_command_name = 'add_group';
    $this->resetAll();
  }
  
  /**
   * This generates the command part of the snippet.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - String containing the command snippet.
   */
  public function generateSnippet() {
    return '"' . $this->_command_name . '":{"group_name":"'. $this->_group_name
     . '","display_name":"' . $this->_display_name
     . '","description":"' . $this->_description
     . '","is_active":"' . $this->_is_active . '"}';
  }
  
  /**
   * Sets the group_name for the record to be added.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $group_name
   *   - The group_name for the record to be added.
   */
  public function setGroupName($group_name) {
    if (isset($group_name)) {
      $this->_group_name = $group_name;
    } else {
      $this->_group_name = '';
    }
  }
  
  /**
   * Gets the group_name for the record to be added.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - The group_name for the record to be added.
   */
  public function getGroupName() {
    return $this->_group_name;
  }
  
  /**
   * Sets the display_name for the record to be added.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $display_name
   *   - The display_name for the record to be added.
   */
  public function setDisplayName($display_name) {
    if (isset($display_name)) {
      $this->_display_name = $display_name;
    } else {
      $this->_display_name = '';
    }
  }
  
  /**
   * Gets the display_name for the record to be added.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - The display_name for the record to be added.
   */
  public function getDisplayName() {
    return $this->_display_name;
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
   * @param string $group_name
   *   - The group_name for the record to be added.
   * @param string $display_name
   *   - The display_name for the record to be added.
   * @param string $description
   *   - The description for the record to be added.
   * @param integer $is_active
   *   - The is_active for the record to be added.
   */
  public function setAll($group_name, $display_name, $description, $is_active){
    $this->setGroupName($group_name);
    $this->setDisplayName($display_name);
    $this->setDescription($description);
    $this->setIsActive($is_active);
  }
  
  /**
   * This resets all the values back to the defaults.
   * @author Damien Whaley <damien@whalebonestudios.com>
   */
  public function resetAll() {
    $this->_group_name = '';
    $this->_display_name = '';
    $this->_description = '';
    $this->_is_active = 0;
  }
}