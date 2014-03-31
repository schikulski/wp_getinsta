<?php
/*
Plugin Name: GetInsta - Instagram Shortcode
Plugin URI: http://www.joss.as
Description: Gets instagram content from shortcode. <br> Usage: [getinsta howmany="HOWMANYIMAGES" userid="YOURUSERID" client_id="YOURCLIENTID"]
Version: 0.2
Author: Simen Schikulski
Author URI: http://www.joss.as
License: GPLv2
*/




// Function to fetch json data from Instagram
function fetchData($url){
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_TIMEOUT, 20);
  $result = curl_exec($ch);
  curl_close($ch);
  return $result;
}



// The shortcut function
function getinsta($atts, $content = null) {
  extract(shortcode_atts(array(
    // Defaults
    "userid" => "238985276",
    "client_id" => "CLIENT_ID",
    "howmany" => "6"

    ), $atts));


  // Get data
  $result = fetchData("https://api.instagram.com/v1/tags/$userid/media/recent/?client_id=$client_id&count=$howmany");
  $result = json_decode($result);


  // What to output to the shortcode
  $output = "";

  foreach ($result->data as $post) {
    $output.= "<a  target='_blank'
        rel='tooltip'
        data-toggle='tooltip'
        title='" . $post->caption->text . "'
        class='instagramimg'
        rel='group1'
        href='" . $post->link . "'>
        <img src='" . $post->images->thumbnail->url . "'>
    </a>";
  }

  return $output;





}


// activate the shortcode
add_shortcode( "getinsta", "getinsta" );


?>
