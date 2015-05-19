<?php
namespace JonathanKrusy\Webhook\Domain;

use JonathanKrusy\Webhook\Domain\Interfaces\IWebhookMessage;

abstract class AbstractWebhookMessage implements IWebhookMessage {

	/**
	 * @var string
	 */
	protected $text = "";

	/**
	 * @return string
	 */
	public function getText()
	{
		return $this->text;
	}

	/**
	 * @param string $text
	 */
	public function setText($text)
	{
		$this->text = $text;
	}

}