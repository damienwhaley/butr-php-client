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
require_once($document_root . '/includes/constants.inc');
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
    
    $this->resetAll();
    
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
  public function generateHtmlTop($js_includes = NULL, $css_includes = NULL,
    $language_code = '') {
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
    
    $js_output = array("    <script type=\"text/javascript\" src=\"js/script.js\"></script>\n");
    
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
    
    $output = array("      <div class=\"container-fluid\">\n",
			"        <div id=\"content\" class=\"row-fluid\">\n",
      "          <article id=\"main\" class=\"span8\">\n",
      "            <div class=\"alert alert-success hide\" id=\"success_alert\">\n",
      "              <button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>\n",
      "              <p id=\"alert-success-text\">&nbsp;</p>\n",
      "            </div><!-- end .alert -->\n",
      "            <div class=\"alert alert-warning hide\" id=\"warning_alert\">\n",
      "              <button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>\n",
      "              <p id=\"alert-warning-text\">&nbsp;</p>\n",
      "            </div><!-- end .alert -->\n",
      "            <div class=\"alert alert-info hide\" id=\"info_alert\">\n",
      "              <button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>\n",
      "              <p id=\"alert-info-text\">&nbsp;</p>\n",
      "            </div><!-- end .alert -->\n",
      "            <div class=\"alert alert-block alert-error hide\" id=\"error_alert\">\n",
      "              <button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>\n",
      "              <h4 class=\"alert-heading\" id=\"alert-error-title\">",
      gettext('Oops!'),
      "</h4>\n",
      "              <p id=\"alert-error-text\">&nbsp;</p>\n",
      "              <p>\n",
      "                <a class=\"btn btn-danger\" href=\"javascript:void(0);\">Take this action</a>\n",
      "                <a class=\"btn\" href=\"javascript:void(0);\">Or do this</a>\n",
      "              </p>\n",
      "            </div><!-- end .alert -->\n");
    
    // Begin output buffering.
    ob_start();
    
    echo implode('', $js_output);
    echo implode('', $css_output);
    echo implode('', $output);
  }
  
  /**
   * This generates the bottom of the page and flushes the buffer.
   */
  public function generateHtmlBottom() {
    
    // i18n Settings
    putenv('LANG='.str_replace('-', '_', $this->getLanguageCode()).'.UTF-8');
    setlocale(LC_ALL, str_replace('-', '_', $this->getLanguageCode()).'.UTF-8');
    $domain = 'messages';
    bindtextdomain($domain, realpath($_SERVER["DOCUMENT_ROOT"]) . '/locale');
    textdomain($domain);
    
    $output = array("          </article><!-- end #main -->\n",
      "          <aside id=\"notifications\" class=\"span1\">\n",
      "          <ul>\n",
      "            <li>\n",
      "              <a href=\"javascript:void(0);\" class=\"help-trigger\">\n",
      "                <img src=\"img/40x40.gif\" alt=\"",
      gettext('Help'),
      "\" title=\"",
      gettext('Help'),  
      "\" width=\"40\" height=\"40\">\n",
      "                <span>",
      gettext('Help'),
      "</span>\n",
      "              </a>\n",
      "            </li>\n",
      "            <li>\n",
      "              <a href=\"javascript:void(0);\" class=\"popover-enabled\" data-content=\"",
      gettext('No new notifications'),
      "\" title=\"",
      gettext('Notifications'),
      "\">\n",
      "                <div class=\"icon\">\n",
      "                  <span class=\"badge badge-important\" id=\"notification-count\">0</span>\n",
      "                    <img src=\"img/40x40.gif\" alt=\"",
      gettext('Notifications'),
      "\" width=\"40\" height=\"40\">\n",
      "                </div>\n",
      "                <span>",
      gettext('Notifications'),
      "</span>\n",
      "              </a>\n",
      "            </li>\n",
      "            <li>\n",
      "              <a href=\"javascript:void(0);\" class=\"popover-enabled\" id=\"recent-activity\"",
      " data-content=\"<ul class='recent-activity-list'>",
      "<a href='' class='btn right'>See All</a></ul>\" title=\"",
      gettext('Recent Activity'),
      "\">\n",
      "                <img src=\"img/40x40.gif\" alt=\"",
      gettext('Recent Activity'),
      "\" width=\"40\" height=\"40\">\n",
      "                <span>",
      gettext('Recent Activity'),
      "</span>\n",
      "              </a>\n",
      "            </li>\n",
      "          </ul>\n",
      "        </aside><!-- end #notifications -->\n",
      "        <div class=\"help-container\">\n",
      "          <ul class=\"help-actions\">\n",
      "            <li>\n",
      "              <a href=\"javascript:void(0);\" class=\"show-search left\"",
      "><i class=\"icon-search\"></i></a>\n",
      "            </li>\n",
      "            <li><a href=\"javascript:void(0);\" class=\"left\"",
      "><i class=\"icon-chevron-left\"></i></a></li>\n",
      "            <li><a href=\"javascript:void(0);\" class=\"left\"",
      "><i class=\"icon-chevron-right\"></i></a></li>\n",
      "            <li><a href=\"javascript:void(0);\" class=\"left closer\"",
      "><i class=\"icon-remove\"></i></a></li>\n",
      "          </ul><!-- end #help-actions -->\n",
      "          <div id=\"search-box\">\n",
      "            <form class=\"form-inline\">\n",
      "              <div class=\"input-prepend right\">\n",
      "                <span class=\"add-on\"><i class=\"icon-search\"></i></span>",
      "<input id=\"prependedInput\" type=\"text\" name=\"\" value=\"\" placeholder=\"",
      gettext('start typing to search'),  
      "\">\n",
      "              </div>\n",
      "            </form>\n",
      "          </div><!-- end #search-box -->\n",
      "          <h3>Help</h3>\n",
      "          <div class=\"inner\">\n",
      "            </div><!-- end .inner -->\n",
      "          </div><!-- end .help-container -->\n",
      "        </div><!-- end #content -->\n",
      "      </div><!-- end .container-fluid -->\n");

    echo implode('', $output);
    
    // End output buffering and flush output.
    ob_end_flush();
  }
  
  /**
   * This adds the CSS files to the array of files which need to be loaded.
   * @param array $css_includes
   *   - array containing the names of the files to be added.
   */
  public function addCss($css_includes) {
    if (is_array($css_includes)) {
      for ($i = 0; $i < sizeof($css_includes); $i++) {
        if (trim($css_includes[$i]) !== '') {
          array_push($this->_css, "    <link rel=\"stylesheet\" href=\"css/"
            . trim($css_includes[$i]) . "\" />\n");
        }
      }
    }
  }
  
  /**
   * This returns the array of css files to be loaded.
   * @return array
   *   - Array containing the css files to be loaded.
   */
  public function getCss() {
    return $this->_css;
  }
  
  /**
   * This adds the Javascript files to the array of files which need to be loaded.
   * @param array $jss_includes
   *   - array containing the names of the files to be added.
   */
  public function addJs($js_includes) {
    if (is_array($js_includes)) {
      for ($i = 0; $i < sizeof($js_includes); $i++) {
        if (trim($js_includes[$i]) !== '') {
          array_push($this->_js, "    <script type=\"text/javascript\" src=\"js/"
            . trim($js_includes[$i]) . "\"></script>\n");
        }
      }
    }
  }
  
  /**
   * This returns the array of js files to be loaded.
   * @return array
   *   - Array containing the js files to be loaded.
   */
  public function getJs() {
    return $this->_js;
  }
  
  /**
   * This sets the language code for the page which is used for i18n.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $language_code
   *   - string containing the language code.
   */
  public function setLanguageCode($language_code) {
    if (isset($language_code) && $language_code !== '') {
      $this->_language_code = $language_code;
    } else {
      $this->_language_code = DEFAULT_LANGUAGE;
    }
  }
  
  /**
   * This grabs the language code of the pagewhich is used for i18n.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   */
  public function getLanguageCode() {
    return $this->_language_code;
  }
  
  /**
   * This resets all the values back to the defaults.
   * @author Damien Whaley <damien@whalebonestudios.com>
   */
  public function resetAll() {
    $this->_css = array();
    $this->_js = array();
    $this->_language_code = DEFAULT_LANGUAGE;
  }
  
  /**
   * This sets all the parameters for the class in one shot.
   * @param array $js
   *   - The array of js files to be loaded.
   * @param array $css
   *   - The array of css files to be loaded.
   * @param string $language_code
   *   - The langage_code to display the page in the given language/locale.
   */
  public function setAll($js, $css, $language_code) {
    $this->addJs($js);
    $this->addCss($css);
    $this->setLanguageCode($language_code);
  }
}
