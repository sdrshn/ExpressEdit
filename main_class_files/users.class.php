<?php
#ExpressEdit 3.01
class users extends server {
	private static $instance=false; //store instance
	protected $OS='unk';
	protected $refer='';
	protected $bot='';
	protected $deltatime='unk';
	public $ip='unk';
	protected $ip_src='unk';
	protected $ip_array='unk';
	protected $mode='normal';
	protected $country='unk';
	protected $country_code3='unk';
	protected $region='unk'; 
	protected $city='unk';
	protected $getdate='';
	protected $continent='unk';
	protected $timestamp='unk';#change to seconds
	protected $http_accept='unk';
	private $bot_array=array('freedictionary','findlinks','funwebproducts','facebook','bing','yahoo','spider','crawler','bot');
	private $db_fields='url,OS,refer,bot,ip,deltatime,ip_src,ip_array,mode,country,region,city,continent,page,owner,date,getdate,month,day,edit,admin,timestamp,http_accept,delta_log,cookie_count,cookie_date,cookie_reference,session_log_count,session_log_id,browser_info';
	protected $return_vars=array();  
	private $edit='noedit';#edit will be changed in in __destruct
	private $delta_log='unk';
	protected $diff_time_check=1.3;
	public $cookie_count='0';
	public $cookie_date='0';  
	public $cookie_reference='0';
	public $session_log_count=0;
	public $session_log_id=0;
	public $browser_info=false;
	public $diff_request_ini='';
function __construct(){  
	$this->deltatimeinst=time::instance();
	$this->return_vars['remote_array']=array();
	if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	parent::__construct();  
	self::gen_user_dat();
	}

 function gen_user_dat(){#date count
     //ini_set('memory_limit','500M');
      $this->timestamp=time(); 
	if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	if (isset($_SERVER['HTTP_USER_AGENT'])){
		$this->OS=$_SERVER['HTTP_USER_AGENT'];
		}
	else $this->OS='user agent not found';	
	if (isset($_SERVER['HTTP_REFERER'])){
		$this->refer=$_SERVER['HTTP_REFERER'];
		}
	if (isset($_SERVER['HTTP_ACCEPT'])){
		$this->http_accept=$_SERVER['HTTP_ACCEPT'];#change to $this->accept...
		}	
	 $this->url=request::return_full_url();
	$this->ip=(Sys::Web)?$this->ip:'local';
	#check for bluehost
	$this->ip_src=(array_key_exists(0,$this->remote_addr_src))?$this->remote_addr_src[0]:'unk';
	$this->ip_array=arrayhandler::implodeMDA($this->remote_array);
	$this->mode=$this->mode;
	$this->owner=Cfg::Owner;
	$this->page=str_replace('.php','',substr_replace(Sys::Self,'',0,1));
	$this->getdate='local time of user@@@'. arrayhandler::implodeAssoc(getdate()).'@@@ and standardized time @@@'.arrayhandler::implodeAssoc(getdate(time()));  
	$this->date=date("dMY-H-i-s");
	$this->month=date("m");
	$this->day=date("d");
     if (!function_exists('mb_internal_encoding')||!extension_loaded('mbstring')) {
          $msg=('Enable mbstring module in your apache server for user lookup info');
          printer::alert_neg($msg);
          mail::alert_min($msg);
          return;
          }
     if (!empty($this->ip)){
          $loader=new fullloader(); 
           $loader->fullpath('geoipcity.php');
          $loader->fullpath('geoipregionvars.php');
		 if (is_file(Cfg_loc::Root_dir."includes/GeoLiteCity.dat"))  
			 $gi = geoip_open(Cfg_loc::Root_dir."includes/GeoLiteCity.dat",GEOIP_STANDARD);
		 elseif (is_file(Sys::Two_up."includes/GeoLiteCity.dat")) 
               $gi = geoip_open(Sys::Two_up."includes/GeoLiteCity.dat",GEOIP_STANDARD);
           elseif (is_file(Sys::One_up."includes/GeoLiteCity.dat")) 
               $gi = geoip_open(Sys::One_up."includes/GeoLiteCity.dat",GEOIP_STANDARD);
          elseif (defined('PATHINC')&&is_file(PATHINC."includes/GeoLiteCity.dat"))
               $gi = geoip_open(PATHINC."includes/GeoLiteCity.dat",GEOIP_STANDARD);
             else  $gi = geoip_open("includes/GeoLiteCity.dat",GEOIP_STANDARD);
          $record =geoip_record_by_addr($gi,$this->ip);
		$this->country_code3=(!empty($record->country_code3))?$record->country_code3:$this->country_code3;
		$this->country=(!empty($record->country_name))?$record->country_name:'unknown';
		$this->region=(!empty($record->region))?$record->region:$this->region;
		$this->city=(!empty($record->city))?$record->city:$this->city;
		$this->continent=(!empty( $record->continent_code))?$record->continent_code:'unkown'; 
		geoip_close($gi); 
		}    
	}
	
function user_info (){ 
	$info="the users Identifying info  Operating System and Browser is :=>$this->OS \n  ip: $this->ip"; 
	$info.= "country: ". $this->country_code3." city: " .$this->city;  
	return $info;
	}
 
public static function instance(){ if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);//static allows it to create an instance without creating a new object
     if  (empty(self::$instance)) {
          self::$instance = new users(); 
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

public function put($reference,$vname){
    $vname=trim($vname);
    $this->$vname=$reference;
    }

function delta_log($log){
	$this->delta_log=$log;
	}
}//end class
?>