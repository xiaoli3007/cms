<?php 
class session_files {
    function __construct() {
		$path = inc_base::load_config('system', 'session_n') > 0 ? inc_base::load_config('system', 'session_n').';'.inc_base::load_config('system', 'session_savepath')  : inc_base::load_config('system', 'session_savepath');
		ini_set('session.save_handler', 'files');
		session_save_path($path);
		session_start();
    }
}
?>