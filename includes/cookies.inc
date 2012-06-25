<?php
/**
 * This sets the session cookie for the given session token for life of the
 * window/browser being open. The actual session is managed by the server
 * and this is just a pointer to the session for the given tab.
 * @author Damien Whaley <damien@whalebonestudios.com>
 *   - String containing the name of the window (used to allow multiple windows
 *     each with different sessions).
 * @param string $session_token
 *   - String containing the UUID session token.
 */
function addSessionCookie($window_name, $session_token) {
  setcookie('Butr|'.$window_name, $session_token, 0, '/');
}

/**
 * This removes the session cookie and should boot you out of the system.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param string $window_name
 *   - String containing the name of the window (used to allow multiple windows
 *     each with different sessions).
 */
function removeSessionCookie($window_name) {
  setcookie('Butr|'.$window_name, '', -1);
}

/**
 * This fetches the session cookie.
 * @author Damien Whaley <damien@whalebonestudios.com>
 * @param string $window_name
 *   - String containing the name of the window (used to allow multiple windows
 *     each with different sessions).
 */
function fetchSessionCookie($window_name) {
  if (isset($_COOKIE['Butr|'.$window_name])) {
    return $_COOKIE['Butr|'.$window_name];
  }
  return '';
}
