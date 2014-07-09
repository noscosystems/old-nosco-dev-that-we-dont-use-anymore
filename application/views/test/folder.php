<?php
use application\models\db\User;

    $page = $this->action->id;
    $this->pageTitle = 'Home';
    $this->breadcrumbs = array();
    $this->layout = '//layouts/column2';

 //   $this->menu = array(
 //       array('label' => 'View recently uploaded folders', 'url' => array('/actions/index')),
 //       array('label' => 'Run a virus check', 'url' => array('/actions/tomorrow')),
        //array('label' => 'Next 30 Days', 'url' => array('/actions/month')),
        //array('label' => 'Admin Actions', 'url' => array('/actions/admin'), 'visible' => Yii::app()->user->priv >= 40),
     //   array('label' => 'New Task', 'url' => array('/actions/task1')),
    //  array('label' => Yii::t('chaser', 'Strategies/Plans'), 'url' => array('/strategies')),
 //   );
?>




<hgroup>
    <h1>	FOLDER uploader  for <?php echo $user->company ?> </h1>

   <!-- 
   <input type='file' webkitdirectory>  
   
    <form enctype="multipart/form-data"  role="form" method="POST" name="fileURL">

   --> 
   
   <form  role="form" method="POST" name="fileURL"  enctype="multipart/form-data">
  <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="email" class="form-control" id="exampleInputEmail1" value= "<?php echo $user->email ?>" placeholder="Enter email">
  </div>

  <div class="form-group">
    <label for="exampleInputPassword1">Description of Folder contents</label>
    <input type="text" class="form-control" id="desc" placeholder="desc">
    <p class="help-block">Brief description of contents i.e. April's invoices</p>
  </div>
  <div class="form-group">
    <label for="exampleInputFile" id="fileHolder">Folder input</label>
    <input type="file" multiple webkitdirectory id="fileURL" name="fileURL[]" >
    <p class="help-block">Please select a FOLDER to upload to the secure portal.</p>
  </div>
  <div class="row">
	<h4>Files within the folder :</h4>
 		<ul id="fileOutput">
 		</ul>
	</div> 
	</br>
  <!--
  <div class="checkbox">
    <label>
      <input type="checkbox"> please send me a confirmation email 
    </label>
  </div>
-->
 <?php echo CHtml::link('Submit', array(), array('class'=>'btn btn-md btn-info')); ?>
  <?php echo CHtml::link('Cancel', array(), array('class'=>'btn btn-md btn-danger')); ?>
  

<!--

<br/>

Upload progress


<?php $loading= "5%"; 
$count=0;
?>
<div class="progress progress-striped active">
  <div class="progress-bar progress-bar-success"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo ($count*10) ?>%">
    <span class="sr-only">45% Complete (success)</span>
  </div>
</div>
-->

</form>
<script>
$(document).ready( function(){
    var files, 
        file, 
        extension, 
        input = document.getElementById("fileURL"),
        output = document.getElementById("fileOutput"),
        holder = document.getElementById("fileHolder");

    input.addEventListener("change", function (e) {
        files = e.target.files;
        output.innerHTML = "";

       for (var i = 0, len = files.length; i < len; i++) {
           file = files[i];
           extension = file.name.split(".").pop();
           
         $("#fileOutput").css('color', 'red');
           var fileName = file.name;
           if(extension == 'pdf')
               {
                   //fileName = "<font color='green'>" + file.name + '  -GOOD TO GO' +"</font>";
               }
          // output.innerHTML += "<li class='type-" + extension + extension + "'>" + fileName + " (" +  Math.floor(file.size/1024 * 100)/100 + "KB)</li>";
        }

                        for (var i = 0, len = files.length; i < len; i++) {
                                file = files[i];
                                extension = file.name.split(".").pop();
                                size = Math.floor(file.size/1024 * 100)/100;
                                if(size > 1000)
                                  {
                                    error = " File Too Large";
                                    color = "red";
                                    errormessage = 'The maxium files size is 1000 KB - You will need to rescan or convert this file to a lower resolution or if its a multiple page document rescan as more than one file';
                                  } else {
                                    error = " OK";
                                    color = "green";
                                    errormessage = " This file is good to go";
                                  }
                                if(extension == 'pdf')
                                  {
                                    if(color != 'red'){color = 'green'};
                                  } else {
                                    if(error == 'OK')
                                      {
                                        color = 'red'
                                        error = "";
                                        error = error + " Only PDF files are allowed";
                                        errormessage = errormessage + 'This file is not in PDF form. See the convert to PDF on the options table on the left';
                                        //errorlarge = "The maxium files size is 1000 KB. You will need to rescan or convert this file to a lower resolution or if its a multiple page document rescan a more than one file";
                                      } else {
                                        error = " Only PDF files are allowed";
                                        errormessage = 'This file is not in PDF form. See the convert to PDF on the options table on the left';                                 
                                      }                                 
                                    color  = "red";
                                  }
                                  output.innerHTML += "<font color='" + color +"'><li class='type-" + extension + extension + " ' title='"  + errormessage + "'>" + file.name + " (" +  Math.floor(file.size/1024 * 100)/100 +  "KB) - <strong>" + error + "</strong></li></font> " 
                               // $("#fileOutput").css('color', 'red');
                               // var fileName = file.name;
                                if(extension == 'pdf')
                                    {
                                     //  output.innerHTML += "<font color='" + color +"'><li class='type-" + extension + extension + "'>" + file.name + " (" +  Math.floor(file.size/1024 * 100)/100 +  "KB) - " + error + "</li></font> " 
                                    } else {
                                      //  output.innerHTML += "<strong><font color='red'><li class='type-" + extension + extension + "'>" + file.name + " (" +  Math.floor(file.size/1024 * 100)/100 + "KB  -  SHOULD BE CONVIRTED TO PDF)</li></font></strong>";
                                    }
                            }   

    }, false);








    // This event is fired as the mouse is moved over an element when a drag is occuring
    input.addEventListener("dragover", function (e) {
        holder.classList.add("highlightOver");
    });

    // This event is fired when the mouse leaves an element while a drag is occuring
    input.addEventListener("dragleave", function (e) {
        holder.classList.remove("highlightOver");
    });

    // Fires when the user releases the mouse button while dragging an object.
    input.addEventListener("dragend", function (e) {
        holder.classList.remove("highlightOver");
    });

    // The drop event is fired on the element where the drop was occured at the end of the drag operation
    input.addEventListener("drop", function (e) {
        holder.classList.remove("highlightOver");
    });
});


 </script>

                        <?php
/*
                           $count = 0;

                            if ($_SERVER['REQUEST_METHOD'] == 'POST')
                            {
                                    
                                foreach ($_FILES['fileURL']['name'] as $i => $name) {

                                  $allowedExts = array("pdf", "PDF");
                           //     $extension = end(explode(".", $_FILES["fileURL"]["name"]));


                                if ((($_FILES["fileURL"]["type"] == "image/PDF")
                                || ($_FILES["fileURL"]["type"] == "image/pdf"))
                                && ($_FILES["fileURL"]["size"] < 20000)
                                && in_array($extension, $allowedExts))

                                    if (strlen($_FILES['fileURL']['name'][$i]) > 1) {

                                        echo "uploading ".$name."<br>";
                                        if (move_uploaded_file($_FILES['fileURL']['tmp_name'][$i], 'upload/'.$name)) {
                                            $count++;

                                        }
                                    }
                                }
                                echo "<br/>Uploaded ".$count." files sucessfully";
                            }*/
                        ?>

<?php

$upload = "upload/".$user->url."/";


    $count = 0;

    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
            
        foreach ($_FILES['fileURL']['name'] as $i => $name) {
            if (strlen($_FILES['fileURL']['name'][$i]) > 1) {

                echo "Uploaded - ".$name."<br>";
               // if (move_uploaded_file($_FILES['fileURL']['tmp_name'][$i], 'upload/'.$name)) {
                  if (move_uploaded_file($_FILES['fileURL']['tmp_name'][$i], $upload.$name)) {
                    $count++;

                }
            }
        }
        echo "<br/>Uploaded ".$count." files sucessfully";

        $text = $count." files have been uploaded to Smarts Accounts";

       //  $text = "Hello " . $customer->fullname . ",\n\n This email is to remind you that you have an appointment with " . $job->Branch->name . " at " . date("H:i", $job->Event->begin) . ", " . date("d/m/Y", $job->Event->begin) . ". \n\n Please do not reply to this email, thanks. ";
                // $email = $customer->Contact->data;
                //$email = "lmscowen@gmail.com";

                $email = $user->email;

                $subject ="Document uploader";
                $headers = "From: " . "Smart  Accounts\r\n";
                mail($email, $subject, $text, $headers);
    }
?>








