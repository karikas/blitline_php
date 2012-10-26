<?php
/**
 * "Response" object instance for Blitline PHP Wrapper
 * It's nice to wrap their response up in an object, I think.
 *
 * @author Mike Karikas, @mkarikas, mike at karikas point com
 * @version 0.1 first shot, 2012-10-26
 *
 */

class Blitline_response {
	public $images;
	public $job_id;
	public $errors;
	private $raw_data;

	/**
	 * Instantiate me with the raw results of our request
	 * @param string $json json string
	 */
	function __construct($json) {
		$this->raw_data = json_decode($json, TRUE);

		if ($this->raw_data['results'] && isset($this->raw_data['results']['images'])) {
			$this->images = $this->raw_data['results']['images'];
		}

		if ($this->raw_data['results'] && isset($this->raw_data['results']['job_id'])) {
			$this->job_id = $this->raw_data['results']['job_id'];
		}

		// Error checking!
		if ($this->raw_data['results'] && isset($this->raw_data['results']['error'])) {
			$this->errors = $this->raw_data['results']['error'];
		}

		// No results?  Who knows what's going on...
		if (!$this->raw_data) {
			$this->errors = "Invalid response, no idea what's going on.  Check the raw response.";
		}
	}

	/**
	 * Return our raw data array
	 *
	 * @return array
	 */
	function get_raw_data() {
		return $this->raw_data;
	}

	/**
	 * Return an associative array of image identifiers pointing to their urls
	 * If there are multiple identical image ids then we tweak'em to be unique.  Only good for iterating at that point.
	 *
	 * Note that if you're doing S3, this will return the link to *your* S3!  I love this so hard.
	 *
	 * @return array
	 */
	function get_images() {
		$out = array();

		if (!$this->images) {
			return FALSE;
		}

		foreach($this->images as $imgkey => $img) {
			if (isset($out[$img['image_identifier']])) {
				$key = "{$img['image_identifier']}-{$imgkey}";
			} else {
				$key = $img['image_identifier'];
			}
			$out[$key] = $img['s3_url'];
		}

		return $out;
	}

	/**
	 * Did we get a successful response?
	 * Really only returns false if we have something in our errors property
	 *
	 * @return bool success
	 */
	function success() {
		return !$this->error_occurred();
	}

	/**
	 * Did an error happen (as far as we can tell)?
	 *
	 * @return bool error occurred
	 */
	function error_occurred() {
		if ($this->errors) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	 * Return whatever's in our errors property
	 *
	 * @return string
	 */
	function get_errors() {
		return $this->errors;
	}
}

/* End of file blitline_response.php */