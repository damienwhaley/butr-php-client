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
 * Generates a Universally Unique IDentifier, version 4.
 * This function generates a truly random UUID. The built in CakePHP String::uuid() function
 * is not cryptographically secure. You should uses this function instead.
 * @author Sean Colombo <sean@seancolombo.com>
 * @see http://tools.ietf.org/html/rfc4122#section-4.4
 * @see http://en.wikipedia.org/wiki/UUID
 * @see http://www.php.net/manual/en/function.uniqid.php#88023
 * @return string A UUID, made up of 32 hex digits and 4 hyphens.
 */
function uuidSecure() {
 
  $pr_bits = null;
  $fp = @fopen('/dev/urandom','rb');
  if ($fp !== false) {
      $pr_bits .= @fread($fp, 16);
      @fclose($fp);
  } else {
      // If /dev/urandom isn't available (eg: in non-unix systems), use mt_rand().
      $pr_bits = "";
      for($cnt=0; $cnt < 16; $cnt++){
          $pr_bits .= chr(mt_rand(0, 255));
      }
  }
 
  $time_low = bin2hex(substr($pr_bits,0, 4));
  $time_mid = bin2hex(substr($pr_bits,4, 2));
  $time_hi_and_version = bin2hex(substr($pr_bits,6, 2));
  $clock_seq_hi_and_reserved = bin2hex(substr($pr_bits,8, 2));
  $node = bin2hex(substr($pr_bits,10, 6));
 
  /**
   * Set the four most significant bits (bits 12 through 15) of the
   * time_hi_and_version field to the 4-bit version number from
   * Section 4.1.3.
   * @see http://tools.ietf.org/html/rfc4122#section-4.1.3
   */
  $time_hi_and_version = hexdec($time_hi_and_version);
  $time_hi_and_version = $time_hi_and_version >> 4;
  $time_hi_and_version = $time_hi_and_version | 0x4000;
 
  /**
   * Set the two most significant bits (bits 6 and 7) of the
   * clock_seq_hi_and_reserved to zero and one, respectively.
   */
  $clock_seq_hi_and_reserved = hexdec($clock_seq_hi_and_reserved);
  $clock_seq_hi_and_reserved = $clock_seq_hi_and_reserved >> 2;
  $clock_seq_hi_and_reserved = $clock_seq_hi_and_reserved | 0x8000;
 
  return sprintf('%08s-%04s-%04x-%04x-%012s',
      $time_low, $time_mid, $time_hi_and_version, $clock_seq_hi_and_reserved, $node);
}

/**
 * Checks to see if the UUID is valid.
 * @author 
 * @see http://drupalcontrib.org/api/drupal/contributions!uuid!uuid.module/function/uuid_is_valid/6
 * @param string $uuid
 */
function uuidIsValid($uuid) {
  return (boolean) preg_match('/^[A-Fa-f0-9]{8}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{12}$/', $uuid);
}