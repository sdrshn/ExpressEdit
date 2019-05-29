#!/bin/bash
sitecontent=( `cat "/www/arunachalaSiteMapFull.txt" `)
#filecontent=( `cat "/www/siteBaseArunchala.txt" `)
cd /www/arunachala/htmlFiles/
for  f in * 
     do   
          f=${f%?}
          echo "$f"
          done;
           