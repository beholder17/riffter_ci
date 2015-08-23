<div class='news_block'>
<div class='h2_cover'>
<h2 class='h2_alt'><?php
if ($this->uri->segment(1)=='tr') echo "Son Haberler";
if ($this->uri->segment(1)=='en') echo "Latest news";
if ($this->uri->segment(1)=='ru') echo "Последние новости";
?></h2>
</div>

<?php //print_r ($content); 
function crop_str($string, $limit)  
{
$substring_limited = substr($string,0, $limit);        //режем строку от 0 до limit
return substr($substring_limited, 0, strrpos($substring_limited, ' ' ));    //берем часть обрезанной строки от 0 до последнего пробела
}



foreach ($news as $key=>$value)
{
?>
	<div class='content_list'>
	<div class='content_line'>
		<div class='content_line_title'><a href='<?= base_url().$this->uri->segment(1).'/'.$category_content.'/'.$value['alias'] ?>'><h3><?php
		if ($this->uri->segment(1)=='en') echo $value['title'];
		if ($this->uri->segment(1)=='tr') echo $value['title_tr'];
		?></h3></a></div>
		<div class='content_line_date'><?= $value['date'] ?></div>
		<div class='content_line_img animated'><a href='<?= base_url().$this->uri->segment(1).'/'.$category_content.'/'.$value['alias'] ?>'><img src='<?php if ($value['image']!=NULL) echo base_url().$value['image']; else echo base_url().'template/img/no_picture.jpg'; ?>'></a></div>
		<div class='content_line_anounce'><?php 
		/*if ($this->uri->segment(1)=='en') echo strip_tags(crop_str($value['fulltext'],700))."..."; */
		if ($this->uri->segment(1)=='ru') echo strip_tags(crop_str($value['fulltext'],700))."..."; 
		if ($this->uri->segment(1)=='tr') echo strip_tags(crop_str($value['fulltext_tr'],700))."..."; 
		?></div>
		<div class='content_line_readmore'><a href='<?= base_url().$this->uri->segment(1).'/'.$category_content.'/'.$value['alias'] ?>'>Узнать детали...</a></div>
	</div>
</div>

	
	<?php
}

?>
</div>
<style>
.content_line{
	position: relative;
	clear: both;
	height: 213px;
}

.content_line_img{
	
	width: 150px;
	height: 150px;
	overflow: hidden;
	float: left;
}

h2.h2_alt{
	text-transform: uppercase;
	text-align: left;
	margin-bottom: 0px;
	margin-left: 0px;
}
h2.h2_alt:before{
background-color: #972448;
  width: 35px;
  height: 31px;
  content: '>';
  color: white;
  margin-right: 10px;
  display: inline-block;
  text-align: center;
}

.content_line_readmore{position: absolute;
bottom: 10px;
right: 10px;
}

.h2_cover{
border-bottom: 2px solid #972448;
}
</style>
<script>
       $('.content_line_img').viewportChecker({
			classToAdd: 'fadeInUp', // Class to add to the elements when they are visible
			classToRemove: 'fadeInUp', // Class to remove before adding 'classToAdd' to the elements
			repeat: false // Add the possibility to remove the class if the elements are not visible
		});
</script>
