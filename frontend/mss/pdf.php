<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/fpdf17/fpdf.php');
require_once($_SERVER['DOCUMENT_ROOT']."/fpdi/fpdi.php");

// initiate FPDI
$pdf = new FPDI();
// add a page
//$pdf->AddPage();
// set the source file


$filename="";
$filename=@$_GET['name'];
if($filename ==""){
echo "error no name";
return;
}
$pageCount = $pdf->setSourceFile("uploads/".$filename.".pdf");
//echo "uploads/".$filename.".pdf";
// import page 1

$i=0;
// iterate through all pages
for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
    // import a page
   // echo $pageNo;
    $templateId = $pdf->importPage($pageNo);
    // get the size of the imported page
    $size = $pdf->getTemplateSize($templateId);

    // create a page (landscape or portrait depending on the imported page size)
    if ($size['w'] > $size['h']) {
        $pdf->AddPage('L', array($size['w'], $size['h']));
    } else {
        $pdf->AddPage('P', array($size['w'], $size['h']));
    }
    // use the imported page
    //$pdf->useTemplate($templateId);
    $pdf->useTemplate($templateId, null,null,102,200,true);

    //////image
    $im = new imagick();
    $im->setResolution(400,400);
    $pdfn='uploads/'.$filename.'.pdf['.$i.']';
  //  echo $pdfn;
    $im->readimage($pdfn);
    if($im){
      //  echo $im;
    }

  //  $im->scaleimage(1000,0);
    $im->setImageFormat('jpeg');



    $im->writeImage('uploads/thumb.jpg');

//$img->setImageUnits(imagick::RESOLUTION_PIXELSPERINCH);

//print_r($img->identifyImage());


   // $im=$im->flattenimages();

    $imgSrc = "uploads/thumb.jpg";
    $im = new imagick($imgSrc );
    /* create the thumbnail */
    $im->cropThumbnailImage( 2200, 2000 );
    /* Write to a file */
    $im->writeImage( "uploads/$filename.$i.png" );

    //////image


    $pdf->Image("uploads/".$filename.'.'.$i.'.png',0,0,-250);

    $im->clear();
    $im->destroy();

$i++;
}


//$tplIdx = $pdf->importPage(1);
// use the imported page and place it at point 10,10 with a width of 100 mm
//$pdf->useTemplate($tplIdx, null,null,102, 200,true);




$pdf->Output();