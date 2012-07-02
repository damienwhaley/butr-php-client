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
  * CommandModifyDockTab class.
  * This implements the functionality required to call the
  * modify_dock_tab message.
  */
class CommandModifyDockTab extends BaseCommand {
  
  /**
   * String containing the uuid for the record to be modified.
   * @var string
   */
  private $_uuid;
  
  /**
   * String containing the dock_item_uuid for the record to be modified.
   * @var string
   */
  private $_dock_item_uuid;
  
  /**
   * String containing the dock_subitem_uuid for the record to be modified.
   * @var string
   */
  private $_dock_subitem_uuid;
  
  /**
   * String containing the system_dock_type_uuid for the record to be modified.
   * @var string
   */
  private $_system_dock_type_uuid;
  
  /**
   * String containing the security_client_type_uuid for the record to be modified.
   * @var string
   */
  private $_security_client_type_uuid;
  
  /**
   * String containing the subitem_name for the record to be modified.
   * @var string
   */
  private $_tab_name;
  
  /**
   * String containing the display_name for the record to be modified.
   * @var string
   */
  private $_display_name;
  
  /**
   * String containing the description for the record to be modified.
   * @var string
   */
  private $_description;
  
  /**
   * Integer containing the weighting for the record to be modified.
   * @var integer
   */
  private $_weighting;
  
  /**
   * String containing the picture_path for the record to be modified.
   * @var string
   */
  private $_picture_path;
  
  /**
   * String containing the subitem_action for the record to be modified.
   * @var string
   */
  private $_tab_action;
  
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
    $this->resetAll();
    $this->_command_name = 'modify_dock_tab';
  }
  
  /**
   * This generates the command part of the snippet.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - String containing the command snippet.
   */
  public function generateSnippet() {
    return '"' . $this->_command_name . '":{"security_client_type_uuid":"' . $this->_security_client_type_uuid
      . '","dock_item_uuid":"' . $this->_dock_item_uuid
      . '","dock_subitem_uuid":"' . $this->_dock_subitem_uuid
      . '","uuid":"' . $this->_uuid
      . '","system_dock_type_uuid":"' . $this->_system_dock_type_uuid
      . '","tab_name":"' . $this->_tab_name
      . '","display_name":"' . $this->_display_name
      . '","description":"' . $this->_description
      . '","weighting":"' . $this->_weighting
      . '","picture_path":"' . $this->_picture_path
      . '","tab_action":"' . $this->_tab_action
      . '","is_active":"' . $this->_is_active . '"}';
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
   * Sets the dock_item_uuid for the record to be modified.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $dock_item_uuid
   *   - The dock_item_uuid for the record to be modified.
   */
  public function setDockItemUuid($dock_item_uuid) {
    if (isset($dock_item_uuid) && uuidIsValid($dock_item_uuid)) {
      $this->_dock_item_uuid = $dock_item_uuid;
    } else {
      $this->_dock_item_uuid = '';
    }
  }
  
  /**
   * Gets the dock_item_uuid for the record to be modified.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - The dock_item_uuid for the record to be modified.
   */
  public function getDockItemUuid() {
    return $this->_dock_item_uuid;
  }
  
  /**
   * Sets the dock_subitem_uuid for the record to be modified.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $dock_subitem_uuid
   *   - The dock_subitem_uuid for the record to be modified.
   */
  public function setDockSubitemUuid($dock_subitem_uuid) {
    if (isset($dock_subitem_uuid) && uuidIsValid($dock_subitem_uuid)) {
      $this->_dock_subitem_uuid = $dock_subitem_uuid;
    } else {
      $this->_dock_subitem_uuid = '';
    }
  }
  
  /**
   * Gets the dock_subitem_uuid for the record to be modified.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - The dock_subitem_uuid for the record to be modified.
   */
  public function getDockSubitemUuid() {
    return $this->_dock_subitem_uuid;
  }
  
  /**
   * Sets the system_dock_type_uuid for the record to be modified.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $system_dock_type_uuid
   *   - The system_dock_type_uuid for the record to be modified.
   */
  public function setSystemDockTypeUuid($system_dock_type_uuid) {
    if (isset($system_dock_type_uuid) && uuidIsValid($system_dock_type_uuid)) {
      $this->_system_dock_type_uuid = $system_dock_type_uuid;
    } else {
      $this->_system_dock_type_uuid = '';
    }
  }
  
  /**
   * Gets the system_dock_type_uuid for the record to be modified.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - The system_dock_type_uuid for the record to be modified.
   */
  public function getSystemDockTypeUuid() {
    return $this->_system_dock_type_uuid;
  }
  
  /**
   * Sets the security_client_type for the record to be added.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $security_client_type_uuid
   *   - The security_client_type_uuid for the record to be added.
   */
  public function setSecurityClientTypeUuid($security_client_type_uuid) {
    if (isset($security_client_type_uuid) && uuidIsValid($security_client_type_uuid)) {
      $this->_security_client_type_uuid = $security_client_type_uuid;
    } else {
      $this->_security_client_type_uuid = '';
    }
  }
  
  /**
   * Gets the security_client_type for the record to be added.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - The security_client_type_uuid for the record to be added.
   */
  public function getSecurityClientTypeUuid() {
    return $this->_security_client_type_uuid;
  }
  
  /**
   * Sets the tab_name for the record to be modified.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $tab_name
   *   - The tab_name for the record to be modified.
   */
  public function setTabName($tab_name) {
    if (isset($tab_name)) {
      $this->_tab_name = $tab_name;
    } else {
      $this->_tab_name = '';
    }
  }
  /**
   * Gets the tab_name for the record to be modified.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - The tab_name for the record to be modified.
   */
  public function getTabName() {
    return $this->_tab_name;
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
   * Sets the weighting for the record to be added.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $weighting
   *   - The weighting for the record to be added.
   */
  public function setWeighting($weighting) {
    if (isset($weighting) && is_numeric($weighting)) {
      $this->_weighting = $weighting;
    } else {
      $this->_weighting = null;
    }
  }
  
  /**
   * Gets the weighting for the record to be added.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - The weighting for the record to be added.
   */
  public function getWeighting() {
    return $this->_weighting;
  }
  
  /**
   * Sets the picture_path for the record to be added.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $picture_path
   *   - The picture_path for the record to be added.
   */
  public function setPicturePath($picture_path) {
    if(isset($picture_path)) {
      $this->_picture_path = $picture_path;
    } else {
      $this->_picture_path = '';
    }
  }
  
  /**
   * Gets the picture_path for the record to be added.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - The picture_path for the record to be added.
   */
  public function getPicturePath() {
    return $this->_picture_path;
  }
  
  /**
   * Sets the tab_action for the record to be modified.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $tab_action
   *   - The tab_action for the record to be modified.
   */
  public function setTabAction($tab_action) {
    if (isset($tab_action)) {
      $this->_tab_action = $tab_action;
    } else {
      $this->_tab_action = '';
    }
  }
  
  /**
   * gets the tab_action for the record to be modified.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - The tab_action for the record to be modified.
   */
  public function getTabAction() {
    return $this->_tab_action;
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
   * @param string $uuid
   *    - The UUID for the uuid for the record to be modified.
   * @param string $dock_item_uuid
   *   - The UUID for the dock_item_uuid for the record to be modified.
   * @param string $dock_subitem_uuid
   *   - The UUID for the dock_subitem_uuid for the record to be modified.
   * @param string $system_dock_type_uuid
   *   - The UUID for the system_dock_type_uuid for the record to be modified.
   * @param string $security_client_type_uuid
   *   - The UUID for the security_client_type_uuid for the record to be modified.
   * @param string $tab_name
   *   - The tab_name for the record to be modified.
   * @param string $display_name
   *   - The display_name for the record to be modified.
   * @param string $description
   *   - The description for the record to be modified.
   * @param integer $weighting
   *   - The weighting for the record to be modified.
   * @param string $picture_path
   *   - The picture_path for the record to be modified.
   * @param string $tab_action
   *   - The UUID for the tab_action for the record to be modified.
   * @param integer $is_active
   *   - The is active boolean flag for the record to be modified.
   */
  public function setAll($uuid, $dock_item_uuid, $dock_subitem_uuid, $system_dock_type_uuid, $security_client_type_uuid,
    $tab_name, $display_name, $description, $weighting, $picture_path, $tab_action, $is_active) {
    $this->setUuid($uuid);
    $this->setDockItemUuid($dock_item_uuid);
    $this->setDockSubitemUuid($dock_subitem_uuid);
    $this->setSystemDockTypeUuid($system_dock_type_uuid);
    $this->setSecurityClientTypeUuid($security_client_type_uuid);
    $this->setTabName($tab_name);
    $this->setDisplayName($display_name);
    $this->setDescription($description);
    $this->setWeighting($weighting);
    $this->setPicturePath($picture_path);
    $this->setTabAction($tab_action);
    $this->setIsActive($is_active);
  }
  
  /**
   * This resets all the values back to the defaults.
   * @author Damien Whaley <damien@whalebonestudios.com>
   */
  public function resetAll() {
    $this->_uuid = '';
    $this->_dock_item_uuid = '';
    $this->_dock_subitem_uuid = '';
    $this->_system_dock_type_uuid = '';
    $this->_security_client_type_uuid = '';
    $this->_tab_name = '';
    $this->_display_name = '';
    $this->_description = '';
    $this->_weighting = null;
    $this->_picture_path = '';
    $this->_tab_action = '';
    $this->_is_active = 0;
  }
}