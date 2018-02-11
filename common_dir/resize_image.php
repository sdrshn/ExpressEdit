<?php
include ('includes/Sys.php');
$image_resize=new photo_batch_resize();
				$image_resize->dbname=$dbname;
				$image_resize->build();
				?>