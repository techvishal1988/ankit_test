<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Security extends CI_Security
{
	public function csrf_show_error()
	{	
		header('Location: ' . $_SERVER['HTTP_REFERER']);
		//redirect($_SERVER['HTTP_REFERER']);
		exit(1);
		//show_error('The action you have requested is not allowed.', 403);
		
		//header('Location: ' . $_SERVER['HTTP_REFERER']);
		//header('Location: ' . htmlspecialchars($_SERVER['REQUEST_URI']), TRUE, 200);
	}
}
