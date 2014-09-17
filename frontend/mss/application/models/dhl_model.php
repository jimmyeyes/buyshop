<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Dhl_model extends CI_Model {
	function __construct() {

		// 呼叫模型(Model)的建構函數
		parent::__construct();

	}

    function dhlapi($json){

        $json=json_decode($json);

        $MessageReference=$json->MessageReference;
        $PackageType=$json->PackageType;
        $sDate=$json->Date;

        $orderid=$json->orderid;

        if($orderid=="" || $PackageType==""){
            return "no data";
        }

        $len=strlen($MessageReference);
        if($len=="0"){
            $MessageReference=$orderid;

            $len=strlen($MessageReference);
            if($len<28){
                $less=28-$len;

                for($i=0;$i<$less;$i++){
                    $MessageReference=$MessageReference."0";
                }

            }
        }else{
            if($len<28){
                $less=28-$len;

                for($i=0;$i<$less;$i++){
                    $MessageReference=$MessageReference."0";
                }

            }
        }
        $Contents="";

        $CompanyName="";
        $AddressLine="";
        $AddressLine2="";
        $City="";
        $PostalCode="";
        $CountryCode="";
        $CountryName="";
        $PersonName="";
        $DeclaredValue="";
        $PhoneNumber="";
        $DeclaredCurrency="";

        $date=date('Y-m-d');
        $time=date('h:i:s');
        $dhlproduct="";
        $kg=0;


///load shipping info
        $sql= "select r1.* from orderlist m left join customerlist r1 on m.BuyerUserID=r1.BuyerUserID  where orderlistid='$orderid' ";
       // echo $sql;
        $query=$this->db->query($sql);
        foreach($query->result() as $row){


            $PhoneNumber=$row->Phone;
            $CompanyName=$row->Name;
            $RCompanyName=$row->Name;
            $PersonName=$row->Name;
            if(strlen($RCompanyName) >35){
                $CompanyName=substr($RCompanyName,0,34);
                $PersonName=substr($RCompanyName,34,strlen($RCompanyName)-34);

                //   echo $RAddressLine.".  in:".$AddressLine."  2:".$AddressLine2;
            }


            $AddressLine=$row->Street1.' '.$row->Street2;
            $RAddressLine=$row->Street1.' '.$row->Street2;
            if(strlen($RAddressLine) >35){
                $AddressLine=substr($RAddressLine,0,34);
                $AddressLine2=substr($RAddressLine,34,strlen($RAddressLine)-34);

             //   echo $RAddressLine.".  in:".$AddressLine."  2:".$AddressLine2;
            }

            $City=$row->CityName;
            $PostalCode=$row->PostalCode;
            $CountryCode=$row->Country;
            $CountryName=$row->CountryName;


        }

        //echo $CompanyName;
        if($CountryCode==""){
            return "custome data no Country code";
        }


        //SEARCH product
        $sql= "select * from orderlistprod  where  orderlistid='$orderid'";
        $query=$this->db->query($sql);
        $count=$query->num_rows();

        if($count ==0){
            //  是否自行輸入單
            $sql=" SELECT * FROM `orderlist` m  where PaymentMethods='trans' and  m.orderlistid='$orderid'";
            $query=$this->db->query($sql);
           if($query->num_rows() ==0){
               return "error no product";
           }
            $row=$query->row();
            $DeclaredValue=$row->Total;
            $DeclaredCurrency="USD";

            if($DeclaredValue==""){
                return "Order not enter Price";
            }

            $dhlproduct.='<ShipmentDetails><NumberOfPieces>1</NumberOfPieces><Pieces>';
            $dhlproduct.='
			<Piece>
				<PieceID>1</PieceID>
				<PackageType>'.$PackageType.'</PackageType>';
                $weight=0.5;

                $dhlproduct.='
				<Weight>'.$weight.'</Weight>
				<Width>10</Width>
				<Height>10</Height>
				<Depth>10</Depth>
			</Piece>
            ';
                $kg+=$weight;

        }else{


            $Contents=$orderid;

           foreach($query->result() as $row){
                if($Contents==""){
                    $Contents.=$row->SKU;
                }else{
                    $Contents.=','.$row->SKU;
                }
            }

            $sql="select * from mynote where orderlistid='$orderid'";
            $row456=$this->db->query($sql)->row();

            if(!empty($row456->content) ){
                $Contents.=",".$row456->content;
            }

            $dhlproduct.='
	<ShipmentDetails>
		<NumberOfPieces>'.$count.'</NumberOfPieces>
		 <Pieces>';
            $i=1;
            foreach($query->result() as $row){
                $dhlproduct.='
			<Piece>
				<PieceID>'.$i.'</PieceID>
				<PackageType>'.$PackageType.'</PackageType>';
                $weight=0.5;

                $dhlproduct.='
				<Weight>'.$weight.'</Weight>
				<Width>10</Width>
				<Height>10</Height>
				<Depth>10</Depth>
			</Piece>
            ';
                $kg+=$weight;
            }


            $sql= "select * from orderlist m   where orderlistid='$orderid' ";
            $query=$this->db->query($sql);
            foreach($query->result() as $row){
                $sql="select * from paypalTransactionDetail  where L_EBAYITEMTXNID0 in ($row->transactionidarr) and L_NUMBER0 in ($row->itemidarr)";
                // echo $orderid;
               // echo $sql;
                $query2=$this->db->query($sql);
                $count=$query->num_rows();
                if($count ==0){
                    return "error paypal info";
                }

                foreach($query2->result() as $row2){
                   // echo $row2->PAYMENTSTATUS;
                  //  echo $row2->AMT;
                    if($row2->PAYMENTSTATUS=="Completed"){
                        //echo $row2->AMT;
                        $DeclaredValue=$row2->AMT;
                        $DeclaredCurrency=$row2->CURRENCYCODE;
                    }

                }
            }
        }


       $arr1=array('AE','AF'.'AL'.'AM'.'AO'.'AU'.'BA'.'BD'.'BH'.'BN'.'BW'.'BY'.'CD'.'CG'.'CI'.'CM'.'CN'.'CY'.'DZ'.'EG'.'ET'.'FJ'.'GA'.'GH'.'HK'.'ID'.'IN'.'IQ'.'IR'.'JO'.'JP'.'KE'.'KG'.'KH'.'KR'.'KW'.'KZ'.'LB'.'LK'.'LS'.'MA'.'MD'.'MG'.'MK'.'ML'.'MM'.'MO'.'MT'.'MU'.'MW'.'MY'.'MZ'.'NA'.'NE'.'NG'.'NP'.'NZ'.'OM'.'PG'.'PH'.'PK'.'QA'.'RE'.'RS'.'RU'.'SA'.'SD'.'SG'.'SL'.'SN'.'SY'.'SZ'.'TG'.'TH'.'TJ'.'TM'.'TR'.'TW'.'TZ'.'UA'.'UG'.'UZ'.'VN'.'YE'.'ZA'.'ZM'.'ZW');
        $arr2=array('AT','BE','BG','CH','CZ','DE','DK','EE','ES','FI','FR','GB','GR','HU','IE','IS','IT','LT','LU','LV','NL','NO','PL','PT','RO','SE','SI','SK');
    $arr3=array('AG','AI','AR','AW','BB','BM','BO','BR','BS','BZ','CA','CL','CO','CR','DM','DO','EC','GF','GP','GT','GY','HN','JM','KN','KY','LC','MQ','MX','NI','PA','PE','PY','SR','SV','TC','TT','US','UY','VC','VE','VG','VI','XC','XM','XN','XY');


    $key1=array_search($CountryCode,$arr1);
    $key2=array_search($CountryCode,$arr2);
     $key3=array_search($CountryCode,$arr3);

        $RegionCode="AP";

        if($key1>=0){
            $RegionCode="AP";
        }else if($key1>=0){
            $RegionCode="EU";
        }else if($key1>=0){
            $RegionCode="AM";
        }


        $post_string='<?xml version="1.0" encoding="UTF-8"?>
<req:ShipmentRequest xmlns:req="http://www.dhl.com" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.dhl.com ship-val-global-req.xsd" schemaVersion="1.0">
	<Request>
		<ServiceHeader>
			<MessageTime>'.$date.'T'.$time.'-08:00</MessageTime>
			<MessageReference>'.$MessageReference.'</MessageReference>
                <SiteID>HIHEAVENINT</SiteID>
			<Password>9vCeJmGthH</Password>
		</ServiceHeader>
	</Request>
	<RegionCode>'.$RegionCode.'</RegionCode>
	<LanguageCode>en</LanguageCode>
	<PiecesEnabled>Y</PiecesEnabled>
	<Billing>
		<ShipperAccountNumber>620828482</ShipperAccountNumber>
		<ShippingPaymentType>S</ShippingPaymentType>
	</Billing>
	<Consignee>';

        $post_string.='
		<CompanyName>'.$CompanyName.'</CompanyName>
		<AddressLine>'.$AddressLine.'</AddressLine>';



        if($AddressLine2!=""){
$post_string.='
		<AddressLine>'.$AddressLine2.'</AddressLine>';
        }



$post_string.='
		<City>'.$City.'</City>
		<PostalCode>'.$PostalCode.'</PostalCode>
		<CountryCode>'.$CountryCode.'</CountryCode>
		<CountryName>'.$CountryName.'</CountryName>
		<Contact>
			<PersonName>'.$PersonName.'</PersonName>
			<PhoneNumber>'.$PhoneNumber.'</PhoneNumber>
		</Contact>
	</Consignee>
	<Dutiable>
		<DeclaredValue>'.$DeclaredValue.'</DeclaredValue>
		<DeclaredCurrency>'.$DeclaredCurrency.'</DeclaredCurrency>
	</Dutiable>';


        $post_string.=$dhlproduct;


        $post_string.='
        	</Pieces>
		<Weight>'.$kg.'</Weight>
		<WeightUnit>K</WeightUnit>
		<GlobalProductCode>P</GlobalProductCode>
		<LocalProductCode>P</LocalProductCode>
		<Date>'.$sDate.'</Date>
        <Contents>'.$Contents.'</Contents>
		<DimensionUnit>C</DimensionUnit>';
//	<InsuredAmount>'.$InsuredAmount.'</InsuredAmount>
        $post_string.='
		<PackageType>'.$PackageType.'</PackageType>
		<IsDutiable>Y</IsDutiable>
		<CurrencyCode>'.$DeclaredCurrency.'</CurrencyCode>
	</ShipmentDetails>
	<Shipper>';

        $sql= "select * from orderlist m left join accounttoken r1 on m.accounttokenid=r1.accounttokenid where orderlistid='$orderid' and  addr!='' ";
        // echo $sql;
        $query=$this->db->query($sql);

        $count=$query->num_rows();
        if($count ==0){

            $sql= "select * from accounttoken  where 1 order by accounttokenid asc limit 1";
           // echo $sql;
            $query=$this->db->query($sql);
            $count=$query->num_rows();
            if($count ==0){
                return "no send  data";
            }
        }

        $CompanyName="";
        $AddressLine="";
        $City="";
        $CountryName="";
        $PhoneNumber="";
        $PersonName="";
        $DivisionCode="";
        $PostalCode="";
        foreach($query->result() as $row){
            $CompanyName=$row->name;
            $AddressLine=$row->addr;
            $City=$row->city;
            $CountryName=$row->country;
            $PhoneNumber=$row->phone;
            $PersonName=$row->PersonName;
            $PostalCode=$row->zipcode;
        }
//<PostalCode>'.$PostalCode.'</PostalCode>

        $post_string.='
		<ShipperID>620828482</ShipperID>
		<CompanyName>'.$CompanyName.'</CompanyName>
		<AddressLine>'.$AddressLine.' </AddressLine>
		<City>'.$City.'</City>
		<DivisionCode>East</DivisionCode>

		<CountryCode>TW</CountryCode>
		<CountryName>'.$CountryName.'</CountryName>
		<Contact>
			<PersonName>'.$PersonName.'</PersonName>
			<PhoneNumber>'.$PhoneNumber.'</PhoneNumber>
		</Contact>
	</Shipper>
	<LabelImageFormat>PDF</LabelImageFormat>
</req:ShipmentRequest>';

        $xml=$this->runfunction($post_string);

        // echo $xml;
        $xml=simplexml_load_string(utf8_encode($xml));
        $status= $xml->Response->Status->ActionStatus;
        if($status=="Error" ){
           return    $xml->Response->Status->Condition->ConditionData;

        }


        $SiteID=@$xml->Response->ServiceHeader->SiteID;
        if($SiteID ==""){
            return    $xml->Response->Status->Condition->ConditionData;
        }

        $MessageTime=$xml->Response->ServiceHeader->MessageTime;
        $MessageReference=$xml->Response->ServiceHeader->MessageReference;
        $SiteID=$xml->Response->ServiceHeader->SiteID;
        $RegionCode=$xml->RegionCode;
        $ActionNote=$xml->Note->ActionNote;
        $AirwayBillNumber=$xml->AirwayBillNumber;
        $BillingCode=$xml->BillingCode;
        $CurrencyCode=$xml->CurrencyCode;
        $CourierMessage=$xml->CourierMessage;
        $DestinationServiceAreaServiceAreaCode=$xml->DestinationServiceArea->ServiceAreaCode;
        $DestinationServiceAreaFacilityCode=$xml->DestinationServiceArea->FacilityCode;
        $DestinationServiceAreaInboundSortCode=$xml->DestinationServiceArea->InboundSortCode;
        $OriginServiceAreaServiceAreaCode=$xml->OriginServiceArea->ServiceAreaCode;
        $OriginServiceAreaOutboundSortCode=$xml->OriginServiceArea->OutboundSortCode;
        $Rated=$xml->Rated;
        $InsuredAmount=$xml->InsuredAmount;
        $WeightUnit=$xml->WeightUnit;
        $ChargeableWeight=$xml->ChargeableWeight;
        $DimensionalWeight=$xml->DimensionalWeight;
        $CountryCode=$xml->CountryCode;
        $AWBBarCode=$xml->Barcodes->AWBBarCode;
        $OriginDestnBarcode=$xml->Barcodes->OriginDestnBarcode;
        $DHLRoutingBarCode=$xml->Barcodes->DHLRoutingBarCode;
        $Piece=$xml->Piece;
        $Contents=$xml->Contents;
        $CustomerID=$xml->CustomerID;
        $ShipmentDate=$xml->ShipmentDate;
        $GlobalProductCode=$xml->GlobalProductCode;
        $ShipperAccountNumber=$xml->Billing->ShipperAccountNumber;
        $ShippingPaymentType=$xml->Billing->ShippingPaymentType;
        $DutyPaymentType=$xml->Billing->DutyPaymentType;
        $DeclaredValue=$xml->Dutiable->DeclaredValue;
        $DeclaredCurrency=$xml->Dutiable->DeclaredCurrency;
        $DHLRoutingCode=$xml->DHLRoutingCode;
        $DHLRoutingDataId=$xml->DHLRoutingDataId;
        $ProductContentCode=$xml->ProductContentCode;
        $ProductShortName=$xml->ProductShortName;
        $InternalServiceCode=$xml->InternalServiceCode;
        $Pieces=$xml->Pieces->Piece;

        $OutputFormat=$xml->LabelImage->OutputFormat;
        $OutputImage=$xml->LabelImage->OutputImage;


        if($RegionCode !="" && $ActionNote!="" &&$OutputImage !=""){


            $sql="select * from dhlserviceresponse where orderlistid='$orderid'";
            $count=$this->db->query($sql)->num_rows();

            if($count >0 ){

                $sql="update dhlserviceresponse set  OutputImage='$OutputImage' where orderlistid='$orderid'";
                $query=$this->db->query($sql);

             //   echo "update";


            }else{

             //   echo "insert";

            $sql="insert into dhlserviceresponse values (null,'$RegionCode','$ActionNote','$MessageTime','$MessageReference','$SiteID','$AirwayBillNumber','$BillingCode','$CurrencyCode','$CourierMessage',";
            $sql.="'$DestinationServiceAreaServiceAreaCode','$DestinationServiceAreaFacilityCode','$DestinationServiceAreaInboundSortCode','$OriginServiceAreaServiceAreaCode','$OriginServiceAreaOutboundSortCode',";
            $sql.="'$Rated','$InsuredAmount','$WeightUnit','$ChargeableWeight','$DimensionalWeight','$CountryCode','$AWBBarCode','$OriginDestnBarcode','$DHLRoutingBarCode','$Piece','$Contents','$CustomerID',";
            $sql.="'$ShipmentDate','$GlobalProductCode','$ShipperAccountNumber','$ShippingPaymentType','$DutyPaymentType','$DeclaredValue','$DeclaredCurrency','$DHLRoutingCode','$DHLRoutingDataId',";
            $sql.="'$ProductContentCode','$ProductShortName','$InternalServiceCode','$OutputFormat','$OutputImage','0','0','$orderid',NOW())";

            $query=$this->db->query($sql);
            $dhlserviceresponseid=$this->db->insert_id();


            if(count($Pieces) >0){
                foreach($Pieces as $pics){
                    $DataIdentifier=$pics->DataIdentifier;
                    $LicensePlate=$pics->LicensePlate;
                    $LicensePlateBarCode=$pics->LicensePlateBarCode;

                    $sql="insert into dhlservicepieces values (null,'$DataIdentifier','$LicensePlate','$LicensePlateBarCode',NOW(),'$dhlserviceresponseid') ";
                    $query=$this->db->query($sql);

                }
            }

            }

        }else{

            return    $xml->Response->Status->Condition->ConditionData;

        }



    }


    function tracking($AWBNumber){

        $date=date('Y-m-d');
        $time=date('h:i:s');

        $MessageReference="1234567890123456789012345678901";


        $post_string='<?xml version="1.0" encoding="UTF-8"?>
<req:KnownTrackingRequest xmlns:req="http://www.dhl.com" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.dhl.com TrackingRequestKnown.xsd">
	<Request>
		<ServiceHeader>
				<MessageTime>'.$date.'T'.$time.'-08:00</MessageTime>
			<MessageReference>'.$MessageReference.'</MessageReference>
                <SiteID>HIHEAVENINT</SiteID>
			<Password>9vCeJmGthH</Password>
		</ServiceHeader>
	</Request>
<LanguageCode>en</LanguageCode>
	<AWBNumber>8564385550</AWBNumber>
	<LevelOfDetails>ALL_CHECK_POINTS</LevelOfDetails>
	<PiecesEnabled>S</PiecesEnabled>
</req:KnownTrackingRequest>
        ';

        //   echo $post_string;
        $xml=$this->runfunction($post_string);

        return $xml;

    }


    function runfunction($post_string){

        //echo "start runfunction";

        $session  = curl_init("https://xmlpi-ea.dhl.com/XMLShippingServlet");                       // create a curl session

// https://xmlpitest-ea.dhl.com/XMLShippingServlet

        curl_setopt($session, CURLOPT_POST, true);              // POST request type
        curl_setopt($session, CURLOPT_POSTFIELDS, $post_string); // set the body of the POST
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);    // return values as a string - not to std out

        $responseXML = curl_exec($session);                     // send the request
        curl_close($session);

        //echo "end runfunction";

        return $responseXML;  // returns a string
    }




 }