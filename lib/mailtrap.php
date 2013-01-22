<?php

	namespace Lib;

	require_once dirname(__FILE__) . '/../vendor/mailtrap/phpmailer/class.phpmailer.php';

	class Mail_Mailtrap extends Mail_Abstract
	{
		/**
		 * @var \PHPMailer
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
			$parameters = array_merge(array(
				'port' => 2525
			), $parameters);

			$mail             = new \PHPMailer();

			$mail->IsSMTP();

			$mail->SMTPAuth   = true;
			$mail->Host       = $parameters['host'];
			$mail->Port       = $parameters['port'];
			$mail->Username   = $parameters['user'];
			$mail->Password   = $parameters['pass'];

			$parameters['mail'] = $mail;


			return $parameters;
		}

		/**
		 * @return Mail_Swift
		 */
		public function send()
		{
			$from = $this->parameters('from');

			if (is_array($from)) {
				$from_address = array_keys($from);
				$from_address = array_pop($from_address);
				$this->_mail->SetFrom($from_address, $from[$from_address]);

			} else {
				$this->_mail->SetFrom($from);
			}

			// $this->_mail->SMTPDebug = 1;

			$this->_mail->Subject = $this->parameters('subject');

			// To
			$this->_mail->AddAddress($this->parameters('to'));

			foreach ($this->parameters('body') as $type => $body) {
				if ($type == 'text/plain') {
					$this->_mail->Body = $body;
				} else {
					$this->_mail->MsgHTML($body);
				}
			}

			if(!$this->_mail->Send()) {
				throw new \Exception('Failed to send email');
			}

			return $this;
		}
	}