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

// Requires and includes.
$document_root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once($document_root . '/includes/settings.inc');
require_once($document_root . '/includes/constants.inc');

/**
  * BaseCommand class.
  * This is a base class which is extended by other classes.
  */
abstract class BaseCommand {
  
  /**
   * String containing the authentication snippet.
   * @var string
   */
  protected $_authentication_snippet;
  
  /**
   * String containing the message name.
   * @var string
   */
  protected $_command_name;
  
  /**
   * String containing the command message snippet.
   * @var string
   */
  protected $_command_snippet;
  
  /**
   * Default constructor.
   * @author Damien Whaley <damien@whalebonestudios.com>
   */
  public function __construct() {
    $this->_authentication_snippet = '';
    $this->_command_name = '';
    $this->_command_snippet = '';
  }
  
  /**
   * This sets the authentication part for the message.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $snippet
   */
  public function setAuthenticationSnippet($snippet) {
    if($snippet && $snippet !== '') {
      $this->_authentication_snippet = $snippet;
    }
  }
  
  /**
   * This sets the command part for the message.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $snippet
   */
  public function setCommandSnippet($snippet) {
    if($snippet && $snippet !== '') {
      $this->_command_snippet = $snippet;
    }
  }
  
  /**
   * This abstract function must be defined in child classes.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - String containing the command snippet.
   */
  abstract public function generateSnippet();
  
  /**
   * Prepare the command ready to be sent.
   * @author Damien Whaley <damien@whalebonestudios.com>
   */
  public function prepareCommand() {  
    $this->setCommandSnippet($this->generateSnippet());
  }
  
  /**
   * This returns the command as a string.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - The string of the command to be sent.
   */
  public function getCommand() {    
    if($this->_authentication_snippet !== '' && $this->_command_snippet !== '') {
      return '{' . $this->_authentication_snippet . ',' . $this->_command_snippet . '}';
    }
    return '';
  }
  
  /**
   * This sends the message to the remote gateway and returns the response.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - String containing the response from the server.
   */
  public function sendCommand() {
    $output = '';
    $data = '';
    
    $data = $this->getCommand();
    
    if($data !== '') {
      try {
        $http = new \HttpRequest(NODEJS_SERVER, \HttpRequest::METH_POST);
        $http->setContentType('application/json');
        $http->setBody($data);
        $http->send();
        $output = $http->getResponseBody();
        $responseCode = $http->getResponseCode();
      } catch (\HttpInvalidParamException $ex) {
        if (isset($ex->innerException)){
          $output = $ex->innerException->getMessage();
        } else {
          $output = $ex->getMessage();
        }
        $output = $this->formatError($output);
      } catch (\Exception $ex) {
        if (isset($ex->innerException)){
          $output = $ex->innerException->getMessage();
        } else {
          $output = $ex->getMessage();
        }
        $output = $this->formatError($output);
      }
    }
    return $output;
  }
  
  /**
   * This formats the error for a non-JSON return into a JSON format.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $message
   *   - String containing the error text
   * @return string
   *  - String containing the JSON error message.
   */
  private function formatError($message) {
    $output = "{\"authentication\":{\"token\":\"\"},\"result\":{\"status\":\"" . MESSAGE_RESULT_ERROR . "\",\"";
    $output .= "\"explanation\":\"" . $message . "\"";
    $output .= "\"},\"" . $this->_command_name . "\":{}}";
    return $output;
  }
  
  /**
   * This grabs the command name which was set.
   * @author Damien Whaley <damien@whalebonestudios.com>
   */
  public function getCommandName() {
    return $this->_command_name;
  }
}