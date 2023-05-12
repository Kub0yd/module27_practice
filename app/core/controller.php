<?php
class Controller {
	public $model;
	public $view;
	public $db;
	function __construct()
	{
		$this->view = new View();
	}
}