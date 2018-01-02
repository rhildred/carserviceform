<?php
/*
Plugin Name: Appointment UI
*/
add_action('init', function() {
    add_shortcode('appt-plugin',function($atts = [], $content = null){
        $content .= "<script>var atts = " .
        json_encode($atts) .
        "</script>";
        $content .= file_get_contents(dirname(__FILE__) . "/index.html");
        return $content;
    });
    wp_register_style('bootstrap', "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css");
    wp_enqueue_style('bootstrap');
    wp_register_style('main_stylesheet', 
    plugins_url('main.css', __FILE__));
    wp_enqueue_style('main_stylesheet');
    

    wp_register_script('angular_script', 
    "https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.3.15/angular.js", 
    true);
    
    wp_enqueue_script('angular_script');
    wp_register_script('mycontroller_script', 
    plugins_url('indexcontroller.js', __FILE__), 
    true);

    wp_enqueue_script('mycontroller_script');
   
});

include_once "backend.php";

register_activation_hook( __FILE__, function(){
    //ob_start(); //use this to debug
    global $wpdb, $table_prefix;
    $wpdb->show_errors();
    $sSQL = "CREATE TABLE " . 
    $table_prefix . "test ('id' INTEGER PRIMARY KEY AUTOINCREMENT, 'test1' TEXT, 'test2' TEXT)";
    $wpdb->query($sSQL);
    $sSQLAppt = "CREATE TABLE " . 
    $table_prefix . "appointment ('id' INTEGER PRIMARY KEY AUTOINCREMENT, 'service' TEXT, 'apptdate' TEXT)";
    $wpdb->query($sSQLAppt);
    $sSQLService = "CREATE TABLE " . 
    $table_prefix . "service ('id' INTEGER PRIMARY KEY AUTOINCREMENT, 'apptid' INTEGER NOT NULL, 'name' TEXT)";
    $wpdb->query($sSQLService);
    //trigger_error(ob_get_contents(),E_USER_ERROR); // this goes with ob_start
} );
