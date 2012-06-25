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
  * CommandModifyUser class.
  * This implements the functionality required to call the
  * modify_user message.
  */
class CommandModifyUser extends BaseCommand {
  
  /**
   * String containing the _table_uuid for the record to be modified.
   * @var string
   */
  private $_uuid;
  
  /**
   * String containing the global_title_uuid for the record to be modified.
   * @var string
   */
  private $_global_title_uuid;
  
  /**
   * String containing the first_name for the record to be modified.
   * @var string
   */
  private $_first_name;
  
  /**
   * String containing the last_name for the record to be modified.
   * @var string
   */
  private $_last_name;
  
  /**
   * String containing the prefrerred_global_language_uuid for the record to be modified.
   * @var string
   */
  private $_preferred_global_language_uuid;
  
  /**
   * String containing the username for the record to be modified.
   * @var string
   */
  private $_username;
  
  /**
   * Default constructor.
   */
  public function __construct() {
    parent::__construct();
    $this->_command_name = 'modify_user';
    $this->_uuid = '';
    $this->_global_title_uuid = '';
    $this->_first_name = '';
    $this->_last_name = '';
    $this->_preferred_global_language_uuid = '';
    $this->_username = '';
  }
  
  /**
   * This generates the command part of the snippet.
   * @return string
   *   - String containing the command snippet.
   */
  public function generateSnippet() {
    return '"' . $this->_command_name . '":{"uuid":"' . $this->_uuid
      . '","global_title_uuid":"' . $this->_global_title_uuid
      . '","first_name":"' . $this->_first_name
      . '","last_name":"' . $this->_last_name
      . '","preferred_global_language_uuid":"' . $this->_preferred_global_language_uuid
      . '","username":"' . $this->_username . '"}';
  }
  
  /**
   * Prepare the command ready to be sent.
   */
  public function prepareCommand() {  
    $this->setCommandSnippet($this->generateSnippet());
  }
  
  /**
   * Sets the uuid for the record to be modified.
   * @param string $name_label
   *   - The _table_uuid for the record to be modified.
   */
  public function setUuid($uuid) {
    $this->_uuid = $uuid;
  }
  
  /**
   * Sets the global_title_uuid for the record to be modified.
   * @param string $name_label
   *   - The global_title_uuid for the record to be modified.
   */
  public function setGlobalTitleUuid($global_title_uuid) {
    $this->_global_title_uuid = $global_title_uuid;
  }
  
  /**
   * Sets the first_name for the record to be modified.
   * @param string $first_name
   *   - The first_name for the record to be modified.
  */
  public function setFirstName($first_name) {
    $this->_first_name = $first_name;
  }
  
  /**
  * Sets the last_name for the record to be modified.
  * @param string $last_name
  *   - The last_name for the record to be modified.
  */
  public function setLastName($last_name) {
    $this->_last_name = $last_name;
  }
  
  /**
  * Sets the preferred_global_language_uuid for the record to be modified.
  * @param string $preferred_global_language_uuid
  *   - The preferred_global_language_uuid for the record to be modified.
  */
  public function setPreferredGlobalLanguageUuid($preferred_global_language_uuid) {
    $this->_preferred_global_language_uuid = $preferred_global_language_uuid;
  }
  
  /**
  * Sets the username for the record to be modified.
  * @param string $username
  *   - The username for the record to be modified.
  */
  public function setUsername($username) {
    $this->_username = $username;
  }
  
  /**
   * This sets all the parameters for the message in one shot.
   * @param string $uuid
   *   - The UUID for the record to be modified.
   * @param string $global_title_uuid
   *   - The UUID for the global title for the record to be modified.
   * @param string $first_name
   *   - The first_name for the record to be modified.
   * @param string $last_name
   *   - The last_name for the record to be modified.
   * @param string $preferred_global_languge_uuid
   *   - The UUID for the preferred_global_language_uuid for the record to be modified.
   * @param string $username
   *   - The username for the record to be modified.
   */
  public function setAll($uuid, $global_title_uuid, $first_name, $last_name, $preferred_global_language_uuid, $username) {
    $this->setUuid($uuid);
    $this->setGlobalTitleUuid($global_title_uuid);
    $this->setFirstName($first_name);
    $this->setLastName($last_name);
    $this->setPreferredGlobalLanguageUuid($preferred_global_language_uuid);
    $this->setUsername($username);
  }
}