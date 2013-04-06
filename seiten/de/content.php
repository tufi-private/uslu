<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');
$serverStage = 'live';
if ($_SERVER['SERVER_NAME'] == 'localhost'){
    $serverStage= 'dev';
}

$config = require '../../config/config.php';
require_once '../../php_class/DBClient.php';
require_once '../../php_class/AssetHandler.php';

$db = new DBClient($config[$serverStage]['database']);
$WEBPATH = $config[$serverStage]['httpd']['path'];



	/* Alle Seiteninhalte aus pages-Tabelle bis id 4 */
	$id = $_GET['id'];
	$cnt = $_GET['cnt'];
	$tabelle = $_GET['table'];

		$query = 'select * from '.$tabelle.' where id='.$id;
		$siteInfos = $db->getRow($query);
		/* var_dump($siteInfos);*/
		
		if ($cnt=='content') {
			print $siteInfos->content;
		}
		
		if ($cnt=='backgroundImage') {
			print $siteInfos->backgroundImage;
		}
		
		if ($cnt=='backgroundColor') {
			print $siteInfos->backgroundColor;
		}
?>