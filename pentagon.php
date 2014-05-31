<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

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

$mysqli->close();
