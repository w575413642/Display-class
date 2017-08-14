<?php
$max = 1000000;
$hit = 0;
$i = 1000 * $max;
while ($i--){
	$rnd = mt_rand(1, $max);
	if($rnd == 1){
		$hit++;
	}

	//echo $rnd , ' ';
}
ob_start();
echo '<h1>$max is ', $max, ' 期望概率：', (float)(1000/$max) , '</h1>';
echo '<h1>', $hit, '</h1>';
echo '<h1>实际概率：', $hit / $max , '</h1>', "<br>\r\n";
$rs = ob_get_clean();
file_put_contents('test.log.html', $rs, FILE_APPEND);

