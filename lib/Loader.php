<?php

/**
 * 自动加载类
 * @version yocheck 1.0
 * @author  huntstack <huntstack@gmail.com>
 * @date    2014-07-09 20:35:10
 * @site 	https://github.com/huntstack
 */

define('ROOT', dirname(dirname(__FILE__))); 

//设置包含路径
set_include_path(ROOT.'/lib/'.PATH_SEPARATOR.ROOT.'/report/'.
	PATH_SEPARATOR.ROOT.'/rules/'.PATH_SEPARATOR.ROOT.'/result/'
	.PATH_SEPARATOR.ROOT.'/rules/js/'.PATH_SEPARATOR.ROOT.'/rules/php');

class Loader{
 	
	public static function loadClass($class){  
		$file = $class . '.php';
		if(file_exists(ROOT."/lib/".$file))  
			require_once($file); 
		elseif(file_exists(ROOT."/report/".$file))
			require_once($file); 
		elseif(file_exists(ROOT."/rules/".$file))
			require_once($file); 
		elseif(file_exists(ROOT."/result/".$file))
			require_once($file); 
		else
			echo "{$file} is not exists!\n";	   
	}   
}   

//注册自动加载类的自定义函数
spl_autoload_register(array('Loader', 'loadClass')); 