<h1><?php
if ($this->uri->segment(1)=='tr') echo 'Ne yazık ki, bu kategoride henüz ürün';
if ($this->uri->segment(1)=='ru') echo 'К сожалению, в данной категории пока нет товаров';
if ($this->uri->segment(1)=='en') echo 'Unfortunately, in this category yet no items';
?></h1>



