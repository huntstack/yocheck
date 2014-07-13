<?php

/**
 * @version yocheck 1.0
 * @author  huntstack <huntstack@gmail.com>
 * @date    2014-07-12 16:02:54
 * @site 	https://github.com/huntstack/yocheck
 */

class File{

	private $rules=array();
	private $pub;

	function __construct(){
		$this->pub=new PublicFunction;
	}

    public function readFile($filename){
        if(!file_exists($filename)){
            Logger::log("Warning","file ".$filename." not exist,skip.");
            Logger::message(2,"file ".$filename." not exist,skip.");
            return ;
        }
    	return file($filename,FILE_TEXT+FILE_IGNORE_NEW_LINES);
    	//return file_get_contents($filename);
    }

    /**
    * 包含规则文件
    */
    public function includeRules($dirpath){
    	$handle=opendir($dirpath);
    	while(($files=readdir($handle))!=false){
    		if($files!="." && $files!=".." && $files!="Rules.php"){
    			if(is_dir($dirpath.$this->pub->dealSlash().$files))
    				$this->includeRules($dirpath.$this->pub->dealSlash().$files);
    			else{
    				include($files);
    				if(pathinfo(dirname($dirpath.$this->pub->dealSlash().$files))["basename"]=="php")
    					$this->rules["php"][]=basename($files,".php");
    				else
    					$this->rules["js"][]=basename($files,".php");
    			}
    		}
   	 	}
	}

    public function run(array $filesList){

    	$this->includeRules(".".$this->pub->dealSlash()."rules");

        Logger::log("INFO","start check files ");
        Logger::message(3,"start check files,this will take several minutes.");
        Logger::message(3,"checking...");
    	foreach($filesList as $key => $value){
    		foreach($this->rules as $rk => $rv){
    			if($key==$rk){
    				for($i=0;$i<count($value);$i++){
    					for($j=0;$j<count($rv);$j++){
	    					$rule=new $rv[$j];
                            $result[$value[$i]][$rv[$j]]=$rule->parser($this->readFile($value[$i]));
                            if(count($result[$value[$i]][$rv[$j]])>=1){
                                $result[$value[$i]][$rv[$j]]["level"]=$rule->level;
                                $result[$value[$i]][$rv[$j]]["name"]=$rule->name;
                                $result[$value[$i]][$rv[$j]]["des"]=$rule->des;
                            }else
                                unset($result[$value[$i]][$rv[$j]]);    
	    				}
    				}    				
    			}
    		}
    	}
        Logger::message(3,"check files done");
        Logger::log("INFO","check files done ");
        //print_r($result);
        return $result;
    }

}