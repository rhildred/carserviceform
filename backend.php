<?php
require_once 'Slim/Slim.php';
require_once 'SlimWpOptions.php';


\Slim\Slim::registerAutoloader();
new \Slim\SlimWpOptions();

add_filter('rewrite_rules_array', function ($rules) {
    $new_rules = array(
        '('.get_option('slim_base_path','slim/api/').')' => 'index.php',
    );
    $rules = $new_rules + $rules;
    return $rules;
});

add_action('init', function () {
    if (strstr($_SERVER['REQUEST_URI'], get_option('slim_base_path','slim/api/'))) {
        $slim = new \Slim\Slim();
        do_action('slim_mapping',$slim);
        $slim->get('/slim/api/user/:u',function($user){
            printf("User is %s",$user);            
        });
        $slim->get('/slim/api/test', function(){
            global $wpdb, $table_prefix;
            echo json_encode(
                $wpdb->get_results( 
                    $wpdb->prepare("SELECT * FROM " . 
                    $table_prefix . "test", null) ));
        });
        $slim->run();
        exit;
    }
});

function carapptplugin_activate() {
    global $wpdb, $table_prefix;
    $wpdb->show_errors();
    $stmt = $wpdb->prepare("CREATE TABLE " . 
        $table_prefix . "test ('id' INTEGER PRIMARY KEY AUTOINCREMENT, 'test1' TEXT, 'test2' TEXT)");
    $wpdb->query($stmt);
}
register_activation_hook( __FILE__, 'carapptplugin_activate' );