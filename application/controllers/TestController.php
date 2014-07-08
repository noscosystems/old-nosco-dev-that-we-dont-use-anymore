<?php

    namespace application\controllers;

    use \Yii;
    use \CException;
    use \application\components\Controller;
    use \application\models\db\User;

    class TestController extends Controller
    {

        /**
         * Action: Index
         *
         * @access public
         * @return void
         */
        public function actionIndex()
        {

            echo "Folder uploader

            <br/>
            Please select a FOLDER to upload
             <form>
            <input type='file' webkitdirectory>test
            </form> ";
            echo 'test index';
            $plan = new \application\models\db\Plan;
            $plan->attributes = array(
                'loan'              => 988,
                'customer'          => 106,
                'amount'            => 100,
                'created'           => time(),
                'start'             => date('Y-m-d', strtotime('31 March 2014')),
                'finish'            => null,
                'method'            => 164,
                'installments'      => 10,
                'per_installment'   => null,
                'rule'              => 'FREQ=MONTHLY;BYSETPOS=-1',
                'strategy'          => null,
                'superceded'        => null,

            );
            $payments = $plan->predictedPayments;
            foreach($payments as $date => $amount) {
                $payments[date('l, jS F, Y', $date)] = $amount;
                unset($payments[$date]);
            }
            var_dump($payments);
            var_dump(date('l, jS F, Y', $plan->nextPaymentDate));

            if(!$plan->save()) {
                var_dump($plan->errors);exit;
            }

            $plan = \application\models\db\Plan::model()->findByPk($plan->id);

            $payments = $plan->predictedPayments;
            foreach($payments as $date => $amount) {
                $payments[date('l, jS F, Y', $date)] = $amount;
                unset($payments[$date]);
            }
            var_dump($payments);
            var_dump(date('l, jS F, Y', $plan->nextPaymentDate));



        }




public function actionFolder()
        {
                // load user details ad pass to view
                $user=User::model()->findByPk(
                Yii::app()->user->id
                );
                if($user===null){
                 'Error, the user has not logged in yet';
                }


             $this->render(
                'folder',
                array(  'user' => $user,
                    //'email' => $email,
                    //'strategy' => $strategy,
                    //'events' =>$events,
                    //'form' => $form,
                  
                    )); 
            }



    }

