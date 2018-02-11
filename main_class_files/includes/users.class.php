<?php
class users extends server {
	
	 private $ROBOT_USER_AGENTS= array (//http://www.monperrus.net/martin/list+of+robot+user+agents
// note that this is meant to be used in a case-insensitive setup

/**** THE BIG THREE ********/
'googlebot\/',        /* Google see http://www.google.com/bot.html              */
'Googlebot-Mobile',
'Googlebot-Image',
'bingbot',            /* Microsoft Bing, see http://www.bing.com/bingbot.htm   */
'slurp',              /* Yahoo, see http://help.yahoo.com/help/us/ysearch/slurp */

/**** Home grown ********/
'java', 
'wget',
'curl',
'Commons-HttpClient',
'Python-urllib',
'libwww',
'httpunit',
'nutch',
'phpcrawl',           /* added 2012-09/17, see http://phpcrawl.cuab.de/ */

/** The others */
'msnbot',             /* see http://search.msn.com/msnbot.htm   */
'Adidxbot',           /* see http://onlinehelp.microsoft.com/en-us/bing/hh204496.aspx */
'blekkobot',          /* see http://blekko.com/about/blekkobot */
'teoma', 
'ia_archiver',
'GingerCrawler',
'webmon ',            /* the space is required so as not to match webmoney */
'httrack',
'webcrawler',
'FAST-WebCrawler',
'FAST Enterprise Crawler',
'convera',
'biglotron',
'grub.org',
'UsineNouvelleCrawler',
'antibot',
'netresearchserver',
'speedy',
'fluffy',
'jyxobot',
'bibnum.bnf',
'findlink',
'exabot',
'gigabot',
'msrbot',
'seekbot',
'ngbot',
'panscient',
'yacybot',
'AISearchBot',
'IOI',
'ips-agent',
'tagoobot',
'MJ12bot',
'dotbot',
'woriobot',
'yanga',
'buzzbot',
'mlbot',
'yandex', 
'purebot',            /* added 2010/01/19  */
'Linguee Bot',        /* added 2010/01/26, see http://www.linguee.com/bot */
'Voyager',            /* added 2010/02/01, see http://www.kosmix.com/crawler.html */
'CyberPatrol',        /* added 2010/02/11, see http://www.cyberpatrol.com/cyberpatrolcrawler.asp */
'voilabot',           /* added 2010/05/18 */
'baiduspider',        /* added 2010/07/15, see http://www.baidu.jp/spider/ */
'citeseerxbot',       /* added 2010/07/17 */
'spbot',              /* added 2010/07/31, see http://www.seoprofiler.com/bot */
'twengabot',          /* added 2010/08/03, see http://www.twenga.com/bot.html */
'postrank',           /* added 2010/08/03, see http://www.postrank.com */
'turnitinbot',        /* added 2010/09/26, see http://www.turnitin.com */
'scribdbot',          /* added 2010/09/28, see http://www.scribd.com */
'page2rss',           /* added 2010/10/07, see http://www.page2rss.com */
'sitebot',            /* added 2010/12/15, see http://www.sitebot.org */
'linkdex',            /* added 2011/01/06, see http://www.linkdex.com */
'ezooms',             /* added 2011/04/27, see http://www.phpbb.com/community/viewtopic.php?f=64&t=935605&start=450#p12948289 */
'dotbot',             /* added 2011/04/27 */
'mail\\.ru',          /* added 2011/04/27 */
'discobot',           /* added 2011/05/03, see http://discoveryengine.com/discobot.html */
'heritrix',           /* added 2011/06/21, see http://crawler.archive.org/ */
'findthatfile',       /* added 2011/06/21, see http://www.findthatfile.com/ */
'europarchive.org',   /* added 2011/06/21, see  http://www.europarchive.org/ */
'NerdByNature.Bot',   /* added 2011/07/12, see http://www.nerdbynature.net/bot*/
'sistrix crawler',    /* added 2011/08/02 */
'ahrefsbot',          /* added 2011/08/28 */
'Aboundex',           /* added 2011/09/28, see http://www.aboundex.com/crawler/ */
'domaincrawler',      /* added 2011/10/21 */
'wbsearchbot',        /* added 2011/12/21, see http://www.warebay.com/bot.html */
'summify',            /* added 2012/01/04, see http://summify.com */
'ccbot',              /* added 2012/02/05, see http://www.commoncrawl.org/bot.html */
'edisterbot',         /* added 2012/02/25 */
'seznambot',          /* added 2012/03/14 */
'ec2linkfinder',      /* added 2012/03/22 */
'gslfbot',            /* added 2012/04/03 */
'aihitbot',           /* added 2012/04/16 */
'intelium_bot',       /* added 2012/05/07 */
'facebookexternalhit',/* added 2012/05/07 */
'yeti',               /* added 2012/05/07 */
'RetrevoPageAnalyzer',/* added 2012/05/07 */
'lb-spider',          /* added 2012/05/07 */
'sogou',              /* added 2012/05/13, see http://www.sogou.com/docs/help/webmasters.htm#07 */
'lssbot',             /* added 2012/05/15 */ 
'careerbot',          /* added 2012/05/23, see http://www.career-x.de/bot.html */
'wotbox',             /* added 2012/06/12, see http://www.wotbox.com */
'wocbot',             /* added 2012/07/25, see http://www.wocodi.com/crawler */
'ichiro',             /* added 2012/08/28, see http://help.goo.ne.jp/help/article/1142 */
'DuckDuckBot',        /* added 2012/09/19, see http://duckduckgo.com/duckduckbot.html */
'lssrocketcrawler',   /* added 2012/09/24 */
'drupact',            /* added 2012/09/27, see http://www.arocom.de/drupact */
'webcompanycrawler',  /* added 2012/10/03 */
'acoonbot',           /* added 2012/10/07, see http://www.acoon.de/robot.asp */  
'openindexspider',    /* added 2012/10/26, see http://www.openindex.io/en/webmasters/spider.html */
'gnam gnam spider',   /* added 2012/10/31 */
'web-archive-net.com.bot', /* added 2012/11/12*/
'backlinkcrawler',    /* added 2013/01/04 */
'coccoc',             /* added 2013/01/04, see http://help.coccoc.vn/ */
'integromedb',        /* added 2013/01/10, see http://www.integromedb.org/Crawler */
'content crawler spider',/* added 2013/01/11 */
'toplistbot',         /* added 2013/02/05 */
'seokicks-robot',     /* added 2013/02/25 */
'it2media-domain-crawler',      /* added 2013/03/12 */
'ip-web-crawler.com', /* added 2013/03/22 */
'siteexplorer.info',  /* added 2013/05/01 */
'elisabot',           /* added 2013/06/27 */
'proximic',           /* added 2013/09/12, see http://www.proximic.com/info/spider.php */
'changedetection',    /* added 2013/09/13, see http://www.changedetection.com/bot.html */
'blexbot',            /* added 2013/10/03, see http://webmeup-crawler.com/ */
'arabot',             /* added 2013/10/09 */
'WeSEE:Search',       /* added 2013/11/18 */
'niki-bot'            /* added 2014/01/01 */
);
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
     
	//modified june12 17 
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
	foreach ($this->bot_array as $bot){
		if (strpos(strtolower($this->OS),$bot)!==false){
			$this->bot.=$bot;
			}
		}
	foreach ($this->ROBOT_USER_AGENTS as $bot){
	    $bot=strtolower($bot);
	   $OS=strtolower($this->OS);
	   if (preg_match("/$bot/",$OS)==true){
		//if (strpos(strtolower($this->OS),$bot)!==false){
			$this->bot.=$bot;  
			}
		}
	(empty($this->bot))&&$this->bot='nobot';	
	if (isset($_SERVER['HTTP_REFERER'])){
		$this->refer=$_SERVER['HTTP_REFERER'];
		}
	if (isset($_SERVER['HTTP_ACCEPT'])){
		$this->http_accept=$_SERVER['HTTP_ACCEPT'];#change to $this->accept...
		}	
	$this->admin= (Sys::Logged_in&&Sys::AdminOn)?'admin/logged':((Sys::Logged_in)?'logged_in':((Sys::AdminOn)?'admin':'noadmin'));
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
      //echo NL.__line__." not real: ".(memory_get_peak_usage(false)/1024/1024)." MiB\n";
 // echo NL.__line__." real: ".(memory_get_peak_usage(true)/1024/1024)." MiB\n\n";
	
     if (!function_exists('mb_internal_encoding')||!extension_loaded('mbstring')) {
          
          $msg=('Enable mbstring module in your apache server for user lookup info');
          printer::alert_neg($msg);
          mail::alert_min($msg);
          return;
          }
      
	if (!empty($this->ip)){ 
		  if (is_file(Cfg_loc::Root_dir."includes/geoipcity.php"))
			   include_once(Cfg_loc::Root_dir."includes/geoipcity.php");
		  else  include_once("includes/geoipcity.php");
		   if (is_file(Cfg_loc::Root_dir."includes/geoipregionvars.php"))
			   include_once("includes/geoipregionvars.php"); 
		  else include_once("includes/geoipregionvars.php");
		  if (is_file(Cfg_loc::Root_dir."includes/GeoLiteCity.dat"))  
			   $gi = geoip_open(Cfg_loc::Root_dir."includes/GeoLiteCity.dat",GEOIP_STANDARD);
		  else $gi = geoip_open(Sys::Base_dir."includes/GeoLiteCity.dat",GEOIP_STANDARD);
		$record =geoip_record_by_addr($gi,$this->ip);
		$this->country_code3=(!empty($record->country_code3))?$record->country_code3:$this->country_code3;
		$this->country=(!empty($record->country_name))?$record->country_name:'unknown';
		$this->region=(!empty($record->region))?$record->region:$this->region;
		$this->city=(!empty($record->city))?$record->city:$this->city;
		$this->continent=(!empty( $record->continent_code))?$record->continent_code:'unkown'; 
		geoip_close($gi); 
		}   
	if ($this->edit=='edit'&&$this->bot!='nobot')mail::alert('BOT INFILTRATION IN EDIT','BOT INFILTRATION in EDIT');
	
	}
	
function user_info (){ 
	$info="the users Identifying info  Operating System and Browser is :=>$this->OS \n  ip: $this->ip"; 
		$info.= "country: ". $this->country_code3." city: " .$this->city;  
	return $info;
	}
	
	
	
	
 function gen_data_base(){ return;  
	if (empty($this->deltatimeinst)){ 
		mail::alert ('delta time not intitiated in users class');
		}
	else{
		$this->deltatime=$this->deltatimeinst->delta();//runs after the ip lookup and geo locate to gage time;
		}
	#if ($this->edit=='noedit'&&$this->deltatime>3)
	 //($this->deltatime>Cfg::Timecheck)&&mail::alert2($this->delta_log,'time: '.$this->deltatime);
	 //($this->diff_request_ini>$this->diff_time_check)&&mail::alert2($this->delta_log,'difftime: '.$this->diff_time_check);
	($this->edit=='edit'&&$this->bot!='nobot')&&mail::alert($this->user_info(),'editpage bot access alert');
	if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	$db_vals='';
	$db_fields=explode(',',$this->db_fields);  
	$mysqlinst = mysql::instance();
	$mysqlinst->dbconnect(Cfg::Db_traffic_db); 
	foreach ($db_fields AS $var){ 
		$db_vals.="'".$mysqlinst->escape($this->$var)."',"; 
		}
	$db_vals=substr_replace($db_vals,'',-1); 
	$table=($this->bot=='nobot')?Cfg::Db_traffic_table:'bot_data'; 
	$q="INSERT into  $table ($this->db_fields)Values($db_vals)";   
	 //    mail::alert ($q 'endhere');    // if ($this->ip=='198.57.214.62')echo $q;
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	$mysqlinst->dbconnect(Cfg::Db_traffic_db_master);
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	$mysqlinst->dbconnect(Sys::Dbname);
	}
 function create_user_db(){
	$columns='';
	$mysqlinst = mysql::instance();
	$mysqlinst->dbconnect(Cfg::Db_traffic_db,Cfg::Db_traffic_username,Db_traffic_pass); 
	 
	$q="Drop Table ".Cfg::Db_traffic_table;  
	$mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,true);
	$mysqlinst->dbconnect(Cfg::Db_traffic_db);
	$dbnames=explode(',',$this->db_fields);
	 foreach ($dbnames AS $vars){
		$columns.="$vars tinytext,";
		}
	$q="CREATE TABLE   ".Cfg::Db_traffic_table." (
	id int(11) unsigned NOT NULL AUTO_INCREMENT,"
	.$columns.
	  " PRIMARY KEY (id)
   ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 "; echo $q;
	 $mysqlinst->query($q,__METHOD__,__LINE__,__FILE__,false);
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