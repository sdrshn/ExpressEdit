<?php
#ExpressEdit 2.0
function scale_render($arr,$value,$mod_percent,$incs,$css,$style,$bp1,$bp2,$unit){
     //the $arr is for border,radius with 4 values not 1 
     if (!is_numeric($bp1)||!is_numeric($bp2)||($bp1-$bp2)<=50)return;
     $diff=$bp1-$bp2;
     echo '
@media screen and (min-width:'.($bp1+1).'px){'
     .$css.' {'.$style.':'.$value.$unit.';}
     }';
     $factor=$mod_percent;
     $increment = $diff/$incs;
     $adjust=($mod_percent-100)/$incs;
     $keytrack=0;
     $flag=true;
     for ($i=$bp1-$increment; $i >= $bp2; $i-=$increment){ 
          if ($mod_percent>100){
               $factor-=$adjust; 
              $ratio=($i/$bp1)*($factor/$mod_percent);#factor starts out at mod_percent then gradually decreases..
              } 
          else $ratio=  1 - (($bp1-$i)/$bp1)*($mod_percent/100);
          //@100 ratio is linear to width change
          //as $mod_percent grows the $ratio decreases faster so the size decrease speeds up..
          $increment=$i/$incs;//increment is recalculated for increments  proportional to size decrease ie smaller for smaller vp wid  
         if (!is_array($arr)){
               $finalcss=$css.' {'.$style.':'.($ratio*$value).$unit.'}'; 
               
               }
          else {
               $finalcss=$css.' {'.$style.':';
               foreach($arr as $val){
                    $finalcss.=($ratio*$val).$unit.' ';
                    }
               $finalcss.=';}';
               }
          #here we are going to store inarray the value for all scaling px size units @ the primary column width for width reference which takes into acount all pading and margins.  Also will tablulate font-size scaling which is directly related to em units which are valid units for paddings and widths... this mirrors the check_data key_down_check function ...
          $minbp=$i-$increment;
          $minw=($minbp>$bp2)?' and (min-width:'.$minbp.'px)':''; 
          echo '<br>
          @media screen and (max-width:'.$i.'px)'.$minw.'{<br>
               '.$finalcss.' 
          }'; //i/bp1 =
          
          }
         
     }
     scale_render('',25,30,20,'#displayCurrentSize2,#displayCurrentSize','font-size','3000',300,'px');
     ?>