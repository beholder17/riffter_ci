<h1>Личный кабинет покупателя</h1>
<h2>Анкета</h2>
<form method='post' enctype='multipart/form-data' action="<?=base_url().$this->uri->segment(1);?>/auth/update_user_info">
	<p>ID: <?=$user_info[0]['id'];?></p>
	<p>Имя: <?=$user_info[0]['name'];?></p>
	<p>Фамилия: <?=$user_info[0]['famil'];?></p>	
	<p>Дата регистрации на сайте: <?=date('d.m.Y',$user_info[0]['date_registration']);?></p>	
	
	<p>Вы можете изменить контактные данные, если они изменились или были указаны неверно.</p>
	
	<p><label for='email'>E-mail: </label><input name='email' type='text' value='<?=$user_info[0]['email'];?>'></p>
	<p><label for='adress'>Adress: </label><input name='adress' type='text' value='<?=$user_info[0]['adress'];?>'></p>
	<p><label for='phone'>Phone: </label><input name='phone' type='text' value='<?=$user_info[0]['phone'];?>'></p>
	<p><label for='userfile'>Avatar: </label><input name='userfile' type='file'></p>
	<input type='submit' name='send' value='Изменить контактную информацию'>
</form>





<?php //var_dump($user_info); ?>