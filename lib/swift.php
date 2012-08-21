<?php

namespace Lib;

require_once '../vendor/swift/lib/swift_required.php';

class Mail_Swift extends Mail_Abstract
{
	/**
	* @var \Swift_Message
	*/
	private $_message;
	
	/**
	* @var \Swift_Mailer
	*/
	private $_mailer;
	
	public function __construct(&$p)
	{
		$this->_mailer = &$p['mailer'];
		$this->_message = new \Swift_Message();
	}

	/**
	 * Parameters: host, port, user, pass
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

		$parameters['mailer'] = \Swift_Mailer::newInstance($transport);
		return $parameters;
	}
	
	/**
	* @return Mail_Swift
	*/
	public function send()
	{
		$this->_message->setSubject($this->parameters('subject'));
		$this->_message->setFrom($this->parameters('from'));
		$this->_message->setTo($this->parameters('to'));
		
		foreach ($this->parameters('body') as $type => $body) {
			$this->_message->setBody($body, $type, 'utf-8');
		}
		
		$this->_mailer->send($this->_message);
		return $this;
	}
}