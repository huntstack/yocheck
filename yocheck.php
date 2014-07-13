<?php

/**
 * 入口,从这里启动
 * @version yocheck 1.0
 * @author  huntstack <huntstack@gmail.com>
 * @date    2014-07-09 21:08:41
 * @site 	https://github.com/huntstack
 */

//自动加载类
require_once("lib/Loader.php");

class yocheck{

	private $start;

	public function main(){

		$this->start=new Process;

		//解析命令行参数
		$this->start->parserCommandLine();
		//扫描文件
		$this->start->scan();
		//分析结果
		$this->start->result();
		//生成报告
		$this->start->report();

	}
}

$y=new yocheck;
$y->main();

?>