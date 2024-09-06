<?php
/**
 * Plugin Name: Trap Gravity Forms
 * Plugin URI: https://github.com/Idrees-Hashmi/Trap-Gravity-Form
 * Author: Syed Idrees Hashmi
 * Author URI: https://github.com/Idrees-Hashmi
 * Description: Collect Gravity forms to Webhook
 * Version: 1.0
 * text-domain: trap-gravity
*/

defined( 'ABSPATH' ) or die( 'No entry' );
// add_action( 'gform_after_submission', 'after_submission', 10, 2 );

add_action( 'gform_after_submission_19', 'idrees_after_submission', 10, 2 );
add_action( 'gform_after_submission_13', 'idrees_after_submission', 10, 2 );


//Replace 19 in gform_after_submission_19 with your form ID
// Add Action Depends on your number of forms


function idrees_after_submission( $entry, $form ) {

    error_log( print_r( $entry, true ) );


    // for name

    $name = null;
$name_posibilities = [45, 36]; // Add more entries as needed

foreach ($name_posibilities as $field) {
    if (!empty($entry[$field])) {
        $name = $entry[$field];
        break; // Stop the loop once we find a non-empty value
    }
}


    // for phone

    $phone = null;
$phone_posibilities = [35, 22]; // Add more entries as needed

foreach ($phone_posibilities as $field) {
    if (!empty($entry[$field])) {
        $phone = $entry[$field];
        break; // Stop the loop once we find a non-empty value
    }
}


 // for email

    $email = null;
$email_posibilities = [34, 21]; // Add more entries as needed

foreach ($email_posibilities as $field) {
    if (!empty($entry[$field])) {
        $email = $entry[$field];
        break; // Stop the loop once we find a non-empty value
    }
}


// for address

    $address = null;
$address_posibilities = [44, 32]; // Add more entries as needed

foreach ($address_posibilities as $field) {
    if (!empty($entry[$field])) {
        $address = $entry[$field];
        break; // Stop the loop once we find a non-empty value
    }
}


// for postcode

    $postcode = null;
$postcode_posibilities = [38, 26]; // Add more entries as needed

foreach ($postcode_posibilities as $field) {
    if (!empty($entry[$field])) {
        $postcode = $entry[$field];
        break; // Stop the loop once we find a non-empty value
    }
}


// Gather all other fields into Comments

    $comments = [];
    $comment_fields = [4, 42, 7, 18, 9, 33, 29, 30, 31, 27, 16];

    foreach ($form['fields'] as $field) {
        if (in_array($field->id, $comment_fields) && !empty($entry[$field->id])) {
            $label = $field->label; // Get the field label
            $comments[] = "$label: " . $entry[$field->id];
        }
    }


// Fetch the form title and add it to the comments
    $form_title = $form['title'];
    array_unshift($comments, "Form Title: $form_title");

    



    if ( $entry['form_id'] == 19 or $entry['form_id'] == 13 ) {

        $info = [
            'Name' => $name,
            'PhoneNo' => $phone,
            'email'  => $email ? $email : 'Not provided',
            'Address'  => $address,
            'Postcode'  => $postcode,
             "Surname" => "hnothig",
             "DateOfBirth" => "2000-10-10",
             "JobType" => "JobType",
             "LeadSource" => "LeadSource",
              "Line1" => "firstline313",
              'Comments' => implode("\n", $comments),
              "MeasureIds" =>[1,2,3]

            
        ];

        $url = 'API Key';  // Replace with your actual API URL
        $username = 'API Username'; // Replace with your actual username
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