<?php

namespace Lib;

interface Mail_Interface
{
	public static function setup(array $parameters);
	public function template($template);
	public function subject($subject);
	public function from($address, $name = null);
	public function to($address, $name = null);
	public function body($message, $content_type = 'text/plain');
	public function send();
}