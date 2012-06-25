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
  * CommandAddCountry class.
  * This implements the functionality required to call the
  * add_country message.
  */
class CommandAddCountry extends BaseCommand {
  
  /**
   * String containing the country_name for the record to be added.
   * @var string
   */
  private $_country_name;
  
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
   * String containing the country_code for the record to be added.
   * @var string
   */
  private $_country_code;
  
  /**
   * String containing the alternate_code for the record to be added.
   * @var string
   */
  private $_alternate_code;
  
  /**
   * Integer containing the weighting for the record to be added.
   * @var integer
   */
  private $_weighting;
  
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
    $this->_command_name = 'add_country';
    $this->_country_name = '';
    $this->_display_name = '';
    $this->_description = '';
    $this->_country_code = '';
    $this->_alternate_code = '';
    $this->_weighting = null;
    $this->_is_active = 0;
  }
  
  /**
   * This generates the command part of the snippet.
   * @return string
   *   - String containing the command snippet.
   */
  public function generateSnippet() {
    return '"' . $this->_command_name . '":{"country_name":"' . $this->_country_name
      . '","display_name":"' . $this->_display_name
      . '","description":"' . $this->_description
      . '","country_code":"' . $this->_country_code
      . '","alternate_code":"' . $this->_alternate_code
      . '","weighting":"' . $this->_weighting
      . '","is_active":"' . $this->_is_active . '"}';
  }
  
  /**
   * Prepare the command ready to be sent.
   */
  public function prepareCommand() {  
    $this->setCommandSnippet($this->generateSnippet());
  }
  
  /**
   * Sets the country_name for the record to be added.
   * @param string $country_name
   *   - The country_name for the record to be added.
   */
  public function setCountryName($country_name) {
    $this->_country_name = $country_name;
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
   * Sets the country_code for the record to be added.
   * @param string $country_code
   *   - The country_code for the record to be added.
   */
  public function setCountryCode($country_code) {
    $this->_country_code = $country_code;
  }
  
  /**
   * Sets the alternate_code for the record to be added.
   * @param string $alternate_code
   *   - The alternate_code for the record to be added.
   */
  public function setAlternateCode($alternate_code) {
    $this->_alternate_code = $alternate_code;
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
   * Sets the is_active for the record to be added.
   * @param integer $is_active
   *   - The description for the record to be added.
   */
  public function setIsActive($is_active) {
    $this->_is_active = $is_active;
  }
  
  /**
   * This sets all the parameters for the message in one shot.
   * @param string $country_name
   *   - The country_name for the record to be added.
   * @param string $display_name
   *   - The display_name for the record to be added.
   * @param string $description
   *   - The description for the record to be added.
   * @param string $country_code
   *   - The country_code for the record to be added.
   * @param string $alternate_code
   *   - The alternate_code for the record to be added.
   * @param integer $weighting
   *   - The weighting for the record to be added.
   * @param integer $is_active
   *   - The is active boolean flag for the record to be added.
   */
  public function setAll($country_name, $display_name, $description,
    $country_code, $alternate_code, $weighting, $is_active) {
    $this->setCountryName($country_name);
    $this->setDisplayName($display_name);
    $this->setDescription($description);
    $this->setCountryCode($country_code);
    $this->setAlternateCode($alternate_code);
    $this->setWeighting($weighting);
    $this->setIsActive($is_active);
  }
}