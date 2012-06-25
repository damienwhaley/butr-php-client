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
  * PageFragment class.
  */
class PageFragment {
  
  /**
   * Array containing the additional css files to be loaded.
   * @var array
   */
  private $_css;
  
  /**
  * Array containing the additional js files to be loaded.
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
   * @param array $js_includes
   *   - An array of strings indicating the additional javascript files to load.
   * @param array $css_includes
   *   - An array of strings indicating the additional css style files to load.
   * @param string $language_code
   *   - A string containing the language code for the page.
   */
  public function generateHtmlTop($js_includes = NULL, $css_includes = NULL, $language_code = '') {
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
    
    $js_output = array();
    
    if (sizeof($this->_js) > 0) {
      $js_output = array_merge($js_output, $this->_js);
    }
    
    $css_output = array();
    
    if (sizeof($this->_css) > 0) {
      $css_output = array_merge($css_output, $this->_css);
    }
    
    // i18n Settings
    putenv('LANG='.str_replace('-', '_', $this->getLanguageCode()).'.UTF-8');
    setlocale(LC_ALL, str_replace('-', '_', $this->getLanguageCode()).'.UTF-8');
    $domain = 'messages';
    bindtextdomain($domain, realpath($_SERVER["DOCUMENT_ROOT"]) . '/locale');
    textdomain($domain);
    
    // Begin output buffering.
    ob_start();
    
    echo implode('', $js_output);
    echo implode('', $css_output);
  }
  
  /**
   * This generates the bottom of the page and flushes the buffer.
   */
  public function generateHtmlBottom() {
    // End output buffering and flush output.
    ob_end_flush();
  }
  
  /**
   * This adds the CSS files to the array of files which need to be loaded.
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
}
