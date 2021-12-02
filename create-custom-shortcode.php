<?php

// function that runs when shortcode is called
function wpb_demo_shortcode() { 
 
// Things that you want to do. 
$message = 'Hello world!'; 
 
// Output needs to be return
return $message;
} 
// register shortcode
add_shortcode('greeting', 'wpb_demo_shortcode');

//You can now use the [greeting] shortcode inside your WordPress posts, pages, and sidebar widgets.

?>
