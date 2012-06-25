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
* License, or (at your option) any later version.
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
 * Autoload function for Butr classes.
 * @param string $class
 *   - The name of the class to be loaded.
 */
function autoload_class($class) {
  $found_butr_class = false;
  
  if (is_null($class)) {
    return;
  }
  
  $class_location = trim($class);
  
  if ($class_location === '') {
    return;
  }
  
  // Handle the Butr namespace prefix
  if (strlen($class_location) > 5) {
    if (substr($class_location, 0, 5) === 'Butr\\') {      
      $class_location = substr($class_location, 5, strlen($class_location) - 5);
      $found_butr_class = true;
    }
  }
  
  if ($class_location === '' || $found_butr_class === false) {
    return;
  } else {
    $document_root = realpath($_SERVER["DOCUMENT_ROOT"]);    
    require_once($document_root . '/classes/' . $class_location . '.class.php');
  }
}

spl_autoload_register('Butr\autoload_class');
