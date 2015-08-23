<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends MX_Controller {

	public function index()
	{
		$data['value'] = $this->load->view('form_auth','', true);
		$this->load->view('form_auth',$data);
	}
	
	public function login()
	{
		// Получаем меню для сайдбара   
		$this->load->model('commerce/commerce_m');
		$data['subcategory'] = $this->commerce_m->get_all_subcategories();
		$data['category'] = $this->commerce_m->get_all_categories();
		
		/* Метатэги */
		$data['seo_title'] = 'Authorization at '.base_url();
		$data['seo_description'] = 'Authorization';
		$data['seo_keywords'] = 'Authorization';
		
		/* Блок авторизации */
		$data['auth'] = $this->load->view('auth/auth_block_null_v','',true);	
		
		$auth_check = $this->session->userdata('login');
		if ($auth_check='') { redirect(base_url());}
		
		
		
		$this->load->model('auth/auth_m');
		$this->load->library('form_validation');
		$this->form_validation->set_rules($this->auth_m->authorization_rules);			
			$check = $this->form_validation->run();
			if ($check == TRUE) {} else {}
		
		
		
		
		
		

		
		
		
		
		
		
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
		$data['content'] = $this->load->view('page_auth',$cap, true);
		
		/* Блок авторизации */
		//$data['auth_form'] = $this->load->module('auth')->auth_block_generator();
		$data['auth_form'] = '';
		
		$this->load->view('main/index_v',$data);
		
	}
	
	function auth_check()
	{
		$data['login'] = $this->input->post('email_auth');
		$data['password'] = $this->input->post('pw_auth');
		
		$this->load->model('auth_m');
		$result = $this->auth_m->check_auth_model($data['login'],$data['password']);

		/*Если авторизация прошла, устанавливаем кукис*/
		if ($result['respond']==true) {$cookie = array(
                   'name'   => 'auth',
				   'value' => true,
                   'expire' => '86500'                   
               );

			set_cookie($cookie);
			
			$user_data = array(
				   //'id'  => $result[0]['id'],
				   'id'  => $result[0]['id'],
                   'login'  => $result[0]['login'],
                   'email'     => $result[0]['email'],
				   'name'     => $result[0]['name'],
				   'level'     => $result[0]['level'],
                   'logged_in' => TRUE
               );

			$this->session->set_userdata($user_data);
			
			
			
			echo "<script>alert('welcome');</script>";
			} else {
				echo "<script>alert('мы вас не знаем');</script>";
			}
	}
	
		function auth_check_ajax()
	{
		
		$data = json_decode($this->input->post('json_data'));
		$email = $data->email_auth;
		$password = $data->pw_auth;
		//$captcha = $data->captcha_auth;
		/*Проверка, завязана ли капча (если авторизация идет со отдельной страницы авторизации )*/
		if (isset($data->captcha_auth)) {$captcha = $data->captcha_auth;
		$personal_auth = true; //если авторизация с отдельной страницы
		//get_cookie('captcha', TRUE);
		} else $personal_auth = false;
		
		$this->load->model('auth_m');
		$result = $this->auth_m->check_auth_model($email,$password);
		/*Если авторизация прошла, устанавливаем кукис и сессию*/
		if ($personal_auth!=true) {
		if ($result['respond']==true) {$cookie = array(
                'name'   => 'auth',
				'value' => true,
                'expire' => '86500'                   
               );

			set_cookie($cookie);
			
			$user_data = array(
				   'id'  => $result[0]['id'],
                   'login'  => $result[0]['login'],
                   'email' => $result[0]['email'],
				   'name' => $result[0]['name'],
				   'famil' => $result[0]['famil'],
				   'otch' => $result[0]['otch'],
				   'adress' => $result[0]['adress'],
				   'level' => $result[0]['level'],
                   'logged_in' => TRUE
               );

			$this->session->set_userdata($user_data);
			delete_cookie("auth_attempt");
			echo json_encode(array(
			'auth_result'=>'1',
			'name'=>$result[0]['name'],
			'otch'=>$result[0]['otch'],
			'personal_auth'=>0
			));
			} else {
				/*Если не верная авторизация то считаем попытки*/
				if (get_cookie('auth_attempt', TRUE)==false) {
					$cookie = array(
                   'name'   => 'auth_attempt',
				   'value' => '1',
                   'expire' => '86500'                   
					);
					set_cookie($cookie);					
				} else {
					$auth_attempt = get_cookie('auth_attempt', TRUE);
					$auth_attempt++;
					$cookie = array(
                   'name'   => 'auth_attempt',
				   'value' => $auth_attempt,
                   'expire' => '86500'                   
					);
					set_cookie($cookie);
					/*Если количество попыток больше допустимых то редирект*/
					if ($auth_attempt>3) {
						echo json_encode(array('auth_result'=>'2'));						
						exit;
					}
				}
				
				
				
				
				echo json_encode(array('auth_result'=>'0'));
			}
		}
		
		if ($personal_auth==true) {
			//если верная капча
			if ($data->captcha_auth==get_cookie('captcha')){
			//и если верна пара логин/пароль
			if ($result['respond']==true) {$cookie = array(
                   'name'   => 'auth',
				   'value' => true,
                   'expire' => '86500'                   
               );
			//то устанавливаем кукисы
			set_cookie($cookie);
			
			$user_data = array(
					'id'  => $result[0]['id'],
                   'login'  => $result[0]['login'],
                   'email'  => $result[0]['email'],
				   'name'   => $result[0]['name'],
				   'famil'  => $result[0]['famil'],
				   'otch'   => $result[0]['otch'],
				   'adress' => $result[0]['adress'],
				   'level'  => $result[0]['level'],				   
                   'logged_in' => TRUE
               );
			//устанавливаем сессию
			$this->session->set_userdata($user_data);
			delete_cookie("auth_attempt");
			echo json_encode(array(
			'auth_result'=>'1',
			'name'=>$result[0]['name'],
			'otch'=>$result[0]['otch'],
			'personal_auth'=>1));
			} else {
				//Если не верная пара логин/пароль
				echo json_encode(array('auth_result'=>'0'));
			}
		} else {
			echo json_encode(array('auth_result'=>'3'));
		}
	}
	}
	
	function auth_block_generator()
	{
		//Загрузка блока авторизации		
		if ($this->session->userdata('logged_in')==TRUE) {
		$data['auth'] = $this->load->view('auth/auth_block_v','',true);
		} else
		$data['auth'] = $this->load->view('auth/form_auth_v','',true);
		if (get_cookie('auth_attempt', TRUE)>3) {
		$data['auth'] = $this->load->view('auth/auth_block_null_v','',true);	
		}
		return $data['auth'];
	}
	

	
	function logout()
	{
		delete_cookie("auth");		
		$user_data = array(
        'id'  => '',
                   'login'  => '',
                   'email'  => '',
				   'name'   => '',
				   'famil'  => '',
				   'otch'   => '',
				   'adress' => '',
				   'level'  => '',				  
                   'logged_in' => FALSE
        );
		
	
		
		//$this->session->unset_userdata($user_data);
		$this->session->sess_destroy();
		//$this->session->unset_userdata();
		//redirect(base_url());
	}
	
	function registration()
	{
		/* Метатэги */
		$data['seo_title'] = 'Registration';
		$data['seo_description'] = 'Registration';
		$data['seo_keywords'] = 'Registration';
		
		// Получаем меню для сайдбара   
		$this->load->model('commerce/commerce_m');
		$data['subcategory'] = $this->commerce_m->get_all_subcategories();
		$data['category'] = $this->commerce_m->get_all_categories();
		
		$this->load->library('form_validation');
		
		// Формируем капчу
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
		
		if (isset($_POST['registration_button'])) {
			//echo "<script>alert('кнопка нажата');</script>";
			$this->load->model('auth/auth_m');
			$this->form_validation->set_rules($this->auth_m->registration_rules);
			$check = $this->form_validation->run();
			if ($check == TRUE AND get_cookie('captcha') == $this->input->post('captcha_auth')) {
				//echo "<script>alert('валидация прошла');</script>";
				// Если форма заполнена правильно
				// Формируем массив для модели
				$data = $this->input->post();
				//echo "<pre>";
				
				unset ($data['registration_button']);
				unset ($data['captcha_auth']);
				
				$data['hash'] = md5($data['email'].$data['phone'].time());
				$data['date_registration'] = time();
				$data['famil'] = $data['surname'];
				unset ($data['surname']);
				
				$data['adress'] = $data['city'];
				unset ($data['city']);
				
				$data['pw'] = md5(md5($data['pw'])."salt57_rwdyY3_2");
				unset ($data['pw2']);
				
				$data['level'] = 1;
				
				//print_r ($data);
				$this->auth_m->registration_user($data);
				redirect(base_url().$this->uri->segment(1).'/auth/registration_done');
				//print_r ($this->auth_m->registration_rules);
				
			} else {
			//echo "<script>alert('валидация НЕ прошла');</script>";
			$data['auth_form'] = $this->load->module('auth')->auth_block_generator();
			$data['content'] = $this->load->view('auth/registration_v',$cap,true);
			$this->load->view('main/index_v',$data);
				
			}
			
		} else {
		//echo "<script>alert('кнопка НЕ нажата');</script>";
		$data['auth_form'] = $this->load->module('auth')->auth_block_generator();
		$data['content'] = $this->load->view('auth/registration_v',$cap,true);
		$this->load->view('main/index_v',$data);
		}
	}
	
	

	
	function registration_done()
	{
		/* Метатэги */
		$data['seo_title'] = "Регистрация прошла успешно";
		$data['seo_description'] = "Регистрация прошла успешно";
		$data['seo_keywords'] = "Регистрация прошла успешно";
		$data['seo_index'] = "0";
		
		// Получаем меню для сайдбара   
		$this->load->model('commerce/commerce_m');
		$data['subcategory'] = $this->commerce_m->get_all_subcategories();
		$data['category'] = $this->commerce_m->get_all_categories();
		
		/* Блок авторизации */
		$data['auth_form'] = $this->load->module('auth')->auth_block_generator();
		$data['content'] = $this->load->view('auth/registration_done_v','',true);
		$this->load->view('main/index_v',$data);
	}
	
	function forget()
	{
		/*if ($this->input->post('submit')!=NULL) {
			
		} else {*/		
		/* Метатэги */
		$data['seo_title'] = "Восстановление пароля";
		$data['seo_description'] = "Восстановление пароля";
		$data['seo_keywords'] = "Восстановление пароля";
		$data['seo_index'] = "0";
		
		// Получаем меню для сайдбара   
		$this->load->model('commerce/commerce_m');
		$data['subcategory'] = $this->commerce_m->get_all_subcategories();
		$data['category'] = $this->commerce_m->get_all_categories();
		
		/* Блок авторизации */
		$data['auth_form'] = $this->load->module('auth')->auth_block_generator();
		
		$this->load->library('form_validation');
		if ($this->input->post('submit')!=NULL){
		

			$this->load->model('auth/auth_m');
			
			$this->form_validation->set_rules($this->auth_m->forget_rules);
			$check = $this->form_validation->run();
			if ($check == TRUE) {
				//echo $this->input->post('email');
				//$this->load->model('auth/auth_m');
				$user = $this->auth_m->get_user_by_email($this->input->post('email'));
				if ($user == false) echo "Пользователь с таким адресом электронной почты не зарегистрирован"; else{
				//print_r($user);	
				
				
				$message_txt = "<h1>Восстановление пароля на сайте ".base_url()."</h1>";
				$message_txt .= "<p>Для восстановления пароля перейдите по ссылки ниже</p>";
				$message_txt .= "<a href='".base_url().$this->uri->segment(1)."/auth/new_password?hash=".$user[0]['hash']."&email=".$user[0]['email']."'>Восстановление пароля</a>";
				$message_txt .= "<p>Если это сообщение пришло к Вам по ошибке - просто проигнорируйте его.</p>";
				
				
				
				
				
				$this->load->library('email');				
				$config['charset'] = 'utf-8';
				$config['mailtype'] = 'html';
				
				$this->email->initialize($config);
				$this->email->from('richworld-st.ru', 'Rich World');
				$this->email->to('someone@example.com'); 
				$this->email->subject('Восстановление пароля');
				$this->email->message($message_txt);	
				$this->email->send();
			
				echo "<br><br><br>".$this->email->print_debugger();
				//redirect(base_url().$this->uri->segment(1).'/auth/new_password');
				$data['content'] = $this->load->view('auth/recovery_send_v','',true);
				$this->load->view('main/index_v',$data);
				}
				
			
				
				
			} else {
				$data['content'] = $this->load->view('auth/forget_v','',true);
				$this->load->view('main/index_v',$data);
			}
		} else {
		
		$data['content'] = $this->load->view('auth/forget_v',$data,true);		
		$this->load->view('main/index_v',$data);
		}		
	}
	
	function new_password()
	{
		$this->load->model('auth/auth_m');
		$this->load->library('form_validation');
		if ($this->input->post('new_pw_submit')) {
			/* Метатэги */
			$data['seo_title'] = "User's Account";
			$data['seo_description'] = "User's Account";
			$data['seo_keywords'] = "User's Account";
			$data['seo_index'] = "0";
			
			// Получаем меню для сайдбара   
			$this->load->model('commerce/commerce_m');
			$data['subcategory'] = $this->commerce_m->get_all_subcategories();
			$data['category'] = $this->commerce_m->get_all_categories();
			
			/* Блок авторизации */
			$data['auth_form'] = $this->load->module('auth')->auth_block_generator();
			

			$this->form_validation->set_rules($this->auth_m->recovery_rules);
			$check = $this->form_validation->run();
			if ($check == TRUE) {
				$pw = md5(md5($this->input->post('password'))."salt57_rwdyY3_2");
				echo $pw;
				/* запись нового пароля */
				$hash = $this->input->post('hash');
				$this->auth_m->write_new_password($pw,$hash);
				
				/* Вывод страницы */
				$data['content'] = $this->load->view('change_password_done_v',$data,true);				
				$this->load->view('main/index_v',$data);
			} else {
				$data['hash'] = $this->input->post('hash');
				$data['content'] = $this->load->view('new_password_v',$data,true);
				$this->load->view('main/index_v',$data);
			}
		} else {
		$hash = mysql_real_escape_string(strip_tags($this->input->get('hash',true)));
		$email = mysql_real_escape_string(strip_tags($this->input->get('email',true)));		
		$data = $this->auth_m->get_user_by_hash_mail($hash, $email);
		//print_r($data);
		if ($data == FALSE) redirect('404'); else{
			/* Метатэги */
			$data['seo_title'] = "User's Account";
			$data['seo_description'] = "User's Account";
			$data['seo_keywords'] = "User's Account";
			$data['seo_index'] = "0";
			
			// Получаем меню для сайдбара   
			$this->load->model('commerce/commerce_m');
			$data['subcategory'] = $this->commerce_m->get_all_subcategories();
			$data['category'] = $this->commerce_m->get_all_categories();
			
			/* Блок авторизации */
			$data['auth_form'] = $this->load->module('auth')->auth_block_generator();
			
			$data['hash'] = $hash;
			$data['content'] = $this->load->view('new_password_v',$data,true);
			$this->load->view('main/index_v',$data);
			//var_dump($data);
		}
		}
	}
	function new_password_action()
	{
		
	}
	
	function account($rout=NULL)
	{
		/* Метатэги */
		$data['seo_title'] = "User's Account";
		$data['seo_description'] = "User's Account";
		$data['seo_keywords'] = "User's Account";
		$data['seo_index'] = "0";
		
		// Получаем меню для сайдбара   
		$this->load->model('commerce/commerce_m');
		$data['subcategory'] = $this->commerce_m->get_all_subcategories();
		$data['category'] = $this->commerce_m->get_all_categories();
		
		/* Блок авторизации */
		$data['auth_form'] = $this->load->module('auth')->auth_block_generator();
		
		
		$data['user_orders'] = $this->commerce_m->get_orders_by_user_id($this->session->userdata('id'));
		
		
		if ($rout == NULL) {
			$data['content'] = $this->load->view('auth/account_v',$data,true);
			}
		if ($rout == 'userinfo') {
			$this->load->model('auth/auth_m');
			$data['user_info'] = $this->auth_m->get_user_by_id($this->session->userdata('id'));
			$data['content'] = $this->load->view('auth/userinfo_v',$data,true);
		}
		if ($rout == 'orders') {
			$data['content'] = $this->load->view('auth/orders_v',$data,true);
		} 
		if ($rout != 'orders' AND $rout != 'userinfo' AND $rout != NULL) {redirect('404');}
		
		$this->load->view('main/index_v',$data);
		}
	
	function update_user_info()
	{
		if ($this->input->post('send')==NULL) redirect('404');
		var_dump($this->input->post('userfile'));
		//if ($this->input->post('userfile')!=NULL){
		$config['upload_path'] = 'assets/avatars';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '100';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
		$config['encrypt_name']  = true;
		
		
		$this->load->library('upload', $config);
	
		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());
			
			//$this->load->view('upload_form', $error);
			echo "error :(";
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			//$this->load->view('upload_success', $data);
			echo "done!";
			
			
			
			
			
			
			$config['image_library'] = 'gd2'; // выбираем библиотеку
					$config['source_image']	= 'assets/avatars/'.$data['upload_data']['file_name'];				
					$config['new_image']	= 'assets/avatars/'.$data['upload_data']['file_name'];				
					$config['create_thumb'] = TRUE; // ставим флаг создания эскиза
					$config['thumb_marker'] = ''; 
					$config['maintain_ratio'] = TRUE; // сохранять пропорции
					$config['width']	= 300; // и задаем размеры
					$config['height']	= 300;
					$this->load->library('image_lib',$config);
					$this->image_lib->resize();
					/* подготовка массива для отправки в модель */
					/*$date['model'] = $this->input->post();
					$date['model']['show'] = 0;
					$date['model']['date'] = date('Y-m-d');*/
					$date['model']['image'] = $data['upload_data']['file_name'];
					unset($date['model']['add']);
					//$date['model']
					//$this->reviews_m->add_review($date['model']);
					//print_r($date['model']);
					//redirect(base_url().$this->uri-
			
			
			echo "done2!";
			var_dump($data);
			
		
		}
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */