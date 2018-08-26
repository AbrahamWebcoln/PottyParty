<?php
/* Revolution Slider support functions
------------------------------------------------------------------------------- */

// Check if RevSlider installed and activated
if ( !function_exists( 'themerex_exists_revslider' ) ) {
	function themerex_exists_revslider() {
		return function_exists('rev_slider_shortcode');
		//return class_exists('RevSliderFront');
		//return is_plugin_active('revslider/revslider.php');
	}
}

// Check if Additional tags installed and activated
if ( !function_exists( 'themerex_exists_additional_tags' ) ) {
    function themerex_exists_additional_tags() {
        return function_exists('themerex_additional_tags');
    }
}
?>