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
  * PageDock class.
  */
class PageDock {
  
  /**
   * Array containing all the dock items. This contains the whole tree structure
   * of the docks, dock items and dock sub items.
   * @var array
   */
  private $_dock;
  
  /**
   * Array containing the module names and their magic terms.
   * @var array
   */
  private $_module;
  
  /**
   * String containing the language code for the display of the docks.
   * @var string
   */
  private $_language_code;
  
  /**
   * Default constructor.
   * There are optional parameters here:
   * - Dock array of objects containing the docks, dock items and dock subitems.
   * - LanguageCode - string containing the locale for rendering the page in a given language.
   */
  public function __construct() {
    $this->resetAll();
    
    $arg_count = func_num_args();
    
    // Add language code
    if ($arg_count > 2) {
      $this->buildModule(func_get_arg(2));
    }
    
    // Add language code
    if ($arg_count > 1) {
      $this->setLanguageCode(func_get_arg(1));
    }
    
    // Add docks
    if ($arg_count > 0) {
      $this->buildDock(func_get_arg(0));
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
   * This takes the output from the ListUserDocks command and it stores it
   * in an internal structure which will be used to display parts of it.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param array $dock
   *   - The array returned from the list_user_docks command.
   */
  public function buildDock($dock) {
    if (is_array($dock)) {
      for($i = 0; $i < sizeof($dock); $i++) {
        $html_id = 'dock-' . (($i < 10) ? '0' . $i : $i);
        
        $this->_dock[] = array(
          'name' => htmlspecialchars($dock[$i]->dock_name, ENT_COMPAT | ENT_HTML5, 'UTF-8'),
          'display_name' => htmlspecialchars($dock[$i]->display_name, ENT_COMPAT | ENT_HTML5, 'UTF-8'),
          'description' => htmlspecialchars($dock[$i]->description, ENT_COMPAT | ENT_HTML5, 'UTF-8'),
          'picture_path' => htmlspecialchars($dock[$i]->picture_path, ENT_COMPAT | ENT_HTML5, 'UTF-8'),
          'html_id' => $html_id,
          'items' => array(),
        );
    
        for($j = 0; $j < sizeof($dock[$i]->items); $j++) {
          $html_id = 'dock-' . (($i < 10) ? '0' . $i : $i) . '-item-' . (($j < 10) ? '0' . $j : $j);
                    
          $this->_dock[$i]['items'][] =  array(
            'name' => htmlspecialchars($dock[$i]->items[$j]->item_name, ENT_COMPAT | ENT_HTML5, 'UTF-8'),
            'display_name' => htmlspecialchars($dock[$i]->items[$j]->display_name, ENT_COMPAT | ENT_HTML5, 'UTF-8'),
            'description' => htmlspecialchars($dock[$i]->items[$j]->description, ENT_COMPAT | ENT_HTML5, 'UTF-8'),
            'picture_path' => htmlspecialchars($dock[$i]->items[$j]->picture_path, ENT_COMPAT | ENT_HTML5, 'UTF-8'),
            'item_type' => htmlspecialchars($dock[$i]->items[$j]->item_magic, ENT_COMPAT | ENT_HTML5, 'UTF-8'),
            'action' => htmlspecialchars($dock[$i]->items[$j]->action, ENT_COMPAT | ENT_HTML5, 'UTF-8'),
            'html_id' => $html_id,
            'subitems' => array(),
          );
          
          for($k = 0; $k < sizeof($dock[$i]->items[$j]->subitems); $k++) {
            $html_id = 'dock-' . (($i < 10) ? '0' . $i : $i) . '-item-' . (($j < 10) ? '0' . $j : $j) . '-subitem-' . (($k < 10) ? '0' . $k : $k);
            
            $this->_dock[$i]['items'][$j]['subitems'][] = array(
              'name' => htmlspecialchars($dock[$i]->items[$j]->subitems[$k]->subitem_name, ENT_COMPAT | ENT_HTML5, 'UTF-8'),
              'display_name' => htmlspecialchars($dock[$i]->items[$j]->subitems[$k]->display_name, ENT_COMPAT | ENT_HTML5, 'UTF-8'),
              'description' => htmlspecialchars($dock[$i]->items[$j]->subitems[$k]->description, ENT_COMPAT | ENT_HTML5, 'UTF-8'),
              'picture_path' => htmlspecialchars($dock[$i]->items[$j]->subitems[$k]->picture_path, ENT_COMPAT | ENT_HTML5, 'UTF-8'),
              'item_type' => htmlspecialchars($dock[$i]->items[$j]->subitems[$k]->subitem_magic, ENT_COMPAT | ENT_HTML5, 'UTF-8'),
              'action' => htmlspecialchars($dock[$i]->items[$j]->subitems[$k]->action, ENT_COMPAT | ENT_HTML5, 'UTF-8'),
              'html_id' => $html_id,
            );
          }
        }
      }
    }
  }
  
  /**
   * This prints out the HTML for the dock header section.
   * @author Damien Whaley <damien@whalebonestudios.com>
   */
  public function generateHtmlDock() {
    
    // i18n Settings
    putenv('LANG='.str_replace('-', '_', $this->getLanguageCode()).'.UTF-8');
    setlocale(LC_ALL, str_replace('-', '_', $this->getLanguageCode()).'.UTF-8');
    $domain = 'messages';
    bindtextdomain($domain, realpath($_SERVER["DOCUMENT_ROOT"]) . '/locale');
    textdomain($domain);
    
    $module_list = $this->prepareModule();
    
    $start_output = array("      <header>\n",
			"        <div class=\"container-fluid\">\n",
			"          <div class=\"row-fluid\">\n");
							
    $end_output = array("            <div id=\"search\" class=\"span4\">\n",
			"              <form class=\"well form-search\">\n",
			"                <div class=\"row-fluid\">\n",
			"                  <div class=\"span12\">\n",
			"                    <div class=\"span9\">\n",
			"                      <input type=\"text\" class=\"span12 search-query\">\n",
			"                    </div>\n",
			"                    <div class=\"span3\">\n",
			"                      <button type=\"submit\" class=\"span12 btn\">",
      gettext('Search'),
      "</button>\n",
			"                    </div>\n",
			"                    <div id=\"refine-search\" class=\"dropdown\">\n",
			"                      <a href=\"javascript:void(0);\" class=\"dropdown-toggle\"",
      " data-toggle=\"dropdown\">",
      gettext('Refine Search'),
      "</a>\n",
			"                      <ul class=\"dropdown-menu\">\n",
			"                        <li>",
      gettext('In field'),  
      ":</li>\n",
			"                        <li>\n",
			"                          <label class=\"radio\">\n",
			"                            <input type=\"radio\" name=\"optionsRadios\"",
      " id=\"optionsRadios1\" value=\"option1\" checked=\"\">\n",
			"                            ",
      gettext('All fields'),
      "\n",
      "                          </label>\n",
			"                         </li>\n",
			"                         <li>\n",
			"                           <label class=\"radio\">\n",
			"                             <input type=\"radio\" name=\"optionsRadios\"",
      " id=\"optionsRadios1\" value=\"option1\">\n",
      "                            ",
			gettext('Name'),
			"\n",
      "                           </label>\n",
			"                         </li>\n",
			"                         <li>\n",
			"                           <label class=\"radio\">\n",
			"                             <input type=\"radio\" name=\"optionsRadios\"",
      " id=\"optionsRadios1\" value=\"option1\">\n",
      "                            ",
			gettext('Email'),
			"                           </label>\n",
			"                         </li>\n",
			"                         <li>\n",
			"                           <label class=\"radio\">\n",
			"                             <input type=\"radio\" name=\"optionsRadios\"",
      " id=\"optionsRadios1\" value=\"option1\">\n",
			"                            ",
      gettext('Phone'),
			"                           </label>\n",
			"                         </li>\n",
			"                        <li>\n",
      "                        <li><hr></li>\n",
		  "                        <li>\n",
      "                          ",
			gettext('By module'),
      ":\n",
			"                        </li>\n",
			"                        <li>\n",
			"                          <select name=\"\" id=\"\" class=\"\">\n",
      $module_list,
      "                          </select>\n",
			"                        </li>\n",
			"                      </ul>\n",
			"                    </div><!-- end .dropdown -->\n",
			"                  </div><!-- end .span12 -->\n",
			"                </div><!-- end .row-fluid -->\n",
			"              </form>\n",
			"            </div><!-- end #search -->\n",
			"          </div><!-- end .row-fluid -->\n",
			"        </div><!-- end .container-fluid -->\n",
			"      </header><!-- end header -->\n");
    
    echo implode('', $start_output);
    echo $this->prepareDock();
    echo implode('', $end_output);
  }
  
  /**
   * This takes the output from the array contained within the session->modules
   * data and it stores it in an internal structure which will be used to display
   * parts of it.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param array $tab
   *   - The array contained within the session->modules data.
   */
  public function buildModule($module) {
    if (is_array($module)) {
      for($i = 0; $i < sizeof($module); $i++) {
        $this->_module[] = array('module' => htmlspecialchars($module[$i]->module, ENT_COMPAT | ENT_HTML5, 'UTF-8'),
          'name' => htmlspecialchars($module[$i]->name, ENT_COMPAT | ENT_HTML5, 'UTF-8'));
      }
    }
  }
  
  /**
   * This prepares the HTML snippet which represents the dock,
   * dock items and dock sub items.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - String containing the HTML snippet for the dock.
   */
  protected function prepareDock() {
    $output = array("            <ul id=\"groups\" class=\"span8\">\n");
    
    if (isset($this->_dock) && is_array($this->_dock)) {
      for ($i = 0; $i < count($this->_dock); $i++) {
        // Prepare docks
        $title = '';
        $alt_text = '';
        $img = '';
        
        if (isset($this->_dock[$i]['display_name'])
          && $this->_dock[$i]['display_name'] !== '') {
          $title = $this->_dock[$i]['display_name'];
        } else if (isset($this->_dock[$i]['name'])
          && $this->_dock[$i]['name'] !== '') {
          $title = $this->_dock[$i]['name'];
        }
        
        if (isset($this->_dock[$i]['description'])
          && $this->_dock[$i]['description'] !== '') {
          $alt_text = $title . " - " . $this->_dock[$i]['description'];
        } else {
          $alt_text = $title;
        }
        
        if (isset($this->_dock[$i]['picture_path'])
          && $this->_dock[$i]['picture_path'] !== '') {
          $img = $this->_dock[$i]['picture_path'];
        } else {
          $img = 'img/75x55.gif';
        }
        
        $output[] = "              <li class=\"dropdown\">\n";
        $output[] = "                <a href=\"javascript:void(0);\"";
        $output[] = "class=\"dropdown-toggle\" data-toggle=\"dropdown\">\n";
        $output[] = "                  <img src=\"";
        $output[] = $img;
        $output[] = "\" alt=\"";
        $output[] = $alt_text;
        $output[] = "\" title=\"";
        $output[] = $alt_text;
        $output[] = "\" width=\"75\" height=\"55\">\n";
        $output[] = "                  <span>";
        $output[] = $title;
        $output[] = "</span>\n";
        $output[] = "                </a>\n";
        
        if (isset($this->_dock[$i]['items']) && is_array($this->_dock[$i]['items'])) {
          
          if (count($this->_dock[$i]['items']) > 0) {
            $output[] = "                <ul class=\"dropdown-menu\">\n";
          }
          
          for ($j = 0; $j < count($this->_dock[$i]['items']); $j++) {
            // Prepare dock items
            $item_title = '';
            $item_alt_text = '';
            $item_img = '';
            $item_action = '';
            
            if (isset($this->_dock[$i]['items'][$j]['display_name'])
              && $this->_dock[$i]['items'][$j]['display_name'] !== '') {
              $item_title = $this->_dock[$i]['items'][$j]['display_name'];
            } else if (isset($this->_dock[$i]['items'][$j]['name'])
              && $this->_dock[$i]['items'][$j]['name'] !== '') {
              $item_itle = $this->_dock[$i]['items'][$j]['name'];
            }
            
            if (isset($this->_dock[$i]['items'][$j]['description'])
              && $this->_dock[$dockIndex]['items'][$j]['description'] !== '') {
              $item_alt_text = $title . " - " . $this->_dock[$i]['items'][$j]['description'];
            } else {
              $item_alt_text = $title;
            }
            
            if (isset($this->_dock[$i]['items'][$j]['picture_path'])
              && $this->_dock[$i]['items'][$j]['picture_path'] !== '') {
              $item_img = $this->_dock[$i]['items'][$j]['picture_path'];
            } else {
              $item_img = '';
            }
            
            if ($this->_dock[$i]['items'][$j]['item_type'] === 'submenu_parent') {
              $item_action = "javascript:void(0);";
            } else {
              if (strpos($this->_dock[$i]['items'][$j]['action'], 'javascript:', 0) !== false) {
                $item_action = $this->_dock[$i]['items'][$j]['action'];
              } else {
                $item_action = "javascript:insertPageFragment('"
                  . $this->_dock[$i]['items'][$j]['action'] . "', true);";
              }
            }
            
            if ($item_img !== '') {
              $item_img = "                      <i class=\"" . $item_img . "\"></i>\n";
            }
            
            $output[] = "                  <li>\n";
            
            if ($this->_dock[$i]['items'][$j]['item_type'] === 'submenu_parent') {
              $output[] = "                    <a href=\"javascript:void(0);";
              $output[] = " title=\"";
              $output[] = $item_alt_text;
              $output[] = "\">\n";
              
              if ($item_img !== '') {
                $output[] = $item_img;
              }
              
              $output[] = "                      ";
              $output[] = $item_title;
              $output[] = "\n";
              $output[] = "                    <i class=\"icon-arrow-right\"></i>\n";
              $output[] = "                    </a>\n";
              
              if (isset($this->_dock[$i]['items'][$j]['subitems'])
                && is_array($this->_dock[$i]['items'][$j]['subitems'])) {
                
                if (count($this->_dock[$i]['items'][$j]['subitems']) > 0) {
                  $output[] = "                  <ul class=\"dropdown-menu sub-menu\">\n";
                }
                
                for($k = 0; $k < count($this->_dock[$i]['items'][$j]['subitems']); $k++) {
                  // Prepare dock subitems
                  $subitem_title = '';
                  $subitem_alt_text = '';
                  $subitem_img = '';
                  $subitem_action = '';
                
                  if (isset($this->_dock[$i]['items'][$j]['subitems'][$k]['display_name'])
                    && $this->_dock[$i]['items'][$j]['subitems'][$k]['display_name'] !== '') {
                    $subitem_title = $this->_dock[$i]['items'][$j]['subitems'][$k]['display_name'];
                  } else if (isset($this->_dock[$i]['items'][$j]['subitems'][$k]['name'])
                    && $this->_dock[$i]['items'][$j]['subitems'][$k]['name'] !== '') {
                    $subitem_title = $this->_dock[$i]['items'][$j]['subitems'][$k]['name'];
                  }
                  
                  if (isset($this->_dock[$i]['items'][$j]['subitems'][$k]['description'])
                    && $this->_dock[$i]['items'][$j]['subitems'][$k]['description'] !== '') {
                    $subitem_alt_text = $title . " - " . $this->_dock[$i]['items'][$j]['subitems'][$k]['description'];
                  } else {
                    $subitem_alt_text = $title;
                  }
                  
                  if ($this->_dock[$i]['items'][$j]['subitems'][$k]['picture_path']
                    && $this->_dock[$i]['items'][$j]['subitems'][$k]['picture_path'] !== '') {
                    $subitem_img = $this->_dock[i]['items'][$j]['subitems'][$k]['picture_path'];
                  } else {
                    $subitem_img = '';
                  }
                  
                  if ($subitem_img !== '') {
                    $subitem_img = "                        <i class=\"" . $subitem_img . "\"></i>\n";
                  }
                  
                  if (strpos($this->_dock[$i]['items'][$j]['subitems'][$k]['action'], 'javascript:', 0) !== false) {
                    $subitem_action = $this->_dock[$i]['items'][$j]['subitems'][$k]['action'];
                  } else {
                    $subitem_action = "javascript:insertPageFragment('" . $this->_dock[$i]['items'][$j]['subitems'][$k]['action'] . "', true);";
                  }
                  
                  $output[] = "                    <li>\n";
                  $output[] = "                      <a href=\"";
                  $output[] = $subitem_action;
                  $output[] = "\" title=\"";
                  $output[] = $subitem_alt_text;
                  $output[] = "\">\n";
                  
                  if ($subitem_img !== '') {
                    $output[] = $subitem_img;
                  }
                  
                  $output[] = "                        ";
                  $output[] = $subitem_title;
                  $output[] = "                      </a>\n";
                  $output[] = "                    </li>\n";               
                }
                
                if (count($this->_dock[$i]['items'][$j]['subitems']) > 0) {
                  $output[] = "                  </ul>\n";
                }
              }
            }
            else {
              $output[] = "                    <a href=\"";
              $output[] = $item_action;
              $output[] = "\" title=\"";
              $output[] = $item_alt_text;
              $output[] = "\">\n";
              
              if ($item_img !== '') {
                $output[] = $item_img;
              }
              
              $output[] = "                      ";
              $output[] = $item_title;
              $output[] = "                    </a>\n";
            }
            $output[] = "                  </li>\n";
          }
          
          if (count($this->_dock[$i]['items']) > 0) {
            $output[] = "                </ul>\n";
          }
        }
        $output[] = "              </li>\n";
      }
    }   	
    $output[] = "            </ul><!-- end #groups -->\n";
    
    return implode('', $output);
  }
  
  /**
   * This prepares the HTML snippet which represents the module list.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @return string
   *   - String containing the HTML snippet for the module list.
   */
  protected function prepareModule() {
    
    // i18n Settings
    putenv('LANG='.str_replace('-', '_', $this->getLanguageCode()).'.UTF-8');
    setlocale(LC_ALL, str_replace('-', '_', $this->getLanguageCode()).'.UTF-8');
    $domain = 'messages';
    bindtextdomain($domain, realpath($_SERVER["DOCUMENT_ROOT"]) . '/locale');
    textdomain($domain);
    
    $output = array();
    
    $output[] = "                            <option value=\"\">";
    $output[] = gettext('All modules');
    $output[] = "</option>\n";
    
    if (isset($this->_module) && is_array($this->_module)) {
      for ($i = 0; $i < count($this->_module); $i++) {
        $output[] = "                            <option value=\"";
        $output[] = $this->_module[$i]['module'];
        $output[] = "\">";
        $output[] = $this->_module[$i]['name'];
        $output[] = "</option>\n";
      }
    }
    
    return implode('', $output);
  }
  
  /**
   * This resets all the values back to the defaults.
   * @author Damien Whaley <damien@whalebonestudios.com>
   */
  public function resetAll() {
    $this->_dock = array();
    $this->_module = array();
    $this->_language_code = '';
  }
  
  /**
   * This sets all the parameters for the class in one shot.
   * @param array $dock
   *   - Array of objects containing the docks, dock items, dock subitems to be loaded.
   * @param array $module
   *   - Array of objects containing the modules the user can see.
   * @param string $language_code
   *   - The langage_code to display the page in the given language/locale.
   */
  public function setAll($dock, $module, $language_code) {
    $this->buildDock($dock);
    $this->buildModule($module);
    $this->setLanguageCode($language_code);
  }
}
