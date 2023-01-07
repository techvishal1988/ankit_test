<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2016, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2016, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Input Class
 *
 * Pre-processes global input data for security
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Input
 * @author		EllisLab Dev Team
 * @link		https://codeigniter.com/user_guide/libraries/input.html
 */
class MY_Input extends CI_Input {

	/**
	 * IP address of the current user
	 *
	 * @var	string
	 */
	protected $ip_address = FALSE;

	/**
	 * Allow GET array flag
	 *
	 * If set to FALSE, then $_GET will be set to an empty array.
	 *
	 * @var	bool
	 */
	protected $_allow_get_array = TRUE;

	/**
	 * Standardize new lines flag
	 *
	 * If set to TRUE, then newlines are standardized.
	 *
	 * @var	bool
	 */
	protected $_standardize_newlines;

	/**
	 * Enable XSS flag
	 *
	 * Determines whether the XSS filter is always active when
	 * GET, POST or COOKIE data is encountered.
	 * Set automatically based on config setting.
	 *
	 * @var	bool
	 */
	protected $_enable_xss = FALSE;

	/**
	 * Enable CSRF flag
	 *
	 * Enables a CSRF cookie token to be set.
	 * Set automatically based on config setting.
	 *
	 * @var	bool
	 */
	protected $_enable_csrf = FALSE;

	/**
	 * List of all HTTP request headers
	 *
	 * @var array
	 */
	protected $headers = array();

	/**
	 * Raw input stream data
	 *
	 * Holds a cache of php://input contents
	 *
	 * @var	string
	 */
	protected $_raw_input_stream;

	/**
	 * Parsed input stream data
	 *
	 * Parsed from php://input at runtime
	 *
	 * @see	CI_Input::input_stream()
	 * @var	array
	 */
	protected $_input_stream;

	protected $security;
	protected $uni;

	// --------------------------------------------------------------------
	
	protected function _clean_input_data($str)
	{
		if (is_array($str))
		{
			$new_array = array();
			foreach (array_keys($str) as $key)
			{
				$new_array[$this->_clean_input_keys($key)] = $this->_clean_input_data($str[$key]);
			}
			return $new_array;
		}

		/* We strip slashes if magic quotes is on to keep things consistent

		   NOTE: In PHP 5.4 get_magic_quotes_gpc() will always return 0 and
		         it will probably not exist in future versions at all.
		*/
		if ( ! is_php('5.4') && get_magic_quotes_gpc())
		{
			$str = stripslashes($str);
		}

		// Clean UTF-8 if supported
		if (UTF8_ENABLED === TRUE)
		{
			$str = $this->uni->clean_string($str);
		}

		// Remove control characters
		$str = remove_invisible_characters($str, FALSE);
		
		
		
		/********** Custom code to remove html & script tags from all the inputs Start **********/
			$router =& load_class('Router', 'core');
			$class_name = strtolower($router->fetch_class());
			$method_name = strtolower($router->fetch_method());
			/*$excluded_methods_arr = array(
										'template',
										'create'
									);
			if(!in_array($method_name, $excluded_methods_arr))
			{
				//$str = strip_tags($str);
				$replaceWith = "";
				$pattern = "/[~#^!$*?><']/";
				return preg_replace($pattern, $replaceWith , $str);
			}*/			
			 
			if(($class_name=="survey" and $method_name=="create") or ($class_name=="survey" and $method_name=="questions_create") or ($class_name=="survey" and $method_name=="questions_edit") or ($class_name=="template" and $method_name=="template") or ($class_name=="admin_dashboard" and $method_name=="employee_graph_create") or ($class_name=="home") and in_array($method_name, array("index","verify_account")) or ($class_name=="dashboard" and $method_name=="change_password"))
			{
				// Note :: No need to anything in this case
			}
			else
			{
				$str = strip_tags($str);
				$replaceWith = "";
				$pattern = "/[".CV_RESTRICTED_SPECIAL_CHARACTERS."]/";/* Note :: Removed char as ~#^!$*?>:<'\/     */
				return preg_replace($pattern, $replaceWith , $str);
			}
		/********** Custom code to remove html & script tags from all the inputs End **********/
		



		// Standardize newlines if needed
		if ($this->_standardize_newlines === TRUE)
		{
			return preg_replace('/(?:\r\n|[\r\n])/', PHP_EOL, $str);
		}

		return $str;
	}

}
