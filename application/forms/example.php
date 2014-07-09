<?php

 $persistentClass = 'form-control';

    return array(
        // Set the elements that you wish to use, the format is as follows:
        'elements' => array(
            // Create the element, use the name as the main identifier. The name should also match the model.
            // For example, if the name is 'example' then the model should have a variable called '$example'.
            'user_name' => array(
                'type' => 'text',
                'maxlength' => 30,
                'class' => 'form-control',
                'hint' => 'Please enter your username',
                'label' => 'Username'
            ),
            'password' => array(
                'type' => 'password',
                'maxlength' => 30,
                'class' => 'form-control',
                'hint' => 'Please enter your password',
                'label' => 'Password'
            ),
            'password2' => array(
                'type' => 'password',
                'maxlength' => 30,
                'class' => 'form-control',
                'hint' => 'Please repeat your password',
                'label' => 'Repeat password'
            ),
            'email' => array(
                'type' => 'email',
                'maxlength' => 100,
                'class' => 'form-control',
                'hint' => 'Please enter your email',
                'label' => 'Email'
            ),
            'company' => array(
                'type' => 'text',
                'maxlength' => 200,
                'class' => 'form-control',
                'hint' => 'Please enter your company',
                'label' => 'Company'
            )
        )
	);