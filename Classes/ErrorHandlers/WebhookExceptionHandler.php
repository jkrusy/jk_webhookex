<?php
namespace JonathanKrusy\JkWebhookex\ErrorHandlers;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Error\ProductionExceptionHandler;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

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

class WebhookExceptionHandler extends ProductionExceptionHandler {

	private $extConf = array();

	/**
	 * @var \JonathanKrusy\JkWebhookex\Service\WebhookErrorService
	 */
	protected $webhookService;

	/** @var string */
	static protected $oldExceptionHandlerClassName;

	/**
	 * Constructs this exception handler - registers itself as the default exception handler.
	 */
	public function __construct()
	{
		/** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
		$objectManager = GeneralUtility::makeInstance("\\TYPO3\\CMS\\Extbase\\Object\\ObjectManager");
		$this->webhookService = $objectManager->get("JonathanKrusy\\JkWebhookex\\Service\\WebhookErrorService");
		parent::__construct();
	}

	/**
	 * Formats and echoes the exception as XHTML.
	 *
	 * @param \Exception $exception The exception object
	 * @return void
	 */
	public function echoExceptionWeb(\Exception $exception)
	{
		/** @var \JonathanKrusy\JkWebhookex\Service\WebhookErrorService $webhookService */
		$webhookService = $this->webhookService;
		$webhookService->handleAll($exception, $this->buildLink());
		parent::echoExceptionWeb($exception);
	}

	private function buildLink() {
		$return = array();
		$return[] = 'http' . ($_SERVER["HTTPS"] ? 's' : '') . '://';
		$return[] = $_SERVER["HTTP_HOST"];
		$return[] = $_SERVER["REQUEST_URI"];
		return implode("", $return);
	}

	/**
	 * Formats and echoes the exception for the command line
	 *
	 * @param \Exception $exception The exception object
	 * @return void
	 */
	public function echoExceptionCLI(\Exception $exception)
	{
		// TODO: Implement echoExceptionCLI() method.
	}

	/**
	 * Prepares the class to replace TYPO3 standard handler with Raven-PHP
	 * implementation.
	 *
	 * @return void
	 */
	public static function initialize() {
		// Save old error handler
		self::$oldExceptionHandlerClassName = $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['errors']['exceptionHandler'];
		$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['errors']['exceptionHandler'] = __CLASS__;
	}
}