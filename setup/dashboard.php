<?php

/**
 * UpThemes Dashboard News Widget
 * 
 * Modified from Yoast SEO Dashboard Widget
 * http://yoast.com
 */

function upthemes_fetch_rss_items( $num ){
	include_once(ABSPATH . WPINC . '/feed.php');
	$rss = fetch_feed('http://upthemes.com/feed/');
	
	// Bail if feed doesn't work
	if ( is_wp_error($rss) )
		return false;
	
	$rss_items = $rss->get_items( 0, $rss->get_item_quantity( $num ) );
	
	// If the feed was erroneously 
	if ( !$rss_items ) {
		$md5 = md5( $this->feed );
		delete_transient( 'feed_' . $md5 );
		delete_transient( 'feed_mod_' . $md5 );
		$rss = fetch_feed( $this->feed );
		$rss_items = $rss->get_items( 0, $rss->get_item_quantity( $num ) );
	}
	
	return $rss_items;
}

function upthemes_db_widget(){

	$options = get_option('upthemes_dbwidget');
	
	$network = '';
	if ( function_exists('is_network_admin') && is_network_admin() )
		$network = '_network';

	if (isset($_POST['upthemes_removedbwidget'])) {
		$options['removedbwidget'.$network] = true;
		update_option('upthemes_dbwidget',$options);
	}			
	if ( isset($options['removedbwidget'.$network]) && $options['removedbwidget'.$network] ) {
		echo "If you reload, this widget will be gone and never appear again, unless you decide to delete the database option 'upthemes_dbwidget'.";
		return;
	}

	$rss_items = upthemes_fetch_rss_items( 3 );
	
	echo '<div class="rss-widget">';
	echo '<ul>';

	if ( !$rss_items ) {
	    echo '<li class="nothing">no news items, feed might be broken...</li>';
	} else {
	    foreach ( $rss_items as $item ) {
			echo '<li class="upthemes">';
			echo '<a class="rsswidget" href="'.esc_url( $item->get_permalink(), $protocolls=null, 'display' ).'">'. esc_html( $item->get_title() ) .'</a>';
			echo ' <span class="rss-date">'. $item->get_date('F j, Y') .'</span>';
			echo '<div class="rssSummary">'. esc_html( strip_tags( $item->get_description() ) ).'</div>';
			echo '</li>';
	    }
	}						

	echo '</ul>';
	echo '<br class="clear"/><div style="margin-top:10px;border-top: 1px solid #ddd; padding-top: 10px; text-align:center;">';
	echo '<a href="http://upthemes.com/feed/"><img src="'.get_bloginfo('wpurl').'/wp-includes/images/rss.png" alt=""/> Subscribe with RSS</a>';
	echo '<form class="alignright" method="post"><input type="hidden" name="upthemes_removedbwidget" value="true"/><input title="Remove this widget from all users dashboards" class="button" type="submit" value="X"/></form>';
	echo '</div>';
	echo '</div>';
}

function upthemes_dbwidget_setup(){
	$network = '';
	if ( function_exists('is_network_admin') && is_network_admin() )
		$network = '_network';

	$options = get_option('upthemes_dbwidget');
	if ( !isset($options['removedbwidget'.$network]) || !$options['removedbwidget'.$network] )
		wp_add_dashboard_widget( 'upthemes_db_widget' , 'The Latest From UpThemes' , 'upthemes_db_widget' );
}