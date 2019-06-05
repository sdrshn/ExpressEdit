<?php
#ExpressEdit 2.0
class render_html{
     private $allow_array=array('karma','ekarasa','imagine');// array of owner names to cache...
     private $return='dbeditmode,mia,editmode,submitted,w,returnedit,render_return';
   
function __construct($page,$return_request=''){return;
     if (!empty($_SERVER["QUERY_STRING"]))return;
     $return_request=(empty($return_request))?Cfg::Check_request:$return_request;
     $return_arr=explode(',',$this->return);
     $return_arr2=explode(',',$return_request);
     $return_arr3=array_merge($return_arr,$return_arr2);
     foreach ($return_arr3 as $re){  
          if (isset($_REQUEST[$re])){return;}//imagine homepage sizing
          }
     if(isset($_SESSION[Cfg::Owner.'adminOn'])||$_SESSION[Cfg::Owner.'logged_in'])return;
     include('includes/time.class.php');
     $this->deltatime=time::instance();
     $this->deltatime->delta_log('render_html initiate');
     if (!isset($_SESSION))session_start();  
     if(strpos($_SERVER['PHP_SELF'],'testsite')!==false)return;
     include ('includes/Cfg_master.class.php');
     if (is_file('includes/Cfg.class.php'))include ('includes/Cfg.class.php');
     else return; 
     include ('includes/Cfg_loc.class.php');  
     include ('includes/request.class.php'); 
     if (Cfg_loc::Domain_extension!='')return;
     $return=true;
     foreach ($this->allow_array as $owner){  
          if(Cfg::Owner==$owner) $return=false;  
          }
     if ($return)return;
     $get_file='backupversions/'.$page.'.php';  
     if (file_exists($get_file)){ 
         $render=file_get_contents($get_file);  
          if (isset($_REQUEST['cache']))echo 'true';
          echo $render;
          include_once('Sys.php'); 
          $usr=users::instance();
          $usr->delta_log($this->deltatime->return_delta_log());
          $usr->diff_request_ini=$this->deltatime->diff_request_ini;
          $usr->gen_data_base();
          $usr->gen_data_base();
          exit();
          }
     else {
          $addresses=explode(',',Cfg::Admin_email);
          foreach ($addresses as $address){
               if (!mail($address,'backup file not found','backup file not found'. $get_file)) 
                    echo 'backup file not found: '.$get_file;
               }
          }
     $my_message='error redirected in render_html'.'<br> line is '. __LINE__.' file is '.__FILE__.' method is '.__METHOD__.' self: '.$_SERVER['PHP_SELF'] ;
     if (!strpos($_SERVER['DOCUMENT_ROOT'],'var')) {
         $addresses=explode(',',Cfg::Admin_email);
         foreach ($addresses as $address){
               mail($address,'error message', $my_message);
               }
          }
     else echo '<p class="red large">'.$my_message.'</p>'; 
     }//end function

}
 
?>