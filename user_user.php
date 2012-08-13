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

$user_uuid = '';
$user_uuid = (isset($_POST['uuid'])) ? $_POST['uuid'] : '';
if ($user_uuid === '' && isset($_GET['uuid'])) {
  $user_uuid = $_GET['uuid'];
}

$butr_authentication = new Butr\Authentication();
$butr_authentication->setSessionToken($session_token);

// Instantiate page fragment class for templated presentation.
$butr_pageTab = new Butr\PageTab();
$butr_pageFragment = new Butr\PageFragment();

// Grab user dock tabs
$butr_command = new Butr\CommandListUserDockTabs();
$butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
$butr_command->setMagic('user_user');
$butr_command->prepareCommand();
$json_user_tabs = $butr_command->sendCommand();
$json_object = json_decode($json_user_tabs, false);
$json_error = json_last_error();

if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
  $butr_pageTab->setAll($json_object->list_user_dock_tabs, $language);
}
unset($json_object);
unset($butr_command);

if (isset($_POST['a'])) {
  switch ($_POST['a']) {
    case 'add':
      $action_mode = 'add';
      break;
    case 'fetch':
      $action_mode = 'fetch';
      break;
    case 'list':
      $action_mode = 'list';
      break;
    default:
      echo "<script type=\"text/javascript\">setHistoryUserUser();</script>\n";
      $action_mode = '';
      break;
  }
} else {
  // Same as default in the switch case above.
  echo "<script type=\"text/javascript\">setHistoryUserUser();</script>\n";
  $action_mode = '';
}
 
if ($action_mode === 'add') {
  // Grab global title configuration settings
  $butr_command = new Butr\CommandListGlobalTitleConfigurations();
  $butr_command->setAll(0, -1, Butr\SORT_DIRECTION_ASCENDING, Butr\SORT_ORDINAL_DEFAULT);
  $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
  $butr_command->prepareCommand();
  $json_global_title_configurations = $butr_command->sendCommand();
  $json_object = json_decode($json_global_title_configurations, false);
  $json_error = json_last_error();

  $title_option_list = array();
  if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
    for($i = 0; $i < sizeof($json_object->list_global_title_configurations->items); $i++) {
      if (isset($json_object->list_global_title_configurations->items[$i]->display_label)) {
        $title_option_list[] = "<option value=\""
          . htmlspecialchars($json_object->list_global_title_configurations->items[$i]->uuid, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . "\">" . htmlspecialchars($json_object->list_global_title_configurations->items[$i]->display_label, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . "</option>\n";
      } else {
        $title_option_list[] = "<option value=\""
          . htmlspecialchars($json_object->list_global_title_configurations->items[$i]->uuid, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . "\">" . htmlspecialchars($json_object->list_global_title_configurations->items[$i]->name_label, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . "</option>\n";
      }
    }
  }
  unset($json_global_title_configurations);
  unset($json_object);
  unset($butr_command);

  // Grab global language configuration settings
  $butr_command = new Butr\CommandListGlobalLanguageConfigurations();
  $butr_command->setAll(0, -1, Butr\SORT_DIRECTION_ASCENDING, Butr\SORT_ORDINAL_DEFAULT);
  $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
  $butr_command->prepareCommand();
  $json_global_language_configurations = $butr_command->sendCommand();
  $json_object = json_decode($json_global_language_configurations, false);
  $json_error = json_last_error();

  $language_option_list = array();
  if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
    for($i = 0; $i < sizeof($json_object->list_global_language_configurations->items); $i++) {
      if (isset($json_object->list_global_language_configurations->items[$i]->display_label)) {
        $language_option_list[] = "<option value=\""
          . htmlspecialchars($json_object->list_global_language_configurations->items[$i]->uuid, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . "\">" . htmlspecialchars($json_object->list_global_language_configurations->items[$i]->display_label, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . "</option>\n";
      } else {
        $language_option_list[] = "<option value=\""
          . htmlspecialchars($json_object->list_global_language_configurations->items[$i]->uuid, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . "\">" . htmlspecialchars($json_object->list_global_language_configurations->items[$i]->language_name, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . "</option>\n";
      }
    }
  }
  unset($json_global_language_configurations);
  unset($json_object);
  unset($butr_command);
?>
<div id="user_user_add_box">
  <fieldset form="user_user_add_form" name="user_user_add_fieldset" id="user_user_add_fieldset">
    <legend><?php echo gettext('Add User'); ?></legend>
    <form name="user_user_add_form" method="post" onsubmit="javascript:return processUserUserAddForm();">
      <label for="global_title_uuid" id="global_title_uuid_label"><?php echo gettext('Title'); ?>:</label>
      <select name="global_title_uuid">
        <option value=""><?php echo gettext('Please Select'); ?></option>
<?php echo implode($title_option_list, "\n") ?>
      </select><br>
      <label for="first_name" id="first_name_label"><?php echo gettext('First Name'); ?>:</label>
      <input type="text" name="first_name" id="first_name" value=""><br>
      <label for="last_name" id="last_name_label"><?php echo gettext('Last Name'); ?>:</label>
      <input type="text" name="last_name" id="last_name" value=""><br>
      <label for="preferred_global_language_uuid" id="preferred_global_language_uuid_label"><?php echo gettext('Preferred Language'); ?>:</label>
      <select name="preferred_global_language_uuid">
        <option value=""><?php echo gettext('Please Select'); ?></option>
<?php echo implode($language_option_list, "\n") ?>
      </select><br>
      <label for="username" id="username_label"><?php echo gettext('Username'); ?>:</label>
      <input type="text" name="username" id="username" value=""><br>
      <label for="submit">&nbsp;</label>
      <button type="submit" name="submit" id="submit"><?php echo gettext('Add User'); ?></button>      
    </form>
  </fieldset>
</div><!-- /#user_user_add_box -->

<?php
} elseif ($action_mode === 'fetch') {
  // Grab global title configuration settings
  $butr_command = new Butr\CommandListGlobalTitleConfigurations();
  $butr_command->setAll(0, -1, Butr\SORT_DIRECTION_ASCENDING, Butr\SORT_ORDINAL_DEFAULT);
  $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
  $butr_command->prepareCommand();
  $json_global_title_configurations = $butr_command->sendCommand();
  $json_object = json_decode($json_global_title_configurations, false);
  $json_error = json_last_error();
  
$title_option_list = array();
  if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
    for($i = 0; $i < sizeof($json_object->list_global_title_configurations->items); $i++) {
      if (isset($json_object->list_global_title_configurations->items[$i]->display_label)) {
        $title_option_list[] = "<option value=\""
          . htmlspecialchars($json_object->list_global_title_configurations->items[$i]->uuid, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . "\">" . htmlspecialchars($json_object->list_global_title_configurations->items[$i]->display_label, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . "</option>\n";
      } else {
        $title_option_list[] = "<option value=\""
          . htmlspecialchars($json_object->list_global_title_configurations->items[$i]->uuid, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . "\">" . htmlspecialchars($json_object->list_global_title_configurations->items[$i]->name_label, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . "</option>\n";
      }
    }
  }
  unset($json_global_title_configurations);
  unset($json_object);
  unset($butr_command);
  
  // Grab global language configuration settings
  $butr_command = new Butr\CommandListGlobalLanguageConfigurations();
  $butr_command->setAll(0, -1, Butr\SORT_DIRECTION_ASCENDING, Butr\SORT_ORDINAL_DEFAULT);
  $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
  $butr_command->prepareCommand();
  $json_global_language_configurations = $butr_command->sendCommand();
  $json_object = json_decode($json_global_language_configurations, false);
  $json_error = json_last_error();
  
  $language_option_list = array();
  if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
    for($i = 0; $i < sizeof($json_object->list_global_language_configurations->items); $i++) {
      if (isset($json_object->list_global_language_configurations->items[$i]->display_label)) {
        $language_option_list[] = "<option value=\""
          . htmlspecialchars($json_object->list_global_language_configurations->items[$i]->uuid, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . "\">" . htmlspecialchars($json_object->list_global_language_configurations->items[$i]->display_label, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . "</option>\n";
      } else {
        $language_option_list[] = "<option value=\""
          . htmlspecialchars($json_object->list_global_language_configurations->items[$i]->uuid, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . "\">" . htmlspecialchars($json_object->list_global_language_configurations->items[$i]->language_name, ENT_COMPAT | ENT_HTML5, 'UTF-8')
          . "</option>\n";
      }
    }
  }
  unset($json_global_language_configurations);
  unset($json_object);
  unset($butr_command);
  
  // Fetch user
  $butr_command = new Butr\CommandFetchUser();
  $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
  $butr_command->setUuid($user_uuid);
  $butr_command->prepareCommand();
  $json_user = $butr_command->sendCommand();
  $json_object = json_decode($json_user, false);
  $json_error = json_last_error();
  
  $user = array();
  if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
    $user['uuid'] = (isset($json_object->fetch_user->uuid)) ? $json_object->fetch_user->uuid : '';
    $user['global_title_uuid'] = (isset($json_object->fetch_user->global_title_uuid)) ? $json_object->fetch_user->global_title_uuid : '';
    $user['first_name'] = (isset($json_object->fetch_user->first_name)) ? $json_object->fetch_user->first_name : '';
    $user['last_name'] = (isset($json_object->fetch_user->first_name)) ? $json_object->fetch_user->last_name : '';
    $user['preferred_global_language_uuid'] = (isset($json_object->fetch_user->preferred_global_language_uuid)) ? $json_object->fetch_user->preferred_global_language_uuid : '';
    $user['username'] = (isset($json_object->fetch_user->username)) ? $json_object->fetch_user->username : '';

    // Escpe output
    $user['uuid'] = htmlspecialchars($user['uuid'], ENT_COMPAT | ENT_HTML5, 'UTF-8');
    $user['global_title_uuid'] = htmlspecialchars($user['global_title_uuid'], ENT_COMPAT | ENT_HTML5, 'UTF-8');
    $user['first_name'] = htmlspecialchars($user['first_name'], ENT_COMPAT | ENT_HTML5, 'UTF-8');
    $user['last_name'] = htmlspecialchars($user['last_name'], ENT_COMPAT | ENT_HTML5, 'UTF-8');
    $user['preferred_global_language_uuid'] = htmlspecialchars($user['preferred_global_language_uuid'], ENT_COMPAT | ENT_HTML5, 'UTF-8');
    $user['username'] = htmlspecialchars($user['username'], ENT_COMPAT | ENT_HTML5, 'UTF-8');
  }
  unset($json_object);
  unset($butr_command);
?>
<div id="user_user_modify_box">
  <fieldset form="user_user_modify_form" name="user_user_modify_fieldset" id="user_user_modify_fieldset">
    <legend><?php echo gettext('Modify User'); ?></legend>
    <form name="user_user_modify_form" method="post" onsubmit="javascript:return processUserUserModifyForm();">
      <label for="global_title_uuid" id="global_title_uuid_label"><?php echo gettext('Title'); ?>:</label>
      <select name="global_title_uuid">
        <option value=""><?php echo gettext('Please Select'); ?></option>
<?php echo implode($title_option_list, "\n") ?>
      </select><br>
      <label for="first_name" id="first_name_label"><?php echo gettext('First Name'); ?>:</label>
      <input type="text" name="first_name" id="first_name"  value="<?php echo $user['first_name']; ?>"><br>
      <label for="last_name" id="last_name_label"><?php echo gettext('Last Name'); ?>:</label>
      <input type="text" name="last_name" id="last_name" value="<?php echo $user['last_name']; ?>"><br>
      <label for="preferred_global_language_uuid" id="preferred_global_language_uuid_label"><?php echo gettext('Preferred Language'); ?>:</label>
      <select name="preferred_global_language_uuid">
        <option value=""><?php echo gettext('Please Select'); ?></option>
<?php echo implode($language_option_list, "\n") ?>
      </select><br>
      <label for="username" id="username_label"><?php echo gettext('Username'); ?>:</label>
      <input type="text" name="username" id="username" value="<?php echo $user['username']; ?>"><br>
      <label for="submit">&nbsp;</label>
      <button type="submit" name="submit" id="submit"><?php echo gettext('Modify User'); ?></button>
      <input type="hidden" name="uuid" value="<?php echo $user['uuid']; ?>">
    </form>
  </fieldset>
</div><!-- /#user_user_modify_box -->

<script type="text/javascript">
  document.user_user_modify_form.global_title_uuid.value = '<?php echo $user['global_title_uuid']; ?>';
  document.user_user_modify_form.preferred_global_language_uuid.value = '<?php echo $user['preferred_global_language_uuid']; ?>';
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
  
  // Grab users
  $butr_command = new Butr\CommandListUsers();
  $butr_command->setAll($offset, $size, $direction, $ordinal);
  $butr_command->setAuthenticationSnippet($butr_authentication->generateSnippet());
  $butr_command->prepareCommand();
  $json_users = $butr_command->sendCommand();
  $json_object = json_decode($json_users, false);
  $json_error = json_last_error();
  
  if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
    $total_count = $json_object->list_users->total_count;
  }
  
  if ($total_count == '' || !isset($total_count)) {
    $total_count = 0;
  }
  
  $butr_pagination = new Butr\Pagination();
  $butr_pagination->setAll($total_count, $size, $offset, $ordinal, $direction, $language_code,
      Butr\PAGINATION_TYPE_PAGE, 'setHistoryUserUserList');
  $butr_pagination->preparePagination();
?>
<h1><?php echo gettext('User Administration'); ?></h1>
<table>
  <thead>
    <tr>
      <th><?php echo gettext('Title'); ?></th>
      <th><?php echo gettext('First Name'); ?></th>
      <th><?php echo gettext('Last Name'); ?></th>
      <th><?php echo gettext('Action'); ?></th>
    </tr>
  </thead>
  <tbody>
<?php
if ($json_error === JSON_ERROR_NONE && $json_object->result->status === 'OK') {
  for($i = 0; $i < sizeof($json_object->list_users->items); $i++) {
?>
    <tr class="<?php echo ($alternate = !$alternate) ? 'odd' : 'even'; ?>">
      <td><?php echo htmlspecialchars($json_object->list_users->items[$i]->title_label, ENT_COMPAT | ENT_HTML5, 'UTF-8'); ?></td>
      <td><?php echo htmlspecialchars($json_object->list_users->items[$i]->first_name, ENT_COMPAT | ENT_HTML5, 'UTF-8'); ?></td>
      <td><?php echo htmlspecialchars($json_object->list_users->items[$i]->last_name, ENT_COMPAT | ENT_HTML5, 'UTF-8'); ?></td>
      <td><button onclick="javascript:setHistoryUserUserFetch('<?php echo htmlspecialchars($json_object->list_users->items[$i]->uuid, ENT_COMPAT | ENT_HTML5, 'UTF-8'); ?>');"><?php echo gettext('Modify'); ?></button></td>
    </tr>
<?php
  }
}
unset($json_users);
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
  
  // Generate the top part of the page fragment including buffering output.
  $butr_pageTab->generateHtmlTab();
  $butr_pageFragment->generateHtmlTop(array('user_user.js'), null, $language_code);
?>
<div class="well">
	<hgroup>
		<h3 class="left"><?php echo gettext('User Information'); ?></h3>
		<ul class="actions">
			<li><a href="" class="icon-cross"></a></li>
			<li><a href="" class="icon-tick"></a></li>
			<li><a href="" class="icon-star"></a></li>
		</ul><!-- end .actions -->
	</hgroup>
	<div class="row-fluid">
		<div class="span8">
			<div class="col">
				<span class="lbl">Label</span>
				<span class="data">Label 1 data</span>
			</div><!-- end .col -->
			<div class="col">
				<span class="lbl">Label</span>
				<span class="data">Label 2 data</span>
			</div><!-- end .col -->
		</div><!-- end .span6 -->
	</div><!-- end .row -->
	<div class="row-fluid">
		<div class="span8">
			<div class="col">
				<span class="lbl">Label</span>
				<span class="data">Label 1 data</span>
			</div><!-- end .col -->
			<div class="col">
				<span class="lbl">Label</span>
				<span class="data">Label 2 data</span>
			</div><!-- end .col -->
		</div><!-- end .span6 -->
	</div><!-- end .row -->
	<div class="row-fluid">
		<div class="span8">
			<div class="col">
				<span class="lbl">Radio</span>
				<span class="data">Radio Button Selection</span>
			</div><!-- end .col -->
		</div><!-- end .span6 -->
	</div><!-- end .row -->
</div><!-- end .well -->

<div class="well" id="well-search-users">
  <h4 class="left"><?php echo gettext('Search Users'); ?></h4>
  <a href="javascript:void(0);" class="right show">Show / Hide</a>
  <div class="inner">
    <form class="form-inline">
    </form>
  </div><!-- end .inner -->
</div><!-- end .well -->

<div class="well" id="well-add-user">
  <h4 class="left"><?php echo gettext('Add User'); ?></h4>
  <a href="javascript:void(0);" class="right show">Show / Hide</a>
  <div class="inner">
    <form class="form-inline">
    </form>
  </div><!-- end .inner -->
</div><!-- end .well -->

<div class="well" id="well-edit-user">
  <h4 class="left"><?php echo gettext('Edit User'); ?></h4>
  <a href="javascript:void(0);" class="right show">Show / Hide</a>
  <div class="inner">
    <form class="form-inline">
    </form>
  </div><!-- end .inner -->
</div><!-- end .well -->


<ul>
  <li><a href="javascript:setHistoryUserUserAdd();"><?php echo gettext('Add User'); ?></a></li>
  <li><a href="javascript:setHistoryUserUserList(0, '<?php echo $default_list_size; ?>', '<?php echo Butr\SORT_ORDINAL_DEFAULT; ?>', '<?php echo Butr\SORT_DIRECTION_ASCENDING; ?>');"><?php echo gettext('List Users'); ?></a></li>
  <li><?php echo gettext('Search Users'); ?></li>
</ul>
<?php
  // Generate bottom part of the page including flushing the buffer.
  $butr_pageFragment->generateHtmlBottom();
}
