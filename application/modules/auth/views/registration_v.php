
<script src="<?= base_url()?>template/js/jquery.maskedinput.min.js" type="text/javascript"></script>


<h1>Регистрация</h1>
<form id='reg_form' method='POST' action='<?= base_url().$this->uri->segment(1);?>/auth/registration'>
	<p><label for='name'>Имя</label>
	<input type='text' size='80' name='name' id='' placeholder='Введите ваше имя' value='<?= set_value('name')?>'>
	<?= form_error('name');?>
	</p>
	<p><label for='surname'>Фамилия</label>
	<input type='text' size='80' name='surname' id='' placeholder='Введите вашу фамилию' value='<?= set_value('surname')?>'>
	<?= form_error('surname');?>
	</p>
	<p><label for='phone'>Телефон</label>
	<input type='text' size='80' name='phone' id='phone' placeholder='Контактный телефон' value='<?= set_value('phone')?>'>
	<?= form_error('phone');?>
	</p>
	<p><label for='city'>Ваш адрес</label>
	<input type='text' size='80' name='city' id='' placeholder='Адрес для доставки' value='<?= set_value('city')?>'>
	<?= form_error('city');?>
	</p>
	<p><label for='email'>E-mail</label>
	<input type='text' size='80' name='email' id='' placeholder='Электронная почта' value='<?= set_value('email')?>'>
	<?= form_error('email');?>
	</p>
	<p><label for='pw'>Пароль</label>
	<input type='password' size='80' name='pw' id='' placeholder='Ваш пароль' value='<?= set_value('pw')?>'>
	<?= form_error('pw');?>
	</p>
	<p><label for='pw2'>Пароль повторно</label>
	<input type='password' size='80' name='pw2' id='' placeholder='Ваш пароль повторно' value='<?= set_value('pw2')?>'>
	<?= form_error('pw2');?>
	</p>
	<p><label for='captcha_auth'>Код с картинки</label><input id='captcha_auth' name='captcha_auth' id="captcha_frm" type="text" size="30" placeholder="Введите код с картинки"><?= form_error('captcha_auth');?></p>
	<p style='position: relative; left: 136px;'><?php echo $image;?></p>
	<input style='position: relative; left: 136px;' class='btn_v2' name='registration_button' type='submit' value='Зарегистрироваться'>
</form>
<script>
jQuery(function($){
   $("#phone").mask("9 (999) 999-99-99",{placeholder:"_ (___) ___-__-__"});
});
</script>

