<?php
include_once "controller.php";


if($_REQUEST){
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if (isset($_REQUEST['_method']) && $_REQUEST['_method'] == "PUT") {
			Controller::update($_REQUEST);
		}
		if (isset($_REQUEST['_method']) && $_REQUEST['_method'] == "PATCH") {
			Controller::all($_REQUEST);
		}
		else{
	    	Controller::save($_REQUEST);
		}
	}
	elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
		
		if(isset($_REQUEST['sagird'])){
	    	Controller::fenn($_REQUEST);
		}
		if(isset($_REQUEST['fenn'])){
	    	Controller::edit($_REQUEST);
		}
		if(isset($_REQUEST['tarix1'])){
	    	Controller::jurnal($_REQUEST);
		}
		if (isset($_REQUEST['ajax'])) {
			Controller::ajax($_REQUEST);
		}
		if(isset($_REQUEST['page'])){
			if($_REQUEST['page'] == "index"){
				Controller::index();
			}
			if($_REQUEST['page'] == "qiymet"){
				Controller::qiymet();
			}
			if($_REQUEST['page'] == "four"){
				Controller::four();
			}
		}
	}
}
?>