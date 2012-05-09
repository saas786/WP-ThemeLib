<?php

/**
 * Load the WordPress Creation Kit
 */
if( !defined('DISABLE_WCK_CFC') )
        include_once(TEMPLATEPATH.'/lib/plugins/custom-fields-creator/wck-cfc.php');

/**
 * Load cpt Archives in nave menus
 */
if( !defined('DISABLE_CPT_ARCHIVES') )
        include_once(TEMPLATEPATH.'/lib/plugins/cpt-archives-in-nav-menus.php');

/**
 * Load Nivo Slider
 */
if( !defined('DISABLE_NIVO_SLIDER') )
    include_once(TEMPLATEPATH.'/lib/plugins/nivo-slider/nivo-slider.php');