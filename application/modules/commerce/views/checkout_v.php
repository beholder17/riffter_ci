<h1>Оформление заказа</h1>
<form method='post' action='<?= base_url().$this->uri->segment(1);?>/commerce/checkout_send'>
	<p>Ваши контактные данные:</p>
	<ul>
	<li>Name: <?=$user_informer[0]['name'];?> <?=$user_informer[0]['famil'];?></li>
	<li>Phone: <?=$user_informer[0]['phone'];?></li>
	<li>Address: <?=$user_informer[0]['adress'];?></li>
	<li>E-mail: <?=$user_informer[0]['email'];?></li>
	</ul>
	

	<p>
	<strong><span><?=$user_informer[0]['name'].' '.$user_informer[0]['famil']?></span></strong>, Ваш заказ будет доставлен по указанному Вами адресу:<br>
	<strong><?= $user_informer[0]['adress'] ?></strong>
	</p>
	

	<p>
		Если указанная информация верна, то нажмите кнопку отправить заказ. После этого он попадет в обработку.<br> Из Вашего личного кабинета вы сможете отслеживать статус заказа.
	</p>
	
	
	Комментарий к заказу (Если требуется)
	<textarea name='comment' class='text_area'></textarea>

	<input value='Отправить заказ' type='submit'>
</form>
<?php
//$tmp = $this->session->userdata();
echo "<pre>";
print_r($userdata['cart_contents']);
?>
<style>
.text_area{
    padding: 0;
    outline: none;
    background-color: white;
    resize: none;
	width: 100%;
	height: 250px;
}
</style>