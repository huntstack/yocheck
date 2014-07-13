<?php

/**
 * 公用方法
 * @version yocheck 1.0
 * @author  huntstack <huntstack@gmail.com>
 * @date    2014-07-09 21:54:20
 * @site 	https://github.com/huntstack
 */

class PublicFunction{

    /**
    * 获取当前时间
    */
    public static function getTime(){
    	return date("H:i:s", time());
    }

    /**
    * 获取当前日期
    */
    public static function getDate(){
    	return date("Y-m-d", time());
    }

    /**
    * 根据不同操作系统处理斜杠
    */
    public function dealSlash(){
    	if(strpos(php_uname('s'),"indows"))
    		return "\\";
    	else
    		return "/";
    }

    /**
    * 根据不同操作系统处理换行符
    */
    public function dealWrap(){
        //stripos不能从第一个字符开始匹配
    	if(stripos(php_uname('s'),"indows"))
    		return "\r\n";
    	else
    		return "\n";
    }

    /**
    * 转换相对路径为绝对路径
    */
    public function covertRelativePathToAbsolutePath(array &$filepath){

        foreach ($filepath as $key => $value) {

            for($i=0;$i<count($filepath[$key]);$i++){
                $j=substr_count($filepath[$key][$i],"..".$this->dealSlash());
                //.\开头
                if($filepath[$key][$i][0]=="." && $filepath[$key][$i][1]==$this->dealSlash())
                    $filepath[$key][$i]=ROOT.$this->dealSlash().substr($filepath[$key][$i],2);
                //包含一个或多个..\
                elseif($j>=1){
                    $path=substr($filepath[$key][$i],$j*3);
                    while($j>0){
                        $root=$this->back();
                        $j--;
                    }
                    //判断是否有路径分隔符，有则去除
                    $root=(substr($root,-1)==$this->dealSlash())?substr($root,0,-1):$root.$this->dealSlash();
                    $filepath[$key][$i]=$root.$this->dealSlash().$path;
                }
                
            }
        }
    }


    private function back(){
        return dirname(ROOT);
    }

    /**
    * 获取文件后缀名
    */
    public function getFileType($file){
        return pathinfo($file, PATHINFO_EXTENSION);
    }

    /**
    * 计算二维数组中第二维的数量
    */
    public function countTwoArray(array $array){
        $a=count($array,COUNT_RECURSIVE)."\n";
        $b=count($array)."\n";
        return $a-$b;
    }

    public static function addLineContent(array $arrayname,array $filecontent){
        foreach ($arrayname as $key => &$value) {
            $value=$filecontent[$key-1]."\n".$filecontent[$key]."\n".$filecontent[$key+1];
        }

        return $arrayname;
    }
}