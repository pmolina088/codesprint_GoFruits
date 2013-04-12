<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	public function index()
	{
		//$this->load->view('welcome_message');
        $this->load->view('login');
        $this->load->view('footer');
	}


}

/* End of file user.php */
/* Location: ./application/controllers/user.php */