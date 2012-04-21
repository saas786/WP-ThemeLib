<?php

define('THEMELIB',dirname(__FILE__));

/**
 * Load all plugins
 */
include_once(THEMELIB.'/plugins/load.php');

/**
 * Load analytics
 */
include_once(THEMELIB.'/analytics/presstrends.php');

/**
 * Load theme setup basics
 */
include_once(THEMELIB.'/setup/load.php');
