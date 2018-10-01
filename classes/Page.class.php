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
   * There are optional parameters here:
   * - Javascript array of strings containing links to additional javascript files.
   * - Css array of strings containing links to additional css files.
   * - LanguageCode - string containing the locale for rendering the page in a given language.
   */
  public function __construct() {
    $this->resetAll();
    
    $arg_count = func_num_args();
    
    // Add language code
    if ($arg_count > 2) {
      $this->setLanguageCode(func_get_arg(2));
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
  public function generateHtmlTop($page_title = 'Butr', $js_includes = null,
    $css_includes = null, $language_code = '') {
    
    // i18n Settings
    putenv('LANG='.str_replace('-', '_', $this->getLanguageCode()).'.UTF-8');
    setlocale(LC_ALL, str_replace('-', '_', $this->getLanguageCode()).'.UTF-8');
    $domain = 'messages';
    bindtextdomain($domain, realpath($_SERVER["DOCUMENT_ROOT"]) . '/locale');
    textdomain($domain);
    
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
    
    $js_output = array("    <script type=\"text-javascript\" src=\"js/libs/jquery-ui.min.js\"></script>\n",
      "    <script type=\"text/javascript\" src=\"js/libs/jquery-1.7.1.min.js\"></script>\n",
      "    <script type=\"text/javascript\" src=\"js/libs/jquery-ui.min.js\"></script>\n",
      "    <script type=\"text/javascript\" src=\"js/libs/modernizr-2.5.3.min.js\"></script>\n",
      "    <script type=\"text/javascript\" src=\"js/libs/bootstrap.js\"></script>\n",
      "    <script type=\"text/javascript\" src=\"js/libs/bootstrap-popover.js\"></script>\n",
      "    <script type=\"text/javascript\" src=\"js/libs/bootstrap-tooltip.js\"></script>\n",
      "    <script type=\"text/javascript\" src=\"js/libs/bootstrap-dropdown.js\"></script>\n",
      "    <script type=\"text/javascript\" src=\"js/libs/bootstrap-modal.js\"></script>\n",
      "    <script type=\"text/javascript\" src=\"js/libs/bootstrap-scrollspy.js\"></script>\n",
      "    <script type=\"text/javascript\" src=\"js/libs/jquery.tablesorter.min.js\"></script>\n",
      "    <script type=\"text/javascript\" src=\"js/libs/jquery.scrollTo-1.4.2-min.js\"></script>\n",
      "    <script type=\"text/javascript\" src=\"js/libs/jquery.history.js\"></script>\n",
      "    <script type=\"text/javascript\" src=\"js/libs/jquery.localisation.min.js\"></script>\n",
      "    <script type=\"text/javascript\" src=\"js/script.js\"></script>\n",
      "    <script type=\"text/javascript\" src=\"js/helpers.js\"></script>\n",
      "    <script type=\"text/javascript\" src=\"js/libs/uuid.js\"></script>\n",
      "    <script type=\"text/javascript\" src=\"js/libs/crypto-sha256-hmac.js\"></script>\n",
      "    <script type=\"text/javascript\" src=\"js/libs/moment.min.js\"></script>\n",
      "    <script type=\"text/javascript\" src=\"js/cookies.js\"></script>\n",
      "    <script type=\"text/javascript\" src=\"js/history.js\"></script>\n",
      "    <script type=\"text/javascript\" src=\"js/tiny_mce/jquery.tinymce.js\"></script>\n",
      "    <script type=\"text/javascript\">\n",
      "      $().ready(function() {\n",
      "        'use strict';\n",
      "        $('textarea.tinymce').tinymce({\n",
      "          script_url : 'js/tiny_mce/tiny_mce.js',\n",
      "          theme : \"advanced\",\n",
      "          plugins : \"autolink,lists,pagebreak,style,layer,table,save,advhr,",
      "advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,",
      "searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,",
      "visualchars,nonbreaking,xhtmlxtras,template,advlist\",\n",
      "          theme_advanced_buttons1 : \"save,newdocument,|,bold,italic,underline,strikethrough,",
      "|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,",
      "fontsizeselect\",\n",
      "          theme_advanced_buttons2 : \"cut,copy,paste,pastetext,pasteword,|,search,replace,",
      "|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,",
      "cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor\",\n",
      "          theme_advanced_buttons3 : \"tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,",
      "|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen\",\n",
      "          theme_advanced_buttons4 : \"insertlayer,moveforward,movebackward,absolute,|",
      ",styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak\",\n",
      "          theme_advanced_toolbar_location : \"top\",\n",
      "          theme_advanced_toolbar_align : \"left\",\n",
      "          theme_advanced_statusbar_location : \"bottom\",\n",
      "          theme_advanced_resizing : true,\n",
      "          content_css : \"css/style.css\",\n",
      "          template_external_list_url : \"lists/template_list.js\",\n",
      "          external_link_list_url : \"lists/link_list.js\",\n",
      "          external_image_list_url : \"lists/image_list.js\",\n",
      "          media_external_list_url : \"lists/media_list.js\",\n",
      "        });\n",
      "      });\n",
      "    </script>\n");
    
    if (sizeof($this->_js) > 0) {
      $js_output = array_merge($js_output, $this->_js);
    }
    
    $css_output = array("    <link rel=\"stylesheet\" href=\"css/bootstrap.css\" type=\"text/css\">\n",
      "    <link rel=\"stylesheet\" href=\"css/style.css\" type=\"text/css\">\n",  
      "    <link rel=\"stylesheet\" href=\"http://fonts.googleapis.com",
      "/css?family=Open+Sans:400italic,400,700\" type=\"text/css\">\n");
    
    if (sizeof($this->_css) > 0) {
      $css_output = array_merge($css_output, $this->_css);
    }
    
    if ($this->getLanguageCode() !== '') {
      $language_output = array("    <script type=\"text/javascript\">\n",
        "      $.localise('js/locales/strings', {language: '",
        $this->getLanguageCode(),
        "', loadBase: true});\n",
        "    </script>\n");
    } else {
      $language_output = array("    <script type=\"text/javascript\">\n",
        "      $.localise('js/locales/strings', {loadBase: true});\n",
        "    </script>\n");
    }
    
    $begin_output = array("<!--[if lt IE 7]><html class=\"no-js lt-ie9 lt-ie8 lt-ie7\"",
      " lang=\"",
      $this->getLanguageCode(),
      "\"><![endif]-->\n",
	    "<!--[if IE 7]><html class=\"no-js lt-ie9 lt-ie8\"",
      " lang=\"",
      $this->getLanguageCode(),
      "\"><![endif]-->\n",
	    "<!--[if IE 8]><html class=\"no-js lt-ie9\"",
      " lang=\"",
      $this->getLanguageCode(),
      "\"><![endif]-->\n",
	    "<!--[if gt IE 8]><!--><html class=\"no-js\"",
      " lang=\"",
      $this->getLanguageCode(),
      "\"><!--<![endif]-->\n",
	    "  <head>\n",
      "    <title>",
      $page_title,
      "</title>\n",
		  "    <meta charset=\"utf-8\">\n",
		  "    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge,chrome=1\">\n");
       
    $end_output = array("  </head>\n",
      "  <body data-spy=\"scroll\">\n",
      "    <div class=\"modal hide\" id=\"error_modal\">\n",
      "      <div class=\"modal-header\">\n",
      "        <a class=\"close\"",
      " href=\"javascript:$('#error_modal').modal('hide');\">x</a>\n",
      "        <h2>",
      gettext('Error'),
      "</h2>\n",
      "        <p id=\"error_modal_message\">&nbsp;</p>\n",
      "        <p class=\"right\"><a href=\"javascript:$('#error_modal').modal('hide');\"",
      " class=\"btn btn-danger\"",
      " onclick=\"javascript:$('#error_modal').modal('hide');\">Close</a></p>\n",
      "        <div class=\"clearfix\"></div>\n",
      "      </div>\n",
      "    </div><!-- end .modal -->\n",
      "    <div class=\"modal hide\" id=\"warning_modal\">\n",
      "      <div class=\"modal-header\">\n",
      "        <a class=\"close\"",
      " href=\"javascript:$('#warning_modal').modal('hide');\">x</a>\n",
      "        <h2>",
      gettext('Warning'),
      "</h2>\n",
      "        <p id=\"warning_modal_message\">&nbsp;</p>\n",
      "        <p class=\"right\"><a href=\"javascript:void(0);\"",
      " class=\"btn btn-warning\"",
      " onclick=\"javascript:$('#warning_modal').modal('hide');\">Close</a></p>\n",
      "        <div class=\"clearfix\"></div>\n",
      "      </div>\n",
      "    </div><!-- end .modal -->\n",
      "    <div class=\"modal hide\" id=\"notice_modal\">\n",
      "      <div class=\"modal-header\">\n",
      "        <a class=\"close\"",
      " href=\"javascript:$('#notice_modal').modal('hide');\">x</a>\n",
      "        <h2>",
      gettext('Notice'),
      "</h2>\n",
      "        <p id=\"notice_modal_message\">&nbsp;</p>\n",
      "        <p class=\"right\"><a href=\"javascript:void(0);\"",
      " class=\"btn btn-info\"",
      " onclick=\"javascript:$('#notice_modal').modal('hide');\">Close</a></p>\n",
      "        <div class=\"clearfix\"></div>\n",
      "      </div>\n",
      "    </div><!-- end .modal -->\n",
      "    <div class=\"modal hide\" id=\"debug_modal\">\n",
      "      <div class=\"modal-header\">\n",
      "        <a class=\"close\"",
      " href=\"javascript:$('#debug_modal').modal('hide');\">x</a>\n",
      "        <h2>",
      gettext('Debug'),
      "</h2>\n",
      "        <p id=\"debug_modal_message\">&nbsp;</p>\n",
      "        <p class=\"right\"><a href=\"javascript:void(0);\"",
      " class=\"btn btn-inverse\"",
      " onclick=\"javascript:$('#debug_modal').modal('hide');\">Close</a></p>\n",
      "        <div class=\"clearfix\"></div>\n",
      "      </div>\n",
      "    </div><!-- end .modal -->\n");
    
    // Get this out early with no buffering.
    echo "<!doctype html>\n";
    
    // Begin output buffering.
    ob_start();
    
    echo implode('', $begin_output);
    echo implode('', $css_output);
    echo implode('', $js_output);
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
  public function addCss($css_includes) {
    if (is_array($css_includes)) {
      for ($i = 0; $i < sizeof($css_includes); $i++) {
        if (trim($css_includes[$i]) !== '') {
          array_push($this->_css, "    <link rel=\"stylesheet\" href=\"css/"
            . trim($css_includes[$i]) . "\" type=\"text/css\">\n");
        }
      }
    }
  }
  
  /**
   * This gets all the CSS files which are going to be loaded.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return array
   *    - Contains all the link tags with the CSS files.
   */
  public function getCss() {
    return $this->_css;
  }
  
  /**
   * This adds the Javascript files to the array of files which need to be loaded.
   * @author Damien Whaley <damien@whalebonestudios.com>
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
   * This gets all the Javascript files which are going to be loaded.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return array
   *   - Containing the script tags with the Javascript files to be loaded.
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
   * This grabs the language code of the page which is used for i18n.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   */
  public function getLanguageCode() {
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
   *   - Array of Javascript files to add to the page load.
   * @param array $css
   *   - Array of Cascading Style Sheets to add to the page load.
   * @param string $language_code
   *   - The langage_code to display the page in the given language/locale.
   */
  public function setAll($js, $css, $language_code) {
    $this->addJs($js);
    $this->addCss($css);
    $this->setLanguageCode($language_code);
  }
}
