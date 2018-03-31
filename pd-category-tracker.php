<?php

/**
 * @package PD Category Tracker
 */
/*
Plugin Name: Custom Category Tracker
Description: Tracks category impressions via Google Analytics Events
Version: 1.0
Author: Rory Molyneux
Author URI: http://pitchdark.co.za
License: Private
Text Domain: pd-category-tracker
*/


add_action('wp_footer', 'send_event');

function send_event() {
    
    if(is_archive()) {
        
        $archive_type = get_the_archive_title();
        $analytics_obj = 'wppas_ga';
                
        echo '<script>
        function sendAnalyticsEvent() {
        
    if(typeof ' . $analytics_obj . ' === "undefined") {
        setTimeout(sendAnalyticsEvent(), 1000);
    } else {
        
        var obj = {
            hitType: "event",
            eventCategory: "wp category statistics",
            eventAction: "impressions",
            eventLabel: "' . $archive_type . '"
        };
        
        // console.log(obj)
        
        ' . $analytics_obj . '("send", obj);
        
    }
    
}
sendAnalyticsEvent();
</script>';
        
    }
    
}