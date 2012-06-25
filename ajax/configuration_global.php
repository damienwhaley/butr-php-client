<?php
/*
 * Butr Universal Travel Reservations
 * A bleeding edge business management system for the travel industry.
 *
 * Copyright (C) 2012 Whalebone Studios and contributors.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 *  published by the Free Software Foundation, either version 3 of the
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

// Includes and requires.
require_once('../includes/butr.inc');

$command = isset($_POST['command']) ? $_POST['command'] : '';
$window_name = isset($_POST['window_name']) ? $_POST['window_name'] : '';

switch($command) {
  case 'add_global_configuration':
    $butr_authentication = new Butr\Authentication();
    
    $session_token = $butr_authentication->fetchSessionCookie($window_name);
    if ($session_token === '') {
      $session_token = isset($_POST['token']) ? $_POST['token'] : '';
    }
    
    $butr_authentication->setSessionToken($session_token);
        
    $name_label = (isset($_POST['name_label'])) ? $_POST['name_label'] : '';
    $display_label = (isset($_POST['display_label'])) ? $_POST['display_label'] : '';
    $description = (isset($_POST['description'])) ? $_POST['description'] : '';
    $magic = (isset($_POST['magic'])) ? $_POST['magic'] : '';
    $text_setting = (isset($_POST['text_setting'])) ? $_POST['text_setting'] : '';
    $integer_setting = (isset($_POST['integer_setting'])) ? $_POST['integer_setting'] : '';
    $float_setting = (isset($_POST['float_setting'])) ? $_POST['float_setting'] : '';
    $datetime_setting = (isset($_POST['datetime_setting'])) ? $_POST['datetime_setting'] : '';
    $uuid_setting = (isset($_POST['uuid_setting'])) ? $_POST['uuid_setting'] : '';
    $bit_setting = (isset($_POST['bit_setting'])) ? $_POST['bit_setting'] : '';
    
    $butr_command = new Butr\CommandAddGlobalConfiguration();
    $butr_command->setAll($name_label, $display_label, $magic, $description,
      $text_setting, $integer_setting, $float_setting, $datetime_setting,
      $uuid_setting, $bit_setting);
    
    $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
    $butr_command->prepareCommand();
    
    echo $butr_command->sendCommand();
    
    break;
  case 'modify_global_configuration':
    $butr_authentication = new Butr\Authentication();
    
    $session_token = $butr_authentication->fetchSessionCookie($window_name);
    if ($session_token === '') {
      $session_token = isset($_POST['token']) ? $_POST['token'] : '';
    }
    
    $butr_authentication->setSessionToken($session_token);
    
    $uuid = (isset($_POST['uuid'])) ? $_POST['uuid'] : '';
    $name_label = (isset($_POST['name_label'])) ? $_POST['name_label'] : '';
    $display_label = (isset($_POST['display_label'])) ? $_POST['display_label'] : '';
    $description = (isset($_POST['description'])) ? $_POST['description'] : '';
    $magic = (isset($_POST['magic'])) ? $_POST['magic'] : '';
    $text_setting = (isset($_POST['text_setting'])) ? $_POST['text_setting'] : '';
    $integer_setting = (isset($_POST['integer_setting'])) ? $_POST['integer_setting'] : '';
    $float_setting = (isset($_POST['float_setting'])) ? $_POST['float_setting'] : '';
    $datetime_setting = (isset($_POST['datetime_setting'])) ? $_POST['datetime_setting'] : '';
    $uuid_setting = (isset($_POST['uuid_setting'])) ? $_POST['uuid_setting'] : '';
    $bit_setting = (isset($_POST['bit_setting'])) ? $_POST['bit_setting'] : '';
    
    $butr_command = new Butr\CommandModifyGlobalConfiguration();
    $butr_command->setAll($uuid, $name_label, $display_label, $magic, $description,
      $text_setting, $integer_setting, $float_setting, $datetime_setting,
      $uuid_setting, $bit_setting);
    $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
    $butr_command->prepareCommand();
    
    echo $butr_command->sendCommand();
    
    break;
  case 'remove_global_configuration':
    $butr_authentication = new Butr\Authentication();
  
    $session_token = $butr_authentication->fetchSessionCookie($window_name);
    if ($session_token === '') {
      $session_token = isset($_POST['token']) ? $_POST['token'] : '';
    }
  
    $butr_authentication->setSessionToken($session_token);
  
    $uuid = (isset($_POST['uuid'])) ? $_POST['uuid'] : '';
  
    $butr_command = new Butr\CommandRemoveGlobalConfiguration();
    $butr_command->setUuid($uuid);
    $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
    $butr_command->prepareCommand();  
    
    echo $butr_command->sendCommand();
  
    break;
}
