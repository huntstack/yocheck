<?php

/**
 * 日志记录
 * @version yocheck 1.0
 * @author  huntstack <huntstack@gmail.com>
 * @date    2014-07-09 21:53:41
 * @site 	https://github.com/huntstack/yocheck
 */
class Logger{

	/**
	* 写入txt文件
	*/
	public static function writeTxt($txt){

		$public=new PublicFunction;
		$handle=fopen(ROOT."/log/".$public->getDate().".txt", "a+");
		fwrite($handle, $public->getTime()." ".$txt.$public->dealWrap());
		fclose($handle);
	}

	/**
	* 向控制台输出信息
	*/
    public static function message($level,$mes=""){
    	if($level==3)
    		echo "  [info]: ".$mes."\n";
    	elseif($level==2)
    		echo "  [warning]: ".$mes."\n";
    	elseif($level==1){
    		echo "  [error]: ".$mes."\n";
    		exit(1);
    	}
    }

    /**
	* 记录日志
	*/
    public static function log($level,$message=""){
    	self::writeTxt("[".$level."] ".$message);
    }
}