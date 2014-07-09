<?php
/*
This file should explain roughly how to use forms with the view.
This page will not work in the browser.
*/
?>

<?php
// Start by rendering the form in both PHP and Html
// This will apply any html attributes that you want to apply
// $form->attributes = array('class' => 'form-control');
// This will then render the form tag with any attributes either set in the configuration or the line about.
echo $form->renderBegin();
// Finally, use the widget for the PHP side of the form, the widget is used to render properties.
$widget = $form->activeFormWidget;
?>
    
    <?php
    // To check for errors made by validation, use the following statement.
    if($widget->errorSummary($form)){
        echo '<div class="alert alert-danger">' . $widget->errorSummary($form) . '</div>';
    }
    ?>

    <?php 
    // The line below is an example of displaying the first name field.
    echo $widget->input($form, 'Username', array('class' => 'form-control', 'placeholder' => 'Username'));
    ?>

     <?php 
    // The line below is an example of displaying the first name field.
    echo $widget->input($form, 'password', array('class' => 'form-control', 'placeholder' => 'Password'));
    ?>

     <?php 
    // The line below is an example of displaying the first name field.
    echo $widget->input($form, 'password2', array('class' => 'form-control', 'placeholder' => 'Repeat password'));
    ?>

     <?php  
    // The line below is an example of displaying the first name field.
    echo $widget->input($form, 'email', array('class' => 'form-control', 'placeholder' => 'Email'));
    ?>

    <?php  
    // The line below is an example of displaying the first name field.
    echo $widget->input($form, 'company', array('class' => 'form-control', 'placeholder' => 'Company'));
    ?>


    <?php 
    // And here is an example of how the button would be using some bootstrap class too.
    echo $widget->button($form, 'submit', array('class' => 'btn btn-md btn-info', 'value' => 'AddUser'));
    ?>

<?php 
// Last but not least, you have to always specify the end of the form.
// This is like having a </form> closing tag. It will also close the widget.
echo $form->renderEnd();
?>