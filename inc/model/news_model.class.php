<?php
defined('IN_CORE') or exit('File does not exist.');
inc_base::load_sys_class('model', '', 0);
class news_model extends model {
	public function __construct() {
		$this->db_config = inc_base::load_config('database');
		$this->db_setting = 'default';
		$this->table_name = 'news';
		parent::__construct();
	}
}
?>