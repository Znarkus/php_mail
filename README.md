# php_mail

Another PHP mail wrapper lib


## Install

Clone and init submodules.

	git clone --recursive git://github.com/Znarkus/php_mail.git


## Basic usage

	require 'lib/abstract.php';
	require 'lib/swift.php';
	require 'lib/factory.php';

	$factory = new Lib\Mail_Factory('swift', 
		array('host' => '127.0.0.1', 'port' => 25, 'from' => array('address' => 'markus@example.com', 'name' => 'Markus')
	);

	$factory->create()
		->subject('Testing')->body("Body\nNew line")->to('jane@example.com')->send();


## Templating

Templates could be stored in files and loaded with [file_get_contents()](http://php.net/manual/en/function.file-get-contents.php),
or with some template engine.

	$tpl = "
	SUBJECT
	This is the subject

	PLAIN BODY
	This is the mail body
	spanning
	multiple lines.
	";

	$factory->create()
		->template($tpl)->to('markus@example.com')->send();


## License

Copyright 2012, Markus Hedlund, [Snowfire](snowfireit.com)
Licensed under the MIT License.
Redistributions of files must retain the above copyright notice.