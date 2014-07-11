<html>
<head>
  <meta charset="utf8">
  <link rel="stylesheet" type="text/css" href="/projects/noscobg/public_html/assets/3baca50d/css/bootstrap.min.css" media="all">
  <link rel="stylesheet" type="text/css" href="/projects/nosco-dev/application/themes/classic/assets/css/main.css" media="all">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="/projects/noscobg/public_html/assets/3baca50d/js/bootstrap.min.js"></script>
</head>
<body>
 <div class="panel panel-primary text-center"><h1>Administrator Panel</h1><br />
   <h3>Hello <!--<?php// echo $user->user_name ?>--><h3></div>
     <!-- <form class="navbar-form navbar-right" role="search"></form>
        <div class="form-group"></div>
          <input type="text" class="form-control pull-right" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
<ul class="nav nav-tabs nav-justified" role="tablist"></ul>
  <li class="active"><a href="#"  >Company</a></li>


  </script>
  <li class="active1"><a href="#" >Email</a></li>
  <li><a href="#">Username</a></li>
</ul>-->
<br/><br/>	
<form class="form-horizontal" role="form">
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Password</label>
    <div class="col-sm-10">
      <input type="email" class="form-control" id="inputEmail3" placeholder="Enter your new password">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Repeat password</label>
    <div class="col-sm-10">
      <input type="email" class="form-control" id="inputEmail3" placeholder="Repeat your new password">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
    <div class="col-sm-10">
      <input type="email" class="form-control" id="inputEmail3" placeholder="Enter your new email">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Company</label>
    <div class="col-sm-10">
      <input type="email" class="form-control" id="inputEmail3" placeholder="Enter your new company">
    </div>
  </div>
  <div class="text-right">
    <?php echo CHtml::link('Save', array('/admin/Company'), array('class'=>'btn btn-md btn-info')); ?>
    <?php echo CHtml::link('Cancel', array('/admin/Username'), array('class'=>'btn btn-md btn-danger')); ?>
  </div>
</form>
</body>
</html>