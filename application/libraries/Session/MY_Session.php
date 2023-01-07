<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2019, British Columbia Institute of Technology
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
 * @copyright	Copyright (c) 2014 - 2019, British Columbia Institute of Technology (https://bcit.ca/)
 * @license	https://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 2.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Session Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Sessions
 * @author		Andrey Andreev
 * @link		https://codeigniter.com/user_guide/libraries/sessions.html
 */
class MY_Session extends CI_Session {

	/**
	 * Userdata array
	 *
	 * Just a reference to $_SESSION, for BC purposes.
	 */
	public $userdata;
	
	protected $_driver = 'files';
	protected $_config;
	protected $_sid_regexp;
	
	// ------------------------------------------------------------------------
	
	/**
	 * Class constructor
	 *
	 * @param	array	$params	Configuration parameters
	 * @return	void
	 */
	public function __construct(array $params = array())
	{
		// No sessions under CLI
		if (is_cli())
		{
			log_message('debug', 'Session: Initialization under CLI aborted.');
			return;
		}
		elseif ((bool) ini_get('session.auto_start'))
		{
			log_message('error', 'Session: session.auto_start is enabled in php.ini. Aborting.');
			return;
		}
		elseif ( ! empty($params['driver']))
		{
			$this->_driver = $params['driver'];
			unset($params['driver']);
		}
		elseif ($driver = config_item('sess_driver'))
		{
			$this->_driver = $driver;
		}
		// Note: BC workaround
		elseif (config_item('sess_use_database'))
		{
			log_message('debug', 'Session: "sess_driver" is empty; using BC fallback to "sess_use_database".');
			$this->_driver = 'database';
		}
	
		$class = $this->_ci_load_classes($this->_driver);
	
		// Configuration ...
		$this->_configure($params);
		$this->_config['_sid_regexp'] = $this->_sid_regexp;
	
		$class = new $class($this->_config);
		if ($class instanceof SessionHandlerInterface)
		{
			/********** Custom code to regenerate ci_session value everytime on login page Start **********/
				$router =& load_class('Router', 'core');			
				if(strtolower($router->fetch_class()) == "home" and $router->fetch_method()=="index")
				{
					$_COOKIE[$this->_config['cookie_name']] ="ravi";
				}
			/********** Custom code to regenerate ci_session value everytime on login page End **********/
			
			if (is_php('5.4'))
			{
				session_set_save_handler($class, TRUE);
			}
			else
			{
				session_set_save_handler(
					array($class, 'open'),
					array($class, 'close'),
					array($class, 'read'),
					array($class, 'write'),
					array($class, 'destroy'),
					array($class, 'gc')
				);
	
				register_shutdown_function('session_write_close');
			}
		}
		else
		{
			log_message('error', "Session: Driver '".$this->_driver."' doesn't implement SessionHandlerInterface. Aborting.");
			return;
		}
	
		// Sanitize the cookie, because apparently PHP doesn't do that for userspace handlers
		if (isset($_COOKIE[$this->_config['cookie_name']])
			&& (
				! is_string($_COOKIE[$this->_config['cookie_name']])
				OR ! preg_match('#\A'.$this->_sid_regexp.'\z#', $_COOKIE[$this->_config['cookie_name']])
			)
		)
		{
			unset($_COOKIE[$this->_config['cookie_name']]);
		}
	
		session_start();
	
		// Is session ID auto-regeneration configured? (ignoring ajax requests)
		if ((empty($_SERVER['HTTP_X_REQUESTED_WITH']) OR strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest')
			&& ($regenerate_time = config_item('sess_time_to_update')) > 0
		)
		{
			if ( ! isset($_SESSION['__ci_last_regenerate']))
			{
				$_SESSION['__ci_last_regenerate'] = time();
			}
			elseif ($_SESSION['__ci_last_regenerate'] < (time() - $regenerate_time))
			{
				$this->sess_regenerate((bool) config_item('sess_regenerate_destroy'));
			}
		}
		// Another work-around ... PHP doesn't seem to send the session cookie
		// unless it is being currently created or regenerated
		elseif (isset($_COOKIE[$this->_config['cookie_name']]) && $_COOKIE[$this->_config['cookie_name']] === session_id())
		{
			setcookie(
				$this->_config['cookie_name'],
				session_id(),
				(empty($this->_config['cookie_lifetime']) ? 0 : time() + $this->_config['cookie_lifetime']),
				$this->_config['cookie_path'],
				$this->_config['cookie_domain'],
				$this->_config['cookie_secure'],
				TRUE
			);
		}
	
		$this->_ci_init_vars();
	
		log_message('info', "Session: Class initialized using '".$this->_driver."' driver.");
	}
	
}