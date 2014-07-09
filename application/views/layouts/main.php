<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf8" />
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

        <!-- Bootstrap CSS framework -->
        <?php
            $bootstrap = Yii::app()->assetPublisher->publish(Yii::getPathOfAlias('composer.twbs.bootstrap.dist'));
        ?>
        <link rel="stylesheet" type="text/css" href="<?php echo $bootstrap; ?>/css/bootstrap.min.css" media="all" />
        <!-- <link rel="stylesheet" type="text/css" href="<?php // echo Yii::app()->assetPublisher->publish(Yii::getPathOfAlias('themes.classic.assets') . '/css/styles.css'); ?>" media="all" /> -->
        <script src="https://code.jquery.com/jquery.js"></script>
        <script src="<?php echo $bootstrap; ?>/js/bootstrap.min.js"></script>
        <link href="<?php echo $bootstrap; ?>/css/bootstrap.min.css" rel="stylesheet" type="text/css" media="all" />

        <title>
            <?php
                if(is_string($this->pageTitle) && $this->pageTitle) {
                    echo CHtml::encode($this->pageTitle) . ' &#8212; ';
                }
                echo CHtml::encode(Yii::app()->name);
            ?>
        </title>

        <script>
            var baseUrl = '<?php echo Yii::app()->urlManager->baseUrl; ?>';

            $(document).ready( function(){
                // Enable all elements with the class "pop" to enable twbs popovers
                $('.pop').popover('hide');
            })
        </script>

        <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    </head>

    <body>

        <!-- Left Navigation Bar Start -->

            <style type="text/css">
                .sidenav {
                    position: fixed;
                    min-height: 100%;
                    width: 80px;
                    top: 0;
                    left: 0;
                    z-index: 100;
                    background: #333;
                    color: #999;
                    text-align: center;
                    text-shadow: 0px 2px 2px #1a1a1a;
                }
                .sidenav .link {
                    text-align: center;
                    font-size: 2.7em;
                    min-height: 70px;
                    padding-top: 13px;
                }
                .sidenav .link:hover{
                    background: #555;
                }

                .sidenav a {
                    color: #999;
                }

                .sidenav a:hover {
                    color: #999;
                }

                .sidenav .link .label {
                    padding-top: 23px;
                    background: #555;
                    color: #bcbcbc;
                    min-height: 70px;
                    position: relative;
                    margin-top: -67px;
                    margin-left: 80px;
                    text-align: center;
                    font-size: 0.8em;
                    width: 300% !important;
                    display: none;
                    border-radius: 0px !important;
                }

                .sidenav .footer {
                    width: 80px;
                    text-align: center;
                    position: fixed;
                    bottom: 0;
                    left: 0;
                }

                .pop {
                    cursor: pointer;
                }
          </style>
            <div class="sidenav hidden-print">

                <div class="link">
                    <?php echo CHtml::link('<span class="glyphicon glyphicon-user"></span>', array('/login/index'), array()); ?>
                    <div class="label">Login</div>
                </div>

                <div class="link">
                    <?php echo CHtml::link('<span class="glyphicon glyphicon-cog"></span>', array('/admin/view'), array()); ?>
                    <div class="label">Admin</div>
                </div>

                <div class="link">
                    <?php echo CHtml::link('<span class="glyphicon glyphicon-save"></span>', array('/test/folder'), array()); ?>
                    <div class="label">Folder uploader</div>
                </div>

                <div class="link">
                    <?php echo CHtml::link('<span class="glyphicon glyphicon-off"></span>', array('/logout/index'), array()); ?>
                    <div class="label">Logout</div>
                </div>
            </div>



            <script>
            $(document).ready( function(){
                // Main links
                $(".sidenav > .link").hover(
                function(){
                    // $(this).children(".label").animate({width:250px}, 100);
                    $(this).children(".label").show();
                    // $(this).children(".label").fadeIn('fast');
                }, function() {
                    // $(this).children(".label").animate({width:0px}, 100);
                    $(this).children(".label").hide();
                    // $(this).children(".label").fadeOut('fast');
                });
            });
            </script>

        <!-- Left Navigation Bar End -->

        <div class="container" id="page">
            <br />
            <?php if(Yii::app()->user->hasFlash('success')): ?>
                <div class="alert alert-success">
                    <?php echo Yii::app()->user->getFlash('success'); ?>
                </div>
            <?php endif; ?>

            <div class="col-xs-11">
                <?php echo $content; ?>
            </div>

            <br />

            <div class="clear"></div>
        </div>

    </body>
</html>

<?php return; ?>


<?php /* @var $this Controller  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="en" />

    <!-- Bootstrap CSS framework -->
    <?php
        $bootstrap = Yii::app()->assetPublisher->publish(Yii::getPathOfAlias('composer.twbs.bootstrap.dist'));
    ?>
    <link rel="stylesheet" type="text/css" href="<?php echo $bootstrap; ?>/css/bootstrap.css" media="all" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->assetPublisher->publish(Yii::getPathOfAlias('themes.classic.assets') . '/css/styles.css'); ?>" media="all" />
    <style type="text/css">
        #mainmenu {
            background: #fff url("<?php echo Yii::app()->assetPublisher->publish(Yii::getPathOfAlias('themes') . '/classic/assets/images/bg.gif'); ?>") repeat-x left top;
        }
    </style>

    <title>DEV-VIEWS: <?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

    <div id="header">
        <div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
    </div><!-- header -->

    <div id="mainmenu">
        <?php $this->widget('zii.widgets.CMenu',array(
            'items'=>array(
                array('label'=>Yii::t('application', 'Home'), 'url'=>Yii::app()->homeUrl),
                array('label'=>Yii::t('application', 'Login'), 'url'=>array('/login'), 'visible'=>Yii::app()->user->isGuest),
                array('label'=>Yii::t('application', 'Logout ({name})', array('{name}' => Yii::app()->user->displayName)), 'url'=>array('/logout'), 'visible'=>!Yii::app()->user->isGuest),
            ),
        )); ?>
    </div><!-- mainmenu -->
    <?php if(isset($this->breadcrumbs)):?>
        <?php $this->widget('zii.widgets.CBreadcrumbs', array(
            'links'=>$this->breadcrumbs,
        )); ?><!-- breadcrumbs -->
    <?php endif?>

    <?php echo $content; ?>

    <div class="clear"></div>

    <div id="footer">
        <?php
            echo Yii::t(
                'application',
                'Copyright &copy; {year} by {company}.',
                array(
                    '{year}' => date('Y'),
                    '{company}' => Yii::app()->name,
                )
            );
        ?>
        <?php
            echo Yii::t('application', 'All rights reserved.');
        ?>
        <br />
        <?php
            $languages = array(
                'en' => 'English',
                'cy' => 'Cymraeg',
            );
            foreach($languages as $code => &$lang) {
                $lang = CHtml::link($lang, array('/language', 'lang' => $code));
            }
            echo implode(' &middot; ', $languages);
        ?>
        <br />
        <?php echo Yii::powered(); ?>
    </div><!-- footer -->

</div><!-- page -->

</body>
</html>
*/
