<?php
//$route['news/:any'] = "content/index/([a-z]+)/([a-z]+)";
$link = mysql_connect("localhost", "root", "") or die("�� ���� ������������");
mysql_select_db("rich_t", $link) or die ('�� ���� ������� ��');
mysql_query("SET NAMES utf8");
/* content module routes*/
$query = "SELECT * FROM content_category";
$result=mysql_query($query);
while($r=mysql_fetch_array($result))
{
	/*$route[$r[1].'/:any'] = "content/index/([a-z]+)/([a-z]+)";
	$route[$r[1]] = "content/index/([a-z]+)";*/
	$route['ru/'.$r[1].'/:any'] = "content/index/([a-z]+)/([a-z]+)";
	$route['en/'.$r[1].'/:any'] = "content/index/([a-z]+)/([a-z]+)";	
	$route['tr/'.$r[1].'/:any'] = "content/index/([a-z]+)/([a-z]+)";	
	$route['ru/'.$r[1]] = "content/index/([a-z]+)";
	$route['en/'.$r[1]] = "content/index/([a-z]+)";
	$route['tr/'.$r[1]] = "content/index/([a-z]+)";
	//$route['(ru|en)/(:any)'] = "content/index/([a-z]+)";
}



mysql_close($link);
?>