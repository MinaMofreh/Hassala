<?php 

    session_start();

	if(isset($_POST['send'])){

		$arr= array();

		if($_POST['credential']){
			$_SESSION['logged_in'] = true;
			$_SESSION['credential'] = $_POST['credential']; // edited 
			$arr['success'] = true;
		} else {
			$arr['success'] = false;
		}

		echo json_encode($arr);
	}

?>