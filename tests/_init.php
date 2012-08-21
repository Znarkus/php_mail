<?php

date_default_timezone_set('Europe/Stockholm');

if ($argc < 3) {
	exit("Usage: {$argv[0]} host port [user] [pass]\n");
}

require '../lib/abstract.php';
require '../lib/swift.php';
require '../lib/factory.php';

$p = array(
	'host' => $argv[1],
	'port' => $argv[2],
	'from' => array('address' => 'john@example.com', 'name' => 'John')
);

if ($argc > 3) {
	$p['user'] = $argv[3];
	$p['pass'] = $argv[4];
}

$factory = new Lib\Mail_Factory('swift', $p);