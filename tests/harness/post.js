function doPost(t, d) {
  ' use strict';
  
  var url = '';
  var contentType = '';
  var body = '';
  
  $('#targetout').html('');
  $('#targetstatus').html('');
  
  switch(t) {
    case 'json':
      url = 'http://butr-server.node.local:3000/json';
      contentType = 'application/json';
      break;
    case 'rest':
      url = 'http://butr-server.node.local:3000/rest';
      contentType = 'text/xml';
      break;
    case 'soap':
      url = 'http://butr-server.node.local:3000/soap';
      contentType = 'text/xml';
      break;
    default:
      url = '';
      contentType = 'application/x-www-form-urlencoded';
  }
  
  body = 'url='+escape(url);
  body += '&contenttype='+escape(contentType);
  body += '&data='+escape(d);
  
  $.ajax({
    url: 'ajax.php',
    data: body,
    type: 'POST',
    contentType: 'application/x-www-form-urlencoded',
    success: function(data, textStatus, jqXHR) {
      $('#targetout').html(jqXHR.responseText.replace(/</g, '&lt;').replace(/>/g, '&gt;'));
      $('#targetstatus').html(jqXHR.status); },
    error: function(jqXHR, textStatus, errorThrown) {
      $('#targetout').html(jqXHR.responseText.replace(/</g, '&lt;').replace(/>/g, '&gt;'));
      $('#targetstatus').html(jqXHR.status);
    }
  });
}

function buildJsonMessage(apiKey, apiSecret, nonce, method, username, password, sessionToken, commandName) {
  'use strict';
  
  var message = {};
  message.authentication = {};
  if (typeof(apiKey) === 'string' && apiKey !== undefined && apiKey !== null && apiKey !== '') {
    message.authentication.api_key = apiKey;
  }
  if (typeof(apiSecret) === 'string' && apiSecret !== undefined && apiSecret !== null && apiSecret !== '') {
    message.authentication.api_secret = Crypto.util.bytesToHex(Crypto.HMAC(Crypto.SHA256, apiSecret, nonce, { asBytes: true }));
  }
  if (typeof(nonce) === 'string' && nonce !== undefined && nonce !== null && nonce !== '') {
    message.authentication.nonce = nonce;
  }
  if (typeof(method) === 'string' && method !== undefined && method !== null && method !== ''){
    message.authentication.method = method;
  }
  if (typeof(username) === 'string' && username !== undefined && username !== null && username !== '') {
    message.authentication.username = username;
  }
  if (typeof(password) === 'string' && password !== undefined && password !== null && password !== '') {
    message.authentication.password = Crypto.util.bytesToHex(Crypto.HMAC(Crypto.SHA256, Crypto.util.bytesToHex(Crypto.HMAC(Crypto.SHA256, username, password, { asBytes: true })), nonce, { asBytes: true }));
  }
  if (typeof(sessionToken) === 'string' && sessionToken !== undefined && sessionToken !== null && sessionToken !== '') {
    message.authentication.session_token = sessionToken;
  }
  
  // Create message here.
  switch (commandName) {
  case 'ping':
    message.ping = {};
    message.ping.content = 'Did Greedo shoot first?';
    break;
  case 'create_session':
    message.create_session = {};
    message.create_session.language = 'en-AU';
    break;
  default:
    message.message_name = {};
    break;
  }
  
  return JSON.stringify(message);
}
