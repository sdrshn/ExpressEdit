<?php
#ExpressEdit 2.0.4
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
#Settings here can be overwritten in local Cfg.class.php file to prevent updating..
class Cfg_master { 
	#the following php.ini directives pertain to image uploading and manipulation or video uploading and limits set in php.ini file in edit directory and in html files upload.  
     const Time_zone='';//optionally set local time zone overrides date_default_timezone_get(); ie 'America/New_York' or 'UTF' 
     const Pic_upload_max='15M';//limit image max size in Mbs..
     const Vid_upload_max='100M';//limit Video max size in Mbs..
     const Pdf_upload_max='10M';//upload pdf max size
     // run phpinfo() to see other limiting currently loaded ini configuration files for filesize   ie.  post_max_size  or upload_max_filesize
	const Memory_limit='300M';// //affects editmode ini_set  
	const Max_execution_time=5;//affects editmode ini_set in seconds
	###################
	const Override=false;//set to false to prevent overwriting of icons and other misc page files
     const Override_page_class=false;//set to false to prevent overwriting of  local class files for each page which may be customized, page specific local classes and also site_master, galler_loc, expand_loc and navigate_loc  (class.php) files..
     const Conserve_image_cachespace=false;//limits cache where possible.
	##The following three settings will determine whether the local server development system if used requires a password..
	#use comma separated of more than one development system. to determine whether local development system or production environment.  May be changed in local Cfg files also
	#to disable login set Force_local_login to falsee and specify Local_server filename....
	const Local_site='htdocs,localhost';// url matches for local sites prints error messages to screen 
	const Force_local_login=false;//if true must login for local developement system
	const Local_server='/media/VolH,xamp';//comma separated of local dev servers to allow login bypass unless Force_local_login is set to true... 
	###################
	//name of database with identical fields to main db for use in viewing backups 
	const Debug_backtrace=true;
	const Error_exit=true;//false for production may be true for development exits on non fatal errors .       const Local_site='htdocs,localhost';//use comma separated of more than one development system. to determine whether local development system or production environment  may be changed in local Cfg files also
	const Mysqlserver='';//dir can be manually configured here if not auto detected which may affect backups..   ie  ='C:/xampp/mysql/bin  on xampp windows default settings where the entire path needs to be specified for mysqldump backups
	#******Database Info**************
     const Secure_session=false;
	const Dbhost = 'localhost'; 
     const Hello = 'hello world';
     const Check_request='returnedit'; //used if cache html page version is reactivated
     const Fonts_browser='Arial, Helvetica, sans-serif; Arial Black, Gadget, sans-serif; Constantia, cambria, sans-serif; Comic Sans MS, Comic Sans MS5, cursive; Courier New, monospace; Georgia1, Georgia, serif; Helvetica, sans-serif; Impact, Impact5, Charcoal6, sans-serif; Lucida Console, Monaco5, monospace; Lucida Sans Unicode, Lucida Grande, sans-serif; Palatino Linotype, Book Antiqua3, Palatino, serif; Tahoma, Geneva, sans-serif; Times New Roman, Times New Roman, Times, serif; Trebuchet MS1, Trebuchet MS, sans-serif; Verdana, Verdana, Geneva, sans-serif';
     const Fonts_extended='Chancur;Miama;MeathFLF;Fely;GothicA1;Hind;Allura;Questrial;Nova Slim;Cabin;Julee;Macondo Swash Caps;Michroma;Give You Glory;Delius Swash Caps;Bad Script;Sofia;Eagle Lake;Kite One;Contrail One;Paprika;Redressed,cursive;Shadows Into Light;Josefin Slab;Antic;Nothing You Could Do;Indie Flower;Delius;Amaranth;Over the Rainbow;Aubrey;Text Me One;Cinzel Decorative;Shadows Into Light Two;Comfortaa;Handlee;Oxygen;Basic;Ruluko;Chivo;Architects Daughter;Merienda;Diplomata SC;Cedarville Cursive;Numans;Happy Monkey;Sintony';
     const Preg_color='/^([a-f]|[A-F]|[0-9]){3}(([a-f]|[A-F]|[0-9]){3})?$/';
     const Preg_email='/^[\w.-]+@[\w.-]+\.[A-Za-z]{2,6}$/';
     const Horiz_nav_class='horiz_nav';
     const Vert_nav_class='vert_nav';//for styling 
     const Style=true; 
     const Wordwrap=100; //set line length for emails
	const Temp_ext='temp_passclass_ext'; 
     #***************************
     #Colors  You can change the value of color on the editor value at top Page Configs
     #You can independently change colors and color order for light and dark themes in the editor
     const Pos_color='64C91D';// success color  and column level 1 color
     const RedAlert_color='c82c1d';//alert messages  often a problem
     const Info_color='e5d805'; //information hover and instructional message.. etc.
	const Navy_color='2B1DC9';
	#the order of these text editor colors and border colors corresponds to the column level.. top colors used much  more frequently
	##  DO NOT CHANGE ORDER HERE OR VALUES WILL BE MIXED..  CHANGE ORDER IN EDITOR UNDER CONFIG THIS PAGE AT TOP.  ADD COLORS HERE ANYWHERE THEN RESET in Maintenance Mode.
	#Color values (default) are now set in global_master class protected vals (top of page);
	const Light_editor_color_order='dodgerblue,maroon,navy,cherry,brightgreen,deepskyblue,orangered,aqua,orange,lightmaroon,ekblue,brown,green,yellow,darkgrey,lightermaroon,darkkhaki,darkmagenta,darkolivegreen,darkorange,darkorchid,darkred,darksalmon,darkseagreen,darkslateblue,darkslategray,darkturquoise,darkviolet,deeppink,dimgray,dimgrey,firebrick,floralwhite,forestgreen,fuchsia,gainsboro,moccasin,magenta,navajowhite,oldlace,olive,olivedrab,orchid,palegoldenrod,palegreen,paleturquoise,palevioletred,papayawhip,peachpuff,peru,plum,powderblue,rosybrown,royalblue,saddlebrown,salmon,sandybrown,seagreen,lightestmaroon,black,gold,white,lightlightaqua,lighteraqua,darkeraqua,darkaqua';
	##   YOU CAN  CHANGE ORDER IN EDITOR UNDER CONFIG THIS PAGE AT TOP or change here as needed and be sure to query database to remove values: UPDATE `master_page` SET page_dark_editor_order='',page_light_editor_order='',page_dark_editor_value='',page_light_editor_value='' which will then auto-generate if you change order at least once. change order of both light and dark to save auto generate time everytime...
	const Dark_editor_color_order='lightlightaqua,papayawhip,paleturquoise,palegoldenrod,oldlace,gainsboro,powderblue,darkseagreen,aqua,white,dodgerblue,maroon,navy,cherry,brightgreen,orangered,orange,lightmaroon,ekblue,brown,green,yellow,darkgrey,lightermaroon,darkkhaki,darkmagenta,darkolivegreen,darkorange,darkorchid,darkred,darksalmon,darkslateblue,darkslategray,palevioletred,palegreen,darkturquoise,darkviolet,deeppink,dimgrey,firebrick,floralwhite,forestgreen,fuchsia,moccasin,magenta,olive,olivedrab,orchid,deepskyblue,peachpuff,navajowhite,peru,plum,rosybrown,royalblue,saddlebrown,salmon,sandybrown,seagreen,lightestmaroon,black,gold,lighteraqua,darkeraqua,darkaqua';
//these colors are arranged for lighter to go with darker background
	//note: color names much match respective global_master  class  names
	//const Full_color_index='info,pos, redAlert ,cherry,aqua,brightgreen,yellow,ekblue,orange,navy,magenta,maroon,brown,green';
	#************************ 
     const Edit_font_size='1'; //sets default font size   1 = 16px
	const Edit_font_family='Helvetica=> sans-serif';//default edit font family  
    #database  tables
     const Directory_dir='directory';
	const Backups_table='backups_db';
     const Db_traffic_table='user_data';
     const Master_post_table='master_post';
     const Master_page_table='master_page';
     const Master_gall_table='master_gall';
     const Master_post_css_table='master_post_css';
     const Master_post_data_table='master_post_data';
     const Master_col_css_table='master_col_css'; 
     const Columns_table='columns';
	const Comment_table='comments';//not used currently
	#rwd defaults
	const Default_width_mode='maxwidth';//if not set
	const Db_tables='columns,comments,directory,master_col_css,master_gall,master_page,master_post,master_post_css,master_post_data';
     #Fields
     const Col_fields='col_table_base,col_table,col_num,col_options,col_status,col_grid_clone,col_gridspace_right,col_gridspace_left,col_grid_width,col_tcol_num,col_primary,col_clone_target,col_clone_target_base,col_style,col_style2,col_temp,col_grp_bor_style,col_comment_style,col_comment_date_style,col_comment_view_style,col_date_style,col_width,col_hr,col_flex_box';
     const Col_fields_all='col_table_base,col_table,col_num,col_options,col_status,col_grid_clone,col_gridspace_right,col_gridspace_left,col_grid_width,col_tcol_num,col_primary,col_clone_target,col_clone_target_base,col_style,col_style2,col_temp,col_grp_bor_style,col_comment_style,col_date_style,col_comment_view_style,col_comment_date_style,col_width,col_hr,col_update,col_time,token,col_flex_box';
    const Col_flex_options='flex_display,col_max_flex,col_min_flex,flex_direction,flex_wrap,flex_justify_content,flex_align_items,flex_align_content,,,,';//leaving additional room for flex otpion on end as record will record 3 times for each of 3 separate potential media queries
     const Blog_flex_options='blog_max_flex,blog_min_flex,flex_order,flex_grow,flex_shrink,flex_basis,flex_align_self,,,,';//leaving additional option room on end as record will record 3 times for each of 3 separate potential media queries
	const Gallery_fields='master_gall_status,master_table_ref,master_gall_ref,gall_ref,gall_table,pic_order,picname,imagetitle,description,subtitle,width,height,galleryname,temp_pic_order,reset_id';
     const Post_fields='blog_clone_table,blog_col,blog_order,blog_type,blog_table,blog_gridspace_right,blog_gridspace_left,blog_grid_width,blog_data1,blog_data2,blog_data3,blog_data4,blog_data5,blog_data6,blog_data7,blog_data8,blog_data9,blog_data10,blog_data11,blog_data12,blog_data13,blog_data14,blog_data15,blog_tiny_data1,blog_tiny_data2,blog_tiny_data3,blog_tiny_data4,blog_tiny_data5,blog_tiny_data6,blog_tiny_data7,blog_tiny_data8,blog_tiny_data9,blog_tiny_data10,blog_tiny_data11,blog_tiny_data12,blog_tiny_data13,blog_tiny_data14,blog_tiny_data15,blog_grid_clone,blog_style,blog_style2,blog_table_base,blog_text,blog_border_start,blog_border_stop,blog_global_style,blog_date,blog_width,blog_width_mode,blog_status,blog_unstatus,blog_clone_target,blog_target_table_base,blog_float,blog_unclone,blog_pub,blog_tag,blog_temp,blog_options,blog_flex_box';
     const Page_fields='page_custom_css,page_head,page_ref,page_title,page_filename,page_width,page_pic_quality,page_style,page_options,page_break_points,page_cache,page_light_editor_value,page_dark_editor_value,page_dark_editor_order,page_light_editor_order,page_comment_style,page_date_style,page_comment_view_style,page_comment_date_style,page_style_day,page_style_month,page_grp_bor_style,page_link,page_link_hover,keywords,metadescription,page_data1,page_data2,page_data3,page_data4,page_data5,page_data6,page_data7,page_data8,page_data9,page_data10,use_tags,page_hr,page_h1,page_h2,page_h3,page_h4,page_h5,page_h6,page_myclass1,page_myclass2,page_myclass3,page_myclass4,page_myclass5,page_myclass6,page_myclass7,page_myclass8,page_myclass9,page_myclass10,page_myclass11,page_myclass12,page_tiny_data1,page_tiny_data2,page_tiny_data3,page_tiny_data4,page_tiny_data5,page_tiny_data6,page_tiny_data7,page_tiny_data8,page_tiny_data9,page_tiny_data10,page_clipboard'; 
	const Page_fields_all='page_custom_css,page_head,page_ref,page_title,page_filename,page_width,page_pic_quality,page_style,page_options,page_break_points,page_cache,page_light_editor_value,page_dark_editor_value,page_dark_editor_order,page_light_editor_order,page_comment_style,page_date_style,page_comment_view_style,page_comment_date_style,page_style_day,page_style_month,page_grp_bor_style,page_link,page_link_hover,keywords,metadescription,page_data1,page_data2,page_data3,page_data4,page_data5,page_data6,page_data7,page_data8,page_data9,page_data10,use_tags,page_hr,page_h1,page_h2,page_h3,page_h4,page_h5,page_h6,page_myclass1,page_myclass2,page_myclass3,page_myclass4,page_myclass5,page_myclass6,page_myclass7,page_myclass8,page_myclass9,page_myclass10,page_myclass11,page_myclass12,page_tiny_data1,page_tiny_data2,page_tiny_data3,page_tiny_data4,page_tiny_data5,page_tiny_data6,page_tiny_data7,page_tiny_data8,page_tiny_data9,page_tiny_data10,page_clipboard,page_update,page_time,token';
	const Dir_fields='dir_menu_id,dir_menu_style,dir_menu_order,dir_sub_menu_order,dir_filename,dir_title,dir_ref,dir_gall_table,dir_blog_table,dir_menu_type,dir_is_gall,dir_gall_type,dir_menu_opts,dir_hide_sub_menu,dir_external,dir_internal,dir_temp,dir_temp2';
	const Comment_fields='com_blog_id,com_text,com_name,com_email,com_token,com_status';
    #indexes
     const Background_styles='background_color,background_gradient_type,background_gradient_color1,background_gradient_color2,background_gradient_color3,background_gradient_color4,background_gradient_color5,background_gradient_color6,background_gradient_transparency1,background_gradient_transparency2,background_gradient_transparency3,background_gradient_transparency4,background_gradient_transparency5,background_gradient_transparency6,background_gradient_color_stop1,background_gradient_color_stop2,background_gradient_color_stop3,background_gradient_color_stop4,background_gradient_color_stop5,background_gradient_color_stop6,background_gradient_position_keyword,background_gradient_position1,background_gradient_position2,background_image,background_image_use,background_repeat,background_horiz,background_vert,background_opacity,background_size,background_pos_width,background_pos_height,background_image_opacity,background_fixed,background_image_none,background_image_noresize,background_video,background_video_ratio,background_video_display,background_image_off,background_color_off';
     const Style_functions=',padding_top,padding_bottom,padding_left,padding_right,margin_top,margin_bottom,margin_left,margin_right,font_family,font_size,font_weight,text_align,font_color,italics_font,small_caps,line_height,letter_spacing,text_underline,width_special,background,radius_corner,columns,text_shadow,box_shadow,transform,borders,height_style,custom_style,outlines,float,media_max_width,media_min_width,width_max_special,width_min_special,,,,left,right,top,bottom';
     const Style_functions_order='background,padding_top,padding_bottom,padding_left,padding_right,margin_top,margin_bottom,margin_left,margin_right,font_color,text_shadow,font_family,font_size,font_weight,text_align,line_height,letter_spacing,italics_font,small_caps,text_underline,radius_corner,borders,box_shadow,outlines,columns,transform';
	const Page_options='page_editor_choice,page_darkeditor_background,page_darkeditor_color,page_lighteditor_background,page_lighteditor_color,page_date_format,page_max_expand_image,page_editor_fontfamily,page_editor_fontsize,page_slideshow,page_width_mode,page_min_width,page_bounce_width,page_image_quality,page_backup_copies,page_advanced,page_editor_bordersize,page_alink_hover_color,page_width_scale_upper,page_width_scale_lower,page_mod_percent,page_rem_unit,page_grid_units,page_darkeditor_info,page_lighteditor_info,page_darkeditor_red,page_lighteditor_red,page_darkeditor_pos,page_lighteditor_pos';
	const Image_options='image_width_limit,image_noexpand,image_max_expand,image_quality,image_noresize,image_min,image_height_set,imagecaption_height,image_caption_text,image_caption_hover,image_internal_link,image_external_link,imagecaption_bottom,image_internal_query,image_height_media,image_max_media1,image_min_media1,image_max_media2,image_min_media2,image_max_media3,image_min_media3,image_max_media4,image_min_media4,image_max_media5,image_min_media5,image_per1,image_per2,image_per3,image_per4,image_per5';//accessed global edit &  add_page_pic 
     const Blog_options='blog_comment,blog_comment_display,blog_editor_use,blog_date_on,blog_date_format,blog_pad_unit,blog_mar_unit,blog_break_points,blog_vert_pos,blog_media_minmax,blog_display_max,blog_display_min,blog_animation,blog_opacity,blog_position,blog_width_opt,blog_min_width_opt,blog_max_width_opt,blog_height_media,blog_height_opt,blog_min_height_opt,blog_max_height_opt,blog_pos_vert_val0,blog_pos_horiz_val0,blog_overflowx,blog_overflowy,blog_custom_class,blog_pos_vert_val1,blog_pos_horiz_val1,blog_pos_vert_val2,blog_pos_horiz_val2,';
	const Position_options='position,position_max,position_min,position_horiz,position_horiz_val,position_vert,position_vert_val,position_zindex,position_pos_neg,position_opacity';
	const Column_options='col_tag_display,col_float_calc,col_use_grid,col_grid_units,col_break_points,col_vert_pos,col_media_minmax,col_display_max,col_display_min,col_pad_unit,col_mar_unit,col_animation,col_opacity,col_position,col_enable_masonry,col_width2,col_width_opt,col_min_width_opt,col_max_width_opt,col_pos_vert_val0,col_pos_horiz_val0,col_height_opt,col_min_height_opt,col_max_height_opt,col_overflowx,col_overflowy,col_height_media,col_pos_vert_val1,col_pos_horiz_val1,col_pos_vert_val2,col_pos_horiz_val2';// 
	const Box_shadow_options='shadowbox_horiz_offset,shadowbox_vert_offset,shadowbox_blur_radius,shadowbox_spread_radius,shadowbox_color,shadowbox_insideout';
	const Animation_options='animate_type,animate_visibility,animate_repeats,animate_duration,animate_height,animate_width,animate_after_type,animate_after_delay,animate_after_repeats,animate_after_duration,animate_final_display,animate_alternate,animate_lock,animate_complete_id,animate_sibling,animate_prior_delay';
	const Animation_types='none,skewSubtle,bounce,flash,pulse,rubberBand,shake,swing,tada,wobble,jello,bounceIn,bounceInDown,bounceInLeft,bounceInRight,bounceInUp,bounceOut,bounceOutDown,bounceOutLeft,bounceOutRight,bounceOutUp,fadeIn,fadeIn,fadeInDownSubtle,fadeInDown,fadeInDownBig,fadeInLeft,fadeInLeftBig,fadeInRight,fadeInRightBig,fadeInUpSubtle,fadeInUp,fadeInUpBig,fadeOut,fadeOutDownSubtle,fadeOutDown,fadeOutDownBig,fadeOutLeft,fadeOutLeftBig,fadeOutRight,fadeOutRightBig,fadeOutUpSubtle,fadeOutUp,fadeOutUpBig,flip,flipInX,flipInY,flipOutX,flipOutY,lightSpeedIn,lightSpeedOut,rotateIn,rotateInDownLeft,rotateInDownRight,rotateInUpLeft,rotateInUpRight,rotateOut,rotateOutDownLeft,rotateOutDownRight,rotateOutUpLeft,rotateOutUpRight,slideInUp,slideInDown,slideInLeft,slideInRight,slideOutUp,slideOutDown,slideOutLeft,slideOutRight,zoomIn,zoomInDown,zoomInLeft,zoomInRight,zoomInUp,zoomOut,zoomOutDown,zoomOutLeft,zoomOutRight,zoomOutUp,hinge,jackInTheBox,rollIn,rollOut';
	const Main_width_options='blog_width_mode,blog_percent_init,blog_marginleft_init,blog_marginright_init,blog_media_1,blog_percent_1,blog_marginleft_1,blog_marginright_1,blog_media_2,blog_percent_2,blog_marginleft_2,blog_marginright_2,blog_media_3,blog_percent_3,blog_marginleft_3,blog_marginright_3,blog_media_4,blog_percent_4,blog_marginleft_4,blog_marginright_4,blog_media_5,blog_percent_5,blog_marginleft_5,blog_marginright_5,blog_media_6,blog_percent_6,blog_marginleft_6,blog_marginright_6,blog_media_7,blog_percent_7,blog_marginleft_7,blog_marginright_7,blog_media_8,blog_percent_8,blog_marginleft_8,blog_marginright_8';
	const Advance_media_width='blog_adv_media_1,blog_adv_width_1,blog_adv_marginleft_1,blog_adv_marginright_1,blog_adv_paddingleft_1,blog_adv_paddingright_1,blog_adv_media_2,blog_adv_width_2,blog_adv_marginleft_2,blog_adv_marginright_2,blog_adv_paddingleft_2,blog_adv_paddingright_2,blog_adv_media_3,blog_adv_width_3,blog_adv_marginleft_3,blog_adv_marginright_3,blog_adv_paddingleft_3,blog_adv_paddingright_3,blog_adv_media_4,blog_adv_width_4,blog_adv_marginleft_4,blog_adv_marginright_4,blog_adv_paddingleft_4,blog_adv_paddingright_4,blog_adv_media_5,blog_adv_width_5,blog_adv_marginleft_5,blog_adv_marginright_5,blog_adv_paddingleft_5,blog_adv_paddingright_5,blog_adv_media_6,blog_adv_width_6,blog_adv_marginleft_6,blog_adv_marginright_6,blog_adv_paddingleft_6,blog_adv_paddingright_6,blog_adv_media_7,blog_adv_width_7,blog_adv_marginleft_7,blog_adv_marginright_7,blog_adv_paddingleft_7,blog_adv_paddingright_7,blog_adv_media_8,blog_adv_width_8,blog_adv_marginleft_8,blog_adv_marginright_8,blog_adv_paddingleft_8,blog_adv_paddingright_8';
     const Backup_copies=200;//change  in page_default settings
	const Column_grid_units=100;//default setting change in page configs
	const Column_break_points='1006,791,489,384';//default setting change in page configs
	const Development=false;//for javascript alert on ajax imagecall and build image and image resize messages on editpage..
     #prefixes  suffixes  extenisons
     const Exts='htm,html,asp';
     const Backup_ext_folder='backupversions/';
     const Post_suffix='_post_id';
     const Col_suffix='_col_id';
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
     const Exclude='jpgraph,tinymce-Orig,1downloaded internet files,fvd suite,zen cart,secure apache ssl,.,..,$recycle.bin,system volume information,temp,phplist,compress,zen,phpMyAdmin,phpsite,ellen,design,css,create,arthur,attachment,highslide,fonts,langs,plugins,themes,utils,graphics,tmp,cgi-bin,forum,zen,wordpress,tinymce,tiny-mce';#these files are excluded from search and other generation programs
    #pdf
     const Valid_pdf_mime='application/pdf,application/acrobat,application/x-pdf,applications/vnd.pdf,text/pdf,text/x-pdf';
     const Pdf_max=15000000;
	const Pass_class_page='passclass.php';
	const Expand_pass_page='expand-passclass.php';
      #directories-non Image or Vid
     const Menu_icon_dir='menu_icons/';
     const Data_dir='data/';
     const Buffer_dir='buffer/';
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
	const Theme_dir='theme_hold/'; 
	const Theme_match='theme'; 
      #**Image Directories ********
     const Favicon='karma.ico';
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
     const Page_width='1600';//sets default page width if no column widths set..
     const Image_response='100,200,300,400,500,700,900,1100,1300,1700,2100';//default  px sises for image cache directories
     const Default_video_img='default_vid.jpg';
	const Pass_image='default_pass.jpg';
	const Default_image='default.jpg';
     ####
      // these image size settings are defaults or maxwidths .. Pic image sizes generally occupy full space of post available up to any max values set..
     const Max_pic_width=3000;//max pic width for body background images
     const Default_watermark=false;//watermark may be added through uploads interface
     const Small_gall_pic_plus='180';//default backup   config in your gall post settings
     const Small_gall_pic_width='180';//default backup  config in your gall post settings
	const Master_gall_pic_plus='200';//master gall setting  config in your gall post settings
     const Large_gall_pic_plus='700';//default backup  config in your gall post settings
     const Large_gall_pic_width='700';//default backup  config in your gall post settings
     const Page_pic_expand_plus='3000'; //default value set in page options..
     ####
     const Valid_pic_mime =   'image/pjpeg,image/jpeg,image/JPG,image/gif,image/GIF,image/X-PNG,image/PNG,image/png,image/x-png,image/svg+xml'; 
     const Valid_pic_ext='jpg,gif,png,jpeg,svg';
     const Valid_watermark_ext="gif,png";
     const Valid_pdf_ext='pdf';
     const Pic_quality=95;
	const Col_maxwidth=4000;
     const Master_gall_pic_width=300;//this is the large thumbnails to go to expanded gallery t 
     const Default_background_image_width=500;//sets default width
     #*********Gallery Management*********
     const Gallery_content='';//blank default   gallery for master gallery
     
     #*************
     const Last_log='last_logfile.txt'; //file with the last log only
     #**Video+++++++++++
     const Vid_button='playvid.gif';  //watermark  play button automatically added to uploaded video still images
     const Vid_background_dir='video_background/'; 
     const Vid_dir='video/';  
     const Video_dir='video/'; 
     const Vid_image_dir='video_image/';                   
     const Valid_vid_mime =  'video/mp4,video/webm,video/ogg,video/m4v';
     const Valid_vid_ext='mp4,ogg,m4v,webm';
     #**Contact++++++++++
     #backup configuration for cleaning sql and gzipped backups   settings may be tweaked based on your available server disk space	const Max_gz_backups=10;
	#other files
	 
}
?>