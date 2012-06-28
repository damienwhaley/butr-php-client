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
  * CommandAddGlobalConfiguration class.
  * This implements the functionality required to call the
  * add_global_configuration message.
  */
class CommandAddGlobalConfiguration extends BaseCommand {
  
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
   * String containing the magic for the record to be added.
   * @var string
   */
  private $_magic;
  
  /**
   * String containing the description for the record to be added.
   * @var string
   */
  private $_description;
  
  /**
   * String containing the text_setting for the record to be added.
   * @var string
   */
  private $_text_setting;
  
  /**
   * Integer containing the integer_setting for the record to be added.
   * @var integer
   */
  private $_integer_setting;
  
  /**
   * Float containing the float_setting for the record to be added.
   * @var float
   */
  private $_float_setting;
  
  /**
   * Date containing the datetime_setting for the record to be added.
   * @var DateTime
   */
  private $_datetime_setting;
  
  /**
   * String containing the uuid_setting for the record to be added.
   * @var string
   */
  private $_uuid_setting;
  
  /**
   * Integer containing the bit_setting for the record to be added.
   * @var integer
   */
  private $_bit_setting;
  
  /**
   * Default constructor.
   */
  public function __construct() {
    parent::__construct();
    $this->_command_name = 'add_global_configuration';
    $this->_name_label = '';
    $this->_display_label = '';
    $this->_magic = '';
    $this->_description = '';
    $this->_text_setting = '';
    $this->_integer_setting = '';
    $this->_float_setting = '';
    $this->_datetime_setting = '';
    $this->_bit_setting = '';
  }
  
  /**
   * This generates the command part of the snippet.
   * @return string
   *   - String containing the command snippet.
   */
  public function generateSnippet() {
    return '"' . $this->_command_name . '":{"name_label":"'. $this->_name_label
     . '","display_label":"' . $this->_display_label
     . '","magic":"' . $this->_magic
     . '","description":"' . $this->_description
     . '","text_setting":"' . $this->_text_setting
     . '","integer_setting":"' . $this->_integer_setting
     . '","float_setting":"' . $this->_float_setting
     . '","datetime_setting":"' . $this->_datetime_setting
     . '","bit_setting":"' . $this->_bit_setting . '"}';
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
   * Sets the magic for the record to be added.
   * @param string $magic
   *   - The magic for the record to be added.
   */
  public function setMagic($magic) {
    $this->_magic = $magic;
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
   * Sets the text_setting for the record to be added.
   * @param string $text_setting
   *   - The text_setting for the record to be added.
   */
  public function setTextSetting($text_setting) {
    $this->_text_setting = $text_setting;
  }
  
  /**
   * Sets the integer_setting for the record to be added.
   * @param integer $integer_setting
   *   - The integer_setting for the record to be added.
   */
  public function setIntegerSetting($integer_setting) {
    $this->_integer_setting = $integer_setting;
  }
  
  /**
   * Sets the float_setting for the record to be added.
   * @param float $float_setting
   *   - The float_setting for the record to be added.
   */
  public function setFloatSetting($float_setting) {
    $this->_float_setting = $float_setting;
  }
  
  /**
   * Sets the datetime_setting for the record to be added.
   * @param DateTime $datetime_setting
   *   - The datetime_setting for the record to be added.
   */
  public function setDatetimeSetting($datetime_setting) {
    // make sure the format is YYYY-MM-DD HH:mm:ss
    
    $this->_datetime_setting = $datetime_setting;
  }
  
  /**
   * Sets the uuid_setting for the record to be added.
   * @param string $uuid_setting
   *   - The uuid_setting for the record to be added.
   */
  public function setUuidSetting($uuid_setting) {
    $this->_uuid_setting = $uuid_setting;
  }
  
  /**
   * Sets the bit_setting for the record to be added.
   * @param integer $bit_setting
   *   - The bit_setting for the record to be added.
   */
  public function setBitSetting($bit_setting) {
    $this->_bit_setting = $name_label;
  }
  
  /**
   * This sets all the fields in one method call.
   * @param string $name_label
   *   - The name_label for the record to be added.
   * @param string $display_label
   *   - The display_label for the record to be added.
   * @param string $magic
   *   - The magic for the record to be added.
   * @param string $description
   *   - The description for the record to be added.
   * @param string $text_setting
   *   - The text_setting for the record to be added.
   * @param integer $integer_setting
   *   - The integer_setting for the record to be added.
   * @param float $float_setting
   *   - The float_setting for the record to be added.
   * @param DateTime $datetime_setting
   *   - The datetime_setting for the record to be added.
   * @param string $uuid_setting
   *   - The uuid_setting for the record to be added.
   * @param integer $bit_setting
   *   - The bit_setting for the record to be added.
   */
  public function setAll($name_label, $display_label, $magic, $description, $text_setting, $integer_setting, $float_setting, $datetime_setting, $uuid_setting, $bit_setting){
    $this->setNameLabel($name_label);
    $this->setDisplayLabel($display_label);
    $this->setMagic($magic);
    $this->setDescription($description);
    $this->setTextSetting($text_setting);
    $this->setIntegerSetting($integer_setting);
    $this->setFloatSetting($float_setting);
    $this->setDatetimeSetting($datetime_setting);
    $this->setUuidSetting($uuid_setting);
    $this->setBitSetting($bit_setting);
  }
}