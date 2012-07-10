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
  * CommandModifySecurityClientTypeConfiguration class.
  * This implements the functionality required to call the
  * modify_security_client_type_configuration message.
  */
class CommandModifySecurityClientTypeConfiguration extends BaseCommand {
  
  /**
   * String containing the uuid for the record to be modified.
   * @var string
   */
  private $_uuid;
  
  /**
   * String containing the name_label for the record to be modified.
   * @var string
   */
  private $_name_label;
  
  /**
   * String containing the display_label for the record to be modified.
   * @var string
   */
  private $_display_label;
  
  /**
   * String containing the description for the record to be modified.
   * @var string
   */
  private $_description;
  
  /**
   * String containing the magic for the record to be modified.
   * @var string
   */
  private $_magic;
  
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
    $this->_command_name = 'modify_security_client_type_configuration';
    $this->resetAll();
  }
  
  /**
   * This generates the command part of the snippet.
   * @return string
   *   - String containing the command snippet.
   */
  public function generateSnippet() {
    return '"' . $this->_command_name . '":{"name_label":"'. $this->_name_label
     . '","uuid":"' . $this->_uuid
     . '","display_label":"' . $this->_display_label
     . '","description":"' . $this->_description
     . '","magic":"' . $this->_magic
     . '","weighting":"' . $this->_weighting
     . '","is_active":"' . $this->_is_active . '"}';
  }
  
  /**
   * Sets the uuid for the record to be modified.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $uuid
   *   - The uuid for the record to be modified.
   */
  public function setUuid($uuid) {
    if (isset($uuid) && uuidIsValid($uuid)) {
      $this->_uuid = $uuid;
    } else {
      $this->_uuid = '';
    }
  }
  
  /**
   * Gets the uuid for the record to be modified.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - The uuid for the record to be modified.
   */
  public function getUuid() {
    return $this->_uuid;
  }
  
  /**
   * Sets the name_label for the record to be modified.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $name_label
   *   - The name_label for the record to be modified.
   */
  public function setNameLabel($name_label) {
    if (isset($name_label)) {
      $this->_name_label = $name_label;
    } else {
      $this->_name_label = '';
    }
  }
  
  /**
   * Gets the name_label for the record to be modified.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - The name_label for the record to be modified.
   */
  public function getNameLabel() {
    return $this->_name_label;
  }
  
  /**
   * Sets the display_label for the record to be modified.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $display_label
   *   - The display_label for the record to be modified.
   */
  public function setDisplayLabel($display_label) {
    if (isset($display_label)) {
      $this->_display_label = $display_label;
    } else {
      $this->_display_label = '';
    }
  }
  
  /**
   * Gets the display_label for the record to be modified.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @reutrn string
   *   - The display_label for the record to be modified.
   */
  public function getDisplayLabel() {
    return $this->_display_label;
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
   * Sets the magic for the record to be modified.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $magic
   *   - The magic for the record to be modified.
   */
  public function setMagic($magic) {
    if (isset($magic)) {
      $this->_magic = $magic;
    } else {
      $this->_magic = '';
    }
  }
  
  /**
   * Gets the magic for the record to be modified.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - The magic for the record to be modified.
   */
  public function getMagic() {
    return $this->_magic;
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
   * This sets all the fields in one method call.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $uuid
   *   - The UUID for the record to be modified.
   * @param string $name_label
   *   - The name_label for the record to be modified.
   * @param string $display_label
   *   - The display_label for the record to be modified.
   * @param string $description
   *   - The description for the record to be modified.
   * @param string $magic
   *   - The magic for the record to be modified.
   * @param integer $weighting
   *   - The weighting for the record to be modified.
   * @param integer $is_active
   *   - The is_active for the record to be modified.
   */
  public function setAll($uuid, $name_label, $display_label, $description,
    $magic, $weighting, $is_active){
    $this->setUuid($uuid);
    $this->setNameLabel($name_label);
    $this->setDisplayLabel($display_label);
    $this->setDescription($description);
    $this->setMagic($magic);
    $this->setWeighting($weighting);
    $this->setIsActive($is_active);
  }
  
  /**
   * This resets all the values back to the defaults.
   * @author Damien Whaley <damien@whalebonestudios.com>
   */
  public function resetAll() {
    $this->_uuid = '';
    $this->_name_label = '';
    $this->_display_label = '';
    $this->_description = '';
    $this->_magic = '';
    $this->_weighting = null;
    $this->_is_active = 0;
  }
}