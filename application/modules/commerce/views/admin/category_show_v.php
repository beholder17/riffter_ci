<div class='content_page'>
<h2>Категории</h2>
<a href='javascript: void(0)' id='add_category_btn_open_dlg'>+ Добавить категорию</a>
<table class="table table-condensed table-hover table-striped table-bordered">
<thead>
	<th>Название</th>
	<th>Описание</th>
	<th>Алиас</th>
	<th>Опции</th>
</thead>
<?php
foreach ($data as $value){?>
<tr class='tr_category_<?= $value['id']?>'>
	<td class='td_category_name'><?= $value['name'] ?></td>
	<td class='td_category_description'><?= $value['description'] ?></td>
	<td class='td_category_alias'><?= $value['alias'] ?></td>
	<td class='td_options'>
	<a href='javascript: void(0)' class='edit_cat' id='cat_edit_<?= $value['id']?>'>Edit</a>
	<a href='javascript: void(0)' class='del_cat' id='cat_del_<?= $value['id']?>'>Delete</a>
	</td>
</tr>	
<?php }?>
</table>
</div>

<div id="dialog-confirm" title="Добавить категорию" style='display: none'>
	<form method='post'>
	Название
	<p><input id='category_name' name='category_name' type='text' size='50' style='width: 300px'></p>
	Описание
	<p><textarea id='category_description' rows="10" cols="50" name='category_description'style='width: 300px'></textarea></p>		
	</form>
</div>

<div id="dialog-confirm-del" title="Подтвердите действие" style='display: none'>
	<p>Вы действительно хотите удалить эту категорию?</p>
</div>
<div id="dialog-confirm-edit" title="Редактировать категорию" style='display: none'>
	<form method='post'>
	Название
	<p><input id='category_name' name='category_name' type='text' size='50' style='width: 300px'></p>
	Алиас (для опытных пользователей)
	<p><input id='category_alias' name='category_alias' type='text' size='50' style='width: 300px'></p>
	Описание
	<p><textarea id='category_description' rows="10" cols="50" name='category_description'style='width: 300px'></textarea></p>		
	</form>
</div>

<script>
function reload()
{
	$('.ui-dialog').html( "close" );				
	$('div.content_my').load('admin/category',function(){show()}); 
}

$(function() {
$('td.td_options a.del_cat').click(function(){
	$get_id = $(this).attr('id');
	/*alert($rrtd);*/
	$(function() {    
	$( "#dialog-confirm-del" ).dialog({
      resizable: false,
      height:200,
	  width:370,
      modal: true,
      buttons: {
		"Удалить": function() {
			var form_data = {
				"id":$get_id
		        };
				$.ajax({
				dataType: 'json',
				type:'POST',
				data:'json_data=' + $.toJSON(form_data),
				url: '<?= base_url();?>admin/del_category',
				success: function($ret){
				reload();
				},
				error: function($exception){
					alert('error!');
					alert('Exeption:'+$exception);
				},
				done: function(){
					alert('done!');			
					alert('Exeption:'+$exception);
				}
				});
		   },
        "Отмена": function() {
          $( this ).dialog( "close" );
        }
	  }

});
});
});

$('td.td_options a.edit_cat').click(function(){
	$get_id = $(this).attr('id');
	$get_id = $get_id.replace(/[^-0-9]/gim,'');
	$name = $('.tr_category_'+$get_id+' .td_category_name').html();
	$description = $('.tr_category_'+$get_id+' .td_category_description').html();
	$alias = $('.tr_category_'+$get_id+' .td_category_alias').html();
	
	$('#dialog-confirm-edit #category_name').attr('value',$name);
	$('#dialog-confirm-edit #category_description').html($description);
	$('#dialog-confirm-edit #category_alias').attr('value',$alias);


	
	$(function() {
	$( "#dialog-confirm-edit" ).dialog({
      resizable: true,
      height:600,
	  width:570,
      modal: true,
      buttons: {
		"Принять изменения": function() {
			  var form_data = {
				"id":$get_id,
				"name":$("#dialog-confirm-edit #category_name").val(),
				"alias":$("#dialog-confirm-edit #category_alias").val(),
				"description":$("#dialog-confirm-edit #category_description").val()
		        };
				if (form_data.name !='' && form_data.description != '' && form_data.alias != '') {
				$.ajax({
				dataType: 'json',
				type:'POST',
				data:'json_data=' + $.toJSON(form_data),
				url: '<?= base_url();?>admin/edit_category',
				success: function($ret){
				reload();
				},
				error: function($exception){
					alert('error!');
					alert('Exeption:'+$exception);
				},
				done: function(){
					alert('done!');			
					alert('Exeption:'+$exception);
				}
				});
				} else alert('Поля должны быть заполнены');
		   },
        "Отмена": function() {
          $( this ).dialog( "close" );
        }
	  }

});
});
});

});

  $(function() {
    $('#add_category_btn_open_dlg').click(function(){
	$( "#dialog-confirm" ).dialog({
      resizable: false,
      height:550,
	  width:370,
      modal: true,
      buttons: {
        "Добавить категорию": function() {
				var form_data = {
				"name":$("#dialog-confirm #category_name").val(),
				"description":$("#dialog-confirm #category_description").val()
		        };
				if (form_data.name !='' && form_data.description != '') {
				$.ajax({
				dataType: 'json',
				type:'POST',
				data:'json_data=' + $.toJSON(form_data),
				url: '<?= base_url();?>admin/add_category',
				success: function($ret){
				//alert('Категория успешно добавлена');
				//$(this).dialog( "close" );
				reload();
				},
				error: function($exception){
					alert('error!');
					alert('Exeption:'+$exception);
				},
				done: function(){
					alert('done!');			
					alert('Exeption:'+$exception);
				}
				});
				} else alert('Поля должны быть заполнены');
        },
        "Отмена": function() {
          $( this ).dialog( "close" );
        }
      }
    });
  });
  })
</script>