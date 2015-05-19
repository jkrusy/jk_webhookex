<?php

namespace JonathanKrusy\Webhook\Service;

use JonathanKrusy\Webhook\Domain\Interfaces\IWebhookConfiguration;
use JonathanKrusy\Webhook\Domain\SlackMessage;

class WebhookErrorService {

	/**
	 * @var array
	 */
	protected $webhooks = array();

	/**
	 * @var
	 */
	protected $slackUserName = '';

	/**
	 * @return mixed
	 */
	public function getSlackUserName()
	{
		return $this->slackUserName;
	}

	/**
	 * @param mixed $slackUserName
	 */
	public function setSlackUserName($slackUserName)
	{
		$this->slackUserName = $slackUserName;
	}

	/**
	 * @param \Exception $exception
	 * @param IWebhookConfiguration $webhookConfiguration
	 * @param $link
	 */
	public function handleSlack(\Exception $exception, IWebhookConfiguration $webhookConfiguration, $link) {
		if($webhookConfiguration->getType() == IWebhookConfiguration::WEBHOOK_SLACK) {
			//hook address
			$webhook = $webhookConfiguration->getWebhookUrl();

			if(strlen($webhook) > 0) {
				$slackMessage = new SlackMessage($webhook);
				$slackMessage->setUsername($this->slackUserName . " " . date("U"));
				$slackMessage->setIconEmoji(':warning:');
				$slackMessage->setText($exception->getMessage());

				$stackTraceFields = array();
				$stackTraceFields[] = array(
					"title" => "Full Stack Trace",
					"value" => $exception->getTraceAsString()
				);
				$slackMessage->setAttachments(array(
					array(
						"fallback" => "Details",
						"color" => "#333333",
						"fields" => array(
							array(
								"title" => ":page_with_curl: File",
								"value" => $exception->getFile(),
								"short" => TRUE
							),
							array(
								"title" => ":paperclip: Line",
								"value" => $exception->getLine(),
								"short" => TRUE
							),
							array(
								"title" => ":zap: Code",
								"value" => $exception->getCode(),
								"short" => TRUE
							),
							array(
								"title" => ":link: Link",
								"value" => ($link != '' ? "<" . $link . ">" : ''),
								"short" => TRUE
							)
						)
					),
					array(
						"fallback" => "Exception data",
						"color" => "#" . $webhookConfiguration->getSlackColor(),
						"fields" => $stackTraceFields
					)
				));

				if($webhookConfiguration->getSlackChannel() !== "") {
					$slackMessage->setChannel($webhookConfiguration->getSlackChannel());
				}
				if($link != '') {
					$slackMessage->setUsername($slackMessage->getUsername() .  " (Web)");
				}

				$slackMessage->send();
			}
		}
	}

	/**
	 * @param IWebhookConfiguration $webhook
	 * @param \Exception $exception
	 * @param string $link
	 */
	public function handleWebhook(IWebhookConfiguration $webhook, \Exception $exception, $link = '') {
		switch($webhook->getType()) {
			case IWebhookConfiguration::WEBHOOK_DEFAULT:
				// TODO: Default Webhook
				break;
			case IWebhookConfiguration::WEBHOOK_SLACK:
				$this->handleSlack($exception, $webhook, $link);
				break;
			default:
				// TODO: add hook
				break;
		}
	}

} 