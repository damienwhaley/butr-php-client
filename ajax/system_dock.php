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
  case 'add_dock':
    $butr_authentication = new Butr\Authentication();
    
    $session_token = $butr_authentication->fetchSessionCookie($window_name);
    if ($session_token === '') {
      $session_token = isset($_POST['token']) ? $_POST['token'] : '';
    }
    
    $butr_authentication->setSessionToken($session_token);
        
    $security_client_type_uuid = (isset($_POST['security_client_type_uuid'])) ? $_POST['security_client_type_uuid'] : '';
    $dock_name = (isset($_POST['dock_name'])) ? $_POST['dock_name'] : '';
    $display_name = (isset($_POST['display_name'])) ? $_POST['display_name'] : '';
    $description = (isset($_POST['description'])) ? $_POST['description'] : '';
    $weighting = (isset($_POST['weighting'])) ? $_POST['weighting'] : '';
    $picture_path = (isset($_POST['picture_path'])) ? $_POST['picture_path'] : '';
    $is_active = (isset($_POST['is_active'])) ? $_POST['is_active'] : '';
    
    $butr_command = new Butr\CommandAddDock();
    $butr_command->setAll($security_client_type_uuid, $dock_name, $display_name,
      $description, $weighting, $picture_path, $is_active);
    
    $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
    $butr_command->prepareCommand();
    echo $butr_command->sendCommand();
    
    break;
  case 'modify_dock':
    $butr_authentication = new Butr\Authentication();
    
    $session_token = $butr_authentication->fetchSessionCookie($window_name);
    if ($session_token === '') {
      $session_token = isset($_POST['token']) ? $_POST['token'] : '';
    }
    
    $butr_authentication->setSessionToken($session_token);
    
    $uuid = (isset($_POST['uuid'])) ? $_POST['uuid'] : '';
    $security_client_type_uuid = (isset($_POST['security_client_type_uuid'])) ? $_POST['security_client_type_uuid'] : '';
    $dock_name = (isset($_POST['dock_name'])) ? $_POST['dock_name'] : '';
    $display_name = (isset($_POST['display_name'])) ? $_POST['display_name'] : '';
    $description = (isset($_POST['description'])) ? $_POST['description'] : '';
    $weighting = (isset($_POST['weighting'])) ? $_POST['weighting'] : '';
    $picture_path = (isset($_POST['picture_path'])) ? $_POST['picture_path'] : '';
    $is_active = (isset($_POST['is_active'])) ? $_POST['is_active'] : '';
    
    $butr_command = new Butr\CommandModifyDock();
    $butr_command->setAll($uuid, $security_client_type_uuid, $dock_name,
      $display_name, $description, $weighting, $picture_path, $is_active);    
    $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
    $butr_command->prepareCommand();
    echo $butr_command->sendCommand();
    
    break;
  case 'remove_dock':
    $butr_authentication = new Butr\Authentication();
  
    $session_token = $butr_authentication->fetchSessionCookie($window_name);
    if ($session_token === '') {
      $session_token = isset($_POST['token']) ? $_POST['token'] : '';
    }
  
    $butr_authentication->setSessionToken($session_token);
  
    $uuid = (isset($_POST['uuid'])) ? $_POST['uuid'] : '';
  
    $butr_command = new Butr\CommandRemoveDock();
    $butr_command->setUuid($uuid);
    $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
    $butr_command->prepareCommand();
    echo $butr_command->sendCommand();
  
    break;
}
