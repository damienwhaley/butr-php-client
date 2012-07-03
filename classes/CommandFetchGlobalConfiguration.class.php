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
  * CommandFetchGlobalConfiguration class.
  * This implements the functionality required to call the
  * fetch_global_configuration message.
  */
class CommandFetchGlobalConfiguration extends BaseCommandFetch {
  
  /**
   * String containing the magic for the record to be fetched.
   * @var string
   */
  private $_magic;
  
  /**
   * Default constructor.
   */
  public function __construct() {
    parent::__construct();
    $this->_command_name = 'fetch_global_configuration';
    $this->resetAll();
  }
  
  /**
   * This generates the command part of the snippet. This overrides the base class.
   * @return string
   *   - String containing the command snippet.
   */
  public function generateSnippet() {
    return '"' . $this->_command_name . '":{"uuid":"'. $this->_uuid
      . '","magic":"' . $this->_magic
      . '"}';
  }
  
  /**
   * Sets the magic for the record to be fetched.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $magic
   *   - The magic for the record to be fetched.
   */
  public function setMagic($magic) {
    if (isset($magic)) {
      $this->_magic = $magic;
    } else {
      $this->_magic = '';
    }
  }
  
  /**
   * Gets the magic for the record to be fetched.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $magic
   *   - The magic for the record to be fetched.
   */
  public function getMagic() {
    return $this->_magic;
  }
  
  /**
   * This sets all the parameters for the message in one shot.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $uuid
   *   - The UUID for the record to be fetched.
   * @return string
   *   - The magic for the record to be fetched.
   */
  public function setAll($uuid, $magic) {
    $this->setUuid($uuid);
    $this->setMagic($magic);
  }
  
  /**
   * This resets all the values back to the defaults.
   * @author Damien Whaley <damien@whalebonestudios.com>
   */
  public function resetAll() {
    $this->_uuid = '';
    $this->_magic = '';
  }
}