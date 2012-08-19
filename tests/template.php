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

$mail = new \Lib\Mail_Swift();
$mail->template($tpl)->to('jane@example.com')->send();