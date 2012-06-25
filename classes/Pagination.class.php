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
  * Pagination class.
  */
class Pagination {
  
  /**
   * Integer holding the total number of results.
   * @var integer
   */
  private $_total_count;
  
  /**
  * Integer holding the number of results per page.
  * @var integer
  */
  private $_size;
  
  /**
   * Integer holding the number of items the displayed items are offset for.
   * @var integer
   */
  private $_offset;
  
  /**
   * String containing the sort ordinal.
   * @var string
   */
  private $_ordinal;
  
  /**
   * String containing the sort direction.
   * @var string
   */
  private $_direction;
  
  /**
   * String containing the language code base.
   * @var string
   */
  private $_language_code;
  
  /**
   * String containing the pagination type. This is where you can have
   * multiple pagination items per screen.
   * @var string
   */
  private $_type;
  
  /**
   * Array containing the prepared output.
   * @var array
   */
  private $_output;
  
  /**
   * String containing the name of the callback handler to display the list
   * @var string
   */
  private $_callback;
  
  /**
   * Default constructor.
   */
  public function __construct() {
    $this->_total_count = 0;
    $this->_size = -1;
    $this->_offset = 0;
    $this->_ordinal = SORT_ORDINAL_DEFAULT;
    $this->_direction = SORT_DIRECTION_ASCENDING;
    $this->_language_code = '';
    $this->_type = 'page';
    $this->_output = array();
    $this->_callback = 'void';
  }
  
  /**
   * This prepares the HTML for the pagination for the list.
   * @author Damien Whaley
   */
  public function preparePagination() {
    
    if ($this->_total_count <= $this->_size) {
      // No pagination required.
      return;
    }
    
    // i18n Settings
    putenv('LANG='.str_replace('-', '_', $this->getLanguageCode()).'.UTF-8');
    setlocale(LC_ALL, str_replace('-', '_', $this->getLanguageCode()).'.UTF-8');
    $domain = 'messages';
    bindtextdomain($domain, realpath($_SERVER["DOCUMENT_ROOT"]) . '/locale');
    textdomain($domain);
    
    $output = array();
    
    $last_page = $this->_total_count - ($this->_total_count % $this->_size);
    
    if ($this->_offset > 0) {
      $this->_output[] = $this->generateEntry(0, 0, false, '&lt;&lt; ' . gettext('First'));
      $this->_output[] = $this->generateEntry($this->_offset - $this->_size, 0, false, '&lt; ' . gettext('Previous'));
    }
    
    $min_threshold = 0;
    if ($this->_offset <= ($this->_size * 2)) {
      $min_threshold = 0;
    } else {
      $min_threshold = $this->_offset - (2 * $this->_size);
    }
    
    $max_threshold = 0;
    if (($this->_offset + ($this->_size * 2)) > $last_page) {
      $max_threshold = $last_page;
    }
    else {
      $max_threshold = $this->_offset + (2 * $this->_size);
    }
    
    // Here make sure that 5 steps show regardless of position
    if (($max_threshold - $min_threshold) < (5 * $this->_size) && (5 * $this->_size) <= $last_page && ($min_threshold - (2 * $this->_size)) <= 0) {
      $max_threshold = $min_threshold + (4 * $this->_size);
    } else if (((($max_threshold - $min_threshold) < (5 * $this->_size)) && (5 * $this->_size) <= $last_page) && ($max_threshold +  (2 * $this->_size)) >= $last_page) {
      $min_threshold = $max_threshold - (4 * $this->_size);
    }
    
    for ($i = 0; $i <= $last_page; $i += $this->_size) {
      
      if ($i == $min_threshold && $i != 0) {
        $this->_output[] = $this->generatePadding(0);
      }
  
      if ($i >= $min_threshold && $i <= $max_threshold) {     
        $is_active = ($i == $this->_offset) ? true : false;
        $page_number = ($i / $this->_size) + 1;
               
        $this->_output[] = $this->generateEntry($i, $page_number, $is_active, '');
      }

      if ($i == $max_threshold && $i < $last_page) {
        $this->_output[] = $this->generatePadding(1);
      }
    }

    if ($this->_offset < $last_page) {
      $this->_output[] = $this->generateEntry($this->_offset + $this->_size, 0, false, gettext('Next') . ' &gt;');
      $this->_output[] = $this->generateEntry($i, 0, false, gettext('Last') . ' &gt;&gt;');
    }
  }
  
  /**
   * This outputs the pagination which was prepared.
   * @author Damien Whaley <damien@whalebonestudios.com>
   */
  public function generatePagination() {
    // i18n Settings
    putenv('LANG='.str_replace('-', '_', $this->getLanguageCode()).'.UTF-8');
    setlocale(LC_ALL, str_replace('-', '_', $this->getLanguageCode()).'.UTF-8');
    $domain = 'messages';
    bindtextdomain($domain, realpath($_SERVER["DOCUMENT_ROOT"]) . '/locale');
    textdomain($domain);
    
    echo "<div id=\"pagination-" . $this->_type . "-wrap\" class=\"pagination-" . $this->_type . "-wrap\">\n";
    echo "<form name=\"pagination_" . $this->_type . "_form\" action=\"butr.php\" method=\"post\">\n";
    if (count($this->_output) > 0) {
      echo implode('&nbsp;', $this->_output);
      echo "<br>\n";
    }
    echo gettext('Displaying up to') . " ";
    echo "<select name=\"size\"";
    if (count($this->_output) > 0) {
      echo " onchange=\"javascript:sizePagination('" . $this->_type . "', this.value, " . $this->_callback . ");\"";
    }
    echo " class=\"pagination-" . $this->_type ."\">\n";
    if ($this->_size == 10) {
      echo "<option value=\"10\" selected>10</option>\n";
    } else {
      echo "<option value=\"10\">10</option>\n";
    }
    if ($this->_size == 20) {
      echo "<option value=\"20\" selected>20</option>\n";
    } else {
      echo "<option value=\"20\">20</option>\n";
    }
    if ($this->_size == 50) {
      echo "<option value=\"50\" selected>50</option>\n";
    } else {
      echo "<option value=\"50\">50</option>\n";
    }
    if ($this->_size == 100) {
      echo "<option value=\"100\" selected>100</option>\n";
    } else {
      echo "<option value=\"100\">100</option>\n";
    }
    if ($this->_size == -1) {
      echo "<option value=\"-1\" selected>" . gettext('All') . "</option>\n";
    } else {
      echo "<option value=\"-1\">" . gettext('All') . "</option>\n";
    }
    echo "</select>\n";
    echo " " . gettext('results from a total of') . " " . $this->_total_count . ".\n";
    echo "<input type=\"hidden\" name=\"offset\" value=\"" . $this->_offset . "\">\n";
    echo "<input type=\"hidden\" name=\"direction\" value=\"" . $this->_direction . "\">\n";
    echo "<input type=\"hidden\" name=\"ordinal\" value=\"" . $this->_ordinal . "\">\n";
    echo "</form>\n";
    echo "</div>\n";
  }
  
  /**
   * This generates the code for each of the items in the pagination set.
   * @param integer $offset
   *   - The offset used to generate the jump function call
   * @param integer $item
   *   - The item number used to generate the div id.
   * @param boolean $is_active
   *   - The size of the list used to generate the jump function call
   * @param string $label
   *   - The label to be used for the link text. If empty then it uses
   *     the $item numerical index.
   * @return string
   *   - the contents of the entry
   */
  private function generateEntry($offset, $item, $is_active, $label) {
    
    if ($is_active) {
      $output = "<div id=\"pagination-" . $this->_type . "-" . $item
      . "\" class=\"pagination-" . $this->_type . "-active\">";
      
      if ($label !== '') {
        $output .= $label;
      } else {
        $output .= $item;
      }
      
      $output .= "</div>\n";
    } else {
      $output = "<div id=\"pagination-" . $this->_type . "-" . $item
        . "\" class=\"pagination-" . $this->_type
        . "\"><a href=\"javascript:jumpPagination('" . $this->_type
        . "', '" . $offset . "', " . $this->_callback . ");\" class=\"pagination-link-" . $this->_type
        . "\">";
      
      if ($label !== '') {
        $output .= $label;
      } else {
        $output .= $item;
      }
      
      $output .= "</a></div>\n";
    }
    
    return $output;
  }
  
  /**
   * This prodces the buffer either sides of the entries if there's too many.
   * @param integer $i
   *   - This denotes whether it is before or after the entries.
   */
  private function generatePadding($i) {
    return "<div class=\"pagination-padding-" . $this->_type . "\""
     . " id=\"pagination-padding-" . $this->_type . "-" . $i . "\">...</div>";
  }
  
  /**
   * This sets the total count for the total possible number of items.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param integer $total_count
   *   - integer containing the total count.
   */
  public function setTotalCount($total_count) {
    $this->_total_count = $total_count;
  }
  
  /**
   * This sets the size for the number of items to be displayed.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param integer $size
   *   - integer containing the size.
   */
  public function setSize($size) {
    $this->_size = $size;
  }
  
  /**
   * This sets the offset for the start of the displayed list.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param integer $offset
   *   - integer containing the offset.
   */
  public function setOffset($offset) {
    $this->_offset = $offset;
  }
  
  /**
   * This sets the ordinal for the column sorted on.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $ordinal
   *   - string containing the ordinal column.
   */
  public function setOrdinal($ordinal) {
    $this->_ordinal = $ordinal;
  }
  
  /**
   * This sets the direction for the sort.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $direction
   *   - string containing the sort direction.
   */
  public function setDirection($direction) {
    $this->_direction = $direction;
  }
  
  /**
   * This sets the callback for the re-displaying of the list
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $callback
   *   - string containing the callback function used to handle the re-display.
   */
  public function setCallback($callback) {
    if (isset($callback) && $callback !== '') {
      $this->_callback = $callback;
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
   * This sets the type for the pagination.
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param string $type
   *   - string containing the type.
   */
  public function setType($type) {
    $this->_type = $type;
  }
  
  /**
   * This sets all the members in one hit
   * @author Damien Whaley <damien@whalebonestudios.com>
   * @param integer $total_count
   *   - integer containing the total number of items.
   * @param integer $size
   *   - integer containing the offset.
   * @param integer $offset
   *   - integer containing the offset.
   * @param string $ordinal
   *   - string containing the ordinal column.
   * @param string $direction
   *   - string containing the sort direction.
   * @param string $language_code
   *   - string containing the language code.
   * @param string $type
   *   - string containing the type of the pagination.
   * @param string $callback
   *   - string containing the callback for the redisplay of the list.
   */
  public function setAll($total_count, $size, $offset, $ordinal, $direction,
    $language_code, $type, $callback) {
    $this->setTotalCount($total_count);
    $this->setSize($size);
    $this->setOffset($offset);
    $this->setOrdinal($ordinal);
    $this->setDirection($direction);
    $this->setLanguageCode($language_code);
    $this->setType($type);
    $this->setCallback($callback);
  }
}
