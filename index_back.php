<?php

$tablesPrefix = 'pamira_';
	
$dbhost="u330431.mysql.masterhost.ru";
$dbuser="u330431";
$dbpass="6_4OCkstE-eS";
$dbname="u330431";	
	
$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
	
/* Проверка подключения */ 
if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();        
}

if (isset($_POST['catalog']) && isset($_POST['submit'])) {
	// Вывод товаров
	
	$where = "WHERE TOV.id_cat = ".$_POST['catalog'];
	if (isset($_POST['style'])) $where .= " AND TOV.id_style = '".$_POST['style']."'";
	if (isset($_POST['type'])) $where .= " AND TOV.id_type = '".$_POST['type']."'";
	if (isset($_POST['brand'])) $where .= " AND TOV.id_brand = '".$_POST['brand']."'";
	if (isset($_POST['material'])) $where .= " AND TOV.id_material = '".$_POST['material']."'";
	if (isset($_POST['color'])) $where .= " AND TOV.id_color_ = '".$_POST['color']."'";
	if (isset($_POST['size'])) $where .= " AND TOV.id_size = '".$_POST['size']."'";
	if (isset($_POST['base'])) $where .= " AND TOV.id_base = '".$_POST['base']."'";
	if (isset($_POST['min'])) $where .= " AND TOV.cost > ".$_POST['min'];
	if (isset($_POST['max'])) $where .= " AND TOV.cost < ".$_POST['max'];

	$query = "SELECT CAT.name_lat as catalog, PODCAT1.name_lat as podcatalog1, PODCAT2.name_lat as podcatalog2, TOV.name_lat, TOV.name_rus, TOV.img, TOV.cost 
FROM ".$tablesPrefix."tovar as TOV 
LEFT JOIN ".$tablesPrefix."catalog as CAT 
ON CAT.id = TOV.id_cat 
LEFT JOIN ".$tablesPrefix."podcatalog1 as PODCAT1
ON PODCAT1.id = TOV.id_podcat1 AND PODCAT1.id_cat = CAT.id
LEFT JOIN ".$tablesPrefix."podcatalog2 as PODCAT2
ON PODCAT2.id = TOV.id_podcat2 AND PODCAT2.id_podcat = PODCAT1.id ".$where."
 ORDER BY CAT.name_rus";
	
	if ($result = $mysqli->query($query)) {
		if ($result->num_rows == 0) echo 'Нет товаров';
		while($data = $result->fetch_assoc())
		{
			//echo 'PODCAT1: '.$data['podcatalog1'].', PODCAT2: '.$data['podcatalog2'];
			// ссылка на товар
			$href = '/catalog/'.$data['catalog'].'/';
			$href .= $data['podcatalog1'] != '' ? $data['podcatalog1'].'/' : '';
			$href .= $data['podcatalog2'] != '' ? $data['podcatalog2'].'/' : '';
			//$href .= $_POST['catalog'] == '3''_/'.$data['name_lat'] ;
			switch($_POST['catalog']) {
				case 1:
				case 4:
				case 5:
				case 13:
				case 14:
					$href .= $data['name_lat'];
					break;
				default:
					$href .= '_/'.$data['name_lat'];
					break;
			}
			
			// ссылка на изображение
			$img = isset($data['img']) ? '/includes/imgresize.php?r=4&file=../imgtovar/'.$data['img'] : '';
			
			// цена
			$cost = $data['cost'] != '0.00' ? $data['cost'] : 'Уточните цену у менеджера';
			
			if ($cost != '0.00' && $cost != 'Уточните цену у менеджера')
			{
				$arr = explode('.', $cost);				
				
				if ($arr[1] == '00')
					$sec = '';
				else
					$sec = '.'.$arr[1];
					
				$arr = strrev($arr[0]);
				$cost = '';
				for ($i = 0; $i < strlen($arr); ++$i)
					if (($i+1) % 3 == 0)
						$cost .= $arr[$i].' ';
					else 
						$cost .= $arr[$i];
				$cost = strrev($cost).$sec.' руб.';
			}
			
			// название товара
			$title = $data['name_rus'];
			//echo $data['catalog'].", ".$data['img'].", ".$data['cost'].", ".$data['name_rus']."\n";
			//print_r($data);
			if($_REQUEST['logout'] == '1') $cost = 'Уточните цену у менеджера';
			echo '<div class="box2"><a title="" href="'.$href.'"><img alt="" src="'.$img.'"></a><span id="spannook2">'.$cost.'</span><br /><br /><a title="" href="'.$href.'">'.$title.'</a></div>';
		}
		$result->close();            
	}
}
else if (isset($_POST['style']) && isset($_POST['catalog'])) {
	$query = "SELECT DISTINCT S.id, S.name 
FROM `pamira_tovar` as T 
LEFT JOIN pamira_style as S 
ON T.id_style = S.id 
WHERE T.id_style != 0 AND T.id_cat = ".$_POST['catalog']."
ORDER BY S.id";
	if ($result = $mysqli->query($query)) {
		while($data = $result->fetch_assoc())
			echo '<option value="'.$data['id'].'">'.$data['name'].'</option>';
		$result->close();            
	}
}
else if (isset($_POST['type']) && isset($_POST['catalog'])) {
	$query = "SELECT DISTINCT S.id, S.name 
FROM `pamira_tovar` as T 
LEFT JOIN pamira_type as S 
ON T.id_type = S.id 
WHERE T.id_type != 0 AND T.id_cat = ".$_POST['catalog']."
ORDER BY S.id";
	if ($result = $mysqli->query($query)) {
		while($data = $result->fetch_assoc())
			echo '<option value="'.$data['id'].'">'.$data['name'].'</option>';
		$result->close();            
	}
}
else if (isset($_POST['brand']) && isset($_POST['catalog'])) {
	$query = "SELECT DISTINCT S.id, S.name 
FROM `pamira_tovar` as T 
LEFT JOIN pamira_brand as S 
ON T.id_brand = S.id 
WHERE T.id_brand != 0 AND T.id_cat = ".$_POST['catalog']."
ORDER BY S.id";
	if ($result = $mysqli->query($query)) {
		while($data = $result->fetch_assoc())
			echo '<option value="'.$data['id'].'">'.$data['name'].'</option>';
		$result->close();            
	}
}
else if (isset($_POST['material']) && isset($_POST['catalog'])) {
	$query = "SELECT DISTINCT S.id, S.name 
FROM `pamira_tovar` as T 
LEFT JOIN pamira_material as S 
ON T.id_material = S.id 
WHERE T.id_material != 0 AND T.id_cat = ".$_POST['catalog']."
ORDER BY S.id";
	if ($result = $mysqli->query($query)) {
		while($data = $result->fetch_assoc())
			echo '<option value="'.$data['id'].'">'.$data['name'].'</option>';
		$result->close();            
	}
}
else if (isset($_POST['color']) && isset($_POST['catalog'])) {
	$query = "SELECT DISTINCT S.id, S.name_color as name 
FROM `pamira_tovar` as T 
LEFT JOIN pamira_color as S 
ON T.id_color_ = S.id 
WHERE T.id_color_ != 0 AND T.id_cat = ".$_POST['catalog']."
ORDER BY S.id";
	if ($result = $mysqli->query($query)) {
		while($data = $result->fetch_assoc())
			echo '<option value="'.$data['id'].'">'.$data['name'].'</option>';
		$result->close();            
	}
}
else if (isset($_POST['size']) && isset($_POST['catalog'])) {
	$query = "SELECT DISTINCT S.id, S.name 
FROM `pamira_tovar` as T 
LEFT JOIN pamira_size as S 
ON T.id_size = S.id 
WHERE T.id_size != 0 AND T.id_cat = ".$_POST['catalog']."
ORDER BY S.id";
	if ($result = $mysqli->query($query)) {
		while($data = $result->fetch_assoc())
			echo '<option value="'.$data['id'].'">'.$data['name'].'</option>';
		$result->close();            
	}
}
else if (isset($_POST['base']) && isset($_POST['catalog'])) {
	$query = "SELECT DISTINCT S.id, S.name 
FROM `pamira_tovar` as T 
LEFT JOIN pamira_base as S 
ON T.id_base = S.id 
WHERE T.id_base != 0 AND T.id_cat = ".$_POST['catalog']."
ORDER BY S.id";
	if ($result = $mysqli->query($query)) {
		if ($result->num_rows > 0) 
			while($data = $result->fetch_assoc())
				echo json_encode(array('id' => $data['id'], 'name' => $data['name']));
		$result->close();            
	}
}
else if (isset($_POST['cost']) && isset($_POST['catalog'])) {
	$query = "SELECT min(cost) as min, max(cost) as max
FROM `pamira_tovar` as T
WHERE T.id_cat = ".$_POST['catalog'];
	if ($result = $mysqli->query($query)) {
		while($data = $result->fetch_assoc())
		{
			if ($data['min'] === null) $data['min'] = '0.00';
			if ($data['max'] === null) $data['max'] = '0.00';
			echo json_encode(array('min' => $data['min'], 'max' => $data['max']));
		}
		$result->close();            
	}
}

/*if (isset($_POST['sql'])) {
	//$result = array();
	if ($result = $mysqli->query($_POST['sql'])) {
		while($data = $result->fetch_assoc())
		{
			//$result[] = $data;
			//print_r($data);
			//if (isset($data['name']))
			//	$data['name'] = iconv ("cp1251", "utf-8", $data['name']);
			//echo json_encode($data);
			
			if (isset($data['id']) && isset($data['name']))
				echo '<option value="'.$data['id'].'">'.$data['name'].'</option>';
			elseif (isset($data['min']) && isset($data['max']))
				echo '<option value="min">'.$data['min'].'</option><option value="max">'.$data['max'].'</option>';
			
		}
		$result->close();       
	}
	//echo json_encode($result);
}
*/

else {


session_start();
if(($page=='cart')and($_POST['submit']=='Пересчитать'))
{
	session_start();
}
if(($page=='ordermake')and($_POST['submit']=='Подтвердить заказ'))
{
	session_start();
}
if(($page=='catalog')and($id=='Posudomoechnye_mashiny'))
{
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: http://www.pamira.ru/catalog/posudomoechnye-mashiny/");
	exit();	
}
if(($page=='tovar_po_brandu')and($id=='AEG'))
{
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: http://www.pamira.ru/tovar_po_brandu/aeg/");
	exit();	
}
$basedir = isset($_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT'] : '';
//$basedir.='/pamira';
$httphost=$_SERVER['HTTP_HOST'];
require_once $basedir.'/includes/config.php';
require_once $basedir.'/includes/dbconnect.php';
if($page=='akcii')
{
	session_start();
	if($_REQUEST['logout'] == '1')
	{
		$_SESSION['logged_cat']="";
		$_SESSION['akcia']=false;
		unset($_SESSION);
	}
	if(($_REQUEST['cat_users']!='') && ($_REQUEST['password']!=''))
	{
		$ktoavt=1;
		require ($basedir."/admin/sources/login.php");
	}
	/*
	if(($_SESSION['akcia'] == true)&&($err==0))
	{
		$getuserdata=mysql_query("SELECT * FROM ".$tablesPrefix."userscat WHERE id_cat='".$_SESSION['logged_cat']."'");
		$rowuserdata=mysql_fetch_array($getuserdata);
		$user_categ=$rowuserdata['categ'];
		$user_name=$rowuserdata['name'];
		$user_admin=$rowuserdata['admin'];
	}
	*/
}
//if($page=='str_designer')
//{
	//if(($_REQUEST['users']=='desi') && ($_REQUEST['password']=='777'))
	if(($_REQUEST['users']=='desi') && ($_REQUEST['password']!=''))
	{
		$ismembers=mysql_query("SELECT * FROM ".$tablesPrefix."members WHERE pass='".md5($_REQUEST['password'])."' LIMIT 1");
		if(mysql_num_rows($ismembers) == 1)
		{
			$rowmembers=mysql_fetch_array($ismembers);
			session_start();
			//$_SESSION['logged_desi']='desi';
			$_SESSION['logged_desi']=$rowmembers['name'];
			$_SESSION['id_desi']=$rowmembers['id'];
			$_SESSION['desi']  = true;
		}
	}
//}
if($_REQUEST['logout'] == '1')
{
	$_SESSION['logged_desi']="";
	$_SESSION['desi']=false;
	unset($_SESSION);
	$k=@array_keys($t[all]);
	for ($i=0; $i<count($k); $i++)
	{
		unset($t[$k[$i]]);
		unset($t[all][$k[$i]]);
	}
}
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

	<?php
	switch($page)
	{
		case 'about':
				echo '<title>О компании</title>
					 <meta name="description" content=" " />
					 <meta name="keywords" content=" " />';
		break;
		case 'contact':
				echo '<title>Контакты</title>
					 <meta name="description" content=" " />
					 <meta name="keywords" content=" " />';
		break;
		case 'akcii':
				echo '<title>Акции</title>
					 <meta name="description" content=" " />
					 <meta name="keywords" content=" " />';
		break;
		case 'sale':
				echo '<title>Распродажи</title>
					 <meta name="description" content=" " />
					 <meta name="keywords" content=" " />';
		break;
		case 'tovar_po_brandu':
				require ($basedir."/sources/tovar_po_brandu.php");
				/*
				echo '<title>Памира - техника для кухни в Ростове-на-Дону. Дилер '.$rowbrand['name'].' в Ростове.</title>
					 <meta name="description" content="Интернет-магазин Памира, официального дилера '.$rowbrand['name'].' в Ростове-на-Дону" />
					 <meta name="keywords" content="Памира, '.$rowbrand['name'].''.$viewdescrbrand.'" />';
				*/
				/*
				echo '<title>'.$rowbrand['name'].' в Ростове. Официальный дилер '.$rowbrand['name'];
				if($rowbrand['name']=='Franke') echo ' (Франке)';
				if($rowbrand['name']=='Electrolux') echo ' (Электролюкс)';
				echo ' магазин Памира.</title>
					 <meta name="description" content="'.$rowbrand['name'].' в интернет-магазине Памира, официального дилера '.$rowbrand['name'].' в Ростове-на-Дону" />';
				*/
				switch($rowbrand['name'])
				{
				case 'Gorenje':
					echo '<title>'.$rowbrand['name'].', купить '.$rowbrand['name'].' в интернет-магазине Памира</title>';
					echo '<meta name="description" content="'.$rowbrand['name'].' по привлекательным ценам в интернет-магазине Памира. Интернет-магазин Памира - широкий выбор встраиваемой техники для кухни." />';
				break;
				case 'Liebherr':
					echo '<title>'.$rowbrand['name'].', купить '.$rowbrand['name'].' в интернет-магазине Памира</title>';
					echo '<meta name="description" content="'.$rowbrand['name'].' по привлекательным ценам в интернет-магазине Памира. Интернет-магазин Памира - широкий выбор встраиваемой техники для кухни." />';
				break;
				case 'Faber':
					echo '<title>'.$rowbrand['name'].', купить '.$rowbrand['name'].' в интернет-магазине Памира</title>';
					echo '<meta name="description" content="'.$rowbrand['name'].' по привлекательным ценам в интернет-магазине Памира. Интернет-магазин Памира - широкий выбор встраиваемой техники для кухни." />';
				break;
				case 'Neff':
					echo '<title>'.$rowbrand['name'].' в интернет-магазине Памира</title>';
					echo '<meta name="description" content="'.$rowbrand['name'].' по привлекательным ценам в интернет-магазине Памира. Интернет-магазин Памира - широкий выбор встраиваемой техники для кухни." />';
				break;
				case 'Franke':
					echo '<title>'.$rowbrand['name'].', купить Франке в интернет-магазине Памира</title>';
					echo '<meta name="description" content="'.$rowbrand['name'].' / Франке по привлекательным ценам в интернет-магазине Памира. Интернет-магазин Памира - широкий выбор встраиваемой техники для кухни." />';
				break;
				case 'Electrolux':
					echo '<title>'.$rowbrand['name'].', купить Электролюкс в интернет-магазине Памира</title>';
					echo '<meta name="description" content="'.$rowbrand['name'].' / Электролюкс по привлекательным ценам в интернет-магазине Памира. Интернет-магазин Памира - широкий выбор встраиваемой техники '.$rowbrand['name'].' для кухни." />';
				break;
				case 'AEG':
					//echo '<title>aeg в интернет-магазине Памира</title>';
					echo '<title>AEG. Бытовая техника AEG. Купить  в интернет-магазине Pamira.ru</title>';
					//echo '<meta name="description" content="aeg по привлекательным ценам в интернет-магазине Памира. Интернет-магазин Памира - широкий выбор встраиваемой техники для кухни." />';
					echo '<meta name="description" content="Производитель AEG. Продукция производителя" />';
				break;
				default:
					//echo '<title>'.$rowbrand['name'].' в Ростове. Официальный дилер '.$rowbrand['name'];
					//if($rowbrand['name']=='Franke') echo ' (Франке)';
					//if($rowbrand['name']=='Electrolux') echo ' (Электролюкс)';
					//echo ' магазин Памира.</title>
					echo '<title>'.$rowbrand['name'].' в интернет-магазине Памира</title>';
					 //<meta name="description" content="'.$rowbrand['name'].' в интернет-магазине Памира, официального дилера '.$rowbrand['name'].' в Ростове-на-Дону" />';
					echo '<meta name="description" content="'.$rowbrand['name'].' по привлекательным ценам в интернет-магазине Памира. Интернет-магазин Памира - широкий выбор встраиваемой техники для кухни." />';
				break;
				}
				switch($rowbrand['name'])
				{
				case 'aeg':
					if(($id1=='')&($id2=='')) echo '<meta name="keywords" content="aeg" />'; else echo '<meta name="keywords" content="'.$rowbrand['name'].', Памира'.$viewdescrbrand.'" />';
				break;
				case 'Gorenje':
					if(($id1=='')&($id2=='')) echo '<meta name="keywords" content="gorenje" />'; else echo '<meta name="keywords" content="'.$rowbrand['name'].', Памира'.$viewdescrbrand.'" />';
				break;
				case 'Franke':
					if(($id1=='')&($id2=='')) echo '<meta name="keywords" content="franke, франке" />'; else echo '<meta name="keywords" content="'.$rowbrand['name'].', Памира'.$viewdescrbrand.'" />';
				break;
				case 'Faber':
					if(($id1=='')&($id2=='')) echo '<meta name="keywords" content="faber" />'; else echo '<meta name="keywords" content="'.$rowbrand['name'].', Памира'.$viewdescrbrand.'" />';
				break;
				case 'Zanussi':
					if(($id1=='')&($id2=='')) echo '<meta name="keywords" content="zanussi" />'; else echo '<meta name="keywords" content="'.$rowbrand['name'].', Памира'.$viewdescrbrand.'" />';
				break;
				case 'Electrolux':
					if(($id1=='')&($id2=='')) echo '<meta name="keywords" content="electrolux, electrolux купить, электролюкс, electrolux куплю" />'; else echo '<meta name="keywords" content="'.$rowbrand['name'].', Памира'.$viewdescrbrand.'" />';
				break;
				case 'Liebherr':
					if(($id1=='')&($id2=='')) echo '<meta name="keywords" content="liebherr" />'; else echo '<meta name="keywords" content="'.$rowbrand['name'].', Памира'.$viewdescrbrand.'" />';
				break;
				case 'Neff':
					if(($id1=='')&($id2=='')) echo '<meta name="keywords" content="neff" />'; else echo '<meta name="keywords" content="'.$rowbrand['name'].', Памира'.$viewdescrbrand.'" />';
				break;
				default:
					echo '<meta name="keywords" content="'.$rowbrand['name'].', Памира'.$viewdescrbrand.'" />';
				break;
				}
		break;
		case 'catalog':
				require ($basedir."/sources/catalog.php");
				switch($rowcatalog['name_rus'])
				{
				case 'Варочные поверхности':
					$viewkeywtovar='Варочная панель, '.$viewkeywtovar;	
					echo '<title>Варочная панель или '.$viewtitletovar.'</title>';
				break;
				case 'Посудомоечные машины':
					//if($id1=='') echo'<title>Посудомоечные машины, купить посудомоечную машину по цене склада</title>'; else echo '<title>'.$viewtitletovar.'</title>';
					if($id1=='') echo'<title>Посудомоечные машины - каталог. Купить посудомоечную машину в интернет-магазине Памира.ру. Цены, отзывы, характеристики, описание, фотографии посудомоечных машин.</title>'; else echo '<title>'.$viewtitletovar.'</title>';
				break;
				case 'Духовые шкафы':
					$viewkeywtovar='Духовой шкаф, '.$viewkeywtovar;	
					echo '<title>Духовой шкаф или '.$viewtitletovar.'</title>';
				break;
				default:
					echo '<title>'.$viewtitletovar.'</title>';
				break;
				}
				
				if($tovar!='')
				{
					 echo '<meta name="description" content="'.$rowtovar['name_rus'].' в магазине Памира" />';
				}else{
					if($rowcatalog['name_rus']=='Варочные поверхности')
					{
						echo '<meta name="description" content="Варочная панель или '.$viewdescwtovar.' в интернет-магазине Памира г. Ростов-на-Дону" />';
					}//else echo '<meta name="description" content="'.$viewdescwtovar.' в интернет-магазине Памира г. Ростов-на-Дону" />';
					if($rowcatalog['name_rus']=='Посудомоечные машины')
					{
						echo '<meta name="description" content="Каталог «Посудомоечные машины» предоставит вам цены, отзывы покупателей, описания, фотографии и подробные технические характеристики посудомоечных машин. В нашем интернет-магазине Памира.ру можно купить посудомоечную машину с доставкой и гарантией." />';
					}
					if($rowcatalog['name_rus']=='Духовые шкафы')
					{
						echo '<meta name="description" content="Духовой шкаф или '.$viewdescwtovar.' в интернет-магазине Памира г. Ростов-на-Дону" />';
					}else echo '<meta name="description" content="'.$viewdescwtovar.' в интернет-магазине Памира г. Ростов-на-Дону" />';
				}
					//if($rowcatalog['name_rus']=='Посудомоечные машины') if($id1=='') echo '<meta name="keywords" content="посудомоечная машина, посудомоечная машина купить, посудомоечная машина куплю" />'; else echo '<meta name="keywords" content="'.$viewkeywtovar.'" />'; else echo '<meta name="keywords" content="'.$viewkeywtovar.'" />';
					if($rowcatalog['name_rus']=='Посудомоечные машины') if($id1=='') echo '<meta name="keywords" content="посудомоечные машины, посудомоечные машины интернет магазин, купить посудомоечные машины, цены на посудомоечные машины, посудомоечные машины цена" />'; else echo '<meta name="keywords" content="'.$viewkeywtovar.'" />'; else echo '<meta name="keywords" content="'.$viewkeywtovar.'" />';
		break;
		case 'article':
				require ($basedir."/sources/article.php");
				if($id=='')
				{	
					echo '<title>Статьи по теме бытовая техника для кухни</title>
					 <meta name="description" content="Статьи от магазина Памира, в помощь выбора техники для кухни" />
					 <meta name="keywords" content=" " />';
				}else{
					echo '<title>'.$rowarticle['name_ru'].'. Статья на сайте интернет-магазина Памира.</title>
					 <meta name="description" content="'.$rowarticle['stroka_descr'].'" />
					 <meta name="keywords" content="'.$rowarticle['stroka_keyw'].'" />';
					$idsert=$rowarticle['textfooter'];
				}
		break;
		default:
				echo '<title>Памира - встраиваемая техника для кухни в Ростове-на-Дону. Дилер Franke (Франке) в Ростове.</title>
					 <meta name="description" content="Памира - магазин, официального дилера Franke в Ростове-на-Дону. Встраиваемая техника для кухни." />
					 <meta name="keywords" content="Памира, Franke, встраиваемая техника, памира, Франке" />';
				/*
				echo '<title>Памира - техника для кухни в Ростове-на-Дону. Интернет-магазин Памира в Ростове.</title>
					 <meta name="description" content="Памира - магазин встроенной техники в Ростове-на-Дону" />
					 <meta name="keywords" content="Памира, памира, интернет-магазин Памира" />';
				*/
	        break;
	}
	?>        
	 <meta http-equiv="Content-type" content="text/html; charset=windows-1251" />
	 <meta name="viewport" content="width=device-width, initial-scale=1">
	 <meta name="robots" content="all" />
	 <meta name='yandex-verification' content='62eb91eee4a401df' />
	<meta name="hash-verification" content="8431d4516ba3ea3af5ec2a59e329507e" />
 <link rel="shortcut icon" href="/favicon.ico">
 
	<!--<script type="text/javascript" src="/js/jquery-1.6.1.min.js"></script> -->
	
	
   	<script type="text/javascript" src="/js/base64.js"></script>
	<script type="text/javascript" src="/js/seohide.js"></script>
	
   <link rel="stylesheet" href="/css/normalize.css">
   <link rel="stylesheet" href="/css/styles.css">
   <script src="/js/vendor/modernizr-2.6.2.min.js"></script>

   <!-- SLIDER REVOLUTION 4.x CSS SETTINGS -->
   <link rel="stylesheet" type="text/css" href="/rslider/css/settings.css" media="screen" />
   
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-26573371-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<link href="/includes/shadowbox-3.0.3/shadowbox.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="/includes/shadowbox-3.0.3/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<!--<script type="text/javascript" charset="utf-8" src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>-->
<script type="text/javascript" charset="utf-8" src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
<script type="text/javascript" src="/js/system.js"></script>

</head>
<?php
	switch($page)
	{
		case 'cart':
			if($_POST['sk']==0) echo '<body onLoad="getcart(\''.$httphost.'\');">';
			if($_POST['sk']==1) echo '<body onLoad="getcart_sk(\''.$httphost.'\');">';
		break;
		/*
		case 'str_designer':
			if($_SESSION['desi']==1)
			{
			echo '<body onLoad="getcartdesign(\''.$httphost.'\');">';
			} else echo '<body onLoad="viewcart(\''.$httphost.'\');">';
		break;
		*/
		default:
			//echo '<body>';
			echo '<body onLoad="viewcart(\''.$httphost.'\');">';
		break;
	}
?>
<!--[if lt IE 7]>
      <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
   <![endif]-->
          
<!--header-->
<?php
require_once $basedir.'/template/_header.php';
?>
<!--/header-->
<?php
//if($page=='123') require_once $basedir.'/sources/razdel_akcii.php';
echo '<noindex>';
require_once $basedir.'/sources/razdel_akcii.php';
echo '</noindex>';
?>           
<!--start main-->  
<div class="content_container">
<!--<div id="slider-range"></div>
<input id="amount1" />
<input id="amount2" />-->
   <table id="wrapper">
   <tr>
       <!--start left_bar-->
       <td id="left_bar">
<?php                
if(($page!='article')and($page!='str_designer'))
{
?>
                <div class="plashka">Каталог товаров</div> 
                
                <div class="boxing">
                 <div class="boxingbleft">
		  <div id="myslidemenu" class="jqueryslidemenu">
<?php
$getcatalog=mysql_query("SELECT * FROM ".$tablesPrefix."catalog");
if(mysql_num_rows($getcatalog)>0)
{
	while($rowcatalog=mysql_fetch_array($getcatalog)){
			echo '<ul>';
			echo '<li><a href="/catalog/'.$rowcatalog['name_lat'].'/" title="'.$rowcatalog['name_rus'].'"';
			if($page=='tovar_po_brandu') echo ' rel="nofollow"';
			echo '>'.$rowcatalog['name_rus'].'</a>';
			$getpodcatalog1=mysql_query("SELECT * FROM ".$tablesPrefix."podcatalog1 WHERE id_cat='".$rowcatalog['id']."'");
			if(mysql_num_rows($getpodcatalog1)>0)
			{
				echo '<ul>';
				while($rowpodcatalog1=mysql_fetch_array($getpodcatalog1)){
					
						echo '<li>';
						echo '<a href="/catalog/'.$rowcatalog['name_lat'].'/'.$rowpodcatalog1['name_lat'].'/"';
						if($page=='tovar_po_brandu') echo ' rel="nofollow"';
						echo '>'.$rowpodcatalog1['name_rus'].'</a>';
						$getpodcatalog2=mysql_query("SELECT * FROM ".$tablesPrefix."podcatalog2 WHERE id_podcat='".$rowpodcatalog1['id']."'");
						if(mysql_num_rows($getpodcatalog2)>0)
						{
							echo '<ul>';
							while($rowpodcatalog2=mysql_fetch_array($getpodcatalog2)){
					
							echo '<li>';
							echo '<a href="/catalog/'.$rowcatalog['name_lat'].'/'.$rowpodcatalog1['name_lat'].'/'.$rowpodcatalog2['name_lat'].'/"';
							if($page=='tovar_po_brandu') echo ' rel="nofollow"';
							echo '>'.$rowpodcatalog2['name_rus'].'</a></li>';
							}
							echo '</ul>';
						}
						echo '</li>';
				}
				echo '</ul>';
			}
			echo '</li>
			</ul>';
	}
}else{
	echo 'Каталог пуст.';
}
?>
		</div>
                  </div>
                </div>


<?php 
/*               
if(($id=='posudomoechnye-mashiny')and($id1==''))
{
	echo '
                <div class="boxing">
                 <div class="boxingbleft" style="font-size:10px;padding-left:4px;padding-right:14px;">';
                 echo '<h4 style="font-size:14px;font-weight:bold;">Как выбрать посудомоечную машину?</h4><span>Посудомоечная машина существенно упрощает жизнь своих владельцев, хотя цены на подобную технику вряд ли можно считать низкими. Но на практике становится очевидным: цель оправдывает средства. На какие технические характеристики, параметры, свойства посудомоечных машин важно обратить внимание при выборе и приобретении? Каковы сильные и слабые стороны разных моделей данных устройств? Об этом читайте в нашей статье. Надеемся, что наш интернет-магазин поможет вам сделать правильный выбор.</span>';
        echo '</div></div>';
}
*/
//if($page=='catalog')
//{
?>
<!--
<div class="plashka">Фильтр</div> 
                
                <div class="boxing">
                 <div class="boxingbfilter">
<div class="filter">
-->
<?php
//require_once $basedir.'/includes/filter1.php';
?>
<!--</div>
</div>
                  </div>
                </div>
                -->
<?php
//}
}
?>            
       </td>
       <!--end left_bar-->
       <!--start content-->
       <td id="content">
       <?php
       if($page!='podbor_tehniki')
       {
       ?>
	<!--poisk-->
	    <div class="poisk">
	    <form name="form2" method="POST" action="/podbor_tehniki/"><input name="" class="butpodteh" value="" type="submit" /></form>
        	 <form name="form1" method="GET" action="/search/">
	             <input name="search" type="text" class="search" value=""/>
	            <input name="" class="buton" value="" type="submit" />    
		</form>                    
	     </div> 
	<!--/poisk-->
	<?php
	} 
	?>
	<?php
	switch($page)
	{
		case 'about':
				require ($basedir."/sources/about.php");
		break;
		case 'contact':
				require ($basedir."/sources/contact.php");
		break;
		case 'akcii':
				require ($basedir."/sources/akcii.php");
		break;
		case 'sale':
				require ($basedir."/sources/sale.php");
		break;
		case 'catalog':
				echo '<div id="contentNEW">';
				//require ($basedir."/sources/catalog.php");
				echo $viewtovar;
				echo '</div>';
		break;
		case 'tovar_po_brandu':
				//require ($basedir."/sources/tovar_po_brandu.php");
				echo $viewtitlebrand;
		break;
		case 'article':
				//require ($basedir."/sources/article.php");
				echo $textechoart;
		break;
		case 'cart':
				require ($basedir."/sources/cart.php");
		break;
		case 'ordermake':
				require ($basedir."/sources/ordermake.php");
		break;
		case 'str_designer':
				require ($basedir."/sources/str_designer.php");
		break;
		case 'search':
				require ($basedir."/sources/search.php");
		break;
				case 'search':
				require ($basedir."/sources/search.php");
		break;
		case 'podbor_tehniki':
				require ($basedir."/sources/podbor_tehniki.php");
		break;
		default:
				/*
				$getbrand=mysql_query("SELECT * FROM ".$tablesPrefix."brand");
				if(mysql_num_rows($getbrand)>0)
				{
					echo '<div align="center">';
					while($rowbrand=mysql_fetch_array($getbrand)){
                          			echo '<img width="90px" src="/imgbrand/'.$rowbrand['img_logo'].'" alt="'.$rowbrand['name'].'" /> ';
					}
					echo '</div>';
				}
				*/
				require ($basedir."/sources/home.php");
	        break;
	}
	require ($basedir."/includes/linkinfo.php");
	?>        
       </td>
       <!--end content-->  
       <!--start right_bar-->
       <td id="right_bar">
             <span id="viewcart"></span>
<?php                
if(($page!='article')and($page!='str_designer'))
{
?>
              <div class="plashka">Наши бренды</div>  
                
               <div class="boxing">
                  <div class="boxingb">
                      <ul class="menu">
<?php
$getbrand=mysql_query("SELECT * FROM ".$tablesPrefix."brand WHERE vis='1' ORDER BY porayd ASC");
if(mysql_num_rows($getbrand)>0)
{
	while($rowbrand=mysql_fetch_array($getbrand)){
                        echo '<li>';
			echo '<a href="/tovar_po_brandu/'.$rowbrand['name_lat'].'/" title=""';
			if($page=='catalog') echo ' rel="nofollow"';
			//echo '>'.$rowbrand['name'].'</a></li>';
			echo '><img width="120px" src="/logobrand/'.strtolower($rowbrand['name']).'.png" style="margin-left:20px;" alt="'.$rowbrand['name'].'" /></a></li>';
	}
}
?>
                      </ul>     
                  </div>
                </div>
<?php
}
?>            
       </td>
       <!--end right_bar-->
   </tr>
   </table> 
   </div>
<!--end main--> 

<?php
require_once $basedir.'/template/_footer.php';
?>
   
   <script>window.jQuery || document.write('<script src="/js/vendor/jquery-1.10.2.min.js"><\/script>')</script>

   <!-- SLIDER REVOLUTION 4.x SCRIPTS  -->
   <script type="text/javascript" src="/rslider/js/jquery.themepunch.plugins.min.js"></script>
   <script type="text/javascript" src="/rslider/js/jquery.themepunch.revolution.min.js"></script>
   <!-- THE SCRIPT INITIALISATION -->
   <script type="text/javascript">
   	setInterval('MyFunction();', 8000);
   	function MyFunction()
	{       
      var revapi;
      jQuery(document).ready(function() {
            revapi = jQuery('.tp-banner').revolution(
            {
               delay:9000,
               startwidth:900,
               startheight:350,
               hideThumbs:10
            });
      });   //ready
      }
   </script>
   <!-- END REVOLUTION SLIDER -->

<script type="text/javascript" src="/js/jfunction.js"></script>

   <script type="text/javascript">
      var frame=0; // номер с которого будет начата ротация 
      var tim; 
      function timers(){ 
          $(".link_image a").eq(frame).trigger("click"); // кликанье по таймеру 
      } 
      $(document).ready(function(){ 
          $(".link_image a").click(function(){ 
              clearTimeout(tim); 
              tim=setTimeout("timers()", 5000); // время ротации 5 сек. 
              var largePath = $(this).attr("href"); // получаем путь до картинки 
              var linkbig = $(this).attr("rel"); // получаем ссылку для картинки 
              var linktext = $(this).attr("title");
              $(".link_image a").removeClass("active"); // устанавливаем стиль для ссылки 
              $(this).toggleClass("active"); 
              frame=$(this).index()+1; 
              if (frame>=document.getElementById('Koll_rotat').value){ // количество картинок в ротации если ровно то начинаем с нуля 
                  frame=0; 
              } 
              $("#rotator_image img").fadeOut("slow", function(){ 
                  $("#rotator_image img").attr({ src: largePath }); 
                  $("#rotator_image a").attr("href", linkbig); 
                  document.getElementById('probalink').innerHTML=linktext; 
                  $("#rotator_image img").fadeIn("slow"); 
              }); 
              return false; 
          }); 
         timers(); // запуск таймера 
      });
   </script>

   <script type="text/javascript" src="/js/vendor/jquery_slidemenu.js"></script>
   <script>
      jqueryslidemenu.buildmenu("myslidemenu", arrowimages, 2)
   </script>
   <script src="/js/login.js"></script>
</body>
</html>
<?php 
} 
$mysqli->close();
print_r($_REQUEST);
?>