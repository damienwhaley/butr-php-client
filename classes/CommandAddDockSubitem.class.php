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

// Requires and includes.
//$document_root = realpath($_SERVER["DOCUMENT_ROOT"]);
//require_once($document_root . '/includes/settings.inc');

/**
  * CommandAddDockSubitem class.
  * This implements the functionality required to call the
  * add_dock message.
  */
class CommandAddDockSubitem extends BaseCommand {
  
  /**
   * String containing the dock_item_uuid for the record to be added.
   * @var string
   */
  private $_dock_item_uuid;
  
  /**
   * String containing the system_dock_type_uuid for the record to be added.
   * @var string
   */
  private $_system_dock_type_uuid;
  
  /**
   * String containing the security_client_type_uuid for the record to be added.
   * @var string
   */
  private $_security_client_type_uuid;
  
  /**
   * String containing the item_name for the record to be added.
   * @var string
   */
  private $_subitem_name;
  
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
   * Integer containing the weighting for the record to be added.
   * @var integer
   */
  private $_weighting;
  
  /**
   * String containing the icon for the record to be added.
   * @var string
   */
  private $_icon;
  
  /**
   * String containing the item_action for the record to be added.
   * @var string
   */
  private $_subitem_action;
  
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
    $this->_command_name = 'add_dock_subitem';
    $this->_dock_item_uuid = '';
    $this->_system_dock_type_uuid = '';
    $this->_security_client_type_uuid = '';
    $this->_subitem_name = '';
    $this->_display_name = '';
    $this->_description = '';
    $this->_weighting = null;
    $this->_icon = '';
    $this->_subitem_action = '';
    $this->_is_active = 0;
  }
  
  /**
   * This generates the command part of the snippet.
   * @return string
   *   - String containing the command snippet.
   */
  public function generateSnippet() {
    return '"' . $this->_command_name . '":{"security_client_type_uuid":"' . $this->_security_client_type_uuid
      . '","dock_item_uuid":"' . $this->_dock_item_uuid
      . '","system_dock_type_uuid":"' . $this->_system_dock_type_uuid
      . '","subitem_name":"' . $this->_subitem_name
      . '","display_name":"' . $this->_display_name
      . '","description":"' . $this->_description
      . '","weighting":"' . $this->_weighting
      . '","icon":"' . $this->_icon
      . '","subitem_action":"' . $this->_subitem_action
      . '","is_active":"' . $this->_is_active . '"}';
  }
  
  /**
   * Prepare the command ready to be sent.
   */
  public function prepareCommand() {  
    $this->setCommandSnippet($this->generateSnippet());
  }
  
  /**
   * Sets the dock_item_uuid for the record to be added.
   * @param string $dock_item_uuid
   *   - The dock_item_uuid for the record to be added.
   */
  public function setDockItemUuid($dock_item_uuid) {
    $this->_dock_item_uuid = $dock_item_uuid;
  }
  
  /**
   * Sets the system_dock_type_uuid for the record to be added.
   * @param string $system_dock_type_uuid
   *   - The system_dock_type_uuid for the record to be added.
   */
  public function setSystemDockTypeUuid($system_dock_type_uuid) {
    $this->_system_dock_type_uuid = $system_dock_type_uuid;
  }
  
  /**
   * Sets the security_client_type for the record to be added.
   * @param string $security_client_type_uuid
   *   - The security_client_type_uuid for the record to be added.
   */
  public function setSecurityClientTypeUuid($security_client_type_uuid) {
    $this->_security_client_type_uuid = $security_client_type_uuid;
  }
  
  /**
   * Sets the subitem_name for the record to be added.
   * @param string $subitem_name
   *   - The subitem_name for the record to be added.
  */
  public function setSubitemName($subitem_name) {
    $this->_subitem_name = $subitem_name;
  }
  
  /**
  * Sets the display_name for the record to be added.
  * @param string $display_name
  *   - The display_name for the record to be added.
  */
  public function setDisplayName($display_name) {
    $this->_display_name = $display_name;
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
  * Sets the weighting for the record to be added.
  * @param string $weighting
  *   - The weighting for the record to be added.
  */
  public function setWeighting($weighting) {
    $this->_weighting = $weighting;
  }
  
  /**
   * Sets the icon for the record to be added.
   * @param string $icon
   *   - The icon for the record to be added.
   */
  public function setIcon($icon) {
    $this->_icon = $icon;
  }
  
  /**
   * Sets the subitem_action for the record to be added.
   * @param string $subitem_action
   *   - The subitem_action for the record to be added.
   */
  public function setSubitemAction($subitem_action) {
    $this->_subitem_action = $subitem_action;
  }
  
  /**
   * Sets the is_active for the record to be added.
   * @param integer $is_active
   *   - The description for the record to be added.
   */
  public function setIsActive($is_active) {
    $this->_is_active = $is_active;
  }
  
  /**
   * This sets all the parameters for the message in one shot.
   * @param string $dock_item_uuid
   *   - The UUID for the dock_item_uuid for the record to be added.
   * @param string $system_dock_type_uuid
   *   - The UUID for the system_dock_type_uuid for the record to be added.
   * @param string $security_client_type_uuid
   *   - The UUID for the security_client_type_uuid for the record to be added.
   * @param string $subitem_name
   *   - The subitem_name for the record to be added.
   * @param string $display_name
   *   - The display_name for the record to be added.
   * @param string $description
   *   - The description for the record to be added.
   * @param integer $weighting
   *   - The weighting for the record to be added.
   * @param string $icon
   *   - The icon for the record to be added.
   * @param string $subitem_action
   *   - The UUID for the action for the record to be added.
   * @param integer $is_active
   *   - The is active boolean flag for the record to be added.
   */
  public function setAll($dock_item_uuid, $system_dock_type_uuid, $security_client_type_uuid,
    $subitem_name, $display_name, $description, $weighting, $icon, $subitem_action, $is_active) {
    $this->setDockItemUuid($dock_item_uuid);
    $this->setSystemDockTypeUuid($system_dock_type_uuid);
    $this->setSecurityClientTypeUuid($security_client_type_uuid);
    $this->setSubitemName($subitem_name);
    $this->setDisplayName($display_name);
    $this->setDescription($description);
    $this->setWeighting($weighting);
    $this->setIcon($icon);
    $this->setSubitemAction($subitem_action);
    $this->setIsActive($is_active);
  }
}