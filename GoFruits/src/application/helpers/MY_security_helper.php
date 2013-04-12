<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * My extended CodeIgniter Security Helper
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Pablo Molina Toledo
 * @link		http://codeigniter.com/user_guide/helpers/security_helper.html
 */

// ------------------------------------------------------------------------

/**
 * Function to check if an user is logged in the application
 *
 * @access	public
 * @return	bool    whether or not the user is logged in
 */
if ( ! function_exists('isLogged'))
{
	function isLogged()
	{
		$CI =& get_instance();

        //check if there are a user logged
        $check = $CI->session->userdata('correo');

        if($check === false)
            return FALSE;
        return TRUE;
	}
}


/* End of file MY_security_helper.php */
/* Location: ./application/helpers/MY_security_helper.php */