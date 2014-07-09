<?php

    return array(
        'elements' => array(
            'username' => array(
                'type' => 'text',
                'maxlength' => 64,
                'hint' => Yii::t('application', 'Please enter your username; it is case-insensitive.'),
            ),
            'password' => array(
                'type' => 'password',
                'hint' => Yii::t('application', 'Please enter your password; it is case-sensitive.'),
            ),
        ),

        'buttons' => array(
            'submit' => array(
                'type' => 'submit',
                'label' => Yii::t('application', 'Login'),
            ),
        ),
    );
