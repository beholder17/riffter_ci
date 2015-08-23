<h1>Add review</h1>
<form action="add_review" method="post" name="add_review" id="add_review" enctype="multipart/form-data">
    <p><label for="name">Your name: </label><input type="text" name="name" size="50" value="<?=isset($form_data['name'])?>"><?= form_error('name');?></p>
    <p><label for="fulltext">Review: </label><br><textarea name="fulltext" rows="10" cols="62"><?=isset($form_data['fulltext'])?></textarea><?= form_error('fulltext');?></p>
	<p><label for="city">Where you from?: </label><input type="text" name="city" size="50" id="" value="<?=isset($form_data['city'])?>"><?= form_error('city');?></p>
    <p><label for="email">Your e-mail: </label><input type="text" name="email" size="50" id="add_review_email" value="<?=isset($form_data['email'])?>"><?= form_error('email');?></p>
	<p><label for="userfile">Photo: </label><input type="file" name="userfile" size="50" id="add_review_userfile"></p>
    <input type="submit" value="Отправить отзыв" name="add" class="btn_v2">
</form>
<p>Адрес электронной почты не будет опубликован и доступен третьим лицам. Он будет использован для ответа на ваше сообщение. Не является обязательным полем</p>
<p>Отзыв будет опубликован после модерации</p>

<? //print_r($form_data);?>

<style>
    .add_review_email
    {
        color: #790228;
        border-radius: 5px;
        border: 1px solid #D0D0D0;
        padding: 5px;
        width: 220px;
    }
</style>
