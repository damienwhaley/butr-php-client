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

/*
 * This is the critical minimum settings for the Butr application. Please fill
 * in your values below, and make sure this file is secure!
 */

// Database connection strings
define('Butr\DATABASE_ENGINE', 'mysql');
define('Butr\DATABASE_HOST', 'localhost');
define('Butr\DATABASE_PORT', '3306');
define('Butr\DATABASE_NAME', 'DBNAME');
define('Butr\DATABASE_USER', 'DBUSER');
define('Butr\DATABASE_PASS', 'DBPASS');

// API Key Registration
define('Butr\API_KEY', ''); // Pre-determined UUID
define('Butr\API_SECRET', ''); // Hashed secret

// Butr Node.js Server
define('Butr\NODEJS_SERVER', 'http://butr-server.node.local:3000/json');

// Default Language
define('Butr\DEFAULT_LANGUAGE', 'en-AU');
