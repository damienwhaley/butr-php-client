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
  * PageNavigation class.
  */
class PageNavigation {
  
  /**
   * String containing the company name.
   * @var string
   */
  private $_company_name;
  
  /**
   * String containing the company logo location
   * @var string
   */
  private $_company_picture_path;
  
  /**
   * String containing the user's first name
   * @var string
   */
  private $_user_first_name;
  
  /**
   * String containing the locale/language
   * @var string
   */
  private $_language_code;
  
  /**
   * Default constructor.
   */
  public function __construct() {
    $this->resetAll();
  }
  
  /**
   * Sets the company name for display as alt text.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $company_name
   *   - The company name for display as alt text.
   */
  public function setCompanyName($company_name) {
    if (isset($company_name)) {
      $this->_company_name = htmlspecialchars($company_name, ENT_COMPAT | ENT_HTML5, 'UTF-8');
    } else {
      $this->_company_name = '';
    }
  }
  
  /**
   * Gets the company name for for display as alt text.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - The company name for display as alt text.
   */
  public function getCompanyName() {
    return $this->_company_name;
  }
  
  /**
   * Sets the company picture path for display as an icon.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $company_picture_path
   *   - The company picture path for display as an icon.
   */
  public function setCompanyPicturePath($company_picture_path) {
    if (isset($company_picture_path)) {
      $this->_company_picture_path = htmlspecialchars($company_picture_path, ENT_COMPAT | ENT_HTML5, 'UTF-8');
    } else {
      $this->_company_picture_path = '';
    }
  }
  
  /**
   * Gets the company picture path for display as an icon.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - The company picture path for display as an icon.
   */
  public function getCompanyPicturePath() {
    return $this->_company_picture_path;
  }
  
  /**
   * Sets the user first name for the welcome text display.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $user_first_name
   *   - The user first name for the welcome text display.
   */
  public function setUserFirstName($user_first_name) {
    // i18n Settings
    putenv('LANG='.str_replace('-', '_', $this->getLanguageCode()).'.UTF-8');
    setlocale(LC_ALL, str_replace('-', '_', $this->getLanguageCode()).'.UTF-8');
    $domain = 'messages';
    bindtextdomain($domain, realpath($_SERVER["DOCUMENT_ROOT"]) . '/locale');
    textdomain($domain);
    
    if (isset($user_first_name) && $user_first_name !== '') {
      $this->_user_first_name = htmlspecialchars($user_first_name, ENT_COMPAT | ENT_HTML5, 'UTF-8');
    } else {
      $this->_user_first_name = gettext('Back');
    }
  }
  
  /**
   * Gets the user first name for the welcome text display.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - The user first name for the welcome text display.
   */
  public function getUserFirstName() {
    return $this->_user_first_name;
  }
   
  /**
   * This resets all the values back to the defaults.
   * @author Damien Whaley <damien@whalebonestudios.com>
   */
  public function resetAll() {
    // i18n Settings
    putenv('LANG='.str_replace('-', '_', $this->getLanguageCode()).'.UTF-8');
    setlocale(LC_ALL, str_replace('-', '_', $this->getLanguageCode()).'.UTF-8');
    $domain = 'messages';
    bindtextdomain($domain, realpath($_SERVER["DOCUMENT_ROOT"]) . '/locale');
    textdomain($domain);
    
    $this->_company_name = '';
    $this->_company_picture_path = '';
    $this->_user_first_name = gettext('Back');
    $this->_language_code = DEFAULT_LANGUAGE;
  }
  
  /**
   * This generates the nav element for the main page in the system.
   * @author Damien Whaley <damien@whalebonestudios.com>
   */
  public function generateHtml() {
    // i18n Settings
    putenv('LANG='.str_replace('-', '_', $this->getLanguageCode()).'.UTF-8');
    setlocale(LC_ALL, str_replace('-', '_', $this->getLanguageCode()).'.UTF-8');
    $domain = 'messages';
    bindtextdomain($domain, realpath($_SERVER["DOCUMENT_ROOT"]) . '/locale');
    textdomain($domain);
    
    $company_logo = '';
    if ($this->getCompanyPicturePath() != '' && $this->getCompanyPicturePath() != '') {
      $company_logo = "<a href=\"javascript:void(0);\">"
        . "<img src=\"" . $this->getCompanyPicturePath() . "\" alt=\""
        . $this->getCompanyName() . "\" title=\"" . $this->getCompanyPicturePath()
        . "\"></a>";
    }
    else {
      $company_logo = "<a href=\"javascript:void(0);\">"
        . $this->getCompanyName() . "</a>";
    }
    
    // @todo When the logo is created replace this with an <img> tag.
    $butr_logo = 'Butr';
    
    $output = array("      <nav class=\"navbar\">\n",
			"        <div class=\"navbar-inner\">\n",
			"          <div class=\"row-fluid\">\n",
			"            <div class=\"span4\">\n",
			"              <h3>",
      $company_logo,  
      "</h3>\n",
			"            </div><!-- end .span4 -->\n",
			"            <div id=\"utilities\" class=\"span8\">\n",
			"              <div class=\"right\">\n",
			"                <div class=\"left\">\n",
			"                  <p>",
      gettext('Welcome'),
      " ",
      $this->getUserFirstName(),  
      "</p>\n",
			"                </div><!-- end .left -->\n",
			"                <ul id=\"toolbar\" class=\"left\">\n",
			"                  <li class=\"undo dropdown\">\n",
			"                    <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" title=\"",
      gettext('Undo'),  
      "\">\n",
			"                    </a>\n",
			"                    <ul class=\"dropdown-menu\" id=\"undo-menu\">\n",
			"                      <li><a href=\"javascript:void(0);\">",
      gettext('Nothing to undo'),  
      "</a></li>\n",
      "                    </ul>\n",
			"                  </li>\n",
			"                  <li class=\"redo dropdown\">\n",
			"                    <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" title=\"",
      gettext('Redo'),  
      "\">\n",			
			"                    </a>\n",
			"                    <ul class=\"dropdown-menu\" id=\"redo-menu\">\n",
			"                      <li><a href=\"javascript:void(0);\">",
      gettext('Nothing to redo'),  
      "</a></li>\n",
			"                    </ul>\n",
			"                  </li>\n",
			"                  <li class=\"help dropdown\">\n",
      "                    <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" title=\"",
      gettext('Help'),
      "\">\n",
      "                    </a></li>\n",
			"                  <li class=\"settings dropdown\">\n",
      "                    <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" title=\"",
      gettext('Settings'),  
      "\">\n",
      "                    </a>\n",
      "                    <ul class=\"dropdown-menu\">\n",
      "                      <li class=\"divider\"></li>\n",
      "                      <li><a href=\"javascript:logOut();\">",
      gettext('Log Out'),
      "</a></li>\n",
      "                    </ul>\n",
      "                  </li>\n",
			"                </ul><!-- end #toolbar -->\n",
			"                <div id=\"butr-logo\" class=\"left\">\n",
			"                  <a href=\"http://www.butr.org\" target=\"_blank\">",
      $butr_logo,
      "</a>\n",
			"                </div><!-- end #butr-logo -->\n",
			"              </div><!-- end .right -->\n",
			"            </div><!-- end #utilities -->\n",
			"          </div><!-- end .row-fluid -->\n",
			"        </div><!-- end .navbar-inner -->\n",
			"      </nav><!-- end .navbar -->\n");
    
    echo implode('', $output);
  }
  
  /**
   * This sets all the parameters for the class in one shot.
   * @param string $company_name
   *   - The name of the company.
   * @param string $company_picture_path
   *   - The URL containing the company logo.
   * @param string $user_first_name
   *   - The first name of the user.
   * @param string $language_code
   *   - The langage_code to display the page in the given language/locale.
   */
  public function setAll($company_name, $company_picture_path, $user_first_name,
    $language_code) {
    $this->setCompanyName($company_name);
    $this->setCompanyPicturePath($company_picture_path);
    $this->setUserFirstName($user_first_name);
    $this->setLanguageCode($language_code);
  }
  
  /**
   * Sets the language code for display in the given language/locale.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $language_code
   *   - The language/locale to display the page in.
   */
  public function setLanguageCode($language_code) {
    if (isset($language_code) && $language_code !== '') {
      $this->_language_code = $language_code;
    } else {
      $this->_language_code = DEFAULT_LANGUAGE;
    }
  }
  
  /**
   * Gets the language code for display in the given language/locale.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - The language/locale to display the page in.
   */
  public function getLanguageCode() {
    return $this->_language_code;
  }
}
