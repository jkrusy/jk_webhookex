<?php
namespace JonathanKrusy\JkWebhookex\Service;
use JonathanKrusy\JkWebhookex\Domain\Model\WebhookConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Jonathan Krusy <j.krusy@raphael-gmbh.de>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  A copy is found in the textfile GPL.txt and important notices to the license
 *  from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/


class WebhookErrorService {

	/**
	 * @var array
	 */
	protected $extConf = array();

	/**
	 * @var array
	 */
	protected $webhooks = array();

	/**
	 *
	 */
	public function __construct() {
		$this->loadWebhooks();
	}

	/**
	 *
	 */
	private function loadWebhooks() {
		$this->extConf = @unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['jk_webhookex']);
		$urls = GeneralUtility::trimExplode(",", $this->extConf["slackWebhookUrl"]);
		$channels = GeneralUtility::trimExplode(",", $this->extConf["slackWebhookChannels"]);
		foreach($channels as $k => $channel) {
			$url = isset($urls[$k]) ? $urls[$k] : $urls[0];
			$webhookConfiguration = new WebhookConfiguration();
			$webhookConfiguration->setType(WebhookConfiguration::WEBHOOK_SLACK);
			$webhookConfiguration->setWebhookUrl($url);
			$webhookConfiguration->setSlackChannel($channel);

			$this->webhooks[] = $webhookConfiguration;
		}
	}

	/**
	 * @param \Exception $exception
	 * @param WebhookConfiguration $webhookConfiguration
	 * @param $link
	 */
	public function handleSlack(\Exception $exception, WebhookConfiguration $webhookConfiguration, $link) {
		if($webhookConfiguration->getType() == WebhookConfiguration::WEBHOOK_SLACK) {
			//hook address
			$webhook = $webhookConfiguration->getWebhookUrl();

			if(strlen($webhook) > 0) {
				$ch = curl_init();

				$stackTraceFields = array();
				$stackTraceFields[] = array(
					"title" => "Full Stack Trace",
					"value" => $exception->getTraceAsString()
				);

				$payloadArray = array(
					"username" => $this->extConf["slackUserName"] . " " . date("U"),
					"icon_emoji" => ':warning:',
					"text" => $exception->getMessage(),
					"attachments" => array(
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
					)
				);
				if($webhookConfiguration->getSlackChannel() !== "") {
					$payloadArray["channel"] = $webhookConfiguration->getSlackChannel();
				}
				if($link != '') {
					$payloadArray["username"] .= " (Web)";;
				}

				//set the url, number of POST vars, POST data
				curl_setopt($ch,CURLOPT_URL, $webhook);
				curl_setopt($ch,CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch,CURLOPT_POSTFIELDS, array(
					"payload" => json_encode($payloadArray)
				));

				//execute post
				curl_exec($ch);

				//close connection
				curl_close($ch);
			}
		}
	}

	/**
	 * @param WebhookConfiguration $webhook
	 * @param \Exception $exception
	 * @param string $link
	 */
	public function handleWebhook(WebhookConfiguration $webhook, \Exception $exception, $link = '') {
		switch($webhook->getType()) {
			case WebhookConfiguration::WEBHOOK_DEFAULT:
				// TODO: Default Webhook
				break;
			case WebhookConfiguration::WEBHOOK_SLACK:
				$this->handleSlack($exception, $webhook, $link);
				break;
			default:
				// TODO: add hook
				break;
		}
	}

	/**
	 * @param \Exception $exception
	 * @param string $link
	 */
	public function handleAll(\Exception $exception, $link = '') {
		foreach($this->webhooks as $webhook) {
			/** @var WebhookConfiguration $webhook */
			$this->handleWebhook($webhook, $exception, $link);
		}
	}

	/**
	 *
	 */
	private function loadConfiguration() {
		$this->extConf = @unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['jk_webhookex']);
	}

}