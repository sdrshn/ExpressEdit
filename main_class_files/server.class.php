<?php
#ExpressEdit 2.0.3
class server{
# ~ ~ ~ ~ ~ ~ ~  Orig class source unknown
    # mode true => return any remote addresses found
    #     false => stop as soon as an address is found
	const Concat = true;
	const Dbg =false;
	private     $private_domains = array(
          array('0.0.0.0','2.255.255.255'),
          array('10.0.0.0','10.255.255.255'),
          array('127.0.0.0','127.255.255.255'),
          array('169.254.0.0','169.254.255.255'),
          array('172.16.0.0','172.31.255.255'),
          array('192.0.2.0','192.0.2.255'),
          array('192.168.0.0','192.168.255.255'),
          array('255.255.255.0','255.255.255.255'),
          );
	private    $vars = array(
        'HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED_FOR',
        'HTTP_X_FORWARDED',
        'HTTP_X_CLUSTER_CLIENT_IP',
        'HTTP_FORWARDED_FOR',
        'HTTP_FORWARDED',
        'REMOTE_ADDR',
        );
	
	protected $remote_addr_src = array();
	protected $remote_addr = array();
	protected $remote_addr_list = array();
	protected $remote_array=array();
	protected $mode='';

public function __construct() {
	if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
	foreach($this->vars as $var) {
		$this->dbg('new',"checking $var");
		if (isset($_SERVER[$var])) {
			$this->dbg('new', "$var = ".$_SERVER[$var]);
			# if no commmas, we get array[0] entry
			$lst = explode(',',$_SERVER[$var]);
			foreach($lst as $xip) {
				$this->dbg('new',"Server.new $var: $xip");
				if ($this->checkIP($var,trim($xip))) {
					$this->remote_addr_list[] = $xip;
					}
				} # end.for($lst)
			}
		} # end.for($vars)
     if (count($this->remote_addr_list)>1){
          $this->mode.='multi';
          }
     if (empty($this->mode))$this->mode='normal';
	} # Server.new()

private function checkIP($src,$ip) {
	if (Sys::Methods) Sys::Debug(__LINE__,__FILE__,__METHOD__);
     if (empty($ip) || ip2long($ip)==-1 || !ip2long($ip)==true) {
          return false;
          }
     $this->dbg(__FUNCTION__,sprintf("checkIP %s[ %s ]",$src,$ip));
     # return false if the ip is in a private domain
     foreach ($this->private_domains as $adx) {
          $min = ip2long($adx[0]);
          $max = ip2long($adx[1]);
          if ((ip2long($ip) >= $min) && (ip2long($ip) <= $max)){
			$this->mode.='priv-'.$ip.'-';
			return false;
			}
          }
     # record this ip and src
	$this->remote_array[$src]=$ip;  
	$this->remote_addr_src[] = $src;
	$this->remote_addr[] = $ip;
	if (count($this->remote_addr)==1)$this->ip=$ip;   
	return true;
     } # Server.checkIP()
 
public function dbg($who,$what) {
     if (self::Dbg) {
          echo sprintf('%s : %s'.NL,str_replace('::','.',$who),$what);
          }
     } # Server.dbg()
 
 public function render() {
    $ii = __METHOD__;
    $msgs =  array(
        'adx' => 'remote_addr = \'%s\'',
        'src' => 'remote_addr_src = \'%s\'',
        'lst' => 'remote_addr_list = \'%s\'',
        );
     echo sprintf($msgs['adx'],implode(',',$this->remote_addr)).NL;
     echo sprintf($msgs['src'],implode(',',$this->remote_addr_src)).NL;
     echo sprintf($msgs['lst'],implode(';',$this->remote_addr_list)).NL;
     } # Server.display()
 
} # Server.class
?>