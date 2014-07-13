<?php

/**
 * @version yocheck 1.0
 * @author  huntstack <huntstack@gmail.com>
 * @date    2014-07-13 09:04:28
 * @site 	https://github.com/huntstack/yocheck
 */

class PHPNotUseCountInFor implements Rules{

    public $level=3;

    public $name ="在for循环中尽量不要使用count()函数";

    public $des  ="<p>在for循环中使用count()函数,每一次for循环都会执行一次该函数，影响性能</p>";

    public function parser(array $filecontent){
        $result=array();

    	$pattern="/for\s*\(.*;.*<=?\s*count\(/";

    	$result=preg_grep($pattern,$filecontent);

    	return $result;
    }
}