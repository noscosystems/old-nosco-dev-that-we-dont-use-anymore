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
        <?php echo Yii::t('app', 'The branch you selected to switch to does not exist.'); ?>
    </p>
</div>
