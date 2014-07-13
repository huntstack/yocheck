<?php

/**
 * @version yocheck 1.0
 * @author  huntstack <huntstack@gmail.com>
 * @date    2014-07-13 21:41:47
 * @site 	https://github.com/huntstack
 */

class PHPEachLineShouldLessThanEightyCharacters implements Rules{
    
    public $level=3;

    public $name ="每行代码长度应控制在80以内，最长不超过120";

    public $des  ="<p>因为 linux 读入文件一般以80列为单位，
    				就是说如果一行代码超过80个字符，那么系统将为此付出额外操作指令。
				    这个虽然看起来是小问题，
				    但是对于追求完美的程序员来说也是值得注意并遵守的规范</p>";

    public function parser(array $filecontent){
        $result=array();

    	$countLine=count($filecontent);

    	for($i=0;$i<$countLine;$i++){
    		if(strlen($filecontent[$i])>120)
    			$result[$i]=$filecontent[$i];
    	}

    	return $result;
    }
}