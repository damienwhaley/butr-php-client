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

$document_root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once($document_root . '/includes/settings.inc');

/**
  * Page class.
  */
class Page {
  
  /**
   * Array containing all the css files to be loaded.
   * @var array
   */
  private $_css;
  
  /**
  * Array containing all the js files to be loaded.
  * @var array
  */
  private $_js;
  
  /**
   * String containing the locale/language
   * @var string
   */
  private $_language_code;
  
  /**
   * Default constructor.
   * @param array $css
   *   - contains an array of the css files to load.
   * @param array $js
   *   - contains an array of the js files to load.
   */
  public function __construct() {
    $arg_count = func_num_args();
    
    $this->_css = array();
    $this->_js = array();
    $this->_language_code = '';
    
    // Add language code
    if ($arg_count > 2) {
      $this->setLanguageCode(func_get_arg(2));
    } else {
      $this->setLanguageCode(DEFAULT_LANGUAGE);
    }
    
    // Add CSS files
    if ($arg_count > 1) {
      $this->addCss(func_get_arg(1));
    }
    
    // Add JS files
    if ($arg_count > 0) {
      $this->addJs(func_get_arg(0));
    }
  }
  
  /**
   * This generates the top part of the page for every screen in the system.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $page_title
   *   - The title for the page.
   * @param array $js_includes
   *   - An array of strings indicating the additional javascript files to load.
   * @param array $css_includes
   *   - An array of strings indicating the additional css style files to load.
   * @param string $language_code
   *   - A string containing the language code for the page.
   */
  public function generateHtmlTop($page_title = 'Butr', $js_includes = NULL, $css_includes = NULL, $language_code = '') {
    if (is_null($page_title) || !isset($page_title)) {
      $page_title = '';
    }
    if ($page_title === '') {
      $page_title = 'Butr';
    } else {
      $page_title = $page_title . ' | Butr';
    }
    
    // Add CSS files
    if (is_array($css_includes)) {
      $this->addCss($css_includes);
    }
    
    // Add JS files
    if (is_array($js_includes)) {
      $this->addJs($js_includes);
    }
    
    // Set the language for the page
    if ($language_code !== '') {
      $this->setLanguageCode($language_code);
    } else {
      $this->setLanguageCode(DEFAULT_LANGUAGE);
    }
    
    $js_output = array("    <script src=\"js/contrib/jquery-1.7.2.min.js\"></script>\n",
      "    <script src=\"js/contrib/jquery-ui-1.8.19.custom.min.js\"></script>\n",
      "    <script src=\"js/contrib/jquery.history.js\"></script>\n",
      "    <script src=\"js/contrib/jquery.localisation.min.js\"></script>\n",
      "    <script src=\"js/contrib/modernizr-latest.js\"></script>\n",
      "    <script src=\"js/contrib/uuid.js\"></script>\n",
      "    <script src=\"js/contrib/crypto-sha256-hmac.js\"></script>\n",
      "    <script src=\"js/contrib/moment.min.js\"></script>\n",
      "    <script src=\"js/cookies.js\"></script>\n",
      "    <script src=\"js/history.js\"></script>\n");
    
    if (sizeof($this->_js) > 0) {
      $js_output = array_merge($js_output, $this->_js);
    }
    
    $css_output = array("    <link rel=\"stylesheet\" href=\"css/contrib/reset.css\" />\n");
    
    if (sizeof($this->_css) > 0) {
      $css_output = array_merge($css_output, $this->_css);
    }
    
    if ($this->getLanguageCode() !== '') {
      $language_output = array("    <script type=\"text/javascript\">\n",
        "      $.localise('js/locales/strings', {language: '" . $this->getLanguageCode() . "', loadBase: true});\n",
        "    </script>\n");
    } else {
      $language_output = array("    <script type=\"text/javascript\">\n",
        "      $.localise('js/locales/strings', {loadBase: true});\n",
        "    </script>\n");
    }
    
    $begin_output = array("<html>\n",
      "  <head>\n",
      "    <title>$page_title</title>\n",
      "    <!--[if !IE 7]>\n",
      "    <style type=\"text/css\">\n",
      "      #wrap {display:table;height:100%}\n",
      "    </style>\n",
      "    <![endif]-->\n");
    
    $end_output = array("  </head>\n",
      "  <body>\n",
      "    <div id=\"error\" style=\"{ display: none; }\"><div id=\"error_message\"></div><!-- /#error_message --></div><!-- /#error -->\n",
      "    <div id=\"notice\" style=\"{ display: none; }\"><div id=\"notice_message\"></div><!-- /#notice_message --></div><!-- /#notice -->\n",
      "    <div id=\"debug\" style=\"{ display: none; }\"><div id=\"debug_message\"></div><!-- /#debug_message --></div><!-- /#debug -->\n");
    
    echo "<!DOCTYPE html>\n";
    
    // i18n Settings
    putenv('LANG='.str_replace('-', '_', $this->getLanguageCode()).'.UTF-8');
    setlocale(LC_ALL, str_replace('-', '_', $this->getLanguageCode()).'.UTF-8');
    $domain = 'messages';
    bindtextdomain($domain, realpath($_SERVER["DOCUMENT_ROOT"]) . '/locale');
    textdomain($domain);
    
    // Begin output buffering.
    ob_start();
    
    echo implode('', $begin_output);
    echo implode('', $js_output);
    echo implode('', $css_output);
    echo implode('', $language_output);
    echo implode('', $end_output);
  }
  
  /**
   * This generates the bottom of the page and flushes the buffer.
   * @author Damien Whaley <damien@whalebonestudios.com>
   */
  public function generateHtmlBottom() {
    $output = "\n  </body>\n</html>";
    
    echo $output;
    
    // End output buffering and flush output.
    ob_end_flush();
  }
  
  /**
   * This adds the CSS files to the array of files which need to be loaded.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param array $css_includes
   *   - array containing the names of the files to be added.
   */
  private function addCss($css_includes) {
    if (is_array($css_includes)) {
      for ($i = 0; $i < sizeof($css_includes); $i++) {
        if (trim($css_includes[$i]) !== '') {
          array_push($this->_css, "    <link rel=\"stylesheet\" href=\"css/" . trim($css_includes[$i]) . "\" />\n");
        }
      }
    }
  }
  
 /**
  * This adds the Javascript files to the array of files which need to be loaded.
  * @author Damien Whaley <damien@whalebonestudios.com>
  * @param array $jss_includes
  *   - array containing the names of the files to be added.
  */
  private function addJs($js_includes) {
    if (is_array($js_includes)) {
      for ($i = 0; $i < sizeof($js_includes); $i++) {
        if (trim($js_includes[$i]) !== '') {
          array_push($this->_js, "    <script src=\"js/" . trim($js_includes[$i]) . "\"></script>\n");
        }
      }
    }
  }
  
 /**
  * This sets the language code for the page which is used for i18n.
  * @author Damien Whaley <damien@whalebonestudios.com>
  * @param string $language_code
  *   - string containing the language code.
  */
  private function setLanguageCode($language_code) {
    if (isset($language_code)) {
      $this->_language_code = $language_code;
    }
  }
  
  /**
   * This grabs the language code of the pagewhich is used for i18n.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   */
  private function getLanguageCode() {
    return $this->_language_code;
  }
  
  /**
   * This sets the session cookie for the given session token for life of the
   * window/browser being open. The actual session is managed by the server
   * and this is just a pointer to the session for the given tab.
   * @author Damien Whaley <damien@whalebonestudios.com>
   *   - String containing the name of the window (used to allow multiple windows
   *     each with different sessions).
   * @param string $session_token
   *   - String containing the UUID session token.
   */
  public function addSessionCookie($window_name, $session_token) {
    setcookie('Butr|'.$window_name, $session_token, 0, '/');
  }
  
  /**
   * This removes the session cookie and should boot you out of the system.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $window_name
   *   - String containing the name of the window (used to allow multiple windows
   *     each with different sessions).
   */
  public function removeSessionCookie($window_name) {
    setcookie('Butr|'.$window_name, '', -1);
  }
  
  /**
   * This fetches the session cookie.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $window_name
   *   - String containing the name of the window (used to allow multiple windows
   *     each with different sessions).
   */
  public function fetchSessionCookie($window_name) {
    if (isset($_COOKIE['Butr|'.$window_name])) {
      return $_COOKIE['Butr|'.$window_name];
    }
    return '';
  }
}
