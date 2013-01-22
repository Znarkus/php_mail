<?php

namespace Lib;

require_once dirname(__FILE__) . '/../vendor/postmark/Postmark.php';

class Mail_Postmark extends Mail_Abstract
{
	/**
	 * @var \Mail_Postmark
	 */
	private $_mail;

	public function __construct(&$p)
	{
		$this->_mail = &$p['mail'];
	}

	/**
	 * Parameters: host, port, user, pass
	 * @param array $parameters
	 */
	public static function setup(array $parameters)
	{
		$parameters['mail'] = \Mail_Postmark::compose();

		return $parameters;
	}

	/**
	 * @return Mail_Postmark
	 */
	public function send()
	{
		$this->_mail->subject($this->parameters('subject'));

		// To
		$this->_mail->addTo($this->parameters('to'));

		foreach ($this->parameters('body') as $type => $body) {
			if ($type == 'text/plain') {
				$this->_mail->messagePlain($body);
			} else {
				$this->_mail->messageHtml($body);
			}
		}

		if(!$this->_mail->send()) {
			throw new \Exception('Failed to send email');
		}

		return $this;
	}
}