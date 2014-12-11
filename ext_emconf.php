<?php
########################################################################
# Extension Manager/Repository config file for ext "sentry".
#
# Auto generated 21-08-2012 19:13
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################
$EM_CONF[$_EXTKEY] = array(
	'title' => 'Webhook error reporting',
	'description' => 'This extension sends TYPO3 errors and warning a configured webhook.',
	'category' => 'services',
	'shy' => 0,
	'dependencies' => '',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => '',
	'state' => 'alpha',
	'internal' => 0,
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'author' => 'Jonathan Krusy',
	'author_email' => 'j.krusy@raphael-gmbh.de',
	'author_company' => '',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'version' => '0.0.0',
	'constraints' => array(
		'depends' => array(
			'php' => '5.3.2-0.0.0',
			'typo3' => '4.5.0-6.2.999',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'suggests' => array(
	),
);
?>