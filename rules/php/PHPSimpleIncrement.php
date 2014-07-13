<?php

/**
 * @version yocheck 1.0
 * @author  huntstack <huntstack@gmail.com>
 * @date    2014-07-13 21:14:37
 * @site 	https://github.com/huntstack
 */

class PHPSimpleIncrement implements Rules{
    
    public $level=3;

    public $name ="使用++\$foo 代替 \$foo++";

    public $des  ="<p>这样会提高20%左右的速度</p>";

    public function parser(array $filecontent){
        $result=array();

    	$pattern="/(^|;)\s*\$[a-z_][a-z0-9_]*\+\+/i";

    	$result=preg_grep($pattern,$filecontent);

    	return $result;
    }
}