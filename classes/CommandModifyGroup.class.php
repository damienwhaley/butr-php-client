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
$document_root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once($document_root . '/includes/settings.inc');

/**
  * CommandModifyGroup class.
  * This implements the functionality required to call the
  * modify_group message.
  */
class CommandModifyGroup extends BaseCommand {
  
  /**
   * String containing the uuid for the record to be modified.
   * @var string
   */
  private $_uuid;
  
  /**
   * String containing the group_name for the record to be modified.
   * @var string
   */
  private $_group_name;
  
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
   * Integer containing the is_active for the record to be modified.
   * @var integer
   */
  private $_is_active;
  
  /**
   * Default constructor.
   */
  public function __construct() {
    parent::__construct();
    $this->_command_name = 'modify_group';
    $this->_uuid = '';
    $this->_group_name = '';
    $this->_display_name = '';
    $this->_description = '';
    $this->_is_active = 0;
  }
  
  /**
   * This generates the command part of the snippet.
   * @return string
   *   - String containing the command snippet.
   */
  public function generateSnippet() {
    return '"' . $this->_command_name . '":{"group_name":"'. $this->_group_name
     . '","uuid":"' . $this->_uuid
     . '","display_name":"' . $this->_display_name
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
   * Sets the uuid for the record to be modified.
   * @param string $uuid
   *   - The name_label for the record to be modified.
   */
  public function setUuid($uuid) {
    $this->_uuid = $uuid;
  }
  
  /**
   * Sets the group_name for the record to be modified.
   * @param string $group_name
   *   - The group_name for the record to be modified.
   */
  public function setGroupName($group_name) {
    $this->_group_name = $group_name;
  }
  
  /**
   * Sets the display_name for the record to be modified.
   * @param string $display_name
   *   - The display_name for the record to be modified.
   */
  public function setDisplayName($display_name) {
    $this->_display_name = $display_name;
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
   *   - The is_active for the record to be modified.
   */
  public function setIsActive($is_active) {
    $this->_is_active = $is_active;
  }
  
  /**
   * This sets all the fields in one method call.
   * @param string $uuid
   *   - The UUID for the record to be modified.
   * @param string $group_name
   *   - The group_name for the record to be modified.
   * @param string $display_name
   *   - The display_name for the record to be modified.
   * @param string $description
   *   - The description for the record to be modified.
   * @param integer $is_active
   *   - The is_active for the record to be modified.
   */
  public function setAll($uuid, $group_name, $display_name, $description, $is_active){
    $this->setUuid($uuid);
    $this->setGroupName($group_name);
    $this->setDisplayName($display_name);
    $this->setDescription($description);
    $this->setIsActive($is_active);
  }
}