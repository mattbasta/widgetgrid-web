<?php

if(isset($path[1])) {
	
	$id = intval($path[1]);
	
	$im = imagecreatefrompng("base.png");
	$black = imagecolorallocate($im, 0, 0, 0);
	
	$c = 0;
	
	for($i=0;$i<4;$i++) {
		for($j=0;$j<4;$j++) {
			if(	($j==0 && $i==0) ||
				($j==0 && $i==3) ||
				($j==3 && $i==0))
				continue;
			
			$b = pow(2, $c);
			
			if($id & $b) {
				
				imagefilledrectangle(
					$im,
					$j * 100 + 100,
					$i * 100 + 100,
					$j * 100 + 200,
					$i * 100 + 200,
					$black
				);
				
			}
			
			$c++;
			
		}
	}
	
	for($i=0;$i<13;$i++) {
		$j = pow(2,$i);
		
		if($id2 % ($j + 1) == 0)
			continue;
		
		$subtr += $j;
		$id2 -= $j;
		
	}
	
	header("Content-type: image/png");
	
	imagepng($im);
	imagedestroy($im);
	
	flush();
	
}