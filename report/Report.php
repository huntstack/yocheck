<?php

/**
 * @version yocheck 1.0
 * @author  huntstack <huntstack@gmail.com>
 * @date    2014-07-13 09:44:44
 * @site 	https://github.com/huntstack/yocheck
 */

class Report{
    
	public function getCount(array $result){

    	$num=array("high"=>0,"mid"=>0,"low"=>0);
    	foreach ($result as $key => $value) {  	
    		if($value["level"]==1)
    			$num["high"]+=(count($value)-3);
    		elseif($value["level"]==2)
    			$num["mid"]+=(count($value)-3);
    		elseif($value["level"]==3)
    			$num["low"]+=(count($value)-3);
    	}
    	return $num;
    }

    public function lsort(array &$rules){
    	$numi=count($rules);
    	for($i=0;$i<$numi-1;$i++){
    		for($j=$i+1;$j<$numi;$j++){
    			if($rules[$i]["level"]>$rules[$j]["level"]){
    				$temp=$rules[$i];
    				$rules[$i]=$rules[$j];
    				$rules[$j]=$temp;
    			}
    		}
    	}
    }

    public function level(array $level){
    	if($level["level"]==1)
    		return "high";
    	elseif($level["level"]==2)
    		return "mid";
    	elseif($level["level"]==3)
    		return "low";
    }

}