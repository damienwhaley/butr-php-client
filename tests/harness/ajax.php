<?php
/**
 * Really, this needs to be sanitised, but for the moment it will do.
 */

$responseCode = 0;
$output = '';

$url = isset($_POST['url']) ? $_POST['url'] : '';
$contentType = isset($_POST['contenttype']) ? $_POST['contenttype'] : 'application/x-www-form-urlencoded';
$data = isset($_POST['data']) ? $_POST['data'] : '';
$data = str_replace('\"', '"', $data);

if ($url === '' || $contentType === '' || $data === '') {
  if (contentType === 'application/json' || contentType === 'json') {
    $output = '{ "error": "Nothing for me to do, Dr. Jones!", "$url": "'.$url.'", "$contentType": "'.$contentType.'", "$data": "'.$data.'" }';
  } else {
    $output = 'Nothing for me to do, Dr. Jones!';    
  }
} else {
  $http = new HttpRequest($url, HttpRequest::METH_POST);
  $http->setContentType($contentType);
  $http->setBody($data);
  try {
    $http->send();
    $output = $http->getResponseBody();
    $responseCode = $http->getResponseCode();
  } catch (Exception $e) {
    $output = '';
    $responseCode = 0;
  }
}
header('', true, $responseCode);
echo '<pre>'.$output.'</pre>';
