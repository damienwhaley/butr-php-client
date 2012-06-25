<?php
require_once('includes/butr.inc');

$butr_Pagination = new Butr\Pagination();

$offset = 0;

$butr_Pagination->setAll(599, 20, $offset, 'default', Butr\SORT_DIRECTION_ASCENDING, 'en_AU', 'page');
$butr_Pagination->preparePagination();
?>
<html>
  <head>
    <title>Pagination Test</title>
    <style type="text/css">
      div.pagination-page { border: solid 1px #bbbbbb; display: inline; padding: 2px; }
      div.pagination-page-active { border: solid 1px #bbbbbb; background-color: #bbbbbb; display: inline; padding: 2px; }
      div.pagination-padding-page { border: none; display: inline; padding: 2px; }
      a.pagination-link-page { text-decoration: none; }
      a.pagination-link-page:hover { text-decoration: underline; }
    </style>
  </head>
  <body>
<?php
$butr_Pagination->generatePagination();

$description = "This is my \"description\".";
$json = '{"authentication":{"session_token":"abc"},"message":{"description":"'.$description.'"}}';
echo $json . "<br>";
echo json_encode($json);

?>
  </body>
</html>