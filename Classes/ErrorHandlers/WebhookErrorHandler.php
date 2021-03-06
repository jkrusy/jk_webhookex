<?php
namespace JonathanKrusy\JkWebhookex\ErrorHandlers;
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

class WebhookErrorHandler implements \TYPO3\CMS\Core\Error\ErrorHandlerInterface {

	private $extConf = array();

	/**
	 * @var \JonathanKrusy\JkWebhookex\Service\WebhookErrorService
	 * @inject
	 */
	protected $service;

	/**
	 * Registers this class as default error handler
	 *
	 * @param int $errorHandlerErrors The integer representing the E_* error level which should be
	 */
	public function __construct($errorHandlerErrors)
	{
		$this->extConf = @unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['jk_webhookex']);
	}

	/**
	 * Defines which error levels should result in an exception thrown.
	 *
	 * @param int $exceptionalErrors The integer representing the E_* error level to handle as exceptions
	 * @return void
	 */
	public function setExceptionalErrors($exceptionalErrors)
	{
		// TODO: Implement setExceptionalErrors() method.
	}

	/**
	 * Handles an error.
	 * If the error is registered as exceptionalError it will by converted into an exception, to be handled
	 * by the configured exceptionhandler. Additionally the error message is written to the configured logs.
	 * If TYPO3_MODE is 'BE' the error message is also added to the flashMessageQueue, in FE the error message
	 * is displayed in the admin panel (as TsLog message)
	 *
	 * @param int $errorLevel The error level - one of the E_* constants
	 * @param string $errorMessage The error message
	 * @param string $errorFile Name of the file the error occurred in
	 * @param int $errorLine Line number where the error occurred
	 * @return bool
	 * @throws \TYPO3\CMS\Core\Error\Exception with the data passed to this method if the error is registered as exceptionalError
	 */
	public function handleError($errorLevel, $errorMessage, $errorFile, $errorLine)
	{
		$this->service->handle(
			new \TYPO3\CMS\Core\Error\Exception(
				§errorMessage,
				$errorLevel
			),
			$errorFile,
			$errorLine
		);
	}
}