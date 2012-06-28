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
  * CommandModifyCountry class.
  * This implements the functionality required to call the
  * modify_country message.
  */
class CommandModifyCountry extends BaseCommand {
  
  /**
   * String containing the UUID for the record to be modified.
   * @var string
   */
  private $_uuid;
  
  /**
   * String containing the country_name for the record to be modified.
   * @var string
   */
  private $_country_name;
  
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
   * String containing the country_code for the record to be modified.
   * @var string
   */
  private $_country_code;
  
  /**
   * String containing the alternate_code for the record to be modified.
   * @var string
   */
  private $_alternate_code;
  
  /**
   * Integer containing the weighting for the record to be modified.
   * @var integer
   */
  private $_weighting;
  
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
    $this->_command_name = 'modify_country';
    $this->resetAll();
  }
  
  /**
   * This generates the command part of the snippet.
   * @return string
   *   - String containing the command snippet.
   */
  public function generateSnippet() {
    return '"' . $this->_command_name . '":{"country_name":"' . $this->_country_name
      . '","uuid":"' . $this->_uuid
      . '","display_name":"' . $this->_display_name
      . '","description":"' . $this->_description
      . '","country_code":"' . $this->_country_code
      . '","alternate_code":"' . $this->_alternate_code
      . '","weighting":"' . $this->_weighting
      . '","is_active":"' . $this->_is_active . '"}';
  }
  
  /**
   * Sets the UUID for the record to be modified.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $uuid
   *   - The UUID for the record to be modified.
   */
  public function setUuid($uuid) {
    if (isset($uuid) && uuidIsValid($uuid)) {
      $this->_uuid = $uuid;
    } else {
      $this->_uuid = '';
    }
  }
  
  /**
   * Sets the UUID for the record to be modified.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - The UUID for the record to be modified.
   */
  public function getUuid() {
    return $this->_uuid;
  }
  
  /**
   * Sets the country_name for the record to be modified.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $country_name
   *   - The country_name for the record to be modified.
   */
  public function setCountryName($country_name) {
    if (isset($country_name)) {
      $this->_country_name = $country_name;
    } else {
      $this->_country_name = '';
    }
  }
  
  /**
   * Gets the country_name for the record to be modified.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - The country_name for the record to be modified.
   */
  public function getCountryName() {
    return $this->_country_name;
  }
  
  /**
   * Sets the display_name for the record to be modified.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $display_name
   *   - The display_name for the record to be modified.
   */
  public function setDisplayName($display_name) {
    if (isset($display_name)) {
      $this->_display_name = $display_name;
    } else {
      $this->_display_name = '';
    }
  }
  
  /**
   * Gets the display_name for the record to be modified.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - The display_name for the record to be modified.
   */
  public function getDisplayName() {
    return $this->_display_name;
  }
  
  /**
   * Sets the description for the record to be modified.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $description
   *   - The description for the record to be modified.
   */
  public function setDescription($description) {
    if (isset($description)) {
      $this->_description = $description;
    } else {
      $this->_description = '';
    }
  }
  
  /**
   * Gets the description for the record to be modified.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - The description for the record to be modified.
   */
  public function getDescription() {
    return $this->_description;
  }
  
  /**
   * Sets the country_code for the record to be modified.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $country_code
   *   - The country_code for the record to be modified.
   */
  public function setCountryCode($country_code) {
    if (isset($country_code)) {
      $this->_country_code = $country_code;
    } else {
      $this->_country_code = '';
    }
  }
  
  /**
   * Gets the country_code for the record to be modified.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - The country_code for the record to be modified.
   */
  public function getCountryCode() {
    return $this->_country_code;
  }
  
  /**
   * Sets the alternate_code for the record to be modified.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $alternate_code
   *   - The alternate_code for the record to be modified.
   */
  public function setAlternateCode($alternate_code) {
    if (isset($alternate_code)) {
      $this->_alternate_code = $alternate_code;
    } else {
      $this->_alternate_code = '';
    }
  }
  
  /**
   * Gets the alternate_code for the record to be modified.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - The alternate_code for the record to be modified.
   */
  public function getAlternateCode() {
    return $this->_alternate_code;
  }
  
  /**
   * Sets the weighting for the record to be modified.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $weighting
   *   - The weighting for the record to be modified.
   */
  public function setWeighting($weighting) {
    if (isset($weighting) && is_numeric($weighting)) {
      $this->_weighting = $weighting;
    } else {
      $this->_weighting = null;
    }
  }
  
  /**
   * Gets the weighting for the record to be modified.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - The weighting for the record to be modified.
   */
  public function getWeighting() {
    return $this->_weighting;
  }
  
  /**
   * Sets the is_active for the record to be modified.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param integer $is_active
   *   - The is_active for the record to be modified.
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
   * Gets the is_active for the record to be modified.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return integer
   *   - The is_active for the record to be modified.
   */
  public function getIsActive() {
    return $this->_is_active;
  }
  
  /**
   * This sets all the parameters for the message in one shot.
   * @param string $uuid
   *   - The UUID for the record to be modified.
   * @param string $country_name
   *   - The country_name for the record to be modified.
   * @param string $display_name
   *   - The display_name for the record to be modified.
   * @param string $description
   *   - The description for the record to be modified.
   * @param string $country_code
   *   - The country_code for the record to be modified.
   * @param string $alternate_code
   *   - The alternate_code for the record to be modified.
   * @param integer $weighting
   *   - The weighting for the record to be modified.
   * @param integer $is_active
   *   - The is active boolean flag for the record to be modified.
   */
  public function setAll($uuid, $country_name, $display_name, $description,
    $country_code, $alternate_code, $weighting, $is_active) {
    $this->setUuid($uuid);
    $this->setCountryName($country_name);
    $this->setDisplayName($display_name);
    $this->setDescription($description);
    $this->setCountryCode($country_code);
    $this->setAlternateCode($alternate_code);
    $this->setWeighting($weighting);
    $this->setIsActive($is_active);
  }
  
  /**
   * This resets all the values back to the defaults.
   * @author Damien Whaley <damien@whalebonestudios.com>
   */
  public function resetAll() {
    $this->_uuid = '';
    $this->_country_name = '';
    $this->_display_name = '';
    $this->_description = '';
    $this->_country_code = '';
    $this->_alternate_code = '';
    $this->_weighting = null;
    $this->_is_active = 0;
  }
}