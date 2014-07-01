<?php
namespace application\controllers;
use application\components\Controller;

class HomeController extends Controller
{
	public function actionIndex()
	{
	$this->render('index');
	}


}
?>