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

/**
  * Dock class.
  */
class Dock {
  
  /**
   * Array containing all the dock items. This contains the whole tree structure
   * of the docks, dock items and dock sub items.
   * @var array
   */
  private $_dock;
  
  /**
   * Array containing all the tab items. This is a flat array structure with all
   * the tabs.
   * @var array
   */
  private $_tab;
  
  /**
   * Default constructor.
   * @param array $css
   *   - contains an array of the css files to load.
   * @param array $js
   *   - contains an array of the js files to load.
   */
  public function __construct() {
    $arg_count = func_num_args();
    
    $this->_dock = array();
    
    // Add docks
    if ($arg_count > 0) {
      buildDock(func_get_arg(0));
    }
  }
  
  /**
   * This takes the output from the ListUserDocks command and it stores it
   * in an internal structure which will be used to display parts of it.
   * @param array $dock
   *   - The array returned from the list_user_docks command.
   */
  public function buildDock($dock) {
    if (is_array($dock)) {
      for($i = 0; $i < sizeof($dock); $i++) {
        $html_id = 'dock-' . (($i < 10) ? '0' . $i : $i);
        
        $this->_dock[] = array(
          'name' => htmlspecialchars($dock[$i]->dock_name, ENT_COMPAT | ENT_HTML5),
          'display_label' => htmlspecialchars($dock[$i]->display_label, ENT_COMPAT | ENT_HTML5),
          'description' => htmlspecialchars($dock[$i]->description, ENT_COMPAT | ENT_HTML5),
          'picture_path' => htmlspecialchars($dock[$i]->picture_path, ENT_COMPAT | ENT_HTML5),
          'html_id' => $html_id,
          'items' => array(),
        );
    
        for($j = 0; $j < sizeof($dock[$i]->items); $j++) {
          $html_id = 'dock-' . (($i < 10) ? '0' . $i : $i) . '-item-' . (($j < 10) ? '0' . $j : $j);
                    
          $this->_dock[$i]['items'][] =  array(
            'name' => htmlspecialchars($dock[$i]->items[$j]->item_name, ENT_COMPAT | ENT_HTML5),
            'display_label' => htmlspecialchars($dock[$i]->items[$j]->display_label, ENT_COMPAT | ENT_HTML5),
            'description' => htmlspecialchars($dock[$i]->items[$j]->description, ENT_COMPAT | ENT_HTML5),
            'picture_path' => htmlspecialchars($dock[$i]->items[$j]->picture_path, ENT_COMPAT | ENT_HTML5),
            'item_type' => htmlspecialchars($dock[$i]->items[$j]->item_magic, ENT_COMPAT | ENT_HTML5),
            'action' => htmlspecialchars($dock[$i]->items[$j]->action, ENT_COMPAT | ENT_HTML5),
            'html_id' => $html_id,
            'subitems' => array(),
          );
          
          for($k = 0; $k < sizeof($dock[$i]->items[$j]->subitems); $k++) {
            $html_id = 'dock-' . (($i < 10) ? '0' . $i : $i) . '-item-' . (($j < 10) ? '0' . $j : $j) . '-subitem-' . (($k < 10) ? '0' . $k : $k);
            
            $this->_dock[$i]['items'][$j]['subitems'][] = array(
              'name' => htmlspecialchars($dock[$i]->items[$j]->subitems[$k]->subitem_name, ENT_COMPAT | ENT_HTML5),
              'display_label' => htmlspecialchars($dock[$i]->items[$j]->subitems[$k]->display_label, ENT_COMPAT | ENT_HTML5),
              'description' => htmlspecialchars($dock[$i]->items[$j]->subitems[$k]->description, ENT_COMPAT | ENT_HTML5),
              'picture_path' => htmlspecialchars($dock[$i]->items[$j]->subitems[$k]->picture_path, ENT_COMPAT | ENT_HTML5),
              'item_type' => htmlspecialchars($dock[$i]->items[$j]->subitems[$k]->subitem_magic, ENT_COMPAT | ENT_HTML5),
              'action' => htmlspecialchars($dock[$i]->items[$j]->subitems[$k]->action, ENT_COMPAT | ENT_HTML5),
              'html_id' => $html_id,
            );
          }
        }
      }
    }
  }
  
  /**
   * This takes the output from the ListUserDockTabs command and it stores it
   * in an internal structure which will be used to display parts of it.
   * @param array $tab
   *   - The array returned from the list_user_dock_tabs command.
   */
  function buildTab($tab) {
  	if (is_array($tab)) {
      for($i = 0; $i < sizeof($tab); $i++) {
  		$html_id = 'tab-' . (($i < 10) ? '0' . $i : $i);
  	
  		$this->_tab[] = array(
  		  'name' => htmlspecialchars($tab[$i]->tab_name, ENT_COMPAT | ENT_HTML5),
  		  'display_label' => htmlspecialchars($tab[$i]->display_label, ENT_COMPAT | ENT_HTML5),
  		  'description' => htmlspecialchars($tab[$i]->description, ENT_COMPAT | ENT_HTML5),
  		  'picture_path' => htmlspecialchars($tab[$i]->picture_path, ENT_COMPAT | ENT_HTML5),
  		  'action' => htmlspecialchars($tab[$i]->action, ENT_COMPAT | ENT_HTML5),
  		  'html_id' => $html_id,
  		  'dock_item' => htmlspecialchars($tab[$i]->dock_items_uuid, ENT_COMPAT | ENT_HTML5),
  		  'dock_subitem' => htmlspecialchars($tab[$i]->dock_subitems_uuid, ENT_COMPAT | ENT_HTML5),
  		);
  	  }
    }
  }
  
  /**
   * This prints out just the divs which make up the dock.
   * @return string
   *   - Containing the HTML snippet for the docks.
   */
  public function printDock() {
    $output = '';
    
    for ($i = 0; $i < sizeof($this->_dock); $i++) {
      $title = '';
      $alt_text = '';
      $img = '';
      
      $output .= "  <div class=\"dock-tile\" id=\"". $this->_dock[$i]['html_id'] . "\">";
      
      if (isset($this->_dock[$i]['display_label']) && $this->_dock[$i]['display_label'] !== '') {
        $title = $this->_dock[$i]['display_label'];
      } else if (isset($this->_dock[$i]['name']) && $this->_dock[$i]['name'] !== '') {
        $title = $this->_dock[$i]['name'];
      }
      
      if (isset($this->_dock[$i]['description']) && $this->_dock[$i]['description'] !== '') {
        $alt_text = $title . " - " . $this->_dock[$i]['description'];
      } else {
        $alt_text = $title;
      }
      
      if (isset($this->_dock[$i]['picture_path']) && $this->_dock[$i]['picture_path'] !== '') {
        $img = $this->_dock[$i]['picture_path'];
      } else {
        $img = '#';
      }
      
      $output .= "<a href=\"javascript:flyOpenDockItem('" . $this->_dock[$i]['html_id']
        . "-item');\" class=\"dock-link\">"
        . "<img src=\"" . $img . "\" class=\"dock-icon\" title=\""
        . $alt_text . "\" alt=\"" . $title . "\"></a></div>\n";
    }
    $output .= "<script type=\"text/javascript\">var dockCount = '" . $i . "';</script>\n";
    
    echo $output;
  }
  
  /**
   * This produces the HTML snippet for a single dock item
   * @param int $dockIndex
   *   - integer containing the array index for the dock.
   */
  private function printDockItem($dockIndex) {
    $output = '';
    
    if (isset($this->_dock[$dockIndex]) && is_array($this->_dock[$dockIndex])) {
      $html_id = 'dock-' . (($dockIndex < 10) ? '0' . $dockIndex : $dockIndex) . '-item';
      $output = "<div id=\"" . $html_id . "\" class=\"dock-item-wrap\" style=\"display: none;\">";
      for ($i = 0; $i < sizeof($this->_dock[$dockIndex]['items']); $i++) {
        $title = '';
        $alt_text = '';
        $img = '';
        $action = '';
        $append = '';
        
        $output .= "<div id=\"" . $this->_dock[$dockIndex]['items'][$i]['html_id'] . "\" class=\"dock-item\">";
        
        if (isset($this->_dock[$dockIndex]['items'][$i]['display_label']) && $this->_dock[$dockIndex]['items'][$i]['display_label'] !== '') {
          $title = $this->_dock[$dockIndex]['items'][$i]['display_label'];
        } else if (isset($this->_dock[$dockIndex]['items'][$i]['name']) && $this->_dock[$dockIndex]['items'][$i]['name'] !== '') {
          $title = $this->_dock[$dockIndex]['items'][$i]['name'];
        }
        
        if (isset($this->_dock[$dockIndex]['items'][$i]['description']) && $this->_dock[$dockIndex]['items'][$i]['description'] !== '') {
          $alt_text = $title . " - " . $this->_dock[$dockIndex]['items'][$i]['description'];
        } else {
          $alt_text = $title;
        }
        
        if (isset($this->_dock[$dockIndex]['items'][$i]['picture_path']) && $this->_dock[$dockIndex]['items'][$i]['picture_path'] !== '') {
          $img = $this->_dock[$dockIndex]['items'][$i]['picture_path'];
        } else {
          $img = '';
        }
        
        if ($img !== '') {
          $output .= "<img src=\"" . $img . "\">";
        }

        if ($this->_dock[$dockIndex]['items'][$i]['item_type'] === 'submenu_parent') {
          // determine what the action should be here
          $action = "javascript:flyOpenDockSubitem('" . $this->_dock[$dockIndex]['items'][$i]['html_id'] . "-subitem');";
          $append = ' &gt;';
        } else {
          if (strpos($this->_dock[$dockIndex]['items'][$i]['action'], 'javascript:', 0) !== false) {
          	$action = $this->_dock[$dockIndex]['items'][$i]['action'];
          } else {
            $action = "javascript:insertContent('" . $this->_dock[$dockIndex]['items'][$i]['action'] . "');";
          }
          $append = '';
        }
        
        $output .= "<a class=\"dock-item-link\" title=\"" . $alt_text . "\""
          . " href=\"" . $action . "\">"
          . $title . "</a>" . $append . "</div>\n";
      }
      $output .= "</div>\n";
    }
     
    echo $output;
  }
  
  /**
  * This produces the HTML snippet for a single dock subitem
  * @param int $dockIndex
  *   - integer containing the array index for the dock.
  * @param int $dockItemIndex
  *   - integer containing the array index for the dock item.
  */
  private function printDockSubitem($dockIndex, $dockItemIndex) {
    $output = '';
  
    if (isset($this->_dock[$dockIndex]['items'][$dockItemIndex]['subitems']) && is_array($this->_dock[$dockIndex]['items'][$dockItemIndex]['subitems'])) {
      $html_id = 'dock-' . (($dockIndex < 10) ? '0' . $dockIndex : $dockIndex) . '-item-' . (($dockItemIndex < 10) ? '0' . $dockItemIndex : $dockItemIndex) . '-subitem';
      $output = "<div id=\"" . $html_id . "\" class=\"dock-subitem-wrap\" style=\"display: none;\">";
      for ($i = 0; $i < sizeof($this->_dock[$dockIndex]['items'][$dockItemIndex]['subitems']); $i++) {
        $title = '';
        $alt_text = '';
        $img = '';
        $action = '';
        $append = '';
  
        $output .= "<div id=\"" . $this->_dock[$dockIndex]['items'][$dockItemIndex]['subitems'][$i]['html_id'] . "\" class=\"dock-subitem\">";
  
        if (isset($this->_dock[$dockIndex]['items'][$dockItemIndex]['subitems'][$i]['display_label']) && $this->_dock[$dockIndex]['items'][$dockItemIndex]['subitems'][$i]['display_label'] !== '') {
          $title = $this->_dock[$dockIndex]['items'][$dockItemIndex]['subitems'][$i]['display_label'];
        } else if (isset($this->_dock[$dockIndex]['items'][$dockItemIndex]['subitems'][$i]['name']) && $this->_dock[$dockIndex]['items'][$dockItemIndex]['subitems'][$i]['name'] !== '') {
          $title = $this->_dock[$dockIndex]['items'][$dockItemIndex]['subitems'][$i]['name'];
        }
  
        if (isset($this->_dock[$dockIndex]['items'][$dockItemIndex]['subitems'][$i]['description']) && $this->_dock[$dockIndex]['items'][$dockItemIndex]['subitems'][$i]['description'] !== '') {
          $alt_text = $title . " - " . $this->_dock[$dockIndex]['items'][$dockItemIndex]['subitems'][$i]['description'];
        } else {
          $alt_text = $title;
        }
  
        if ($this->_dock[$dockIndex]['items'][$dockItemIndex]['subitems'][$i]['picture_path'] && $this->_dock[$dockIndex]['items'][$dockItemIndex]['subitems'][$i]['picture_path'] !== '') {
          $img = $this->_dock[$dockIndex]['items'][$dockItemIndex]['subitems'][$i]['picture_path'];
        } else {
          $img = '';
        }
  
        if ($img !== '') {
          $output .= "<img src=\"" . $img . "\">";
        }
        
        if (strpos($this->_dock[$dockIndex]['items'][$dockItemIndex]['subitems'][$i]['action'], 'javascript:', 0) !== false) {
          $action = $this->_dock[$dockIndex]['items'][$dockItemIndex]['subitems'][$i]['action'];
        } else {
          $action = "javascript:insertContent('" . $this->_dock[$dockIndex]['items'][$dockItemIndex]['subitems'][$i]['action'] . "');";
        }
        
        $output .= "<a class=\"dock-subitem-link\" title=\"" . $alt_text . "\""
          . " href=\"" . $action . "\">"
          . $title . "</a>" . $append . "</div>\n";        
      }
      $output .= "</div>\n";
    }
     
    echo $output;
  }
  
  /**
   * This prints out all the dock items.
   */
  public function printDockItems() {
    for($i = 0; $i < sizeof($this->_dock); $i++) {
      $this->printDockItem($i);
    }
    echo "<script type=\"text/javascript\">var dockItemCount = '" . $i . "';</script>\n";
  }
  
  /**
   * This prints out all the dock subitems.
   */
  public function printDockSubitems() {
    for($i = 0; $i < sizeof($this->_dock); $i++) {
      for($j = 0; $j < sizeof($this->_dock[$i]['items']); $j++) {
        $this->printDockSubitem($i, $j);
      }
    }
  }
  
  /**
   * This prints out a single dock tabs
   */
  public function printDockTab() {
  	$output = '';
  	
  	for ($i = 0; $i < sizeof($this->_tab); $i++) {
  	  $title = '';
  	  $alt_text = '';
  	  $img = '';
  	
  	  $output .= "  <div class=\"dock-tab\" id=\"". $this->_tab[$i]['html_id'] . "\" style=\"display: none;\">";
  	
  	  if (isset($this->_tab[$i]['display_label']) && $this->_tab[$i]['display_label'] !== '') {
  	    $title = $this->_tab[$i]['display_label'];
  	  } else if (isset($this->_tab[$i]['name']) && $this->_tab[$i]['name'] !== '') {
  	    $title = $this->_tab[$i]['name'];
  	  }
  	
  	  if (isset($this->_tab[$i]['description']) && $this->_tab[$i]['description'] !== '') {
  		$alt_text = $title . " - " . $this->_tab[$i]['description'];
  	  } else {
  		$alt_text = $title;
  	  }
  	
  	  if (isset($this->_tab[$i]['picture_path']) && $this->_tab[$i]['picture_path'] !== '') {
  	    $img = $this->_tab[$i]['picture_path'];
  	  } else {
  		$img = '';
  	  }
  	  
  	  if ($img !== '') {
  	  	$output .= "<img src=\"" . $img . "\">";
  	  }
  	
  	  if (strpos($this->_tab[$i]['action'], 'javascript:', 0) !== false) {
  	  	$action = $this->_tab[$i]['action'];
  	  } else {
  	  	$action = "javascript:insertContent('" . $this->_tab[$i]['action'] . "');";
  	  }
  	  
  	  $output .= "<a class=\"dock-tab-link\" title=\"" . $alt_text . "\""
  	    . " href=\"" . $action . "\">"
  	    . $title . "</a></div>\n";
  	}
  	$output .= "<script type=\"text/javascript\">var dockTabCount = '" . $i . "';</script>\n";
  	
  	echo $output;
  }
}
