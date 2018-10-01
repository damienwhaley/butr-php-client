<?php 
/*
 * Butr Universal Travel Reservations
 * A bleeding edge business management system for the travel industry.
 *
 * Copyright (C) 2012 Whalebone Studios and contributors.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 *  published by the Free Software Foundation, either version 3 of the
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

// Include and requires.
require_once('includes/butr.inc');
require_once('includes/cookies.inc');

$language_code = isset($_POST['language']) ? $_POST['language'] : Butr\DEFAULT_LANGUAGE; // or read from butrSession json object
$action_mode = '';
$window_name = (isset($_POST['window_name'])) ? $_POST['window_name'] : '';
$session_token = fetchSessionCookie($window_name);

$message_uuid = '';
$message_uuid = (isset($_POST['uuid'])) ? $_POST['uuid'] : '';
if ($message_uuid === '' && isset($_GET['uuid'])) {
  $message_uuid = $_GET['uuid'];
}

$butr_authentication = new Butr\Authentication();
$butr_authentication->setSessionToken($session_token);

// Instantiate page fragment class for templated presentation.
$butr_page_fragment = new Butr\PageFragment();

// Generate the top part of the page fragment including buffering output.
$butr_page_fragment->generateHtmlTop(array('system_message.js'), array('system_message.css'), $language_code);

if (isset($_POST['a'])) {
  switch ($_POST['a']) {
    case 'add':
      echo "<script type=\"text/javascript\">setHistorySystemMessageAdd();</script>\n";
      $action_mode = 'add';
      break;
    case 'fetch':
      $action_mode = 'fetch';
      break;
    case 'list':
      $action_mode = 'list';
      break;
    default:
      echo "<script type=\"text/javascript\">setHistorySystemMessage();</script>\n";
      $action_mode = '';
      break;
  }
} else {
  // Same as default in the switch case above.
  echo "<script type=\"text/javascript\">setHistorySystemMessage();</script>\n";
  $action_mode = '';
}
 
if ($action_mode === 'add') {
  // Grab modules
  $butr_command = new Butr\CommandListModules();
  $butr_command->setAll(0, -1, Butr\SORT_DIRECTION_ASCENDING, Butr\SORT_ORDINAL_DEFAULT);
  $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
  $butr_command->prepareCommand();
  $json_modules = $butr_command->sendCommand();
  $json_object = json_decode($json_modules, false);
  $json_error = json_last_error();

  $module_option_list = array();
  if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
    for($i = 0; $i < sizeof($json_object->list_modules->items); $i++) {
      $module_option_list[] = "<option value=\""
        . htmlspecialchars($json_object->list_modules->items[$i]->uuid, ENT_COMPAT | ENT_HTML5, 'UTF-8')
        . "\">" . htmlspecialchars($json_object->list_modules->items[$i]->module_name, ENT_COMPAT | ENT_HTML5, 'UTF-8')
        . "</option>\n";
    }
  }
  unset($json_modules);
  unset($json_object);
  unset($butr_command);
?>
<h1><?php echo gettext('Message Administration'); ?></h1>
<div id="system_message_add_box">
  <fieldset form="system_message_add_form" name="system_message_add_fieldset" id="system_message_add_fieldset">
    <legend><?php echo gettext('Add Message'); ?></legend>
    <form name="system_message_add_form" method="post" onsubmit="javascript:return processSystemMessageAddForm();">
      <label for="module_uuid" id="module_uuid"><?php echo gettext('Module'); ?>:</label>
      <select name="module_uuid">
        <option value=""><?php echo gettext('Please Select'); ?></option>
<?php echo implode($module_option_list, "\n") ?>
      </select><br>
      <label for="message_name" id="message_name_label"><?php echo gettext('Message Name'); ?>:</label>
      <input type="text" name="message_name" id="message_name" value=""><br>
      <label for="magic" id="magic_label"><?php echo gettext('Magic'); ?>:</label>
      <input type="text" name="magic" id="magic" value=""><br>
      <label for="description" id="description_label"><?php echo gettext('Description'); ?>:</label>
      <textarea name="description" id="description"></textarea><br>
      <label for="is_active" id="is_active_label"><?php echo gettext('Is Active'); ?>:</label>
      <input type="checkbox" name="is_active" id="is_active" value="1" checked><br>
      <label for="submit">&nbsp;</label>
      <button type="submit" name="submit" id="submit"><?php echo gettext('Add Message'); ?></button>      
    </form>
  </fieldset>
</div><!-- /#system_message_add_box -->

<?php
} elseif ($action_mode === 'fetch') {
  // Grab modules
  $butr_command = new Butr\CommandListModules();
  $butr_command->setAll(0, -1, Butr\SORT_DIRECTION_ASCENDING, Butr\SORT_ORDINAL_DEFAULT);
  $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
  $butr_command->prepareCommand();
  $json_modules = $butr_command->sendCommand();
  $json_object = json_decode($json_modules, false);
  $json_error = json_last_error();

  $module_option_list = array();
  if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
    for($i = 0; $i < sizeof($json_object->list_modules->items); $i++) {
      $module_option_list[] = "<option value=\""
        . htmlspecialchars($json_object->list_modules->items[$i]->uuid, ENT_COMPAT | ENT_HTML5, 'UTF-8')
        . "\">" . htmlspecialchars($json_object->list_modules->items[$i]->module_name, ENT_COMPAT | ENT_HTML5, 'UTF-8')
        . "</option>\n";
    }
  }
  unset($json_modules);
  unset($json_object);
  unset($butr_command);
  
  // Fetch message
  $butr_command = new Butr\CommandFetchMessage();
  $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
  $butr_command->setUuid($message_uuid);
  $butr_command->prepareCommand();
  $json_message = $butr_command->sendCommand();
  $json_object = json_decode($json_message, false);
  $json_error = json_last_error();
  
  $message = array();
  if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
    $message['uuid'] = (isset($json_object->fetch_message->uuid)) ? $json_object->fetch_message->uuid : '';
    $message['module_uuid'] = (isset($json_object->fetch_message->module_uuid)) ? $json_object->fetch_message->module_uuid : '';
    $message['message_name'] = (isset($json_object->fetch_message->message_name)) ? $json_object->fetch_message->message_name : '';
    $message['magic'] = (isset($json_object->fetch_message->magic)) ? $json_object->fetch_message->magic : '';
    $message['description'] = (isset($json_object->fetch_message->description)) ? $json_object->fetch_message->description : '';
    $message['is_actve'] = (isset($json_object->fetch_message->is_active)) ? $json_object->fetch_message->is_active : '';
  
    // Escape output
    $message['uuid'] = htmlspecialchars($message['uuid'], ENT_COMPAT | ENT_HTML5, 'UTF-8');
    $message['module_uuid'] = htmlspecialchars($message['module_uuid'], ENT_COMPAT | ENT_HTML5, 'UTF-8');
    $message['message_name'] = htmlspecialchars($message['message_name'], ENT_COMPAT | ENT_HTML5, 'UTF-8');
    $message['magic'] = htmlspecialchars($message['magic'], ENT_COMPAT | ENT_HTML5, 'UTF-8');
    $message['description'] = htmlspecialchars($message['description'], ENT_NOQUOTES | ENT_HTML5, 'UTF-8');  
  }
  
  unset($json_message);
  unset($json_object);
  unset($butr_command);
?>
<h1><?php echo gettext('Message Administration'); ?></h1>
<div id="system_message_modify_box">
  <fieldset form="system_message_modify_form" name="system_message_modify_fieldset" id="system_message_modify_fieldset">
    <legend><?php echo gettext('Modify Message'); ?></legend>
    <form name="system_message_modify_form" method="post" onsubmit="javascript:return processSystemMessageModifyForm();">
      <label for="module_uuid" id="module_uuid"><?php echo gettext('Module'); ?>:</label>
      <select name="module_uuid">
        <option value=""><?php echo gettext('Please Select'); ?></option>
<?php echo implode($module_option_list, "\n") ?>
      </select><br>
      <label for="message_name" id="message_name_label"><?php echo gettext('Message Name'); ?>:</label>
      <input type="text" name="message_name" id="message_name" value="<?php echo $message['message_name']; ?>"><br>
      <label for="magic" id="magic_label"><?php echo gettext('Magic'); ?>:</label>
      <input type="text" name="magic" id="magic" value="<?php echo $message['magic']; ?>"><br>
      <label for="description" id="description_label"><?php echo gettext('Description'); ?>:</label>
      <textarea name="description" id="description"><?php echo $message['description']; ?></textarea><br>
      <label for="is_active" id="is_active_label"><?php echo gettext('Is Active'); ?>:</label>
      <input type="checkbox" name="is_active" id="is_active" value="1"<?php if ($message['is_actve'] == 1) { echo ' checked'; } ?>><br>
      <label for="submit">&nbsp;</label>
      <button type="submit" name="submit" id="submit"><?php echo gettext('Modify Message'); ?></button>
      <input type="hidden" name="uuid" value="<?php echo $message['uuid']; ?>">     
    </form>
  </fieldset>
</div><!-- /#system_message_modify_box -->

<script type="text/javascript">
  document.system_message_modify_form.module_uuid.value = '<?php echo $message['module_uuid']; ?>';
</script>
<?php
} elseif ($action_mode === 'list') {
  $alternate = true;
  $default_list_size = Butr\DEFAULT_LIST_SIZE;
  
  // Fetch global default_list_size configuration value
  $butr_command = new Butr\CommandFetchGlobalConfiguration();
  $butr_command->setMagic('default_list_size');
  $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
  $butr_command->setUuid($message_uuid);
  $butr_command->prepareCommand();
  $json_global_configuration = $butr_command->sendCommand();
  $json_object = json_decode($json_global_configuration, false);
  $json_error = json_last_error();
  
  if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
    $default_list_size = (isset($json_object->fetch_global_configuration->effective_setting)) ? $json_object->fetch_global_configuration->effective_setting : Butr\DEFAULT_LIST_SIZE;
  }
  
  unset($json_global_configuration);
  unset($json_object);
  unset($butr_command);
  
  $ordinal = isset($_POST['ordinal']) ? $_POST['ordinal'] : '';
  if ($ordinal === '') {
    $ordinal = isset($_GET['ordinal']) ? $_GET['ordinal'] : Butr\SORT_ORDINAL_DEFAULT;
  }
  $size = isset($_POST['size']) ? $_POST['size'] : -2;
  if ($size === -2) {
    $size = isset($_GET['size']) ? $_GET['size'] : $default_list_size;
  }
  $direction = isset($_POST['direction']) ? $_POST['direction'] : '';
  if ($direction === '') {
    $direction = isset($_GET['direction']) ? $_GET['direction'] : Butr\SORT_DIRECTION_ASCENDING;
  }
  $offset = isset($_POST['offset']) ? $_POST['offset'] : -1;
  if ($offset === -1) {
    $offset = isset($_GET['offset']) ? $_GET['offset'] : 0;
  }
  
  // Grab messages
  $butr_command = new Butr\CommandListMessages();
  $butr_command->setAll($offset, $size, $direction, $ordinal);
  $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
  $butr_command->prepareCommand();
  $json_messages = $butr_command->sendCommand();
  $json_object = json_decode($json_messages, false);
  $json_error = json_last_error();
  
  if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
    $total_count = $json_object->list_messages->total_count;
  }
  
  if ($total_count == '' || !isset($total_count)) {
    $total_count = 0;
  }
  
  $butr_pagination = new Butr\Pagination();
  $butr_pagination->setAll($total_count, $size, $offset, $ordinal, $direction, $language_code,
    Butr\PAGINATION_TYPE_PAGE, 'setHistorySystemMessageList');
  $butr_pagination->preparePagination();
?>
<h1><?php echo gettext('Message Administration'); ?></h1>
<table>
  <thead>
    <tr>
      <th><?php echo gettext('Message Name'); ?></th>
      <th><?php echo gettext('Action'); ?></th>
    </tr>
  </thead>
  <tbody>
<?php
if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
  for($i = 0; $i < sizeof($json_object->list_messages->items); $i++) {
?>
    <tr class="<?php echo ($alternate = !$alternate) ? 'odd' : 'even'; ?>">
      <td><?php echo htmlspecialchars($json_object->list_messages->items[$i]->message_name, ENT_COMPAT | ENT_HTML5, 'UTF-8'); ?></td>
      <td><button onclick="javascript:setHistorySystemMessageFetch('<?php echo htmlspecialchars($json_object->list_messages->items[$i]->uuid, ENT_COMPAT | ENT_HTML5, 'UTF-8'); ?>');"><?php echo gettext('Modify'); ?></button></td>
    </tr>
<?php
  }
}
unset($json_messages);
unset($json_object);
unset($butr_command);
?>  
  </tbody>
</table>
<?php
  $butr_pagination->generatePagination();
} else {
  $default_list_size = Butr\DEFAULT_LIST_SIZE;
  
  // Fetch global default_list_size configuration value
  $butr_command = new Butr\CommandFetchGlobalConfiguration();
  $butr_command->setMagic('default_list_size');
  $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
  $butr_command->setUuid($message_uuid);
  $butr_command->prepareCommand();
  $json_global_configuration = $butr_command->sendCommand();
  $json_object = json_decode($json_global_configuration, false);
  $json_error = json_last_error();
  
  if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
    $default_list_size = (isset($json_object->fetch_global_configuration->effective_setting)) ? $json_object->fetch_global_configuration->effective_setting : Butr\DEFAULT_LIST_SIZE;
  }
  
  unset($json_global_configuration);
  unset($json_object);
  unset($butr_command);
?>
<h1><?php echo gettext('Message Administration'); ?></h1>
<ul>
  <li><a href="javascript:insertPageFragment('system_message.php?a=add')"><?php echo gettext('Add Message'); ?></a></li>
  <li><a href="javascript:setHistorySystemMessageList(0, '<?php echo $default_list_size; ?>', '<?php echo Butr\SORT_ORDINAL_DEFAULT; ?>', '<?php echo Butr\SORT_DIRECTION_ASCENDING; ?>');"><?php echo gettext('List Messages'); ?></a></li>
</ul>
<?php
}
// Generate bottom part of the page including flushing the buffer.
$butr_page_fragment->generateHtmlBottom();