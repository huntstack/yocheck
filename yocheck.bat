::windows下的启动程序
::@后面的命令在执行时不输出至控制台
@if "%*"=="" (.\php\php.exe -h) else (.\php\php.exe -c .\php\php.ini yocheck.php %*)