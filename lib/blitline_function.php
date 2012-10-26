<?php
/**
 * "Function" object instance for Blitline PHP Wrapper
 * A stand-in class to create 'function' requests with Blitline's API.
 * You'd think, "Hey, just use arrays, no need for functions, this is JSON"
 * And you'd be wrong.  They do some weird stuff and it falls apart at things like:
 * {
 * "application_id": "YOUR_APP_ID",
 * "src" : "YOUR_IMAGE_SOURCE",
 * "functions" : [{
 *    "name": "rotate",
 *    "params" : "90",
 *    "save" : { "image_identifier" : "MY_ROTATED_IMAGE"} },
 *    "functions" : [{
 *       "name" : "resize_to_fill", // Easy crop method
 *       "params" : { "width" : 100, "height" : 100 }
 *       "save" : { "image_identifier" : "MY_ROTATED_AND_CROPPED_IMAGE"}
 *      },
 *       "name" : "resize_to_fill", // Easy crop method
 *       "params" : { "width" : 50, "height" : 50 },
 *       "save" : { "image_identifier" : "MY_ROTATED_AND_SMALLER_CROPPED_IMAGE"}
 *      }
 *    }]
 * }]}
 *
 * @author Mike Karikas, @mkarikas, mike at karikas point com
 * @version 0.1 first shot, 2012-10-26
 *
 */

class Blitline_function {
	public $name;
	public $params;
	public $save;

	function __construct($name='', $params=array(), $save=array()) {
		if ($name) $this->set_name($name);
		if ($params) $this->set_params($params);
		if ($save) $this->set_save($save);
	}

	/**
	 * Pass in a Blitline_function object here to add a child process.
	 *
	 * @param Blitline_function $functions Blitline_function object
	 */
	function add_function($functions) {
		if ($functions) {
			$this->functions = array($functions);
		}
	}

	public function set_name($name='') {
		$this->name = $name;
	}

	public function get_name() {
		return $this->name;
	}

	public function set_params($params=array()) {
		$this->params = $params;
	}

	public function get_params() {
		return $this->params;
	}

	public function set_save($save=array()) {
		$this->save = $save;
	}

	public function clear_save($save=array()) {
		unset($this->save);
	}

	public function get_save() {
		return $this->save;
	}

}

/* End of file blitline_function.php */