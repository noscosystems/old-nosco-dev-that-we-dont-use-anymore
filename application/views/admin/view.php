<html>
<head>
    <meta charset="utf8">
    <link rel="stylesheet" type="text/css" href="/projects/noscobg/public_html/assets/3baca50d/css/bootstrap.min.css" media="all">
    <!-- <link rel="stylesheet" type="text/css" href="/projects/nosco-dev/application/themes/classic/assets/css/main.css" media="all">-->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="/projects/noscobg/public_html/assets/3baca50d/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="panel panel-primary text-center"><h1>Administrator Panel</h1><br /><h3>Hello</h3></div>

<!-- <div class="form-group">
<<input type="text" class="form-control pull-right" placeholder="Search">
</div>-
<button type="submit" class="btn btn-default">Submit</button>-->
<ul class="nav nav-tabs nav-justified" role="tablist">
    <li class="active"><?php echo CHtml::link('Company', array('/admin/company')); ?></li>
</script>
<li class="active1"><?php echo CHtml::link('Email', array('/admin/email')); ?></li>
<li class="active2"><?php echo CHtml::link('Username', array('/admin/username')); ?></li>

</ul>
</form><br/ >

<div class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Modal title</h4>
            </div>
            <div class="modal-body">
                <p>One fine body&hellip;</p>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="text-right">
<br /><?php echo CHtml::link('New company', array('/admin/NewUsername'), array('class'=>'btn btn-sm btn-info')); ?>
</div><br />

<table class="table">
    <?php foreach ($users as $key => $user): ?>
        <?php if($user->company): ?>
            <?php
            $rowClass = "";
            if($key % 2 == 0) 
                $rowClass = "info";
            ?>
            <tr class="<?php echo $rowClass; ?>">
                <td><?php echo $user->company; ?></td>
                <td class="text-center"><?php echo $user->id; ?></td>
                <td class="text-right">
                    <div class="btn-group">
                        <?php echo CHtml::link('Edit', array('/admin/ClickButton','id' => $user->id), array('class' =>'btn btn-md btn-info')); ?>
                        <input type="submit" class="btn btn-danger" value="Delete"/>


                      <!--  <script>
                        $(dokument).ready(function(){
                            $(.btn btn-danger).click(function(){
                                $(.modal fade).show(.)
                            });
                        });
                        </script>-->
                        <div class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Modal title</h4>
      </div>
      <div class="modal-body">
        <p>One fine body&hellip;</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


                    </div>
                </td>
            </tr>
        <?php endif ?>
    <?php endforeach; ?>
</table>       
</div>
</body>
</html>