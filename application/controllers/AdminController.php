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
	
	// 	$user=User::model()->findAll();

	
 // $this->render(
 //                'view',
 //                array(  'user' => $user,
 //                    //'email' => $email,
 //                    //'strategy' => $strategy,
 //                    //'events' =>$events,
 //                    //'form' => $form,
                  
 //                    ));

		$this->render('index');
	}

	public function actionView(){
		$user=User::model()->findAll();

	
 		$this->render('view',
                array(  'user' => $user[0],
                    // 'email' => $email,
                    // 'strategy' => $strategy,
                    // 'events' =>$events,
                    // 'form' => $form,
                  
                   ));
	}


	public function actionCreate()

	{

	$user=new User;
    
    {
       
        $user->attributes=array(
        'user_name'=> $_POST['User'],
      	'password'=>$_POST['Password'],
      	'password2'=>$_POST['Repeate Password'],
      	'company'=>$_POST['Company'],
      	'email'=>$_POST['email'],
      	);
	}
		if($user->save()){ 
			$this->redirect(array('admin/view'));
		}
		else{
			$this->redirect(array('AdminEdit'));
		}
		$user=User::model()->findAll();

		$users = User::model()->findAll();
	            $this->render('viewUsername',array('users'=>$users,));

	            foreach($users as $user) {
	            	echo $user->username;
	            }

	     }      
	     public function actionUsername()
	     {
	     	$user=User::model()->findAll();

	     	$this->render('viewUsername', array(
	     		'users' => $user,
	     	));
	     }    
	         public function actionEmail()
	     {
	     	$users=User::model()->findAll();
	     		
	     	$this->render('viewEmail', array(
	     		'users' => $users,
	     	));
	     }  

	        public function actionCompany()
	     {
	     	$users=User::model()->findAll();
	     		
	     	$this->render('view', array(
	     		'users' => $users,
	     	));
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