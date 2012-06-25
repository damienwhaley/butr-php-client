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
  * CommandModifyMessage class.
  * This implements the functionality required to call the
  * modify_message message.
  */
class CommandModifyMessage extends BaseCommand {
  
  /**
   * String containing the uuid for the record to be modified.
   * @var string
   */
  private $_uuid;
  
  /**
   * String containing the module_uuid for the record to be modified.
   * @var string
   */
  private $_module_uuid;
  
  /**
   * String containing the message_name for the record to be modified.
   * @var string
   */
  private $_message_name;
  
  /**
   * String containing the magic for the record to be modified.
   * @var string
   */
  private $_magic;
  
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
    $this->_command_name = 'modify_message';
    $this->_module_uuid = '';
    $this->_message_name = '';
    $this->_magic = '';
    $this->_description = '';
    $this->_is_active = 0;
  }
  
  /**
   * This generates the command part of the snippet.
   * @return string
   *   - String containing the command snippet.
   */
  public function generateSnippet() {
    return '"' . $this->_command_name . '":{"module_uuid":"' . $this->_module_uuid
      . '","uuid":"' . $this->_uuid
      . '","message_name":"' . $this->_message_name
      . '","magic":"' . $this->_magic
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
   * Sets the module for the record to be modified.
   * @param string $module_uuid
   *   - The module_uuid for the record to be modified.
   */
  public function setModuleUuid($module_uuid) {
    $this->_module_uuid = $module_uuid;
  }
  
  /**
   * Sets the message_name for the record to be modified.
   * @param string $message_name
   *   - The message_name for the record to be modified.
  */
  public function setMessageName($message_name) {
    $this->_message_name = $message_name;
  }
  
  /**
  * Sets the display_name for the record to be modified.
  * @param string $display_name
  *   - The display_name for the record to be modified.
  */
  public function setMagic($magic) {
    $this->_magic = $magic;
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
   * @param string $module_uuid
   *   - The UUID for the module_uuid for the record to be modified.
   * @param string $message_name
   *   - The message_name for the record to be modified.
   * @param string $magic
   *   - The magic for the record to be modified.
   * @param string $description
   *   - The description for the record to be modfied.
   * @param integer $is_active
   *   - The is active boolean flag for the record to be modified.
   */
  public function setAll($uuid, $module_uuid, $message_name, $magic, $description, $is_active) {
    $this->setUuid($uuid);
    $this->setModuleUuid($module_uuid);
    $this->setMessageName($message_name);
    $this->setMagic($magic);
    $this->setDescription($description);
    $this->setIsActive($is_active);
  }
}