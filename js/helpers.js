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
 * This hides all the modal messages and alert messages.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function hideAllModalsAndAlerts() {
  'use strict';
  
  $('#error_modal').modal('hide');
  $('#warning_modal').modal('hide');
  $('#notice_modal').modal('hide');
  $('#debug_modal').modal('hide');
  $('#success_alert').hide();
  $('#warning_alert').hide();
  $('#info_alert').hide();
  $('#error_alert').hide();
}

/**
 * This disables a button and lightens it.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param sel
 *   - This is the DOM selector
 */
function disableButton(sel) {
  'use strict';
  
  var btn = $(sel);
  
  if (btn !== undefined && btn !== null) {
	btn.addClass('disabled');
	btn.prop('disabled', 'disabled');
  }
}

/**
 * This disables a button and lightens it.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param sel
 *   - This is the DOM selector
 */
function enableButton(sel) {
  'use strict';
  
  var btn = $(sel);
  
  if (btn !== undefined && btn !== null) {
	btn.removeProp('disabled', 'disabled');
	btn.removeClass('disabled');
  }
}

/**
 * This checks if a given button is disabled
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param sel
 *   - This is the DOM selector
 * @returns {Boolean}
 *   - true if disabled, false if not
 */
function isButtonDisabled(sel) {
  'use strict';
  
  var btn = $(sel);
  
  if (btn !== undefined && btn !== null) {
	if (btn.prop('disabled') !== undefined
	  && btn.prop('disabled') !== null
	  && btn.prop('disabled') === 'disabled') {
	  return true;
	}  
  }
  
  return false;
}

/**
 * This sets the titles for the page and fragment. This is called
 * just in case the fragment load has not set the titles.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function setTitles() {
  'use strict';
    
  if (document.butr_state_form.page_title.value !== undefined
    && document.butr_state_form.page_title.value !== null
    && document.butr_state_form.page_title.value !== '') {
    document.title = document.butr_state_form.page_title.value;
  }
  if (butr_state_form.fragment_title.value !== undefined
	&& butr_state_form.fragment_title.value !== null
	&& butr_state_form.fragment_title.value !== '') {
    $('#page-title').html(butr_state_form.fragment_title.value);
  }
}