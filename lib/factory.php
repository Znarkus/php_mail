<?php

namespace Lib;

class Mail_Factory
{
	private $_adapter;
	private $_parameters;
	
	private static $_classes = array('swift' => '\Lib\Mail_Swift', 'mailtrap' => '\Lib\Mail_Mailtrap');
	
	public function __construct($adapter, $parameters = array())
	{
		$this->_adapter = $adapter;
		
		$class_name = self::$_classes[$adapter];
		$this->_parameters = $class_name::setup($parameters);
	}
	
	public function create()
	{
		$class_name = self::$_classes[$this->_adapter];
		$mail = new $class_name($this->_parameters);
		
		if (isset($this->_parameters['from'])) {
			$mail->from($this->_parameters['from']['address'], $this->_parameters['from']['name']);
		}
		
		return $mail;
	}
}