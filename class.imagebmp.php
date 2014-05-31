<?php

/** 
 * <b>Handles BMP output</b>
 */

class imagebmp{

    /**
     * creates a Windows BMP picture
     * @see imagegif, imagejpeg ...
     */
    function imagebmp(&$img, $filename=""){
      $widthOrig = imagesx($img);
      // width = 16*x
      $widthFloor = ((floor($widthOrig/16))*16);
      $widthCeil = ((ceil($widthOrig/16))*16);
      $height = imagesy($img);
  
      $size = ($widthCeil*$height*3)+54;
  
      // Bitmap File Header
      $result = 'BM';     // header (2b)
      $result .= imagebmp::int_to_dword($size); // size of file (4b)
      $result .= imagebmp::int_to_dword(0); // reserved (4b)
      $result .= imagebmp::int_to_dword(54);  // byte location in the file which is first byte of IMAGE (4b)
      // Bitmap Info Header
      $result .= imagebmp::int_to_dword(40);  // Size of BITMAPINFOHEADER (4b)
      $result .= imagebmp::int_to_dword($widthCeil);  // width of bitmap (4b)
      $result .= imagebmp::int_to_dword($height); // height of bitmap (4b)
      $result .= imagebmp::int_to_word(1);  // biPlanes = 1 (2b)
      $result .= imagebmp::int_to_word(24); // biBitCount = {1 (mono) or 4 (16 clr ) or 8 (256 clr) or 24 (16 Mil)} (2b)
      $result .= imagebmp::int_to_dword(0); // RLE COMPRESSION (4b)
      $result .= imagebmp::int_to_dword(0); // width x height (4b)
      $result .= imagebmp::int_to_dword(0); // biXPelsPerMeter (4b)
      $result .= imagebmp::int_to_dword(0); // biYPelsPerMeter (4b)
      $result .= imagebmp::int_to_dword(0); // Number of palettes used (4b)
      $result .= imagebmp::int_to_dword(0); // Number of important colour (4b)
      
      // is faster than chr()
      $arrChr = array();
      for($i=0; $i<256; $i++){
        $arrChr[$i] = chr($i);
      }
  
      // creates image data
      $bgfillcolor = array("red"=>0, "green"=>0, "blue"=>0);
  
      // bottom to top - left to right - attention blue green red !!!
      $y=$height-1;
      for ($y2=0; $y2<$height; $y2++) {
        for ($x=0; $x<$widthFloor;  ) {
          $rgb = imagecolorsforindex($img, imagecolorat($img, $x++, $y));
          $result .= $arrChr[$rgb["blue"]].$arrChr[$rgb["green"]].$arrChr[$rgb["red"]];
          $rgb = imagecolorsforindex($img, imagecolorat($img, $x++, $y));
          $result .= $arrChr[$rgb["blue"]].$arrChr[$rgb["green"]].$arrChr[$rgb["red"]];
          $rgb = imagecolorsforindex($img, imagecolorat($img, $x++, $y));
          $result .= $arrChr[$rgb["blue"]].$arrChr[$rgb["green"]].$arrChr[$rgb["red"]];
          $rgb = imagecolorsforindex($img, imagecolorat($img, $x++, $y));
          $result .= $arrChr[$rgb["blue"]].$arrChr[$rgb["green"]].$arrChr[$rgb["red"]];
          $rgb = imagecolorsforindex($img, imagecolorat($img, $x++, $y));
          $result .= $arrChr[$rgb["blue"]].$arrChr[$rgb["green"]].$arrChr[$rgb["red"]];
          $rgb = imagecolorsforindex($img, imagecolorat($img, $x++, $y));
          $result .= $arrChr[$rgb["blue"]].$arrChr[$rgb["green"]].$arrChr[$rgb["red"]];
          $rgb = imagecolorsforindex($img, imagecolorat($img, $x++, $y));
          $result .= $arrChr[$rgb["blue"]].$arrChr[$rgb["green"]].$arrChr[$rgb["red"]];
          $rgb = imagecolorsforindex($img, imagecolorat($img, $x++, $y));
          $result .= $arrChr[$rgb["blue"]].$arrChr[$rgb["green"]].$arrChr[$rgb["red"]];
        }
        for ($x=$widthFloor; $x<$widthCeil; $x++) {
          $rgb = ($x<$widthOrig) ? imagecolorsforindex($img, imagecolorat($img, $x, $y)) : $bgfillcolor;
          $result .= $arrChr[$rgb["blue"]].$arrChr[$rgb["green"]].$arrChr[$rgb["red"]];
        }
        $y--;
      }
      
      // see imagegif
      if($filename==""){
        //echo $result;
        file_put_contents('MyBmpTest.bmp', $result);
      } else {
        $file = fopen($filename, "wb");
        fwrite($file, $result);
        fclose($file);
      }
    }
    // imagebmp helpers
    function int_to_dword($n){
      return chr($n & 255).chr(($n >> 8) & 255).chr(($n >> 16) & 255).chr(($n >> 24) & 255);
    }
    function int_to_word($n){
      return chr($n & 255).chr(($n >> 8) & 255);
    }

    
} // end class imagebmp
?>