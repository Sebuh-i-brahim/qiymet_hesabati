<?php

require_once "database.php";

require_once "validation.php";


class Controller
{
	
	static public function index()
	{	
		header("Location: index.php");
		die();
	}

	static public function qiymet()
	{
		header("Location: qiymet.php");
		die();
	}

	static public function save($request)
	{
		if (session_status() == PHP_SESSION_NONE) {
		    session_start();
		}
		$Validate = new Validate();

		$data = Validate::all($request);

		$db = new db();

		db::addFenn($data);

		$_SESSION['sagird'] = db::sagird();

		$_SESSION['gorunus'] = "1";

		self::qiymet();

	}
	
	static public function edit($request)
	{

		$db = new db();
		
		$table = db::edit($request);

		$_SESSION['table'] = $table;

		$_SESSION['tarix'] = $request;

		self::qiymet();
		
	}

	static public function fenn($request)
	{
		if (session_status() == PHP_SESSION_NONE) {
		    session_start();
		}
		$db = new db();
		
		$fenn = db::fenn($request['sagird']);

		$_SESSION['fenn'] = $fenn;

		$_SESSION['sg_id'] = $request['sagird'];

		self::qiymet();
	}

}










?>