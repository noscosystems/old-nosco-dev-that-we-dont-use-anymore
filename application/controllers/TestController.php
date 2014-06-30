<?php

    namespace application\controllers;

    use \Yii;
    use \CException;
    use \application\components\Controller;

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
 public function actionApr()
        {
                $this->render(
        'apr'
        );
        }

public function actionFolderwithslider()
        {

             $this->render(
                'folderwithslider',
                array( // 'customer' => $customer,
                    )); 
            }




public function actionFolder()
        {

  /*     
    $count = 0;

    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
            
        foreach ($_FILES['fileURL']['name'] as $i => $name) {
            if (strlen($_FILES['fileURL']['name'][$i]) > 1) {

                echo "uploading ".$name."<br>";
                if (move_uploaded_file($_FILES['fileURL']['tmp_name'][$i], 'upload/'.$name)) {
                    $count++;

                }
            }
        }
        echo "uploaded ".$count." files sucessfully";
    }


*/







             $this->renderPartial(
                'folder',
                array( // 'customer' => $customer,
                   // 'strategies' => $strategies,
                   // 'strategy' => $strategy,
                   // 'events' =>$events,
                   // 'form' => $form,
                  
                    )); 
            }


            public function actionFolder2()
        {

             $this->render(
                'folder2',
                array( // 'customer' => $customer,
                   // 'strategies' => $strategies,
                   // 'strategy' => $strategy,
                   // 'events' =>$events,
                   // 'form' => $form,
                  
                    )); 
            }


             public function actionFolder3()
        {

             $this->render(
                'folder3',
                array( // 'customer' => $customer,
                   // 'strategies' => $strategies,
                   // 'strategy' => $strategy,
                   // 'events' =>$events,
                   // 'form' => $form,
                  
                    )); 
            }

    }

