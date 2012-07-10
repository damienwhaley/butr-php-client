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
  * CommandAddUser class.
  * This implements the functionality required to call the
  * add_user message.
  */
class CommandAddUser extends BaseCommand {
  
  /**
   * String containing the global_title_uuid for the record to be added.
   * @var string
   */
  private $_global_title_uuid;
  
  /**
   * String containing the first_name for the record to be added.
   * @var string
   */
  private $_first_name;
  
  /**
   * String containing the last_name for the record to be added.
   * @var string
   */
  private $_last_name;
  
  /**
   * String containing the prefrerred_global_language_uuid for the record to be added.
   * @var string
   */
  private $_preferred_global_language_uuid;
  
  /**
   * String containing the username for the record to be added.
   * @var string
   */
  private $_username;
  
  /**
   * Default constructor.
   */
  public function __construct() {
    parent::__construct();
    $this->_command_name = 'add_user';
    $this->resetAll();
  }
  
  /**
   * This generates the command part of the snippet.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - String containing the command snippet.
   */
  public function generateSnippet() {
    return '"' . $this->_command_name . '":{"global_title_uuid":"' . $this->_global_title_uuid
      . '","first_name":"' . $this->_first_name
      . '","last_name":"' . $this->_last_name
      . '","preferred_global_language_uuid":"' . $this->_preferred_global_language_uuid
      . '","username":"' . $this->_username . '"}';
  }
  
  /**
   * Sets the global_title_uuid for the record to be added.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $name_label
   *   - The global_title_uuid for the record to be added.
   */
  public function setGlobalTitleUuid($global_title_uuid) {
    if (isset($global_title_uuid) && uuidIsValid($global_title_uuid)) {
      $this->_global_title_uuid = $global_title_uuid;
    } else {
      $this->_global_title_uuid = '';
    }
  }
  
  /**
   * Gets the global_title_uuid for the record to be added.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - The global_title_uuid for the record to be added.
   */
  public function getGlobalTitleUuid() {
    return $this->_global_title_uuid;
  }
  
  /**
   * Sets the first_name for the record to be added.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $first_name
   *   - The first_name for the record to be added.
  */
  public function setFirstName($first_name) {
    if (isset($first_name)) {
      $this->_first_name = $first_name;
    } else {
      $this->_first_name = '';
    }
  }
  
  /**
   * Gets the first_name for the record to be added.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - The first_name for the record to be added.
   */
  public function getFirstName() {
    return $this->_first_name;
  }
  
  /**
   * Sets the last_name for the record to be added.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $last_name
   *   - The last_name for the record to be added.
   */
  public function setLastName($last_name) {
    if (isset($last_name)) {
      $this->_last_name = $last_name;
    } else {
      $this->_last_name = '';
    }
  }
  
  /**
   * Gets the last_name for the record to be added.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - The last_name for the record to be added.
   */
  public function getLastName() {
    return $this->_last_name;
  }
  
  /**
   * Sets the preferred_global_language_uuid for the record to be added.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $preferred_global_language_uuid
   *   - The preferred_global_language_uuid for the record to be added.
   */
  public function setPreferredGlobalLanguageUuid($preferred_global_language_uuid) {
    if (isset($preferred_global_language_uuid) && uuidIsValid($preferred_global_language_uuid)) {
      $this->_preferred_global_language_uuid = $preferred_global_language_uuid;
    } else {
      $this->_preferred_global_language_uuid = '';
    }
  }
  
  /**
   * Gets the preferred_global_language_uuid for the record to be added.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - The preferred_global_language_uuid for the record to be added.
   */
  public function getPreferredGlobalLanguageUuid() {
    return $this->_preferred_global_language_uuid;
  }
  
  /**
   * Sets the username for the record to be added.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $username
   *   - The username for the record to be added.
   */
  public function setUsername($username) {
    if (isset($username)) {
      $this->_username = $username;
    } else {
      $this->_username = '';
    }
  }
  
  /**
   * Gets the username for the record to be added.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - The username for the record to be added.
   */
  public function getUsername() {
    return $this->_username;
  }
  
  /**
   * This sets all the parameters for the message in one shot.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $global_title_uuid
   *   - The UUID for the global title for the record to be added.
   * @param string $first_name
   *   - The first_name for the record to be added.
   * @param string $last_name
   *   - The last_name for the record to be added.
   * @param string $preferred_global_languge_uuid
   *   - The UUID for the preferred_global_language_uuid for the record to be added.
   * @param string $username
   *   - The username for the record to be added.
   */
  public function setAll($global_title_uuid, $first_name, $last_name,
    $preferred_global_language_uuid, $username) {
    $this->setGlobalTitleUuid($global_title_uuid);
    $this->setFirstName($first_name);
    $this->setLastName($last_name);
    $this->setPreferredGlobalLanguageUuid($preferred_global_language_uuid);
    $this->setUsername($username);
  }
  
  /**
   * This resets all the values back to the defaults.
   * @author Damien Whaley <damien@whalebonestudios.com>
   */
  public function resetAll() {
    $this->_global_title_uuid = '';
    $this->_first_name = '';
    $this->_last_name = '';
    $this->_preferred_global_language_uuid = '';
    $this->_username = '';
  }
}