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

switch($command) {
  case 'create_session':
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password_hash = isset($_POST['password_hash']) ? $_POST['password_hash'] : '';
    $nonce = isset($_POST['nonce']) ? $_POST['nonce'] : '';
    $authentication_method = isset($_POST['authentication_method']) ? $_POST['authentication_method'] : '';
    $language = isset($_POST['language']) ? $_POST['language'] : '';
    
    $butr_authentication = new Butr\Authentication();
    $butr_authentication->setNonce($nonce);
    $butr_authentication->setUsername($username);
    $butr_authentication->setPassword($password_hash);
    $butr_authentication->setAuthenticationMethod($authentication_method);
    
    $butr_command = new Butr\CommandCreateSession();
    $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
    $butr_command->setLanguage($language);
    $butr_command->prepareCommand();
    
    echo $butr_command->sendCommand();
    break;
  case 'ping':
    $nonce = isset($_POST['nonce']) ? $_POST['nonce'] : '';
    
    $butr_authentication = new Butr\Authentication();
    $butr_authentication->setNonce($nonce);
    
    $butr_command = new Butr\CommandPing();
    $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
    $butr_command->prepareCommand();
    
    echo $butr_command->sendCommand();
    break;
}
