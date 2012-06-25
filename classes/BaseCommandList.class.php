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
    $this->_offset = 0;
    $this->_size = -1;
    $this->_direction = SORT_DIRECTION_ASCENDING;
    $this->_ordinal = SORT_ORDINAL_DEFAULT;
  }
    
  /**
   * This sets the size paramter.
   * @param integer $size
   */
  public function setSize($size) {
    $this->_size = $size;
  }
  
  /**
   * This gets the size parameter.
   * @return int
   */
  public function getSize() {
    return $this->_size;
  }
  
  /**
   * This sets the offset paramter.
   * @param integer $offset
   */
  public function setOffset($offset) {
    $this->_offset = $offset;
  }
  
  /**
   * This gets the offset parameter.
   * @return int
   */
  public function getOffset() {
    return $this->_offset;
  }
  
  /**
   * This set the ordinal parameter.
   * @param string $ordinal
   */
  public function setOrdinal($ordinal) {
    $this->_ordinal = $ordinal;
  }
  
  /**
   * This gets the ordinal parameter.
   * @return string
   */
  public function getOrdinal() {
    return $this->_ordinal;
  }  
  /**
   * This sets the direction parameter.
   * @param integer $direction
   */
  public function setDirection($direction) {
    $this->_direction = $direction;
  }
  
  /**
   * This gets the direction parameter.
   * @return string
   */
  public function getDirection($direction) {
    return $this->_direction;
  }
  
  /**
   * This sets all the parameters in one hit.
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
   * Prepare the command ready to be sent.
   */
  public function prepareCommand() {
    $this->setCommandSnippet($this->generateSnippet());
  }
}