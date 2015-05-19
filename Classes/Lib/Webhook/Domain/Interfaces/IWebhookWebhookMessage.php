<?php
namespace JonathanKrusy\Webhook\Domain\Interfaces;

interface IWebhookMessage {

	/**
	 * @param string $text
	 * @return mixed
	 */
	public function send($text = "");

	/**
	 * @return string
	 */
	public function getText();

	/**
	 * @param string $text
	 */
	public function setText($text);

} 