[PHP] 급식데이터 API ver 1.1
----------------
### 설명
* 전국 각 시, 도의 교육청 학생서비스 페이지를 파싱하여 오늘의 조식, 중식, 석식 급식 데이터를 가져올수 있습니다.

### 읽어올 수 있는 데이터 범위
* 교육청에 등록되어있는 전국의 모든 공/사립 교육기관.
* 몇몇 학교는 데이터가 등록되어있지 않아 사용하지 못할수도 있습니다.

### 사용방법

데이터는 GET방식으로 받습니다.

| POST/GET |이름|간단 설명|
|--------|--------|--------|
|GET|countryCode|교육청 사이트 주소|
|GET|schulCode|학교 코드|
| GET |insttNm|학교 이름|
|GET|schulCrseScCode|학교 종류|

1. countryCode
해당 지역의 이름입니다.

| 지역 | 코드 |
| --- | --- |
| SEOUL | 서울특별시 |
| INCHEON | 인천광역시 |
| DAEJEON | 대전광역시 |
| DAEGU | 대구광역시 |
| BUSAN | 부산광역시 |
| ULSAN | 울산광역시 |
| GWANGJU | 광주광역시 |
| SEJONG | 세종시 |
| GYEONGG | 경기도 |
| KANGWON | 강원도 |
| JEONBUK | 전라북도 |
| JEONNAM | 전라남도 |
| GYEONGBU | 경상북도 |
| GYEONGNA | 경상남도 |
| CHUNGBU | 충청북도 |
| CHUNGNA | 충청남도 |
| JEJU | 제주도 |

2. schulCode
학교 코드입니다.
교육청 사이트 주소 뒤에 `/spr_ccm_cm01_001.do`를 붙여 학교 코드를 검색하실수 있습니다.

3. insttNm
정확한 학교 이름입니다.

4. schulCrseScCode
유치원 = 1, 초등학교 = 2, 중학교 = 3, 고등학교 = 4

### 출력결과
Json으로 출력됩니다.

~~~javascript
{
"success" : 1,

"countryCode":"hes.goe.go.kr",

"schulCode":"I100000150",

"insttNm":"\uc591\uc9c0\uace0\ub4f1\ud559\uad50",

"schulCrseScCode":"4",

"date":"2015-05-30",

"meal":false
}
~~~

처음으로 만들어보는 API입니다.

그런만큼 표준에서 벗어나는 부분도 많을것이라고 생각됩니다.

그런 부분의 따끔한 지적도 감사히 받도록하겠습니다.

Contact to <dexterastin@gmail.com>.
