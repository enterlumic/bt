<?php
function load_preview()
{
    $dir = explode("/", __DIR__);
	array_pop($dir);
	$dir = implode("/", $dir);
	require_once($dir . '/views/modal_preview_uploader.php');
}
?>