<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends MX_Controller {

	public function __construct()
       {
            parent::__construct();
			
       }
	
	 
	public function index($page_alias=null)
	{
		

	}
	
	/* Страница 404 */
	public function notfound()
	{
		$this->load->view('notfound_v');
	}
	
	public function forbidden()
	{
		$this->load->view('forbidden_v');
	}
	




	public function mechanik(){

		// Получаем меню для сайдбара
		$this->load->model('commerce/commerce_m');
		$data['subcategory'] = $this->commerce_m->get_all_subcategories();
		$data['category'] = $this->commerce_m->get_all_categories();

		if (!isset($page_alias)) {



			// Получаем блок последних новостей
		$this->load->model('content/content_m');
		$block_data['category_content'] = 'news';
		$block_data['news'] = $this->content_m->get_content_block('news',3);
		$data['block_news'] = $this->load->view('block_news_v',$block_data,true);

			/* Метатэги */
		$data['seo_title'] = "Главная";
		$data['seo_description'] = "Главная seo_description";
		$data['seo_keywords'] = "Главная seo_keywords";

			/* Блок авторизации */
		$data['auth_form'] = $this->load->module('auth')->auth_block_generator();

		} else {
			$page_alias = $this->uri->segment(2); //обезвредить
			$this->load->model('main_m');
			$data['content'] = $this->main_m->get_page($page_alias);
			if ($data['content']== false ) redirect(base_url().'404', 'refresh');

			/* Метатэги */
			$data['seo_title'] = $data['content'][0]['title'];
			$data['seo_description'] = $data['content'][0]['description'];
			$data['seo_keywords'] = $data['content'][0]['keywords'];

			/* Блок авторизации */
			$data['auth_form'] = $this->load->module('auth')->auth_block_generator();
			$data['content'] = $this->load->view('main/page_v',$data,true);
		}



		$this->load->view('index_v',$data);
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */