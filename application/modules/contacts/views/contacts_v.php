<?php $this->lang->load('contacts', $this->uri->segment(1)); ?>
<h1><?= $this->lang->line('contacts');?></h1>
<div class='contacts_text'>
<?php 
$text_ru = "Адрес : г. Ростов - на - Дону,<br>
пр. Шолохова 310 “А”,<br>
пав. № 10,<br>
Рынок “Классик” пав. № 125<br>
и № 175<br>
Телефон :<br>
8 ( 908) 177 93 99,<br>
8 (918) 518 00 22<br>
</div>";
$text_en = "Адрес : г. Ростов - на - Дону,<br>
пр. Шолохова 310 “А”,<br>
пав. № 10,<br>
Рынок “Классик” пав. № 125<br>
и № 175<br>
Телефон :<br>
8 ( 908) 177 93 99,<br>
8 (918) 518 00 22<br>
</div>";
$text_tr = "Yer: - on - Don Rostov,<br>
pr. Sholokhov en 310 “A“<br>
PAV. Number 10,<br>
Pazar “Klasik“ PAV. Sayı 125<br>
ve numara 175<br>
Telefon:<br>
8 (908) 177 93 99<br>
8 (918) 518 00 22<br>
</ div>";
if ($this->uri->segment(1)=='tr') echo $text_tr;
if ($this->uri->segment(1)=='en') echo $text_en;
if ($this->uri->segment(1)=='ru') echo $text_ru;
?>
<!--<script type="text/javascript" charset="utf-8" src="https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=Mt6V82ryiFXlAEDv6P_c064v54ZznLWV&width=415&height=350"></script>-->
<div class='map_block'>
<script type="text/javascript" charset="utf-8" src="https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=Mt6V82ryiFXlAEDv6P_c064v54ZznLWV&height=400"></script>
</div>

<div class="h2_cover">
<h2 class="h2_alt"><?= $this->lang->line('form_caption');?></h2>
</div>
<form id='contacts' method='post' action=''>
	<p><label for='name'><?= $this->lang->line('contacts_form_name');?></label><input type='text' name='name' id='' placeholder='Ваше имя'></p>
	<p><label for='email'><?= $this->lang->line('contacts_form_phone_mail');?></label><input type='text' name='email' id='' placeholder='Ваши контакты, чтобы мы могли ответить Вам'></p>
	<p><label for='theme'><?= $this->lang->line('contacts_form_theme');?></label><input type='text' name='theme' id='' placeholder='Тема сообщения'></p>
	<p><label for='msg'><?= $this->lang->line('contacts_form_text');?></label><textarea name='msg'></textarea></p>
	<p><input class='btn_v2'type='submit' name='submit_contacts' id='' placeholder='placeholdr' value='<?= $this->lang->line('contacts_form_submit');?>'></p>
	<p><input type="checkbox" checked="checked" /><span style='position: relative; left: -116px;'><?= $this->lang->line('contacts_form_send_copy');?></span></p>
	<p><label for='captcha'><?= $this->lang->line('contacts_form_captcha');?></label><input type='text' name='captcha' id='' placeholder='Введите код с картинки'></p>
	<p style='position: relative; left: 31%; '><?php echo $image;?></p>
	
	<p>
	<?php //echo $random_string_for_captcha; ?>
	</p>
</form>