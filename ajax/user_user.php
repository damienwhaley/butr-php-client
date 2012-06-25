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
  case 'add_user':
    $butr_authentication = new Butr\Authentication();
    
    $session_token = $butr_authentication->fetchSessionCookie($window_name);
    if ($session_token === '') {
      $session_token = isset($_POST['token']) ? $_POST['token'] : '';
    }
    
    $butr_authentication->setSessionToken($session_token);
        
    $global_title_uuid = (isset($_POST['global_title_uuid'])) ? $_POST['global_title_uuid'] : '';
    $first_name = (isset($_POST['first_name'])) ? $_POST['first_name'] : '';
    $last_name = (isset($_POST['last_name'])) ? $_POST['last_name'] : '';
    $preferred_global_language_uuid = (isset($_POST['preferred_global_language_uuid'])) ? $_POST['preferred_global_language_uuid'] : '';
    $username = (isset($_POST['username'])) ? $_POST['username'] : '';
    
    $butr_command = new Butr\CommandAddUser();
    $butr_command->setAll($global_title_uuid, $first_name, $last_name,
      $preferred_global_language_uuid, $username);
    
    $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
    $butr_command->prepareCommand();
    echo $butr_command->sendCommand();
    
    break;
  case 'modify_user':
    $butr_authentication = new Butr\Authentication();
  
    $session_token = $butr_authentication->fetchSessionCookie($window_name);
    if ($session_token === '') {
      $session_token = isset($_POST['token']) ? $_POST['token'] : '';
    }
  
    $butr_authentication->setSessionToken($session_token);
    
    $uuid = (isset($_POST['uuid'])) ? $_POST['uuid'] : '';
    $global_title_uuid = (isset($_POST['global_title_uuid'])) ? $_POST['global_title_uuid'] : '';
    $first_name = (isset($_POST['first_name'])) ? $_POST['first_name'] : '';
    $last_name = (isset($_POST['last_name'])) ? $_POST['last_name'] : '';
    $preferred_global_language_uuid = (isset($_POST['preferred_global_language_uuid'])) ? $_POST['preferred_global_language_uuid'] : '';
    $username = (isset($_POST['username'])) ? $_POST['username'] : '';
  
    $butr_command = new Butr\CommandModifyUser();
    $butr_command->setAll($uuid, $global_title_uuid, $first_name, $last_name,
      $preferred_global_language_uuid, $username);
  
    $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
    $butr_command->prepareCommand();
    echo $butr_command->sendCommand();
    
    break;
  case 'remove_user':
    $butr_authentication = new Butr\Authentication();
  
    $session_token = $butr_authentication->fetchSessionCookie($window_name);
    if ($session_token === '') {
      $session_token = isset($_POST['token']) ? $_POST['token'] : '';
    }
  
    $butr_authentication->setSessionToken($session_token);
  
    $uuid = (isset($_POST['uuid'])) ? $_POST['uuid'] : '';
  
    $butr_command = new Butr\CommandRemoveUser();
    $butr_command->setUuid($uuid);
  
    $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
    $butr_command->prepareCommand();
    echo $butr_command->sendCommand();
  
    break;
}
