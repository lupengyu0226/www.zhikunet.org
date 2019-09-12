<?php
//error_reporting(E_ALL);
define('SHUYANG_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR);
define('CRON_PATH', SHUYANG_PATH.'caches/cron');
include SHUYANG_PATH.'languages/feitian.php';
$pid_file = CRON_PATH . '/crons.pid';
if (is_file($pid_file))
{
    if ((filemtime($pid_file) + 180) < SYS_TIME)
	{
		echo date("Y-m-d H:i:s").": This Cron running over one minutes, now killing it...". PHP_EOL;
		@unlink($pid_file);
	}
	else
	{
	echo date("Y-m-d H:i:s").": This Cron is running.".PHP_EOL;
	exit;
	}
}
file_put_contents($pid_file, '');


shy_base::app_run('cron','index','edi_cron');
if (is_file($pid_file)) @unlink($pid_file);
echo date("Y-m-d H:i:s").": This Cron is running.".PHP_EOL;
?>