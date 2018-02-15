<?php

	/**
		* Crud class performs base database tasks
		*
		* Crud can be inherited as a base class in other classes which require database interactions, 
		* it can also be directly instantiated 
		*
		* Example usage:
		* $CRUD_OBJ = new Crud();
		* $CRUD_OBJ->table_name = "your_table";
		* $record_list = $CRUD_OBJ->recordSelect();
		*/
		
	Class Crud{
		
		private $connection;
		public $table_name;
		public $last_record_Id = 0;
		public $throw_exceptions = "off";
		public $error_log = array();
		public $current_run_sql;
		public $unpaginated_result_count;
		
		
		/**
		 * Class contructor
		 * @param string $table_name 
		 * @return null 
		 */
		public function __construct($table_name = ""){
			if(!empty($table_name)){
				$this->$table_name = $table_name;
			}
			try{
				$this->connection = new MySQLi(DATABASE_SERVER,DATABASE_USER,DATABASE_PASSWORD,DATABASE_NAME);
				if($this->tableExist($this->table_name)){
					
				}else{
					$this->logErrors("The table '".$this->table_name."' doesn’t exist in the current database.");
				}
			}catch(Exception $ex){
				$this->logErrors($ex->getMessage());
			}
		}
		
		/**
		 * This function is used to insert new records into the current table it takes two parameters: 
		 * $data: An associative array of columns and associated values
		 * $exclude: An optional array of columns to ignore in the insert statement
		 * @param array $data 
		 * @param array $exclude
		 * @return bool 
		 *
		 * @access public
		 */
		public function addNewRecord($table_name = '',$data,$exclude = array()){
			if(empty($this->table_name)){
				if(empty($table_name)){
					$this->logErrors("Invalid table name.");
				}else{
					if($this->tableExist($table_name)){
						$this->table_name = $table_name;
					}else{
						$this->logErrors("Invalid table name.");
					}
				}
			}
			try{
				if(is_array($data) && count($data)){
					if(!is_array($exclude)) $exclude = array($exclude);
					foreach( array_keys($data) as $key ) {
			        	if( !in_array($key, $exclude) ) {
			            	$fields[] = "`$key`";
			            	$values[] = "'" . addslashes($data[$key]) . "'";
			        	}
			    	}
			    	$fields = implode(",", $fields);
			    	$values = implode(",", $values);
				    $sql = "INSERT INTO `$this->table_name` ($fields) VALUES ($values)";
			    
                    
					$result = $this->connection->query($sql);
					if($this->connection->insert_id == 0){
						return false;
					}else{
						$this->last_record_Id = $this->connection->insert_id;
						if($this->last_record_Id > 0){
							$this->current_run_sql = $sql;
							return true;
						}else{
							return false;
						}
					}
				}else{
					$this->logErrors("Missing or invalid parameters supplied, please check the documentation.");
				}
			}catch(Exception $ex){
				$this->logErrors($ex->getMessage());
			}
		}
		
		/**
		 * This function is used to update existing records of the current table it takes three parameters: 
		 * $data: An associative array of columns and associated values
		 * $column_to_check: Name of the column which will be used in the WHERE clause
		 * $column_value: Value of the column in the WHERE column
		 * @param array $data 
		 * @param string $column_to_check
		 * @param mixed $column_value
		 * @return bool 
		 *
		 * @access public
		 */
		public function updateRecord($table_name = '',$data ,$column_to_check ,$column_value){
			
			echo $column_value;
			exit;
			if(empty($this->table_name)){
				if(empty($table_name)){
					$this->logErrors("Invalid table name.");
				}else{
					if($this->tableExist($table_name)){
						$this->table_name = $table_name;
					}else{
						$this->logErrors("Invalid table name.");
					}
				}
			}
			try{
				if(is_array($data) && count($data) > 0 && !empty($column_to_check) && !empty($column_value)){
					if(is_array($data) && !empty($column_to_check) && !empty($column_value)){
			            $sql = "UPDATE ".$this->table_name." SET ";
						$loopCount = 0;
			            foreach(array_keys($data) as $key){
		                	$record = $data[$key];
							if(!empty($record)){
							 	if($loopCount <= 0){
			                        $sql .= " `$key`="."'".addslashes($record)."'";
			                    }else {
			                        $sql .= " ,`$key`="."'".addslashes($record)."'";
			                    }
			                    $loopCount++;
							}else{
								continue;
							}
		                }
						$column_value = addslashes($column_value);
			            $sql = sprintf($sql." WHERE %s = '%s'", $column_to_check, $column_value);
					   
					   
					   
						if($this->connection->query($sql) > 0){
							$this->current_run_sql = $sql;
							return true;
						}else{
							$this->current_run_sql = $sql;
							return false;
						}
					}else{
						return false;
					}
				}else{
					$this->logErrors("Missing or invalid parameters supplied, please check the documentation.");
				}
			}catch(Exception $ex){
				$this->logErrors($ex->getMessage());
			}
		}
		
		/**
		 * This function is used to delete records in the current table it takes two parameters: 
		 * $column_to_check: Name of the column which will be used in the WHERE clause
		 * $column_value: Value of the column in the WHERE column
		 * @param string $column_to_check
		 * @param mixed $column_value
		 * @return bool 
		 *
		 * @access public
		 */
		public function deleteRecord($column_to_check,$column_value){
			try{
				if(!empty($column_to_check) && !empty($column_value)){
					$column_value = addslashes($column_value);
					$delete_sql = sprintf("DELETE FROM %s WHERE %s = '%s'", 
											$this->table_name,$column_to_check,$column_value);
					$result = $this->connection->query($delete_sql);
					if($result > 0){
						$this->current_run_sql = $delete_sql;
						return true;
					}else{
						return false;
					}
				}else{
					$this->logErrors("Missing or invalid parameters supplied, please check the documentation.");
				}
			}catch(Exception $ex){
				$this->logErrors($ex->getMessage());
			}
		}
		
		/**
		 * This function is used to fetch data from the current table, it takes two optional parameters: 
		 * 
		 * $table_name: If the base table name is not define a table name can be passed to this function
		 * $columns_to_exclude: An array of columns which should not be included in the fetched result set
		 * $where_condition: An associative array of columns and associated values which should be used in the where clause
		 * @param array $columns_to_exclude
		 * @param array $where_condition
		 * @param string $table_name
		 * @return array 
		 *
		 * @access public
		 */
		public function recordSelect($table_name = '',$columns_to_include = array(),$where_condition= array(),$upper_limit = "",$lower_limit = "",$order_by = array()){
			if(empty($this->table_name)){
				if(empty($table_name)){
					$this->logErrors("Invalid table name.");
				}else{
					if($this->tableExist($table_name)){
						$this->table_name = $table_name;
					}else{
						$this->logErrors("Invalid table name.");
					}
				}
			}
			try{
				$sql = "";
				if(is_array($columns_to_include)){
					if(count($columns_to_include) > 0){
						$colums = implode(", ",$columns_to_include);
						$sql = "SELECT $colums FROM `$this->table_name`";
					}else{
						$sql = "SELECT * FROM `$this->table_name`";
					}
				}else{
					$sql = "SELECT * FROM `$this->table_name`";
				}
				if(is_array($where_condition) && count($where_condition) > 0){
					$where_sql_string = "";
					$loop_count = 0;
					foreach($where_condition as $key => $value){
						if($loop_count == 0){
							$where_sql_string = " WHERE `$key` = '".$value."'";
						}else{
							$where_sql_string .= " And `$key` = '".$value."'";
						}
						$loop_count++;
					}
					$sql .= $where_sql_string;
				}
				
				if(is_array($order_by) && count($order_by) > 0){
					$order_by_string = "";
					$loop_count = 0;
					foreach($order_by as $key => $value){
						if($loop_count == 0){
							$order_by_string = " ORDER BY `$key` ".$value."";
						}else{
							$order_by_string .= " , `$key` ".$value."";
						}
						$loop_count++;
					}
					$sql .= $order_by_string;
				}
				
				if(intval($lower_limit) == 0 && intval($upper_limit) <= 0){
					
				}elseif(intval($lower_limit) > 0 && intval($upper_limit) <= 0){
					$sql .= " LIMIT ".$lower_limit."";
					
				}elseif(intval($lower_limit) >= 0 && intval($upper_limit) > 0){
					$sql .= " LIMIT ".$lower_limit.", ".$upper_limit."";
				}
				
				if(!empty($sql)){
					$this->current_run_sql = $sql;
					$unpaginated_result_count = count($this->executeQuery($sql));
					return $this->executeQuery($sql);
				}else{
					return array();
				}
			}catch(Exception $ex){
				$this->logErrors($ex->getMessage());
			}
		}
		
		/**
		 * This function loads all columns in the current table: 
		 * @return array 
		 *
		 * @access private
		 */
		private function getTableColumns(){
			try{
				if(!empty($this->table_name)){
					$sql = sprintf("SHOW COLUMNS FROM %s", $this->table_name);
					$result = $this->connection->query($sql);
					if((int)$result->num_rows > 0){
						$fieldlist =array();
						$counter=0;
						while($row=$result->fetch_object()){
							$fieldlist[$counter]=$row;
							$counter++;
						}
					}else{
						$fieldlist =array();
					}
					if(count($fieldlist) > 0){
						$this->current_run_sql = $sql;
						return $fieldlist;
					}else{
						return array();
					}
				}else{
					$this->logErrors("Table name not defined");
				}
			}catch(Exception $ex){
				$this->logErrors($ex->getMessage());
			}
		}
		
		/**
		 * This function checks if the table name exists, this function takes one parameter:
		 * $table_name: The table name to check
		 * @param string $table_name
		 * @return array 
		 *
		 * @access private
		 */
		private function tableExist($table_name){
			$table_check_sql = "SHOW TABLES LIKE '".$table_name."'";
			$results = $this->connection->query($table_check_sql);
			if($results->num_rows > 0){
				$this->current_run_sql = $table_check_sql;
				return true;
			}else{
				return false;
			}
		}
		
		/**
		 * This function populates an error array, this function takes one parameter:
		 * $error_message: The error messsage to log
		 * @param string $error_message
		 * @return null 
		 *
		 * @access private
		 */
		private function logErrors($error_message){
			if(strtolower($this->throw_exceptions) == "off"){
				array_push($this->error_log,$error_message);
			}else{
				throw new Exception($error_message);
			}
		}
		
		/**
		 * This function executes a valid SQL statement, this function takes one parameter:
		 * $sql: The sql statement to execute
		 * @param string $sql
		 * @return bool 
		 *
		 * @access public
		 */
		public function executeNonQuery($sql){
			try{
				$result = $this->connection->query($sql);
				return $result;
			}catch(Exception $ex){
				return false;
				$this->logErrors($ex->getMessage());
			} 
		}
		
		/**
		 * This function executes a valid SQL statement, this function takes one parameter:
		 * $sql: The sql statement to execute
		 * @param string $sql
		 * @return array 
		 *
		 * @access public
		 */
		public function executeQuery($sql){
			if($result = $this->connection->query($sql)){
				if((int)$result->num_rows > 0){
					$fieldlist =array();
					$counter=0;
					while($row=$result->fetch_object()){
						$fieldlist[$counter]=$row;
						$counter++;
					}
				}else{
					$fieldlist =array();
				}
				if(count($fieldlist) > 0){
					$this->current_run_sql = $sql;
					return $fieldlist;
				}else{
					return array();
				}
			}else{
				$this->logErrors("Error while processing query.");
			}
		}
		
		/**
		 * Get the value of a given column based on table name and where clause, this function takes three parameter:
		 * $sql: $table_name: The table to check in, this parameter is optional
		 * @param string $table_name
		 * @param string $column_name
		 * @param array $where_condition
		 * @return array 
		 *
		 * @access public
		 */
		public function getColumnValue($table_name = '', $column_name, $where_condition = array()){
			if(!empty($table_name)){
				if($this->tableExist($table_name)){
					$this->table_name = $table_name;
				}else{
					$this->logErrors("Invalid table name.");
				}
			}
			try{
				if(empty($column_name)){
					$this->logErrors("Invalid column name.");
				}else{
					if(is_array($where_condition) && count($where_condition)){
						$sql = "SELECT `$column_name` FROM `$this->table_name` WHERE ";
						
						
						$loopCount = 0;
			            foreach(array_keys($where_condition) as $key){
		                	$record = $where_condition[$key];
							if(!empty($record)){
							 	if($loopCount <= 0){
			                        $sql .= " `$key`="."'".addslashes($record)."'";
			                    }else {
			                        $sql .= " AND `$key`="."'".addslashes($record)."'";
			                    }
			                    $loopCount++;
							}else{
								continue;
							}
		                }
						
						
						if($result = $this->connection->query($sql)){
							if((int)$result->num_rows > 0){
								$row = $result->fetch_object();
								$row = (array)$row;
								return $row[$column_name];
							}else{
								return "";
							}
						}
					}else{
						$this->logErrors("Invalid WHERE clause parameter.");
					}
				}
			}catch(Exception $ex){
				$this->logErrors($ex->getMessage());
			}
		}
		
		
         /*custom method for the blog 	
		 * This function executes a valid SQL statement, this function takes one parameter:
		 * $: The sql statement to execute
		 * @param string $sql
		 * @return blog 
		 * @access public
		 */
		 
		 
		 
		 public function Twitter($hash_tag)
		 {
			
			$url = 'http://search.twitter.com/search.atom?q='.urlencode('#'.$hash_tag) ;
		    $ch = curl_init($url);
		    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, TRUE);
		    $xml = curl_exec ($ch);
		    curl_close ($ch);
		
		    $twelement = new SimpleXMLElement($xml);
		
		 }
		 

	
	public static function savecode($code){
		$crud = new Crud("codes");
		
		$data = array("id" => '', "code" => $code, "status_id" => '0');
		if ($crud->addNewRecord('codes',$data))
		{
			 //echo '1';
			 $response='Thank you';	
		}
		else
		{
			 //echo '0';
			 $response='not';	
		}
		

	}
	
}
		
	
