<?php

require '_init.php';

$mail = new \Lib\Mail_Swift();
$mail->subject('Testing')->body("Body\nNew line")->to('jane@example.com')->send();