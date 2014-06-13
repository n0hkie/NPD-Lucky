<?php
	ob_start();
	header('Cache-Control: no-cache, must-revalidate');
	header('Content-type: application/json');

	echo json_encode($res_obj);
	ob_end_flush();
?>