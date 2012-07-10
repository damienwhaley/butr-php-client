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
  * CommandAddRegistration class.
  * This implements the functionality required to call the
  * add_registration message.
  */
class CommandAddRegistration extends BaseCommand {
  
  /**
   * String containing the api_public for the record to be added.
   * @var string
   */
  private $_api_public;
  
  /**
   * String containing the api_private for the record to be added.
   * @var string
   */
  private $_api_private;
  
  /**
   * String containing the description for the record to be added.
   * @var string
   */
  private $_description;
  
  /**
   * String containing the security_client_type_uuid for the record to be added.
   * @var string
   */
  private $_security_client_type_uuid;
  
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
    $this->_command_name = 'add_registration';
    $this->resetAll();
  }
  
  /**
   * This generates the command part of the snippet.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - String containing the command snippet.
   */
  public function generateSnippet() {
    return '"' . $this->_command_name . '":{"api_public":"'. $this->_api_public
     . '","api_private":"' . $this->_api_private
     . '","description":"' . $this->_description
     . '","is_active":"' . $this->_is_active
     . '","security_client_type_uuid":"' . $this->_security_client_type_uuid . '"}';
  }
  
  /**
   * Sets the api_public for the record to be added.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $module_uuid
   *   - The uuid containing the api_public for the record to be added.
   */
  public function setApiPublic($api_public) {
    if (isset($api_public) && uuidIsValid($api_public)) {
      $this->_api_public = $api_public;
    } else {
      $this->_api_public = '';
    }
  }
  
  /**
   * Gets the api_public for the record to be added.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - The uuid containing the api_public for the record to be added.
   */
  public function getApiPublic() {
    return $this->_api_public;
  }
  
  /**
   * Sets the api_private for the record to be added.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $api_private
   *   - The SHA256 encoded api_private for the record to be added.
   */
  public function setApiPrivate($api_private) {
    if (isset($api_private) && strlen($api_private) === 64) {
      $this->_api_private = $api_private;
    } else {
      $this->_api_private = '';
    }
  }
  
  /**
   * Gets the api_private for the record to be added.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string $api_private
   *   - The SHA256 encoded api_private for the record to be added.
   */
  public function getApiPrivate() {
    return $this->_api_private;
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
   * Sets the security_client_type_uuid for the record to be added.
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
   * Gets the security_client_type_uuid for the record to be added.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string $security_client_type_uuid
   *   - The security_client_type_uuid for the record to be added.
   */
  public function getSecurityClientTypeUuid() {
    return $this->_security_client_type_uuid;
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
   * @param string $api_public
   *   - The api_public for the record to be added.
   * @param string $api_private
   *   - The api_private for the record to be added.
   * @param string security_client_type_uuid
   *   - The UUID for the security client type for the record to be added.
   * @param string $description
   *   - The description for the record to be added.
   * @param integer $is_active
   *   - The is active boolean flag for the record to be added.
   */
  public function setAll($api_public, $api_private, $security_client_type_uuid,
    $description, $is_active){
    $this->setApiPublic($api_public);
    $this->setApiPrivate($api_private);
    $this->setSecurityClientTypeUuid($security_client_type_uuid);
    $this->setDescription($description);
    $this->setIsActive($is_active);
  }
  
  /**
   * This resets all the values back to the defaults.
   * @author Damien Whaley <damien@whalebonestudios.com>
   */
  public function resetAll() {
    $this->_api_public = '';
    $this->_api_private = '';
    $this->_description = '';
    $this->_security_client_type_uuid = '';
    $this->_is_active = 0;
  }
}