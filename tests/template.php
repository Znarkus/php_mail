<?php

require '_init.php';

$tpl = "
SUBJECT
Subject

PLAIN BODY
Line 1
Line 2
Line 3
";

$factory->create()
	->template($tpl)->to('jane@example.com')->send();