<?php
    $this->pageTitle = Yii::t('app', 'Switch Branch');
    $this->breadcrumbs = array(
        Yii::t('app', 'Login') => array(Yii::app()->user->loginUrl),
        $this->pageTitle,
    );
?>
</h1><?php echo CHtml::encode($this->pageTitle); ?></h1>

<div class="alert alert-danger">
    <p>
        <strong><?php echo Yii::t('app', 'Error!'); ?></strong>
        <?php echo Yii::t('app', 'You do not have the succificient privileges to switch branches.'); ?>
    </p>
</div>
