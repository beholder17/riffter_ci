<?php
//$route['news/:any'] = "content/index/([a-z]+)/([a-z]+)";
$link = mysql_connect("localhost", "root", "") or die("�� ���� ������������");
mysql_select_db("rich_t", $link) or die ('�� ���� ������� ��');
mysql_query("SET NAMES utf8");
/* pages - 'main' module routes*/
$query = "SELECT * FROM pages WHERE `show`='1'";
$result=mysql_query($query);
while($r=mysql_fetch_array($result))
{
	//$route['$r[8]] = "main/index/:any";
	$route['ru/'.$r[12]] = "main/index/:any";
	$route['en/'.$r[12]] = "main/index/:any";
	$route['tr/'.$r[12]] = "main/index/:any";
}

/* �������� - �� ������ ���������� ����������� */
//http://rich_t.ru/index.php/main/index/kh
//$route[':any'] = "main/index/$1";
$route['en/forbidden'] = "main/forbidden";
$route['ru/forbidden'] = "main/forbidden";
$route['tr/forbidden'] = "main/forbidden";




mysql_close($link);
?>