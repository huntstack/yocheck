<?php

/**
 * @version yocheck 1.0
 * @author  huntstack <huntstack@gmail.com>
 * @date    2014-07-12 20:03:32
 * @site 	https://github.com/huntstack
 */

class JSIfMustHaveBraces implements Rules{

        
    public $level=1;

    public $name="流程控制语句需加大括号";

    public $des="<p>if,while,for,foreach后面跟单语句时也必须加大括号
                如if(1) echo 11;是不被允许的</p>";

    public function parser(array $filecontent){

        $result=array();

        //匹配if() expression;
        $pattern="/if\s?\(.*?\)[^\{]*;/i";
        //匹配if()
        //expression;
        $pattern2="/if\s?\(.*?\)(.*?)(?!\{)/i";

        $result=preg_grep($pattern,$filecontent);

        $tmp=preg_grep($pattern2,$filecontent);

        foreach ($tmp as $key => $value) {

            if(preg_match("/\{/i", $filecontent[$key]))
                ;
            elseif(preg_match("/\{/i", $filecontent[$key+1]))
                ;
            elseif(preg_match("/;/i", $filecontent[$key+1]))
                $result[$key+1]=$filecontent[$key+1];
            elseif(preg_match("/;/i", $filecontent[$key+2]))
                $result[$key+2]=$filecontent[$key+2];
        }

        return $result;
    }
}
