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
    
    $analytics_obj = 'wppas_ga';
    
    if(is_archive()) {
        // Get the name of the archive
        $archive_type = get_the_archive_title();
                        
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
    
    if(is_single()) {
        // Set the parent category
        $parent_cat = 16;
        
        // Get all child categories of a parent
        $categories = get_categories(array('child_of' => $parent_cat));
        
        echo '<script>
        function sendAnalyticsEvent() {
        
    if(typeof ' . $analytics_obj . ' === "undefined") {
        setTimeout(sendAnalyticsEvent(), 1000);
    } else {
    
        ';
        foreach($categories as $cat) {
                            
                echo "\r\n" . 'var obj = {
            hitType: "event",
            eventCategory: "wp category statistics",
            eventAction: "impressions",
            eventLabel: "' . $cat->name . '"
        }
        // console.log(obj)
            
        ' . $analytics_obj . '("send", obj);';
                
        }
        // Close off JS function
        echo "\r\n}\r\n}";
        
        // Do function
        echo "\r\nsendAnalyticsEvent();
</script>";
        
        
    }
    

        
}
    
