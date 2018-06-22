<?php
/*
Plugin Name: Email Form Plugin
Plugin URI: http://youfoundnate.com/
Description: Simple email contact form plugin
Version: 1.1
Author: Nathan Moseley
Author URI: http://youfoundnate.com/
*/


function html_form_code()
{
    if (isset($_POST['cf-email'])) {
        echo ' ';
    } else {
        echo '<div class="nl-blurred">';
        echo '<div class="container demo-1">';
        echo '<div class="main clearfix">';
        echo '<form id="nl-form" class="nl-form" action="' . esc_url($_SERVER['REQUEST_URI']) . '" method="post">';
        echo 'I ';
        echo '<input type="text" name="cf-name"  value="' . (isset($_POST["cf-name"]) ? esc_attr($_POST["cf-name"]) : '') . '" placeholder="your name" data-subline="For example: <em>Jon</em> or <em>Kristyn</em>" />';
        echo ' want to get my website or app ';
        echo '<select>';
        echo '<option value="1" selected>finished</option>';
        echo '<option value="2">looking better</option>';
        echo '<option value="3">working</option>';
        echo '<option value="4">built</option>';
        echo '</select>';
        echo '<br />in a ';
        echo '<select>';
        echo '<option value="1" selected>standard</option>';
        echo '<option value="2">fancy</option>';
        echo '<option value="3">hip</option>';
        echo '<option value="4">quick</option>';
        echo '<option value="5">old school</option>';
        echo '</select>';
        echo ' way';
        echo '<br />by ';
        echo '<input type="text" value="" placeholder="any time" data-subline="For example: <em>next-week</em> or <em>next-month</em>" /> in ';
        echo '<input type="text" value="" placeholder="any city" data-subline="For example: <em>Los Angeles</em> or <em>Vancouver</em>"/>.';
        echo '<input type="email" name="cf-email" value="' . (isset($_POST["cf-email"]) ? esc_attr($_POST["cf-email"]) : '') . '" placeholder="your email" id="myEmail" required="required"  class="userInput">';
        echo '<div class="nl-submit-wrap">';
        echo '<button id="form-submit" class="nl-submit" type="submit" name="cf-submitted">Submit</button>';
        echo '</div>';
        echo '<div class="nl-overlay"></div>';
        echo '</form>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
}
function deliver_mail()
{
   
    // if the submit button is clicked, send the email
    if (isset($_POST['cf-submitted'])) {
       

        // sanitize form values
        $name = sanitize_text_field($_POST["cf-name"]);
        $email = sanitize_email($_POST["cf-email"]);
        // $subject = sanitize_text_field($_POST["cf-subject"]);
        // $message = esc_textarea($_POST["cf-message"]);

        // get the blog administrator's email address
        // $to = get_option('admin_email');
        $to = 'ncmoseley@gmail.com';
        $subjectname = $_POST["cf-name"];
        $subject = 'Someone Needs a Dev!';
        $message = 'Lets get this going!';
        $headers = "From: $subjectname <$email>" . "\r\n";

        // If email has been process for sending, display a success message
        if (wp_mail($to, $subject, $message, $headers)) {
            echo '<div>';
            echo '<p>Thanks for contacting me, expect a response soon!</p>';
            echo '</div>';
        } else {
            echo 'An unexpected error occurred';
        }
    }
}

function cf_shortcode()
{
    ob_start();
    deliver_mail();
    html_form_code();

    return ob_get_clean();
}

add_shortcode('sitepoint_contact_form', 'cf_shortcode');

function wpse_load_plugin_css()
{
    $plugin_url = plugin_dir_url(__FILE__);

    wp_enqueue_style('style1', $plugin_url . 'css/nl-form.css');
}
add_action('wp_enqueue_scripts', 'wpse_load_plugin_css');
