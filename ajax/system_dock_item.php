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
  case 'add_dock_item':
    $butr_authentication = new Butr\Authentication();
    
    $session_token = $butr_authentication->fetchSessionCookie($window_name);
    if ($session_token === '') {
      $session_token = isset($_POST['token']) ? $_POST['token'] : '';
    }
    
    $butr_authentication->setSessionToken($session_token);
    
    $dock_uuid = (isset($_POST['dock_uuid'])) ? $_POST['dock_uuid'] : '';
    $system_dock_type_uuid = (isset($_POST['system_dock_type_uuid'])) ? $_POST['system_dock_type_uuid'] : '';
    $security_client_type_uuid = (isset($_POST['security_client_type_uuid'])) ? $_POST['security_client_type_uuid'] : '';
    $item_name = (isset($_POST['item_name'])) ? $_POST['item_name'] : '';
    $display_name = (isset($_POST['display_name'])) ? $_POST['display_name'] : '';
    $description = (isset($_POST['description'])) ? $_POST['description'] : '';
    $weighting = (isset($_POST['weighting'])) ? $_POST['weighting'] : '';
    $icon = (isset($_POST['icon'])) ? $_POST['icon'] : '';
    $item_action = (isset($_POST['item_action'])) ? $_POST['item_action'] : '';
    $is_active = (isset($_POST['is_active'])) ? $_POST['is_active'] : '';
    
    $butr_command = new Butr\CommandAddDockItem();
    $butr_command->setAll($dock_uuid, $system_dock_type_uuid, $security_client_type_uuid, $item_name,
       $display_name, $description, $weighting, $icon, $item_action, $is_active);
    $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
    $butr_command->prepareCommand();
    echo $butr_command->sendCommand();
    
    break;
  case 'modify_dock_item':
    $butr_authentication = new Butr\Authentication();
    
    $session_token = $butr_authentication->fetchSessionCookie($window_name);
    if ($session_token === '') {
      $session_token = isset($_POST['token']) ? $_POST['token'] : '';
    }
    
    $butr_authentication->setSessionToken($session_token);
    
    $uuid = (isset($_POST['uuid'])) ? $_POST['uuid'] : '';
    $dock_uuid = (isset($_POST['dock_uuid'])) ? $_POST['dock_uuid'] : '';
    $system_dock_type_uuid = (isset($_POST['system_dock_type_uuid'])) ? $_POST['system_dock_type_uuid'] : '';
    $security_client_type_uuid = (isset($_POST['security_client_type_uuid'])) ? $_POST['security_client_type_uuid'] : '';
    $item_name = (isset($_POST['item_name'])) ? $_POST['item_name'] : '';
    $display_name = (isset($_POST['display_name'])) ? $_POST['display_name'] : '';
    $description = (isset($_POST['description'])) ? $_POST['description'] : '';
    $weighting = (isset($_POST['weighting'])) ? $_POST['weighting'] : '';
    $icon = (isset($_POST['icon'])) ? $_POST['icon'] : '';
    $item_action = (isset($_POST['item_action'])) ? $_POST['item_action'] : '';
    $is_active = (isset($_POST['is_active'])) ? $_POST['is_active'] : '';
    
    $butr_command = new Butr\CommandModifyDockItem();
    $butr_command->setAll($uuid, $dock_uuid, $system_dock_type_uuid, $security_client_type_uuid, $item_name,
      $display_name, $description, $weighting, $icon, $item_action, $is_active);
    $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
    $butr_command->prepareCommand();
    echo $butr_command->sendCommand();
    
    break;
  case 'remove_dock_item':
    $butr_authentication = new Butr\Authentication();
  
    $session_token = $butr_authentication->fetchSessionCookie($window_name);
    if ($session_token === '') {
      $session_token = isset($_POST['token']) ? $_POST['token'] : '';
    }
  
    $butr_authentication->setSessionToken($session_token);
  
    $uuid = (isset($_POST['uuid'])) ? $_POST['uuid'] : '';
  
    $butr_command = new Butr\CommandRemoveDockItem();
    $butr_command->setUuid($uuid);
    $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
    $butr_command->prepareCommand();
    echo $butr_command->sendCommand();
  
    break;
}
