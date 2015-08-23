<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contacts extends MX_Controller {

	public function index()
	{
		$this->load->library('form_validation');
		
		// Получаем меню для сайдбара   
		$this->load->model('commerce/commerce_m');
		$data['subcategory'] = $this->commerce_m->get_all_subcategories();
		$data['category'] = $this->commerce_m->get_all_categories();
		
		/* Блок авторизации */
		$data['auth_form'] = $this->load->module('auth')->auth_block_generator();
		$this->load->helper('captcha');
		$string_for_captcha = random_string('numeric',6);
		
		$vals = array(
			'word'	=> $string_for_captcha,
			'img_path'	=> './img/captcha/',
			'img_url'	=> base_url().'img/captcha/',
			'font_path'	=> './system/fonts/texb.ttf',
			'img_width'	=> '150',
			'img_height' => '50',
			'expiration' => '50'
			);
		$cap = create_captcha($vals);
		$cap['random_string_for_captcha'] = $string_for_captcha;
		$cookie = array(
                    'name'   => 'captcha',
                    'value' => $string_for_captcha,
                    'expire' => '7200'                   
		);
		set_cookie($cookie);	
		
		
		if ($this->input->post('submit_contacts')){
			
		}
		else {
			
		}
		
		
		$data['contacts'] = $this->load->view('contacts/contacts_v.php',$cap,true);
		/* Метатэги */
		$data['seo_title'] = 'Контакты ';
		$data['seo_description'] = 'Контакты seo_description';
		$data['seo_keywords'] = 'Контакты seo_keywords';
		
		
		

		$this->load->view('main/index_v',$data);
	
	}
	
	public function send()
	{
		$this->load->library('email');
		$this->email->from('yv001@yandex.ru', 'YourName');
		$this->email->to('yv001@yandex.ru'); 
		$this->email->subject('Тест Email');
		$this->email->message('Тестирование класса отправки сообщений');	
		$this->email->send();
		echo $this->email->print_debugger();
	}
	
	public function send_msg()
	{
		echo "sender";
	}

	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */