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

/**
 * This creates a new cookie, or overrides it. This is adapted from the functions
 * at Quirksmode.
 * @author Scott Andrew <scottandrew@gmail.com>
 * @param name
 *   - String containing the name of the cookie.
 * @param value
 *   - String containing the value of the cookie.
 * @param days
 *   - Number containing the number of minutes the cookie lives for.
 * @see http://www.quirksmode.org/js/cookies.html
 */
function createCookie(name, value, minutes) {
  'use strict';
  
  if (minutes !== undefined && minutes !== null && !isNaN(minutes)) {
    var date = new Date();
    date.setTime(date.getTime()+(minutes*60*1000));
    var expires = '; expires='+date.toGMTString();
  }
  else {
    var expires = '';
  }
  document.cookie = name+'='+value+expires+'; path=/';
}

/**
 * This reads a given cookie. This is adapted from the functions at
 * Quirksmode.
 * @author Scott Andrew <scottandrew@gmail.com>
 * @param name
 *   - String containing the name of the cookie.
 * @returns
 *   - String containing the contents of the cookie.
 * @see http://www.quirksmode.org/js/cookies.html
 */
function readCookie(name) {
  'use strict';
  
  var nameEQ = name + '=';
  var ca = document.cookie.split(';');
  for(var i=0;i < ca.length;i++) {
    var c = ca[i];
    while (c.charAt(0) === ' ') {
      c = c.substring(1, c.length);
    }
    if (c.indexOf(nameEQ) === 0) {
      return c.substring(nameEQ.length,c.length);
    }
  }
  return null;
}

/**
 * This reases the given cookie. This is adapted from the functions at
 * Quirksmode.
 * @author Scott Andrew <scottandrew@gmail.com>
 * @param name
 *   - String containing the name of the cookie.
 * @see http://www.quirksmode.org/js/cookies.html
 */
function eraseCookie(name) {
  'use strict';
  
  createCookie(name, '', -1);
}