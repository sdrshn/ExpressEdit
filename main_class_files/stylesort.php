
<html><head><title>Style Sort</title>
<style>
body {background:black; color:white;}
.border{border: 5px  solid   orange; margin: 30px 0}
</style>
	</head><body>
<?php
#ExpressEdit 2.0
include('includes/Sys.php');
$ownerdir='karma/';
$table=Cfg::Master_post_table;
$id=68903;
$field='blog_data3,blog_data4,blog_data5,blog_data6,blog_data7';
$field_arr=explode(',',$field);
$mysqlinst = mysql::instance();
$mysqlinst->dbconnect('vwpkbpmy_karmawebsite'); 
foreach ($field_arr as $field){
	echo '<div class="border">';
$q="select $field from $table where blog_id=$id ";
echo $q;
$r=$mysqlinst->query($q);
list($styles)=$mysqlinst->fetch_row($r);
printer::alert_neg( "Begin Render for field $field ");

echo $styles;
$style_array=explode(',',$styles);
$indexes=explode(',',Cfg::Style_functions);
	foreach($indexes as $key =>$index){
		if (!empty($index)) {
			${$index.'_index'}=$key;
			  //print NL.  $index." = $key"; 
			}
		}

for ($i=0; $i < count($indexes); $i++){
     echo NL."{$indexes[$i]} value: {$style_array[$i]}";
     }
$background_styles=explode(',',Cfg::Background_styles);
$background_value_array=explode('@@',$style_array[$background_index]);

for ($i=0; $i<count($background_styles); $i++){ 
     echo NL."{$background_styles[$i]} value: {$background_value_array[$i]}";
	
     }
 	foreach($background_styles as $key =>$index){
		if (!empty($index)) {
			${$index.'_index'}=$key;
			   //print NL.  $index." = $key"; 
			}
		}
	
echo NL.NL.
'<img src="'.$ownerdir.Cfg::Background_image_dir.$background_value_array[$background_image_index].'"  width="75">';
echo  $background_value_array[$background_image_index].'</div>';
	}//end foreach $field
?>
</body><html>