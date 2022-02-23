<?php
	/*************************Display only available option***************/
	add_filter( 'woocommerce_ajax_variation_threshold', 'wc_ninja_ajax_threshold' );
	function wc_ninja_ajax_threshold() {
	    return 150;
	}
?>