<?php
	header("Content-type: application/json; charset=UTF-8");

	require "simple_html_dom.php";

	$countryCode = $_GET['countryCode'];				// 지역 코드
	$schulCode =  $_GET['schulCode'];					// 학교 코드
	$insttNm = $_GET['insttNm']; 						// 학교이름
	//KINDERGARTEN = 1, ELEMENTARY = 2, MIDDLE = 3, HIGH = 4;
	$schulCrseScCode = $_GET['schulCrseScCode'];		//학교 종류 
	$schulKndScCode = "0" . $schulCrseScCode;			// 0.학교종류

	$MENU_URL = "sts_sci_md00_001.do";			 		 //월별식단표
	$firstDate = date('w',strtotime(date("Y-m-")."1")); //월 첫번째요일
	$todayDate = date("d");  							//오늘 일
	$date = $firstDate + $todayDate -1; 				//몇번째칸

	if (!isset($countryCode, $schulCode, $insttNm, $schulCrseScCode)) {
		$array = array(
			'success' => 0,
			'reason' => 'Please check the value'
		);

		echo json_encode($array);
		return;
	}

	switch ($countryCode) {
		case "SEOUL":					//서울특별시
			$hesSiteDomain = "sen";
			break;
		case "INCHEON":					//인천광역시
			$hesSiteDomain = "ice";
			break;
		case "DAEJEON":					//대전광역시
			$hesSiteDomain = "dje";
			break;
		case "DAEGU":					//대구광역시
			$hesSiteDomain = "dge";
			break;
		case "BUSAN":					//부산광역시
			$hesSiteDomain = "pen";
			break;
		case "ULSAN":					//울산광역시
			$hesSiteDomain = "use";
			break;
		case "GWANGJU":					//광주광역시
			$hesSiteDomain = "gen";
			break;
		case "SEJONG":					//세종시
			$hesSiteDomain = "sje";
			break;
		case "GYEONGGI":				//경기도
			$hesSiteDomain = "goe";
			break;
		case "KANGWON":					//강원도
			$hesSiteDomain = "kwe";
			break;
		case "JEONBUK":					//전라북도
			$hesSiteDomain = "jbe";
			break;
		case "JEONNAM":					//전라남도
			$hesSiteDomain = "jne";
			break;
		case "GYEONGBUK":				//경상북도
			$hesSiteDomain = "gbe";
			break;
		case "GYEONGNAM":				//경상남도
			$hesSiteDomain = "gne";
			break;
		case "CHUNGBUK":				//충청북도
			$hesSiteDomain = "cbe";
			break;
		case "CHUNGNAM":				//충청남도
			$hesSiteDomain = "cne";
			break;
		case "JEJU":					//제주도
			$hesSiteDomain = "jje";
			break;
		default:
			$array = array(
				'success' => 0,
				'reason' => 'Pleace check the value of countryCode parameter.'
			);

			echo json_encode($array);
			return;
	}

	$targetURL = "http://hes." . $hesSiteDomain . ".go.kr/" . $MENU_URL . "?schulCode=" . $schulCode . "&insttNm=" . urlencode( $insttNm ) . "&schulCrseScCode=" . $schulCrseScCode . "&schulKndScCode=" . $schulKndScCode;
	$html = file_get_html( $targetURL );
	$replace = array("<td>", "</td>", "<div>", "</div>", "<br />", "()");
	$foodArr = str_replace($replace, "", preg_replace("/[0-9]/", "", $html -> find('td')));
	$replace2 = array("①", "②", "③", "④", "⑤", "⑥", "⑦", "⑧", "⑨", "⑩", "⑪", "⑫", "⑬", "$" , "*");
	$foodArr[ $date ] = str_replace($replace2, "a", $foodArr[ $date ]);

	$str = "aaaaaaaaaaaaaaaaaaa";

	for ($i=0; $i < 19; $i++) { 
		$foodArr[ $date ] = str_replace($str, ", ", $foodArr[ $date ]);
		$str = substr($str, 0, -1);
	}

	$foodArr[ $date ] = str_replace(", <br />", "<br />", str_replace("[", "<br />[", $foodArr[ $date ]));

	if (", " == substr($foodArr[ $date ], -2)) {
		$foodArr[ $date ] = substr($foodArr[ $date ], 0, -2);
	}

	if ("" == $foodArr[ $date ]) {
		$foodArr[ $date ] = "데이터가 존재하지 않습니다.";
	}

	$array = array(
		'success' => 1,
		'countryCode' => $countryCode,
		'schulCode' => $schulCode,
		'insttNm' => $insttNm,
		'schulCrseScCode' => $schulCrseScCode,
		'date' => date("Y-m-d"),
		'meal' => $foodArr[ $date ]
	);

	$json = json_encode($array);

	echo ($json);
?>