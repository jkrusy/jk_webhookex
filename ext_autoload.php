<?php
$extpath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('jk_webhookex');
return array(
	'JonathanKrusy\JkWebhookex\Domain\Repository\WebhookConfigurationRepository' => $extpath . 'Classes/Domain/Repository/WebhookConfigurationRepository.php',
	'JonathanKrusy\Webhook\Service\WebhookErrorService' => $extpath . 'Classes/Lib/Webhook/Service/WebhookErrorService.php'
);