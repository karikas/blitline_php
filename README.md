# PHP wrapper for Blitline API

This is a PHP wrapper for Blitline's cloud-based image processing API, by Michael Karikas (@mkarikas).  I have nothing to do with Blitline but really wanted to use their system in our PHP code... hence this library.

## Prerequisites
Before using this library, please ensure you have an application ID from Blitline - see www.blitline.com for details.  They start you off with a free account, it's easy!
You'll need to be running PHP 5.3 and have CURL installed, I believe that's it.

## How to use this

First, get your API key.  You can either pass this in when instantiating Blitline or set a constant called BLITLINE_APP_ID before instantiating your Blitline object.
The workflow here is:
- Instantiate once
- Load image
- Set S3 destination information (optional)
- Add filters, in order of operation
- Optional - start another request and repeat the process.  This allows multiple sets of operations with the same source file!
- Process

So, here's a basic example.  This will take an image and resize it to 256x256, then apply default sharpening, and return the generated file location.

```php
define('BLITLINE_APP_ID', 'YOUR-APP-ID-FROM-BLITLINE-DOT-COM');
include('lib/blitline_php.php');

$src = 'http://p.twimg.com/Atb2B0MCAAADLk6.jpg';

$Blit = new Blitline_php();
$Blit->load($src);
$Blit->do_resize_to_fill(256, 256);
$Blit->do_sharpen();

$results = $Blit->process();
if ($results->success()) {
	foreach($results->get_images() as $name => $url) {
		echo "Processed: {$name} at {$url}\n";
	}
} else {
	print_r($results->get_errors());
}
```

This example would make three thumbnails in different sizes and save them:

```php
define('BLITLINE_APP_ID', 'YOUR-APP-ID-FROM-BLITLINE-DOT-COM');
include('lib/blitline_php.php');

$src = 'http://placekitten.com/1024/768';

$Blit = new Blitline_php();
$Blit->load($src, 'kitten-256.jpg'); // Passing in our own image identifier

// Resize 256 pixel image
$Blit->do_resize_to_fill(256, 256);

// 512 pixel image, sharpened, 45 % quality
$Blit->set_image_id('kitten-512.jpg');
$Blit->set_jpg_quality(45);
$Blit->do_resize_to_fit(512, 512);
$Blit->do_sharpen();

// One more tiny one for fun
$Blit->new_request();
$Blit->set_image_id('kitten-48.jpg');
$Blit->set_jpg_quality(75);
$Blit->do_resize_to_fill(48, 48);

$results = $Blit->process();
if ($results->success()) {
	foreach($results->get_images() as $name => $url) {
		echo "Processed: {$name} at {$url}\n";
	}
} else {
	print_r($results->get_errors());
}
```

...at this point there aren't many functions supported, but I wanted to get this library up as soon as it was working.

## Want to save to an Amazon AWS S3 bucket?
You can also configure this to save to an S3 bucket.  First, you'll need to follow Blitline's guide at http://www.blitline.com/docs/s3_permissions to add permissions to your target S3 bucket before trying to save anything there.

Somewhere between instantiating the class and calling process(), set $Blit->set_s3_target($bucket, $key, $headers), where:
    - $bucket is the name of your blitline-approved bucket
    - $key is the key/filename to save it as.  Note that "folders" work here as well.
    - $headers is an optional associative array of additional header values.  Refer to http://www.blitline.com/docs/s3_headers and http://docs.amazonwebservices.com/AmazonS3/latest/API/RESTObjectPUT.html

For example, a quickie would be:

```php
$Blit = new Blitline_php('YOUR-API-KEY');
$Blit->load('http://img.gawkerassets.com/img/17wen4d92trn3jpg/original.jpg');
$Blit->set_s3_target('my-s3-bucket', 'thumbs/tranquil-countryside.jpg');
$Blit->do_resize_to_fill(72, 72);
$Blit->process();
```

Note that if you're doing multiple requests you need to set the S3 Target for each image you're saving, otherwise it'll recklessly overwrite the original each time.

You can also clear the s3 target by calling clear_s3_target().

## Things to know
    - Your source file absolutely has to come from a public URL, no local paths allowed.  That's just how Blitline works.
    - The image URLs returned by Blitline will NOT be valid when returned to you, Blitline queues the image processing so it may take up to several seconds for your images to appear there.  To know if your image is really done processing, you would need to poll your job id, but that's not in the API yet.
    - Want to see a log of everything that's happened so far?  Call get_log(); to return or get_log(TRUE) to echo.
    - Want to see a log of all ERRORS that've happened so far?  Call get_errors(); to return or get_errors(TRUE) to echo.
    - Want to see if an error has happened?  Call error_occurred(), returns TRUE/FALSE.
    - Want to see the log/errors as you go?  Call debug_on() (there's also a debug_off() )
    - This is so totally alpha-beta, dude.

## To-do list
    - Add all additional filters/functions from the Blitline API
    - Add support for saving down to 8 bit PNGs
    - Add additional error checking
    - Add support for polling
    - Additional documentation