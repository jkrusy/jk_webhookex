<?php
namespace JonathanKrusy\JkWebhookex\Service;
use JonathanKrusy\JkWebhookex\Domain\Model\WebhookConfiguration;
use JonathanKrusy\Webhook\Domain\IWebhookConfiguration;
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


class WebhookErrorService extends \JonathanKrusy\Webhook\Service\WebhookErrorService {

	/**
	 * @var array
	 */
	protected $extConf = array();

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

		$this->setSlackUserName($this->extConf["slackUserName"]);
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