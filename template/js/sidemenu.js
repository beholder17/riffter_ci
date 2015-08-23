$(document).ready(function(){
	check_active();
	function close_all()
	{
		$('.partner_item ul').slideUp(200);
	}
	
	function check_active()
	{
		$('li.partner_item ul li.active').parent().css('display','block');
		if ($('li').is('li.partner_item ul li.active')===true) {	
			$('ul#partners_list').css('display','block');
			$('.rich_world_products_list').css('display','none');
			//alert('sdf');
		}
	}
	
	$('.partner_item').click(function(){		
		//$('.partner_item ul:not(this)').slideDown(200);
		
		if ($(this).children().next().css('display') == 'none'){
			$('.partner_item ul').slideUp(200);
			$(this).children().next().slideToggle( 200, function(){});
		}
		});
	$('#partners').click(function(){
		$(this).next().slideToggle( 200, function() {});
		});
	$('.rich_world_products_btn').click(function(){
		$(this).next().slideToggle( 200, function() {});
		});

	//$('.view-partners-menu a.active').parent().parent().parent().parent().css('display','block');
//alert('done');
     $('.navigation_trigger').click(function(){
		
		$(this).next().slideToggle( 100, function() {});
		//$(this).next().toggle('slide');
	
    
		
		});                                 
                                        }
                            ); 
          