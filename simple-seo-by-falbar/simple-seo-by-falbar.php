<?php
/*
Plugin Name: Simple SEO by falbar
Plugin URI: http://falbar.ru/
Description: This plugin extends the standard SEO WordPress features.
Version: 1.1
Author: Anton Kuleshov
Author URI: http://falbar.ru/
*/

if(!defined('ABSPATH')){

	die();
}

define('SSBF', true);

define('SSBF_BASE', dirname(__FILE__));
define('SSBF_DS', DIRECTORY_SEPARATOR);

define('SSBF_DIR_INC', SSBF_BASE.SSBF_DS.'includes'.SSBF_DS);

require_once(SSBF_DIR_INC.'class-falbar-ssbf-core.php');
require_once(SSBF_DIR_INC.'class-falbar-ssbf.php');

$ssbf = new Falbar_SSBF();
$ssbf->run();