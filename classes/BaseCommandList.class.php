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
  * BaseCommandList class.
  * This base class implements the basics for the list
  * messages.
  */
abstract class BaseCommandList extends BaseCommand {
  
  /**
   * Integer containing the offset for the page to start showing results from.
   * @var integer
   */
  protected $_offset;
  
  /**
   * Integer containing the number of results per page.
   * @var integer
   */
  protected $_size;
  
  /**
   * String containing the direction of sorting.
   * @var string
   */
  protected $_direction;
  
  /**
   * String containing the field of the results to sort on.
   * @var string
   */
  protected $_ordinal;
  
  /**
   * Default constructor.
   */
  public function __construct() {
    parent::__construct();
    $this->_command_name = '';
    $this->resetAll();
  }
    
  /**
   * This sets the size paramter.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param integer $size
   */
  public function setSize($size) {
    if (isset($size) && is_numeric($size) && $size >= 0) {
      $this->_size = $size;
    } else {
      $this->_size = LIST_SIZE_ALL;
    }
  }
  
  /**
   * This gets the size parameter.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return int
   */
  public function getSize() {
    return $this->_size;
  }
  
  /**
   * This sets the offset paramter.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param integer $offset
   */
  public function setOffset($offset) {
    if (isset($offset) && is_numeric($offset) && $offset >= 0) {
      $this->_offset = $offset;
    } else {
      $this->_offset = 0;
    }
  }
  
  /**
   * This gets the offset parameter.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return int
   */
  public function getOffset() {
    return $this->_offset;
  }
  
  /**
   * This set the ordinal parameter.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $ordinal
   */
  public function setOrdinal($ordinal) {
    if (isset($ordinal)) {
      $this->_ordinal = $ordinal;
    } else {
      $this->_ordinal = SORT_ORDINAL_DEFAULT;
    }
  }
  
  /**
   * This gets the ordinal parameter.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   */
  public function getOrdinal() {
    return $this->_ordinal;
  }  
  /**
   * This sets the direction parameter.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param integer $direction
   */
  public function setDirection($direction) {   
    if (isset($direction) && strcmp($direction, SORT_DIRECTION_DESCENDING) == 0) {
      $this->_direction = SORT_DIRECTION_DESCENDING;
    } else {
      $this->_direction = SORT_DIRECTION_ASCENDING;
    }
  }
  
  /**
   * This gets the direction parameter.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   */
  public function getDirection() {
    return $this->_direction;
  }
  
  /**
   * This sets all the parameters in one hit.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param integer $offset
   *   - Integer containing the page offset in the results.
   * @param integer $size
   *   - Integer containing the number of results to display.
   * @param string $direction
   *   - String containing the direction to sort the results in.
   * @param sting $ordinal
   *   - String containing the field to sort on.
   */
  public function setAll($offset, $size, $direction, $ordinal) {
    $this->setOffset($offset);
    $this->setSize($size);
    $this->setDirection($direction);
    $this->setOrdinal($ordinal);
  }
  
  /**
   * This generates the command part of the snippet.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - String containing the command snippet.
   */
  public function generateSnippet() {
    return '"' . $this->_command_name . '":{"offset":"' . $this->_offset
    .'","size":"' . $this->_size
    .'","direction":"' . $this->_direction
    .'","ordnial":"' . $this->_ordinal
    .'"}';
  }
  
  /**
   * This resets all the parameters in one hit.
   * @author Damien Whaley <damien@whalebonestudios.com>
   */
  public function resetAll() {
    $this->_offset = 0;
    $this->_size = LIST_SIZE_ALL;
    $this->_direction = SORT_DIRECTION_ASCENDING;
    $this->_ordinal = SORT_ORDINAL_DEFAULT;
  }
}