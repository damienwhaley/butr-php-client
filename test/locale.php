<?php
//namespace Butr;

$document_root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once($document_root . '/includes/settings.inc');

// I18N support information here
$language = 'en_AU.UTF-8';
putenv('LANG='.$language);
setlocale(LC_ALL, $language);

// Set the text domain as 'messages'
$domain = 'messages';
bindtextdomain($domain, $document_root . '/locale');
textdomain($domain);

echo gettext("A string to be translated would go here");

?>