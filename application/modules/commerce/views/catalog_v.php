<?php $this->lang->load('commerce', $this->uri->segment(1)); ?>
<?php 
//echo "<pre>";
//unset($content[0]['description']);
//print_r($subcategory_info);  ?>

<h1 style='margin-top: 5px; margin-bottom: 5px'><?=$category_info[0]['name']?></h1>
<h2 style='margin-top: 5px; margin-bottom: 5px'><?=$subcategory_info[0]['name']?></h2>
<?php


echo $pager;
?>
<div class='catalog_canvas'>
<?php
foreach ($content as $key=>$value){

	// get thumbnail file name
	$path_info = pathinfo($value['image']);
	$value['image'] = $path_info['filename'].'_thumb.'.$path_info['extension'];
?>

<div class='product_item' id='<?= $value['id']?>'>
<div class='product_item_image'><a href="<?= $subcategory_alias; ?>/<?= $value['id'] ?>"><img src='<?= base_url(); ?>assets/img/products/thumbs/<?= $value['image'] ?>'></a></div>
<div class='product_item_name'><a href='<?= $subcategory_alias; ?>/<?= $value['id'] ?>'><?php
if ($this->uri->segment(1)=='tr') echo $value['name_tr']; else echo $value['name'];
?></a></div>
<div class='product_item_price'><?php 
if ($this->uri->segment(1)=='en') {echo '$ '.$value['price-usd']; $by = 'by';}
if ($this->uri->segment(1)=='ru') {echo $value['price-rub'].' &#8399;'; $by = 'от';}
if ($this->uri->segment(1)=='tr') {echo $value['price-try'].' £'; $by = 'by';}
?></div>
<div class='product_item_buy
<?php 
$at_cart = array_keys($cart);
$count = count($cart);
$output_txt = "";
for ($i = 0; $i < $count; $i++)
{
	if ($cart[$at_cart[$i]]['id'] == $value['id']) {$output_txt = "at_cart"; 
	$tmp = true;
	continue;
	}
}
echo $output_txt;
?>
'>

<?php 
$at_cart = array_keys($cart);
$count = count($cart);
$output_txt = $this->lang->line('catalog_add_to_cart');
for ($i = 0; $i < $count; $i++)
{
	if ($cart[$at_cart[$i]]['id'] == $value['id']) {$output_txt = $this->lang->line('already_at_cart');
	$tmp = true;
	continue;
	}
}
echo $output_txt;
?>
<input type='hidden' value="<?= $value['id'] ?>">
</div>

<?php if ($this->session->userdata('level')=='99') { ?>
<a class='edit_item_link' href='<?= base_url();?>admin/edit_product/<?= $value['id'] ?>'>Edit</a>
<?php }?>

<div class='comparsion' id='c_<?= $value['id'] ?>'><?= $this->lang->line('add_to_comparsion');?></div>
</div>

	
<?php	

}
echo '<div class="bottom_pager">'.$pager.'</div>';

//$session_id = $this->session->userdata('session_id');
//echo $session_id;
//print_r ($this->session->userdata('comparsion'));
?>
</div>
<div class='bottom_description'>

<h2><?=$subcategory_info[0]['name']?> <?=$by;?> <?=$category_info[0]['name']?></h2>
<p><?=$subcategory_info[0]['fulltext']?></p>
</div>
<style>
.bottom_description{
	display: inline-block;
	margin-top: 50px;
}

.catalog_canvas{
	display: table;
  width: 100%;
}
</style>

<script>
	    $(document).ready(function(){
                $('.product_item_buy').click(function(){
					if (!$(this).hasClass('at_cart')) {
					$id = $(this).children().attr('value');
					//alert($id);
						$.ajax({
						dataType: 'text',
						type:'POST',
						data:'json_data='+$id,
						url: '<?= base_url().$this->uri->segment(1);?>/commerce/add_to_cart',
						success: function($ret){
						//reload();
						//alert('в корзине');
						$('#'+$id+' .product_item_buy').html('В корзине');
						$offset = $('#'+$id+' .product_item_image img').offset();
						$offset_cart = $('.shopping_cart_informer').offset();
						$left = $offset.left;//+0.5;
						$top = $offset.top;//+0.5;
						//alert($left+' - '+$top);
						//$('#'+$id+' .product_item_image').eq(0).clone();
						$('body').append('<img style="z-index: 100; width: 218px; height: 218px; position: absolute; top: '+$top+'px; left: '+$left+'px" id="tmp_'+$id+'" src="<?= base_url(); ?>assets/img/products/thumbs/<?= $value['image'] ?>">');
						//$('img #tmp_'+$id).css('position','absolute');
						$('body img#tmp_'+$id).animate( { "position":"absolute","top": $offset_cart.top+"px" },
						{queue:false, duration:450 } )
						 .animate( { "left": $offset_cart.left+"px" }, {queue:false, duration:450 } )
						 .animate( { "width":"20px" }, {queue:false, duration:450 } )
						 .animate( { "height":"20px" }, {queue:false, duration:450 } )
						 .animate( { "opacity":"0" }, {queue:false, duration:450 } );
						setTimeout(function(){
							$('body img#tmp_'+$id).remove(); 
						}, 1000);
						
						$shopping_cart_items = parseInt($('.shopping_cart_informer a span').html());						
						$shopping_cart_items = $shopping_cart_items+1;
						$('.shopping_cart_informer a span').html($shopping_cart_items);
						$('.shopping_cart_counter_container').html($shopping_cart_items);
						
						//$('#'+$id+' .product_item_image').appendTo('#logo_block');
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
						} else alert('Уже в корзине');
				})
		$('.comparsion').click(function(){
			$id = $(this).attr('id').substr(2);
			//alert($id);
			$.ajax({
						dataType: 'text',
						type:'POST',
						data:'id='+$id,
						url: '<?= base_url().$this->uri->segment(1);?>/commerce/add_to_comparsion',
						success: function($ret){
							alert($ret);
						},
						error: function($exception){
						}
			})
		})
		})
</script>


