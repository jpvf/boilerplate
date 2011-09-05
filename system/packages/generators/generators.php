<?php 

$load = Loader::getInstance();

$dir = __DIR__ . '/classes/';

$load->file($dir . 'files' . EXT);
$load->file($dir . 'sql' . EXT);