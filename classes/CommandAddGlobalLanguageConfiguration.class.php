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
  * CommandAddGlobalLanguageConfiguration class.
  * This implements the functionality required to call the
  * add_global_language_configuration message.
  */
class CommandAddGlobalLanguageConfiguration extends BaseCommand {
  
  /**
   * String containing the name_label for the record to be added.
   * @var string
   */
  private $_name_label;
  
  /**
   * String containing the display_label for the record to be added.
   * @var string
   */
  private $_display_label;
  
  /**
   * String containing the description for the record to be added.
   * @var string
   */
  private $_description;
  
  /**
   * String containing the language_code for the record to be added.
   * @var string
   */
  private $_language_code;
  
  /**
   * String containing the language_family for the record to be added.
   * @var string
   */
  private $_language_family;
  
  /**
   * String containing the country_uuid for the record to be added.
   * @var string
   */
  private $_country_uuid;
  
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
    $this->_command_name = 'add_global_language_configuration';
    $this->_name_label = '';
    $this->_display_label = '';
    $this->_description = '';
    $this->_language_code = '';
    $this->_language_family = '';
    $this->_country_uuid = '';
    $this->_weighting = null;
    $this->_is_active = 0;
  }
  
  /**
   * This generates the command part of the snippet.
   * @return string
   *   - String containing the command snippet.
   */
  public function generateSnippet() {
    return '"' . $this->_command_name . '":{"name_label":"'. $this->_name_label
     . '","display_label":"' . $this->_display_label
     . '","description":"' . $this->_description
     . '","language_code":"' . $this->_language_code
     . '","language_family":"' . $this->_language_family
     . '","country_uuid":"' . $this->_country_uuid
     . '","weighting":"' . $this->_weighting
     . '","is_active":"' . $this->_is_active . '"}';
  }
   
  /**
   * Sets the name_label for the record to be added.
   * @param string $name_label
   *   - The name_label for the record to be added.
   */
  public function setNameLabel($name_label) {
    $this->_name_label = $name_label;
  }
  
  /**
   * Sets the display_label for the record to be added.
   * @param string $display_label
   *   - The display_label for the record to be added.
   */
  public function setDisplayLabel($display_label) {
    $this->_display_label = $display_label;
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
   * Sets the language_code for the record to be added.
   * @param string $language_code
   *   - The language_code for the record to be added.
   */
  public function setLanguageCode($language_code) {
    $this->_language_code = $language_code;
  }
  
  /**
   * Sets the language_family for the record to be added.
   * @param string $language_family
   *   - The language_fmaily for the record to be added.
   */
  public function setLanguageFamily($language_family) {
    $this->_language_family = $language_family;
  }
  
  /**
   * Sets the country_uuid for the record to be added.
   * @param string $country_uuid
   *   - The country_uuid for the record to be added.
   */
  public function setCountryUuid($country_uuid) {
    $this->_country_uuid = $country_uuid;
  }
  
  /**
   * Sets the weighting for the record to be added.
   * @param integer $weighting
   *   - The weighting for the record to be added.
   */
  public function setWeighting($weighting) {    
    $this->_weighting = $weighting;
  }
  
  /**
   * Sets the is_active for the record to be added.
   * @param integer $is_active
   *   - The is_active for the record to be added.
   */
  public function setIsActive($is_active) {
    $this->_is_active = $is_active;
  }
  
  /**
   * This sets all the fields in one method call.
   * @param string $name_label
   *   - The name_label for the record to be added.
   * @param string $display_label
   *   - The display_label for the record to be added.
   * @param string $description
   *   - The description for the record to be added.
   * @param string $language_code
   *   - The language_code for the record to be added.
   * @param string $language_family
   *   - The language_family for the record to be added.
   * @param string $country_uuid
   *   - The country_uuid for the record to be added.
   * @param integer $weighting
   *   - The weighting for the record to be added.
   * @param integer $is_active
   *   - The is_active for the record to be added.
   */
  public function setAll($name_label, $display_label, $description,
    $language_code, $language_family, $country_uuid, $weighting, $is_active){
    $this->setNameLabel($name_label);
    $this->setDisplayLabel($display_label);
    $this->setDescription($description);
    $this->setLanguageCode($language_code);
    $this->setLanguageFamily($language_family);
    $this->setCountryUuid($country_uuid);
    $this->setWeighting($weighting);
    $this->setIsActive($is_active);
  }
}