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
  * PageWell class.
  */
class PageWell {
  
  /**
   * Array containing all the wells. This is a flat array structure with all
   * the wells.
   * @var array
   */
  private $_well;
  
  /**
   * String containing the language code for the display of the wells.
   * @var string
   */
  private $_language_code;
  
  /**
   * String containing the uuid of the record for the page.
   * @var string
   */
  private $_uuid;
  
  /**
   * Default constructor.
   * There are optional parameters here:
   * - Well array of objects containing wells for the given page.
   * - LanguageCode - string containing the locale for rendering the page in a given language.
   */
  public function __construct() {
    $this->resetAll();
    
    $arg_count = func_num_args();
    
    // Add uuid
    if ($arg_count > 2) {
    	$this->setUuid(func_get_arg(2));
    }
    
    // Add language code
    if ($arg_count > 1) {
      $this->setLanguageCode(func_get_arg(1));
    }
    
    // Add wells
    if ($arg_count > 0) {
      $this->buildWell(func_get_arg(1));
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
   * Sets the UUID for the record to be displayed.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $uuid
   *   - The UUID for the record to be displayed.
   */
  public function setUuid($uuid) {
  	if (isset($uuid) && uuidIsValid($uuid)) {
  		$this->_uuid = $uuid;
  	} else {
  		$this->_uuid = '';
  	}
  }
  
  /**
   * Sets the UUID for the record to be displayed.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - The UUID for the record to be displayed.
   */
  public function getUuid() {
  	return $this->_uuid;
  }
  
  /**
   * This takes the output from the ListUserDockTabs command and it stores it
   * in an internal structure which will be used to display parts of it.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param array $well
   *   - The array returned from the list_user_dock_tabs command.
   */
  function buildWell($well) {
  	if (is_array($well)) {
      for($i = 0; $i < sizeof($well); $i++) {
    		$html_id = 'well-' . (($i < 10) ? '0' . $i : $i);
    	
    		$this->_well[] = array(
    		  'name' => htmlspecialchars($well[$i]->tab_name, ENT_COMPAT | ENT_HTML5, 'UTF-8'),
    		  'display_name' => htmlspecialchars($well[$i]->display_name, ENT_COMPAT | ENT_HTML5, 'UTF-8'),
    		  'description' => htmlspecialchars($well[$i]->description, ENT_COMPAT | ENT_HTML5, 'UTF-8'),
    		  'picture_path' => htmlspecialchars($well[$i]->picture_path, ENT_COMPAT | ENT_HTML5, 'UTF-8'),
    		  'action' => htmlspecialchars($well[$i]->action, ENT_COMPAT | ENT_HTML5, 'UTF-8'),
    		  'html_id' => $html_id,
    		  'well_type' => htmlspecialchars($well[$i]->items[$j]->tab_magic, ENT_COMPAT | ENT_HTML5, 'UTF-8'),
    		  'subwells' => array(),
    		  'is_record_required' => htmlspecialchars($well[$i]->is_record_required, ENT_COMPAT | ENT_HTML5, 'UTF-8'),
    		);
    		
    		for($j = 0; $j < sizeof($tab[$i]->items); $j++) {
    		  $html_id = 'well-' . (($i < 10) ? '0' . $i : $i) . '-subwell-' . (($j < 10) ? '0' . $j : $j);
    		
    		  $this->_tab[$i]['subwells'][] =  array(
  		      'name' => htmlspecialchars($well[$i]->subtabs[$j]->subtab_name, ENT_COMPAT | ENT_HTML5, 'UTF-8'),
  		      'display_name' => htmlspecialchars($well[$i]->subtabs[$j]->display_name, ENT_COMPAT | ENT_HTML5, 'UTF-8'),
  		      'description' => htmlspecialchars($well[$i]->subtabs[$j]->description, ENT_COMPAT | ENT_HTML5, 'UTF-8'),
  		      'picture_path' => htmlspecialchars($well[$i]->subtabs[$j]->picture_path, ENT_COMPAT | ENT_HTML5, 'UTF-8'),
  		      'well_type' => htmlspecialchars($well[$i]->subtabs[$j]->item_magic, ENT_COMPAT | ENT_HTML5, 'UTF-8'),
  		      'action' => htmlspecialchars($well[$i]->subtabs[$j]->action, ENT_COMPAT | ENT_HTML5, 'UTF-8'),
  		      'html_id' => $html_id,
    		    'is_record_required' => htmlspecialchars($well[$i]->subtabs[$j]->is_record_required, ENT_COMPAT | ENT_HTML5, 'UTF-8'),
  		    );
  	    }
      }
  	}
  }  
  
  /**
   * This prints out the HTML for the page wells.
   * @author Damien Whaley <damien@whalebonestudios.com>
   */
  public function generateHtmlWell() {
    
    // i18n Settings
    putenv('LANG='.str_replace('-', '_', $this->getLanguageCode()).'.UTF-8');
    setlocale(LC_ALL, str_replace('-', '_', $this->getLanguageCode()).'.UTF-8');
    $domain = 'messages';
    bindtextdomain($domain, realpath($_SERVER["DOCUMENT_ROOT"]) . '/locale');
    textdomain($domain);
       
    // Begin output buffering.
    ob_start();
    
    echo $this->prepareWell();
    
    // End output buffering and flush output.
    ob_end_flush();
  }
  
  /**
   * This prepares the HTML snippet which represents the wells.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - String containing the HTML snippet for the tab.
   */
  protected function prepareWell() {
    
    // i18n Settings
    putenv('LANG='.str_replace('-', '_', $this->getLanguageCode()).'.UTF-8');
    setlocale(LC_ALL, str_replace('-', '_', $this->getLanguageCode()).'.UTF-8');
    $domain = 'messages';
    bindtextdomain($domain, realpath($_SERVER["DOCUMENT_ROOT"]) . '/locale');
    textdomain($domain);
    
    $output = array();
    
    if (isset($this->_well) && is_array($this->_well)) {
      for ($i = 0; $i < count($this->_well); $i++) {
        // Prepare wells
        $title = '';
        $alt_text = '';
        $action = '';
        
        if (isset($this->_well[$i]['display_label'])
          && $this->_well[$i]['display_label'] !== '') {
          $title = $this->_well[$i]['display_label'];
        } else if (isset($this->_well[$i]['name'])
          && $this->_well[$i]['name'] !== '') {
          $title = $this->_well[$i]['name'];
        }
        
        if (isset($this->_well[$i]['description'])
          && $this->_well[$i]['description'] !== '') {
          $alt_text = $title . " - " . $this->_well[$i]['description'];
        } else {
          $alt_text = $title;
        }
        
        if (isset($this->_well[$i]['tab_type'])
            && $this->_well[$i]['tab_type'] === 'subtab_parent') {
          $action = "javascript:wellToggle('" . $this->_well[$i]['html_id'] . "');";
        } else {
          if (strpos($this->_well[$i]['action'], 'javascript:', 0) !== false) {
            $action = $this->_well[$i]['action'];
          } else {
            $action = "javascript:insertPageFragmentWell('"
            . $this->_well[$i]['action'];

            if ($this->_well[$i]['action'] !== '') {
              $action .= '&uuid=' . $this->getUuid();
            }
            else {
              $action .= '?uuid=' . $this->getUuid();
            }
            
            $action .= "', '"
            . $this->_well[$i]['html_id'] . "', false, true, '"
            . $this->_well[$i]['is_record_required']
            . "');";
          }
        }
        
        if (isset($this->_tab[$i]['tab_type'])
          && $this->_tab[$i]['tab_type'] === 'subtab_parent') {
          // Do nothing - don't render these.
        } else {
          $output[] = "            <div class=\"well\" id=\"";
          $output[] = $this->_well[$i]['html_id'];
          $output[] = "\">\n";
          $output[] = "              <h4 class=\"left\">";
          $output[] = $title;
          $output[] = "</h4>\n";          
          $output[] = "              <a onclick=\"";
          $output[] = $action;
          $output[] = "\" href=\"javascript:void(0);\" class=\"right show\">";
          $output[] = gettext('Show / Hide');
          $output[] = "</a>\n";
          $output[] = "              <div class=\"inner\" id=\"";
          $output[] = $this->_well[$i]['html_id'];
          $output[] = "-inner\">\n";
          $output[] = "              </div><!-- end .inner -->\n";
          $output[] = "            </div><!-- end .well -->\n";
        }
        
        if (isset($this->_well[$i]['subtabs']) && is_array($this->_well[$i]['subtabs'])) {
          
          for($j = 0; $j < count($this->_well[$i]['subtabs']); $j++) {
          
            // Prepare subwells
            $subtab_title = '';
            $subtab_alt_text = '';
            $subtab_action = '';
            
            if (isset($this->_well[$i]['subtabs'][$j]['display_label'])
                && $this->_well[$i]['subtabs'][$j]['display_label'] !== '') {
              $subtab_title = $this->_tab[$i]['subtabs'][$j]['display_label'];
            } else if (isset($this->_tab[$i]['subtabs'][$j]['name'])
                && $this->_well[$i]['subtabs'][$j]['name'] !== '') {
              $subtab_title = $this->_tab[$i]['subtabs'][$j]['name'];
            }
            
            if (isset($this->_well[$i]['subtabs'][$j]['description'])
                && $this->_well[$i]['subtabs'][$j]['description'] !== '') {
              $subtab_alt_text = $title . " - " . $this->_well[$i]['subtabs'][$j]['description'];
            } else {
              $subtab_alt_text = $title;
            }
            
            if (isset($this->_well[$i]['subtabs'][$j]['tab_type'])
              && $this->_well[$i]['subtabs'][$j]['tab_type'] === 'subtab_parent') {
              $subtab_action = "javascript:wellToggle('"
                . $this->_well[$i]['subtabs'][$j]['html_id'] . "');";
            } else {
              if (strpos($this->_well[$i]['subtabs'][$j]['action'], 'javascript:', 0) !== false) {
                $subtab_action = $this->_tab[$i]['subtabs'][$j]['action'];
              } else {
                $subtab_action = "javascript:insertPageFragmentWell('"
                . $this->_well[$i]['subtabs'][$j]['action'] . "', '"
                . $this->_well[$i]['subtabs'][$j]['html_id'] . "', false, true, '"
                . $this->_well[$i]['subtabs'][$j]['is_record_required']
                . "');";
              }
            }
            
            if (isset($this->_well[$i]['subtabs'][$j]['tab_type'])
              && $this->_well[$i]['subtabs'][$j]['tab_type'] === 'subtab_parent') {
              // Do nothing - don't render these.
            } else {
              $output[] = "            <div class=\"well\" id=\"";
              $output[] = $this->_well[$i]['subtabs'][$j]['html_id'];
              $output[] = "\">\n";
              $output[] = "              <h4 class=\"left\">";
              $output[] = $title;
              $output[] = "</h4>\n";          
              $output[] = "              <a onclick=\"";
              $output[] = $action;
              $output[] = "\" href=\"javascript:void(0);\" class=\"right show\">";
              $output[] = gettext('Show / Hide');
              $output[] = "</a>\n";
              $ouptut[] = "              <div class=\"inner\" id=\"";
              $output[] = $this->_well[$i]['subtabs'][$j]['html_id'];
              $output[] = "-inner\">\n";
              $output[] = "              </div><!-- end .inner -->\n";
              $output[] = "            </div><!-- end .well -->\n";
            }
          }
        }
      }
    }
        
    return implode('', $output);
  }
  
  /**
   * This resets all the values back to the defaults.
   * @author Damien Whaley <damien@whalebonestudios.com>
   */
  public function resetAll() {
    $this->_well = array();
    $this->_language_code = DEFAULT_LANGUAGE;
  }
  
  /**
   * This sets all the parameters for the class in one shot.
   * @param array $well
   *   - Array of objects containing the tabs and tab items to be loaded.
   * @param string $language_code
   *   - The langage_code to display the page in the given language/locale.
   * @param string $uuid
   *   - The UUID for the record to be displayed.
   */
  public function setAll($well, $language_code, $uuid) {
    $this->buildWell($well);
    $this->setLanguageCode($language_code);
    $this->setUuid($uuid);
  }
}
