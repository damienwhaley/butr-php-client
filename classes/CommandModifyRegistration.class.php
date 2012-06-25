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
  * CommandModifyRegistration class.
  * This implements the functionality required to call the
  * add_group message.
  */
class CommandModifyRegistration extends BaseCommand {
  
  /**
   * String containing the UUID for the record to be modified.
   * @var string
   */
  private $_uuid;
  
  /**
   * String containing the api_public for the record to be modified.
   * @var string
   */
  private $_api_public;
  
  /**
   * String containing the api_private for the record to be modified.
   * @var string
   */
  private $_api_private;
  
  /**
   * String containing the description for the record to be modified.
   * @var string
   */
  private $_description;
  
  /**
   * String containing the security_client_type_uuid for the record to be modified.
   * @var string
   */
  private $_security_client_type_uuid;
  
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
    $this->_command_name = 'modify_registration';
    $this->_uuid = '';
    $this->_api_public = '';
    $this->_api_private = '';
    $this->_description = '';
    $this->_security_client_type_uuid = '';
    $this->_is_active = 0;
  }
  
  /**
   * This generates the command part of the snippet.
   * @return string
   *   - String containing the command snippet.
   */
  public function generateSnippet() {
    return '"' . $this->_command_name . '":{"api_public":"'. $this->_api_public
     . '","uuid":"' . $this->_uuid
     . '","api_private":"' . $this->_api_private
     . '","description":"' . $this->_description
     . '","security_client_type_uuid":"' . $this->_security_client_type_uuid . '"}';
  }
  
  /**
   * Sets the UUID for the record to be modified.
   * @param string $uuid
   *   - The uuid for the record to be modified.
   */
  public function setUuid($uuid) {
    $this->_uuid = $uuid;
  }
  
  /**
   * Sets the api_public for the record to be modified.
   * @param string $api_public
   *   - The api_public for the record to be modified.
   */
  public function setApiPublic($api_public) {
    $this->_api_public = $api_public;
  }
  
  /**
   * Sets the api_private for the record to be modified.
   * @param string $api_private
   *   - The api_private for the record to be modified.
   */
  public function setApiPrivate($api_private) {
    $this->_display_name = $api_private;
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
   * Sets the security_client_type_uuid for the record to be modified.
   * @param string $security_client_type_uuid
   *   - The security_client_type_uuid for the record to be modified.
   */
  public function setSecurityClientTypeUuid($security_client_type_uuid) {
    $this->_security_client_type_uuid = $security_client_type_uuid;
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
   * This sets all the fields in one method call.
   * @param string $uuid
   *   - The uuid for the record to be modified.
   * @param string $api_public
   *   - The api_public for the record to be modified.
   * @param string $api_private
   *   - The api_private for the record to be modified.
   * @param string security_client_type_uuid
   *   - The UUID for the security client type for the record to be modified.
   * @param string $description
   *   - The description for the record to be modified.
   * @param integer $is_active
   *   - The is active boolean flag for the record to be modified.
   */
  public function setAll($uuid, $api_public, $api_private, $security_client_type_uuid,
    $description, $is_active){
    $this->setUuid($uuid);
    $this->setApiPublic($api_public);
    $this->setApiPrivate($api_private);
    $this->setSecurityClientTypeUuid($security_client_type_uuid);
    $this->setDescription($description);
    $this->setIsActive($is_active);
  }
}