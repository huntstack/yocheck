<?php

/**
 * @version yocheck 1.0
 * @author  huntstack <huntstack@gmail.com>
 * @date    2014-07-13 22:59:12
 * @site 	https://github.com/huntstack/yocheck
 */

class PHPClassNameChar implements Rules{
    public $level=3;

    public $name ="类名只包含字母，且第一个字符大写";

    public $des  ="<p>类名第一个字符大写</p>";

    public function parser(array $filecontent){
        $result=array();

    	$pattern="/class\s+[a-z][a-zA-Z]+/";

    	$result=preg_grep($pattern,$filecontent);

    	return $result;
    }
}