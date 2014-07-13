<?php

/**
 * @version yocheck 1.0
 * @author  huntstack <huntstack@gmail.com>
 * @date    2014-07-13 21:35:23
 * @site 	https://github.com/huntstack
 */

class PHPNotUseTab implements Rules{
    
    public $level=2;

    public $name ="缩进由四个空格组成，禁止使用制表符TAB";

    public $des  ="<p>这个主要是为了代码美观整齐。因为在不同的编辑器里， 
    				TAB 制表符的长度是不一样的，而空格则是一样的。
    				实际上这已经成为编写代码的默认标准之一</p>";

    public function parser(array $filecontent){
        $result=array();

    	$pattern="/\t/i";

    	$result=preg_grep($pattern,$filecontent);

    	return $result;
    }
}