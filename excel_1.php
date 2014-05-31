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
$aSheet->setTitle(iconv("Windows-1251", "UTF-8", '«аказ'));

$baseFont = array(
	'font'=>array(
		'name'=>'Arial Cyr',
		'size'=>'9',
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
//номера по пор€дку
//$aSheet->setCellValue('A1','N');
//$aSheet->setCellValue('A2','1');
//$aSheet->setCellValue('A3','2');
//$aSheet->setCellValue('A4','3');
//$aSheet->setCellValue('A5','4');
//устанавливаем ширину
$aSheet->getDefaultColumnDimension()->setWidth(8.6);
$aSheet->getColumnDimension('A')->setWidth(2.5);
$aSheet->getColumnDimension('B')->setWidth(2.9);
$aSheet->getColumnDimension('C')->setWidth(12.3);
$aSheet->getColumnDimension('D')->setWidth(13.5);
$aSheet->getColumnDimension('E')->setWidth(45.7);
$aSheet->getColumnDimension('F')->setWidth(13.6);
$aSheet->getColumnDimension('G')->setWidth(7);

$aSheet->getDefaultRowDimension()->setRowHeight(12.75);
$aSheet->getRowDimension('7')->setRowHeight(27.3);
$aSheet->getRowDimension('8')->setRowHeight(15.25);
$aSheet->getRowDimension('9')->setRowHeight(15.25);
$aSheet->getRowDimension('10')->setRowHeight(14.9);
$aSheet->getRowDimension('13')->setRowHeight(15.25);
$aSheet->getRowDimension('14')->setRowHeight(15.25);
$aSheet->getRowDimension('20')->setRowHeight(17.7);
$aSheet->getRowDimension('21')->setRowHeight(17.7);
$aSheet->getRowDimension('22')->setRowHeight(17.7);
$aSheet->getRowDimension('24')->setRowHeight(9.0);
$aSheet->getRowDimension('27')->setRowHeight(9.8);

//$aSheet->getRowDimension('1')->setRowHeight(36);
//$aSheet->getRowDimension('3')->setRowHeight(30);
//$aSheet->getRowDimension('6')->setRowHeight(30);

$aSheet->mergeCells('A1:G1');
$aSheet->mergeCells('A2:G2');
$aSheet->mergeCells('A3:G3');
$aSheet->mergeCells('A4:G4');
$aSheet->mergeCells('A5:G5');
$aSheet->mergeCells('A6:G6');
$aSheet->mergeCells('A7:G7');
$aSheet->mergeCells('A8:G8');
$aSheet->mergeCells('A9:G9');
$aSheet->mergeCells('A10:G10');
$aSheet->mergeCells('A11:G11');
$aSheet->mergeCells('A12:G12');
$aSheet->mergeCells('A13:G13');
$aSheet->mergeCells('A14:G14');
$aSheet->mergeCells('A15:G15');
$aSheet->mergeCells('B16:G20');
$aSheet->mergeCells('B21:G21');
$aSheet->mergeCells('B22:G22');
$aSheet->mergeCells('B23:G23');

$objDrawing = new PHPExcel_Worksheet_Drawing();
      $objDrawing->setWorksheet($aSheet);
      $objDrawing->setName("name");
      $objDrawing->setDescription("Description");
      $objDrawing->setPath($_SERVER['DOCUMENT_ROOT'].'/images/logo_pamira.png');//'/path_to/image.png');
      $objDrawing->setCoordinates('B1');
      $objDrawing->setOffsetX(0);
      $objDrawing->setOffsetY(5);

$aSheet->getStyle('A1')->applyFromArray($baseFont);

$aSheet->setCellValue('A1',iconv("Windows-1251", "UTF-8", 'ƒата подачи за€вки:                '.date('d.m.Y').'г.'));

//.$_SERVER['DOCUMENT_ROOT']

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