<?php
defined('IN_CORE') or exit('File does not exist.');
inc_base::load_sys_class('oracel_model', '', 0);
class times_model extends oracel_model {
	public function __construct() {
		$this->db_config = inc_base::load_config('database');
		$this->db_setting = 'default';
		$this->table_name = 'times';
		parent::__construct();
	}
}
?>