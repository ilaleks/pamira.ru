<?php
session_start();
$basedir = isset($_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT'] : '';

require_once $basedir.'/includes/config.php';
require_once $basedir.'/includes/dbconnect.php';
require_once $basedir.'/includes/propis.php';

	if($_SESSION['desi']==1)
	{
		$getnac=mysql_query("SELECT * FROM ".$tablesPrefix."margin WHERE nac_default='1' AND id_members='".$_SESSION['id_desi']."' LIMIT 1");
		if(mysql_num_rows($getnac)>0)
		{
			$rownac=mysql_fetch_array($getnac);
			$whovidnac=$rownac['nackopt'];
			$getnacproc=mysql_query("SELECT * FROM ".$tablesPrefix."marginitems WHERE id_margin='".$rownac['id']."'");
			while($rownacproc=mysql_fetch_array($getnacproc))
			{
				$mass_brand[$rownacproc['id_brand']]=$rownacproc['p_nac'];
				//var_dump($mass_brand);
			}
		}else {
			for($i=1;$i<=100;$i++)
			{
				$mass_brand[$i]=0;
			}
		}
	}

set_include_path(get_include_path() . PATH_SEPARATOR .
'PhpExcel/Classes/');
//подключаем и создаем класс PHPExcel
include_once 'PHPExcel.php';
$pExcel = new PHPExcel();
$pExcel->setActiveSheetIndex(0);
$aSheet = $pExcel->getActiveSheet();
$aSheet->setTitle(iconv("Windows-1251", "UTF-8", 'Заказ'));

$baseFont = array(
	'font'=>array(
		'name'=>'Arial Cyr',
		'size'=>'9',
		'bold'=>false
	)
);
$base8Font = array(
	'font'=>array(
		'name'=>'Arial Cyr',
		'size'=>'8',
		'bold'=>false
	)
);
$bold9Font = array(
	'font'=>array(
		'name'=>'Arial Cyr',
		'size'=>'9',
		'bold'=>true
	)
);
$bold10Font = array(
	'font'=>array(
		'name'=>'Arial Cyr',
		'size'=>'10',
		'bold'=>true
	),
	'alignment'=>array(
		'horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		'vertical'=>PHPExcel_Style_Alignment::VERTICAL_CENTER
	)
);
$bold10Fontnocenter = array(
	'font'=>array(
		'name'=>'Arial Cyr',
		'size'=>'10',
		'bold'=>true
	)
);
$boldFont = array(
	'font'=>array(
		'name'=>'Arial Cyr',
		'size'=>'14',
		'bold'=>true
	)
);
//и позиционирование
$center = array(
	'alignment'=>array(
		'horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		'vertical'=>PHPExcel_Style_Alignment::VERTICAL_CENTER
	)
);
$left = array(
	'alignment'=>array(
		'horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
		'vertical'=>PHPExcel_Style_Alignment::VERTICAL_CENTER
	)
);
$right = array(
	'alignment'=>array(
		'horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
		'vertical'=>PHPExcel_Style_Alignment::VERTICAL_CENTER
	)
);	
$borders = array(
	'bottom' => array(
		'style' => PHPExcel_Style_Border::BORDER_THIN
	)
);


//устанавливаем данные
//номера по порядку
//$aSheet->setCellValue('A1','N');
//$aSheet->setCellValue('A2','1');
//$aSheet->setCellValue('A3','2');
//$aSheet->setCellValue('A4','3');
//$aSheet->setCellValue('A5','4');
//устанавливаем ширину
$aSheet->getDefaultColumnDimension()->setWidth(3);
$aSheet->getColumnDimension('A')->setWidth(1);
$aSheet->getColumnDimension('AI')->setWidth(1);
$aSheet->getRowDimension('1')->setRowHeight(36);
$aSheet->getRowDimension('3')->setRowHeight(30);
$aSheet->getRowDimension('6')->setRowHeight(30);
$aSheet->mergeCells('B1:AH1');
$aSheet->mergeCells('B3:G3');
$aSheet->mergeCells('H3:AL3');
$aSheet->mergeCells('B6:C6');
$aSheet->mergeCells('D6:G6');
$aSheet->mergeCells('H6:O6');
$aSheet->mergeCells('P6:R6');
$aSheet->mergeCells('S6:T6');
$aSheet->mergeCells('U6:X6');
$aSheet->mergeCells('Y6:AC6');
$aSheet->mergeCells('AD6:AH6');

$aSheet->getStyle('B1')->applyFromArray($boldFont);
$aSheet->getStyle('B1')->applyFromArray($center);
$aSheet->getStyle('B1:AH1')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
$aSheet->setCellValue('B1',iconv("Windows-1251", "UTF-8", 'Заказ техники'));
$aSheet->getStyle('B3')->applyFromArray($center);
$aSheet->getStyle('B3')->applyFromArray($baseFont);
if($_SESSION['desi']==1)
{
$aSheet->setCellValue('B3',iconv("Windows-1251", "UTF-8", 'Поставщик1:'));
} else {
$aSheet->setCellValue('B3',iconv("Windows-1251", "UTF-8", 'Поставщик2:').':'.$_SESSION['desi']);
}
$aSheet->getStyle('H3')->applyFromArray($bold9Font);
$aSheet->getStyle('H3')->getAlignment()->setWrapText(true);
$aSheet->setCellValue('H3',iconv("Windows-1251", "UTF-8", 'Индивидуальный предприниматель Баженов Дмитрий Николаевич, ИНН 616600808386,                                    344029, Ростовская обл, Ростов-на-Дону г, Алексея Береста ул, дом № 9, тел.: 300-52-99'));

$aSheet->getStyle('B6:C6')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
$aSheet->getStyle('B6:C6')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
$aSheet->getStyle('B6:C6')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$aSheet->getStyle('D6:G6')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
$aSheet->getStyle('D6:G6')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$aSheet->getStyle('H6:O6')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
$aSheet->getStyle('H6:O6')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$aSheet->getStyle('P6:R6')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
$aSheet->getStyle('P6:R6')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$aSheet->getStyle('S6:T6')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
$aSheet->getStyle('S6:T6')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$aSheet->getStyle('U6:X6')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
$aSheet->getStyle('U6:X6')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$aSheet->getStyle('Y6:AC6')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
$aSheet->getStyle('Y6:AC6')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$aSheet->getStyle('AD6:AH6')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
$aSheet->getStyle('AD6:AH6')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);

$aSheet->getStyle('B6:AH6')->applyFromArray($bold10Font);
$aSheet->setCellValue('B6',iconv("Windows-1251", "UTF-8", '№'));
$aSheet->setCellValue('D6',iconv("Windows-1251", "UTF-8", 'Артикул'));
$aSheet->setCellValue('H6',iconv("Windows-1251", "UTF-8", 'Товары'));
$aSheet->setCellValue('P6',iconv("Windows-1251", "UTF-8", 'Кол-во'));
$aSheet->setCellValue('S6',iconv("Windows-1251", "UTF-8", 'Ед.'));
$aSheet->setCellValue('U6',iconv("Windows-1251", "UTF-8", 'Цена'));
$aSheet->getStyle('Y6')->getAlignment()->setWrapText(true);
$aSheet->setCellValue('Y6',iconv("Windows-1251", "UTF-8", 'Сумма без скидки'));
$aSheet->setCellValue('AD6',iconv("Windows-1251", "UTF-8", 'Сумма'));

$j=7;
//начало товар
if($_GET['idzakaz']!='')
{
	$getszakaz=mysql_query("SELECT * FROM ".$tablesPrefix."skzakaz WHERE id_zakaz='".$_GET['idzakaz']."'");	
	while($rowszakaz=mysql_fetch_array($getszakaz))
	{
		$ids=$rowszakaz['id_tovar'];
		$m[all][$ids]=$ids;
		$m[$ids][kol]=$rowszakaz['koll_tovar'];
		$k=@array_keys($m[all]);

	}
} else {
	//session_start();
	$k=@array_keys($t[all]);
}

$summallcost=0;
$tovarallkol=0;
for ($i=0; $i<count($k); $i++) {
$l=$i+1;
if($_GET['idzakaz']!='')
{
	$idtovar=$k[$i];
	$tovarkol=$m[$k[$i]][kol];
} else {
	$idtovar=$k[$i];
	$tovarkol=$t[$k[$i]][kol];
}
$gettovar=mysql_query("SELECT * FROM ".$tablesPrefix."tovar WHERE id='".$idtovar."' LIMIT 1");
$rowtovar=mysql_fetch_array($gettovar);
if($_SESSION['desi']==1)
{
	if($whovidnac==1)
	{
		$cost=$rowtovar['cost'];
	} else {
		$cost=$rowtovar['cost_opt'];
	}
	$cost=$cost+($cost*$mass_brand[$rowtovar['id_brand']])/100;
        
        $summcost=$tovarkol*$cost;
        $summcost=$summcost-($summcost*$tovarsk/100);
        $summcost=sprintf("%.2f",$summcost);
        
	//$summcost=sprintf("%.2f",$tovarkol*$cost);
} else $summcost=sprintf("%.2f",$tovarkol*$rowtovar['cost']);
//if($_SESSION['desi']==1) $summcost=sprintf("%.2f",$tovarkol*$rowtovar['cost_opt']); else $summcost=sprintf("%.2f",$tovarkol*$rowtovar['cost']);
$tovarallkol=$tovarallkol+$tovarkol;
$summallcost=sprintf("%.2f",$summallcost+$summcost);

$aSheet->getRowDimension($j)->setRowHeight(30);
if($_SESSION['desi']==1)
{
$aSheet->setCellValue('AK'.$j,iconv("Windows-1251", "UTF-8", number_format('123',2,","," ")));
$aSheet->setCellValue('AL'.$j,iconv("Windows-1251", "UTF-8", print_r($_SESSION, true)));
}
$aSheet->mergeCells('B'.$j.':C'.$j);
$aSheet->mergeCells('D'.$j.':G'.$j);
$aSheet->mergeCells('H'.$j.':O'.$j);
$aSheet->mergeCells('P'.$j.':R'.$j);
$aSheet->mergeCells('S'.$j.':T'.$j);
$aSheet->mergeCells('U'.$j.':X'.$j);
$aSheet->mergeCells('Y'.$j.':AC'.$j);
$aSheet->mergeCells('AD'.$j.':AH'.$j);
$aSheet->getStyle('B'.$j.':C'.$j)->applyFromArray($center);
$aSheet->getStyle('D'.$j.':G'.$j)->applyFromArray($center);
$aSheet->getStyle('H'.$j.':O'.$j)->applyFromArray($left);
$aSheet->getStyle('P'.$j.':R'.$j)->applyFromArray($right);
$aSheet->getStyle('S'.$j.':T'.$j)->applyFromArray($center);
$aSheet->getStyle('U'.$j.':X'.$j)->applyFromArray($right);
$aSheet->getStyle('Y'.$j.':AC'.$j)->applyFromArray($right);
$aSheet->getStyle('AD'.$j.':AH'.$j)->applyFromArray($right);

$aSheet->getStyle('B'.$j.':C'.$j)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
$aSheet->getStyle('B'.$j.':C'.$j)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$aSheet->getStyle('B'.$j.':C'.$j)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$aSheet->getStyle('D'.$j.':G'.$j)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$aSheet->getStyle('D'.$j.':G'.$j)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$aSheet->getStyle('H'.$j.':O'.$j)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$aSheet->getStyle('H'.$j.':O'.$j)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$aSheet->getStyle('P'.$j.':R'.$j)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$aSheet->getStyle('P'.$j.':R'.$j)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$aSheet->getStyle('S'.$j.':T'.$j)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$aSheet->getStyle('S'.$j.':T'.$j)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$aSheet->getStyle('U'.$j.':X'.$j)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$aSheet->getStyle('U'.$j.':X'.$j)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$aSheet->getStyle('Y'.$j.':AC'.$j)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$aSheet->getStyle('Y'.$j.':AC'.$j)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$aSheet->getStyle('AD'.$j.':AH'.$j)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$aSheet->getStyle('AD'.$j.':AH'.$j)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);

$aSheet->getStyle('B'.$j.':AH'.$j)->applyFromArray($base8Font);
$aSheet->setCellValue('B'.$j,iconv("Windows-1251", "UTF-8", $l));
$aSheet->setCellValue('D'.$j,iconv("Windows-1251", "UTF-8", ''));
$aSheet->getStyle('H'.$j)->getAlignment()->setWrapText(true);
$aSheet->setCellValue('H'.$j,iconv("Windows-1251", "UTF-8", $rowtovar['name_rus']));
$aSheet->setCellValue('P'.$j,iconv("Windows-1251", "UTF-8", $tovarkol));
$aSheet->setCellValue('S'.$j,iconv("Windows-1251", "UTF-8", 'шт.'));
$aSheet->setCellValue('U'.$j,iconv("Windows-1251", "UTF-8", number_format($cost,2,","," ")));
$aSheet->setCellValue('Y'.$j,iconv("Windows-1251", "UTF-8", number_format($summcost,2,","," ")));
$aSheet->setCellValue('AD'.$j,iconv("Windows-1251", "UTF-8", number_format($summcost,2,","," ")));
$j++;
}
//конец товар
$aSheet->getStyle('B'.$j.':AH'.$j)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
$aSheet->getRowDimension($j)->setRowHeight(4);
$j++;
$aSheet->getStyle('B'.$j.':AH'.$j)->applyFromArray($bold10Fontnocenter);
$aSheet->mergeCells('S'.$j.':X'.$j);
$aSheet->mergeCells('Y'.$j.':AC'.$j);
$aSheet->mergeCells('AD'.$j.':AH'.$j);
$aSheet->getStyle('S'.$j.':X'.$j)->applyFromArray($right);
$aSheet->getStyle('Y'.$j.':AC'.$j)->applyFromArray($right);
$aSheet->getStyle('AD'.$j.':AH'.$j)->applyFromArray($right);
$aSheet->setCellValue('S'.$j,iconv("Windows-1251", "UTF-8", 'Итого:'));
$aSheet->setCellValue('Y'.$j,iconv("Windows-1251", "UTF-8", number_format($summallcost,2,","," ")));
$aSheet->setCellValue('AD'.$j,iconv("Windows-1251", "UTF-8", number_format($summallcost,2,","," ")));
$j++;
$aSheet->getStyle('B'.$j.':AH'.$j)->applyFromArray($bold10Fontnocenter);
$aSheet->mergeCells('S'.$j.':X'.$j);
$aSheet->getStyle('S'.$j.':X'.$j)->applyFromArray($right);
$aSheet->setCellValue('S'.$j,iconv("Windows-1251", "UTF-8", 'В том числе НДС:'));
$j++;
$aSheet->getStyle('B'.$j.':AH'.$j)->applyFromArray($bold10Fontnocenter);
$aSheet->mergeCells('S'.$j.':X'.$j);
$aSheet->mergeCells('AD'.$j.':AH'.$j);
$aSheet->getStyle('S'.$j.':X'.$j)->applyFromArray($right);
$aSheet->getStyle('AD'.$j.':AH'.$j)->applyFromArray($right);
$aSheet->setCellValue('S'.$j,iconv("Windows-1251", "UTF-8", 'Всего к оплате:'));
$aSheet->setCellValue('AD'.$j,iconv("Windows-1251", "UTF-8", number_format($summallcost,2,","," ")));
$j++;
$aSheet->mergeCells('B'.$j.':AH'.$j);
$aSheet->setCellValue('B'.$j,iconv("Windows-1251", "UTF-8", 'Всего наименований '.count($k).', на сумму '.number_format($summallcost,2,","," ").' руб'));
$j++;
$aSheet->mergeCells('B'.$j.':AC'.$j);
$aSheet->getStyle('B'.$j.':AH'.$j)->applyFromArray($bold10Fontnocenter);
$aSheet->setCellValue('B'.$j,iconv("Windows-1251", "UTF-8", num_propis(number_format($summallcost,0,".","")).' рублей 00 копеек'));
$aSheet->mergeCells('AD'.$j.':AH'.$j);
$aSheet->getStyle('AD'.$j.':AH'.$j)->applyFromArray($right);
$aSheet->setCellValue('AD'.$j,iconv("Windows-1251", "UTF-8", 'Без НДС'));
$j++;
$aSheet->mergeCells('B'.$j.':AH'.$j);
$aSheet->getStyle('B'.$j.':AH'.$j)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
$aSheet->getRowDimension($j)->setRowHeight(4);
$j++;
$aSheet->getRowDimension($j)->setRowHeight(4);

/*
$pExcel->createSheet();
$pExcel->setActiveSheetIndex(1);
$aSheet1 = $pExcel->getActiveSheet();
$aSheet1->setTitle(iconv("Windows-1251", "UTF-8", 'Товар'));
$j=0; 
$flg=0;
for ($i=0; $i<count($k); $i++) {
$iDrowing = new PHPExcel_Worksheet_Drawing();
if($flg==0)
{
$n=$i+$j+1;
$m=$i+$j+2;
}
$idtovar=$k[$i];
$gettovar=mysql_query("SELECT * FROM ".$tablesPrefix."tovar WHERE id='".$idtovar."' LIMIT 1");
$rowtovar=mysql_fetch_array($gettovar);
if($flg==0)
{
	$aSheet1->setCellValue('A'.$n,iconv("Windows-1251", "UTF-8", $rowtovar['name_rus']));
	$iDrowing->setPath('imgtovar/'.$rowtovar['img']); 
	$iDrowing->setCoordinates('A'.$m); 
	$iDrowing->setResizeProportional(true); 
	$flg=1;
} else {
	$aSheet1->setCellValue('H'.$n,iconv("Windows-1251", "UTF-8", $rowtovar['name_rus']));
	$iDrowing->setPath('imgtovar/'.$rowtovar['img']); 
	$iDrowing->setCoordinates('H'.$m); 
	$iDrowing->setResizeProportional(true); 
	$flg=0;
}
$iDrowing->setHeight(200); 
$iDrowing->setWorksheet($pExcel->getActiveSheet());
if($flg==0) $j=$j+11;
}

$pExcel->setActiveSheetIndex(0);
$aSheet = $pExcel->getActiveSheet();
*/

if($_GET['idzakaz']!='')
{
	$namefile='Zakaz_N'.$_GET['idzakaz'].'_ot_'.date('d_m_Y').'.xls';
} else $namefile='Zakaz_new.xls';
//отдаем пользователю в браузер
include("PHPExcel/Writer/Excel5.php");
$objWriter = new PHPExcel_Writer_Excel5($pExcel);
header('Content-Type: application/x-msexcel');
header('Content-Disposition: inline;filename="'.$namefile.'"');
header('Cache-Control: max-age=0');
$objWriter->save('php://output');
?>