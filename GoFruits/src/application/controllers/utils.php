<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Utils extends CI_Controller {

	public function about()
	{
		$this->load->view('header');
        $this->load->view('about');
        $this->load->view('footer');
	}

    public function contact()
    {
        $this->load->view('header');
        $this->load->view('contact');
        $this->load->view('footer');
    }
}

/* End of file utils.php */
/* Location: ./application/controllers/utils.php */