<?php
include_once "controller.php";


if($_REQUEST){
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	     Controller::save($_REQUEST);
	}
	elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
		
		if(isset($_REQUEST['sagird'])){
	    	Controller::fenn($_REQUEST);
		}
		if(isset($_REQUEST['fenn'])){
	    	Controller::edit($_REQUEST);
		}
	}
	elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
	     Controller::update($_REQUEST);
	}
	elseif ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
	     
	}
}
?>