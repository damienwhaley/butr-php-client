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
  case 'add_permission':
    $butr_authentication = new Butr\Authentication();
    
    $session_token = $butr_authentication->fetchSessionCookie($window_name);
    if ($session_token === '') {
      $session_token = isset($_POST['token']) ? $_POST['token'] : '';
    }
    
    $butr_authentication->setSessionToken($session_token);
        
    $module_uuid = (isset($_POST['module_uuid'])) ? $_POST['module_uuid'] : '';
    $permission_name = (isset($_POST['permission_name'])) ? $_POST['permission_name'] : '';
    $description = (isset($_POST['description'])) ? $_POST['description'] : '';
    $magic = (isset($_POST['magic'])) ? $_POST['magic'] : '';
    $importance = (isset($_POST['importance'])) ? $_POST['importance'] : '';
    
    $butr_command = new Butr\CommandAddPermission();
    $butr_command->setAll($module_uuid, $permission_name, $description, $magic, $importance);   
    $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
    $butr_command->prepareCommand();
    echo $butr_command->sendCommand();
    
    break;
  case 'modify_permission':
    $butr_authentication = new Butr\Authentication();
  
    $session_token = $butr_authentication->fetchSessionCookie($window_name);
    if ($session_token === '') {
      $session_token = isset($_POST['token']) ? $_POST['token'] : '';
    }
  
    $butr_authentication->setSessionToken($session_token);
    
    $uuid = (isset($_POST['uuid'])) ? $_POST['uuid'] : '';
    $module_uuid = (isset($_POST['module_uuid'])) ? $_POST['module_uuid'] : '';
    $permission_name = (isset($_POST['permission_name'])) ? $_POST['permission_name'] : '';
    $description = (isset($_POST['description'])) ? $_POST['description'] : '';
    $magic = (isset($_POST['magic'])) ? $_POST['magic'] : '';
    $importance = (isset($_POST['importance'])) ? $_POST['importance'] : '';
  
    $butr_command = new Butr\CommandModifyPermission();
    $butr_command->setAll($uuid, $module_uuid, $permission_name, $description, $magic, $importance);
    $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
    $butr_command->prepareCommand();
    echo $butr_command->sendCommand();
    
    break;
  case 'remove_permission':
    $butr_authentication = new Butr\Authentication();
  
    $session_token = $butr_authentication->fetchSessionCookie($window_name);
    if ($session_token === '') {
      $session_token = isset($_POST['token']) ? $_POST['token'] : '';
    }
  
    $butr_authentication->setSessionToken($session_token);
  
    $uuid = (isset($_POST['uuid'])) ? $_POST['uuid'] : '';
  
    $butr_command = new Butr\CommandRemovePermission();
    $butr_command->setUuid($uuid);
  
    $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
    $butr_command->prepareCommand();
    echo $butr_command->sendCommand();
  
    break;
}
