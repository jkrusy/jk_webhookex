<?php
namespace JonathanKrusy\Webhook\Domain\Interfaces;

interface IWebhookConfiguration {

	const WEBHOOK_DEFAULT = 1;
	const WEBHOOK_SLACK = 2;

	/**
	 * @return int
	 */
	public function getType();

	/**
	 * @param int $type
	 */
	public function setType($type);

	/**
	 * @return string
	 */
	public function getWebhookUrl();

	/**
	 * @param string $webhookUrl
	 */
	public function setWebhookUrl($webhookUrl);

	/**
	 * @return string
	 */
	public function getSlackChannel();

	/**
	 * @param string $slackChannel
	 */
	public function setSlackChannel($slackChannel);

	/**
	 * @return string
	 */
	public function getSlackColor();

	/**
	 * @param string $slackColor
	 */
	public function setSlackColor($slackColor);

} 