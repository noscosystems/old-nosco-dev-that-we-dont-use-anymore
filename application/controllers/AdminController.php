<?php

 namespace application\controllers;

    use \Yii;
    use \CException;
    use \application\components\Controller;
    use \application\models\db\User;

class AdminController extends Controller
{
	public function actionIndex()
	{
	
		$company=User::model()->findByAttribute(array('company')(
			Yii::app()->user->company);
			if ($company === null){
				'Error, the company has not enter yet '}
				$this->render ('adminPanel',array());
			}

	}
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}