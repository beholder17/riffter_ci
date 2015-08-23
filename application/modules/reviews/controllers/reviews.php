<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Reviews extends MX_Controller
{


    public function index()
    {

        // Получаем меню для сайдбара
        $this->load->model('commerce/commerce_m');
        $data['subcategory'] = $this->commerce_m->get_all_subcategories();
        $data['category'] = $this->commerce_m->get_all_categories();


        //error_reporting(0);
        /* Получаем слайдер */
        //$data['slider'] = $this->load->view('main_slider_v','',true);
        $this->load->model('reviews_m');

        /* pager */
        $this->load->library('pager');
        $current_page_check = $this->input->get('page');
        if ($current_page_check!='') { $current_page_value = $this->input->get('page');} else { $current_page_value = 1; }
        $config['base_url'] = base_url().$this->uri->segment(1).'/reviews';
        $config['total_rows'] = $this->reviews_m->get_approved_reviews_count();
        $config['per_page'] = "5";
        $config['current_page'] = $current_page_value;
        $this->pager->initializer($config);
        $data['pager'] = $this->pager->create_links();

        // Получаем одобренные отзывы

        //$data['approved_reviews'] = $this->reviews_m->get_all_approved_reviews();
        $data['approved_reviews'] = $this->reviews_m->get_all_approved_reviews($config['per_page'],$this->pager->requested_page());
        $data['content'] = $this->load->view('reviews_main_page_v', $data, true);






        /* Метатэги */
        $data['seo_title'] = "reviews";
        $data['seo_description'] = "reviews";
        $data['seo_keywords'] = "reviews seo_keywords";

        /* Блок авторизации */
        $data['auth_form'] = $this->load->module('auth')->auth_block_generator();


        $this->load->view('main/index_v', $data);
    }

    function add_review()
    {
        // Получаем меню для сайдбара
        $this->load->model('commerce/commerce_m');
        $data['subcategory'] = $this->commerce_m->get_all_subcategories();
        $data['category'] = $this->commerce_m->get_all_categories();
        $this->load->model('reviews_m');
        $this->load->library('form_validation');
		
        if (isset($_POST['add'])){
			$data['form_data'] = $this->input->post();
            $this->form_validation->set_rules($this->reviews_m->add_review_rules);
			$check = $this->form_validation->run();
            if ($check == FALSE)
            {
                $data['content'] = $this->load->view('review_add_v',$data,true);
                /* Метатэги */
                $data['seo_title'] = "reviews";
                $data['seo_description'] = "reviews";
                $data['seo_keywords'] = "reviews seo_keywords";

                /* Блок авторизации */
                $data['auth_form'] = $this->load->module('auth')->auth_block_generator();

                $this->load->view('main/index_v', $data);
				
				
            }
            else
            {             
				$config['upload_path'] = 'assets/reviews_img';
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_size']	= '1000';
				$config['max_width']  = '1024';
				$config['max_height']  = '768';
				$config['encrypt_name']  = 'true';
				$this->load->library('upload', $config);
				if ( ! $this->upload->do_upload())
				{
					$error = array('error' => $this->upload->display_errors());
					print_r ($error);
				}
				else
				{
					$data = array('upload_data' => $this->upload->data());
					$config['image_library'] = 'gd2'; // выбираем библиотеку
					$config['source_image']	= 'assets/reviews_img/'.$data['upload_data']['file_name'];				
					$config['new_image']	= 'assets/reviews_img/'.$data['upload_data']['file_name'];				
					$config['create_thumb'] = TRUE; // ставим флаг создания эскиза
					$config['thumb_marker'] = ''; 
					$config['maintain_ratio'] = TRUE; // сохранять пропорции
					$config['width']	= 300; // и задаем размеры
					$config['height']	= 300;
					$this->load->library('image_lib',$config);
					$this->image_lib->resize();
					/* подготовка массива для отправки в модель */
					$date['model'] = $this->input->post();
					$date['model']['show'] = 0;
					$date['model']['date'] = date('Y-m-d');
					$date['model']['image'] = $data['upload_data']['file_name'];
					unset($date['model']['add']);
					//$date['model']
					$this->reviews_m->add_review($date['model']);
					//print_r($date['model']);
					redirect(base_url().$this->uri->segment(1)."/reviews");
					//TODO:отправка уведомления 
					
				}
            }

        } else {


            $data['content'] = $this->load->view('review_add_v','',true);

            /* Метатэги */
            $data['seo_title'] = "reviews";
            $data['seo_description'] = "reviews";
            $data['seo_keywords'] = "reviews seo_keywords";

            /* Блок авторизации */
            $data['auth_form'] = $this->load->module('auth')->auth_block_generator();

            $this->load->view('main/index_v', $data);

        }




    }
	
	function adm_reviews($param=null)
	{
		$this->load->model('reviews_m');
		if ($param == 'unpublish') {$data['reviews'] = $this->reviews_m->get_all_unpublish_reviews();}
		if ($param == 'publish') {$data['reviews'] = $this->reviews_m->get_all_reviews();}
		if ($param == null) {$data['reviews'] = $this->reviews_m->get_all_reviews();}
		$this->load->view('reviews/admin/adm_reviews_v',$data);
	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */