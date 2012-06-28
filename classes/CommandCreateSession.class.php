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
  * CommandCreateSession class.
  * This implements the functionality required to call the
  * create_session message.
  */
class CommandCreateSession extends BaseCommand {

  /**
   * String containing the language.
   * @var string
   */
  private $_language;
  
  /**
   * Default constructor.
   */
  public function __construct() {
    parent::__construct();
    $this->_command_name = 'create_session';
  }
  
  /**
   * This generates the command part of the snippet.
   * @return string
   *   - String containing the command snippet.
   */
  public function generateSnippet() {
    $output = '"' . $this->_command_name . '": {';
    if($this->_language && $this->_language !== '') {
      $output .= '"language":"' . $this->_language . '"';
    }
    $output .= '}';
    
    return $output;
  }
  
  /**
   * This returns the language used.
   * @return string
   *   - The language for this command.
   */
  public function getLanguage() {
    return $this->_language;
  }
  
  /**
   * This sets the langauge to generate the command correctly.
   * @param string $language
   *   - The language code to use.
   */
  public function setLanguage($language) {
    if ($language && $language !== '') {
      $this->_language = $language;
    }
  }
}