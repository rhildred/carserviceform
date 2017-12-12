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
        $slim->post('/slim/api/appointment', function(){
            global $wpdb, $table_prefix;
            $postdata = file_get_contents("php://input");
            $oAppointment = json_decode($postdata);
            $ssQL = "INSERT INTO " . $table_prefix . 
            "appointment(service, apptdate) VALUES(%s, %s)";
            $stmt = $wpdb->prepare($ssQL, 
                array($oAppointment->service, $oAppointment->apptdate));
            $wpdb->query($stmt);
            $oAppointment->id = $wpdb->insert_id;
            echo json_encode($oAppointment);
        });
        $slim->run();
        exit;
    }
});

