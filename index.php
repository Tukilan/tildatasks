<?php
	error_reporting(E_ALL);
    ini_set('display_errors',false);

    // Массив телефонов , распределенный по городам
    $phones = [
    	'москва' => '8-800-495-49-54',
    	'краснодар' => '8-800-495-44-44inde',
    	'def' => '8-800-000-00-00',
    ];
    $request = file_get_contents("http://api.sypexgeo.net/json/".$_SERVER['REMOTE_ADDR']); 
	$array = json_decode($request);
	$city =  $array->city->name_ru;
	if ($phones[strtolower($city)]){
		$currphone = $phones[strtolower($city)];
	} else {
		$currphone = $phones['def'];
	}


	function task1(int $start = 1,int $end = 100){
		if ($start > $end){
			echo 'Стартовая цифра больше чем конечная'; 
			return 0;
		}
		$limitrow = 1; // Лимит цифр на строке
		$currlimit = 0; // Текущая позиция на строке
		for ($i=$start; $i <= $end ; $i++) { 
			echo $i.'&nbsp&nbsp&nbsp';
			$currlimit++;
			if ($currlimit == $limitrow){
				echo '<br>';
				$limitrow++;
				$currlimit = 0;
			}
		}	
	}
	


	function task2(int $rows = 7,int $cols = 5){
		$arr = genArr($rows,$cols);
		
		PrintData($arr,SumArray($arr));

	}

	function PrintData(array $arr,array $sumall){
		
		foreach ($arr as $k => $v) {
			echo '<div style="display:flex;">';
			foreach ($v as $kk => $vv) {
				echo '<div style="text-align:center;    width: 50px;">'.$vv.'</div>';
			}
			echo '('.$sumall['sumrow'][$k].')';
			echo '</div>';
		}
		echo '<div style="display:flex;">';
		foreach ($sumall['sumcol'] as $k => $v) {
			echo '<div style="text-align:center;    width: 50px;">('.$v.')</div>';
		}
		echo '</div>';

	}

	function SumArray(array $arr):array{
		$sumrow = [];
		$sumcol = [];
		foreach ($arr as $k => $v) {
			$sumrow[$k] = array_sum($v);
			foreach ($v as $kk => $vv) {
				$sumcol[$kk]+= $vv;
			}
		}
		return ['sumcol'=>$sumcol,'sumrow'=>$sumrow];
	}

	// Честно свиснул с https://translated.turbopages.org/proxy_u/en-ru.ru.2717cae5-628b4b21-67ec94ad-74722d776562/https/stackoverflow.com/questions/17778723/generating-random-numbers-without-repeats?noredirect=1
	// Генерирует массив случайных уникальных чисел
	function randomGen(int $min,int $max,int $quantity):array {
		$numbers = range($min, $max);
		shuffle($numbers);
		return array_slice($numbers, 0, $quantity);
	}

	function genArr(int $rows = 7,int $cols = 5):array{
		for ($i=0; $i < $rows; $i++) {
			$arr[$i] = randomGen(1,1000,$cols);
		}
		return $arr;
	}



?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Задачи для подхода к разработке</title>
</head>
<body>
	<div class="header">
		<div class="phone"><?=$currphone?></div>
	</div>
	<div class="content">
		<?php
			echo '<h1>Задача 1</h1> <br>';
			task1(1,100);
			echo '<h1>Задача 2</h1> <br>';
			task2();
		?>
	</div>
	<div class="footer">
		<div class="phone"><?=$currphone?></div>
	</div>
</body>
</html>
<style>
	.phone{
		text-align: center;
	}
	div.header {
  position:fixed;
  top:0;
  width:100%;
  height:50px;
}
div.footer {
	position: fixed;
	left: 0;
	bottom: 0;
	width: 100%;
	/*height: 80px;*/
}
</style>