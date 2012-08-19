<?php

date_default_timezone_set('Europe/Stockholm');

if ($argc < 3) {
	exit("Usage: {$argv[0]} host port [user] [pass]\n");
}

require '../lib/interface.php';
require '../lib/swift.php';

$p = array(
	'host' => $argv[1],
	'port' => $argv[2],
	'from' => array('address' => 'john@example.com', 'name' => 'John')
);

if ($argc > 3) {
	$p['user'] = $argv[3];
	$p['pass'] = $argv[4];
}

Lib\Mail_Swift::setup($p);
