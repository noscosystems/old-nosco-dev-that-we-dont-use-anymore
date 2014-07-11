<?php
namespace application\controllers;

use \Yii;
use \CException;
use \application\components\Controller;
use \application\models\db\User;
use \application\components\form\Form;

class AdminController extends Controller
{
    public function actionIndex()
    {

    //  $user=User::model()->findAll();


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
        $users=User::model()->findAll();

        if (isset($_POST['deleteID'])){

            $user = User::model()->findByPk($_POST['deleteID']);
            if($user->delete())
                $this->redirect(array('admin/view'));
        }


        $this->render('view',
            array(  'users' => $users,
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
                'user_name'=> $_POST['Username'],
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

        if (isset($_POST['deleteID'])){

            $user = User::model()->findByPk($_POST['deleteID']);
            if($user->delete())
                $this->redirect(array('admin/view'));
        }

        $this->render('view', array(
            'users' => $users,
            ));
    }

    public function actionClickButton($id)
    {
        $user = \application\models\db\User::model()->findByPk($id);

        $this->render('AdminEdit', array(
            'user' => $user,
            ));
    }

    public function actionNewUsername()
    {
        // Construct a new Form.
        // Replace 'config' with the form configuration and 'Model' with the form model (see later).
        // See \application\forms for the configs.
        // See \application\models\form for the form models.
        $form = new Form('application.forms.example', new \application\models\form\NewUser);

        // Check if the form has been submitted and validated.
        if($form->submitted() && $form->validate()){
            // Query is true.

            // You are able to set the attributes of a database model with the attributes of a form model, example:
            // Create a new empty DB model.
            $dbModel = new \application\models\db\User;
            // Assign all attributes from the form model
            $dbModel->attributes = $form->model->attributes;
            // Save the database model.
            $dbModel->save();
        }

        // var_dump($form);exit;

        // There is no view named 'form'.
        $this->render('newUsername', array(
            'form' => 'form',
        ));

    }

        public function actionDeleteUser(){
            if (isset($_POST['deleteID'])){
                $id = $_POST['deleteID'];
                $user = User::model()->findByPk($_POST['deleteID']);
                if($user->delete())
                    $this->redirect(array('admin/view'));
            }
            //$user = User::model()->findByAttributes(array(
             //'id' => Yii::app()->user->id,
               // ));

           // $user=User::model()->find($user->id); 
           // $user->delete();

            
        }
    // Uncomment the following methods and override them if needed
    /*
    public function filters()user_name
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
