<?php $this->lang->load('commerce', $this->uri->segment(1)); ?>
<?php
// get thumbnail file name
$path_info = pathinfo($item[0]['image']);
$thumbnail_image = $path_info['filename'] . '_thumb.' . $path_info['extension'];

?>

<h1 style="margin: 15px 10px 15px 10px"><?php
    if ($this->uri->segment(1) == 'tr') echo $item[0]['name_tr']; else echo $item[0]['name'];
    ?></h1>


<div class='item_image'>

    <a class="fancybox-button" rel="fancybox-button"
       href='<?= base_url(); ?>assets/img/products/<?= $item[0]['image']; ?>' title="<?= $item[0]['name']; ?>">
        <img src='<?= base_url(); ?>assets/img/products/thumbs/<?= $thumbnail_image; ?>'>
    </a>


</div>
<div class='item_description'>

	<?php if ($this->session->userdata('level')=='99') { ?>
    <div class="edit_item_link"><a href="<?= base_url(); ?>admin/edit_product/<?= $item[0]['id'] ?>">Edit</a>
    </div>
	<?php }?>

    <div class="product_description_line"><span>Category: </span><?= $item[0]['category'] ?></div>
    <div class="product_description_line"><span>Subategory: </span> <a
            href="<?= base_url() . 'catalog/' . $item[0]['category_alias'] . '/' . $item[0]['subcategory_alias'] ?>"><?= $item[0]['subcategory'] ?></a>
    </div>
    <div class="product_description_line"><span>Art: </span> <?= $item[0]['sku'] ?></div>


    <div class='product_description_line'><span>Status: </span><?php
        if ($item[0]['status'] == 1) echo $this->lang->line('item_available');
        if ($item[0]['status'] != 1) echo $this->lang->line('item_not_available');
        ?></div>

	<div class="product_description_line" style='font-size: 33px !important;'><span>Price: </span> <?php 
	if ($this->uri->segment(1)=='en') echo '$ '.$item[0]['price-usd'];
	if ($this->uri->segment(1)=='ru') echo $item[0]['price-rub'].' &#8399;';
	if ($this->uri->segment(1)=='tr') echo $item[0]['price-try'].' £';
	?></div>	
	<?php //var_dump($cart);?>
    <div class='product_item_buy_individual <?php 
	$at_cart = array_keys($cart);
	$count = count($cart);
	$output_txt = "";
	for ($i = 0; $i < $count; $i++)
	{
		if ($cart[$at_cart[$i]]['id'] == $item[0]['id']) {$output_txt = "at_cart"; 
		$tmp = true;
		continue;
		}
	}
	echo $output_txt;
	?>' id='<?=$item[0]['id'];?>'><?= $this->lang->line('catalog_add_to_cart'); ?></div>
    <?php //if ($this->uri->segment(1) == 'tr') echo '<div class="product_description_line">'.$item[0]['description_tr'].'</div>'; ?>
    <?php //if ($this->uri->segment(1) == 'en') echo '<div class="product_description_line">'.$item[0]['description'].'</div>'; ?>
	<script type="text/javascript" src="//yastatic.net/share/share.js" charset="utf-8"></script><div class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="none" data-yashareQuickServices="vkontakte,facebook,twitter,odnoklassniki"></div>
</div>

<div class='item_tabs'>
    <div id="tabs">
        <ul>
            <li><a href="#tabs-1">Описание</a></li>
            <li><a href="#tabs-2">Характеристики</a></li>
            <li><a href="#tabs-3">Отзывы</a></li>
        </ul>
        <div id="tabs-1">
            <p><?= $item[0]['description']; ?></p>
        </div>
        <div id="tabs-2">
            <?php
            if ($item[0]['volume'] != NULL) echo "<p>Volume: " . $item[0]['volume'] . "</p>";
            if ($item[0]['width'] != NULL) echo "<p>Width: " . $item[0]['width'] . "</p>";
            if ($item[0]['height'] != NULL) echo "<p>Height: " . $item[0]['height'] . "</p>";
            if ($item[0]['thickness'] != NULL) echo "<p>thickness: " . $item[0]['thickness'] . "</p>";
            if ($item[0]['weight'] != NULL) echo "<p>weight: " . $item[0]['weight'] . "</p>";
            if ($item[0]['material'] != NULL) echo "<p>material: " . $item[0]['material'] . "</p>";
            if ($item[0]['abrasiveness'] != NULL) echo "<p>abrasiveness: " . $item[0]['abrasiveness'] . "</p>";
            ?>
        </div>
        <div id="tabs-3">
            <p>VK Widget Code</p>
        </div>
    </div>
</div>
<script>
    $(function () {
        $("#tabs").tabs();
    });
</script>

<div style='clear: both'></div>
<pre>
<?php //print_r($cart); ?>
    <?php //var_dump($item[0]); ?>

    <script>
        $(document).ready(function () {
            $('.product_item_buy_individual').click(function () {
                if (!$(this).hasClass('at_cart')) {
                    //$id = $(this).children().attr('value');
					$id = $(this).attr('id');
                    //alert($id);
                    $.ajax({
                        dataType: 'text',
                        type: 'POST',
                        data: 'json_data=' + $id,
                        url: '<?= base_url().$this->uri->segment(1);?>/commerce/add_to_cart',
                        success: function ($ret) {
                            //reload();
                            //alert('в корзине');
                            $('.product_item_buy_individual').html('В корзине');
                            $offset = $('.item_image img').offset();
                            $offset_cart = $('.shopping_cart_informer').offset();
                            $left = $offset.left;//+0.5;
                            $top = $offset.top;//+0.5;
                            //alert($left+' - '+$top);
                            //$('#'+$id+' .product_item_image').eq(0).clone();
                            $('body').append('<img style="z-index: 100; width: 218px; height: 218px; position: absolute; top: ' + $top + 'px; left: ' + $left + 'px" id="tmp_' + $id + '" src="<?= base_url(); ?>assets/img/products/thumbs/<?= $thumbnail_image;?>">');
                            //$('img #tmp_'+$id).css('position','absolute');
                            $('body img#tmp_' + $id).animate({"position": "absolute", "top": $offset_cart.top + "px"},
                                {queue: false, duration: 450})
                                .animate({"left": $offset_cart.left + "px"}, {queue: false, duration: 450})
                                .animate({"width": "20px"}, {queue: false, duration: 450})
                                .animate({"height": "20px"}, {queue: false, duration: 450})
                                .animate({"opacity": "0"}, {queue: false, duration: 450});
                            setTimeout(function () {
                                $('body img#tmp_' + $id).remove();
                            }, 1000);

                            $shopping_cart_items = parseInt($('.shopping_cart_informer a span').html());
                            $shopping_cart_items = $shopping_cart_items + 1;
                            $('.shopping_cart_informer a span').html($shopping_cart_items);
                            $('.shopping_cart_counter_container').html($shopping_cart_items);

                            $('.product_item_buy_individual').addClass('at_cart');
                            //$('#'+$id+' .product_item_image').appendTo('#logo_block');
                        },
                        error: function ($exception) {
                            alert('error!');
                            alert('Exeption:' + $exception);
                        },
                        done: function () {
                            alert('done!');
                            alert('Exeption:' + $exception);
                        }
                    });
                } else alert('Уже в корзине');
            })


            $(".fancybox-button").fancybox({
                prevEffect: 'none',
                nextEffect: 'none',
                closeBtn: true,
                helpers: {
                    title: {type: 'inside'},
                    buttons: {}
                }
            });

        })
    </script>
