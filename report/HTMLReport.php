<?php

/**
 * @version yocheck 1.0
 * @author  huntstack <huntstack@gmail.com>
 * @date    2014-07-13 11:38:36
 * @site 	https://github.com/huntstack/yocheck
 */

class HTMLReport extends Report{

	public function top(){
		$csspath=ROOT."/result/css/result.css";
		$time=PublicFunction::getDate()." ".PublicFunction::getTime();
		return <<<END
<html>
	<head>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" type="text/css" href="$csspath">
	<title>静态代码检查报告</title>
	</head>
	<body>
	    <div class="version">
	   		<span>yocheck $time</span>
	    </div>
	    <script language="JavaScript">
	    	function showCode(lineid,event){
	    		var event = event || window.event;
				var code = document.getElementById('code');
				var snippet=document.getElementById(lineid+'code');
				code.style.display='block';
				code.style.left=event.clientX+(document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft);    
				code.style.top=event.clientY+(document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop);     
				code.innerHTML=snippet.innerHTML;   	 
	    	}

	    	function showDes(desid,event){
	    		 var event = event || window.event;
				 var description = document.getElementById('description');
				 var snippet=document.getElementById(desid+'description');
				 description.style.left=event.clientX+(document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft);    
				 description.style.top=event.clientY+(document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop);
				 description.innerHTML=snippet.innerHTML;
				 description.style.display='block';	 
	    	}
	    	function hideCode(){
				 var s = document.getElementById('code');
				 s.style.display='none';
	    	}
	    	function hideDes(){
				 var s = document.getElementById('description');
				 s.style.display='none';
	    	}

	    	function collapseDiv(divid){
				var d=document.getElementById(divid);
				if(d.style.display==='block')
					d.style.display='none';
				else
					d.style.display='block';
	    	}
	    </script>
END;
	}

	public function bottom(){
		return <<<END
	</body>
</html>	
END;
	}
    
    public function creatReport($param,array $result){

    	try{
    		$handle=fopen($param["reportDir"], "w");
    	}catch(Exception $e){
    		echo $e->getMessage();
    		Logger::log("ERROR",$e->getMessage());
    		exit(1);
    	}

    	Logger::message(3,"creating report...");
    	Logger::log("INFO","create report to ".$param["reportDir"]);

    	fwrite($handle, $this->top().$this->parserResult($result).$this->bottom());
		fclose($handle);
		Logger::message(3,"you can see the report at ".$param["reportDir"]);
    }

    public function parserResult(array $result){
    	$id=0;
    	$divid=0;
    	foreach ($result as $key => $value) {
    		$num=$this->getCount($value);
    		if($num["high"]==0 && $num["mid"]==0 && $num["low"]==0){
    			;
    		}else{
    			$html.='<div class="files"><span class="filename">'.$key.'</span><button class="ca" onclick="collapseDiv('.++$divid.')">点我</button><div class="filenum">';
	    		$html.='<span class="high">'.$num["high"]."</span>";
	    		$html.='<span class="mid">'.$num["mid"]."</span>";
	    		$html.='<span class="low">'.$num["low"]."</span></div></div>";
	    		$html.='<div id='.$divid.' style="display:none;"><table>';
	    		//$this->lsort($value);
	    		foreach ($value as $k => $v) {
	    			foreach ($v as $kk => $vv) {
	    				if($kk!="level" && $kk!="name" && $kk!="des" && !is_null($kk)){
	    					$html.='<tr class="'.$this->level($v).'"><td>'.++$kk.'</td>';
	    					$html.='<td style="width:200px">'.$k.'</td>';
	    					$html.='<td style="width:450px" onmouseover="showCode('.++$id.',event)" onmouseout="hideCode()"><xmp>'.trim($vv).'</xmp></td>';
	    					$html.='<td class="trcode" style="width:350px" onmouseover="showDes('.$id.',event)" onmouseout="hideDes()">'.$v["name"].'</td></tr>';
	    					$html.='<span id="'.$id."code".'" style="display:none;">'.$this->getCodeSnippet($kk,$key).'</span>';
	    					$html.='<span id="'.$id."description".'" style="display:none;">'.$v["des"].'</span>';
	    				}
	    			}

	    			
	    		}
	    		$html.='</table></div>';
	    	}	
    	}
    	$html.='<div id="code"></div>';
	    $html.='<div id="description"></div>';
    	return $html;
    }

    private function getCodeSnippet($index,$filename){
    	$file=new File;
    	$content=$file->readFile($filename);
    	$line1=$index-3;
    	$line2=$index-2;
    	$line3=$index-1;
    	$line4=$index;
    	$line5=$index+1;
    	$line6=$index+2;
    	return  "<span>{$line1} ".$content[$index-4]."</span></br>".
    			"<span>{$line2} ".$content[$index-3]."</span></br>".
    			"<span>{$line3} ".$content[$index-2]."</span></br>".
    			"<span style='color:yellow;'>{$line4} ".$content[$index-1]."</span></br>".
    			"<span>{$line5} ".$content[$index]."</span></br>".
    			"<span>{$line6} ".$content[$index+1]."</span></br>";
    }
}