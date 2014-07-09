<?php


 namespace application\models\form;

    // Using Yii, agian pretty standard, reason being is that you may using functions like translate, or encode, or Yiisoft etc.
    use \Yii;
    // CException is error handling, it will allow you to create custom form error checking and display Exceptions (or errors) to the user.
    use \CException;
    // Finally, you need to be able to use the FormModel, basically saying that this class extends the FormModel, google for more info.
    use \application\components\form\Model as FormModel;

    class NewUser extends FormModel
    {

    	public $user_name;
        public $password;
        public $password2;
        public $email;
        public $company;

        public function rules()
        {
            return array(
                // Here I will list some of the rules you can have, if you want more, Google or go to \application\components\FormModel.
                array('user_name, password, password2, email, company', 'required'),
                array('user_name', 'length', 'min' => 3, 'max' => 30),
                array('password', 'length', 'min' => 5, 'max' => 30),
                array('password2', 'length', 'min' => 5, 'max' => 30),
                array('email', 'email'),
                array('company', 'length', 'min' => 3, 'max' => 30),
            );
        }





    }
