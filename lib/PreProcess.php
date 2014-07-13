<?php

/**
 * @version yocheck 1.0
 * @author  huntstack <huntstack@gmail.com>
 * @date    2014-07-09 21:13:05
 * @site 	https://github.com/huntstack/yocheck
 */

class PreProcess{
    
    private $help=<<<END

  	-h    show this help
  	-if   ignore these files 
  	       (default:exe,ini,gitignore)
  	-id   ignore these directories
  	       (default:.git)
  	-o    write result to file
  	       (default: ./result/***.html)
  	-r    use report template,currently only supports html                        
  	-v    show version information

  	Examples:
  	yocheck D:\user-branch
  	yocheck /var/www/controller
  	yocheck -if exe,class,ini -id .git,user D:\user-branch
  	yocheck -o /var/wwww/123.html /var/www/controller

END;

	private $files=array();
	private $pub;

	function __construct(){
		$this->pub=new PublicFunction;
	}


    /**
    *处理命令行参数
    */
    public function parserCommandLine(){

    	Logger::log("INFO","start to paser command line paramers.");

    	$parameters=array();

    	$parameters["reportType"]="html";
    	$parameters["reportDir"]=ROOT."/result/".PublicFunction::getDate().".".$parameters["reportType"];
    	$parameters["ignoreFile"]="exe,tpl,gitignore";
		$parameters["ignoreDir"]=".git";
		$parameters["sources"]=array();
		$parameters["help"]=$this->help;

		$sources=-1;

		if($_SERVER["argc"]==1){
			echo $this->help;
			exit(1);
		}

		for($i=1;$i<=count($_SERVER["argv"]);$i++){
			switch ($_SERVER["argv"][$i]) {
				case '-h':
					echo $this->help;
					exit(1);
					break;
				case '-if':
					if(!isset($_SERVER["argv"][++$i])){
						echo $this->help;
						exit(1);
					}
					$parameters["ignoreFile"]=$_SERVER["argv"][$i];
					break;
				case '-id':
					if(!isset($_SERVER["argv"][++$i])){
						echo $this->help;
						exit(1);
					}
					$parameters["ignoreDir"]=$_SERVER["argv"][$i];
					break;
				case '-o':
					if(!isset($_SERVER["argv"][++$i])){
						echo $this->help;
						exit(1);
					}
					$parameters["reportDir"]=$_SERVER["argv"][$i];
					break;
				case '-r':
					if(!isset($_SERVER["argv"][++$i])){
						echo $this->help;
						exit(1);
					}
					$parameters["reportType"]=$_SERVER["argv"][$i];
					break;
				case '-v':
					echo "yocheck version-1.0,you can find more information in https://github.com/huntstack";
					exit(1);
				break;
				
				default:
					$parameters["sources"][++$sources]=$_SERVER["argv"][$i];
					break;
			}
		}

		//去除多余的null节点
		unset($parameters["sources"][$sources]);
		Logger::log("INFO","paser command line parameters done.");

		return $parameters;

    }

    /**
    * 扫描文件返回文件类型的二维关键字数组
    */
    public function scan(array $parameters){

    	Logger::message(3,"start scan files.");
    	Logger::log("INFO","start scan files.");

    	$ignoredir=explode(",", $parameters["ignoreDir"]);
    	$ignorefile=explode(",", $parameters["ignoreFile"]);

    	if(!isset($parameters["sources"])){
    		echo $this->help;
    		Logger::log("ERROR","nothing to sacan,input the sources files or directories.");
    		Logger::message(1,"nothing to sacan,input the sources files or directories.");
    	}
    	
    	foreach($parameters["sources"] as $source){

    		if(is_dir($source)){
    			if($source==$parameters["ignoreDir"])
    				Logger::message(1,"this directory is ignored.");
    			$this->recursive($source,$ignoredir,$ignorefile);
    		}
    		elseif(file_exists($source) && in_array($this->pub->getFileType($source),$ignorefile)==false)
    			$this->files[$this->pub->getFileType($source)][]=$source;
    		else{
    			Logger::log("ERROR","files or directory not exist.");
    			Logger::message(1,"files or directory not exist.");
    		}
    			
    	}

    	//转换相对路径为绝对路径，方便后续统计
    	$this->pub->covertRelativePathToAbsolutePath($this->files);
    	//print_r($this->files);
    	Logger::message(3,"scan files done. ".$this->pub->countTwoArray($this->files)." files will be checked.");
    	Logger::log("INFO","scan files done. ".$this->pub->countTwoArray($this->files)." files will be checked.");

    	return $this->files;
    }

    /**
    * 递归遍历文件夹
    */
    private function recursive($dirpath,array $ignore,array $ignorefile){
    	$handle=opendir($dirpath);
    	while(($files=readdir($handle))!=false){
			if($files!="." && $files!=".." && in_array($files,$ignore)==false){
				if(is_dir($dirpath.$this->pub->dealSlash().$files)){
					$this->recursive($dirpath.$this->pub->dealSlash().$files,$ignore,$ignorefile);
				}elseif(in_array($this->pub->getFileType($dirpath.$this->pub->dealSlash().$files),$ignorefile)==false)
					$this->files[$this->pub->getFileType($dirpath.$this->pub->dealSlash().$files)][]=$dirpath.$this->pub->dealSlash().$files;
			}
		}
    }


}