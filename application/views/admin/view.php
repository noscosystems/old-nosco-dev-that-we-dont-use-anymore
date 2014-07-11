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
                    <div class="btn-group" id="adminButtons">
                        <?php echo CHtml::link('Edit', array('/admin/ClickButton','id' => $user->id), array('class' =>'btn btn-md btn-info')); ?>
                        <?php echo CHtml::link('Delete', '#delete', array('class'=>'btn btn-danger', 'data-toggle'=>'modal', 'delete' => $user->id)); ?>
                    </div>
                </td>
            </tr>
        <?php endif ?>
    <?php endforeach; ?>
</table>       
</div>
</body>
</html>




<!-- Modal -->
<form  method="POST" role="form" name="deleteForm" id="">
    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="deleteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">Delete</h4>
                </div>
                <div class="modal-body">
                     <h4 class="modal-title" id="myModalLabel">Are you sure you want to delete this user</h4>
                <input type="hidden" name="deleteID" id="inputDeleteID" class="form-control" value="ID" required="required">
                </div>
                <div class="modal-footer">
                    
                    <button type="submit" class="btn btn-md btn-danger">Delete</button>
                    <?php echo CHtml::link('Cancel', array('/admin/view'), array('class'=>'btn btn-md btn-info')); ?>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    $(document).ready( function(){
        $("#adminButtons a").click( function(event){
            var delID = $(this).attr("delete");

            if(delID && delID != "undefined"){
                $("#inputDeleteID").val(delID);
            }
        })
    })
</script>