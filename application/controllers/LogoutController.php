<?php
namespace application\controllers;
use application\components\Controller;
use Yii;
class LogoutController extends Controller
{
	public function actionIndex()
	{
		//If the user is not guest (logged-in) then log them out
		if(!Yii::app()->user->isGuest){
			Yii::app()->user->logout();
		}
		// go to homepage
		$this->redirect(array('/login/index'));
	}
}
?>