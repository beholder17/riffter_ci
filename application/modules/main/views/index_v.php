<?php $this->lang->load('main_menu', $this->uri->segment(1)); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<!--[if lt IE 9]>
    <script src="js/html5.js"></script>
	<![endif]-->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
	
	<link href="<?= base_url();?>template/css/basic_styles.css" rel="stylesheet" type="text/css"> 
	<script src="<?= base_url();?>template/js/css3-mediaqueries.js" type="text/javascript"></script>
	
	<link href="<?= base_url();?>template/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"> 
	
	
	<link href="<?= base_url();?>template/css/custom_styles.css" rel="stylesheet" type="text/css">
	<link href="<?= base_url();?>template/css/media_queries.css" rel="stylesheet" type="text/css">

	<link href="<?= base_url();?>template/css/animate.css" rel="stylesheet" type="text/css">
	
	<meta name="viewport" content="width=device-width">
	<meta name="viewport" content="initial-scale=1.0">
	<title><?= $seo_title ?></title>
	<meta name="keywords" content="<?= $seo_keywords ?>"/>
	<meta name="description" content="<?= $seo_description ?>"/>
	<meta name="robots" content="<?php if (isset($seo_index)) {if ($seo_index == '0') echo 'noindex,nofollow'; else echo 'index,follow';} else echo 'index,follow';?>">
	
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script src="<?= base_url();?>template/js/jquery.viewportchecker.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="<?= base_url();?>template/js/sidemenu.js"></script>
	
	<script type="text/javascript" src="<?= base_url()?>/template/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
	<script type="text/javascript" src="<?= base_url()?>/template/js/jquery.jcarousel.min.js"></script>
	
	<link href="<?= base_url().'template/jquery-ui-1.11.4.custom/'?>jquery-ui.css" rel="stylesheet" type="text/css">
	<link href="<?= base_url().'template/jquery-ui-1.11.4.custom/'?>theme_custom.css" rel="stylesheet" type="text/css">
	
	
	<script type="text/javascript" src="<?= base_url()?>template/js/jquery.json.min.js"></script>
	<script type="text/javascript" src="<?= base_url()?>template/js/jquery.serializejson.min.js"></script>

	<!-- Add fancyBox -->
	<link rel="stylesheet" href="<?= base_url();?>template/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
	<script type="text/javascript" src="<?= base_url();?>template/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>

</head>
<body>
    <h1>This is Spartaaa!!!</h1>
	<div id="pagewrap">
		<header id="header">
		<div id='header_phone'>+7 (908) 177-93-99</div>
		<div class='auth_block'>
			<?= $auth_form; ?>
		</div>
		<!--<div class='lang_switcher'>
			<p>ЯЗЫК</p>
			<a id='ru' href='#'></a>
			<a id='en' href='#'></a>
		</div>-->

		<?php echo modules::run('lang/switcher','main'); ?>
		<div class='shopping_cart'>
			<div class='shopping_cart_counter'>
				<div class='shopping_cart_counter_container'><?= $this->cart->total_items(); ?></div>
			</div>
			
			<div class='shopping_cart_informer'>
				<a href='<?= base_url().$this->uri->segment(1);?>/commerce/cart'><?= $this->lang->line('cart_term1');?> <span><?= $this->cart->total_items(); ?></span> <?= $this->lang->line('cart_term2');?></a>
			</div>
		</div>
		</header>
		 <nav>
			<div class='navigation_trigger'></div>
			 <ul id="main_nav">
				<li><a <?php //if ($this->uri->segment(2)==NULL) echo "class='active'";?> <?php if ( $this->uri->segment(2)==NULL) echo "class='active border_radius_left'"; ?> href="<?=base_url().$this->uri->segment(1)?>"><?= $this->lang->line('home');?></a></li>
				<li><a <?php if (stripos(uri_string(), 'news')==4) echo "class='active'"; ?> href="<?=base_url().$this->uri->segment(1)?>/news/"><?= $this->lang->line('news');?></a></li>
				<li><a <?php if (stripos(uri_string(), 'about')==4) echo "class='active'"; ?> href="<?=base_url().$this->uri->segment(1)?>/about"><?= $this->lang->line('about');?></a></li>
				<li><a <?php if (stripos(uri_string(), 'opt')==4) echo "class='active'"; ?> href="<?=base_url().$this->uri->segment(1)?>/opt"><?= $this->lang->line('wholesale');?></a></li>
				<li><a <?php if (stripos(uri_string(), 'payment-and-delivery')==4) echo "class='active'"; ?> href="<?=base_url().$this->uri->segment(1)?>/payment-and-delivery"><?= $this->lang->line('delivery_pay');?></a></li>
				<li><a <?php if (stripos(uri_string(), 'reviews')==4) echo "class='active'"; ?> href="<?=base_url().$this->uri->segment(1)?>/reviews"><?= $this->lang->line('reviews');?></a></li>
				<li><a <?php if (stripos(uri_string(), 'contacts')==4) echo "class='active'"; ?> href="<?=base_url().$this->uri->segment(1)?>/contacts/"><?= $this->lang->line('contacts');?></a></li>
			 </ul>
		  </nav>
		<aside id="sidebar">
			<div id='logo_block'>
				<a href='<?= base_url().$this->uri->segment(1)?>'></a>
			</div>
		  <div class='side_menu'>
		  
			<a id='novelty' href='<?= base_url().$this->uri->segment(1)?>/commerce/novelty'><?= $this->lang->line('novelty');?></a>
			<div class='rich_world_products_btn'>Rich World</div>
			<ul class='rich_world_products_list'>
				<?php foreach ($subcategory as $item){
				$link = base_url().$this->uri->segment(1).'/catalog/rich-world/'.$item['alias'];
				$link_to_compare = base_url().$this->uri->segment(1).'/catalog/'.$this->uri->segment(3).'/'.$this->uri->segment(4);
				if ($link_to_compare==$link) $current_marker = 'class="active"'; else $current_marker='';
				?>
				
				<li <?=$current_marker?>><a href='<?=$link?>'><?= $item['name'] ?></a></li>
				<?php }?>
			</ul>
			<a id='partners' href='javascript:void(0)'><?= $this->lang->line('partners');?></a>
			<ul id='partners_list'>
			<?php foreach ($category as $item): if ($item['name']=='Rich World') continue;?>
				<li class='partner_item'><p><?= $item['name']?></p>
					<ul>
					<?php foreach ($subcategory as $item_sc){
						$link = base_url().$this->uri->segment(1).'/catalog/'.$item['alias'].'/'.$item_sc['alias'];						
						$link_to_compare = base_url().$this->uri->segment(1).'/catalog/'.$this->uri->segment(3).'/'.$this->uri->segment(4);
						if ($link_to_compare==$link) $current_marker = 'class="active"'; else $current_marker='';
						?>
						
					<li <?=$current_marker?>><a href='<?=$link?>'><?= $item_sc['name'];?></a></li>
					<?php }?>
					</ul>
				</li>
			<?php endforeach?>
	
			</ul>
			</ul>
			<?php echo modules::run('commerce/block_recommended_slider','8'); ?>
		  </div>
		  
		</aside>  
		<div id="content">
		
			<div class='search_form'>
				<form method='post' action='<?= base_url()?><?= $this->uri->segment(1);?>/search'>
					<div class='search_form_lense'></div>
					<input placeholder='<?= $this->lang->line('search_placeholder');?>' name='search_text' id='search_text' type='text' value='<?php if (isset($search_text)) echo $search_text;?>' size='40'>
					<input name='search_btn' id='search_btn' type='submit' value='<?= $this->lang->line('search');?>'>
				</form>
			</div>
			<div style='position: relative; top: 15px;'>
				<?php if (current_url()==base_url().'index.php/en' OR current_url()==base_url().'index.php/tr' OR current_url()==base_url().'index.php/ru') echo "<div class='promo_link'>
					<a href='".base_url().$this->uri->segment(1)."/commerce/promo'></a>
				</div>" ?>
				
				<?php if (current_url()==base_url().'index.php/en' OR current_url()==base_url().'index.php/tr' OR current_url()==base_url().'index.php/ru') 
					echo modules::run('slider/index','main'); ?>
			</div>
			<?php if (current_url()==base_url().'index.php/en' OR current_url()==base_url().'index.php/tr' OR current_url()==base_url().'index.php/ru') echo modules::run('commerce/block_recommended','7'); ?>
			<div class='content_container' <?php if ( $this->uri->segment(1)==NULL) echo "content_container_void"?>>			
			<?php if (isset($block_news)) echo $block_news; ?>
			<?php if (isset($contacts)) echo $contacts; ?>
			<?php if (isset($content)) echo $content; ?>
			</div>
			
		  
		
		</div>
		
		<footer id="footer">
		<div class="phone_number_footer">+7 (908) 177-93-99</div>
		<ul class="menu_footer">			
			<li class=""><a href="#" class=""><?= $this->lang->line('delivery_pay');?></a></li>
			<li class=""><a href="#" class=""><?= $this->lang->line('contacts');?></a></li>
			<li class=""><a href="#" class=""><?= $this->lang->line('cart');?></a></li>
		</ul>
		</footer>
	</div>

</body>
</html>