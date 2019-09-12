<?php 
defined('IN_SHUYANG') or exit('No permission resources.'); 
class EDI_index extends index { 
    public function __construct() { 
        if(empty($_SESSION['right_enter'])) { 
			header('HTTP/1.1 404 Not Found');
			header("status: 404 Not Found");
			include(template('content','404'));exit;
        } 
        parent::__construct(); 
    } 
   
    public function public_logout() { 
        $_SESSION['right_enter'] = 0; 
        parent::public_logout(); 
    } 

/**
 * 清空error_log缓存
 */
public function clear_error_log() {
        $file = "caches/error_log.php";
            if (!unlink($file)) {
            showmessage('清空失败，请检查 '.$file,HTTP_REFERER);
        } else {
            touch("$file");
            showmessage('错误日志清空成功！',HTTP_REFERER);
        }
    }
 } 
?>
