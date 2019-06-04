<?php
#ExpressEdit 2.0
echo <<<eol
<!DOCTYPE html>
<html lang="en"> 
<head>
<script>
document.cookie='screenW='+screen.width+','+screen.height; 
document.cookie="clientW="+window.innerWidth|| document.documentElement.clientWidth|| document.body.clientWidth+"; path=/";
</script>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
eol;
?>
