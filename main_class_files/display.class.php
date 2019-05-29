<?php
#ExpressEdit 2.0
class display {
	private $tablename='user_data'; 
	private $database=Cfg::Db_user_db;
	private $tables=array();
	private $default_array=array('update_bots','show_all','reorder_id');#these radio buttons revert to false after submit


function __construct(){
	  set_time_limit(200);
	   ini_set('memory_limit','300M');
	   }	
function db_view(){
	   $display_arr=array();
	   $display=array();		
	   $where='';
	   $cols=array();
	    $mysqlinst = mysql::instance(); 
	   //$mysqlinst->dbconnect(Sys::Dbname);
	   $mysqlinst->dbconnect($this->database);
	   if (!isset($_POST['submitted'])) {
			 $users='url,OS,refer,ip,deltatime,ip_src,mode,country,region,city,continent,page,owner,date,month,day,edit,cookie_count,cookie_date,session_log_count';
			 $browser_arr=array('browser_name','browser_stock','browser_hidden','browser_channel','browser_mode','browser_version','browser_details','engine_name','engine_version','OS_name','device_type','device_identified','device_generic','camouflage','features');
			 $user_arr=explode(',',$users);
			 $owner=(Sys::Debug)?'':" owner='".Cfg::Owner."' AND ";
			 $q='select ';
			 foreach ($user_arr as $user){
				 $q.="u.$user,";
				 }
			 foreach ($browser_arr as $browser){
				 $q.="b.$browser,";
				 }
			 $q=substr_replace($q,'',-1);
			 $q.=" from user_data as u, browser_data as b where b.device_type!='bot' AND $owner admin='noadmin' AND b.device_type IS NOT NULL AND ( u.cookie_reference = b.cookie_reference
			 OR u.session_log_id = b.session_log_id )
			 ORDER BY u.id DESC
			 LIMIT 150";
			 echo $q;
			 echo NL."this gives the last 150 visitors further screened to remove bots with Niels Leenheer 'whichbrowser' database".NL;
			 $r = $mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
			$dis=1;
			$days=0;
			while ($rows = $mysqlinst->fetch_assoc($r,__LINE__)){
				foreach ($rows as $key => $row){
					$display[$key]=$row;
					}
				$display_arr[]=$display;
				 }
			printer::horiz_print($display_arr);
			if (!Sys::Debug)return;
			}//end if !submitted	 
		
	    
	$this->tables=check_data::get_tables($this->database);
	$columns=$mysqlinst->fetch_fields($this->tablename);
	$columns_str=implode(',',$columns);  
	foreach ($columns AS $name){
		$cols[$name]=true; #setup multi array so values can be updated with post!!
		} 
	$q="SELECT `SCHEMA_NAME`  FROM  information_schema.SCHEMATA";
	$r=$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	while($rows=$mysqlinst->fetch_row($r,__LINE__)){
		$dbases[]=$rows[0];
		}
	 
	$array =array(
			array(
			"name" =>$dbases,
			"value" =>false,
			"type" =>'dropdown' ,
			"selected" =>Cfg::Dbn_prefix.'user_data',
			"ref" => "database",
			"text1" =>'Select Your Database: ',
			"text2"=>''
			),
			array(
			"name" =>$this->tables,
			"value" =>false,
			"type" =>'dropdown' ,
			"selected" =>$this->tablename,
			"ref" => "tablename",
			"text1" =>'Select Your Table: ',
			"text2"=>''
			),  
			array(
			"name" => "query",
			"value" =>false,
			"type" =>'textarea' ,
			"rowlength" =>3,
			"columns" => 100,
			"text1" =>'Entire Query: ',
			"text2"=>''
			),
			array(
			"name" => "where",
			"value" =>'',
			"type" =>'textarea' ,
			"rowlength" =>3,
			"columns" => 100,
			"text1" =>'where/order by: ',
			"text2"=>'enter delimiter information'
			),
		array(
			"name" => $cols,
			"value" =>true,
			"type" =>'checkbox' ,
			"check" =>true,
			"ref" => 'fields',
			"text1" =>'Display:',
			"text2"=>''
			), 
		array(
		    "name" => "reorder_id",
		    "value" => false,
		    "type" =>'radio' ,
		    "show_size" =>'NA',
		    "maxlength" => 'NA',
		    "text1" =>'Reorder id ',
		    "text2"=>'Reorder'
		    ),
		array(
		    "name" => "update_bots",
		    "value" => false,
		    "type" =>'radio' ,
		    "show_size" =>'NA',
		    "maxlength" => 'NA',
		    "text1" =>'Update the bot list',
		    "text2"=>'Update Bots:'
		    ),
		array(
		    "name" => "show_all",
		    "value" => false,
		    "type" =>'radio' ,
		    "show_size" =>'NA',
		    "maxlength" => 'NA',
		    "text1" =>'Display all rows',
		    "text2"=>'display all'
		    )
		);  
	$checkbox_key=$array[4]['ref'];
	 #do this so one round of correct table gives the correct fields....
	if (isset($_POST['submitted'])) { //  echo NL.'post is  this one'; printer::horiz_print($_POST);   print_r($_POST);
		
/*	$fields = $_POST['fields']; 
if (is_array($fields)) { 
echo "<pre>";
print_r($fields);
echo "</pre>";
foreach ($fields as $key=>$val) {
echo "$key -> $val <br>";
}
$content = '<hr><br>';
$content = $content . count($fields); 
for ($i=0;$i<count($fields);$i++) { 
$content = $content . "<li>$fields[$i]\n"; 
} 
echo $content;
}
else echo $fields . ' is fields';*/
 
		
		list ($pass_arr,$array)=forms::form_process($array,$this->default_array);
		//echo "submitted pass array is "; printer::vert_print($pass_arr);
		foreach ($pass_arr AS $key=>$val){#note this will pass back $this->tablename
		    if (is_array($key))continue;//echo $key.' is key';
		    $this->$key=$val;
		    }
		if ($this->reorder_id)self::reorder();  
		if ($this->update_bots)self::update_bots();    
		$mysqlinst->dbconnect($this->database); 
		if (!empty($this->query)){ 
			
			if (strpos(strtolower($this->query),'select')!==false){
				$r=$mysqlinst->query($this->query,__METHOD__,__LINE__,__FILE__,false);
				while ($rows = $mysqlinst->fetch_assoc($r,__LINE__)){
					 printer::vert_print($rows);
					}
				}
			return;	
			} 
		$this->tables=check_data::get_tables($this->database);
		//echo NL.'post is'. printer::vert_print($_POST);
		$array[1]['name']=$this->tables;  //passed through now update for representation
		$cols=array();
		$columns=$mysqlinst->fetch_fields($this->tablename);
		$columns_str=implode(',',$columns);
		//echo "column string is $columns_str";
		#here's the meat of columns check  
		foreach ($columns AS $name){ #set value of col[#name] by checking whether passed with post col and selected with post field   if yes and no then false otherwise true
		    $cols[$name]=(isset($_POST['col'][$name])&&!(isset($_POST['fields'][$name])))?false:true; #setup multi array so values can be updated with post!!
		    }	    
		$count=count($cols); 
		#to limit the display
		 $array[4]['name']=$cols;#update the cols with new choice of tables...//passed through now update for representation
		 
		if ($this->tablename==$_POST['tablecheck']&&$columns_str==$_POST['columns_str'] ){#do not proceed further if tables hasn't caught up to db change
			$field_arr=array();
			$field_list='';  
			foreach ($pass_arr['fields'] AS $data=>$val){
				 if ($val){
					$field_list.=$data.',';
					$field_arr[]=$data;
					}
				}
			$count_limit=0;
			if (empty($this->where)){
				$q="SELECT count(".key($cols).") as countnum FROM $this->tablename ";
				 $r = $mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true); 
				$row = $mysqlinst->fetch_assoc($r);  
				$countit=$row['countnum'];
				$count_limit=($countit >500&&$this->show_all==false)?$countit-150:0;
				} 
			$field_list=substr_replace($field_list,'',-1);
			echo NL. $this->query. NL;
			if (empty($this->where))$this->where=" order by id desc limit 300";
			$q="SELECT $field_list  FROM $this->tablename $this->where";
			echo $q;
			$r = $mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
			$dis=1;
			$days=0;
			while ($rows = $mysqlinst->fetch_assoc($r,__LINE__)){
				$i=0; 
				$ctime=(isset($rows['date']))?$rows['date']:false; 
				if (!empty($ctime)){ 
					$ctime=substr($ctime,0,9);
					$totaldelay = time() - strtotime($ctime);
					if($totaldelay <= 0) mail::alert('time display problem');
					else{
						$days = $totaldelay / 86400;
						// echo NL. "days ago: $days";
						 $display['days ago'] =number_format($days,2);						 }
					}	
				foreach($field_arr AS $key){
					//$display[] =array($key=>$rows[$i]); //print_r($display);  works for vertical array
					 $display[$key] =$rows[$key]; //works for horizontal array  : use count limit to limit display
					 //if ($dis<2)echo NL. "$key equals $rows[$i] and index is $i"; 
					$i++;
					}
				 ($dis >$count_limit) &&$display_arr[]=$display;
				$dis++;
				// print_r($display_arr);
				}//end while
				//print_r($display_arr); 
		printer::horiz_print($display_arr); 
			}//end if table has caught up with database change
			printer::vert_print($_POST);
	
		}//end submitted	
	include ('includes/strictheader.nometa.php'); 
		
	echo '
	<link href="'.Cfg_loc::Root_dir.'program.css" rel="stylesheet" type="text/css" >  
	</head>
	<body>
	<div class="container">';
	printer::alert_neu('For additional database info enter new where statement, for present database, or browse databases and tables. You may also enter entire query. <br >You will need to process through twice for the database to select different db and tablename'); 
		
	forms::form_render($array,'','<p><input type="hidden" name="tablecheck" value="'.$this->tablename.'"></p>
				    <p><input type="hidden" name="columns_str" value="'.$columns_str.'"></p>');
	echo'
	<p class="ramana"><a href="db_files.php">Db List Files</a></p>';
	echo'
	</div>
	</body>                
	</html>';
	}//end function construct
	
function update_bots(){
	$usr=users::instance();
	$bot_arr=$usr->get('bot_array');
	printer::vert_print($bot_arr);  
	$mysqlinst = mysql::instance(); 
	$mysqlinst->dbconnect(Cfg::Db_user_db);
	$q="select id, OS from user_data where bot='nobot' order by id";
	$r = $mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
	$i=1;
	$bot='';
	while ($rows = $mysqlinst->fetch_assoc($r,__LINE__)){
		foreach ($bot_arr as $bot){
			if (strpos(strtolower($rows['OS']),$bot)!==false){
				$bot.=$bot;
				$q2="Update user_data set bot='$bot' where id=".$rows['id']; echo NL. $q2;
				$mysqlinst->query($q2,__METHOD__,__LINE__,__FILE__,false);
				}
			}
		}
	}
	
function reorder(){
	if ($this->tablename!=$_POST['tablecheck'])return;#if the dropdown hasn't caught up return;
	$mysqlinst = mysql::instance(); 
	$mysqlinst->dbconnect($this->database);
	$q="select id from $this->tablename order by id";
	$r = $mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
	$i=1;
	while ($rows = $mysqlinst->fetch_assoc($r,__LINE__)){
		$q2="Update $this->tablename set id=$i where id=".$rows['id']; 
		$mysqlinst->query($q2,__METHOD__,__LINE__,__FILE__,false);
		$i++;
		}
	}
	
###***************            id,OS,bot,owner,ip,time,mode,country,city,page,ip_src,region,continent,date,refer,ip_array,month,day,edit,Admin,timestamp,data4	 
function display_owner($days=30,$owner=Cfg::Owner){ 
	$sess=session::instance();  
	$whe="WHERE owner = '$owner' and edit='noedit' and Admin='noAdmin' and bot='nobot'  and ip !=''";
	if (isset($_POST['days'])&&is_numeric($_POST['days'])){
		$days=$_POST['days'];
		}
	$gbl=new global_master('return');#return for object use of functions
	$java=new javascript('plus','print'); 
	$userPages=array();
	$userDistinct=array();
	$display=array(); 
	$month='';
	$day='';
	$mysqlinst=mysql::instance();
	$mysqlinst->dbconnect(Cfg::Db_user_db);
	include ('includes/strictheader.nometa.php'); 
	echo $java->javascript_return;	
	echo ' 
	 <style type="text/css">
	   dl,li,dt,dd,h1,h2,h3,h4,h5,h6,pre,form,body,html,p,blockquote, input {margin: 0; padding: 0;}
	p{color: #000; text-align: center; font-family: "verdana", arial, sans-serif;}

	  body, textarea { background:#eee;}
	  p{text-align: left;}
	  .clear {clear: both;}
	.container {width: 1000px; margin:0 auto;}
	.title{font-size: 1.4em; text-align:center;padding-bottom:30px;}
	.frequent{font-size:1.1em;}
	.unique {font-size: 1.2em; width: 450px; float:left;}
	.unique span {color:#d00d44}
	.pages{color:#CE0DA4; }
	.float {float: left; width:90px; padding-top: 120px;}
	.containgraph{ float:left; width: 620px;}
	.datadisplay {margin:0 auto; width: 800px;}
	.containallgraphs {margin: 0 auto; width: 750px;}
	.graphbig {font-size:1.1em; text-align:center; font-weight:700; color:#102f16;}
	.graph {font-size:.8em; text-align:center;  color:#1f5a2a; padding-bottom:40px;}
	 .graph span  {color:#B63EA0;}
	.date{color:#ccc;font-size:1.1em;}
	.small {font-size:.7em}
	.floatleft {float:left; width: 300px; padding-top: 30px;padding-left:20px;}
	</style>
	 </head>
	<body>
	<div class="container">';
	$input='<p class="ramana">Change Current no. of days to view Visitors: <input type="text" size="3" maxlength="3" name="days" value="'.$days.'" ></p>';
	forms::form_open();
	forms::form_close($input,'change days');
	echo '<p class="title">In the past '.$days.' days you\'ve had the following visits: </p>';
	$tabs=1;
	for ($d=$days;$d>=1;$d--){
		// echo NL.NL."no of days is $d";
		$q="SELECT count(ip) as count  from $this->tablename $whe and timestamp < ".(time()-(($d-1) * 86400))." and timestamp > ".(time()-(($d)  * 86400));  
		 
		$r = $mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
		$row  = $mysqlinst->fetch_assoc($r,__LINE__);
		 //echo "no. of pages is ".$row['count'];
		$userPages[$d]=$row['count'];  
		  
		$q2="SELECT count(Distinct ip) as count2  from $this->tablename $whe and timestamp < ".(time()-(($d-1) * 86400))." and timestamp > ".(time()-(($d)  * 86400));  
		$r2 = $mysqlinst->query($q2,__METHOD__,__LINE__,__FILE__,false);
		$row2  = $mysqlinst->fetch_assoc($r2,__LINE__);  
		$userDistinct[$d]=$row2['count2'];
		}
	 //echo 'user page array is ';print_r($userPages);exit();
	 
	$countPages=array_sum($userPages);
	$countUsers=array_sum($userDistinct);
	$grh= new graph();	
	$grh->generate($userPages,'graph'.$sess->token);	 
	$grh->generate($userDistinct,'graph'.$sess->token);
	echo '
	<div class="containallgraphs">
	<p class="graphbig float">Total # of Page Visits</p>
	<div class="containgraph">';
	$gbl->render_img('graph'.$sess->token.'1.png');
	echo'<p class="graphbig">Days Ago</p> 
	 <p class="graph">The <span>total page visits</span> by all visitors to your site during the past '.$days.' days is '.$countPages.'</p>
	 </div>';
	 printer::pclear();
	 echo'<p class="graphbig float"># of Unique Users</p>
	 <div class="containgraph">';
	$gbl->render_img('graph'.$sess->token.'2.png');
	echo  '<p class="graphbig">Days Ago</p> 
	 <p class="graph">Total number of <span> individual unique visitors</span> to your website during the past '.$days.' days is '.$countUsers.'</p> 
	</div>';
	printer::pclear();
	echo'</div>';
	echo '<div class="datadisplay">';
	$where="$whe and timestamp > ".(time()-($days  * 86400));
	$q="truncate temp_data"; 
	$r = $mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
	$q="SELECT DISTINCT ip  from $this->tablename $where";
	$r = $mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false); 
	$i=1;
	while ($rows = $mysqlinst->fetch_assoc($r,__LINE__)){
		$q2="INSERT INTO temp_data(ip,data4) SELECT ip, count('ip') as ipcount from $this->tablename $where and ip='".$rows['ip']."'";#add extra  time check to watch for out of data ip's	 
		$mysqlinst->query($q2,__METHOD__,__LINE__,__FILE__,false);
		$i++;
		}
		 
	$q4="select ip,data4 from temp_data order by data4 desc";  #data 4 is number of visits...
	$r4=$mysqlinst->query($q4,__METHOD__,__LINE__,__FILE__,false);
	echo '<p class="frequent">Below is a detailed list of the visitors location, the no. of pages visited, and pages visited:</p>';
	 
	while ($row4=$mysqlinst->fetch_assoc($r4,__LINE__)){
		$q5="select ip,refer,OS,country, city, continent, page,region,date,month,day,getdate from $this->tablename $where and ip='".$row4['ip']."' order by month, day";
		$r5=$mysqlinst->query($q5,__METHOD__,__LINE__,__FILE__,false);
	 	$i=1; 
		//$q6="create temporary table display_it select date, page, month, day from user_data";
		//$r6=$mysqlinst->query($q6,__LINE__,false);
		while ($rows5=$mysqlinst->fetch_assoc($r5,__LINE__)){
			if ($i==1&&!empty($rows5['city'])){echo NL.NL. '<p class="unique"><span>This user visited your site '.$row4['data4'].' times:</span>  <br> city: '.$rows5['city']; if (!empty($rows5['region'])) echo '<br> region: '.$rows5['region'];
			echo'<br> country: '.$rows5['country'].'</p>';
				echo'<div class="floatleft">';
				$gbl->plus_mod('Click + for tech details');
				echo '<p class="unique">ip address: '.$rows5['ip'].'<br> using browser/OS : '.$rows5['OS'].'<br>continent: '.$rows5['continent'];
				if (!empty($rows5['getdate']))echo '<br>More Date/Time data: '.$rows5['getdate'];
				echo'</p></div></div>';
				printer::divclear();
				}
					 
			if (!empty($rows5['refer'])&&$rows5['refer']!='unk'&&strpos($rows5['refer'],Cfg::Owner)===false){
				echo '<p class="website">Site from which Visitor Linked to Your Page:<br> <a href="'.str_replace('&','&amp;',$rows5['refer']).'">'.str_replace('&','&amp;',$rows5['refer']).'</a></p>';
				}
			if ($month!=$rows5['month']||$day!=$rows5['day']){
				$month=$rows5['month'];
				$day=$rows5['day']; 
				echo '<p class="pages">On  '.substr($rows5['date'],0,9).' the follow pages were visited:</p>';
				}
			$page=str_replace('index','HomePage',$rows5['page']);	
			 echo $page.'&nbsp;&nbsp;';
			 $i++;
			}
		 
			//$q7='insert into display_it (date, page, month, day) values ('.substr($rows5['date'],0,9).','.$rows5['page'].','.$rows5['month'].','.$rows5['day'].')';	 
			//$mysqlinst->query($q7,__LINE__,false);
			 
		 
		}
	echo'
	</div>
	</div>
	</body>
	</html>';
	if (is_file($sess->token.'1.png')) unlink($sess->token.'1.png');
	if (is_file($sess->token.'2.png')) unlink($sess->token.'1.png');
	
		/*	 while ($rows = $mysqlinst->fetch_assoc($r,__LINE__)){
		$display_arr=array();
		$ip=$rows['ip']; 
		$buffer[]= NL.NL. '<p class="uniqe">A unique user (ip: '.$rows['ip'].' city: '.$rows['city'].'. region: '.$rows['region'].' country: '.$rows['country'].') visited your site as follows:</p>';
		$q2="select page, refer, page, date, OS,ip from user_data $where and ip = '$ip'";	 
		$r2 = $mysqlinst->query($q2,__METHOD__,__LINE__,__FILE__,true);
		$i=0;
		while ($rows2 = $mysqlinst->fetch_assoc($r2,__LINE__)){
			$i++;
			$display['On this date:']= $rows2['date'];
			$display['Visiting this Page:']= $rows2['page'];
			$display['Coming from this page:']= ($rows2['refer']=='unk')?'':$rows2['refer'];
			$display['Using this browser:']= ($rows2['OS']=='unk')?'':$rows2['OS'];
			$display['Ip:']= $rows2['ip'];
			$buffer[]=$display;
			} 
		printer::horiz_print($display_arr);
		
		$q="select id,date from $this->tablename";
	$r = $mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	while ($rows = $mysqlinst->fetch_assoc($r,__LINE__)){
		$q2="update $this->tablename set timestamp='".strtotime(substr($rows['date'],0,9))."' where id='".$rows['id']."'";  echo NL.$q2;
		 $mysqlinst->query($q2,__METHOD__,__LINE__,__FILE__,true);
		}}*/
	}//end display_owner 

 
	 
 }//end class
	 
 ?>