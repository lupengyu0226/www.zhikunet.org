<?php 
class session_files {
    function __construct() {
		$path = shy_base::load_config('system', 'session_n') > 0 ? shy_base::load_config('system', 'session_n').';'.shy_base::load_config('system', 'session_savepath')  : shy_base::load_config('system', 'session_savepath');
		ini_set('session.save_handler', 'files');
		ini_set("session.cookie_httponly", 1);
		session_save_path($path);
		session_start();
    }
}
?>
