<h1>Hello</h1>
 
<?php
if(Yii::app()->user->isGuest):
?>
<?php
//The URL insite on array
 //echo CHtml::link( 'Login', array('/login'));
?>
<?php
else :
	
?>
<br />
<?php
//The URL out site
 echo CHtml::link('Logout' ,array('/logout'));
?>
You are login in as User#<?php echo Yii::app()->user->id; ?>
<?php
endif;
?>