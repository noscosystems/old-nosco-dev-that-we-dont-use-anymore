<html>
  <head>
  <meta charset="utf8">
    <link rel="stylesheet" type="text/css" href="/projects/noscobg/public_html/assets/3baca50d/css/bootstrap.min.css" media="all">
    <link rel="stylesheet" type="text/css" href="/projects/nosco-dev/application/themes/classic/assets/css/main.css" media="all">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="/projects/noscobg/public_html/assets/3baca50d/js/bootstrap.min.js"></script>
  </head>
    <body>
      <div class="panel panel-primary text-center">
        <h1>Administrator Panel</h1><br /><h3>Hello </h3>
     </div>
     
       <!-- <div class="form-group">
          <<input type="text" class="form-control pull-right" placeholder="Search">
        </div>-
          <button type="submit" class="btn btn-default">Submit</button>-->
<ul class="nav nav-tabs nav-justified" role="tablist">
  <li class="active1"><?php echo CHtml::link('Company', array('/admin/company')); ?></li>

  <li class="active3"><?php echo CHtml::link('Email', array('/admin/email')); ?></li>
  <li class="active"><?php echo CHtml::link('Username', array('/admin/username')); ?></li>
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
</div><!-- /.modal --><br/><br/ >
<br /><input type="button" class="btn btn-default btn-sm pull-right" value="New Username">
</input><br />

<table class="table">
<?php $count = 0; ?>
<?php foreach($users as $key=> $user): ?>
  <?php if($user->user_name): ?>
  <?php
  $rowClass="";
  if ($count % 2 ==0)
    $rowClass="info"?> 
  <tr class="<?php echo $rowClass; ?>">
  <td><?php echo $user->user_name; ?></td>
    <td class="active">
    <input type="submit" class="btn btn-danger pull-right" value="Delete"> <?php echo $user->id; ?></input>
      <input type="submit" class="btn btn-info pull-right" value="Edit"></input>
      
    </td>
  </tr>
  <?php $count++; ?>
<?php endif ?>
<?php endforeach; ?>
</table>       
</div>
    </body>
</html>