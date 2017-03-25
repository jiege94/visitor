<?php  
class ModuleController{
	protected $dsn='mysql:host=localhost;dbname=visitor';
	protected $username='root';
	protected $password='';
	public static $pdo;
	public function __construct(){
		if (is_null(self::$pdo)) {
			try{
				self::$pdo=new Pdo($this->dsn,$this->username,$this->password);
			}catch(Expection $e){
				die($e->getMessage());
			}
		}
	}
	#query
	public function query_sql($sql){
		try{
			self::$pdo->query("SET NAMES UTF8");
			self::$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);//设置抛出异常，报SQL语句的错
			$result=self::$pdo->query($sql);//返回一个对象
			$row=$result->fetchAll(PDO::FETCH_ASSOC);//得到索引数据
			return $row;
		}catch(Exception $e){
			die($e->getMessage());
		}
	}
	#add方法
	public function add($table,$data){
		try{
			// INSERT　INTO {$table} ({$keys}) VALUE ({$values});
			$keys=implode(',',array_keys($data));
			$values="'".implode("','", $data)."'";
			self::$pdo->query("SET NAMES UTF8");
			self::$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			$result=self::$pdo->exec("INSERT INTO {$table} ({$keys}) VALUES ({$values})");
			return $result;
		}catch(Exception $e){
			die($e->getMessage());
		}
	}
	#update
	public function update($table,$data,$id){
		try{
			//UPDATE student SET name='lucy',xuehao='0014' WHERE id=1;
			$sql='';
			foreach ($data as $k => $v) {
				$sql.=",$k='{$v}'";
			}
			$sql=substr($sql, 1);
			self::$pdo->query("SET NAMES UTF8");
			self::$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			$result=self::$pdo->exec("UPDATE {$table} SET {$sql} WHERE userid={$id}");
			return $result;
		}catch(Exception $e){
			die($e->getMessage());
		}
	}
	#delete
	public function delete($table,$id){
		try{
			//DELETE FROM student WHERE id=2
			self::$pdo->query("SET NAMES UTF8");
			self::$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			$result=self::$pdo->exec("DELETE FROM {$table} WHERE id={$id}");
			return $result;
		}catch(Exception $e){
			die($e->getMessage());
		}
	}
}
