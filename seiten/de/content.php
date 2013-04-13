<?php
require_once '../../config/init.inc.php';

/* Alle Seiteninhalte aus pages-Tabelle bis id 4 */
$id = $_GET['id'];
$cnt = $_GET['cnt'];
$tabelle = $_GET['table'];

$query = 'select * from ' . $tabelle . ' where id=' . $id;
$siteInfos = $db->getRow($query);
/* var_dump($siteInfos);*/

if ($cnt == 'content') {
    print $siteInfos->content;
}

if ($cnt == 'backgroundImage') {
    print $siteInfos->backgroundImage;
}

if ($cnt == 'backgroundColor') {
    print $siteInfos->backgroundColor;
}
?>