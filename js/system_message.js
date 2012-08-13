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
 * This set the message history to allow back/forwards buttons. This is for the
 * system message administration add message page.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function setHistorySystemMessageAdd() {
  'use strict';
  
  var historyState = {};
  var content = '';
  historyState.pageUrl = 'system_message.php';
  historyState.pageAttributes = 'a=add';
  historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_MessageAdministration+' | '+butr_i18n_AddMessage;
  
  content = '?page=' + historyState.pageUrl + '&' + historyState.pageAttributes;

  // Remove trailing ampersand
  if (content.charAt(content.length - 1) === '&') {
	content = content.substring(0, content.length - 1);
  }
  
  document.title = historyState.pageTitle;
  $('#title').html(butr_i18n_MessageAdministration+' - '+butr_i18n_AddMessage);
  document.butr_state_form.content.value = content;
  History.pushState(historyState, historyState.pageTitle, content);
}

/**
 * This set the message history to allow back/forwards buttons. This is for the
 * system messsage administration add message page.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param uuid
 *   - string containing the uuid of the message record.
 */
function setHistorySystemMessageFetch(uuid) {
  'use strict';
  
  var historyState = {};
  var content = '';
  historyState.pageUrl = 'system_message.php';
  historyState.pageAttributes = 'a=fetch&uuid=' + uuid;
  historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_MessageAdministration+' | '+butr_i18n_ModifyMessage;
  
  content = '?page=' + historyState.pageUrl + '&' + historyState.pageAttributes;

  // Remove trailing ampersand
  if (content.charAt(content.length - 1) === '&') {
	content = content.substring(0, content.length - 1);
  }
  
  document.title = historyState.pageTitle;
  $('#title').html(butr_i18n_MessageAdministration+' - '+butr_i18n_ModifyMessage);
  document.butr_state_form.content.value = content;
  History.pushState(historyState, historyState.pageTitle, content);
}

/**
 * This set the message history to allow back/forwards buttons. This is for the
 * message administration list message page.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param offset
 *   - integer containing the segment to display.
 * @param size
 *   - integer containing the number of results per offset.
 * @param ordinal
 *   - string containing the field ordinal to order results on.
 * @param direction
 *   - string containing the direction of sorting.
 */
function setHistorySystemMessageList(offset, size, ordinal, direction) {
  'use strict';
  
  if (offset === undefined || offset === null || isNaN(offset)) {
	offset = 0;
  }
  
  if (size === undefined || size === null || isNaN(size)) {
	size = 20;
  }
  
  if (ordinal === undefined || ordinal === null || ordinal === '') {
	ordinal = 'default';
  }
  
  if (direction === undefined || direction === null || direction === '') {
	direction = 'ascending';
  }
  
  var content = '';
  var historyState = {};
  historyState.pageUrl = 'system_message.php';
  historyState.pageAttributes = 'a=list&offset=' + escape(offset) + '&size=' + escape(size) + '&ordinal=' + escape(ordinal) + '&direction=' + escape(direction);
  historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_MessageAdministration+' | '+butr_i18n_ListMessages;
  
  content = '?page=' + historyState.pageUrl + '&' + historyState.pageAttributes;

  // Remove trailing ampersand
  if (content.charAt(content.length - 1) === '&') {
	  content = content.substring(0, content.length - 1);
  }
  
  document.title = historyState.pageTitle;
  $('#title').html(butr_i18n_MessageAdministration  + ' - ' + butr_i18n_ListMessages);
  document.butr_state_form.content.value = content;
  History.pushState(historyState, historyState.pageTitle, content);
}

/**
 * This checks the message form to ensure that the form has sensible information.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function processSystemMessageAddForm() {
  'use strict';
  
  var errorMessage = '';
  var moduleUuid = document.system_message_add_form.module_uuid.value;
  var messageName = document.system_message_add_form.message_name.value;
  var magic = document.system_message_add_form.magic.value;
  var description = document.system_message_add_form.description.value;
  var isActive = 0;
  if (document.system_message_add_form.is_active.checked === true) {
	isActive = 1;  
  }
  
  $('#error').modal('hide');
  $('#warning').modal('hide');
  $('#notice').modal('hide');
  $('#debug').modal('hide');
  
  document.system_message_add_form.submit.disabled = true;
  
  if (moduleUuid === undefined || moduleUuid === null || moduleUuid === '') {
    errorMessage += '<br>* '+butr_i18n_Module;
  }
  if (messageName === undefined || messageName === null || messageName === '') {
	  errorMessage += '<br>* '+butr_i18n_MessageName;
  }
  if (magic === undefined || magic === null || magic === '') {
    magic = '';
  }
  if (description === undefined || description === null || description === '') {
    description = '';
  }
  
  if (errorMessage !== '') {
    $('#notice_message').html(butr_i18n_PleaseCheckThatYouHaveCompleted+':'+errorMessage);
    $('#notice').modal('show');
    document.system_message_add_form.submit.disabled = false;
    return false;
  }
  
  var form_body = '';
   
  form_body = 'module_uuid=' + escape(moduleUuid)
    + '&message_name=' + escape(messageName)
    + '&magic=' + escape(magic)
    + '&description=' + escape(description)
    + '&is_active=' + escape(isActive)
    + '&command=add_message'
    + '&window_name=' + escape(window.name);
    
  $.ajax({
    url: 'ajax/system_message.php',
    data: form_body,
    type: 'POST',
    contentType: 'application/x-www-form-urlencoded',
    success: function(data, textStatus, jqXHR) {
      'use strict';
      
      try {
        processSystemMessageAddResponse(JSON.parse(jqXHR.responseText));
      } catch (e) {
        handleSystemMessageAddError(jqXHR.responseText);
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      'use strict';
      
      handleSystemMessageAddError(jqXHR.responseText);
    }
  });
  
  return false;
}

/**
 * This function handles the login and then posts to the next system screen.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param res
 *   - object containing the JSON response from the Butr server.
 */
function processSystemMessageAddResponse(res) {
  'use strict';
  
  var responseStatus = '';
  var explanation = '';
  var messageUuid = '';

  if (res === undefined || res === null || typeof(res) !== 'object') {
    return handleSystemMessageAddError(res);
  }
  
  if (res.result !== undefined) {
    if (res.result.status !== undefined && res.result.status !== null && res.result.status !== '') {
      responseStatus = res.result.status ;
    }
  }
  
  if (res.add_message !== undefined) {
    if (res.add_message.uuid !== undefined && res.add_message.uuid !== null && res.add_message.uuid !== '') {
      messageUuid = res.add_message.uuid;
    }
  }
  
  if (responseStatus === 'OK' && messageUuid !== '') {
	setHistorySystemMessageFetch(messageUuid);
    return;
  }

  return handleSystemMessageAddError(res);
}

/**
 * This checks the message form to ensure that the form has sensible information.
 * @author Damien Whaley <damien@whalebonestudios.com>
 */
function processSystemMessageModifyForm() {
  'use strict';
  
  var errorMessage = '';
  var uuid = document.system_message_modify_form.uuid.value;
  var moduleUuid = document.system_message_modify_form.module_uuid.value;
  var messageName = document.system_message_modify_form.message_name.value;
  var magic = document.system_message_modify_form.magic.value;
  var description = document.system_message_modify_form.description.value;
  var isActive = 0;
  if (document.system_message_modify_form.is_active.checked === true) {
	isActive = 1;  
  }
  
  $('#error').modal('hide');
  $('#warning').modal('hide');
  $('#notice').modal('hide');
  $('#debug').modal('hide');
  
  document.system_message_modify_form.submit.disabled = true;
  
  if (uuid === undefined || uuid === null || uuid === '') {
    errorMessage += '<br>* '+butr_i18n_Uuid;
  }
  if (moduleUuid === undefined || moduleUuid === null || moduleUuid === '') {
    errorMessage += '<br>* '+butr_i18n_Module;
  }
  if (messageName === undefined || messageName === null || messageName === '') {
	  errorMessage += '<br>* '+butr_i18n_MessageName;
  }
  if (magic === undefined || magic === null || magic === '') {
    magic = '';
  }
  if (description === undefined || description === null || description === '') {
    description = '';
  }
  
  if (errorMessage !== '') {
    $('#notice_message').html(butr_i18n_PleaseCheckThatYouHaveCompleted+':'+errorMessage);
    $('#notice').modal('show');
    document.system_message_modify_form.submit.disabled = false;
    return false;
  }
  
  var form_body = '';
   
  form_body = 'uuid=' + escape(uuid)
	+ '&module_uuid=' + escape(moduleUuid)
    + '&message_name=' + escape(messageName)
    + '&magic=' + escape(magic)
    + '&description=' + escape(description)
    + '&is_active=' + escape(isActive)
    + '&command=modify_message'
    + '&window_name=' + escape(window.name);
    
  $.ajax({
    url: 'ajax/system_message.php',
    data: form_body,
    type: 'POST',
    contentType: 'application/x-www-form-urlencoded',
    success: function(data, textStatus, jqXHR) {
      'use strict';
      
      try {
        processSystemMessageModifyResponse(JSON.parse(jqXHR.responseText));
      } catch (e) {
        handleSystemMessageModifyError(jqXHR.responseText);
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      'use strict';
      
      handleSystemMessageModifyError(jqXHR.responseText);
    }
  });
  
  return false;
}

/**
 * This function handles the login and then posts to the next system screen.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param res
 *   - object containing the JSON response from the Butr server.
 */
function processSystemMessageModifyResponse(res) {
  'use strict';
  
  var responseStatus = '';
  var explanation = '';
  var messageUuid = '';

  if (res === undefined || res === null || typeof(res) !== 'object') {
    return handleSystemMessageModifyError(res);
  }
  
  if (res.result !== undefined) {
    if (res.result.status !== undefined && res.result.status !== null && res.result.status !== '') {
      responseStatus = res.result.status ;
    }
  }
  
  if (res.modify_message !== undefined) {
    if (res.modify_message.uuid !== undefined && res.modify_message.uuid !== null && res.modify_message.uuid !== '') {
      messageUuid = res.modify_message.uuid;
    }
  }
  
  if (responseStatus === 'OK' && messageUuid !== '') {
    // refresh view to be the view message and get it to pop a message to say message
    // was modified.
    
    alert('Message wth UUID = ' + messageUuid + ' was modified.');
    
    document.system_message_modify_form.submit.disabled = false;
    
    return;
  }

  return handleSystemMessageModifyError(res);
}

/**
 * This handles any errors and displays them in an error div.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param res
 *   - object or string containing the response from the server.
 */
function handleSystemMessageAddError(res) {
  'use strict';
  
  var responseStatus = '';
  var explanation = '';
  
  try {
    res = JSON.parse(res);
  }
  catch (e) {
    // Do nothing.
  }

  if (res !== null && res !== undefined && typeof(res) === 'object') {
    if (res.result !== undefined) {
      if (res.result.status !== undefined && res.result.status !== null && res.result.status !== '') {
        responseStatus = res.result.status ;
      }
    }

    if (responseStatus !== 'OK') {
      if (res.result !== undefined) {
        if (res.result.explanation !== undefined && res.result.explanation !== null && res.result.explanation !== '') {
          explanation = res.result.explanation;
        }
      }
    }
  }
  
  if (explanation === '') {
    explanation = butr_i18n_CouldNotAddMessage+'.';
  }

  if (responseStatus !== 'OK') {
    $('#error_message').html(explanation);
    $('#error').modal('show');
  }
  
  document.system_message_add_form.submit.disabled = false;
}

/**
 * This handles any errors and displays them in an error div.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param res
 *   - object or string containing the response from the server.
 */
function handleSystemMessageModifyError(res) {
  'use strict';
  
  var responseStatus = '';
  var explanation = '';
  
  try {
    res = JSON.parse(res);
  }
  catch (e) {
    // Do nothing.
  }

  if (res !== null && res !== undefined && typeof(res) === 'object') {
    if (res.result !== undefined) {
      if (res.result.status !== undefined && res.result.status !== null && res.result.status !== '') {
        responseStatus = res.result.status ;
      }
    }

    if (responseStatus !== 'OK') {
      if (res.result !== undefined) {
        if (res.result.explanation !== undefined && res.result.explanation !== null && res.result.explanation !== '') {
          explanation = res.result.explanation;
        }
      }
    }
  }
  
  if (explanation === '') {
    explanation = butr_i18n_CouldNotModifyMessage+'.';
  }

  if (responseStatus !== 'OK') {
    $('#error_message').html(explanation);
    $('#error').modal('show');
  }
  
  document.system_message_modify_form.submit.disabled = false;
}