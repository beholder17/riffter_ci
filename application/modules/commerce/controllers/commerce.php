<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Commerce extends MX_Controller {
	public function __construct()
       {
            parent::__construct();
		//	$this->load->library('cart');
			
       }
	public function catalog()
	{
		
		// Получаем меню для сайдбара   
		$this->load->model('commerce/commerce_m');
		$data['subcategory'] = $this->commerce_m->get_all_subcategories();
		$data['category'] = $this->commerce_m->get_all_categories();
			
		
		$this->load->library('pagination');
		$this->load->model('commerce_m');
		$lang = $this->uri->segment(1);
		$category = $this->uri->segment(3);
		$subcategory = $this->uri->segment(4);
		$item_id = $this->uri->segment(5);
		$data['subcategory_alias'] = $subcategory;
		if ($category!=null AND $subcategory==null){
				//echo "<script>alert('1 $category - $subcategory');</script>";
				
				$data['content'] = $this->commerce_m->get_category($category);
				
				$data['content'] = $this->load->view('commerce_v',$data,true);
				$this->load->view('main/index_v',$data);
				}
		if ($category!=null AND $subcategory!=null AND $item_id==null){
				
				/* check to existing product at category/subcategory */
				if ($this->commerce_m->product_existing($category,$subcategory) == false) { redirect(base_url().'commerce/no_products');				
				}
				
				/* pager */
				$this->load->library('pager');				
				$tmp = $this->input->get('page');
				if ($tmp!='') $current_page_value = $this->input->get('page'); else $current_page_value = 1;
				$config['base_url'] = base_url().$this->uri->segment(1)."/catalog/$category/$subcategory";
				$config['total_rows'] = $this->commerce_m->get_products_count($category,$subcategory);
				$config['per_page'] = 3;
				$config['current_page'] = $current_page_value;
				
				$this->pager->initializer($config); 				

				$data['pager'] = $this->pager->create_links();
				
				
				
				$data['category_info'] = $this->commerce_m->get_category($category);
				$data['subcategory_info'] = $this->commerce_m->get_subcategory($subcategory);
				$data['content'] = $this->commerce_m->get_catalog($category,$subcategory,$config['per_page'],$this->pager->requested_page());
				$data['cart'] = $this->cart->contents();
				/* Метатэги */
				$data['seo_title'] = $data['content'][0]['seo_title'];
				$data['seo_description'] = $data['content'][0]['seo_description'];
				$data['seo_keywords'] = $data['content'][0]['seo_keywords'];
				$data['content'] = $this->load->view('catalog_v',$data,true);
				/* Блок авторизации */
				$data['auth_form'] = $this->load->module('auth')->auth_block_generator();
				$this->load->view('main/index_v',$data);
				
		}
		
		if ($category!=null AND $subcategory!=null AND $item_id!=null){
				
				/* check to existing product at category/subcategory */
				if ($this->commerce_m->product_item_existing($category,$subcategory,$item_id) == false) { redirect(base_url().'commerce/no_product_item');				
				}
				
				
				
				$data['item'] = $this->commerce_m->get_product($item_id);
				
				
				//$data['content'] = $this->commerce_m->get_catalog($category,$subcategory,$config['per_page'],$this->pager->requested_page());
				//$data['content'] = 'dslfkj - '.$item_id;
				$data['cart'] = $this->cart->contents();
				/* Метатэги */
				$data['seo_title'] = $data['item'][0]['seo_title'];
				$data['seo_description'] = $data['item'][0]['seo_description'];
				$data['seo_keywords'] = $data['item'][0]['seo_keywords'];

				$data['content'] = $this->load->view('product_v',$data,true);
				/* Блок авторизации */
				$data['auth_form'] = $this->load->module('auth')->auth_block_generator();
				$this->load->view('main/index_v',$data);
				
		}
		
		if ($category==null AND $subcategory==null){
				/* Страница по адресу base_url()/catalog*/
				//echo "<script>alert('3 $category - $subcategory');</script>";
				$data['content'] = 'все категории без каких-либо идентификаторов';
				echo "base_url()/catalog<br>все категории без каких-либо идентификаторов";
		}
		
		
	}
	
	function add_to_comparsion()
	{
		if (!$this->input->post('id')) {redirect('404');}

		
		$tmp = $this->input->post('id');
		if ($this->session->userdata('comparsion')==NULL) $data = array(); else $data = $this->session->userdata('comparsion');
		
		if (!in_array($tmp, $data)) {

		array_push($data,$tmp);
		
		$comparedata = array(
                   'comparsion'  => $data
               );

		$this->session->set_userdata($comparedata);
		echo "Добавлено в сравнения";
		} else echo "уже в сравнении";
		//echo $tmp;
		
		/*
		$this->cart->update($data);
		redirect (base_url().'commerce/cart');*/
	}
	
	function comparsion()
	{
		// Получаем меню для сайдбара   
		$this->load->model('commerce/commerce_m');
		$data['subcategory'] = $this->commerce_m->get_all_subcategories();
		$data['category'] = $this->commerce_m->get_all_categories();
		
		/* Метатэги */
		$data['seo_title'] = "Сравнение товаров";
		$data['seo_description'] = "Страница сравнения товаров";
		$data['seo_keywords'] = "Корзина товаров";
		
		/* Содержимое корзины */
		$data['cart'] = $this->cart->contents();
		
		/* Сравнение товаров */
		$data['comparsion_id_list'] = $this->session->userdata('comparsion');
		$this->load->model('commerce_m');
		$data['comparsion_items'] = array();
		foreach ($data['comparsion_id_list'] as $value)
		{
			array_push ($data['comparsion_items'],$this->commerce_m->get_product($value));
		}
		
		
		
		/* Блок авторизации */
		$data['auth_form'] = $this->load->module('auth')->auth_block_generator();
		
		//if ($data['cart']!=null) $data['content'] = $this->load->view('commerce/comparsion_v',$data,true); else $data['content'] = $this->load->view('commerce/cart_is_empty_v',$data,true);
		$data['content'] = $this->load->view('commerce/comparsion_v',$data,true);
		$this->load->view('main/index_v',$data);	
	}
	
	function thumb_extractor($img)
	{
		$path_info = pathinfo($img);
		$value = $path_info['filename'].'_thumb.'.$path_info['extension'];
		return $value;
	}
	
	
	
	function no_products()
	{
		// Получаем меню для сайдбара   
		$this->load->model('commerce/commerce_m');
		$data['subcategory'] = $this->commerce_m->get_all_subcategories();
		$data['category'] = $this->commerce_m->get_all_categories();
		
		/* Метатэги */
		$data['seo_title'] = "Товаров пока нет";
		$data['seo_description'] = "Товаров пока нет";
		$data['seo_keywords'] = "Товаров пока нет";
		
		
		
		$data['content'] = $this->load->view('catalog_v',$data,true);
		/* Блок авторизации */
		$data['auth_form'] = $this->load->module('auth')->auth_block_generator();
		
		$data['content'] = $this->load->view('commerce_no_products_v',$data,true);
		$this->load->view('main/index_v',$data);
	}
	
	public function cart($set_currency=NULL)
	{
		// пересчет корзины на одну валюту
		if ($set_currency!=NULL){

			switch ($set_currency) {
			case 'en':
				$cur_suffix='usd';
				break;
			case 'tr':
				$cur_suffix='try';
				break;
			case 'ru':
				$cur_suffix='rub';
				break;
			default: redirect('404');
			}
			
			
			
			
			$cart = $this->cart->contents();
			//echo $set_currency."<br>";
			//var_dump($cart);
			$this->load->model('commerce/commerce_m');
			foreach ($cart as $key=>$value)
			{
				//$this->cart->insert();
				//if ($cart[$key]['currency']!=$set_currency){
					$cart[$key]['currency'] = $set_currency;
					
					//получить цену в нужной валюте
					$new_price = $this->commerce_m->get_product($value['id']);
					
					$price_index = 'price-'.$cur_suffix;
					$new_price = $new_price[0][$price_index];
					
					$cart[$key]['price'] = $new_price;
					$this->cart->insert($cart[$key]);
					//var_dump($cart[$key]);
					
					
				//}
				
			}
			redirect(base_url().$this->uri->segment(1).'/commerce/cart');
			//var_dump($this->cart->contents());
			
		} else {
			// Получаем меню для сайдбара   
			$this->load->model('commerce/commerce_m');
			$data['subcategory'] = $this->commerce_m->get_all_subcategories();
			$data['category'] = $this->commerce_m->get_all_categories();
			
			/* Метатэги */
			$data['seo_title'] = "Корзина товаров";
			$data['seo_description'] = "Корзина товаров";
			$data['seo_keywords'] = "Корзина товаров";
			$data['seo_index'] = "0";
			/* Содержимое корзины */
			$data['cart'] = $this->cart->contents();
			
			/* Блок авторизации */
			$data['auth_form'] = $this->load->module('auth')->auth_block_generator();
			
			
			/* Проверка корзины на мультивалютность */
			//var_dump ($data['cart']);
			$tmp = array();
			foreach ($data['cart'] as $item)
			{
				array_push($tmp,$item['currency']);
			}
			$result = array_unique($tmp);
			//print_r($result);
			$data['multi_currency'] = $result;
			
			
			if ($data['cart']!=null) $data['content'] = $this->load->view('commerce/cart_v',$data,true); else $data['content'] = $this->load->view('commerce/cart_is_empty_v',$data,true);
			$this->load->view('main/index_v',$data);
		}
			
		
		
	}
	
	function add_to_cart()
	{
		if (!$this->input->post('json_data')) {redirect('404');	}
		//session_start();
		$id = $this->input->post('json_data');
		
		
		$this->load->model('commerce_m');
		$product = $this->commerce_m->get_product($id);

		
		$product[0]['image'] = $this->thumb_extractor($product[0]['image']);
		
		/* выбор валюты в зависимости от текущего языка */
		if ($this->uri->segment(1) == 'en') $price = $product[0]['price-usd']; 
		if ($this->uri->segment(1) == 'tr') $price = $product[0]['price-try'];
		if ($this->uri->segment(1) == 'ru') $price = $product[0]['price-rub'];
		
			$data = array(
			array(
               'id'      => $product[0]['id'],
               'qty'     => '1',
               'price'   => $price,
               'name'    => $product[0]['name'],
			   'name_tr'    => $product[0]['name_tr'],
			   'image'    => $product[0]['image'],
			   'currency'    => $this->uri->segment(1),
			   'category_alias'    => $product[0]['category_alias'],
			   'subcategory_alias'    => $product[0]['subcategory_alias'],
			   'sku'    => $product[0]['sku']
            )
			
			);
			
			
		$re = $this->cart->insert($data);
		$this->cart->insert($data);
		//print_r ($data);
		//echo "<br><br><br>";
		//print_r('>>>'.$re.'<<<');
		$data = $this->cart->contents();
		//print_r ($data);
	}
	
	public function cart_drop()
	{
		$this->cart->destroy();
	}
	
	public function cart_remove_item()
	{
		/*$data = array( 
		  array( 
		  'rowid' => 'b99ccdf16028f015540f341130b6d8ec', 
		  'qty' => 3 
		  ), 
		  
		  array( 
		  'rowid' => 'xw82g9q3r495893iajdh473990rikw23', 
		  'qty' => 4 
		  ), 
		  
		  array( 
		  'rowid' => 'fh4kdkkkaoe30njgoe92rkdkkobec333', 
		  'qty' => 2 
		  ) 
		  );
		*/
		if (!$this->input->post('json_data')) {redirect('404');	}
		//session_start();
		
		$tmp = json_decode($this->input->post('json_data'),true);
		
		$data = array(
		  'rowid' => $tmp['rowid'], 
		  'qty' => $tmp['qty']
		  );
		
		$this->cart->update($data);
		redirect (base_url().'commerce/cart');
	}
	
	function cart_calculate()
	{
		if ($this->input->post('cart_calculate'))
		{
			$data = array();
			$iteration = 1;
			$cart_calculate = $this->input->post();
			foreach ($cart_calculate as $key => $value)
			{
				if ($key =='cart_calculate') continue;
				if (!isset($_POST['qty_'.$iteration])) continue;
				$array = array('rowid'=>$_POST['rowid_'.$iteration], 'qty' => $_POST['qty_'.$iteration]);
				$this->cart->update($array);
				$iteration++;
			}
			redirect(base_url().'commerce/cart');
		}
		
	}
	
	function checkout()
	{
		$this->load->library('form_validation');
		// Получаем меню для сайдбара   
		$this->load->model('commerce/commerce_m');
		$data['subcategory'] = $this->commerce_m->get_all_subcategories();
		$data['category'] = $this->commerce_m->get_all_categories();
		
		/* Метатэги */
		$data['seo_title'] = "Оформление заказа";
		$data['seo_description'] = "Оформление заказа";
		$data['seo_keywords'] = "Оформление заказа";
		$data['seo_index'] = "0";
		/* Информация о пользователе */
		$this->load->model('auth/auth_m');
		//$data['user_informer'] = $this->auth_m->get_user_by_id('1');
		
		//echo "<script>alert('".$this->session->userdata('last_activity')."');</script>";
		$data['user_informer'] = $this->auth_m->get_user_by_id($this->session->userdata('id'));
		
		$data['userdata'] =  $this->session->userdata;
		
		//echo '<script>alert("'.time().'");</script>';
		
		/* Содержимое корзины */
		$data['cart'] = $this->cart->contents();
		
		/* Блок авторизации */
		$data['auth_form'] = $this->load->module('auth')->auth_block_generator();
		
		if ($data['cart']!=null) $data['content'] = $this->load->view('commerce/checkout_v',$data,true); else $data['content'] = $this->load->view('commerce/cart_is_empty_v',$data,true);
		$this->load->view('main/index_v',$data);
	}
	
	function checkout_send()
	{

			// Получаем меню для сайдбара   
			$this->load->model('commerce/commerce_m');
			$data['subcategory'] = $this->commerce_m->get_all_subcategories();
			$data['category'] = $this->commerce_m->get_all_categories();
			
			/* Метатэги */
			$data['seo_title'] = "Оформление заказа";
			$data['seo_description'] = "Оформление заказа";
			$data['seo_keywords'] = "Оформление заказа";
			$data['seo_index'] = "0";
		
			/* Блок авторизации */
			$data['auth_form'] = $this->load->module('auth')->auth_block_generator();
			
			/* Информация о пользователе */
			$this->load->model('auth/auth_m');
			$data['user_informer'] = $this->auth_m->get_user_by_id($this->session->userdata('id'));
			
			//echo '<script>alert("'.$this->input->post('comment').'");</script>';
			
			$sql_data['date_order_create'] = time();
			$sql_data['comment'] = $this->input->post('comment');
			$sql_data['user_id'] = $this->session->userdata('id');
			$sql_data['cart'] = serialize($this->cart->contents());
			$sql_data['ip'] = $_SERVER["REMOTE_ADDR"];
			
			$sql_data['status'] = 1;

			
			$this->load->model('commerce_m');
			$this->commerce_m->add_order($sql_data);
			
			
			$data['userdata'] =  $this->session->userdata;
			
			$this->cart->destroy();
			
			$data['content'] = $this->load->view('checkout_done_v.php','',true);
			$this->load->view('main/index_v',$data);
		
	}
	
	function block_recommended_slider($limit=NULL)
	{	
	$this->load->model('commerce/commerce_m');
	$data['items'] = $this->commerce_m->get_recommended_products($limit);
	$this->load->view('block_recommended_slider_v',$data);	
	}
	
	function block_recommended($limit=NULL)
	{
	$this->load->model('commerce/commerce_m');
	$data['cart'] = $this->cart->contents();
	$data['items'] = $this->commerce_m->get_recommended_products($limit);
	$this->load->view('block_recommended_v',$data);	
	}
	
	public function novelty($category=NULL, $subcategory=NULL)
	{
		// Получаем меню для сайдбара   
		$this->load->model('commerce/commerce_m');
		$data['subcategory'] = $this->commerce_m->get_all_subcategories();
		$data['category'] = $this->commerce_m->get_all_categories();
		if($category==NULL AND $subcategory==NULL){
			/* Метатэги */
			$data['seo_title'] = "Novelty";
			$data['seo_description'] = "Novelty";
			$data['seo_keywords'] = "Novelty";
			$data['seo_index'] = "1";
			/* Содержимое корзины */
			//$data['cart'] = $this->cart->contents();
			
			/* Блок авторизации */
			$data['auth_form'] = $this->load->module('auth')->auth_block_generator();
			
			/* Получение новинок */
			/* Выбираем все категории и подкатегории*/
			$data['to_output'] = '';
			//$data['categories'] = $this->commerce_m->get_all_categories_novelty();
			$data['categories'] = $this->commerce_m->get_all_categories();
			foreach($data['categories'] as $cat)
			{
				$cat_exist = $this->commerce_m->product_novelty_existing_cat($cat['id']);
				if ($cat_exist==true){
					$data['to_output'] .= '<h2>'.$cat['name'].'</h2>';
					$tmp['category_id'] = $cat['id'];
					$tmp['category_alias'] = $cat['alias'];
					$data['subcategories'] = $this->commerce_m->get_all_subcategories();
					foreach($data['subcategories'] as $subcat)
					{
						$tmp['subcategory_id'] = $subcat['id'];
						$tmp['subcategory_alias'] = $subcat['alias'];
						$subcat_exist = $this->commerce_m->product_novelty_existing_subcat($cat['id'],$subcat['id']);
						if ($subcat_exist==true){
							$data['to_output'] .= '<h3>'.$subcat['name'].'</h3>';
							
							$tmp['info'] = $this->commerce_m->get_novelty_short($cat['id'],$subcat['id']);
							$tmp['cart'] = $this->cart->contents();
							//print_r ($tmp);
							/*foreach ($tmp as $value)
							{
								$data['to_output'] .= $value['name'];
							}*/
							if (count($tmp['info'])>0){$data['to_output'] .= $this->load->view('commerce/novelty_catalog_element_v',$tmp,true);}
						}
					}
				}
			}
			
			
			//$data['novelties'] = $this->commerce_m->get_novelty_short(1,3);
			
			
			$data['content'] = $this->load->view('commerce/novelty_v',$data,true);
			$this->load->view('main/index_v',$data);
		}
		if($category!=NULL AND $subcategory!=NULL){
			$category = mysql_real_escape_string($category);
			$subcategory = mysql_real_escape_string($subcategory);
				
				/* Метатэги */
			$data['seo_title'] = "Novelty";
			$data['seo_description'] = "Novelty";
			$data['seo_keywords'] = "Novelty";
			$data['seo_index'] = "1";
			/* Содержимое корзины */
			//$data['cart'] = $this->cart->contents();
			
			/* Блок авторизации */
			$data['auth_form'] = $this->load->module('auth')->auth_block_generator();
			
			/* Получение новинок */
			/* Выбираем все категории*/
			$data['category'] = $this->commerce_m->get_category_by_id($category);
			$data['subcategory'] = $this->commerce_m->get_subcategory_by_id($subcategory);
			$data['novelties'] = $this->commerce_m->get_novelty_full($category,$subcategory);
			
			$tmp = $this->commerce_m->get_category_by_id($category);			
			$data['category_alias'] = $tmp['0']['alias'];
			$tmp = $this->commerce_m->get_subcategory_by_id($subcategory);
			$data['subcategory_alias'] = $tmp['0']['alias'];
			$data['cart'] = $this->cart->contents();
			$data['category_id'] = $category;
			$data['subcategory_id'] = $subcategory;
			
			
			$data['content'] = $this->load->view('commerce/novelty_cat_subcat_v',$data,true);
			$this->load->view('main/index_v',$data);
		}
		if($category!=NULL AND $subcategory==NULL){redirect('404');}
	}
	
	function orders()
	{
		$this->load->model('commerce/commerce_admin_m');
		$tmp['data'] = $this->commerce_admin_m->get_orders();
		return $data['content'] = $this->load->view('commerce/admin/orders_show_v',$tmp);
	}
	
	function print_order($id)
	{
		$id = mysql_real_escape_string($id);
		$this->load->model('commerce/commerce_admin_m');
		$this->load->model('auth/auth_m');
		$tmp['data'] = $this->commerce_admin_m->get_order_details($id);		
		$tmp['user'] = $this->auth_m->get_user_by_id($tmp['data'][0]['user_id']);
		return $data['content'] = $this->load->view('commerce/admin/print_order_v',$tmp);
	}
	
	function adm_orders($param=null)
	{
		$param = mysql_real_escape_string($param);
		$this->load->model('commerce/commerce_admin_m');
		switch($param){
			case "history":
			$param = '3';
			$data['data'] = $this->commerce_admin_m->get_orders_by_status($param);
			$this->load->view('commerce/admin/orders_show_v',$data);
			break;
			case "paid":
			$param = '2';
			$data['data'] = $this->commerce_admin_m->get_orders_by_status($param);
			$this->load->view('commerce/admin/orders_show_v',$data);
			break;
			case "unpaid":
			$param = '1';
			$data['data'] = $this->commerce_admin_m->get_orders_by_status($param);
			$this->load->view('commerce/admin/orders_show_v',$data);
			break;
			default: redirect('404');
		}
		
		if ($param == 'unpublish') {$data['data'] = $this->reviews_m->get_all_unpublish_reviews();}
		if ($param == 'publish') {$data['data'] = $this->reviews_m->get_all_reviews();}
		if ($param == null) {$data['data'] = $this->reviews_m->get_all_reviews();}
	}
	
	function promo()
	{
		echo "promo";
	}
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */