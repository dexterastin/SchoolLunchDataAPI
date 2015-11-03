<?php
//20150930
header("Content-type: application/json; charset=UTF-8");

require "simple_html_dom.php";

$countryCode = $_GET['countryCode'];            // 교육청 사이트
$schulCode =  $_GET['schulCode'];             // 학교 코드
$insttNm = $_GET['insttNm'];        // 학교이름
//KINDERGARTEN = 1, ELEMENTARY = 2, MIDDLE = 3, HIGH = 4;
$schulCrseScCode = $_GET['schulCrseScCode'];        //학교 종류 
$schulKndScCode = "0" . $schulCrseScCode;     // 0.학교종류

/*
echo "countryCode : " . $countryCode;
echo "schulCode : " . $schulCode;
echo "insttNm : " . $insttNm;
echo "schulCrseScCode : " . $schulCrseScCode;
*/

$MENU_URL = "sts_sci_md00_001.do";  //월별식단표
$firstDate = date('w',strtotime(date("Y-m-")."1")); //월 첫번째요일
$todayDate = date("d");  //오늘 일
//$todayDate = 28;
$date = $firstDate + $todayDate -1; //몇번째칸

$targetURL = "http://" . $countryCode . "/" . $MENU_URL . "?schulCode=" . $schulCode . "&insttNm=" . urlencode( $insttNm ) . "&schulCrseScCode=" . $schulCrseScCode . "&schulKndScCode=" . $schulKndScCode;

// echo $targetURL;

$html = file_get_html( $targetURL );
$replace = array("<td>", "</td>", "<div>", "</div>", "<br />", "()");

$foodArr = str_replace($replace, "a", preg_replace("/[0-9]/", "", $html -> find('td')));

$replace2 = array("①", "②", "③", "④", "⑤", "⑥", "⑦", "⑧", "⑨", "⑩", "⑪", "⑫", "⑬", "$" , "*", "/", "&", ";", "=", ",", ">", "<", "\"", ", ");

$str1 = "aaaaaaaaaaaaaaaaaaaaaaaaaa";
$str = $str1;
$len = strlen($str);

foreach ($foodArr as &$value) {

  $value = str_replace($replace2, "a", $value);
  $value = preg_replace("/[a-zA-Z]/", "a", $value);

  for ($i=0; $i < $len; $i++) { 
    $value = str_replace($str, ", ", $value);
    $str = substr($str, 0, -1);
  }

  $str = $str1;

  if (substr($value, -2)==", ") {
    $value = substr($value, 0, -2);
  }

  $value = str_replace(", [", "[", $value);

  $value = str_replace("[", "<br />[", $value);

  $value = str_replace("],", "]", $value);

  if ($value=="" || strpos("<br />[", $value) || $value==",  " || $value==",  ,  ") {
    $value = "<br />데이터가 존재하지 않습니다.";
  }
}

// echo $foodArr[$date];

$array = array(
  'countryCode' => $countryCode,
  'schulCode' => $schulCode,
  'insttNm' => $insttNm,
  'schulCrseScCode' => $schulCrseScCode,
  'date' => date("Y-m-").$todayDate,
  'meal' => $foodArr[$date]
  );

$json = json_encode($array);

echo $json;

?>