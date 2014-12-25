<?php

/**
 * @version yocheck 1.0
 * @author  huntstack <huntstack@gmail.com>
 * @date    2014-07-09 21:23:41
 * @site 	https://github.com/huntstack/yocheck
 */

class Process{

    private $pre;
    private $file;
    private $reporter;
    private $parameters;
    private $filesList;
    private $result;
   

    function __construct(){
        $this->pre=new PreProcess;
        $this->file=new File;
        $this->reporter=new HTMLReport;
    }
    
    public function parserCommandLine(){
        $this->parameters=$this->pre->parserCommandLine();
    }

    public function scan(){
        $this->filesList=$this->pre->scan($this->parameters);

    }

    public function result(){
    	$this->result=$this->file->run($this->filesList);
    }

    public function report(){
    	$this->reporter->creatReport($this->parameters,$this->result);
        echo "  [NOTICE]--if you have some suggestions,you can send email to \n";
        echo "            huntstack@gmail.com\n";
        echo "            or you can download the source code from \n";
        echo "            https://github.com/huntstack/yocheck.\n";
    }
}