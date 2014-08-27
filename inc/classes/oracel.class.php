<?php
/**
 *  oracel.class.php 数据库实现类
 *
 * @copyright			(C) 2005-2010 PHPCMS
 * @license				http://www.phpcms.cn/license/
 * @lastmodify			2010-6-1
 */

final class oracel
{
	
	
		/**
	 * 数据库配置信息
	 */
	private $config = null;
	
	/**
	 * 数据库连接资源句柄
	 */
	public $link = null;
	
	/**
	 * 最近一次查询资源句柄
	 */
	public $lastqueryid = null;
	
	/**
	 *  统计数据库查询次数
	 */
	public $querycount = 0;
	
	public function __construct() {

	}
	
	/**
	 * 打开数据库连接,有可能不真实连接数据库
	 * @param $config	数据库连接参数
	 * 			
	 * @return void
	 */
	public function open($config) {
		$this->config = $config;
			
		if($config['autoconnect'] == 1) {
			$this->connect();
		}
	}
	
	public function connect()//连接数据库
		{
			
	
		   $orcale_username= $this->config['username'];
		   $orcale_password=$this->config['password'];
		   $orcale_dbdatabase=$this->config['hostname'];
		  
		   
		 
					   if(!$this->db_conn)
					   {
								$dblink=oci_connect($orcale_username,$orcale_password,$orcale_dbdatabase,'AL32UTF8'); 
								if(!$dblink) 
								{echo "数据库连接失败!";
								$e = oci_error();
							
								exit;						
								}
					  			
					 return $dblink;
			 
						}
		}





public  function select($data,$table,$where ,$limit = '', $order = '', $group = '', $key = '')
{
	
	 
		$where = $where == '' ? '' : ' where '.$where.' ';
		$order = $order == '' ? '' : ' ORDER BY '.$order;
		$group = $group == '' ? '' : ' GROUP BY '.$group;
		
		if($limit){
		$limit = explode(',', $limit);
		
		$kaishi='and rownum<'.$limit[1].' minus ';
		$jieshu='and rownum<'.$limit[0];
	
		
		}
		$field = explode(',', $data);
		array_walk($field, array($this, 'add_special_char'));
		$data = implode(',', $field);
		
	
		
	if($limit){	
	
		if($order){
		$table="(select * from ".$table." ".$order." )";
		}
		
	    if ($data==""){ 	//取范围的查询
	  
	  
	   $sql = " select *   from  ".$table."  ". $where.$kaishi.$group ." select *   from  ".$table."  ". $where.$jieshu.$group;
	   
	 	 }else{
	  
	  	
	   $sql = " select ".$data. " from ".$table."  ".$where.$kaishi.$group ." select *   from  ".$table."  ". $where.$jieshu.$group;
	  	 }
	   
		}else{		//不取范围的查询
		
		 if ($data==""){ 
	  
	  
	   $sql = " select *   from  ".$table."  ". $where.$group.$order ;
	   
	 	 }else{
	  
	  $sql = " select ".$data. " from ".$table."  ".$where.$group.$order;
	  	 }
			
		}
	
	
		
	   $stmt = oci_parse( $this->connect(), $sql);
	   
	
	   
	   oci_execute($stmt);
	 
	 //  $nrows = oci_fetch_all($stmt, $results);
	   
	   while (($row = oci_fetch_array($stmt, OCI_ASSOC))) {
			$res[]=$row;
		}
	      
       if(!$res) { 
					
		
		$e = oci_error();
		 exit;
		
		}
		
	   return $res;
		@oci_free_statement($stmt); 
		$this->close();
		  //查询数据
  }




public  function insert($data, $table, $return_insert_id = false, $replace = false) {
		if(!is_array( $data ) || $table == '' || count($data) == 0) {
			return false;
		}
		
		$fielddata = array_keys($data);
		$valuedata = array_values($data);
		array_walk($fielddata, array($this, 'add_special_char'));
		array_walk($valuedata, array($this, 'escape_string'));
		
		$ziztable='s_'.$table;
			
		
		foreach($valuedata as $key=>$v){
			if($v=="'".OKEY."'"){
				$valuedata[$key]="".$ziztable.".nextval";			//oracel 自增数据
			}else{
				$valuedata[$key]="".$v."";	
			}
		}
		

	
		$field = implode (',', $fielddata);
		$value = implode (',', $valuedata);
	
		
		
	
		#$cmd = $replace ? 'REPLACE INTO' : 'INSERT INTO';
		$cmd = 'INSERT INTO';
		$sql = $cmd.' '.$table.'('.$field.') VALUES ('.$value.')';
	
	
		
		$stmt = oci_parse( $this->connect(),  $sql);
		 
		if (!$stmt){  echo ' sql格式出错！请与程序员联系';} 
		
	
		$r = oci_execute($stmt);
		
		return $return_insert_id ?  $r : $r;
		#return $stmt;
		oci_free_statement($stmt) ;//插入数据库
	    $this->close();
	}
	
	/**
	 * 获取最后一次添加记录的主键号
	 * @return int 
	 */
	public function insert_id($idby) {
		
		$ids= $this->select('','','','',$idby.' desc');
		
		return $ids;
		#return mysql_insert_id($this->link);
	}


	public function update($data, $table, $where = '') {
		if($table == '' or $where == '') {
			return false;
		}

		$where = ' WHERE '.$where;
		$field = '';
		if(is_string($data) && $data != '') {
			$field = $data;
		} elseif (is_array($data) && count($data) > 0) {
			$fields = array();
			foreach($data as $k=>$v) {
				switch (substr($v, 0, 2)) {
					case '+=':
						$v = substr($v,2);
						if (is_numeric($v)) {
							$fields[] = $this->add_special_char($k).'='.$this->add_special_char($k).'+'.$this->escape_string($v, '', false);
						} else {
							continue;
						}
						
						break;
					case '-=':
						$v = substr($v,2);
						if (is_numeric($v)) {
							$fields[] = $this->add_special_char($k).'='.$this->add_special_char($k).'-'.$this->escape_string($v, '', false);
						} else {
							continue;
						}
						break;
					default:
						$fields[] = $this->add_special_char($k).'='.$this->escape_string($v);
				}
			}
			$field = implode(',', $fields);
		} else {
			return false;
		}

		$sql = 'UPDATE '.$table.' SET '.$field.$where;
		
		
		$stmt = oci_parse( $this->connect(),  $sql);
	    if (!$stmt){echo ' sql格式出错！请与程序员联系';} 
        $r = oci_execute($stmt);
		return $r;
		oci_free_statement($stmt) ;//修改数据
		$this->close();//关闭数据
	  
	
	}
	
  



	public function delete($table, $where) {
		if ($table == '' || $where == '') {
			return false;
		}
		$where = ' WHERE '.$where;
		$sql = 'DELETE FROM '.$table.''.$where;
		
		$stmt = oci_parse( $this->connect(),  $sql);
		return oci_execute($stmt);//删除数据
		oci_free_statement($stmt);
		$this->close();
		
	}



	
	
		/**
	 * 获取单条记录查询
	 * @param $data 		需要查询的字段值[例`name`,`gender`,`birthday`]
	 * @param $table 		数据表
	 * @param $where 		查询条件
	 * @param $order 		排序方式	[默认按数据库默认方式排序]
	 * @param $group 		分组方式	[默认为空]
	 * @return array/null	数据查询结果集,如果不存在，则返回空
	 */
	public function get_one($data, $table, $where = '', $order = '', $group = '') {
		$where = $where == '' ? '' : ' WHERE '.$where;
		$order = $order == '' ? '' : ' ORDER BY '.$order;
		$group = $group == '' ? '' : ' GROUP BY '.$group;
		
		$field = explode( ',', $data);
		array_walk($field, array($this, 'add_special_char'));
		$data = implode(',', $field);

		$sql = 'SELECT '.$data.' FROM '.$table.''.$where.$group.$order;

		$stmt = oci_parse( $this->connect(),  $sql);
		
		if (!$stmt){  echo ' sql格式出错！请与程序员联系';} 
		
	
	
		$r = oci_execute($stmt);
		
		  while (($row = oci_fetch_array($stmt, OCI_ASSOC))) {
			$res=$row;
		}

		return $res;
		oci_free_statement($stmt) ;//插入数据库
	    $this->close();
	
	}
	
function close()
	{
		if(!$this->close){
			//OCILogoff(  $this->connect() );
			oci_close(  $this->connect() );
			
			
		}
	}


function db_query($str)
{ 
	 if($this->connect()=="")
	 {    AlertExit("我们的数据库正忙，请稍后再连接！");}
	$stmt = OCIParse( $this->connect(),  $str);
	 if (!$stmt)
	 {AlertExit(' sql格式出错！请与程序员联系');}
	 $r = OCIExecute($stmt);
	 return $stmt;
	 OCIFreeStatement($stmt);
	 $this->close();
	 }
	 

/**
	 * 对字段两边加反引号，以保证数据库安全
	 * @param $value 数组值
	 */
	public function add_special_char(&$value) {
		if('*' == $value || false !== strpos($value, '(') || false !== strpos($value, '.') || false !== strpos ( $value, '`')) {
			//不处理包含* 或者 使用了sql方法。
		} else {
			$value = ''.trim($value).'';
		}
		return $value;
	}
	
	/**
	 * 对字段值两边加引号，以保证数据库安全
	 * @param $value 数组值
	 * @param $key 数组key
	 * @param $quotation 
	 */
	public function escape_string(&$value, $key='', $quotation = 1) {
		if ($quotation) {
			$q = '\'';
		} else {
			$q = '';
		}
		$value = $q.$value.$q;
		return $value;
	}
	
	//前后缀处理
	private function pre_suf($table) {
		$table = str_replace('pre_', '`'.$this->config['database'].'`.`'.$this->config['tablepre'], $table);
		$table = str_replace('_suf', '`', $table);
		return $table;
	}
	
	
}
?>