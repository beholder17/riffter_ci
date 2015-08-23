<?php
/**
 * Created by PhpStorm.
 * User: Ярослав
 * Date: 04.08.2015
 * Time: 12:37
 */
?>
<?php
function crop_str($string, $limit)
{
$substring_limited = substr($string,0, $limit);        //режем строку от 0 до limit
return substr($substring_limited, 0, strrpos($substring_limited, ' ' ));    //берем часть обрезанной строки от 0 до последнего пробела
}
?>

<h1>Отзывы</h1>
<?= $pager ?>
<div class="add_review"><a class="btn_v2" style='margin: 10px;' href="<?=base_url().$this->uri->segment(1)?>/reviews/add_review"><i class="fa fa-pencil"></i> Добавить свой отзыв</a></div>
<div style='margin-top:20px;'>
    <?php foreach($approved_reviews as $key => $value){ ?>
<div class="review_line">
    <div class="review_id"><?=$value['name'];?>,</div>
	
	<div class="review_city"><?=$value['city'];?></div>
	<img style='float: left; width: 100px; padding: 5px;' src='<?php if ($value['image']!=NULL) echo base_url().'assets/reviews_img/'.$value['image'];
	else echo base_url().'template/img/no_picture.jpg';
	?>'>
    <div class="review_text"><?=crop_str($value['fulltext'],300).'...';?></div>
    <div class="review_date"><?=$value['date'];?></div>
    <div class="review_link">
        <a href="<?= base_url().$this->uri->segment(1)?>/reviews/<?=$value['id']?>">Подробнее...</a>
    </div>
</div>



<?php } ?>
</div>

<?php //var_dump($approved_reviews); ?>
