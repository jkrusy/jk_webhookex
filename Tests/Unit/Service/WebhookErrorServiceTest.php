<?php
use TYPO3\CMS\Core\Utility\GeneralUtility;

class WebhookErrorServiceTest  extends \TYPO3\CMS\Core\Tests\UnitTestCase {

	/**
	 * @var \JonathanKrusy\JkWebhookex\Service\WebhookErrorService
	 * @inject
	 */
	protected $service;


	protected function setUp() {
		$this->service = GeneralUtility::makeInstance("\\JonathanKrusy\\JkWebhookex\\Service\\WebhookErrorService");
	}

	/**
	 * @test
	 */
	public function testWebhookService() {
		$this->service->handle(
			new \TYPO3\CMS\Core\Error\Exception(
				"Unit test exception",
				123
			),
			"Unit test file",
			__LINE__
		);
	}

}