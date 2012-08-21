<?php

require '_init.php';

$factory->create()
	->subject('Testing')->body("Body\nNew line")->to('jane@example.com')->send();