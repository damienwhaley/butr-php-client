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
  * PageTab class.
  */
class PageTab {
  
  /**
   * Array containing all the tab items. This is a flat array structure with all
   * the tabs.
   * @var array
   */
  private $_tab;
  
  /**
   * String containing the language code for the display of the docks.
   * @var string
   */
  private $_language_code;
  
  /**
   * Default constructor.
   * There are optional parameters here:
   * - Tab array of objects containing tabs for the given page.
   * - LanguageCode - string containing the locale for rendering the page in a given language.
   */
  public function __construct() {
    $this->resetAll();
    
    $arg_count = func_num_args();
    
    // Add language code
    if ($arg_count > 1) {
      $this->setLanguageCode(func_get_arg(1));
    }
    
    // Add tabs
    if ($arg_count > 0) {
      $this->buildTab(func_get_arg(1));
    }
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
   * This takes the output from the ListUserDockTabs command and it stores it
   * in an internal structure which will be used to display parts of it.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param array $tab
   *   - The array returned from the list_user_dock_tabs command.
   */
  function buildTab($tab) {
  	if (is_array($tab)) {
      for($i = 0; $i < sizeof($tab); $i++) {
    		$html_id = 'tab-' . (($i < 10) ? '0' . $i : $i);
    	
    		$this->_tab[] = array(
    		  'name' => htmlspecialchars($tab[$i]->tab_name, ENT_COMPAT | ENT_HTML5, 'UTF-8'),
    		  'display_name' => htmlspecialchars($tab[$i]->display_name, ENT_COMPAT | ENT_HTML5, 'UTF-8'),
    		  'description' => htmlspecialchars($tab[$i]->description, ENT_COMPAT | ENT_HTML5, 'UTF-8'),
    		  'picture_path' => htmlspecialchars($tab[$i]->picture_path, ENT_COMPAT | ENT_HTML5, 'UTF-8'),
    		  'action' => htmlspecialchars($tab[$i]->action, ENT_COMPAT | ENT_HTML5, 'UTF-8'),
    		  'html_id' => $html_id,
    		  'tab_type' => htmlspecialchars($dock[$i]->items[$j]->tab_magic, ENT_COMPAT | ENT_HTML5, 'UTF-8'),
    		  'subtabs' => array(),
    		);
    		
    		for($j = 0; $j < sizeof($tab[$i]->items); $j++) {
    		  $html_id = 'tab-' . (($i < 10) ? '0' . $i : $i) . '-subtab-' . (($j < 10) ? '0' . $j : $j);
    		
    		  $this->_tab[$i]['subtabs'][] =  array(
  		      'name' => htmlspecialchars($tab[$i]->subtabs[$j]->subtab_name, ENT_COMPAT | ENT_HTML5, 'UTF-8'),
  		      'display_name' => htmlspecialchars($tab[$i]->subtabs[$j]->display_name, ENT_COMPAT | ENT_HTML5, 'UTF-8'),
  		      'description' => htmlspecialchars($tab[$i]->subtabs[$j]->description, ENT_COMPAT | ENT_HTML5, 'UTF-8'),
  		      'picture_path' => htmlspecialchars($tab[$i]->subtabs[$j]->picture_path, ENT_COMPAT | ENT_HTML5, 'UTF-8'),
  		      'tab_type' => htmlspecialchars($tab[$i]->subtabs[$j]->item_magic, ENT_COMPAT | ENT_HTML5, 'UTF-8'),
  		      'action' => htmlspecialchars($tab[$i]->subtabs[$j]->action, ENT_COMPAT | ENT_HTML5, 'UTF-8'),
  		      'html_id' => $html_id,
  		    );
  	    }
      }
  	}
  }  
  
  /**
   * This prints out the HTML for the dock header section.
   * @author Damien Whaley <damien@whalebonestudios.com>
   */
  public function generateHtmlTab() {
    
    // i18n Settings
    putenv('LANG='.str_replace('-', '_', $this->getLanguageCode()).'.UTF-8');
    setlocale(LC_ALL, str_replace('-', '_', $this->getLanguageCode()).'.UTF-8');
    $domain = 'messages';
    bindtextdomain($domain, realpath($_SERVER["DOCUMENT_ROOT"]) . '/locale');
    textdomain($domain);
    
    $start_output = array("          <aside id=\"sidebar\" class=\"span3\">\n",
			"            <ul class=\"well nav nav-list\">\n",
      "              <li class=\"nav-header\">",
      gettext('Navigation'),
      "</li>\n");
							
    $end_output = array("            </ul>\n",
			"          </aside><!-- end #sidebar -->\n");
    
    // Begin output buffering.
    ob_start();
    
    echo implode('', $start_output);
    echo $this->prepareTab();
    echo implode('', $end_output);
    
    // End output buffering and flush output.
    ob_end_flush();
  }
  
  /**
   * This prepares the HTML snippet which represents the tabs,
   * and tab item items.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - String containing the HTML snippet for the tab.
   */
  protected function prepareTab() {
    $output = array();
    
    if (isset($this->_tab) && is_array($this->_tab)) {
      for ($i = 0; $i < count($this->_tab); $i++) {
        // Prepare dock tabs
        $title = '';
        $alt_text = '';
        $img = '';
        $action = '';
        
        if (isset($this->_tab[$i]['display_label'])
          && $this->_tab[$i]['display_label'] !== '') {
          $title = $this->_tab[$i]['display_label'];
        } else if (isset($this->_tab[$i]['name'])
          && $this->_tab[$i]['name'] !== '') {
          $title = $this->_tab[$i]['name'];
        }
        
        if (isset($this->_tab[$i]['description'])
          && $this->_tab[$i]['description'] !== '') {
          $alt_text = $title . " - " . $this->_tab[$i]['description'];
        } else {
          $alt_text = $title;
        }
        
        if (isset($this->_tab[$i]['picture_path'])
          && $this->_tab[$i]['picture_path'] !== '') {
          $img = $this->_tab[$i]['picture_path'];
        } else {
          $img = '';
        }
        
        if ($img !== '') {
          $img = "                  <i class=\"" . $item_img . "\"></i>\n";
        }
        
        if ($this->_tab[$i]['tab_type'] === 'subtab_parent') {
          $action = "javascript:void(0);";
        } else {
          if (strpos($this->_tab[$i]['action'], 'javascript:', 0) !== false) {
            $action = $this->_tab[$i]['action'];
          } else {
            $action = "javascript:insertContent('"
            . $this->_tab[$i]['action'] . "');";
          }
        }
        
        $output[] = "              <li";
        
        if (isset($this->_tab[$i]['tab_type'])
          && $this->_tab[$i]['tab_type'] === 'subtab_parent'
          && isset($this->_tab[$i]['subtabs']) && is_array($this->_tab[$i]['subtabs'])
          && count($this->_tab[$i]['subtabs']) > 0) {
          $output[] = " class=\"sub-nav\"";
        }
        
        $output[] = ">\n";
        $output[] = "                <a href=\"";
        $output[] = $action;
        $output[] = "\"";
        
        if (isset($this->_tab[$i]['tab_type'])
            && $this->_tab[$i]['tab_type'] === 'subtab_parent'
            && isset($this->_tab[$i]['subtabs']) && is_array($this->_tab[$i]['subtabs'])
            && count($this->_tab[$i]['subtabs']) > 0) {
          $output[] = " class=\"toggle\"";
        }
        
        $output[] = " title=\"";
        $output[] = $alt_text;
        $output[] = "\">\n";
        
        if ($img !== '') {
          $output[] = $img;
        }
        
        $output[] = "                  ";
        $output[] = $title;
        $output[] = "</a>\n";
        
        if (isset($this->_tab[$i]['subtabs']) && is_array($this->_tab[$i]['subtabs'])) {
          
          if (count($this->_tab[$i]['subtabs']) > 0) {
            $output[] = "                <ul>\n";
          }
          
          for($j = 0; $j < count($this->_tab[$i]['subtabs']); $j++) {
          
            // Prepare dock subtabs
            $subtab_title = '';
            $subtab_alt_text = '';
            $subtab_img = '';
            $subtab_action = '';
            
            if (isset($this->_tab[$i]['subtabs'][$j]['display_label'])
                && $this->_tab[$i]['subtabs'][$j]['display_label'] !== '') {
              $subtab_title = $this->_tab[$i]['subtabs'][$j]['display_label'];
            } else if (isset($this->_tab[$i]['subtabs'][$j]['name'])
                && $this->_tab[$i]['subtabs'][$j]['name'] !== '') {
              $subtab_title = $this->_tab[$i]['subtabs'][$j]['name'];
            }
            
            if (isset($this->_tab[$i]['subtabs'][$j]['description'])
                && $this->_tab[$i]['subtabs'][$j]['description'] !== '') {
              $subtab_alt_text = $title . " - " . $this->_tab[$i]['subtabs'][$j]['description'];
            } else {
              $subtab_alt_text = $title;
            }
            
            if (isset($this->_tab[$i]['subtabs'][$j]['picture_path'])
                && $this->_tab[$i]['subtabs'][$j]['picture_path'] !== '') {
              $subtab_img = $this->_tab[$i]['subtabs'][$j]['picture_path'];
            } else {
              $subtab_img = '';
            }
            
            if ($subtab_img !== '') {
              $subtab_img = "                      <i class=\"" . $item_img . "\"></i>\n";
            }
            
            if ($this->_tab[$i]['subtabs'][$j]['tab_type'] === 'subtab_parent') {
              $subtab_action = "javascript:void(0);";
            } else {
              if (strpos($this->_tab[$i]['subtabs'][$j]['action'], 'javascript:', 0) !== false) {
                $subtab_action = $this->_tab[$i]['subtabs'][$j]['action'];
              } else {
                $subtab_action = "javascript:insertContent('"
                . $this->_tab[$i]['subtabs'][$j]['action'] . "');";
              }
            }
            
            $output[] = "                <li>\n";
            $output[] = "                  <a href=\"";
            $output[] = $subtab_action;
            $output[] = "\" title=\"";
            $output[] = $subtab_alt_text;
            $output[] = "\">";
            $output[] = $subtab_title;
            $output[] = "</a>\n";
            $output[] = "                </li>\n";
          }

          if (count($this->_tab[$i]['subtabs']) > 0) {
            $output[] = "                </ul>\n";
          }
          
        }
        
        $output[] = "              </li>\n";
      }
    }
        
    return implode('', $output);
  }
  
  /**
   * This resets all the values back to the defaults.
   * @author Damien Whaley <damien@whalebonestudios.com>
   */
  public function resetAll() {
    $this->_tab = array();
    $this->_language_code = DEFAULT_LANGUAGE;
  }
  
  /**
   * This sets all the parameters for the class in one shot.
   * @param array $tab
   *   - Array of objects containing the tabs and tab items to be loaded.
   * @param string $language_code
   *   - The langage_code to display the page in the given language/locale.
   */
  public function setAll($tab, $language_code) {
    $this->buildTab($tab);
    $this->setLanguageCode($language_code);
  }
}
