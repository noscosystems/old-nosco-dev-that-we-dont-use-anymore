<?php

    namespace application\controllers;

    use \Yii;
    use \CException;
    use \application\components\Controller;
    use \application\components\form\Form as FormBuilder;
    use \application\models\form\Login as LoginForm;
    use \application\components\auth\Identity;

    class LoginController extends Controller
    {

        /**
         * Action: Index
         *
         * This is the action that is used to handle external exceptions.
         *
         * @access public
         * @return void
         */
        public function actionIndex()
        {
            
            if(!Yii::app()->user->isGuest){

                $this->redirect(redirect(array('/')));
            }
            $form = new FormBuilder('application.forms.login', new LoginForm);
            if($form->submitted() && $form->validate()){
                $identity = new Identity($form->model->username, $form->model->password);
                $areDetailsCorrect = $identity ->authenticate();
                if ($areDetailsCorrect){
                    Yii::app()->user->login($identity);
                    $this->redirect(array('/'));
                }
                else{

                }
            } 
            $this->render('index',array(
                    'form'=>$form,
                ));
        }

    }
