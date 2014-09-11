<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Ebayapi_model extends CI_Model {


    var $schedule;
    var $time;
    var $cer;
    var $dev;
    var $app;

	function __construct() {

		// 呼叫模型(Model)的建構函數
		parent::__construct();

        $sql="select *  from webauth ";
        //echo $sql;
        $query=$this->db->query($sql);
        foreach($query->result() as $row){
            $this->cer=$row->cert;
            $this->dev=$row->dev;
            $this->app=$row->app;
        }
	}

    function runfunctionpost($post_string,$callname,$site){

        //echo "start runfunction";

        $session  = curl_init($this->all_model->url);                       // create a curl session

        curl_setopt($session, CURLOPT_POST, true);              // POST request type
        curl_setopt($session, CURLOPT_POSTFIELDS, $post_string); // set the body of the POST
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);    // return values as a string - not to std out


        if($site=="US"){
            $siteid="1";
        }else if($site=="Australia"){
            $siteid="15";
        }else if($site=="UK"){
            $siteid="3";
        }


        $headers = array(
            "X-EBAY-API-CALL-NAME:".$callname."",
            "X-EBAY-API-SITEID:".$siteid,                                // Site 0 is for US
            "X-EBAY-API-COMPATIBILITY-LEVEL:837",
            "X-EBAY-API-CERT-NAME:".$this->cer."",
            "X-EBAY-API-DEV-NAME:".$this->dev."",
            "X-EBAY-API-APP-NAME:".$this->app."",
            "Content-Type:text/xml;charset=utf-8"
        );
        curl_setopt($session, CURLOPT_HTTPHEADER, $headers);    //set headers using the above array of headers

        $responseXML = curl_exec($session);                     // send the request
        curl_close($session);

        //echo "end runfunction";

        return $responseXML;  // returns a string
    }


    function runfunction($post_string,$callname){

        //echo "start runfunction";

        $session  = curl_init($this->all_model->url);                       // create a curl session

        curl_setopt($session, CURLOPT_POST, true);              // POST request type
        curl_setopt($session, CURLOPT_POSTFIELDS, $post_string); // set the body of the POST
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);    // return values as a string - not to std out

        $headers = array(
            "X-EBAY-API-CALL-NAME:".$callname."",
            "X-EBAY-API-SITEID:1",                                // Site 0 is for US
            "X-EBAY-API-COMPATIBILITY-LEVEL:837",
            "X-EBAY-API-CERT-NAME:".$this->cer."",
            "X-EBAY-API-DEV-NAME:".$this->dev."",
            "X-EBAY-API-APP-NAME:".$this->app."",
            "Content-Type:text/xml;charset=utf-8"
        );
        curl_setopt($session, CURLOPT_HTTPHEADER, $headers);    //set headers using the above array of headers

        $responseXML = curl_exec($session);                     // send the request
        curl_close($session);

        //echo "end runfunction";

        return $responseXML;  // returns a string
    }




    function ReviseItem($accounttokenid,$itemid,$productid){
        $token="";
        $currency="";
        $Site="";
        $sql="select * from accounttoken where accounttokenid='".$accounttokenid."'";
        $result =$this->db->query($sql);
        foreach($result->result() as $row){
            $token= $row->token;
            $currency=$row->Currency;
        }

        if($currency=="GBP"){
            $Site="UK";
        }else if($currency=="USD"){
            $Site="US";
        }else if($currency=="AUD"){
            $Site="Australia";
        }


        $Title="";
        $Description="";
        $CategoryID="";
        $StartPrice="";
        $ConditionID="";
        $Country="";
        $Currency="";
        $DispatchTimeMax="";
        $ListingDuration="";
        $ListingType="";
        $PaymentMethods="";
        $PayPalEmailAddress="";
        $PostalCode="";
        $Quantity="";
        $ReturnsAcceptedOption="";
        $RefundOption="";
        $RefundOption="";
        $ReturnsWithinOption="";
        $ReturnsDescription="";
        $ShippingCostPaidByOption="";
        $ShippingType="";
        $ShippingServicePriority="";
        $ShippingService="";
        $ShippingServiceCost="";

        $BuyItNowPrice="";

        $InternationalShippingService="";
        $InternationalShippingServicePriority="";
        $InternationalShippingServiceCost="";
        $InternationalShipToLocation="";
        $InternationalShippingServiceAdditionalCost="";

        $ShippingServicePriority="";
        $ShippingService="";
        $ShippingServiceCost="";

        $InternationalShippingService2="";
        $InternationalShippingServicePriority2="";
        $InternationalShippingServiceCost2="";
        $InternationalShipToLocation2="";
        $InternationalShippingServiceAdditionalCost2="";

        $ShippingServicePriority2="";
        $ShippingService2="";
        $ShippingServiceCost2="";
        $brand="";
        $mpn="";
        $ean="";
        $upc="";
        $FreeShipping="";
        $autopay="";
        $ProductReferenceID="";
        $StoreCategoryID="";
        $Location="";
        $PrivateListing="";
        $ShippingServiceAdditionalCost="";
        $ShippingServiceAdditionalCost2="";


        $sql="select * from productactive where productactiveid='".$productid."'";
        $result =$this->db->query($sql);
        foreach($result->result() as $row){

            $Title=$row->ebaytitle;
            $Description=$row->spec;


            $CategoryID=$row->category;
            if($row->currencyID=="GBP"){
                $StartPrice=$row->PriceGBP;
            }else if($row->currencyID=="USD"){
                $StartPrice=$row->StartPrice;
            }else if($row->currencyID=="AUD"){
                $StartPrice=$row->PriceAUD;

            }
            $ConditionID=$row->ConditionID;
            $Country=$row->Country;
            $Currency=$currency;
            $DispatchTimeMax=$row->DispatchTimeMax;
            $ListingDuration=$row->ListingDuration;
            $ListingType=$row->ListingType;
            $PaymentMethods=$row->PaymentMethods;
            $PayPalEmailAddress=$row->PayPalEmailAddress;
            $Quantity=$row->Quantity;
            $ReturnsAcceptedOption=$row->ReturnsAcceptedOption;
            $RefundOption=$row->RefundOption;
            $ReturnsWithinOption=$row->ReturnsWithinOption;
            $ReturnsDescription=$row->ReturnsDescription;
            $ShippingCostPaidByOption=$row->ShippingCostPaidByOption;
            $ShippingType=$row->ShippingType;

            $ShippingServicePriority=$row->ShippingServicePriority;
            $ShippingService=$row->ShippingService;
            $ShippingServiceCost=$row->ShippingServiceCost;

            $InternationalShippingService=$row->InternationalShippingService;
            $InternationalShippingServicePriority=$row->InternationalShippingServicePriority;
            $InternationalShippingServiceCost=$row->InternationalShippingServiceCost;
            $InternationalShipToLocation=$row->InternationalShipToLocation;
            $InternationalShippingServiceAdditionalCost=$row->InternationalShippingServiceAdditionalCost;


            $ShippingServicePriority2=$row->ShippingServicePriority2;
            $ShippingService2=$row->ShippingService2;
            $ShippingServiceCost2=$row->ShippingServiceCost2;


            $InternationalShippingService2=$row->InternationalShippingService2;
            $InternationalShippingServicePriority2=$row->InternationalShippingServicePriority2;
            $InternationalShippingServiceCost2=$row->InternationalShippingServiceCost2;
            $InternationalShipToLocation2=$row->InternationalShipToLocation2;
            $InternationalShippingServiceAdditionalCost2=$row->InternationalShippingServiceAdditionalCost2;

            $brand=$row->brand;
            $mpn=$row->mpn;
            $ean=$row->ean;
            $upc=$row->upc;
            $sku=$row->sku;
            $FreeShipping=$row->FreeShipping;
            $autopay=$row->AutoPay;
            $StoreCategoryID=$row->storecategory;

            $exclude=$row->exclude;
            $ProductReferenceID=$row->ProductReferenceID;
            $Location=$row->Location;
            $PrivateListing=$row->PrivateListing;

            $ShippingServiceAdditionalCost=$row->ShippingServiceAdditionalCost;
            $ShippingServiceAdditionalCost2=$row->ShippingServiceAdditionalCost2;


        }

                $post_string = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
        <ReviseItemRequest xmlns=\"urn:ebay:apis:eBLBaseComponents\">
        <ErrorLanguage>en_US</ErrorLanguage>
        <Item>
        <ItemID>".$itemid."</ItemID>
         <Title>".$Title."</Title>
           <Description> <![CDATA[".$Description."]]></Description>
          <PrimaryCategory>
        <CategoryID>".$CategoryID."</CategoryID>
        </PrimaryCategory>
        <StartPrice>".$StartPrice."</StartPrice>";

                if($StoreCategoryID !=""){
                    $post_string .=" <Storefront>
                        <StoreCategoryID>".$StoreCategoryID."</StoreCategoryID>
                     </Storefront>";
                }

                $post_string .="
        <ConditionID>".$ConditionID."</ConditionID>
        <Country>".$Country."</Country>
        <Currency>".$Currency."</Currency>
             <AutoPay>".$autopay."</AutoPay>
          <PrivateListing>".$PrivateListing."</PrivateListing>
        <DispatchTimeMax>".$DispatchTimeMax."</DispatchTimeMax>
        <ListingDuration>".$ListingDuration."</ListingDuration>
        <ListingType>".$ListingType."</ListingType>
        <PaymentMethods>".$PaymentMethods."</PaymentMethods>
        <PayPalEmailAddress>".$PayPalEmailAddress."</PayPalEmailAddress>";

        if($ProductReferenceID!=""){
            $post_string .="
                   <ProductListingDetails>
                      <ProductReferenceID>".$ProductReferenceID."</ProductReferenceID>
                      <IncludeStockPhotoURL>true</IncludeStockPhotoURL>
                      <IncludePrefilledItemInformation>true</IncludePrefilledItemInformation>
                      <UseFirstProduct>true</UseFirstProduct>
                      <UseStockPhotoURLAsGallery>true</UseStockPhotoURLAsGallery>
                      <ReturnSearchResultOnDuplicates>true</ReturnSearchResultOnDuplicates>
                </ProductListingDetails>";
        }else{


        }
        $post_string .="
        <Quantity>".$Quantity."</Quantity>
        <Location>".$Location."</Location>
        <ReturnPolicy>
        <ReturnsAcceptedOption>".$ReturnsAcceptedOption."</ReturnsAcceptedOption>
        <RefundOption>".$RefundOption."</RefundOption>
        <ReturnsWithinOption>".$ReturnsWithinOption."</ReturnsWithinOption>
        <Description>".$ReturnsDescription."</Description>
        <ShippingCostPaidByOption>".$ShippingCostPaidByOption."</ShippingCostPaidByOption>
        </ReturnPolicy>
        <ItemSpecifics>";


        if( $brand!=""){
            $post_string .="
           <NameValueList>
        <Name>Brand</Name>
        <Value>$brand</Value>
        </NameValueList>
       ";

        }

        if($sku !=""){

            $post_string .="

           <NameValueList>
            <Name>SKU</Name>
            <Value>$sku</Value>
            </NameValueList>";
        }


        if($upc !=""){
            $post_string .="
           <NameValueList>
        <Name>UPC</Name>
        <Value>$upc</Value>
        </NameValueList>";
        }

        if($ean !=""){
            $post_string .="
           <NameValueList>
        <Name>EAN</Name>
        <Value>$ean</Value>
        </NameValueList>";
        }



        if($mpn !=""){
            $post_string .="
           <NameValueList>
        <Name>MPN</Name>
        <Value>$mpn</Value>
        </NameValueList>";
        }


        $post_string .="

        </ItemSpecifics>
        <SKU>$sku</SKU>
        <ShippingDetails>
        <ShippingType>".$ShippingType."</ShippingType>
        <GlobalShipping>true</GlobalShipping>
        <ShippingServiceOptions>
        <ShippingServicePriority>".$ShippingServicePriority."</ShippingServicePriority>
        <ShippingService>".$ShippingService."</ShippingService>";
        if($FreeShipping=="true"){
            $post_string .="<FreeShipping>true</FreeShipping>";
        }else{
            $post_string .=" <ShippingServiceCost>".$ShippingServiceCost."</ShippingServiceCost>";
        }
        $post_string .="
        <ShippingServiceAdditionalCost currencyID=\"$Currency\">".$ShippingServiceAdditionalCost."</ShippingServiceAdditionalCost>
        </ShippingServiceOptions>";



        if( $ShippingServicePriority2 !='0' ){
            $post_string .=" <ShippingServiceOptions>
            <ShippingServicePriority>".$ShippingServicePriority2."</ShippingServicePriority>
            <ShippingService>".$ShippingService2."</ShippingService>
            <ShippingServiceCost>".$ShippingServiceCost2."</ShippingServiceCost>
            <ShippingServiceAdditionalCost>".$ShippingServiceAdditionalCost2."</ShippingServiceAdditionalCost></ShippingServiceOptions>";

        }



        $post_string .="
        <InternationalShippingServiceOption>
        <ShippingService>".$InternationalShippingService."</ShippingService>
        <ShippingServiceCost currencyID=\"$Currency\">".$InternationalShippingServiceCost."</ShippingServiceCost>
        <ShippingServiceAdditionalCost currencyID=\"$Currency\">".$InternationalShippingServiceAdditionalCost."</ShippingServiceAdditionalCost>
        <ShippingServicePriority>".$InternationalShippingServicePriority."</ShippingServicePriority>
        <ShipToLocation>".$InternationalShipToLocation."</ShipToLocation>
        </InternationalShippingServiceOption>";


       if( $InternationalShippingServicePriority2 !='0'){

             $post_string .="
             <InternationalShippingServiceOption>
            <ShippingService>".$InternationalShippingService2."</ShippingService>
            <ShippingServiceCost currencyID=\"$Currency\">".$InternationalShippingServiceCost2."</ShippingServiceCost>
            <ShippingServiceAdditionalCost currencyID=\"$Currency\">".$InternationalShippingServiceAdditionalCost2."</ShippingServiceAdditionalCost>
            <ShippingServicePriority>".$InternationalShippingServicePriority2."</ShippingServicePriority>
            <ShipToLocation>".$InternationalShipToLocation2."</ShipToLocation>
            </InternationalShippingServiceOption>";

        }

        if($exclude!=""){
            $arrexcl=explode(',',$exclude);

            foreach($arrexcl as $exa){
                $post_string .=  "<ExcludeShipToLocation>".$exa."</ExcludeShipToLocation>";
            }
        }


        $post_string .="  </ShippingDetails>
        <ShipToLocations>".$InternationalShipToLocation."</ShipToLocations>
        </Item>
        <RequesterCredentials>
        <eBayAuthToken>".$token."</eBayAuthToken>
        </RequesterCredentials>
        <WarningLevel>High</WarningLevel>
        </ReviseItemRequest>​​";


    //  echo $post_string;

        return $this->runfunctionpost($post_string,"ReviseItem","$Site");

    }

    function ReviseItemPriceQua($accounttokenid,$itemid,$productid){
        $token="";
        $currency="";
        $Site="";
        $sql="select * from accounttoken where accounttokenid='".$accounttokenid."'";
        $result =$this->db->query($sql);
        foreach($result->result() as $row){
            $token= $row->token;
            $currency=$row->Currency;
        }

        if($currency=="GBP"){
            $Site="UK";
        }else if($currency=="USD"){
            $Site="US";
        }else if($currency=="AUD"){
            $Site="Australia";
        }

        $StartPrice="";
        $Currency="";
        $Quantity="";

        $sql="select * from productactive where productactiveid='".$productid."'";
        $result =$this->db->query($sql);
        foreach($result->result() as $row){


            if($row->currencyID=="GBP"){
                $StartPrice=$row->PriceGBP;
            }else if($row->currencyID=="USD"){
                $StartPrice=$row->StartPrice;
            }else if($row->currencyID=="AUD"){
                $StartPrice=$row->PriceAUD;
            }
            $Quantity=$row->Quantity;
            $Title=$row->ebaytitle;
            $Description=$row->spec;
            $CategoryID=$row->category;

            $ConditionID=$row->ConditionID;
            $Country=$row->Country;
            $Currency=$currency;
            $DispatchTimeMax=$row->DispatchTimeMax;
            $ListingDuration=$row->ListingDuration;
            $ListingType=$row->ListingType;
            $PaymentMethods=$row->PaymentMethods;
            $PayPalEmailAddress=$row->PayPalEmailAddress;
            $Quantity=$row->Quantity;
            $ReturnsAcceptedOption=$row->ReturnsAcceptedOption;
            $RefundOption=$row->RefundOption;
            $ReturnsWithinOption=$row->ReturnsWithinOption;
            $ReturnsDescription=$row->ReturnsDescription;
            $ShippingCostPaidByOption=$row->ShippingCostPaidByOption;
            $ShippingType=$row->ShippingType;

            $ShippingServicePriority=$row->ShippingServicePriority;
            $ShippingService=$row->ShippingService;
            $ShippingServiceCost=$row->ShippingServiceCost;

            $InternationalShippingService=$row->InternationalShippingService;
            $InternationalShippingServicePriority=$row->InternationalShippingServicePriority;
            $InternationalShippingServiceCost=$row->InternationalShippingServiceCost;
            $InternationalShipToLocation=$row->InternationalShipToLocation;
            $InternationalShippingServiceAdditionalCost=$row->InternationalShippingServiceAdditionalCost;


            $ShippingServicePriority2=$row->ShippingServicePriority2;
            $ShippingService2=$row->ShippingService2;
            $ShippingServiceCost2=$row->ShippingServiceCost2;


            $InternationalShippingService2=$row->InternationalShippingService2;
            $InternationalShippingServicePriority2=$row->InternationalShippingServicePriority2;
            $InternationalShippingServiceCost2=$row->InternationalShippingServiceCost2;
            $InternationalShipToLocation2=$row->InternationalShipToLocation2;
            $InternationalShippingServiceAdditionalCost2=$row->InternationalShippingServiceAdditionalCost2;

            $brand=$row->brand;
            $mpn=$row->mpn;
            $ean=$row->ean;
            $upc=$row->upc;
            $sku=$row->sku;
            $FreeShipping=$row->FreeShipping;
            $autopay=$row->AutoPay;
            $StoreCategoryID=$row->storecategory;

            $exclude=$row->exclude;
            $ProductReferenceID=$row->ProductReferenceID;
            $Location=$row->Location;
            $PrivateListing=$row->PrivateListing;

            $ShippingServiceAdditionalCost=$row->ShippingServiceAdditionalCost;
            $ShippingServiceAdditionalCost2=$row->ShippingServiceAdditionalCost2;


        }

        $post_string = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
        <ReviseItemRequest xmlns=\"urn:ebay:apis:eBLBaseComponents\">
        <ErrorLanguage>en_US</ErrorLanguage>
        <Item>
        <ItemID>".$itemid."</ItemID>
        <StartPrice>".$StartPrice."</StartPrice>";



        $post_string .="
       ";

        if($ProductReferenceID!=""){
            $post_string .="
                   <ProductListingDetails>
                      <ProductReferenceID>".$ProductReferenceID."</ProductReferenceID>
                      <IncludeStockPhotoURL>true</IncludeStockPhotoURL>
                      <IncludePrefilledItemInformation>true</IncludePrefilledItemInformation>
                      <UseFirstProduct>true</UseFirstProduct>
                      <UseStockPhotoURLAsGallery>true</UseStockPhotoURLAsGallery>
                      <ReturnSearchResultOnDuplicates>true</ReturnSearchResultOnDuplicates>
                </ProductListingDetails>";
        }else{





        }
        $post_string .=" <Quantity>".$Quantity."</Quantity>";


        if($RefundOption!=""){



            $post_string .="

        <ReturnPolicy>
        <ReturnsAcceptedOption>".$ReturnsAcceptedOption."</ReturnsAcceptedOption>
        <RefundOption>".$RefundOption."</RefundOption>
        <ReturnsWithinOption>".$ReturnsWithinOption."</ReturnsWithinOption>
        <Description>".$ReturnsDescription."</Description>
        <ShippingCostPaidByOption>".$ShippingCostPaidByOption."</ShippingCostPaidByOption>
        </ReturnPolicy>";
            }

$post_string .="

        </Item>
        <RequesterCredentials>
        <eBayAuthToken>".$token."</eBayAuthToken>
        </RequesterCredentials>
        <WarningLevel>High</WarningLevel>
        </ReviseItemRequest>​​";

      //  echo $post_string;
//
        return $this->runfunctionpost($post_string,"ReviseItem","$Site");

    }



    function GetItemDesc($itemid,$tokencurrency,$appid){

        $siteid=0;
        if($tokencurrency =="USD"){

        }else if($tokencurrency=="AUD"){

            $siteid="15";
        }else if($tokencurrency=="GBP"){
            $siteid="3";
        }


        $url=$this->all_model->shoppingurl."callname=GetSingleItem&esponseencoding=XML&appid=".$appid."&siteid=".$siteid."&version=861&ItemID=".$itemid."&IncludeSelector=Description,ItemSpecifics,Variations,details";
        $xml=file_get_contents($url);

        //  echo $xml;

        return $xml;

    }






 }