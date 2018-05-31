<?php 

/*三十六进制转换*/
$dic = array( 
    0 => '0', 1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5', 6 => '6', 7 => '7', 8 => '8', 9 => '9', 
    10 => 'A', 11 => 'B', 12 => 'C', 13 => 'D', 14 => 'E', 15 => 'F', 16 => 'G', 17 => 'H', 18 => 'I', 
    19 => 'J', 20 => 'K', 21 => 'L', 22 => 'M', 23 => 'N', 24 => 'O', 25 => 'P', 26 => 'Q', 27 => 'R', 
    28 => 'S', 29 => 'T', 30 => 'U', 31 => 'V', 32 => 'W', 33 => 'X', 34 => 'Y', 35 => 'Z' 
    ); 
 
//十进制转换三十六进制
function enid($int, $format = 8) { 
    global $dic; 
    $arr = array(); 
    $loop = true; 
    while ($loop)  
    { 
        $arr[] = $dic[bcmod($int, 36)]; 
        $int = floor(bcdiv($int, 36)); 
        if ($int == 0) { 
            $loop = false; 
        } 
    } 
    array_pad($arr, $format, $dic[0]); 
    return implode('', array_reverse($arr)); 
} 
 
//三十六进制转换十进制 
function deid($id) { 
    global $dic; 
    // 键值交换 
    $dedic = array_flip($dic); 
    // 去零 
    $id = ltrim($id, $dic[0]); 
    // 反转 
    $id = strrev($id); 
    $v = 0; 
    for($i = 0, $j = strlen($id); $i < $j; $i++)  
    { 
        $v = bcadd(bcmul($dedic[$id{$i}] , bcpow(36, $i)) , $v); 
    } 
    return $v; 
}  

/*end */


?>