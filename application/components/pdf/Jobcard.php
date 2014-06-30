<?php

namespace application\components\pdf;
use \Yii;

class Jobcard
{

    protected $url;

public function __construct($type, $id)// public function __construct($file)
{
$jobid=$id;
        //  $imageurl=Yii::app()->assetPublisher->publish(Yii::getPathOfAlias('application.views.assets.images') . '/logo.gif ');
        //      $image= \CHtml::image($imageurl, 'User', array('height' => 90));


//   try get file contents  //
// open in style tags   open->

$statement = file_get_contents(Yii::getPathOfAlias('application.documents.template') . "/".$type.".php");


//  RUN FIND AND REPLACE *************************************************************************
//$statement2 = new \application\components\pdf\findandreplace('1234', $statement);
//echo $statement2;
                        $job = \application\models\db\job\Job::model()->findByPK($jobid);
                        $branch =  \application\models\db\Branch::model()->findByPK(Yii::app()->user->branch);

                        //$customer_name = $job->Customer->title.' '.$job->Customer->firstname.' '$job->Customer->lastname;

                        $statement = str_replace("[customer full name]", $job->Customer->fullname, $statement);
                       $statement = str_replace("[address1]", $job->Customer->Address->line1, $statement);
                       $statement = str_replace("[town]", $job->Customer->Address->line3, $statement);
                       $statement = str_replace("[city]", $job->Customer->Address->line4, $statement);
                       $statement = str_replace("[postcode]", $job->Customer->Address->postalCode, $statement);
                        $statement = str_replace("[job no]", $job->id, $statement);
                        $statement = str_replace("[date]", Yii::app()->dateFormatter->formatDateTime(time(), 'long', null), $statement);
                        if(isset($job->registration)){ $statement = str_replace("[reg]", $job->registration, $statement);} else { $statement = str_replace("[reg]", 'N/A', $statement);}
                        $statement = str_replace("[tel]", $job->id, $statement);
                        $statement = str_replace("makemodel", $job->Model->name." ".$job->Model->Make->name, $statement);


                        $statement = str_replace("[Description1]", isset($job->Parts[0]) ? $job->Parts[0]->description : null, $statement);
                        $statement = str_replace("[Description2]", isset($job->Parts[1]) ? $job->Parts[1]->description : null, $statement);
                        $statement = str_replace("[Description3]", isset($job->Parts[2]) ? $job->Parts[2]->description : null, $statement);
                        $statement = str_replace("[Description4]", isset($job->Parts[3]) ? $job->Parts[3]->description : null, $statement);

                        $statement = str_replace("[Qty1]", isset($job->Parts[0]) ? $job->Parts[0]->quantity : null, $statement);
                        $statement = str_replace("[Qty2]", isset($job->Parts[1]) ? $job->Parts[1]->quantity : null, $statement);
                        $statement = str_replace("[Qty3]", isset($job->Parts[2]) ? $job->Parts[2]->quantity : null, $statement);
                        $statement = str_replace("[Qty4]", isset($job->Parts[3]) ? $job->Parts[3]->quantity : null, $statement);

                        $statement = str_replace("[Price1]", isset($job->Parts[0]) ? $job->Parts[0]->price : null, $statement);
                        $statement = str_replace("[Price2]", isset($job->Parts[1]) ? $job->Parts[1]->price : null, $statement);
                        $statement = str_replace("[Price3]", isset($job->Parts[2]) ? $job->Parts[2]->price : null, $statement);
                        $statement = str_replace("[Price4]", isset($job->Parts[3]) ? $job->Parts[3]->price : null, $statement);

                        $statement = str_replace("[part1]", isset($job->Parts[0]->PartType) ? $job->Parts[0]->PartType->name : null, $statement);
                        $statement = str_replace("[part2]", isset($job->Parts[1]->PartType) ? $job->Parts[1]->PartType->name : null, $statement);
                        $statement = str_replace("[part3]", isset($job->Parts[2]->PartType) ? $job->Parts[2]->PartType->name : null, $statement);
                        $statement = str_replace("[part4]", isset($job->Parts[3]->PartType) ? $job->Parts[3]->PartType->name : null, $statement);


                        If(!empty($job->customerNotes)){$statement = str_replace("No customer instrucions", $job->customerNotes, $statement);}
                        If($job->deposit >1){$statement = str_replace("total_", $job->deposit, $statement);}else{ $statement = str_replace("total_d", '0.00', $statement);}
                        $statement = str_replace("total_t", $job->total/100, $statement);
                        $statement = str_replace("[note]", $job->sound, $statement);
                        $statement = str_replace("[tailpipe]", $job->tailpipe, $statement);



                        // user  and branch info


                        $statement = str_replace("[branch name]", $branch->name, $statement);
                        $statement = str_replace("[branch address]", $branch->address, $statement);
                        if(!empty($branch->postcode)){$statement = str_replace("[branch postcode]", $branch->postcode, $statement);}else{$statement = str_replace("[branch postcode]", ".", $statement);}
                        $statement = str_replace("[branch tel]", $branch->sales, $statement);
                        $statement = str_replace("[branch email]", $branch->email, $statement);
                        if(!empty($branch->vat)){$statement = str_replace("[branch vat]", $branch->vat, $statement);}else {$statement = str_replace("[branch vat]", "-", $statement);}

                       // Yii::app()->user->Branch->name



$text = $statement;
$file = $statement;
$txt = $statement;
/////$PDF = new \application\components\PdfManager3($customer->id,$text,null,null,null,null);
    $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('NOSCO');
    $pdf->SetTitle('Nosco');
    $pdf->SetSubject('Document');
    $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// remove default header/footer
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);

    // $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, ' ', PDF_FONT_SIZE_DATA, ));

// set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetMargins(PDF_MARGIN_LEFT, 5, PDF_MARGIN_RIGHT, true);
    // $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
  //  $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
//if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
//    require_once(dirname(__FILE__).'/lang/eng.php');
//    $pdf->setLanguageArray($l);
//}

// ---------------------------------------------------------

// set font
    $pdf->SetFont('times', '', 11);

// add a page
    $pdf->AddPage();


    $pos = strpos($txt, '</');
     if ($pos == false) { $pdf->Write(0, $txt, '', 0, 'L', true, 0, false, false, 0);} else
        {$pdf->writeHTML($txt, true, false, true, false, '');}


//  detect document type
        $doc_type = 'X';
        $pos = strpos($txt, 'STATEMENT');
        if ($pos == false) { $doc_type = 'X';} else
        {$doc_type = 'statement';}


                                        $filename = $jobid."-".$type."-".time().".pdf";



                                        $filelocation = Yii::getPathOfAlias('webroot.xdocuments.customer');//  WORKS ON BOTH
                                 //       $filelocation = 'xdocuments\customer';
                                        $fileNL = $filelocation."\\".$filename; // linux
                                        $fileNL = str_replace('\\','/',$fileNL);

                                        $fileNL = $filelocation."/".$filename;




                                     //   $pdf->Output($fileNL,'F');
                                        $pdf->Output($fileNL,'F');

                                     //   var_dump($fileNL);
                                     //   exit;
// save details in documents table

                                        $document = new \application\models\db\Document;
                                        $document->attributes = array(
                                            'created'       => time(),
                                            'name'          => $type,
                                            'user'          => Yii::app()->user->id,
                                            'customer'      => $job->Customer->id,
                                            'address'       => $filename,
                                            'job'           => $job->id,


                                            );
                                        $document->save();


        $url= Yii::app()->createUrl('xdocuments/customer');

     // $url =$url.'/'.$filename;

        $this->url = $url.'/'.$filename;

     // var_dump($url);






/*

?>  <!--<script type="text/javascript" language="Javascript">window.open('documents/customer/2611_statement_1389286670.pdf');</script> --> <?php

////exit;
$file=$text;
//echo $file;
$filename = \application\models\db\Document::model()->findAllByAttributes(array('customer'=>$_GET['id']),array('order'=>'created DESC'));
$filename = $filename['0']->name;
$filename = 'documents/customer/'.$filename;
//$this->redirect(array('/documents/customer/2611_statement_1389285599.pdf'));
//$this->redirect(filename);
// header("Location: $filename");
//echo '<script> window.location="documents/customer/614_statement_1389875615.pdf"; </script> ';
echo '<script type="text/javascript" language="Javascript">window.open("documents/customer/614_statement_1389875615.pdf");</script>';
exit;
*/




                                    }



    /**
     * Get: Jobcard URL
     *
     * @access public
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Get: Javascript Popup Link
     *
     * @access public
     * @return string
     */
    public function getPopupLink($width = 820, $height = 900)
    {
        return '<script type="text/javascript" language="Javascript">window.open("'.$this->url.'","_blank","toolbar=no, scrollbars=yes, resizable=yes, , width='.$width.', height='.$height.'");</script>';
    }

}
