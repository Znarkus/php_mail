<?php

namespace Lib;

require_once '../vendor/swift/lib/swift_required.php';

class Mail_Swift implements Mail_Interface
{
	/**
	* @var \Swift_Message
	*/
	private $_message;
	
	/**
	* @var \Swift_Mailer
	*/
	static private $_mailer;
	static private $_defaults = array();
	
	public function __construct()
	{
		$this->_message = new \Swift_Message();
		$this->from(self::$_defaults['from']['address'], self::$_defaults['from']['name']);
	}

	/**
	 * Parameters: from (address, name), host, port,
	 * @param array $parameters
	 */
	public static function setup(array $parameters)
	{
		$parameters = array_merge(array(
			'host' => '127.0.0.1',
			'port' => 25
		), $parameters);

		\Swift::init(function () {
			\Swift_DependencyContainer::getInstance()
				->register('mime.qpcontentencoder')
				->asAliasOf('mime.nativeqpcontentencoder');
		});

		$transport = \Swift_SmtpTransport::newInstance($parameters['host'], $parameters['port']);

		if (isset($parameters['user'])) {
			$transport->setUsername($parameters['user'])->setPassword($parameters['pass']);
		}

		self::$_mailer = \Swift_Mailer::newInstance($transport);
		self::$_defaults['from'] = $parameters['from'];
	}

	/**
	 * @return Mail_Swift
	 */
	public function template($template)
	{
		preg_match('/\v*SUBJECT\v+(?<subject>.+)\v+(?<body_type>HTML|PLAIN) BODY\v+(?<body>.+)$/s', $template, $m);

		$this->subject($m['subject']);
		$this->body($m['body'], $m['body_type'] === 'HTML' ? 'text/html' : 'text/plain');

		return $this;
	}
	
	/**
	* @return Mail_Swift
	*/
	public function subject($subject)
	{
		$this->_message->setSubject($subject);
		return $this;
	}
	
	/**
	* @return Mail_Swift
	*/
	public function from($address, $name = null)
	{
		if ($name) {
			$this->_message->setFrom(array($address => $name));
		} else {
			$this->_message->setFrom($address);
		}
		
		return $this;
	}
	
	/**
	* @return Mail_Swift
	*/
	public function to($address, $name = null)
	{
		if ($name) {
			$this->_message->setTo(array($address => $name));
		} else {
			$this->_message->setTo($address);
		}
		
		return $this;
	}
	
	/**
	* @return Mail_Swift
	*/
	public function body($message, $content_type = 'text/plain')
	{
		$this->_message->setBody($message, $content_type, 'utf-8');
		return $this;
	}
	
	/**
	* @return Mail_Swift
	*/
	public function send()
	{
		self::$_mailer->send($this->_message);
		return $this;
	}
}