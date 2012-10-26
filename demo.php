<?php
// Set our API key and load the library
define('BLITLINE_APP_ID', 'YOUR-APP-ID-FROM-BLITLINE-DOT-COM');
include('lib/blitline_php.php');

// I'm mayor of the internet and I love cats
$src = 'http://placekitten.com/1024/768';

// Instantiate our Blitline object
$Blit = new Blitline_php();

// Want to see what's going on?  Turn on debugging.
// $Blit->debug_on();

// Load our image and give it an optional image identifier
$Blit->load($src, 'kitten-256.jpg'); // Passing in our own image identifier

// Resize it to a 256 pixel image
$Blit->do_resize_to_fill(256, 256);

// *Also* resize to a 512 pixel image, sharpened, 45 % quality
$Blit->new_request();
$Blit->set_image_id('kitten-512.jpg');
$Blit->set_jpg_quality(45);
$Blit->do_resize_to_fit(512, 512);
$Blit->do_sharpen();

// One more tiny one for fun
$Blit->new_request();
$Blit->set_image_id('kitten-48.jpg');
$Blit->set_jpg_quality(75);
$Blit->do_resize_to_fill(48, 48);

// Want to see our request queue?
//print_r($Blit->get_requests());

// Ok, run our queue!
$results = $Blit->process();

// Did that work?
if ($results->success()) {
	// Success!
	foreach($results->get_images() as $name => $url) {
		echo "Processed: {$name} at {$url}\n";
	}
} else {
	// EPIC FAIL
	echo 'ERROR: '.$results->get_errors();
}

// Want to see the raw response from Blitline?
//print_r($results->get_raw_data());

/* End of file demo.php */