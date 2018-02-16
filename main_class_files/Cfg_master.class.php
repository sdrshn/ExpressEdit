<?php
/*
ExpressEdit is an integrated Theme Creation CMS
	Copyright (c) 2018  Brian Hayes expressedit.org  

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <https://www.gnu.org/licenses/>.*/
class Cfg_master {
	const View_db='ekarasac_viewdb';
	const Spacings_off=true;
	const Debug_backtrace=true;
	const Override=true;//set to true to override common file overwrites  ie custom gallery prev next navigation images etc.
	const Error_exit=true;//false for production may be true for development exits on non fatal errors .       const Local_site='htdocs,localhost';//use comma separated of more than one development system. to determine whether local development system or production environment  may be changed in local Cfg files also
	const Test_site_dir=null; //not used anymore..  
	const Session_save_path='session_XaByzrt5';//customize a  session save path directory .. may be specified in local Cfg.class.php  use no special characters
	const Mysqlserver='';//dir can be manually configured here if not auto detected which may affect backups..   ie  ='C:/xampp/mysql/bin  on xampp windows default settings where the entire path needs to be specified for mysqldump backups
	const Prevent_default=0;//for debugging only
     const Timecheck=2; //if more than 2 seconds to render a page then a alert email is sent. Usually happens with search engines over doing it
	#******Database Info**************
   //const Restrict=true;  //set to true to emulate logging in for live server on your devlopement system.  set to false to bypass logging in for edit pages and other restricted files  affects the local system only
     const Admin_key='sedreplace';
     const Time_zone='America/New_York';
     const Secure_session=false;
	const Local_site='htdocs,localhost';//use comma separated of more than one development system. to determine whether local development system or production environment  may be changed in local Cfg files also
     const Dbhost = 'localhost'; 
     const Dbase_update='ekarasawebsite,florencewebsite,imaginewebsite,karmawebsite';//for development only
     const Hello = 'hello world';
     const Fonts_browser='Arial, Helvetica, sans-serif; Arial Black, Gadget, sans-serif; Constantia, cambria, sans-serif; Comic Sans MS, Comic Sans MS5, cursive; Courier New, monospace; Georgia1, Georgia, serif; Helvetica, sans-serif; Impact, Impact5, Charcoal6, sans-serif; Lucida Console, Monaco5, monospace; Lucida Sans Unicode, Lucida Grande, sans-serif; Palatino Linotype, Book Antiqua3, Palatino, serif; Tahoma, Geneva, sans-serif; Times New Roman, Times New Roman, Times, serif; Trebuchet MS1, Trebuchet MS, sans-serif; Verdana, Verdana, Geneva, sans-serif';
     const Fonts_extended='Questrial, sans-serif;Nova Slim, cursive;Cabin, sans-serif;Julee, cursive;Macondo Swash Caps, cursive;Michroma, sans-serif;Give You Glory, cursive;Delius Swash Caps, cursive;Bad Script, cursive;Sofia, cursive;Eagle Lake, cursive;Kite One, sans-serif;Contrail One, cursive;Paprika, cursive;Redressed, cursive;Shadows Into Light, cursive;Josefin Slab, serif;Antic, sans-serif;Nothing You Could Do, cursive;Indie Flower, cursive;Delius, cursive;Amaranth, sans-serif;Over the Rainbow, cursive;Aubrey, cursive;Text Me One, sans-serif;Cinzel Decorative, cursive;Shadows Into Light Two, cursive;Comfortaa, cursive;Handlee, cursive;Oxygen, sans-serif;Basic, sans-serif;Ruluko, sans-serif;Chivo, sans-serif;Architects Daughter, cursive;Merienda, cursive;Diplomata SC, cursive;Cedarville Cursive, cursive;Numans, sans-serif;Happy Monkey, cursive;Sintony, sans-serif';
     const Preg_color='/^([a-f]|[A-F]|[0-9]){3}(([a-f]|[A-F]|[0-9]){3})?$/';
     const Preg_email='/^[\w.-]+@[\w.-]+\.[A-Za-z]{2,6}$/';
     const Horiz_nav_class='horiz_nav';
     const Vert_nav_class='vert_nav';//for styling 
     const Style=true; 
     const Wordwrap=100; //set line length for emails
	const Temp_ext='temp_passclass_ext';
     //const Master_pass=''; 
     #***************************
     #Colors  You can change the value of color on the editor value at top Page Configs
     #You can independently change colors and color order for light and dark themes in the editor
     const Pos_color='64C91D';// success color  and column level 1 color
     const RedAlert_color='c82c1d';//alert messages  often a problem
     const Info_color='e5d805'; //information hover and instructional message.. etc.
     const Brown_color='816227';
     const Maroon_color='800000';
     const Yellow_color='FFFF00';
     const Aqua_color='00ffff';
     const Magenta_color='ff00ff';
     const Brightgreen_color='00ff00';
     const Orange_color='ff6600';
     const Ek_blue_color='0075a0';
     const Blue_color='1DBAC9';
     const Navy_color='2B1DC9';
     const White_color='ffffff';
     const Black_color='000000';
     const Green_color='266a2e';
	const Purple_color='800080';
	const Cherry_color='C91B45';
	const darkgrey='a9a9a9';
	const darkkhaki='bdb76b';
	const darkmagenta='8b008b';
	const darkolivegreen='556b2f';
	const darkorange='ff8c00';
	const darkorchid='9932cc';
	const darkred='8b0000';
	const darksalmon='e9967a';
	const darkseagreen='8fbc8f';
	const darkslateblue='483d8b';
	const darkslategray='2f4f4f';
	const darkturquoise='00ced1';
	const darkviolet='9400d3';
	const deeppink='ff1493';
	const deepskyblue='00bfff';
	const dimgray='696969';
	const dimgrey='696969';
	const dodgerblue='1e90ff';
	const firebrick='b22222';
	const floralwhite='fffaf0';
	const forestgreen='228b22';
	const fuchsia='ff00ff';
	const gainsboro='dcdcdc';
	const moccasin='ffe4b5';
	const navajowhite='ffdead'; 
	const oldlace='fdf5e6';
	const olive='808000';
	const olivedrab='6b8e23'; 
	const orangered='ff4500';
	const orchid='da70d6';
	const palegoldenrod='eee8aa';
	const palegreen='98fb98';
	const paleturquoise='afeeee';
	const palevioletred='d87093';
	const papayawhip='ffefd5';
	const peachpuff='ffdab9';
	const peru='cd853f';
	const plum='dda0dd';
	const powderblue='b0e0e6'; 
	const rosybrown='bc8f8f';
	const royalblue='4169e1';
	const saddlebrown='8b4513';
	const salmon='fa8072';
	const sandybrown='f4a460';
	const seagreen='2e8b57'; 

 
	#the order of these text editor colors and border colors corresponds to the column level.. top colors used much  more frequently
	##  DO NOT CHANGE ORDER HERE OR VALUES WILL BE MIXED..  CHANGE ORDER IN EDITOR UNDER CONFIG THIS PAGE AT TOP
	const Light_editor_color_order='pos,cherry,navy,brightgreen,maroon,aqua,magenta,orange,ekblue,brown,green,yellow,darkgrey,darkkhaki,darkmagenta,darkolivegreen,darkorange,darkorchid,darkred,darksalmon,darkseagreen,darkslateblue,darkslategray,darkturquoise,darkviolet,deeppink,deepskyblue,dimgray,dimgrey,dodgerblue,firebrick,floralwhite,forestgreen,fuchsia,gainsboro,moccasin,navajowhite,oldlace,olive,olivedrab,orangered,orchid,palegoldenrod,palegreen,paleturquoise,palevioletred,papayawhip,peachpuff,peru,plum,powderblue,rosybrown,royalblue,saddlebrown,salmon,sandybrown,seagreen,black,white,info,redAlert';
	##   YOU CAN  CHANGE ORDER IN EDITOR UNDER CONFIG THIS PAGE AT TOP or change here as needed and be sure to query database to remove values: UPDATE `master_page` SET page_dark_editor_order='',page_light_editor_order='',page_dark_editor_value='',page_light_editor_value='' which will then auto-generate if you change order at least once. change order of both light and dark to save auto generate time everytime...
	const Dark_editor_color_order='pos,aqua,brightgreen,yellow,paleturquoise,moccasin,palegreen,ekblue,orange,navy,magenta,maroon,brown,green,darkgrey,darkkhaki,darkmagenta,darkolivegreen,darkorange,darkorchid,darkred,darksalmon,darkseagreen,darkslateblue,darkslategray,darkturquoise,darkviolet,deeppink,deepskyblue,dimgray,dimgrey,dodgerblue,firebrick,floralwhite,forestgreen,fuchsia,gainsboro,navajowhite,oldlace,olive,olivedrab,orangered,orchid,palegoldenrod,palevioletred,papayawhip,peachpuff,peru,plum,powderblue,rosybrown,royalblue,saddlebrown,salmon,sandybrown,seagreen,cherry,black,white,info,redAlert';//these colors are arranged for lighter to go with darker background
	//note: color names much match respective global_master  class  names
	//const Full_color_index='info,pos, redAlert ,cherry,aqua,brightgreen,yellow,ekblue,orange,navy,magenta,maroon,brown,green';
	#************************ 
     const Edit_font_size='1'; 
	const Edit_font_family='Helvetica=> sans-serif';
	const Secure_mode=false;
     const Container_style='background_inner'; //field being used for container style
     const Body_style='background';  //Filed being use for body style
    #database  tables
     const Dbn_nav='directory';
     //const Directory_table='directory';
	const Backups_table='backups_db';
     const Db_traffic_table='user_data';
     const Master_post_table='master_post';
     const Master_page_table='master_page';
     const Master_gall_table='master_gall';
     const Master_post_css_table='master_post_css';
     const Master_post_data_table='master_post_data';
     const Master_col_css_table='master_col_css';
     const Restore_table_backup='gallery_temp_restore';
     const Setup_table='setupmaster';#used in addgallery pic to generate new tables
     const Columns_table='columns';
	const Comment_table='comments';
	#rwd defaults
	const Default_min_width=70;
	const Default_bounce_width=150;
	const Default_width_mode='maxwidth';
	const Db_tables='columns,comments,directory,master_col_css,master_gall,master_page,master_post,master_post_css,master_post_data';

     #Fields
     const Col_fields='col_table_base,col_table,col_num,col_options,col_status,col_grid_clone,col_gridspace_right,col_gridspace_left,col_grid_width,col_tcol_num,col_primary,col_clone_target,col_clone_target_base,col_style,col_temp,col_grp_bor_style,col_comment_style,col_comment_date_style,col_comment_view_style,col_date_style,col_width,col_hr';
     const Col_fields_all='col_table_base,col_table,col_num,col_options,col_status,col_grid_clone,col_gridspace_right,col_gridspace_left,col_grid_width,col_tcol_num,col_primary,col_clone_target,col_clone_target_base,col_style,col_temp,col_grp_bor_style,col_comment_style,col_date_style,col_comment_view_style,col_comment_date_style,col_width,col_hr,col_update,col_time,token';
     const Col_css_fields='col_options,col_gridspace_right,col_gridspace_left,col_grid_width,col_grid_clone,col_style,col_grp_bor_style,col_comment_style,col_date_style,col_comment_date_style,col_comment_view_style,col_width';
	const Gallery_fields='master_gall_status,master_table_ref,master_gall_ref,gall_ref,gall_table,pic_order,picname,imagetitle,description,subtitle,width,height,galleryname,temp_pic_order,reset_id';
     const Post_fields='blog_clone_table,blog_col,blog_order,blog_type,blog_table,blog_gridspace_right,blog_gridspace_left,blog_grid_width,blog_data1,blog_data2,blog_data3,blog_data4,blog_data5,blog_data6,blog_data7,blog_data8,blog_data9,blog_data10,blog_tiny_data1,blog_tiny_data2,blog_tiny_data3,blog_tiny_data4,blog_tiny_data5,blog_tiny_data6,blog_tiny_data7,blog_tiny_data8,blog_tiny_data9,blog_tiny_data10,blog_grid_clone,blog_style,blog_table_base,blog_text,blog_border_start,blog_border_stop,blog_global_style,blog_date,blog_width,blog_height,blog_alt_rwd,blog_status,blog_unstatus,blog_clone_target,blog_target_table_base,blog_float,blog_unclone,blog_pub,blog_tag,blog_temp,blog_options';
     const Page_fields='page_ref,page_title,page_filename,page_width,page_pic_quality,page_style,page_options,page_break_points,page_cache,page_light_editor_value,page_dark_editor_value,page_dark_editor_order,page_light_editor_order,page_comment_style,page_date_style,page_comment_view_style,page_comment_date_style,page_style_day,page_style_month,page_grp_bor_style,page_link,keywords,metadescription,page_data1,page_data2,page_data3,page_data4,use_tags,page_hr,page_h1,page_h2,page_h3,page_h4,page_h5,page_h6,page_myclass1,page_myclass2,page_myclass3,page_myclass4,page_myclass5,page_myclass6,page_myclass7,page_myclass8,page_myclass9,page_myclass10,page_myclass11,page_myclass12,page_clipboard';
	const Page_fields_all='page_ref,page_title,page_filename,page_width,page_pic_quality,page_style,page_options,page_break_points,page_cache,page_light_editor_value,page_dark_editor_value,page_dark_editor_order,page_light_editor_order,page_comment_style,page_date_style,page_comment_view_style,page_comment_date_style,page_style_day,page_style_month,page_grp_bor_style,page_link,keywords,metadescription,page_data1,page_data2,page_data3,page_data4,use_tags,page_hr,page_h1,page_h2,page_h3,page_h4,page_h5,page_h6,page_myclass1,page_myclass2,page_myclass3,page_myclass4,page_myclass5,page_myclass6,page_myclass7,page_myclass8,page_myclass9,page_myclass10,page_myclass11,page_myclass12,page_clipboard,page_update,page_time,token';
	const Dir_fields='dir_menu_id,dir_menu_style,dir_menu_order,dir_sub_menu_order,dir_filename,dir_title,dir_ref,dir_gall_table,dir_blog_table,dir_menu_type,dir_is_gall,dir_gall_type,dir_menu_opts,dir_hide_sub_menu,dir_external,dir_internal,dir_temp,dir_temp2';
     const Css_fields='blog_pub,blog_order,blog_table,blog_style,blog_float,blog_width,blog_height,blog_alt_rwd,blog_data1,blog_data2,blog_data3,blog_data4,blog_data5,blog_data6,blog_data7,blog_tiny_data1,blog_tiny_data2';
	const Comment_fields='com_blog_id,com_text,com_name,com_email,com_token,com_status';
    #indexes
     const Background_styles='background_color,background_gradient_type,background_gradient_color1,background_gradient_color2,background_gradient_color3,background_gradient_color4,background_gradient_color5,background_gradient_color6,background_gradient_transparency1,background_gradient_transparency2,background_gradient_transparency3,background_gradient_transparency4,background_gradient_transparency5,background_gradient_transparency6,background_gradient_color_stop1,background_gradient_color_stop2,background_gradient_color_stop3,background_gradient_color_stop4,background_gradient_color_stop5,background_gradient_color_stop6,background_gradient_position_keyword,background_gradient_position1,background_gradient_position2,background_image,background_image_use,background_repeat,background_horiz,background_vert,background_opacity,background_size,background_pos_width,background_pos_height,background_image_opacity,background_fixed,background_image_none,background_image_noresize,background_video,background_video_ratio,background_video_display';
     const Style_functions=',padding_top,padding_bottom,padding_left,padding_right,margin_top,margin_bottom,margin_left,margin_right,font_family,font_size,font_weight,text_align,font_color,italics_font,small_caps,line_height,letter_spacing,text_underline,width_special,background,radius_corner,columns,text_shadow,box_shadow,transform,borders,height_style,custom_style,outlines,float,margin_left_percent,margin_right_percent,width_max_special,width_min_special,width_percent_special,padding_left_percent,padding_right_percent,left,right,top,bottom';
     const Style_functions_order='background,padding_top,padding_bottom,padding_left,padding_right,margin_top,margin_bottom,margin_left,margin_right,padding_left_percent,padding_right_percent,margin_left_percent,margin_right_percent,font_color,text_shadow,font_family,font_size,font_weight,text_align,line_height,letter_spacing,italics_font,small_caps,text_underline,radius_corner,borders,box_shadow,outlines,columns,transform';
	const Page_options='page_editor_choice,page_darkeditor_background,page_darkeditor_color,page_lighteditor_background,page_lighteditor_color,page_date_format,page_max_expand_image,page_editor_fontfamily,page_editor_fontsize,page_slideshow,page_width_mode,page_min_width,page_bounce_width,page_image_quality,page_backup_copies,page_advanced';
	const Image_options='width_limit,image_noexpand,image_max_expand,image_quality,image_noresize,image_min,height_set';//accessed global edit &  add_page_pic 
     const Blog_options='blog_comment,blog_comment_display,blog_editor_use,blog_date_on,blog_date_format,blog_pad_unit,blog_mar_unit,blog_break_points,blog_vert_pos,blog_media_minmax,blog_display_on_off,blog_media_px';
	const Column_options='column_tag_display,column_float_calc,column_use_grid,column_grid_units,column_break_points,column_vert_pos,column_media_minmax,column_display_on_off,column_media_px,column_pad_unit,column_mar_unit';//break points last as may contain commas
	const Box_shadow_options='shadowbox_horiz_offset,shadowbox_vert_offset,shadowbox_blur_radius,shadowbox_spread_radius,shadowbox_color,shadowbox_insideout';
	const Alt_rwd_options='blog_width_mode,blog_min_width,blog_bounce_width';
	const Backup_copies=200;//change  in page_default settings
	const Column_grid_units=100;
	const Column_break_points='1000,768,600';
	const Development=false;//for javascript alert on ajax imagecall and build image and image resize messages on editpage..
     #prefixes  suffixes  extenisons
     const Edit_gall_ext='';
     const Exts='htm,html,asp';
     const Backup_ext_folder='backupversions/';
     const Param_css_append='_col_css';
     const Post_css_append='_post_css';
     const Post_suffix='_post_id';
     const Post_prefix='post_';
     const Blog_prefix='blog_';//for fields
     const Col_prefix='col_';
	const Page_prefix='page_';
     //const Gall_ref_ext='data';
     const Expand_ref_ext='expand';
     #Files  and file extensions
     const Log_file='mylog.txt';
     const Db_ext='.sql';
     const Aux_scripts='add_page_pic,add_page_vid';//like to prevent return link when editing
     //const Table_suffix='data,highslide,expand,_thumbs';
     const Request_pass='';
     const Exclude='jpgraph,tinymce-Orig,1downloaded internet files,fvd suite,zen cart,secure apache ssl,.,..,$recycle.bin,system volume information,temp,phplist,compress,zen,phpMyAdmin,phpsite,ellen,design,css,create,arthur,attachment,highslide,fonts,langs,plugins,themes,utils,graphics,tmp,cgi-bin,forum,zen,wordpress,tinymce,tiny-mce';#these files are excluded from search and other generation programs
     const Skip_it='data,expand,undo_temp,gallery_storage,gallery_temp_restore,setupmaster';#setupmaster used in gallery setup table creation
    const Test_site='false';
     #pdf
     const Valid_pdf_mime='application/pdf,application/acrobat,application/x-pdf,applications/vnd.pdf,text/pdf,text/x-pdf';
     const Pdf_max=15000000;
	const Pass_class_page='passclass.php';
	const Expand_pass_page='expand-passclass.php';
      #directories-non Image or Vid
     const Menu_icon_dir='menu_icons/';
     const Data_dir='data/';
     const Gall_info_dir='gall_info_dir/';
     const Image_info_dir='image_info_dir/';
	const Page_info_dir='page_info_dir/';
     const Auto_slide_dir='auto_slide/';
	const Image_noresize_dir='image_noresize/';
	const Graphics_dir='graphics/';
     const Social_dir='socialicons/';
     const Contact_dir='contacts/';
     const Font_dir='fonts/';
     const Display_dir='display';
     const Backup_dir='backups/';
     const Master_dir='master/';
	const Image100_dir='imagedir100/';
     const Common_dir='common_dir/';//A repository of common files and video drectory used to install on sub-domains
	const Logfile_dir='logfile/';
     const Include_dir='includes/';
     const Upload_dir='uploads/';
     const Script_dir='scripts/';
	const Response_dir_prefix='imagedir';
     const Style_dir='styling/';
     const Tinymce_user_dir='styling/tiny_mce/'; 
     const Local_dir='/media/VolH/htdocs/';
     const Server_dir='/home/ekarasac/public_html/';
	const Theme_dir='theme_hold/'; 
      #**Image Directories ********
     const Playbutton_dir='playbutton/';
     const Watermark_dir='watermarks/';
     const Background_image_dir='background_images/';
     const Small_thumb_dir='small_images/';
     const Large_image_dir='large_images/';//for gallery
     const Master_thumb_dir='master_thumbs/'; 
     const Page_images_dir='page_images/';
     const Page_images_expand_dir='page_images_expanded/';
     #***Image Info*****************************
     #Image_response values must asccend
      const Image_response='100,200,300,400,500,700,900,1100,1300,1700,2100';
     //const Image_response='2100,1300,1100,900,700,500,400,300,200,100';//in an effort to deliver quicker browser page load times and minimize bandwidth images at the px widths specified here are created to deliver the minimum size equal or larger to the request. These resized Images are created once and only if the particular size is requested. The master upload file is the source from which all resized images are created and should be large enough to accom0date sizes and expanded images.  For image intensive sites running low on server space, you can clear the resized image folders and only essential sized images will be auto regenerated from the original master upload image.
     //Page_pic_plus and Page_pic_expand_plus if set will override Page_width and  Page_pic_expand 
     const Page_pic_width='400';// value is set for images for constant width regardless of height to better fit the page.  
     const Page_pic_plus=''; //for fitting into blogs it is best kept empty to default to page_pic_width  Setting a Page_pic_plus will set the total value of the height + width  and will override any Page_pic_width settting  
     const Page_pic_expand_plus='800';//sets the combined width and height of Expanded Page Images when Page Images are clicked  
     const Page_pic_expand_width='';// normally for expanded view both height and width are considered.  If you prefer to set the width then be sure to set the  Pic_expand_plus value to empty (='';)
     #image size configs may be changed when uploading a photo 
     const Page_width=1280;//default  which is changed in page options  or col options 
     const Default_video_img='default_vid.jpg';
	const Pass_image='default_pass.jpg';
	const Default_image='default.jpg';
     const Max_pic_width=1800;//max pic width for body background images
     const Text_images=false;
     const Check_gallery='reorder,expand,gallery';
     const Default_watermark=false;
     const Title= '';
     const Subtitle= '';
     const Contact_title_pic='contactsudarshan.gif';
     const Gall_topbot_pad=70;
     const Gall_container_width='720';
     const Gallery_row_width='560';
     const Small_gall_pic_plus='180';
	const Master_gall_pic_plus='200';//master gall setting  stipulates width_height
     const Large_gall_pic_plus='700';
     const Small_gall_pic_width='';
     const Large_gall_pic_width=''; 
     const Valid_pic_mime =   'image/pjpeg,image/jpeg,image/JPG,image/gif,image/GIF,image/X-PNG,image/PNG,image/png,image/x-png,image/svg+xml'; 
     const Valid_pic_ext='jpg,gif,png,jpeg,svg';
     const Valid_watermark_ext="gif,png";
     const Pic_max=12000000;
     const Pic_quality=95;
     const Expandgallery='';
     const Gallery_global=false;
	const Col_maxwidth=4000;
     const Master_gall_pic_width=300;//this is the large thumbnails to go to expanded gallery that doesn't seem set with value anywhere
     const Default_background_image_width=1600;
     #*********Gallery Management*********
     const Master_galls='';#replaces Gallery content tables
     const Gallery_content='';//blank default   gallery for master gallery
     
     #*************
     const Last_log='last_logfile.txt'; //file with the last log only
     #**Video+++++++++++
     const Vid_button='playvid.gif';  //watermark  play button automatically added to uploaded video still images
     const Vid_background_dir='video_background/'; 
     const Vid_dir='video/'; 
     const Vid_image_dir='video_image/';                   
     //const Valid_vid_mime =  'application/x-shockwave-flash,video/mp4,application/vnd.adobe.flash.movie,video/x-flv,video/quicktime,application/octet-stream,application/x-zip-compressed,application/zip,video/x-ms-wmv,video/webm,video/ogg,video/m4v';
	const Valid_vid_mime =  'video/mp4,video/webm,video/ogg,video/m4v';
     //const Valid_vid_ext='flv,mov,zip,mp4,mp4,ogg,m4v,webm';
     const Valid_vid_ext='mp4,ogg,m4v,webm';
      const Vid_max=15000000; 
     const Vid_width_max=1000;
     const Vid_height_max=1000;
     const Vid_min=50;
     const Vid_default_size=400;
     const Aspect_flv=1.333;
     const Aspect_mov_ratio=1.28;
     const Aspect_wmv=1.1818; 
     const Aspect_mp4=1.333;
     const Aspect_mov=1.333;
     const Aspect_ogg=1.333;
     const Aspect_m4v=1.333;
     const Aspect_webm=1.333;
     const Aspect_swf=1.333;
     #**Contact++++++++++
     const Mail_from='ekarasa@ekarasa.com';
     const Contact_master_email_pic='sudarshanemail.gif';
     const Contact_master_pic='sudarshan_design.jpg'; 
     #backup configuration for cleaning sql and gzipped backups   settings may be tweaked based on your available server disk space
     const Max_sql_backups=10;//keeps these many backups..
	const Max_gz_backups=10;
	const Max_gz_days=5;//for gzipped files
     #other files
     
 
}
?>