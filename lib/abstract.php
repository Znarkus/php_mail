<?php

namespace Lib;

abstract class Mail_Abstract
{
	private $_parameters = array();
	
	/**
	* @return Mail_Abstract
	*/
	abstract public function send();
	public static function setup(array $parameters)
	{
		return $parameters;
	}
	
	public function parameters($key = null)
	{
		if ($key) {
			return $this->_parameters[$key];
		} else {
			return $this->_parameters;
		}
	}

	/**
	 * @return Mail_Abstract
	 */
	public function template($template)
	{
		preg_match('/\v*SUBJECT\v+(?<subject>.+)\v+(?<body_type>HTML|PLAIN) BODY\v+(?<body>.+)$/s', $template, $m);

		$this->subject($m['subject']);
		$this->body($m['body'], $m['body_type'] === 'HTML' ? 'text/html' : 'text/plain');

		return $this;
	}
	
	/**
	* @return Mail_Abstract
	*/
	public function subject($subject)
	{
		$this->_parameters['subject'] = $subject;
		return $this;
	}
	
	/**
	* @return Mail_Abstract
	*/
	public function from($address, $name = null)
	{
		if ($name) {
			$this->_parameters['from'] = array($address => $name);
		} else {
			$this->_parameters['from'] = $address;
		}
		
		return $this;
	}
	
	/**
	* @return Mail_Abstract
	*/
	public function to($address, $name = null)
	{
		if ($name) {
			$this->_parameters['to'] = array($address => $name);
		} else {
			$this->_parameters['to'] = $address;
		}
		
		return $this;
	}
	
	/**
	* @return Mail_Abstract
	*/
	public function body($message, $content_type = 'text/plain')
	{
		$this->_parameters['body'][$content_type] = $message;
		return $this;
	}
}