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
    $this->resetAll();
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
     . '","datetime_setting":"' . date_format($this->_datetime_setting, 'Y-m-d H:i:s')
     . '","bit_setting":"' . $this->_bit_setting . '"}';
  }
  
  /**
   * Sets the name_label for the record to be added.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $name_label
   *   - The name_label for the record to be added.
   */
  public function setNameLabel($name_label) {
    if (isset($name_label)) {
      $this->_name_label = $name_label;
    } else {
      $this->_name_label = '';
    }
  }
  
  /**
   * Gets the name_label for the record to be added.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - The name_label for the record to be added.
   */
  public function getNameLabel() {
    return $this->_name_label;
  }
  
  /**
   * Sets the display_label for the record to be added.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $display_label
   *   - The display_label for the record to be added.
   */
  public function setDisplayLabel($display_label) {
    if (isset($display_label)) {
      $this->_display_label = $display_label;
    } else {
      $this->_display_label = '';
    }
  }
  
  /**
   * Gets the display_label for the record to be added.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - The display_label for the record to be added.
   */
  public function getDisplayLabel() {
    return $this->_display_label;
  }
  
  /**
   * Sets the magic for the record to be added.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $magic
   *   - The magic for the record to be added.
   */
  public function setMagic($magic) {
    if (isset($magic)) {
      $this->_magic = $magic;
    } else {
      $this->_magic = '';
    }
  }
  
  /**
   * Gets the magic for the record to be added.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - The magic for the record to be added.
   */
  public function getMagic() {
    return $this->_magic;
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
   * Sets the text_setting for the record to be added.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $text_setting
   *   - The text_setting for the record to be added.
   */
  public function setTextSetting($text_setting) {
    if (isset($text_setting)) {
      $this->_text_setting = $text_setting;
    } else {
      $this->_text_setting = '';
    }
  }
  
  /**
   * Gets the text_setting for the record to be added.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - The text_setting for the record to be added.
   */
  public function getTextSetting() {
    return $this->_text_setting;
  }
  
  /**
   * Sets the integer_setting for the record to be added.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param integer $integer_setting
   *   - The integer_setting for the record to be added.
   */
  public function setIntegerSetting($integer_setting) {
    if (isset($integer_setting) && is_numeric($integer_setting)) {
      $this->_integer_setting = intval(floor($integer_setting));
    } else {
      $this->_integer_setting = null;
    }
  }
  
  /**
   * Gets the integer_setting for the record to be added.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return integer
   *   - The integer_setting for the record to be added.
   */
  public function getIntegerSetting() {
    return $this->_integer_setting;
  }
  
  /**
   * Sets the float_setting for the record to be added.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param float $float_setting
   *   - The float_setting for the record to be added.
   */
  public function setFloatSetting($float_setting) {
    if (isset($float_setting) && is_numeric($float_setting)) {
      $this->_float_setting = floatval($float_setting);
    } else {
      $this->_float_setting = null;
    }
  }
  
  /**
   * Gets the float_setting for the record to be added.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return float
   *   - The float_setting for the record to be added.
   */
  public function getFloatSetting() {
    return $this->_float_setting;
  }
  
  /**
   * Sets the datetime_setting for the record to be added. This only
   * accepts date times in the format "2012-07-02 12:34:56".
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $datetime_setting
   *   - The datetime_setting for the record to be added.
   */
  public function setDatetimeSetting($datetime_setting) {
    if (isset($datetime_setting)) {
      $datetime = \DateTime::createFromFormat('Y-m-d H:i:s', $datetime_setting);
      if ($datetime) {
        $this->_datetime_setting = $datetime;
      } else {
        $this->_datetime_setting = null;  
      }
    } else {
      $this->_datetime_setting = null;
    }
  }
  
  /**
   * Gets the datetime_setting for the record to be added.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return DateTime
   *   - The datetime_setting for the record to be added.
   */
  public function getDatetimeSetting() {
    return $this->_datetime_setting;
  }
  
  /**
   * Sets the uuid_setting for the record to be added.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $uuid_setting
   *   - The uuid_setting for the record to be added.
   */
  public function setUuidSetting($uuid_setting) {
    if (isset($uuid_setting) && uuidIsValid($uuid_setting)) {
      $this->_uuid_setting = $uuid_setting;
    } else {
      $this->_uuid_setting = '';
    }
  }
  
  /**
   * Gets the uuid_setting for the record to be added.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - The uuid_setting for the record to be added.
   */
  public function getUuidSetting() {
    return $this->_uuid_setting;
  }
  
  /**
   * Sets the bit_setting for the record to be added.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param integer $bit_setting
   *   - The bit_setting for the record to be added.
   */
  public function setBitSetting($bit_setting) {
    if (isset($bit_setting) && is_numeric($bit_setting)) {
      if ($bit_setting == 0) {
        $this->_bit_setting = 0;
      } else {
        $this->_bit_setting = 1;
      }
    } else {
      $this->_bit_setting = 0;
    }
  }
  
  /**
   * Gets the bit_setting for the record to be added.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return integer
   *   - The bit_setting for the record to be added.
   */
  public function getBitSetting() {
    return $this->_bit_setting;
  }
  
  /**
   * This sets all the fields in one method call.
   * @author Damien Whaley <damien@whalebonestudios.com>
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
  public function setAll($name_label, $display_label, $magic, $description,
    $text_setting, $integer_setting, $float_setting, $datetime_setting,
    $uuid_setting, $bit_setting){
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
  
  /**
   * This resets all the values back to the defaults.
   * @author Damien Whaley <damien@whalebonestudios.com>
   */
  public function resetAll() {
    $this->_name_label = '';
    $this->_display_label = '';
    $this->_magic = '';
    $this->_description = '';
    $this->_text_setting = '';
    $this->_integer_setting = null;
    $this->_float_setting = null;
    $this->_datetime_setting = null;
    $this->_uuid_setting = '';
    $this->_bit_setting = 0;
  }
}