<?php
namespace JonathanKrusy\JkWebhookex\Domain\Model;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Jonathan Krusy <j.krusy@googlemail.de>
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

use JonathanKrusy\Webhook\Domain\IWebhookConfiguration;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class WebhookConfiguration extends AbstractEntity implements IWebhookConfiguration {

	/**
	 * @var int
	 */
	protected $type;

	/**
	 * @var string
	 */
	protected $webhookUrl;

	/**
	 * @var string
	 */
	protected $slackColor = "FF0000";

	/**
	 * @var string
	 */
	protected $slackChannel = "";

	/**
	 * @return int
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * @param int $type
	 */
	public function setType($type)
	{
		$this->type = $type;
	}

	/**
	 * @return string
	 */
	public function getWebhookUrl()
	{
		return $this->webhookUrl;
	}

	/**
	 * @param string $webhookUrl
	 */
	public function setWebhookUrl($webhookUrl)
	{
		$this->webhookUrl = $webhookUrl;
	}

	/**
	 * @return string
	 */
	public function getSlackChannel()
	{
		return $this->slackChannel;
	}

	/**
	 * @param string $slackChannel
	 */
	public function setSlackChannel($slackChannel)
	{
		$this->slackChannel = $slackChannel;
	}

	/**
	 * @return string
	 */
	public function getSlackColor()
	{
		return $this->slackColor;
	}

	/**
	 * @param string $slackColor
	 */
	public function setSlackColor($slackColor)
	{
		$this->slackColor = $slackColor;
	}

} 