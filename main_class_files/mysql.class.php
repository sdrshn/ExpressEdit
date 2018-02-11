<?php 
class mysql {  //master for add page pic core    //add is my first oop class and is largely unnecessary as perhaps $q could have been simply passed!
    private static $instance=false; //store instance  

  

function dbconnect($dbname=Sys::Dbname,$Dbuser='',$Dbpass=Cfg::Dbpass) {  
    $Dbuser=(empty($Dbuser))?Cfg::Dbuser:$Dbuser;
    if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$this->dbname=$dbname;
	 $this->link=mysqli_connect(Cfg::Dbhost,$Dbuser,$Dbpass, $dbname); 
	return $this->link;
   } 

 function escape($value){
	$value = mysqli_real_escape_string($this->link, $value);
	return $value;
	}
 
 function dbconnect_no_db($Dbuser='',$Dbpass=Cfg::Dbpass) {  if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
    $Dbuser=(empty($Dbuser))?Cfg::Dbuser:$Dbuser;
	 $this->link=mysqli_connect('localhost',$Dbuser,$Dbpass); #make general connection to create database.... 
	 return $this->link;
   } 

function prepare($query){
	return $this->link->prepare($query);
	}
public function select_db($dbname){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
    $this->dbname=$dbname;
    if (Sys::Debug)echo "\n<br>". "made it to select_db  the db   is $dbname....";           
    $selected=$this->link->select_db($dbname);
    return $selected;
    }

public function create ($dbname){
	$sql="create database $dbname";
	 $r=self::query($sql);
	 return $r;
	}

static function restoreDB($path, $db_file, $dbname,  $user, $pass,$mysql_path=Sys::Mysqlserver, $host='localhost'){
	system("$mysql_path mysql -h$host -u$user -p$pass $dbname  <  $path$db_file");
	}
	
static function backupDB($path, $db_file, $dbname,  $user, $pass,$mysql_path=Sys::Mysqlserver, $host='localhost'){
	system("$mysql_path mysqldump -h $host -u $user -p $pass $dbname  >  $path$db_file");
	}
 
	// system(Sys::Mysqlserver."mysqldump -h ".Cfg::Dbhost." -u ".Cfg::Dbuser." -p".Cfg::Dbpass." $dbname > ".Sys::Pub.$respathbackupfile);
	  
public function permissions ($db, $user, $pass,$line=__LINE__){
    $db_selected =  self::select_db($db);  
    if (!$db_selected) {
	   echo 'not selected';
	   self::create($db);  
	   }
    $q='grant usage on *.* to '.$user."@localhost identified by '$pass'"; echo 'usage granted';
    self::query($q,$line);
    $q='grant all privileges on *.*  to '. $user.'@localhost';
    self::query($q,$line);  echo 'privelidge granted';
    }
	
public function dropdatabase($db,$line=''){
    $db_selected =  self::select_db($db); 
    if (!$db_selected) { echo  $db .' not detected';
	   return;
	   }
    $q="drop database $db";
    self::query($q,$line);
    echo NL. $db. ' has been deleted';  
    }
#query   
public function query($q,$method='',$line='',$file='',$affected=false){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
     // if (strpos($q,'update')!==false&&strpos($q,'gall_ref')!==false)exit("$q is q and line is $line and method is $method and file is $file and db is ".Sys::Dbname);
    //if (strpos($q,'delete')!==false)echo $q;
    //if (strpos($q,'update')!==false)echo $q;
     if (Sys::Refreshoff){//for viewing when submitting with redirecting. header redirecting updates styling following submit
          if (Sys::Edit&&strpos(strtolower(substr($q,0,10)),'select')===false){
                if (!isset($_SESSION[Cfg::Owner.'QUERY']))$_SESSION[Cfg::Owner.'QUERY']=array();
                $_SESSION[Cfg::Owner.'QUERY'][]=array('Query'=>$q,'Method'=>$method,'Line'=>$line,'File'=>$file);
                }
           elseif(Sys::Edit){
                if (!isset($_SESSION[Cfg::Owner.'QUERY_select']))$_SESSION[Cfg::Owner.'QUERY_select']=array();
                $_SESSION[Cfg::Owner.'QUERY_select'][]=array('Query'=>$q,'Method'=>$method,'Line'=>$line,'File'=>$file);
                }
          }
    if (Sys::Mysql||Sys::Debug)echo $q;//  {if (strpos(strtolower($q),'delete'))echo NL.'q: '.$q.' *** '.$method.$line.$file;  }
    $r=$this->link->query($q);//if (strpos(strtolower($q),'update'))echo NL.'q: '.$q.' *** '.$method.$line.$file;  
      if (!$affected){return $r;}
    (!empty($method))&&$method="  method: $method";
    (!empty($file))&&$file="  file: $file";
    (!empty($line))&&$line="  line: $line";
    $check=$this->affected_rows();
    if (empty($check)){
	   mail::alert('No affected rows in '.Sys::Self." using query $q in $this->dbname".NL. "info.: $method $line $file");
	   if (Sys::Debug)echo '<p style="font-weight: bold; color: #'.Cfg::RedAlert_color.';font_size: 1.4em;">No affected rows in '.Sys::Self.' using '.$q.' in '.$this->dbname.NL. $file.$line.'</p>';
	   }
	 return $r;
      }
   
public function select($table,$columns='*',$where=false){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
    if(Sys::Debug)echo "\n<br>". '<br>made it to select function  ';
    $q='SELECT '
            .(is_array($columns) ? implode(',',$columns):$columns)
            .' FROM '
            .$table
            .($where ? ' WHERE '.$where:';');
    if (Sys::Debug)echo "\n<br>". $q;
    return  $this->query($q);				 
    } 
          
public function affected_rows($line='',$method=''){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
    $check=$this->link->affected_rows;
    if ($check<1){
	   $check=false;
	   }
    else {
	   $check=true;
	   }
    
   // if (Sys::Mysql) echo NL. 'affected rows call and affect rows is: '.$check. ' at line: '.$line .' in method: '.$method;
    return $check;
    }
           
public function num_rows($r){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
    return $r->num_rows;
    }
    
public function fetch_assoc($r,$line='',$method=''){  
    if (Sys::Debug) echo NL.'fetch assoc';
    //elseif (Sys::Mysql) echo NL. 'fetch assoc';
    $check=$this->link->affected_rows;
    if ($check<1){
	   return false;
	   }
    else  
    return  $r->fetch_assoc();
    }

public function fetch_row($r,$line='',$method=''){ //echo $line.' is line and meth is '.$method;
    if (Sys::Debug) echo NL.'fetch_row';
   // elseif (Sys::Mysql) echo NL. 'fetch row';
     $check=$this->link->affected_rows;
    if ($check<1){  
	   return false;
	   }
    else return	 $r->fetch_row();
    }
    
function fetch_fields($tablename){
	$this->cols=array();
	$q="select  * from $tablename";
	if ($r = self::query($q)) {
		/* Get field information for all columns */
		 $finfo = $r->fetch_fields();
		 foreach ($finfo as $val) {
			 $this->cols[]= $val->name;
			 }
		$r->close();
		 } 
	 $this->field_count=count($this->cols);  
	 return $this->cols;
	 }

function drop_tables($db,$echo=false){
    self::dbconnect($db);#do this to create dbase if not exists
    $q="SHOW TABLES";
    $r=$this->query($q,__LINE__,false);

    While($rows=$this->fetch_row($r,__LINE__)){ 
	    $q="DROP TABLE $rows[0]";
	    if ($echo)echo $q;
	    $this->query($q,__LINE__,false);
	    }
    }

function table_exists ($table, $db) { 
	$tables = mysql_list_tables ($db); 
	while (list ($temp) = mysql_fetch_array ($tables)) {
		if ($temp == $table) {
			return TRUE;
		}
	}
	return FALSE;
}

public function mysqli_real_escape($value){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
    mysqli_real_escape_string($this->link, $value);
    }
    
function double_connect($db1, $db2, $q){ if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	if (Sys::Debug) echo Sys::Debug(__LINE__,__FILE__,__METHOD__);   
     $this->dbconnect($db1);  
    $this->link = $this->dbconnect($db2);
    $this->query($q);
    if (Sys::Debug)echo "<br>\n this is q ...$q";        
    }// end function add all

function add_all($new_add_array, $q) {if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
    $this->add_array=$new_add_array;
    foreach ($this->add_array  as $this->var){if (Sys::Debug) echo "<p style=\"font-size: 1.3em; color: green;\">   $q     $this->dbname</p>";
    $this->build_update($this->var, $q); }  
    }// end function add all

function build_update($var,$q,$line='',$alert=true) {if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);// takes q directly or from add_all
    $this->dbconnect($var);
    if  (Sys::Debug) echo " <br>\n q=$q <br> dbase=$var...";
    $r=$this->query($q,$line,$alert);
    // $check=$this->affected_rows();
	//if ($check<0){
	//// $message=array();
	// $message[]="Failure in mysql build update  using $var with $q";
	//// $success=array();
	 
		//  $mail->mailwebmaster($success, $message);
	//  echo '<p style="font-weight: bold; font-size: 1.4em; color: #C00">Update failure using '. $var.'
	//  </p>';
	// }
	 
    }//end build update


function build_query($q) {// takes q directly or from add_all
        if  (Sys::Debug) echo " <br>\n q=$q <br> dbase=$this->dbname...";
    $r=$this->query($q);
    
    if (Sys::Mysql) echo NL. 'build_query '. $q;
    if (!$this->affected_rows()){
	 $message=array();
	 $message[]="Failure in mysql build update  using $var with $q";
	 $success=array();
	 $mail= new mail;
		  $mail->mailwebmaster($success, $message);
	  echo '<p style="font-weight: bold; font-size: 1.4em; color: #C00">Update failure using '. $this->dbname.'
	  </p>';
	 }
	 return $r;
    }//end build query
    
function count_field($tablename, $field='pic_order',$dbname='',$unequal=false,$where='',$echo=false) {;if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
   if (!empty($dbname)){  
	   $this-> dbconnect($dbname);
	   }
    $q="SELECT MAX(".$field.") as fieldmax,  COUNT(".$field.") AS countnum FROM $tablename $where";   if(Sys::Count)echo $q; 
    if (Sys::Debug)echo NL. 'count field: '.$q;
    if ($echo)echo NL. 'count field: '.$q;
    //if (Sys::Mysql) echo $q;
    $rxx = $this->query($q,'',false);
     $check=$this->affected_rows();
	if (empty($check)){
		$this->field_inc=$this->pic_ord=0;
		$this->fieldmax=0;
		$this->countnum=0;
		return 0;
		}
    $row = $this->fetch_assoc($rxx); if (Sys::Debug)echo 'field max is '.$row['fieldmax']. "and count is ".$row['countnum'];
    $row['fieldmax']=(empty($row['fieldmax'])||!is_numeric($row['fieldmax'])) ? 0:$row['fieldmax'];
    if ($unequal===true&&$row['countnum'] != $row['fieldmax']) {
	   $msg=NL.'unequal maxnumber and no. of pics in '.$tablename .NL .' field max is '.$row['fieldmax']. "and count is ".$row['countnum'];
	   if (Sys::Debug) echo $msg;
	   mail::error($msg); 
	  }
     $this->field_inc=$row['fieldmax']+1;  
    $this->pic_ord=$row['fieldmax']+1;
    $this->fieldmax=$row['fieldmax'];
    $this->countnum=$row['countnum'];
    //echo "count field q= $q  pic ord= $this->pic_ord";
    return  $this->countnum;
     }//end function count_pics       

public function count_it($table,$where=false,$column='*'){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);//not using this
    $q=$this->select($table,'COUNT('.$column.')',$where);  
    if (Sys::Mysql) echo $q;
    $q=$this->fetch_row($q);
    return (int)$q[0];
    }
    
 public function close(){if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
               return @mysqli_close($this->link);
           }
		 
 
public static function  instance(){ //static allows it to create an instance without creating a new object
    
    if  (empty(self::$instance)) {
	   self::$instance = new mysql(); 
        } 
    return self::$instance; 
    }  
function get($vname){ 
	$vname=trim($vname);
	if  (isset($this->$vname)){
		return $this->$vname;
		}
	$msg="the var: $vname does not exist in ".__FILE__;	
	  mail::error($msg,$vname.'problem');
	   
	}


    			  //begin unused and untested
        /*   private function mysqli_errno(){
               return  @mysqli_errno($this->link);
           }
            
           private function mysqli_error(){
               return @mysqli_error($this->link);
           }
           
        
         
           public function fetch_object($query=false){
                  return @mysqli_fetch_object($query?$query:$this->lastQuery);
           }
           
        
           
           public function free($query=false){
               return @mysqli_free_result($query?$query:$this->lastQuery);
           }
	
          
           
		    public function error($msg){
                echo  $msg.' '.$this->mysqli_errno().' : '.$this->mysqli_error();
           } 
			 function field_exists($field, $table)
            {
                $query = $this->query("
                    SHOW COLUMNS 
                    FROM {$table} 
                    LIKE '{$field}'
                ");
                $exists = $this->num_rows($query);
                
                if($exists > 0)
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
			
			function table_exists($table)
            {   
                $query = $this->query("
                    SHOW TABLES 
                    LIKE '{$table}'
                ");
                $exists = $this->num_rows($query);
                if($exists > 0)
                {
                    return true;
                }
                else                   
                {
                    return false;
                }
            }
           function drop_table($tableName){
              return $this->query('DROP TABLE '.$tableName);
           }
           
           function drop_fields($tableName,$fieldNames){
                 return $this->query('ALTER TABLE '.$tableName.' drop ('.(is_array($fieldNames)?implode(',',$fieldNames) :$fieldNames).')');
           }
		*/
		//end unused and untested
}// end class
?>
