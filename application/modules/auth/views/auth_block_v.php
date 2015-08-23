<form id='auth_form_already' name="auth_form_already" method="post" action="javascript:void(0);">
					<!--Welcome, <?= $this->session->userdata('name'); ?>-->
					
					
					<?php if ($this->session->userdata('logged_in')==true AND $this->session->userdata('level')=='1') {?><a href='<?= base_url().$this->uri->segment(1)?>/auth/account'>Account</a><?php }?>
					<?php if ($this->session->userdata('level')=='99') {?><a href='<?= base_url()?>admin'>Administration</a><?php }?>
					&nbsp&nbsp|&nbsp&nbsp&nbsp <i class="fa fa-sign-out"></i><input id="logout_button" type="submit" value="Выход">
</form>
<div id="dialog-message" title=""></div>

<script>
function auth_info_window($auth_window_header,$window_content,$redirect)
{
	$(function(){
		$('#dialog-message').html($window_content);
		$('#dialog-message').attr('title',$auth_window_header);
				$( "#dialog-message" ).dialog({
				  modal: true,
				  buttons: {
					Ok: function() {
					  $( this ).dialog( "close" );
					  if ($redirect==1) window.location.replace("<?=base_url()?>"); else location.reload(true);
					}
				  }
				});
			  });
}

$(document).ready(function(){        
    $('#logout_button').click(function(){
		$.ajax({
		dataType: 'json',
		type:'POST',
		url: '<?= base_url(); ?>auth/logout/',
		success: function(){		
		auth_info_window('Выход','<p>Заходите к нам еще!</p>',1);		
		
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
		})	
	})
</script>