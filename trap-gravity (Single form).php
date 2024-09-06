<?php
/**
 * Plugin Name: Trap Gravity Forms
 * Plugin URI: https://github.com/Idrees-Hashmi/Trap-Gravity-Form
 * Author: Syed Idrees Hashmi
 * Author URI: https://github.com/Idrees-Hashmi
 * Description: Collect Gravity forms to Webhook
 * Version: 0.1.0
 * text-domain: trap-gravity
*/

defined( 'ABSPATH' ) or die( 'No entry' );
// add_action( 'gform_after_submission', 'after_submission', 10, 2 );

add_action( 'gform_after_submission_19', 'idrees_after_submission', 10, 2 );

//Replace 19 in gform_after_submission_19 with your form ID


function idrees_after_submission( $entry, $form ) {

    error_log( print_r( $entry, true ) );


// Gather all other fields into Comments

    $comments = [];
    $comment_fields = [4, 42, 7, 18, 9, 33, 29, 30, 31, 27, 16];

    foreach ($form['fields'] as $field) {
        if (in_array($field->id, $comment_fields) && !empty($entry[$field->id])) {
            $label = $field->label; // Get the field label
            $comments[] = "$label: " . $entry[$field->id];
        }
    }

    



    if ( $entry['form_id'] == 19 or $entry['form_id'] == 13 ) {

        $info = [
            'Name' => $entry[$field],
            'PhoneNo' => $entry[$field],
            'email'  => $entry[$field],
            'Address'  => $entry[$field],
            'Postcode'  => $entry[$field],
             "Surname" => "hnothig",
             "DateOfBirth" => "2000-10-10",
             "JobType" => "JobType",
             "LeadSource" => "LeadSource",
              "Line1" => "firstline313",
              'Comments' => implode("\n", $comments),
              "MeasureIds" =>[1,2,3]

            
        ];

        $url = 'API Key';  // Replace with your actual API URL
        $username = 'API USername'; // Replace with your actual username
        $password = 'API Password'; // Replace with your actual password

        // Encoding credentials for Basic Auth
        $auth = base64_encode( "$username:$password" );

        $args = [
            'method'    => 'POST',
            'body'      => json_encode($info), // Encode the data as JSON
            'headers'   => [
                'Authorization' => 'Basic ' . $auth,
                'Content-Type'  => 'application/json',
            ],
        ];

        $response = wp_remote_post( $url, $args );

    }

}