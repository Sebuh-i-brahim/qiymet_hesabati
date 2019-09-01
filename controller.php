<?php

require_once "database.php";

require_once "validation.php";


class Controller
{
	
	static public function index()
	{	
		header("Location: index.php");
		exit();
	}

	static public function qiymet()
	{
		if (session_status() == PHP_SESSION_NONE) {
		    session_start();
		}
		if (!isset($_SESSION['sagird'])) {
			$db = new db();
			$_SESSION['sagird'] = db::sagird();
		}
		header("Location: qiymet.php");
		exit();
	}

	static public function four()
	{	
		if (session_status() == PHP_SESSION_NONE) {
		    session_start();
		}
		if (empty($_SESSION['sagird'])) {
			$db = new db();
			$_SESSION['sagird'] = db::sagird();
		}
		
		header("Location: four.php");
		exit();
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
		if (session_status() == PHP_SESSION_NONE) {
		    session_start();
		}

		$db = new db();
		
		$table = db::edit($request);

		$_SESSION['tarix'] = $request;
		
		$_SESSION['table'] = $table;

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

	static public function update($request)
	{	
		
		if (session_status() == PHP_SESSION_NONE) {
		    session_start();
		}

		$Validate = new Validate();

		$data = Validate::qiymet($request);

		$db = new db();

		db::update($data);

		self::qiymet();
	}

	static public function jurnal($request)
	{	
		if (session_status() == PHP_SESSION_NONE) {
		    session_start();
		}
		$db = new db();
		
		$fenns = db::jurnal($request);

		$_SESSION['all'] = $fenns;

		self::four();
	}
	static public function ajax($request)
	{
		$data = json_decode($request['ajax']);
		$db = new db();

		$ajax = db::ajax($data);

		return $ajax;
	}

}










?>