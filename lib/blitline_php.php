<?php
/**
 * Blitline PHP Wrapper - using Blitline's cloud-based image processing API the easy way!
 * Easy enough if you use PHP of course, with this library.
 * So easy even babies and dogs can use it (see http://phabricator.org/)
 *
 * @author Mike Karikas, @mkarikas, mike at karikas point com
 * @version 0.1 first shot, 2012-10-26
 *
 */

// File types
define('BLITLINE_JPG', 'jpg');
define('BLITLINE_PNG', 'png');
define('BLITLINE_DEFAULT', 'default');

// Gravity directions for cropping/watermarks/etc
define('BLITLINE_GRAVITY_NORTH', 'NorthGravity');
define('BLITLINE_GRAVITY_NORTHWEST', 'NorthWestGravity');
define('BLITLINE_GRAVITY_NORTHEAST', 'NorthEastGravity');
define('BLITLINE_GRAVITY_SOUTH', 'SouthGravity');
define('BLITLINE_GRAVITY_SOUTHWEST', 'SouthWestGravity');
define('BLITLINE_GRAVITY_SOUTHEAST', 'SouthEastGravity');
define('BLITLINE_GRAVITY_CENTER', 'CenterGravity');

define('BLITLINE_COMPOSITE_UNDEFINED', 'UndefinedCompositeOp'); // No composite operator has been specified.
define('BLITLINE_COMPOSITE_ADD', 'AddCompositeOp'); // The result of composite image + image, with overflow wrapping around (mod 256)
define('BLITLINE_COMPOSITE_ATOP', 'AtopCompositeOp'); // The result is the same shape as image, with composite image obscuring image where the image shapes overlap. Note that this differs from OverCompositeOp because the portion of composite image outside of image’s shape does not appear in the result.
define('BLITLINE_COMPOSITE_BUMPMAP', 'BumpmapCompositeOp'); // The result image shaded by composite image.
define('BLITLINE_COMPOSITE_COLORBURN', 'ColorBurnCompositeOp'); // Darkens the destination color to reflect the source color. Painting with white produces no change.
define('BLITLINE_COMPOSITE_COLORDODGE', 'ColorDodgeCompositeOp'); // Brightens the destination color to reflect the source color. Painting with black produces no change.
define('BLITLINE_COMPOSITE_COLORIZE', 'ColorizeCompositeOp'); // Each pixel in the result image is the combination of the brightness of the target image and the saturation and hue of the composite image. This is the opposite of LuminizeCompositeOp.
define('BLITLINE_COMPOSITE_COPY', 'CopyCompositeOp'); // Replace the target image with the composite image.
define('BLITLINE_COMPOSITE_COPYBLACK', 'CopyBlackCompositeOp'); // Copy the black channel from the composite image to the target image.
define('BLITLINE_COMPOSITE_COPYBLUE', 'CopyBlueCompositeOp'); // Copy the blue channel from the composite image to the target image.
define('BLITLINE_COMPOSITE_COPYCYAN', 'CopyCyanCompositeOp'); // Copy the cyan channel from the composite image to the target image.
define('BLITLINE_COMPOSITE_COPYGREEN', 'CopyGreenCompositeOp'); // Copy the green channel from the composite image to the target image.
define('BLITLINE_COMPOSITE_COPYMAGENTA', 'CopyMagentaCompositeOp'); // Copy the magenta channel from the composite image to the target image.
define('BLITLINE_COMPOSITE_COPYOPACITY', 'CopyOpacityCompositeOp'); // If the composite image’s matte attribute is true, copy the opacity channel from the composite image to the target image. Otherwise, set the target image pixel’s opacity to the intensity of the corresponding pixel in the composite image.
define('BLITLINE_COMPOSITE_COPYRED', 'CopyRedCompositeOp'); // Copy the red channel from the composite image to the target image.
define('BLITLINE_COMPOSITE_COPYYELLOW', 'CopyYellowCompositeOp'); // Copy the yellow channel from the composite image to the target image.
define('BLITLINE_COMPOSITE_DARKEN', 'DarkenCompositeOp'); // Replace target image pixels with darker pixels from the composite image.
define('BLITLINE_COMPOSITE_DIFFERENCE', 'DifferenceCompositeOp'); // The result of abs(composite image - image). This is useful for comparing two very similar images.
define('BLITLINE_COMPOSITE_DISPLACE', 'DisplaceCompositeOp'); // Displace target image pixels as defined by a displacement map. The operator used by the displace method.
define('BLITLINE_COMPOSITE_DISSOLVE', 'DissolveCompositeOp'); // The operator used in the dissolve method.
define('BLITLINE_COMPOSITE_DSTATOP', 'DstAtopCompositeOp'); // The part of the destination lying inside of the source is composited over the source and replaces the destination.
define('BLITLINE_COMPOSITE_DSTIN', 'DstInCompositeOp'); // The part of the destination lying inside of the source replaces the destination.
define('BLITLINE_COMPOSITE_DSTOUT', 'DstOutCompositeOp'); // The part of the destination lying outside of the source replaces the destination.
define('BLITLINE_COMPOSITE_DSTOVER', 'DstOverCompositeOp'); // The destination is composited over the source and the result replaces the destination.
define('BLITLINE_COMPOSITE_EXCLUSION', 'ExclusionCompositeOp'); // Produces an effect similar to that of ’difference’, but appears as lower contrast. Painting with white inverts the destination color. Painting with black produces no change.
define('BLITLINE_COMPOSITE_HARDLIGHT', 'HardLightCompositeOp'); // Multiplies or screens the colors, dependent on the source color value. If the source color is lighter than 0.5, the destination is lightened as if it were screened. If the source color is darker than 0.5, the destination is darkened, as if it were multiplied. The degree of lightening or darkening is proportional to the difference between the source color and 0.5. If it is equal to 0.5 the destination is unchanged. Painting with pure black or white produces black or white.
define('BLITLINE_COMPOSITE_HUE', 'HueCompositeOp'); // Each pixel in the result image is the combination of the hue of the target image and the saturation and brightness of the composite image.
define('BLITLINE_COMPOSITE_IN', 'InCompositeOp'); // The result is simply composite image cut by the shape of image. None of the image data of image is included in the result.
define('BLITLINE_COMPOSITE_LIGHTEN', 'LightenCompositeOp'); // Replace target image pixels with lighter pixels from the composite image.
define('BLITLINE_COMPOSITE_LINEARBURN', 'LinearBurnCompositeOp'); // Same as LinearDodgeCompositeOp, but also subtract one from the result. Sort of a additive ’Screen’ of the images.
define('BLITLINE_COMPOSITE_LINEARDODGE', 'LinearDodgeCompositeOp'); // This is equivelent to PlusCompositeOp in that the color channels are simply added, however it does not "plus" the alpha channel, but uses the normal OverCompositeOp alpha blending, which transparencies are involved. Produces a sort of additive multiply-like result.
define('BLITLINE_COMPOSITE_LINEARLIGHT', 'LinearLightCompositeOp'); // Increase contrast slightly with an impact on the foreground’s tonal values.
define('BLITLINE_COMPOSITE_LUMINIZE', 'LuminizeCompositeOp'); // Each pixel in the result image is the combination of the brightness of the composite image and the saturation and hue of the target image. This is the opposite of ColorizeCompositeOp.
define('BLITLINE_COMPOSITE_MINUS', 'MinusCompositeOp'); // The result of composite image - image, with overflow cropped to zero. The matte chanel is ignored (set to 255, full coverage).
define('BLITLINE_COMPOSITE_MULTIPLY', 'MultiplyCompositeOp'); // Multiplies the color of each target image pixel by the color of the corresponding composite image pixel. The result color is always darker.
define('BLITLINE_COMPOSITE_NO', 'NoCompositeOp'); // No composite operator has been specified.
define('BLITLINE_COMPOSITE_OUT', 'OutCompositeOp'); // The resulting image is composite image with the shape of image cut out.
define('BLITLINE_COMPOSITE_OVER', 'OverCompositeOp'); // The result is the union of the the two image shapes with composite image obscuring image in the region of overlap. The matte channel of the composite image is respected, so that if the composite pixel is part or all transparent, the corresponding image pixel will show through.
define('BLITLINE_COMPOSITE_OVERLAY', 'OverlayCompositeOp'); // Multiplies or screens the colors, dependent on the destination color. Source colors overlay the destination whilst preserving its highlights and shadows. The destination color is not replaced, but is mixed with the source color to reflect the lightness or darkness of the destination.
define('BLITLINE_COMPOSITE_PINLIGHT', 'PinLightCompositeOp'); // Similar to HardLightCompositeOp, but using sharp linear shadings, to similate the effects of a strong ’pinhole’ light source.
define('BLITLINE_COMPOSITE_PLUS', 'PlusCompositeOp'); // The result is just the sum of the image data. Output values are cropped to 255 (no overflow). This operation is independent of the matte channels.
define('BLITLINE_COMPOSITE_REPLACE', 'ReplaceCompositeOp'); // The resulting image is image replaced with composite image. Here the matte information is ignored.
define('BLITLINE_COMPOSITE_SATURATE', 'SaturateCompositeOp'); // Each pixel in the result image is the combination of the saturation of the target image and the hue and brightness of the composite image.
define('BLITLINE_COMPOSITE_SCREEN', 'ScreenCompositeOp'); // Multiplies the inverse of each image’s color information.
define('BLITLINE_COMPOSITE_SOFTLIGHT', 'SoftLightCompositeOp'); // Darkens or lightens the colors, dependent on the source color value. If the source color is lighter than 0.5, the destination is lightened. If the source color is darker than 0.5, the destination is darkened, as if it were burned in. The degree of darkening or lightening is proportional to the difference between the source color and 0.5. If it is equal to 0.5, the destination is unchanged. Painting with pure black or white produces a distinctly darker or lighter area, but does not result in pure black or white.
define('BLITLINE_COMPOSITE_SRCATOP', 'SrcAtopCompositeOp'); // The part of the source lying inside of the destination is composited onto the destination.
define('BLITLINE_COMPOSITE_SRC', 'SrcCompositeOp'); // The source is copied to the destination. The destination is not used as input.
define('BLITLINE_COMPOSITE_SRCIN', 'SrcInCompositeOp'); // The part of the source lying inside of the destination replaces the destination.
define('BLITLINE_COMPOSITE_SRCOUT', 'SrcOutCompositeOp'); // The part of the source lying outside of the destination replaces the destination.
define('BLITLINE_COMPOSITE_SRCOVER', 'SrcOverCompositeOp'); // The source is composited over the destination.
define('BLITLINE_COMPOSITE_SUBTRACT', 'SubtractCompositeOp'); // The result of composite image - image, with underflow wrapping around (mod 256). The add and subtract operators can be used to perform reversable transformations.
define('BLITLINE_COMPOSITE_XOR', 'XorCompositeOp'); // The result is the image data from both composite image and image that is outside the overlap region. The overlap region will be blank.

// Include our buddy classes
require_once('blitline_function.php');
require_once('blitline_response.php');

class Blitline_php {
	// Essentials
	protected $api_source; // API endpoint for running a job
	protected $app_id; // APP ID from your Blitline account
	protected $data_errors; // Running array of errors
	protected $data_log; // Running array of logged data for debugging
	protected $debug; // Debugging on or off

	// Blitline options
	protected $bl_image_identifier; // Image identifier
	protected $bl_file_format; // File format
	protected $bl_jpg_quality; // JPG quality
	// TODO: "png_quantize":true for PNG 8-bit
	protected $bl_image_src; // Image URL source
	protected $bl_postback_url; // Postback URL on completion
	protected $bl_s3_bucket; // S3 target bucket
	protected $bl_s3_key; // S3 target key (filename)
	protected $bl_s3_headers; // S3 target headers array

	// Tracking what we're doing
	public $requests; // Array of operations to perform
	public $current_request; // Current request we're working on
	public $result; // We store our results object here

	/**
	 * Set all default settings and set our APP ID (required)
	 *
	 * @param string $app_id Blitline APP ID (required)
	 */
	function __construct($app_id='') {
		$this->api_source = 'http://api.blitline.com/job';
		$this->data_errors = array();
		$this->data_log = array();
		$this->debug_off();

		$this->current_request = FALSE;
		$this->requests = array();
		$this->result = array();

		// Default settings
		$this->set_image_id();
		$this->set_file_format('jpg');
		$this->set_jpg_quality();
		$this->set_s3_bucket();
		$this->set_s3_key();
		$this->set_s3_headers();

		// Try and set our app id
		$this->set_app_id($app_id);

		// Start a new request
		$this->new_request();
	}

	/***********************
	 * GETTERS AND SETTERS
	 **********************/

	/**
	 * Set our App ID - from Blitline.
	 * Can pass in as a string or set as the constant BLITLINE_APP_ID
	 *
	 * @param string $app_id
	 * @return bool success
	 */
	function set_app_id($app_id='') {
		if (!empty($app_id)) {
			$this->log("Setting APP ID");
			$this->app_id = $app_id;
		} elseif (defined('BLITLINE_APP_ID')) {
			$this->log("Setting APP ID from BLITLINE_APP_ID");
			$this->app_id = BLITLINE_APP_ID;
		} else {
			$this->error('No APP ID provided! Pass it in or set BLITLINE_APP_ID.');
			return FALSE;
		}

		return TRUE;
	}

	/**
	 * Return our App ID.
	 *
	 * @return string
	 */
	function get_app_id() {
		return $this->app_id;
	}

	/**
	 * Set our image identifier for this image, required by Blitline
	 * If no value is passed in, sets it to our current timestamp
	 *
	 * @param string $image_id Image identifier
	 * @return bool success
	 */
	function set_image_id($image_id='') {
		($image_id) ? $ok_image_id = $image_id : $ok_image_id = time();
		$this->log("Setting image id to '{$ok_image_id}'");

		$this->bl_image_identifier = $ok_image_id;
		return TRUE;
	}

	/**
	 * Return the image identifier
	 *
	 * @return string
	 */
	function get_image_id() {
		return $this->bl_image_identifier;
	}

	/**
	 * Set the return file format - BLITLINE_JPG, BLITLINE_PNG or BLITLINE_DEFAULT
	 * Can also pass in blank for the default
	 *
	 * @param string $format BLITLINE_JPG|BLITLINE_PNG|BLITLINE_DEFAULT or empty for default
	 * @return bool success
	 */
	function set_file_format($format='') {
		$ok_format = strtolower($format);
		if (!$ok_format) $ok_format = 'default';
		$this->log("Setting file format to '{$ok_format}'");

		if (in_array($ok_format, array(BLITLINE_JPG, BLITLINE_PNG, BLITLINE_DEFAULT)) ) {
			$this->bl_file_format = $ok_format;
			return TRUE;
		} else {
			$this->error("Invalid file format passed ({$format}), needs to be JPG, PNG, or default.");
			return FALSE;
		}
	}

	/**
	 * Return the file format
	 * BLITLINE_JPG, BLITLINE_PNG or BLITLINE_DEFAULT
	 *
	 * @return string
	 */
	function get_file_format() {
		return $this->bl_file_format;
	}

	/**
	 * Set the quality of our resulting jpgs, between 1 and 100, 100 is best quality.
	 *
	 * @param int $quality 1-100, higher is better
	 * @return bool success
	 */
	function set_jpg_quality($quality=75) {
		$ok_quality = intval($quality);
		$this->log("Setting JPG quality to '{$ok_quality}'");

		if ($quality > 0 && $quality <= 100) {
			$this->bl_jpg_quality = $quality;
			return TRUE;
		} else {
			$this->error("Invalid JPG quality level ({$quality}), needs to be between 1 and 100.");
			return FALSE;
		}
	}

	/**
	 * Return JPG quality, 1 - 100
	 * @return int
	 */
	function get_jpg_quality() {
		return $this->bl_jpg_quality;
	}

	/**
	 * Set your postback URL, to be pinged after photo processing
	 * Leave the $url blank to clear it.
	 *
	 * @param string $url Postback URL, or blank to clear
	 * @return bool success
	 */
	function set_postback_url($url='') {
		$this->log("Setting postback URL to '{$url}'");
		$this->bl_postback_url = $url;
		return TRUE;
	}

	/**
	 * Return our postback url, if it even exists
	 * @return mixed
	 */
	function get_postback_url() {
		return $this->bl_postback_url;
	}

	/**
	 * Return our image source
	 *
	 * @return string
	 */
	function get_image_src() {
		return $this->bl_image_src;
	}

	/**
	 * Set our S3 target info (optional)
	 * This will tell our processing to save directly to S3 upon image processing completion
	 * You should be setup for this first by following http://www.blitline.com/docs/s3_permissions
	 *
	 * @param string $bucket
	 * @param string $key
	 * @param array $headers Associative array of headers
	 */
	function set_s3_target($bucket, $key, $headers=array()) {
		$this->set_s3_bucket($bucket);
		$this->set_s3_key($key);
		if ($headers) $this->set_s3_headers($headers);
	}

	/**
	 * Clear our S3 target - so no more saving to S3
	 */
	function clear_s3_target() {
		$this->log("Clearing S3 target");
		$this->set_s3_bucket();
		$this->set_s3_key();
		$this->set_s3_headers();
	}

	/**
	 * Set our S3 target bucket
	 *
	 * @param string $input
	 */
	function set_s3_bucket($input='') {
		if ($input) $this->log("Setting S3 target bucket to {$input}");
		$this->bl_s3_bucket = $input;
	}

	/**
	 * Return our S3 target bucket
	 *
	 * @return string
	 */
	function get_s3_bucket() {
		return $this->bl_s3_bucket;
	}

	/**
	 * Set our S3 target key/filename
	 *
	 * @param string $input
	 */
	function set_s3_key($input='') {
		if ($input) $this->log("Setting S3 target key/filename to {$input}");
		$this->bl_s3_key = $input;
	}

	/**
	 * Return our S3 target key/filename
	 *
	 * @return string
	 */
	function get_s3_key() {
		return $this->bl_s3_key;
	}

	/**
	 * Set our S3 target headers (array) - see http://www.blitline.com/docs/s3_headers
	 *
	 * @param array $headers associative array of headers
	 */
	function set_s3_headers($headers=array()) {
		if ($headers) $this->log("Setting S3 target headers to something");
		$this->bl_s3_headers = (array)$headers;
	}

	/**
	 * Return our S3 target headers array
	 *
	 * @return array
	 */
	function get_s3_headers() {
		return $this->bl_s3_headers;
	}


	/**
	 * Return our array of pending requests
	 *
	 * @return array
	 */
	function get_requests() {
		return $this->requests;
	}

	/**
	 * Return our current request
	 *
	 * @return array
	 */
	function get_current_request() {
		return $this->current_request;
	}

	/***********************
	 * INTERNAL OPERATIONS
	 **********************/

	/**
	 * Write a message to our internal log array
	 * Pass in TRUE as the second arg or call debug_on() to echo as well
	 *
	 * @param string $msg
	 * @param bool $echo Output message (FALSE by default)
	 */
	protected function log($msg='', $echo = FALSE) {
		if ($msg) {
			$this->data_log[] = $msg;
			if ($echo || $this->debug) echo "{$msg}\n";
		}
	}

	/**
	 * Retrieve the log, or pass in TRUE to output it to the browser/console.
	 *
	 * @param bool $echo Output log (FALSE by default)
	 * @return mixed
	 */
	function get_log($echo = FALSE) {
		if ($echo) {
			foreach($this->data_log as $line) {
				echo "{$line}\n";
			}
		}
		return $this->data_log;
	}

	/**
	 * Trigger an error report, note that this doesn't currently trigger a real PHP error (though that would make sense)
	 * Just logs it for echoing or later retrieval
	 * Pass in TRUE as a second arg to echo to the browser (also does that when debug_on() is called)
	 * @param string $msg Error message
	 * @param bool $echo
	 */
	protected function error($msg='', $echo = FALSE) {
		if ($msg) {
			$this->data_errors[] = $msg;
			$this->log("ERROR: {$msg}", ($echo || $this->debug));
		}
	}

	/**
	 * Retrieve the error log, or pass in TRUE to output it to the browser/console.
	 *
	 * @param bool $echo Output log (FALSE by default)
	 * @return mixed
	 */
	function get_errors($echo = FALSE) {
		if ($echo) {
			foreach($this->data_errors as $line) {
				echo "{$line}\n";
			}
		}
		return $this->data_errors;
	}

	/**
	 * Has an error occurred?  Call this and you'll get a TRUE or FALSE to that question.
	 * @return bool error occurred
	 */
	function error_occurred() {
		return (count($this->data_errors) > 0);
	}

	/**
	 * Turn on debugging - echo everything that happens.
	 */
	function debug_on() {
		$this->debug = TRUE;
	}

	/**
	 * Turn off debugging - no echos.
	 */
	function debug_off() {
		$this->debug = FALSE;
	}

	/**
	 * Start a new processing request
	 * If we had one already, add it to our pile of existing requests
	 */
	function new_request() {
		// If we already have a request in progress, save that to our list of requests
		if ($this->current_request) {
			$this->save_request();
		}

		// I know this is possible happening twice, since we also set $this->current_request to FALSE in save_request(),
		// but it sure makes things easier and ensures we can count on $current_request to be empty when everything's
		// "committed".
		$this->log("Setting up new image processing request");
		$this->current_request = FALSE;
	}

	/**
	 * Add a new function to our current cascading list of commands (single request of 1+ operations)
	 * This in an internal function, don't touch me =P
	 *
	 * @param string $name
	 * @param array $params
	 */
	protected function add_to_request($name, $params) {
		$func = new Blitline_function(
			$name,
			$params,
			$this->build_save_command()
		);

		// Is this new?
		if (!$this->current_request) {
			// It is new!  First request.
			// We store this in an array element because that makes our recursive stuff fit with how Blitline likes requests
			$this->current_request = array($func);
		} else {
			// Nope, already doing something.  Recursively loop through until we find a place to fit, then add ourselves.
			$this->add_to_current_request_functions($this->current_request, $func, 0);
		}
	}

	/**
	 * Add a new function 'inside' of the current one.  This is a recursive function
	 * While we're at it, modify any values up the trail to be PNGs for maximum quality awesomeness
	 * Also alter the image identifier to be unique
	 *
	 * @param array $level Array of [0] => Blitline_function object in question
	 * @param Blitline_function $func New Blitline_function to be added
	 * @param int $counter What level we're on
	 */
	protected function add_to_current_request_functions($level, $func, $counter) {
		// First, alter our values for this point in our 'tree' for best quality and a unique name
		$level[0]->clear_save(); // No need to save

		// Commented this out, if you wanted to save each image as you went this would be helpful, but is unnecessary
		// if all you want is the final image
		//$level->set_save( $this->build_save_command( $this->get_image_id() . "-{$counter}", BLITLINE_PNG) );

		// Is this the end of our current tree, so we can add our new function?
		if (!isset($level[0]->functions)) {
			$level[0]->add_function($func);
		} else {
			// Nope, we must go deeper down the rabbit hole (take a left at Albuquerque)
			$this->add_to_current_request_functions($level[0]->functions, $func, $counter+1);
		}
	}

	/**
	 * Save/commit our current request to our array of requests
	 *
	 * @return bool success
	 */
	function save_request() {
		$this->log("Saving request");
		if ($this->current_request[0]) {
			$this->requests[] = $this->current_request[0];

			// Clear our current request so we know we're "committed"
			$this->log("Clearing existing image processing request");
			$this->current_request = FALSE;
			return TRUE;
		} else {
			$this->error("Could not save request, current request is empty!");
			return FALSE;
		}
	}

	/**
	 * Assemble a "Save" request for Blitline operations
	 * Just pulls together what we've already specified
	 *
	 * Note that while we validate the default values, values passed in here are not validated.
	 *
	 * Can pass in overrides here as well for our default settings
	 *
	 * @param bool $id_override
	 * @param bool $format_override
	 * @param bool $quality_override
	 * @return array
	 */
	protected function build_save_command($id_override = FALSE, $format_override = FALSE, $quality_override = FALSE) {
		$save = array();

		// Image identifier
		if ($id_override) {
			$save['image_identifier'] = $id_override;
		} else {
			$save['image_identifier'] = $this->get_image_id();
		}

		// File format
		if ($format_override) {
			$save['extension'] = $format_override;
		} else {
			if ($this->get_file_format() != BLITLINE_DEFAULT) {
				$save['extension'] = $this->get_file_format();
			}
		}

		// JPG quality
		if ($quality_override) {
			$save['quality'] = $quality_override;
		} else {
			$valid_for_quality = array(BLITLINE_JPG, BLITLINE_DEFAULT);
			if ( (!$format_override && in_array($this->get_file_format(), $valid_for_quality) ) ||
					 ( $format_override && in_array($format_override, $valid_for_quality)) ) {
				$save['quality'] = $this->get_jpg_quality();
			}
		}

		// S3 destination?
		if ($this->get_s3_bucket() && $this->get_s3_key()) {
			$save['s3_destination'] = array();
			$save['s3_destination']['bucket'] = $this->get_s3_bucket();
			$save['s3_destination']['key'] = $this->get_s3_key();
			if ($this->get_s3_headers()) {
				$save['s3_destination']['headers'] = $this->get_s3_headers();
			}
		}

		return $save;
	}

	/**
	 * Set our input image file - MUST be a full URL!
	 * If this function doesn't think it's valid we'll return FALSE, but will proceed regardless.
	 * Also pass in an image id if you want, otherwise we'll use the basename of this file.
	 *
	 * @param string $src source url
	 * @param string $image_identifier If you don't want us to use the filename
	 * @return bool success (if we think it's a success)
	 */
	function load($src='', $image_identifier='') {
		// Did we pass in an id, or do we set a default image id based on the image name?
		if ($image_identifier) {
			$this->set_image_id( $image_identifier );
		} else {
			$this->set_image_id( basename($src) );
		}

		$this->log("Loading source image url: {$src}");
		$this->bl_image_src = $src;

		if ($src != filter_var($src, FILTER_VALIDATE_URL)) {
			$this->error("...but I don't think it'll work, doesn't look like a URL to me!");
			return FALSE;
		} else {
			// URL looks good to us
			return TRUE;
		}
	}

	/**
	 * Process our commands - send it to Blitline!
	 * Godspeed, little images
	 *
	 * @return Blitline_response
	 */
	function process() {
		$this->log("Sending request to process images...");

		// If we haven't saved our current request, do so now
		if ($this->current_request) {
			$this->save_request();
		}

		$request = array(
			'application_id' => $this->get_app_id(),
			'src' => $this->get_image_src(),
			'functions' => $this->requests
		);

		// Make CURL request of json => encoded json string
		$http_query = http_build_query(array('json' => json_encode($request) ));
		//$this->log("Sending request: ".json_encode($request) );
		$this->log("Sending request to Blitline...");

		$ch = curl_init($this->api_source);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $http_query);
		$this->result = new Blitline_response( curl_exec($ch) );
		if ($this->result->success()) {
			$this->log("Success!");
		} else {
			$this->error('ERROR: '.$this->result->get_errors());
		}

		// Clear our requests/queue
		$this->current_request = FALSE;
		$this->requests = array();

		return $this->result;
	}

	/**************************************************************
	 * GOOD STUFF - ACTUAL BLITLINE COMMANDS
	 * MIMICS FUNCTIONS AT http://www.blitline.com/docs/functions
	 *************************************************************/

	/**
	 * Composites one image onto another
	 *
	 * @param string $src Source Url of image you wants composited with original image
	 * @param bool $as_mask TRUE or FALSE to use src as a greyscale mask (defaults to false)
	 * @param int $x X offset of where to place image on original image
	 * @param int $y Y offset of where to place image on original image
	 * @param string $composite_op How composite is to be applied. Defaults to "BLITLINE_COMPOSITE_OVER" (overlayed)
	 */
	function do_composite($src, $as_mask=FALSE, $x=0, $y=0, $composite_op=BLITLINE_COMPOSITE_OVER) {
		$this->log("Compositing: {$src}, {$as_mask}, {$x}, {$y}, {$composite_op}");
		$params = array(
			'src' => $src,
			'as_mask' => $as_mask,
			'x' => $x,
			'y' => $y,
			'composite_op' => $composite_op
		);

		$this->add_to_request('composite', $params);
	}

	/**
	 * Resize the image to fit within the specified dimensions while retaining the aspect ratio of the original image.
	 * If necessary, crop the image in the larger dimension
	 *
	 * Common English Translation: This is probably the crop you want if you want to cut a center piece out of a photo
	 * and use it as a thumbnail. This wont do any scaling, only cut out the center (by default) to your defined size.
	 *
	 * @param int $width Width of desired image
	 * @param int $height Height of desired image
	 * @param string $gravity Location of crop (defaults to BLITLINE_GRAVITY_CENTER)
	 * @param bool $only_shrink_larger Don't upsize image (defaults to FALSE)
	 */
	function do_resize_to_fill($width=40, $height=40, $gravity=BLITLINE_GRAVITY_CENTER, $only_shrink_larger=FALSE) {
		$this->log("Resize-to-fill: {$width} x {$height}, {$gravity}, {$only_shrink_larger}");
		$params = array(
			'width' => $width,
			'height' => $height,
			'gravity' => $gravity,
			'only_shrink_larger' => $only_shrink_larger
		);

		$this->add_to_request('resize_to_fill', $params);
	}

	/**
	 * Resize the image to fit within the specified dimensions while retaining the original aspect ratio.
	 * The image may be shorter or narrower than specified in the smaller dimension but will not be larger than the
	 * specified values
	 *
	 * Common English Translation: This is probably the crop you want if you need to rescale a photo down to a smaller
	 * size while keeping the same height to width ratio.
	 *
	 * @param int $width Width of desired image
	 * @param int $height Height of desired image
	 * @param bool $only_shrink_larger Don't upsize image (defaults to FALSE)
	 */
	function do_resize_to_fit($width=40, $height=40, $only_shrink_larger=FALSE) {
		$this->log("Resize-to-fit: {$width} x {$height}, $only_shrink_larger");
		$params = array(
			'width' => $width,
			'height' => $height,
			'only_shrink_larger' => $only_shrink_larger
		);

		$this->add_to_request('resize_to_fit', $params);
	}

	/**
	 * Makes a "best guess" crop to upper-left and lower-right corners. For example, if you have an image with a bunch
	 * of white border around it, and you want it cropped to only where there something other than the border color.
	 */
	function do_trim() {
		$this->log("Trimming to remove whitespace");
		$params = new stdClass();

		$this->add_to_request('trim', $params);
	}

	/**
	 * Sharpens the image
	 *
	 * @param float $sigma Gaussian sigma of sharpen (defaults to 1.0)
	 * @param float $radius Gaussian radius of shapen (defaults to 0.0)
	 */
	function do_sharpen($sigma=1.0, $radius=0.0) {
		$this->log("Sharpening: {$sigma} amount, {$radius} radius");
		$params = array(
			'sigma' => $sigma,
			'radius' => $radius
		);

		$this->add_to_request('sharpen', $params);
	}
}
/* End of file blitline_php.php */