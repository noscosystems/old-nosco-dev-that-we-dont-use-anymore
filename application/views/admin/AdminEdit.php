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
        <h1>Administrator Panel</h1><br /><h3>Hello <!--<?php echo $user->user_name ?>--></h3>
     </div>
     <!-- <form class="navbar-form navbar-right" role="search">
        <div class="form-group">
        <input type="text" class="form-control pull-right" placeholder="Search">
        </div>
          <button type="submit" class="btn btn-default">Submit</button>-->
         <!-- <ul class="nav nav-tabs nav-justified" role="tablist">
            <li class="active"><a href="#"  >Company</a></li>


            </script>
          <li class="active1"><a href="#" >Email</a></li>
          <li><a href="#">Username</a></li>
            </ul>
        </div>
      </form>-->
    </div>

  
  <form class="form-horizontal" role="form" >
 <!-- action="<?php// echo $this->createUrl(array('/admin/create')) ?>" mothod="post" it must be put at form with class form-horiontal-->
  <br/>
	<!--<div class="form-group form-group-sm">   
    <div class="col-sm-2 control-label pull-left" for="formGroupInputSmall">Username<?php //echo $user->user_name ?></div>
    <div class="col-sm-10">
      <input class="form-control pull-left" type="text" id="formGroupInputSmall" placeholder="">
      <span class="help-block">Please enter the new Username.</span>
    </div>
  </div>-->
  <div class="form-group form-group-sm">   
    <div class="col-sm-2 control-label pull-left" for="formGroupInputSmall">Password</div>
    <div class="col-sm-10">
      <input class="form-control pull-left" type="text" id="formGroupInputSmall" placeholder="">
      <span class="help-block">Please enter the new Password.</span>
    </div>
  </div>
  <div class="form-group form-group-sm">   
    <div class="col-sm-2 control-label pull-left" for="formGroupInputSmall">Repeat password</div>
    <div class="col-sm-10">
      <input class="form-control pull-left" type="text" id="formGroupInputSmall" placeholder="">
      <span class="help-block">Please repeat the new Password.</span>
    </div>
  </div>
  <div class="form-group form-group-sm">   
    <div class="col-sm-2 control-label pull-left" for="formGroupInputSmall">Company<!--<?php echo $user->company ?>--></div>
    <div class="col-sm-10">
      <input class="form-control pull-left" type="text" id="formGroupInputSmall" placeholder="">
      <span class="help-block">Please enter the new Conpany.</span>
    </div>
  </div>
  <div class="form-group form-group-sm">   
    <div class="col-sm-2 control-label pull-left" for="formGroupInputSmall">Email<!--<?php echo $user->email ?>--></div>
    <div class="col-sm-10">
      <input class="form-control pull-left" type="text" id="formGroupInputSmall" placeholder="">
      <span class="help-block">Please enter the new Email.</span>
    </div>
  </div>
</form>
<input type="submit" class="btn btn-primary btn pull-right" value="Save"></input><br /><br /><br />
  </body>
</html>