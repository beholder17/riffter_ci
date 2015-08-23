<h1>Восстановление пароля</h1>
<p>
Укажите адрес эл. почты, который вы использовали при регистрации, и инструкции по смене пароля будут высланы на этот адрес.
</p>
<form method='post' action='forget'>
	<p><label for='email'>Ваш E-mail: </label><input name='email' type='text' value=''>
	<?=  form_error('email'); ?>
	</p>
	<input name='submit' type='submit' value='Восстановить'>
</form>
<?php
//set_value('email')
?>