<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Dhl extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index() {

		echo "Access Denied";

        $xml=$this->tracking("2160035161");
        $xml=simplexml_load_string($xml);

        //  print_r($xml);

        /// echo    $xml->Response->Status->ActionStatus;

        $ActionStatus=  @$xml->AWBInfo->Status->ActionStatus;


        if($ActionStatus=="success"){

              $ShipmentInfo= $xml->AWBInfo->ShipmentInfo;
              $DestinationServiceArea=  $ShipmentInfo->DestinationServiceArea;
              echo $DestinationServiceArea;
              $date=  $ShipmentInfo->ShipmentEvent->Date;
              $time=  $ShipmentInfo->ShipmentEvent->Time;
              $ServiceEvent=$ShipmentInfo->ShipmentEvent->ServiceEvent->Description;
              $ServiceArea=$ShipmentInfo->ShipmentEvent->ServiceArea->Description;
               echo $date."  ".$time."  ".$ServiceArea."  ".$ServiceEvent;


        }else{
            echo "error";
        }

	}


    function dhlsyn(){
        //SELECT * FROM `orderlist` m left join paypalTransactionDetail r1 on L_EBAYITEMTXNID0 in (m.transactionidarr) and L_NUMBER0 in (m.itemidarr)
       // left join orderlistprod r2 on r2.orderlistid =m.orderlistid
        //where r1.`SHIPTONAME` !=""  and r2.SKU !=""

        $orderlistid="233";


    }

	








    function pdf(){

        $dir=dirname(dirname(dirname(__FILE__)));
      //  echo $dir;

require_once($dir.'/tcpdf/tcpdf.php');
        $width = 210;
        $height = 127;


$pagelayout = array($width, $height); //  or array($height, $width)


// create new PDF document
$pdf = new TCPDF("L", PDF_UNIT, $pagelayout, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('mikeliu');
$pdf->SetTitle('');
$pdf->SetSubject('');
$pdf->SetKeywords('');

// set default header data
$pdf->SetHeaderData();
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, "tets".' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
//$pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//**** set margins
$pdf->SetMargins("0", "0", "0");

$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(0);

// set auto page breaks

$pdf->SetAutoPageBreak(TRUE, 0);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// ---------------------------------------------------------

// set default font subsetting mode
//$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('dejavusans', '', 10, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// set text shadow effect
//$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

// Set some content to print
$html = <<<EOD
75-DF3D Qty:X1<br />
From:HiHeaven International Co.,Ltd.<br />
7F., No.16, Ln. 66, Chongren St., East Dist<br />
Tainan City<br />
Taiwan(R.O.C.) ,70151<br />
(TEL) 88662896839<br />
EOD;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, 10, 50, $html, 0, 0, 0, true, '', true);


        $html = <<<EOD
75-DF3D Qty:X1<br />
From:HiHeaven International Co.,Ltd.<br />
7F., No.16, Ln. 66, Chongren St., East Dist<br />
Tainan City<br />
Taiwan(R.O.C.) ,70151<br />
(TEL) 88662896839<br />
EOD;

// Print text using writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, 105, 45, $html, 0, 0, 0, true, '', true);


        $html = <<<EOD
1234125543
EOD;

// Print text using writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, 55, 95, $html, 0, 0, 0, true, '', true);



        $html = <<<EOD
103
EOD;

// Print text using writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, 9, 98, $html, 0, 0, 0, true, '', true);



        $html = <<<EOD
4
EOD;

// Print text using writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, 25, 98, $html, 0, 0, 0, true, '', true);


        $html = <<<EOD
10
EOD;

// Print text using writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, 40, 98, $html, 0, 0, 0, true, '', true);


        $html = <<<EOD
descript
EOD;

// Print text using writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, 8, 5, $html, 0, 0, 0, true, '', true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output($dir.'/uploads/example_001.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

    }


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
