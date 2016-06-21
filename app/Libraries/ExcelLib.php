<?php namespace App\Libraries;

use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Writer_Excel2007;
use PHPExcel_Writer_Excel5;
use PHPExcel_Cell;


class ExcelLib{

  public $uploadsPath; 

  public function __construct(){

	}


    /* unique_data_array function
    *  @key :- multiD column index
    *  @data :- $data array contain xlsx content
    */

  function uniqueDataArray($array, $key) {
      $temp_array = array();
      $i = 0;
      $key_array = array();

      foreach($array as $val) {
          if (!in_array($val[$key], $key_array)) {
              $key_array[$i] = $val[$key];
              $temp_array[$i] = $val;
          }
          $i++;
      }
      return $temp_array;
  }

  /* readExcelUniqueValue function
  *  Read Both Type of XLSX or XLS
  *
  */

 public function readExcelUniqueValue($file,$ky){
 $objPHPExcel = PHPExcel_IOFactory::load($file);
   $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
   foreach ($cell_collection as $cell) {
       $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
       $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
       $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
       $arr_data[$row][$this->toNumber($column)-1] = $data_value;
    }
   //echo "<pre>";  print_r ($this->uniqueDataArray($arr_data,0));
   return ($this->uniqueDataArray($arr_data,$ky));
 }


   /* readExcel function
   *  Read Both Type of XLSX or XLS
   *
   */

  public function readExcel($file){
	$objPHPExcel = PHPExcel_IOFactory::load($file);
    $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
    foreach ($cell_collection as $cell) {
        $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
        //$colNumber = PHPExcel_Cell::columnIndexFromString($colString);
        $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
        $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
        $arr_data[$row][$this->toNumber($column)-1] = $data_value;
   	}

    return ($arr_data);
  }


   /* writeXlsx function
   *  write Both Type of XLSX or XLS
   *
   */
  public function writeExcel($arr_data,$filename){
	$excel = new PHPExcel;
    $list = $excel->setActiveSheetIndex(0);
    $rowcounter = 1;
    foreach($arr_data as $key=>$d){
        $chr = "A";
        foreach($d as $d1){
            $list->setCellValue($chr.$rowcounter,$d1);
            $chr++;
        }
        $rowcounter++;
    }
	if(pathinfo($filename, PATHINFO_EXTENSION) == "xls"){
       $writer = new PHPExcel_Writer_Excel5($excel);
	}else if(pathinfo($filename, PATHINFO_EXTENSION) == "xlsx"){
	   $writer = new PHPExcel_Writer_Excel2007($excel);
	}else{
		echo "File is Neither XLS Nor XLSX ";
	}
    $writer->save($filename);
  }

  /* toNumber function
  *  Convert column Alphabet to Number
  *
  */
  function toNumber($dest)
    {
        if ($dest)
            return ord(strtolower($dest)) - 96;
        else
            return 0;
    }

    /* fileValidate function
    *  return parameter(size,sheetcount,header,rowcount,columncount)
    *
    */
  function fileValidate($path){
      $validate_array = array();
      $excel = new PHPExcel;
      $path =public_path()."/uploads/".$path;
      $objPHPExcel = PHPExcel_IOFactory::load($path);
  		$validate_array['fileSize'] = filesize($path);
      $validate_array['sheetCount'] = $objPHPExcel->getSheetCount();
      for($i=0;$i<$validate_array['sheetCount'];$i++){
            $activeSheet = $objPHPExcel->setActiveSheetIndex($i); // set active sheet

            $validate_array['sheetRow'][$i] = $activeSheet->getHighestRow();
            $validate_array['sheetColumn'][$i] = $activeSheet->getHighestColumn();
            $validate_array['sheetDimension'][$i] = $activeSheet->calculateWorksheetDimension();
            $validate_array['sheetTitle'][$i] = $activeSheet->getTitle();

            $cell_collection = $activeSheet->getCellCollection();
            $arr_data = array();
            foreach ($cell_collection as $key=>$cell) {
                $column = $activeSheet->getCell($cell)->getColumn();
                $colNumber = PHPExcel_Cell::columnIndexFromString($column);
                $row = $activeSheet->getCell($cell)->getRow();
                if($row == 6)
                  break;
                $data_value = $activeSheet->getCell($cell)->getValue();
                $arr_data[$row][$colNumber] = $data_value;
                //$validate_array['sheetdata'][$i] = $arr_data;
           	}
          $validate_array['sheetData'][$i] = $arr_data;
      }
      //echo "<pre>"; echo json_encode($validate_array,JSON_PRETTY_PRINT); exit;
      //echo "<pre>"; print_r ($validate_array); exit;
      return $validate_array;
  }

}
?>
