<?  
error_reporting(E_ALL);
session_start();
$basedir = isset($_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT'] : '';

require_once $basedir.'/includes/config.php';
require_once $basedir.'/includes/dbconnect.php';

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

require_once $basedir.'/admin/fpdf/fpdf.php';

// Начало конфигурации
$textColour = array( 0, 0, 0 );
$headerColour = array( 100, 100, 100 );
$tableHeaderTopTextColour = array( 255, 255, 255 );
$tableHeaderTopFillColour = array( 125, 152, 179 );
$tableHeaderTopProductTextColour = array( 0, 0, 0 );
$tableHeaderTopProductFillColour = array( 143, 173, 204 );
$tableHeaderLeftTextColour = array( 99, 42, 57 );
$tableHeaderLeftFillColour = array( 184, 207, 229 );
$tableBorderColour = array( 50, 50, 50 );
$tableRowFillColour = array( 213, 170, 170 );
$reportName = "2009 Widget Sales Report";
$reportNameYPos = 90;
$logoFile = "widget-company-logo.png";
$logoXPos =50;
$logoYPos = 50;
$logoWidth = 90;
$columnLabels = array( "Q1", "Q2", "Q3", "Q4" );
$rowLabels = array( "SupaWidget", "WonderWidget", "MegaWidget", "HyperWidget" );
$chartXPos = 20;
$chartYPos = 250;
$chartWidth = 160;
$chartHeight = 200;
$chartXLabel = "Product";
$chartYLabel = "2009 Sales";
$chartYStep = 20000;
$chartColours = array(
                  array( 255, 100, 100 ),
                  array( 100, 255, 100 ),
                  array( 100, 100, 255 ),
                  array( 255, 255, 100 ),
                );
$data = array(
          array( 9940, 10100, 9490, 11730 ),
          array( 19310, 21140, 20560, 22590 ),
          array( 25110, 26260, 25210, 28370 ),
          array( 27650, 24550, 30040, 31980 ),
        );
// Конец конфигурации

$pdf = new FPDF( 'P', 'mm', 'A4' );
$pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );
$pdf->AddPage();

$pdf->AddFont('ArialMT','B','verdana.php');

/*
$pdf->AddFont('ArialMT','B','verdana.php');
$pdf->SetFont('ArialMT','B',18); 
$pdf->Cell(102, 10, 'Проба', 0, 0, 'L' );
$pdf->Cell(102, 10, 'Проба1', 0, 0, 'L' );
$pdf->Ln();
$pdf->SetFont('ArialMT','B',14);
$pdf->Cell(102, 6, '8 200 руб.', 0, 0, 'L' );
$pdf->Cell(102, 6, '8 200 руб.', 0, 0, 'L' );
$pdf->Ln();
$pdf->Image('imgtovar/20120718010421.jpeg', $logoXPos, 28, $logoWidth );
$pdf->Image('imgtovar/20120718010421.jpeg', 110, 28, $logoWidth );

$pdf->Ln(100);

$pdf->AddFont('ArialMT','B','verdana.php');
$pdf->SetFont('ArialMT','B',18); 
$pdf->Cell(102, 10, 'Проба', 0, 0, 'L' );
$pdf->Cell(102, 10, 'Проба1', 0, 0, 'L' );
$pdf->Ln();
$pdf->SetFont('ArialMT','B',14);
$pdf->Cell(102, 6, '8 200 руб.', 0, 0, 'L' );
$pdf->Cell(102, 6, '8 200 руб.', 0, 0, 'L' );
$pdf->Ln();
$pdf->Image('imgtovar/20120718010421.jpeg', $logoXPos, 144, $logoWidth );
$pdf->Image('imgtovar/20120718010421.jpeg', 110, 144, $logoWidth );
*/
/*
$pdf->SetXY(10,10);
$pdf->SetFont('ArialMT','B',18); 
$pdf->Write(10,'Проба');
$pdf->SetXY(10,20);
$pdf->SetFont('ArialMT','B',14);
$pdf->Write(6,'8 200 руб.');
$pdf->Image('imgtovar/20120718010421.jpeg', $logoXPos, 28, $logoWidth );

$pdf->SetXY(112,10);
$pdf->SetFont('ArialMT','B',18); 
$pdf->Write(10,'Проба1');
$pdf->SetXY(112,20);
$pdf->SetFont('ArialMT','B',14);
$pdf->Write(6,'8 300 руб.');
$pdf->Image('imgtovar/20120718010421.jpeg', 110, 28, $logoWidth );

$pdf->SetXY(10,130);
$pdf->SetFont('ArialMT','B',18); 
$pdf->Write(10,'Проба');
$pdf->SetXY(10,140);
$pdf->SetFont('ArialMT','B',14);
$pdf->Write(6,'8 200 руб.');
$pdf->Image('imgtovar/20120718010421.jpeg', $logoXPos, 148, $logoWidth );

$pdf->SetXY(112,130);
$pdf->SetFont('ArialMT','B',18); 
$pdf->Write(10,'Проба1');
$pdf->SetXY(112,140);
$pdf->SetFont('ArialMT','B',14);
$pdf->Write(6,'8 300 руб.');
$pdf->Image('imgtovar/20120718010421.jpeg', 110, 148, $logoWidth );


$pdf->AddPage();
*/
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
	$k=@array_keys($t[all]);
}

$j=1; 
$flg=0;
for($i=0; $i<count($k); $i++)
{
	$idtovar=$k[$i];
	$gettovar=mysql_query("SELECT * FROM ".$tablesPrefix."tovar WHERE id='".$idtovar."' LIMIT 1");
	$rowtovar=mysql_fetch_array($gettovar);
	//$pdf->SetXY(10,10);
	switch($j)
	{
		case 1:
			$pdf->SetXY(30,10);
		break;
		case 2:
			//$pdf->SetXY(112,10);
			$pdf->SetXY(30,130);
		break;
		case 3:
			//$pdf->SetXY(10,130);
			$pdf->SetXY(30,250);
		break;
		case 4:
			//$pdf->SetXY(112,130);
			$pdf->SetXY(30,370);
		break;
	}
	$pdf->SetFont('ArialMT','B',14); 
	$pdf->Write(10,$rowtovar['name_rus']);
	//$pdf->SetXY(10,20);
	switch($j)
	{
		case 1:
			$pdf->SetXY(40,20);
		break;
		case 2:
			//$pdf->SetXY(112,20);
			$pdf->SetXY(40,140);
		break;
		case 3:
			//$pdf->SetXY(10,140);
			$pdf->SetXY(40,260);
		break;
		case 4:
			//$pdf->SetXY(112,140);
			$pdf->SetXY(40,380);
		break;
	}
	if($_SESSION['desi']==1)
	{
		if($whovidnac==1)
		{
			$cost=$rowtovar['cost'];
		} else {
			$cost=$rowtovar['cost_opt'];
		}
		$cost=$cost+($cost*$mass_brand[$rowtovar['id_brand']])/100;
	} else $cost=$rowtovar['cost'];
	$pdf->SetFont('ArialMT','B',11);
	$pdf->Write(6,'Стоимость: '.number_format($cost,0,"."," ").' руб.');
	//$pdf->Image('imgtovar/'.$rowtovar['img'], $logoXPos, 28, $logoWidth );
	switch($j)
	{
		case 1:
			$pdf->Image('imgtovar/'.$rowtovar['img'], $logoXPos, 28);
		break;
		case 2:
			//$pdf->Image('imgtovar/'.$rowtovar['img'], 110, 28, $logoWidth );
			$pdf->Image('imgtovar/'.$rowtovar['img'], $logoXPos, 148);
		break;
		case 3:
			//$pdf->Image('imgtovar/'.$rowtovar['img'], $logoXPos, 148, $logoWidth );
			$pdf->Image('imgtovar/'.$rowtovar['img'], $logoXPos, 268);
		break;
		case 4:
			//$pdf->Image('imgtovar/'.$rowtovar['img'], 110, 28, $logoWidth );
			$pdf->Image('imgtovar/'.$rowtovar['img'], $logoXPos, 388);
		break;
	}
	$j++;
	if(($j==3)OR($j==6)OR($j==9)OR($j==12)OR($j==15)OR($j==18)OR($j==21)OR($j==24)OR($j==27)OR($j==30)OR($j==33)OR($j==36)OR($j==39)OR($j==42)OR($j==45)OR($j==48)OR($j==51)OR($j==54)OR($j==57)OR($j==60))
	{
		$pdf->AddPage();
		$j=1;
	}
}

if($_GET['idzakaz']!='')
{
	$namefile='Spisok_k_zakazu_N'.$_GET['idzakaz'].'_ot_'.date('d_m_Y').'.pdf';
} else $namefile='Spisok_k_zakazu_new.pdf';
$pdf->Output($namefile, "D");

?>