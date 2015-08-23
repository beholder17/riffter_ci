<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Slider extends MX_Controller {

	public function index($slider_name=NULL)
	{
		if ($slider_name!=NULL) {
		$this->load->model('slider/slider_m');
		$data['slider_body'] = $this->slider_m->getslider($slider_name);
		
		/* Get slider's images */
		$data['slider_images'] = unserialize($data['slider_body'][0]['data']);
		$this->load->view('slider/slider_main_v',$data);
		} else {echo 'slider name was not select';		
		}
	}
	
	

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */