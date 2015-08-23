<h1>Укажите ваш новый пароль</h1>
<form method='post' id='form_new_password' action='<?= base_url().$this->uri->segment(1)?>/auth/new_password'>
	<p><input type='password' name='password' placeholder='Новый пароль'></p><?=  form_error('password'); ?>
	<p><input type='password' name='password2' placeholder='Пароль еще раз'></p><?=  form_error('password2'); ?>
	<input type='hidden' name='hash' value='<?=$hash?>'>
	<p><input type='submit' name='new_pw_submit'></p>
</form>