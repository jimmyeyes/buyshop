<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class All_model extends CI_Model
{

    var $schedule;
    var $time;
    var $url = "https://api.ebay.com/ws/api.dll";
    var $shoppingurl = "http://open.api.ebay.com/shopping?";
    var $runame = "HiHeaven_Intern-HiHeaven-6337-4-vzhrsrmpl";
    var $cer = "f5c9562a-4839-41fe-85c0-77d6f2a3d769";
    var $dev = "63d13c33-fcb4-4e0d-8cb2-ced175bf370a";
    var $app = "com.jwliu.ebay";
    var $listurl="http://cgi.ebay.com/ws/eBayISAPI.dll?ViewItem&item=";
    var $sandbox = false;

    function __construct()
    {

        // 呼叫模型(Model)的建構函數
        parent::__construct();

        $sql = "select *  from webauth ";
        //echo $sql;
        $query = $this->db->query($sql);
        foreach ($query->result() as $row) {

            if ($this->sandbox) {
                $this->url = "https://api.sandbox.ebay.com/ws/api.dll";
                $this->shoppingurl = "http://open.api.sandbox.ebay.com/shopping?";
                $this->runame = "none-com.jwliu.ebay-nqjvlqwzo";
                $this->listurl="http://cgi.sandbox.ebay.com/ws/eBayISAPI.dll?ViewItem&item=";

            } else {

                $this->cer = $row->cert;
                $this->dev = $row->dev;
                $this->app = $row->app;
            }
        }

    }

    function getlisturl(){


        return $this->listurl;
    }


    function gettoken($sessionid)
    {
        // create the xml request that will be POSTed
        if ($this->sandbox) {

            $url = "https://signin.sandbox.ebay.com/ws/eBayISAPI.dll?SignIn&RuName=" . $this->runame . "&SessID=" . $sessionid;
        } else {
            $url = "https://signin.ebay.com/ws/eBayISAPI.dll?SignIn&RuName=" . $this->runame . "&SessID=" . $sessionid;

        }

        //echo $url;
        ?>
        <input type="button" value="開新視窗" onclick="window.open(' <?= $url ?> ', 'Yahoo');"/>
    <?
    } // function

    function getsession()
    {
        // create the xml request that will be POSTed
        $post_string = '<?xml version="1.0" encoding="utf-8"?>
        <GetSessionIDRequest xmlns="urn:ebay:apis:eBLBaseComponents">
          <RuName>' . $this->runame . '</RuName>
        </GetSessionIDRequest>';

        return $this->runfunction($post_string, "GetSessionID");


    } // function


    function getPaypalURL($item)
    {

        return "<a target='_blank' href='http://cgi.ebay.com/ws/eBayISAPI.dll?ViewItem&item=$item'>$item</a>";

    }

    function getItemURL($item)
    {

        return "<a target='_blank' href='http://cgi.ebay.com/ws/eBayISAPI.dll?ViewItem&item=$item'>$item</a>";

    }

    function getPath()
    {
        $url = base_url() . "";
        $adminurl = base_url() . "index.php/welcome";

        return array($url, $adminurl);
    }

    function getPathIndex()
    {
        $url = base_url() . "";
        $adminurl = base_url() . "index.php/";

        return array($url, $adminurl);
    }

    function getTime()
    {

        date_default_timezone_set("Asia/Taipei");
        $datestring = "%Y-%m-%d %h:%i:%s";
        $time = time();

        return mdate($datestring, $time);
    }

    function getYear()
    {

        date_default_timezone_set("Asia/Taipei");
        $datestring = "%Y";
        $time = time();

        return mdate($datestring, $time);
    }

    function getDate()
    {

        date_default_timezone_set("Asia/Taipei");
        $datestring = "%Y-%m-%d";
        $time = time();

        return mdate($datestring, $time);
    }

    function getPurchasetype($id)
    {

        $id = $id - 1;
        $str = "";
        $arr = array('待訂', '已訂', '待入庫');
        $str = $arr[$id];
        return $str;
    }

    function getPayType($id)
    {

        $str = "";
        $arr = array('待付', '結清');
        $str = $arr[$id];
        return $str;
    }

    function getCompany($id)
    {

        $query = $this->db->query("select * from company where companyid='" . $id . "'")->row();
        return $query->companyname;
    }

    function getProduct($id)
    {

        $query = $this->db->query("select * from product where productid='" . $id . "'")->row();
        return $query->prodname;
    }


    function getAlPay($id)
    {


        $arr = array('現金', '支票');
        $str = $arr[$id];
        return $str;
    }

    function getDallor()
    {

        return array('美金', '英鎊', '澳幣', '電匯');

    }

    function getSecurity($val)
    {

        $authority = $this->session->userdata('authority');
        if ($authority) {

            if (($val & $authority) == $val) {
                return true;
            } else {
                if ($this->session->userdata('username') == false) {
                    redirect('/welcome/login', 'refresh');
                }


                return false;
            }

        } else {
            if ($this->session->userdata('username') == false) {
                redirect('/welcome/login', 'refresh');
            }
            return false;
        }

    }

    function getAuth()
    {

        $arr = array(
            '系統設置' => 1,
            '使用者管理' => 2,
            '廠商資料' => 4,
            '商品資料' => 8,
            '採購' => 16,
            '庫存管理' => 32,
            '帳務管理' => 64,
            '商品售價權限' => 128,
            '廠商清單金額權限' => 256,
            '訂單管理' => 512,
            '上傳追蹤碼' => 1024,
            'ebay' => 2048,
        );
        return $arr;
    }

    function getGramPrice($gram)
    {
        $price = 0;

        $temp1 = $gram % 20;
        if ($temp1 == 0) {
            $temp2 = intval($gram / 20);
            //echo $temp2;
            $price = ($temp2 - 1) * 10 + 13 + 65;
        } else {
            $temp2 = intval($gram / 20);
            //echo $temp2;
            $price = ($temp2) * 10 + 13 + 65;
        }


        return $price;

    }

    function getBalance($val)
    {
        $val = $val - 1;
        $arr = array('資產', '負債', '業主權益');
        $str = $arr[$val];
        return $str;

    }

    function getInout($val)
    {

        $arr = array('收入', '費用', '成本');
        $str = $arr[$val];
        return $str;

    }

    function getInvoicetype($val)
    {
        $val = $val - 1;
        $arr = array('進項發票', '銷項發票');
        $str = $arr[$val];
        return $str;
    }

    function getErr()
    {
        $str = "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
        $str .= "沒有權限<br><a href='javascript:history.back()'>back</a>";
        return $str;

    }

    function getMenu($url, $active)
    {

        $menu = "";
        $authority = $this->session->userdata('authority');
        $menuid = $this->session->userdata('menuid');

            $menu .= " <li ";

            if ($active == 8 || $active==16 || $active==32|| $active==4 ) {
                $menu .= "class='active'";
            }
            $menu .= " > ";
            $menu .= " <a href=" . $url . "product/product><i class=\"fa fa-inbox\"></i>
					<span class=\"title\">Inventory</span><span class='arrow '></span></a>";
            if ($active == 8 || $active==16 || $active==32|| $active==4) {
                $menu.="<ul class=\"sub-menu\">";
                if (($authority & 8) == 8) {
                    $menu .= "<li " ;

                    if($menuid==11){
                        $menu.="class='active' ";
                    }

                    $menu .= " >  <a href=" . $url . "product/product><i class=\"fa fa-inbox\"></i>
					<span class=\"title\">Product Inventory</span></a></li>";
                }


                if (($authority & 32) == 32) {

                    $menu .= "<li " ;

                if($menuid==12){
                    $menu.="class='active' ";
                }

                $menu.=" >  <a href=" . $url . "purchase/purchase><i class=\"fa fa-inbox\"></i>
					<span class=\"title\">Inventory Process</span></a></li>";

                /*
                $menu .= "<li  >  <a href=" . $url . "purchase/detail><i class=\"fa fa-inbox\"></i>
					<span class=\"title\">Inventory Process Detail</span></a></li>";


                $menu .= "<li  >  <a href=" . $url . "inventory/inventory><i class=\"fa fa-inbox\"></i>
                <span class=\"title\">Inventory</span></a></li>";
             */

                $menu .= "<li ";

                if($menuid==13){
                    $menu.="class='active' ";
                }

                $menu.=" >  <a href=" . $url . "company/company><i class=\"fa fa-flag\"></i>
					<span class=\"title\">Supplier</span></a></li>";
/*
                $menu .= "<li  >  <a href=" . $url . "inventory/inventory_back><i class=\"fa fa-inbox\"></i>
					<span class=\"title\">退貨列表</span></a></li>";

*/
                }
                $menu.="</ul>";
            }
            $menu .= "</li>";


            if (($authority & 2048) == 2048) {
                $menu .= " <li ";

                if ($active == 2048 ) {
                    $menu .= "class='active'";
                }
                $menu .= " >  <a href='" . $url . "ebay/eactive'><i class=\"fa fa-th\"></i>
					<span class=\"title\">eBay</span><span class='arrow '></span></a>";

                if ( $active == 2048) {
                    $menu .= "  <ul class=\"sub-menu\">";

                    $menu .= "<li ";

                    if($menuid==21){
                        $menu.="class='active' ";
                    }

                    $menu.=" ><a   href='" . $url . "ebay/eactive'><i class=\"fa fa-th\"></i><span class=\"title\">Active</span></a></li>	";

                    $menu .= "<li ";

                    if($menuid==22){
                        $menu.="class='active' ";
                    }

                    $menu.=" ><a   href='" . $url . "ebay/awaiting'><i class=\"fa fa-th\"></i><span class=\"title\">Awaiting Upload</span></a></li>	";
                    $menu .= "<li ";

                    if($menuid==23){
                        $menu.="class='active' ";
                    }

                    $menu.=" ><a  href='" . $url . "ebay/message'><i class=\"fa fa-th\"></i><span class=\"title\">Message</span></a></li>	";

                    $menu .= " </ul>";
                }
                $menu .= "</li>";
            }

        if (($authority & 512) == 512) {
            $menu .= " <li ";
            if ($active == 512 || $active == 1024) {
                $menu .= "class='active'";
            }
            $menu .= " >  <a href=" . $url . "order/order><i class=\"fa fa-th\"></i>
					<span class=\"title\">Order</span></a>";
            $menu .= "</li>";
        }

        if (($authority & 64) == 64) {
            $menu .= " <li ";

            if ($active == 64) {
                $menu .= "class='active'";
            }
            $url2="#";
            $menu .= " >  <a href='" . $url . "account/invoicelist'><i class=\"fa fa-credit-card\"></i>
					<span class=\"title\">Accounting</span><span class='arrow '></span></a>";
            if ($active == 64) {
                $menu .= "  <ul class=\"sub-menu\">";

                $menu .= "<li ";

                if($menuid==41){
                    $menu.="class='active' ";
                }

                $menu.=" ><a  href='" . $url . "account/invoicelist'><i class=\"fa fa-credit-card\"></i>
					<span class=\"title\">發票管理</span></a></li>	";
                $menu .= "<li ";

                if($menuid==42){
                    $menu.="class='active' ";
                }

                $menu.=" ><a href='" . $url . "account/income'><i class=\"fa fa-credit-card\"></i>
					<span class=\"title\">損益表</span></a></li>	";
                $menu .= "<li ";

                if($menuid==43){
                    $menu.="class='active' ";
                }

                $menu.=" ><a  href='" . $url . "account/balance'><i class=\"fa fa-credit-card\"></i>
					<span class=\"title\">資產負債表</span></a></li>	";
                $menu .= " </ul>";
            }
            $menu .= "</li>";
        }

        if (($authority & 1) == 1) {
            $menu .= " <li ";

            if ($active == 1) {
                $menu .= "class='active'";
            }
            $menu .= " >   <a href=" . $url . "welcome/as5km435> <i class=\"fa fa-cogs\"></i>
                <span class=\"title\">Setting</span></a>";

            //if ($active == 1) {
              //  if (($authority & 2) == 2) {
                //    $menu .= "<ul class=\"sub-menu\">";
                  //  $menu .= "<li ";

               //     if($menuid==51){
                    //    $menu.="class='active' ";
                    //}

                   // $menu.=" > <a href=" . $url . "welcome/as5km435><i class=\"fa fa-cogs\"></i>
                //<span class=\"title\">System Setting</span></a></li>";
                  //  $menu .= "<li ";

                    //if($menuid==52){
                  //      $menu.="class='active' ";
                    //}

               /*     $menu.=" > <a data-toggle=\"tab\" href=" . $url . "welcome/as5km435#tabs-2><i class=\"fa fa-cogs\"></i>
                <span class=\"title\">eBay</span></a></li>";
                    $menu .= "<li ";

                    if($menuid==53){
                        $menu.="class='active' ";
                    }

                    $menu.=" > <a data-toggle=\"tab\" href=" . $url . "welcome/as5km435#tabs-3><i class=\"fa fa-cogs\"></i>
                <span class=\"title\">Paypal</span></a></li>";
                    $menu .= "<li ";

                    if($menuid==54){
                        $menu.="class='active' ";
                    }

                    $menu.=" >  <a data-toggle=\"tab\" href=" . $url . "welcome/as5km435#portlet_tab_4><i class=\"fa fa-cogs\"></i>
                <span class=\"title\">Shipping</span></a></li>";

                    $menu .= "<li ";

                    if($menuid==55){
                        $menu.="class='active' ";
                    }

                    $menu.=" > <a data-toggle=\"tab\" href=" . $url . "welcome/as5km435#tabs-7><i class=\"fa fa-cogs\"></i>
                <span class=\"title\">Accounting</span></a></li>";
                    $menu .= "<li ";

                    if($menuid==56){
                        $menu.="class='active' ";
                    }


                    $menu.=" >  <a href=" . $url . "welcome/member><i class=\"fa fa-user\"></i>
                <span class=\"title\">Member</span></a></li>";
                    $menu .= "</ul>";*/

              //  }
            //}
            $menu .= "</li>";
        }
            $menu .= "</ul>";
            return $menu;

        }

        function shoppingrunfunction($post_string, $callname)
        {

            //echo "start runfunction";
            $url = $this->shoppingurl . "callname=GetSingleItem&esponseencoding=XML&appid=" . $this->app . "&siteid=0&version=861&ItemID=110136420194&IncludeSelector=Description,ItemSpecifics";
            file_get_contents($url);

            //echo "end runfunction";

         //   echo $responseXML;

           // return $responseXML; // returns a string
        }

        function runfunction($post_string, $callname)
        {

            //echo "start runfunction";

            $session = curl_init($this->url); // create a curl session

            curl_setopt($session, CURLOPT_POST, true); // POST request type
            curl_setopt($session, CURLOPT_POSTFIELDS, $post_string); // set the body of the POST
            curl_setopt($session, CURLOPT_RETURNTRANSFER, true); // return values as a string - not to std out

            $headers = array(
                "X-EBAY-API-CALL-NAME:" . $callname . "",
                "X-EBAY-API-SITEID:0", // Site 0 is for US
                "X-EBAY-API-COMPATIBILITY-LEVEL:837",
                "X-EBAY-API-CERT-NAME:" . $this->cer . "",
                "X-EBAY-API-DEV-NAME:" . $this->dev . "",
                "X-EBAY-API-APP-NAME:" . $this->app . "",
                "Content-Type:text/xml;charset=utf-8"
            );
            curl_setopt($session, CURLOPT_HTTPHEADER, $headers); //set headers using the above array of headers

            $responseXML = curl_exec($session); // send the request
            curl_close($session);

            //echo "end runfunction";

            return $responseXML; // returns a string
        }


        function runfunctionpost($post_string, $callname, $site)
        {

            //echo "start runfunction";

            $session = curl_init($this->url); // create a curl session

            curl_setopt($session, CURLOPT_POST, true); // POST request type
            curl_setopt($session, CURLOPT_POSTFIELDS, $post_string); // set the body of the POST
            curl_setopt($session, CURLOPT_RETURNTRANSFER, true); // return values as a string - not to std out


            if ($site == "US") {
                $siteid = "0";
            } else if ($site == "Australia") {
                $siteid = "15";
            } else if ($site == "UK") {
                $siteid = "3";
            }


            $headers = array(
                "X-EBAY-API-CALL-NAME:" . $callname . "",
                "X-EBAY-API-SITEID:" . $siteid, // Site 0 is for US
                "X-EBAY-API-COMPATIBILITY-LEVEL:837",
                "X-EBAY-API-CERT-NAME:" . $this->cer . "",
                "X-EBAY-API-DEV-NAME:" . $this->dev . "",
                "X-EBAY-API-APP-NAME:" . $this->app . "",
                "Content-Type:text/xml;charset=utf-8"
            );
            curl_setopt($session, CURLOPT_HTTPHEADER, $headers); //set headers using the above array of headers

            $responseXML = curl_exec($session); // send the request
            curl_close($session);

            //echo "end runfunction";

            return $responseXML; // returns a string
        }

        function GetOrders($accountid)
        {
            $token="";
            $sql = "select * from accounttoken where accounttokenid='" . $accountid . "'";
            $result = $this->db->query($sql);
            foreach ($result->result() as $row) {
                $token = $row->token;
            }
            $post_string = '<?xml version="1.0" encoding="utf-8"?>
                    <GetOrdersRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                    <RequesterCredentials>
                    <eBayAuthToken>' . $token . '</eBayAuthToken>
                    </RequesterCredentials>
                      <NumberOfDays>5</NumberOfDays>
                    <WarningLevel>High</WarningLevel>
                    </GetOrdersRequest>​​';


            return $this->runfunction($post_string, "GetOrders");


        }

    function GetOrdersOneDay($accountid)
    {
        $token="";
        $sql = "select * from accounttoken where accounttokenid='" . $accountid . "'";
        $result = $this->db->query($sql);
        foreach ($result->result() as $row) {
            $token = $row->token;
        }
        $post_string = '<?xml version="1.0" encoding="utf-8"?>
                    <GetOrdersRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                    <RequesterCredentials>
                    <eBayAuthToken>' . $token . '</eBayAuthToken>
                    </RequesterCredentials>
                      <NumberOfDays>1</NumberOfDays>
                    <WarningLevel>High</WarningLevel>
                    </GetOrdersRequest>​​';


        return $this->runfunction($post_string, "GetOrders");


    }

        function GetOrderTransactions($accountid)
        {
            $token="";
            $sql = "select * from accounttoken where accounttokenid='" . $accountid . "'";
            $result = $this->db->query($sql);
            foreach ($result->result() as $row) {
                $token = $row->token;
            }


            $post_string = '<?xml version="1.0" encoding="utf-8"?>
    <GetOrderTransactionsRequest xmlns="urn:ebay:apis:eBLBaseComponents">
    <RequesterCredentials>
    <eBayAuthToken>' . $token . '</eBayAuthToken>
    </RequesterCredentials>
      <OrderIDArray>
        <OrderID>110124838437-27121149001</OrderID>
      </OrderIDArray>
    <WarningLevel>High</WarningLevel>
    </GetOrderTransactionsRequest>​​';

            return $this->runfunction($post_string, "GetOrderTransactions");
        }


        function AddItem($accountid, $productid, $currency, $site)
        {

            $token="";
            $sql = "select * from accounttoken where accounttokenid='" . $accountid . "'";
            $result = $this->db->query($sql);
            foreach ($result->result() as $row) {
                $token = $row->token;
            }

            $FreeShipping="";
            $Title = "";
            $Description = "";
            $CategoryID = "";
            $StartPrice = "";
            $ConditionID = "";
            $Country = "";
            $Currency = "";
            $DispatchTimeMax = "";
            $ListingDuration = "";
            $ListingType = "";
            $PaymentMethods = "";
            $PayPalEmailAddress = "";
            $Quantity = "";
            $ReturnsAcceptedOption = "";

            $RefundOption = "";
            $ReturnsWithinOption = "";
            $ReturnsDescription = "";
            $ShippingCostPaidByOption = "";
            $ShippingType = "";
            $ShippingServicePriority = "";
            $ShippingService = "";
            $ShippingServiceCost = "";
            $Site = $site;
            $PrivateListing = "";


            $InternationalShippingService = "";
            $InternationalShippingServicePriority = "";
            $InternationalShippingServiceCost = "";
            $InternationalShipToLocation = "";
            $InternationalShippingServiceAdditionalCost="";

            $InternationalShippingService2 = "";
            $InternationalShippingServicePriority2 = "";
            $InternationalShippingServiceCost2 = "";
            $InternationalShipToLocation2 = "";
            $InternationalShippingServiceAdditionalCost2 = "";


            $ShippingServicePriority2 = "";
            $ShippingService2 = "";
            $ShippingServiceCost2 = "";

            $StoreCategoryID = "";

            $ebaytitle = "";
            $autopay = "";

            $sql = "select * from product where productid='" . $productid . "'";
            $result = $this->db->query($sql);
            foreach ($result->result() as $row) {

                $Title = $row->prodname;
                $Description = $row->spec;
                $CategoryID = $row->category;

                if ($currency == "GBP") {
                    $StartPrice = $row->PriceGBP;

                } else if ($currency == "USD") {
                    $StartPrice = $row->StartPrice;
                } else if ($currency == "AUD") {
                    $StartPrice = $row->PriceAUD;

                }

                $BuyItNowPrice = $row->StartPrice;
                $ConditionID = $row->ConditionID;
                $Country = $row->Country;
                $Currency = $currency;
                $DispatchTimeMax = $row->DispatchTimeMax;
                $ListingDuration = $row->ListingDuration;
                $ListingType = $row->ListingType;
                $PaymentMethods = $row->PaymentMethods;
                $PayPalEmailAddress = $row->PayPalEmailAddress;
                $Quantity = $row->Quantity;

                $ReturnsAcceptedOption = $row->ReturnsAcceptedOption;
                $RefundOption = $row->RefundOption;
                $ReturnsWithinOption = $row->ReturnsWithinOption;

                $ReturnsDescription = $row->ReturnsDescription;
                $ShippingCostPaidByOption = $row->ShippingCostPaidByOption;
                $ShippingType = $row->ShippingType;
                $ShippingServicePriority = $row->ShippingServicePriority;
                $ShippingService = $row->ShippingService;
                $ShippingServiceCost = $row->ShippingServiceCost;

                $InternationalShippingService = $row->InternationalShippingService;
                $InternationalShippingServicePriority = $row->InternationalShippingServicePriority;
                $InternationalShippingServiceCost = $row->InternationalShippingServiceCost;
                $InternationalShipToLocation = $row->InternationalShipToLocation;

                $sku = $row->sku;
                $Title = $row->ebaytitle;
                $autopay = $row->AutoPay;
                $StoreCategoryID = $row->storecategory;
                $PrivateListing = $row->PrivateListing;
                $Location = $row->Location;
                $exclude = $row->exclude;


                $ShippingServicePriority2 = $row->ShippingServicePriority2;
                $ShippingService2 = $row->ShippingService2;
                $ShippingServiceCost2 = $row->ShippingServiceCost2;


                $InternationalShippingService2 = $row->InternationalShippingService2;
                $InternationalShippingServicePriority2 = $row->InternationalShippingServicePriority2;
                $InternationalShippingServiceCost2 = $row->InternationalShippingServiceCost2;
                $InternationalShipToLocation2 = $row->InternationalShipToLocation2;
                $InternationalShippingServiceAdditionalCost2 = $row->InternationalShippingServiceAdditionalCost2;


            }


            $post_string = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
            <AddItemRequest xmlns=\"urn:ebay:apis:eBLBaseComponents\">
            <ErrorLanguage>en_US</ErrorLanguage>
            <WarningLevel>High</WarningLevel>
            <Item>
            <Title>" . $Title . "</Title>
            <Description><![CDATA[" . $Description . "]]></Description>
            <PrimaryCategory>
            <CategoryID>" . $CategoryID . "</CategoryID>
            </PrimaryCategory>
            <AutoPay>" . $autopay . "</AutoPay>
            <StartPrice>" . $StartPrice . "</StartPrice>";

            if ($StoreCategoryID != "") {
                $post_string .= " <Storefront>
                <StoreCategoryID>" . $StoreCategoryID . "</StoreCategoryID>
             </Storefront>";
            }

            $post_string .= "  <ConditionID>" . $ConditionID . "</ConditionID>
            <Country>" . $Country . "</Country>
            <Currency>" . $Currency . "</Currency>
            <DispatchTimeMax>" . $DispatchTimeMax . "</DispatchTimeMax>
            <ListingDuration>" . $ListingDuration . "</ListingDuration>
            <ListingType>" . $ListingType . "</ListingType>
            <PaymentMethods>" . $PaymentMethods . "</PaymentMethods>
            <PayPalEmailAddress>" . $PayPalEmailAddress . "</PayPalEmailAddress>
            ";


            $sql = "select * from product_img where proid='" . $productid . "'";
            $num = $this->db->query($sql)->num_rows();
            $query = $this->db->query($sql);

            if ($num) {
                $post_string .= "<PictureDetails>";
                foreach ($query->result() as $rowimg) {
                    $post_string .= "<PictureURL>" . base_url() . $rowimg->url . "</PictureURL>";
                }

                $post_string .= "</PictureDetails>";
            }
            $post_string .= "
            <Quantity>" . $Quantity . "</Quantity>
            <Location>" . $Location . "</Location>
            <ReturnPolicy>
            <ReturnsAcceptedOption>" . $ReturnsAcceptedOption . "</ReturnsAcceptedOption>
            <RefundOption>" . $RefundOption . "</RefundOption>
            <ReturnsWithinOption>" . $ReturnsWithinOption . "</ReturnsWithinOption>
            <Description>" . $ReturnsDescription . "</Description>
            <ShippingCostPaidByOption>" . $ShippingCostPaidByOption . "</ShippingCostPaidByOption>
            </ReturnPolicy>
            <ItemSpecifics>
            <NameValueList>
                <Name>sku</Name>
                <Value>$sku</Value>
            </NameValueList>
             <NameValueList>
                <Name>Custom</Name>
                <Value>$sku</Value>
            </NameValueList>
            </ItemSpecifics>
            <PrivateListing>" . $PrivateListing . "</PrivateListing>
            <ShippingDetails>
            <ShippingType>" . $ShippingType . "</ShippingType>
            <GlobalShipping>true</GlobalShipping>

              <InternationalShippingServiceOption>
                <ShippingService>" . $InternationalShippingService . "</ShippingService>
                <ShippingServiceCost currencyID=\"$Currency\">" . $InternationalShippingServiceCost . "</ShippingServiceCost>
                <ShippingServiceAdditionalCost currencyID=\"$Currency\">" . $InternationalShippingServiceAdditionalCost . "</ShippingServiceAdditionalCost>
                <ShippingServicePriority>" . $InternationalShippingServicePriority . "</ShippingServicePriority>
                <ShipToLocation>" . $InternationalShipToLocation . "</ShipToLocation>
                </InternationalShippingServiceOption>
                  <InternationalShippingServiceOption>
                <ShippingService>" . $InternationalShippingService2 . "</ShippingService>
                <ShippingServiceCost currencyID=\"$Currency\">" . $InternationalShippingServiceCost2 . "</ShippingServiceCost>
                <ShippingServiceAdditionalCost currencyID=\"$Currency\">" . $InternationalShippingServiceAdditionalCost2 . "</ShippingServiceAdditionalCost>
                <ShippingServicePriority>" . $InternationalShippingServicePriority2 . "</ShippingServicePriority>
                <ShipToLocation>" . $InternationalShipToLocation2 . "</ShipToLocation>
                </InternationalShippingServiceOption>
                <ShippingServiceOptions>
                <ShippingServicePriority>" . $ShippingServicePriority . "</ShippingServicePriority>
                <ShippingService>" . $ShippingService . "</ShippingService>";
            if ($FreeShipping == "1") {
                $post_string .= "<FreeShipping>true</FreeShipping>";
            } else {
                $post_string .= "<ShippingServiceCost>" . $ShippingServiceCost . "</ShippingServiceCost>";
            }
            $post_string .= "
                </ShippingServiceOptions>
                  <ShippingServiceOptions>
                <ShippingServicePriority>" . $ShippingServicePriority2 . "</ShippingServicePriority>
                <ShippingService>" . $ShippingService2 . "</ShippingService>";
            if ($FreeShipping == "1") {
                $post_string .= "<FreeShipping>true</FreeShipping>";
            } else {
                $post_string .= "<ShippingServiceCost>" . $ShippingServiceCost2 . "</ShippingServiceCost>";
            }
            $post_string .= " </ShippingServiceOptions>";

            if ($exclude != "") {
                $arrexcl = explode(',', $exclude);

                foreach ($arrexcl as $exa) {
                    $post_string .= "<ExcludeShipToLocation>" . $exa . "</ExcludeShipToLocation>";
                }
            }

            $post_string .= "
            </ShippingDetails>
            <ShipToLocations>" . $InternationalShipToLocation . "</ShipToLocations>
            <Site>" . $Site . "</Site>
            </Item>
            <RequesterCredentials>
            <eBayAuthToken>" . $token . "</eBayAuthToken>
            </RequesterCredentials>
            </AddItemRequest>";

            //echo $post_string;
            return $this->runfunctionpost($post_string, "AddItem", $site);


        }


        function AddFixPriceItem($accountid, $productid, $currency, $site)
        {
            $token="";
            $sql = "select * from accounttoken where accounttokenid='" . $accountid . "'";
            //echo $sql;
            $result = $this->db->query($sql);
            foreach ($result->result() as $row) {
                $token = $row->token;
            }


            $Title = "";
            $Description = "";
            $CategoryID = "";
            $StartPrice = "";
            $ConditionID = "";
            $Country = "";
            $Currency = "";
            $DispatchTimeMax = "";
            $ListingDuration = "";
            $ListingType = "";
            $PaymentMethods = "";
            $PayPalEmailAddress = "";
            $PostalCode = "";
            $Quantity = "";
            $ReturnsAcceptedOption = "";
            $RefundOption = "";
            $RefundOption = "";
            $ReturnsWithinOption = "";
            $ReturnsDescription = "";
            $ShippingCostPaidByOption = "";
            $ShippingType = "";
            $ShippingServicePriority = "";
            $ShippingService = "";
            $ShippingServiceCost = "";
            $Site = $site;
            $BuyItNowPrice = "";

            $InternationalShippingService = "";
            $InternationalShippingServicePriority = "";
            $InternationalShippingServiceCost = "";
            $InternationalShipToLocation = "";
            $InternationalShippingServiceAdditionalCost = "";

            $ShippingServicePriority = "";
            $ShippingService = "";
            $ShippingServiceCost = "";

            $InternationalShippingService2 = "";
            $InternationalShippingServicePriority2 = "";
            $InternationalShippingServiceCost2 = "";
            $InternationalShipToLocation2 = "";
            $InternationalShippingServiceAdditionalCost2 = "";

            $ShippingServicePriority2 = "";
            $ShippingService2 = "";
            $ShippingServiceCost2 = "";
            $brand = "";
            $mpn = "";
            $ean = "";
            $upc = "";
            $FreeShipping = "";
            $autopay = "";
            $ProductReferenceID = "";
            $StoreCategoryID = "";
            $Location = "";
            $PrivateListing = "";
            $ShippingServiceAdditionalCost = "";
            $ShippingServiceAdditionalCost2 = "";


            $sql = "select * from product where productid='" . $productid . "'";
            $result = $this->db->query($sql);
            foreach ($result->result() as $row) {

                $Title = $row->ebaytitle;
                $CategoryID = $row->category;
                if ($currency == "GBP") {
                    $StartPrice = $row->PriceGBP;
                    $Description = $row->spec;

                } else if ($currency == "USD") {
                    $StartPrice = $row->StartPrice;
                    $Description = $row->spec;

                } else if ($currency == "AUD") {
                    $StartPrice = $row->PriceAUD;
                    $Description = $row->spec;

                }else{
                    $StartPrice = $row->StartPrice;
                    $Description = $row->spec;
                }
                $ConditionID = $row->ConditionID;
                $Country = $row->Country;
                $Currency = $currency;
                $DispatchTimeMax = $row->DispatchTimeMax;
                $ListingDuration = $row->ListingDuration;
                $ListingType = $row->ListingType;
                $PaymentMethods = $row->PaymentMethods;
                $PayPalEmailAddress = $row->PayPalEmailAddress;
                $Quantity = $row->Quantity;
                $ReturnsAcceptedOption = $row->ReturnsAcceptedOption;
                $RefundOption = $row->RefundOption;
                $ReturnsWithinOption = $row->ReturnsWithinOption;
                $ReturnsDescription = $row->ReturnsDescription;
                $ShippingCostPaidByOption = $row->ShippingCostPaidByOption;
                $ShippingType = $row->ShippingType;

                $ShippingServicePriority = $row->ShippingServicePriority;
                $ShippingService = $row->ShippingService;
                $ShippingServiceCost = $row->ShippingServiceCost;

                $InternationalShippingService = $row->InternationalShippingService;
                $InternationalShippingServicePriority = $row->InternationalShippingServicePriority;
                $InternationalShippingServiceCost = $row->InternationalShippingServiceCost;
                $InternationalShipToLocation = $row->InternationalShipToLocation;
                $InternationalShippingServiceAdditionalCost = $row->InternationalShippingServiceAdditionalCost;


                $ShippingServicePriority2 = $row->ShippingServicePriority2;
                $ShippingService2 = $row->ShippingService2;
                $ShippingServiceCost2 = $row->ShippingServiceCost2;


                $InternationalShippingService2 = $row->InternationalShippingService2;
                $InternationalShippingServicePriority2 = $row->InternationalShippingServicePriority2;
                $InternationalShippingServiceCost2 = $row->InternationalShippingServiceCost2;
                $InternationalShipToLocation2 = $row->InternationalShipToLocation2;
                $InternationalShippingServiceAdditionalCost2 = $row->InternationalShippingServiceAdditionalCost2;

                $brand = $row->brand;
                $mpn = $row->mpn;
                $ean = $row->ean;
                $upc = $row->upc;
                $sku = $row->sku;
                $FreeShipping = $row->FreeShipping;
                $autopay = $row->AutoPay;
                $StoreCategoryID = $row->storecategory;

                $exclude = $row->exclude;
                $ProductReferenceID = $row->ProductReferenceID;
                $Location = $row->Location;
                $PrivateListing = $row->PrivateListing;

                $ShippingServiceAdditionalCost = $row->ShippingServiceAdditionalCost;
                $ShippingServiceAdditionalCost2 = $row->ShippingServiceAdditionalCost2;


            }

            $post_string = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
            <AddFixedPriceItemRequest xmlns=\"urn:ebay:apis:eBLBaseComponents\">
            <ErrorLanguage>en_US</ErrorLanguage>
            <WarningLevel>High</WarningLevel>
            <Item>
            <Title>" . $Title . "</Title>
            <Description> <![CDATA[" . $Description . "]]></Description>
            <PrimaryCategory>
            <CategoryID>" . $CategoryID . "</CategoryID>
            </PrimaryCategory>
             <AutoPay>" . $autopay . "</AutoPay>
               <PrivateListing>" . $PrivateListing . "</PrivateListing>
            <StartPrice>" . $StartPrice . "</StartPrice>";

            if ($StoreCategoryID != "") {
                $post_string .= " <Storefront>
                <StoreCategoryID>" . $StoreCategoryID . "</StoreCategoryID>
             </Storefront>";
            }

            $post_string .= "  <CategoryMappingAllowed>true</CategoryMappingAllowed>
            <ConditionID>" . $ConditionID . "</ConditionID>
            <Country>" . $Country . "</Country>
            <Currency>" . $Currency . "</Currency>
            <DispatchTimeMax>" . $DispatchTimeMax . "</DispatchTimeMax>
            <ListingDuration>" . $ListingDuration . "</ListingDuration>
            <ListingType>" . $ListingType . "</ListingType>
            <PaymentMethods>" . $PaymentMethods . "</PaymentMethods>
            <PayPalEmailAddress>" . $PayPalEmailAddress . "</PayPalEmailAddress>";
            $sql = "select * from product_img where proid='" . $productid . "'";
            $num = $this->db->query($sql)->num_rows();
            $query = $this->db->query($sql);
            if ($num) {
                $post_string .= "<PictureDetails>";
                foreach ($query->result() as $rowimg) {
                    $post_string .= "<PictureURL>" . base_url() . $rowimg->url . "</PictureURL>";
                }

                $post_string .= "</PictureDetails>";
            }

            if ($ProductReferenceID != "") {
                $post_string .= "
                   <ProductListingDetails>
                      <ProductReferenceID>" . $ProductReferenceID . "</ProductReferenceID>
                      <IncludeStockPhotoURL>true</IncludeStockPhotoURL>
                      <IncludePrefilledItemInformation>true</IncludePrefilledItemInformation>
                      <UseFirstProduct>true</UseFirstProduct>
                      <UseStockPhotoURLAsGallery>true</UseStockPhotoURLAsGallery>
                      <ReturnSearchResultOnDuplicates>true</ReturnSearchResultOnDuplicates>
                </ProductListingDetails>";
            } else {


            }

            $post_string .= "
            <Quantity>" . $Quantity . "</Quantity>
            <Location>" . $Location . "</Location>
            <ReturnPolicy>
            <ReturnsAcceptedOption>" . $ReturnsAcceptedOption . "</ReturnsAcceptedOption>
            <RefundOption>" . $RefundOption . "</RefundOption>
            <ReturnsWithinOption>" . $ReturnsWithinOption . "</ReturnsWithinOption>
            <Description>" . $ReturnsDescription . "</Description>
            <ShippingCostPaidByOption>" . $ShippingCostPaidByOption . "</ShippingCostPaidByOption>
            </ReturnPolicy>
            <ItemSpecifics>";


            if ($brand != "") {
                $post_string .= "
           <NameValueList>
        <Name>Brand</Name>
        <Value>$brand</Value>
        </NameValueList>
       ";

            }

            if ($sku != "") {

                $post_string .= "

           <NameValueList>
            <Name>SKU</Name>
            <Value>$sku</Value>
            </NameValueList>";
            }


            if ($upc != "") {
                $post_string .= "
           <NameValueList>
        <Name>UPC</Name>
        <Value>$upc</Value>
        </NameValueList>";
            }

            if ($ean != "") {
                $post_string .= "
           <NameValueList>
        <Name>EAN</Name>
        <Value>$ean</Value>
        </NameValueList>";
            }


            if ($mpn != "") {
                $post_string .= "
           <NameValueList>
        <Name>MPN</Name>
        <Value>$mpn</Value>
        </NameValueList>";
            }


            $post_string .= "
            </ItemSpecifics>
            <SKU>$sku</SKU>
            <ShippingDetails>
            <GlobalShipping>true</GlobalShipping>

            <InternationalShippingServiceOption>
            <ShippingService>" . $InternationalShippingService . "</ShippingService>
            <ShippingServiceCost currencyID=\"$Currency\">" . $InternationalShippingServiceCost . "</ShippingServiceCost>
            <ShippingServiceAdditionalCost currencyID=\"$Currency\">" . $InternationalShippingServiceAdditionalCost . "</ShippingServiceAdditionalCost>
            <ShippingServicePriority>" . $InternationalShippingServicePriority . "</ShippingServicePriority>
            <ShipToLocation>" . $InternationalShipToLocation . "</ShipToLocation>
            </InternationalShippingServiceOption>";


            if ($InternationalShippingServicePriority2 != '0') {

                $post_string .= "  <InternationalShippingServiceOption>
            <ShippingService>" . $InternationalShippingService2 . "</ShippingService>
            <ShippingServiceCost currencyID=\"$Currency\">" . $InternationalShippingServiceCost2 . "</ShippingServiceCost>
            <ShippingServiceAdditionalCost currencyID=\"$Currency\">" . $InternationalShippingServiceAdditionalCost2 . "</ShippingServiceAdditionalCost>
            <ShippingServicePriority>" . $InternationalShippingServicePriority2 . "</ShippingServicePriority>
            <ShipToLocation>" . $InternationalShipToLocation2 . "</ShipToLocation>
            </InternationalShippingServiceOption>";

            }

            $post_string .= "  <ShippingServiceOptions>
            <ShippingServicePriority>" . $ShippingServicePriority . "</ShippingServicePriority>
            <ShippingService>" . $ShippingService . "</ShippingService>";
            if ($FreeShipping == "true") {
                $post_string .= "<FreeShipping>true</FreeShipping>";
            } else {
                $post_string .= "<ShippingServiceCost>" . $ShippingServiceCost . "</ShippingServiceCost>";
            }
            $post_string .= "<ShippingServiceAdditionalCost>" . $ShippingServiceAdditionalCost . "</ShippingServiceAdditionalCost></ShippingServiceOptions>";


            if ($ShippingServicePriority2 != '0') {
                $post_string .= " <ShippingServiceOptions>
            <ShippingServicePriority>" . $ShippingServicePriority2 . "</ShippingServicePriority>
            <ShippingService>" . $ShippingService2 . "</ShippingService>";
                if ($FreeShipping == "1") {
                    $post_string .= "<FreeShipping>true</FreeShipping>";
                } else {
                    $post_string .= "<ShippingServiceCost>" . $ShippingServiceCost2 . "</ShippingServiceCost>";
                }
                $post_string .= "<ShippingServiceAdditionalCost>" . $ShippingServiceAdditionalCost2 . "</ShippingServiceAdditionalCost></ShippingServiceOptions>";

            }

            $post_string .= "<ShippingType>" . $ShippingType . "</ShippingType>";

            if ($exclude != "") {
                $arrexcl = explode(',', $exclude);

                foreach ($arrexcl as $exa) {
                    $post_string .= "<ExcludeShipToLocation>" . $exa . "</ExcludeShipToLocation>";
                }
            }

            $post_string .= "</ShippingDetails>
            <ShipToLocations>" . $InternationalShipToLocation . "</ShipToLocations>
            <Site>" . $Site . "</Site>
            </Item>
            <RequesterCredentials>
            <eBayAuthToken>" . $token . "</eBayAuthToken>
            </RequesterCredentials>
            </AddFixedPriceItemRequest>";

           //  echo $post_string;

            return $this->runfunctionpost($post_string, "AddFixedPriceItem", $Site);
        }


        function GetTransactionDetails($transactionID)
        {
            $sql = "select * from paypalaccount where 1";
            $result = $this->db->query($sql);
            foreach ($result->result() as $row) {
                if ($row->paypalusername == "")
                    continue;

                $PF_USER = $row->paypalusername;
                $PF_PWD = $row->paypalpassword;
                $PF_SIG = $row->signature;


                $PF_METHOD = "GetTransactionDetails";
                $VERSION = "78";
                //$TransactionID="3MC17669RG423011M";

                $methodName_ = $PF_METHOD;
                //$transactionID = urlencode($TransactionID);


                // Add request-specific fields to the request string.
                $nvpStr_ = "&TRANSACTIONID=$transactionID";
                //echo $nvpStr_;
                $environment="";
              //  $environment = 'sandbox';
                // Set up your API credentials, PayPal end point, and API version.
                $API_UserName = urlencode($PF_USER);
                $API_Password = urlencode($PF_PWD);
                $API_Signature = urlencode($PF_SIG);
                $API_Endpoint = "https://api-3t.paypal.com/nvp";
                if ("sandbox" === $environment || "beta-sandbox" === $environment) {
                  //  $API_Endpoint = "https://api-3t.$environment.paypal.com/nvp";
                }

               // echo $API_Endpoint;

                $version = urlencode('78.0');

                // Set the curl parameters.
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
                curl_setopt($ch, CURLOPT_VERBOSE, 1);

                // Turn off the server and peer verification (TrustManager Concept).
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);

                // Set the API operation, version, and API signature in the request.
                $nvpreq = "METHOD=$methodName_&VERSION=$version&PWD=$API_Password&USER=$API_UserName&SIGNATURE=$API_Signature$nvpStr_";

              //  echo $nvpreq;
                // Set the request as a POST FIELD for curl.
                curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);

                // Get response from the server.
                $httpResponse = curl_exec($ch);

                if (!$httpResponse) {
                  //  exit("$methodName_ failed: " . curl_error($ch) . '(' . curl_errno($ch) . ')');
                }

                // Extract the response details.
                $httpResponseAr = explode("&", $httpResponse);

                $httpParsedResponseAr = array();
                foreach ($httpResponseAr as $i => $value) {
                    $tmpAr = explode("=", $value);
                    if (sizeof($tmpAr) > 1) {
                        $httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
                    }
                }

                if ((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr)) {
                    exit("Invalid HTTP Response for POST request($nvpreq) to $API_Endpoint.");
                }

                if ("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {
                    //exit('GetTransactionDetails Completed Successfully: '.print_r($httpParsedResponseAr, true));
                   //   print_r($httpParsedResponseAr);

                    $RECEIVERBUSINESS = @urldecode($httpParsedResponseAr["RECEIVERBUSINESS"]);
                    if ($RECEIVERBUSINESS == "")
                        return;
                    $RECEIVEREMAIL = urldecode($httpParsedResponseAr["RECEIVEREMAIL"]);
                    $RECEIVERID = urldecode($httpParsedResponseAr["RECEIVERID"]);
                    $EMAIL = urldecode($httpParsedResponseAr["EMAIL"]);
                    $PAYERID = urldecode($httpParsedResponseAr["PAYERID"]);
                    $PAYERSTATUS = urldecode($httpParsedResponseAr["PAYERSTATUS"]);
                    $COUNTRYCODE = urldecode($httpParsedResponseAr["COUNTRYCODE"]);
                    $SHIPTONAME = urldecode(@$httpParsedResponseAr["SHIPTONAME"]);
                    $SHIPTOSTREET = @urldecode(@$httpParsedResponseAr["SHIPTOSTREET"]);
                    $SHIPTOCITY = @urldecode(@$httpParsedResponseAr["SHIPTOCITY"]);
                    $SHIPTOSTATE = @urldecode($httpParsedResponseAr["SHIPTOSTATE"]);
                    $SHIPTOCOUNTRYCODE = @urldecode($httpParsedResponseAr["SHIPTOCOUNTRYCODE"]);
                    $SHIPTOCOUNTRYNAME = @urldecode($httpParsedResponseAr["SHIPTOCOUNTRYNAME"]);
                    $SHIPTOZIP = @urldecode($httpParsedResponseAr["SHIPTOZIP"]);
                    $ADDRESSOWNER = @urldecode($httpParsedResponseAr["ADDRESSOWNER"]);
                    $ADDRESSSTATUS = @urldecode($httpParsedResponseAr["ADDRESSSTATUS"]);
                    $SALESTAX = @urldecode($httpParsedResponseAr["SALESTAX"]);
                    $SHIPDISCOUNT = @urldecode($httpParsedResponseAr["SHIPDISCOUNT"]);
                    $INSURANCEAMOUNT = @urldecode($httpParsedResponseAr["INSURANCEAMOUNT"]);
                    $BUYERID = @urldecode($httpParsedResponseAr["BUYERID"]);
                    $CLOSINGDATE = @urldecode($httpParsedResponseAr["CLOSINGDATE"]);
                    $TIMESTAMP = urldecode($httpParsedResponseAr["TIMESTAMP"]);
                    $CORRELATIONID = urldecode($httpParsedResponseAr["CORRELATIONID"]);
                    $ACK = urldecode($httpParsedResponseAr["ACK"]);
                    $VERSION = urldecode($httpParsedResponseAr["VERSION"]);
                    $BUILD = urldecode($httpParsedResponseAr["BUILD"]);
                    $FIRSTNAME = urldecode($httpParsedResponseAr["FIRSTNAME"]);
                    $LASTNAME = urldecode($httpParsedResponseAr["LASTNAME"]);
                    $TRANSACTIONID = urldecode($httpParsedResponseAr["TRANSACTIONID"]);
                    $TRANSACTIONTYPE = urldecode($httpParsedResponseAr["TRANSACTIONTYPE"]);
                    $PAYMENTTYPE = urldecode($httpParsedResponseAr["PAYMENTTYPE"]);
                    $ORDERTIME = urldecode($httpParsedResponseAr["ORDERTIME"]);
                    $AMT = urldecode($httpParsedResponseAr["AMT"]);
                    $FEEAMT = urldecode(@$httpParsedResponseAr["FEEAMT"]);
                    $TAXAMT = urldecode(@$httpParsedResponseAr["TAXAMT"]);
                    $SHIPPINGAMT = urldecode(@$httpParsedResponseAr["SHIPPINGAMT"]);
                    $HANDLINGAMT = urldecode(@$httpParsedResponseAr["HANDLINGAMT"]);
                    $CURRENCYCODE = urldecode($httpParsedResponseAr["CURRENCYCODE"]);
                    $PAYMENTSTATUS = urldecode($httpParsedResponseAr["PAYMENTSTATUS"]);
                    $PENDINGREASON = urldecode($httpParsedResponseAr["PENDINGREASON"]);
                    $REASONCODE = urldecode($httpParsedResponseAr["REASONCODE"]);
                    $SHIPPINGMETHOD = urldecode(@$httpParsedResponseAr["SHIPPINGMETHOD"]);
                    $PROTECTIONELIGIBILITY = urldecode($httpParsedResponseAr["PROTECTIONELIGIBILITY"]);
                    $PROTECTIONELIGIBILITYTYPE = urldecode($httpParsedResponseAr["PROTECTIONELIGIBILITYTYPE"]);

                    $MULTIITEM=@urldecode(@$httpParsedResponseAr["MULTIITEM"]);
                    $itemidarr="";
                    if($MULTIITEM==""){

                        $L_NUMBER0 = urldecode(@$httpParsedResponseAr["L_NUMBER0"]);
                        $itemidarr=$L_NUMBER0;
                    }else{
                        for($i=0;$i<$MULTIITEM;$i++){
                            $L_NUMBER0 = urldecode(@$httpParsedResponseAr["L_NUMBER".$i]);
                            if($itemidarr==""){
                                $itemidarr=$L_NUMBER0;
                            }else{
                                $itemidarr.=",".$L_NUMBER0;
                            }
                        }

                    }

                    $L_EBAYITEMTXNID0 = urldecode(@$httpParsedResponseAr["L_EBAYITEMTXNID0"]);
                    $L_NAME0 = urldecode(@$httpParsedResponseAr["L_NAME0"]);
                    $L_NUMBER0 = urldecode(@$httpParsedResponseAr["L_NUMBER0"]);
                    $L_QTY0 = urldecode(@$httpParsedResponseAr["L_QTY0"]);
                    $L_TAXAMT0 = urldecode(@$httpParsedResponseAr["L_TAXAMT0"]);
                    $L_SHIPPINGAMT0 = urldecode(@$httpParsedResponseAr["L_SHIPPINGAMT0"]);
                    $L_HANDLINGAMT0 = urldecode(@$httpParsedResponseAr["L_HANDLINGAMT0"]);
                    $L_CURRENCYCODE0 = urldecode($httpParsedResponseAr["L_CURRENCYCODE0"]);
                    $L_AMT0 = urldecode(@$httpParsedResponseAr["L_AMT0"]);





                    $sql = "select paypalTransactionDetailid from  paypalTransactionDetail where TRANSACTIONID='$TRANSACTIONID' ";
                    $query = $this->db->query($sql);
                    $count = $query->num_rows();
                    if ($count == "0") {


                        $Street1= $SHIPTOSTREET;
                        $SHIPTOSTREET=str_replace('"',"'",$Street1);



                        $sql = "insert into paypalTransactionDetail values (null,'$RECEIVERBUSINESS','$RECEIVEREMAIL','$RECEIVERID','$EMAIL','$PAYERID',";
                        $sql .= "\"".$PAYERSTATUS."\",\"".$COUNTRYCODE."\",\"".$SHIPTONAME."\",\"".$SHIPTOSTREET."\",\"".$SHIPTOCITY."\",\"".$SHIPTOSTATE."\",\"".$SHIPTOCOUNTRYCODE."\",\"".$SHIPTOCOUNTRYNAME."\",";
                        $sql .= "\"".$SHIPTOZIP."\",\"".$ADDRESSOWNER."\",\"".$ADDRESSSTATUS."\",'$SALESTAX',\"".$SHIPDISCOUNT."\",'$INSURANCEAMOUNT',\"".$BUYERID."\",\"".$CLOSINGDATE."\",'$TIMESTAMP',";
                        $sql .= "\"".$CORRELATIONID."\",'$ACK','$VERSION','$BUILD',\"".$FIRSTNAME."\",\"".$LASTNAME."\",\"".$TRANSACTIONID."\",'$TRANSACTIONTYPE','$PAYMENTTYPE','$ORDERTIME',";
                        $sql .= "'$AMT','$FEEAMT','$TAXAMT','$SHIPPINGAMT','$HANDLINGAMT','$CURRENCYCODE','$PAYMENTSTATUS','$PENDINGREASON','$REASONCODE','$SHIPPINGMETHOD',";
                        $sql .= "\"".$PROTECTIONELIGIBILITY."\",'$PROTECTIONELIGIBILITYTYPE','$L_EBAYITEMTXNID0','$L_NAME0','$L_NUMBER0','$L_QTY0','$L_TAXAMT0','$L_SHIPPINGAMT0','$L_HANDLINGAMT0',";
                        $sql .= "'$L_CURRENCYCODE0','$L_AMT0','$itemidarr',NOW())";
                        //	echo $sql;
                        $this->db->query($sql);
                    } else {
                        //	echo "update";
                        $row = $query->row();
                        $sql = " update  paypalTransactionDetail set  itemidarr='$itemidarr',PAYMENTSTATUS='$PAYMENTSTATUS' ,PENDINGREASON='$PENDINGREASON'  , REASONCODE='$REASONCODE'  ";
                        $sql .= ",  PROTECTIONELIGIBILITY='$PROTECTIONELIGIBILITY' , PROTECTIONELIGIBILITYTYPE='$PROTECTIONELIGIBILITYTYPE'   where paypalTransactionDetailid='$row->paypalTransactionDetailid'";

                        $this->db->query($sql);

                    }

                } else {
                   // echo $transactionID;
                  // exit('GetTransactionDetails failed: ' . print_r($httpParsedResponseAr, true));
                }
            }
        }


        function UpdateTrackNumber($accountid, $tracknumber, $carrier, $orderid, $OrderLineItemID, $TransactionID, $ItemID)
        {
            $token="";
            $sql = "select * from accounttoken where accounttokenid='" . $accountid . "'";
            $result = $this->db->query($sql);
            foreach ($result->result() as $row) {
                $token = $row->token;
            }

            //   $to= date("Y-m-d\TH:i:s\Z");
            $post_string = '<?xml version="1.0" encoding="utf-8"?>
        <CompleteSaleRequest xmlns="urn:ebay:apis:eBLBaseComponents">
        <WarningLevel>High</WarningLevel>
         <OrderID>' . $orderid . '</OrderID>
         <Paid>true</Paid>
            <Shipped>true</Shipped>
          <Shipment>
          <ShipmentTrackingDetails>
            <ShipmentTrackingNumber>' . $tracknumber . '</ShipmentTrackingNumber>
            <ShippingCarrierUsed>' . $carrier . '</ShippingCarrierUsed>
            </ShipmentTrackingDetails>
          </Shipment>
             <RequesterCredentials>
        <eBayAuthToken>' . $token . '</eBayAuthToken>
        </RequesterCredentials>​
        </CompleteSaleRequest>​';

            //  echo $post_string;
//        <OrderLineItemID>'.$OrderLineItemID.'</OrderLineItemID>


            return $this->runfunction($post_string, "CompleteSale");


        }

        function UploadSiteHostedPictures($accountid, $url, $name)
        {
            $token="";
            $sql = "select * from accounttoken where accounttokenid='" . $accountid . "'";
            $result = $this->db->query($sql);
            foreach ($result->result() as $row) {
                $token = $row->token;
            }

            $post_string = '<?xml version="1.0" encoding="utf-8"?>
    <UploadSiteHostedPicturesRequest xmlns="urn:ebay:apis:eBLBaseComponents">
    <RequesterCredentials>
    <eBayAuthToken>' . $token . '</eBayAuthToken>
    </RequesterCredentials>
    <WarningLevel>High</WarningLevel>
    <ExternalPictureURL>' . $url . '</ExternalPictureURL>
    <PictureName>' . $name . '</PictureName>
    </UploadSiteHostedPicturesRequest>​​';


            return $this->runfunction($post_string, "UploadSiteHostedPictures");


        }

        function product_ebay_pic_update($accountid, $productid, $ItemID)
        {
            $token="";
            $sql = "select * from accounttoken where accounttokenid='" . $accountid . "'";
            $result = $this->db->query($sql);
            foreach ($result->result() as $row) {
                $token = $row->token;
            }


            $sql = "select * from productactive where productactiveid='" . $productid . "'";
            $result = $this->db->query($sql);
            foreach ($result->result() as $row) {


                if ($row->currencyID == "GBP") {
                    $StartPrice = $row->PriceGBP;
                } else if ($row->currencyID == "USD") {
                    $StartPrice = $row->StartPrice;
                } else if ($row->currencyID == "AUD") {
                    $StartPrice = $row->PriceAUD;
                }
                $Quantity = $row->Quantity;
                $Title = $row->ebaytitle;
                $Description = $row->spec;
                $CategoryID = $row->category;

                $ConditionID = $row->ConditionID;
                $Country = $row->Country;
                $Currency = $row->currencyID;
                $DispatchTimeMax = $row->DispatchTimeMax;
                $ListingDuration = $row->ListingDuration;
                $ListingType = $row->ListingType;
                $PaymentMethods = $row->PaymentMethods;
                $PayPalEmailAddress = $row->PayPalEmailAddress;
                $Quantity = $row->Quantity;
                $ReturnsAcceptedOption = $row->ReturnsAcceptedOption;
                $RefundOption = $row->RefundOption;
                $ReturnsWithinOption = $row->ReturnsWithinOption;
                $ReturnsDescription = $row->ReturnsDescription;
                $ShippingCostPaidByOption = $row->ShippingCostPaidByOption;
                $ShippingType = $row->ShippingType;

                $ShippingServicePriority = $row->ShippingServicePriority;
                $ShippingService = $row->ShippingService;
                $ShippingServiceCost = $row->ShippingServiceCost;

                $InternationalShippingService = $row->InternationalShippingService;
                $InternationalShippingServicePriority = $row->InternationalShippingServicePriority;
                $InternationalShippingServiceCost = $row->InternationalShippingServiceCost;
                $InternationalShipToLocation = $row->InternationalShipToLocation;
                $InternationalShippingServiceAdditionalCost = $row->InternationalShippingServiceAdditionalCost;


                $ShippingServicePriority2 = $row->ShippingServicePriority2;
                $ShippingService2 = $row->ShippingService2;
                $ShippingServiceCost2 = $row->ShippingServiceCost2;


                $InternationalShippingService2 = $row->InternationalShippingService2;
                $InternationalShippingServicePriority2 = $row->InternationalShippingServicePriority2;
                $InternationalShippingServiceCost2 = $row->InternationalShippingServiceCost2;
                $InternationalShipToLocation2 = $row->InternationalShipToLocation2;
                $InternationalShippingServiceAdditionalCost2 = $row->InternationalShippingServiceAdditionalCost2;

                $brand = $row->brand;
                $mpn = $row->mpn;
                $ean = $row->ean;
                $upc = $row->upc;
                $sku = $row->sku;
                $FreeShipping = $row->FreeShipping;
                $autopay = $row->AutoPay;
                $StoreCategoryID = $row->storecategory;

                $exclude = $row->exclude;
                $ProductReferenceID = $row->ProductReferenceID;
                $Location = $row->Location;
                $PrivateListing = $row->PrivateListing;

                $ShippingServiceAdditionalCost = $row->ShippingServiceAdditionalCost;
                $ShippingServiceAdditionalCost2 = $row->ShippingServiceAdditionalCost2;


            }


            $post_string = '<?xml version="1.0" encoding="utf-8"?>
        <ReviseFixedPriceItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
        <RequesterCredentials>
        <eBayAuthToken>' . $token . '</eBayAuthToken>
        </RequesterCredentials>
        <WarningLevel>High</WarningLevel>
        <Item>
        <ItemID>' . $ItemID . '</ItemID>';
            $sql = "select * from productactive_img where prodid='" . $productid . "'";
            $num = $this->db->query($sql)->num_rows();
            $query = $this->db->query($sql);
            if ($num) {
                $post_string .= "<PictureDetails> ";
                foreach ($query->result() as $rowimg) {
                    $post_string .= "<PictureURL>" . base_url() . $rowimg->url . "</PictureURL>";
                }
                $post_string .= "</PictureDetails>";
            }

            if ($RefundOption != "") {


                $post_string .= "

        <ReturnPolicy>
        <ReturnsAcceptedOption>" . $ReturnsAcceptedOption . "</ReturnsAcceptedOption>
        <RefundOption>" . $RefundOption . "</RefundOption>
        <ReturnsWithinOption>" . $ReturnsWithinOption . "</ReturnsWithinOption>
        <Description>" . $ReturnsDescription . "</Description>
        <ShippingCostPaidByOption>" . $ShippingCostPaidByOption . "</ShippingCostPaidByOption>
        </ReturnPolicy>";
            }


            $post_string .= '</Item> </ReviseFixedPriceItemRequest>​​';

            //   echo $post_string;
            return $this->runfunction($post_string, "ReviseFixedPriceItem");


        }


        function product_ebay_get_item($accountid, $ItemID)
        {
            $token="";
            $sql = "select * from accounttoken where accounttokenid='" . $accountid . "'";
            $result = $this->db->query($sql);
            foreach ($result->result() as $row) {
                $token = $row->token;
            }

            $post_string = '<?xml version="1.0" encoding="utf-8"?>
    <GetItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
    <RequesterCredentials>
    <eBayAuthToken>' . $token . '</eBayAuthToken>
    </RequesterCredentials>
    <WarningLevel>High</WarningLevel>
    <ItemID>' . $ItemID . '</ItemID>
    </GetItemRequest>​';

            //echo $post_string;
            return $this->runfunction($post_string, "GetItem");


        }

        function updateproductebayitem($productid, $itemid, $accounttokenid)
        {
            $xml = $this->all_model->product_ebay_get_item($accounttokenid, $itemid);
            $item = simplexml_load_string($xml)->Item;
            $xml = simplexml_load_string($xml);
            // print_r($xml);
            if ($xml->Ack == "Failure") {
                return;
            }

            $Country = $item->Country;
            $Currency = $item->Currency;
            $ItemID = $item->ItemID;
            $StartPrice = $item->StartPrice;
            $ListingDuration = $item->ListingDuration;
            $ListingType = $item->ListingType;
            $PayPalEmailAddress = $item->PayPalEmailAddress;
            $CategoryID = $item->PrimaryCategory->CategoryID;
            $Quantity = $item->Quantity;


            $set2 = "";
            $shipcount = count($item->ShippingDetails->ShippingServiceOptions);

            if ($shipcount > 1) {
                $shipps = $item->ShippingDetails->ShippingServiceOptions;
                $i = 1;
                foreach ($shipps as $ship) {

                    if ($i == 1) {
                        $set2 .= ",ShippingServicePriority='$ship->ShippingServicePriority',ShippingService='$ship->ShippingService' ,ShippingServiceCost='$ship->ShippingServiceCost' ,ShippingServiceAdditionalCost='$ship->ShippingServiceAdditionalCost'";
                        $FreeShipping = @$item->ShippingDetails->ShippingServiceOptions->FreeShipping;

                    } else {
                        $set2 .= ",ShippingServicePriority2='$ship->ShippingServicePriority',ShippingService2='$ship->ShippingService' ,ShippingServiceCost2='$ship->ShippingServiceCost' ,ShippingServiceAdditionalCost2='$ship->ShippingServiceAdditionalCost'";
                    }

                    $i++;
                }

            } else {
                $ShippingServiceCost = $item->ShippingDetails->ShippingServiceOptions->ShippingServiceCost;
                $ShippingServiceAdditionalCost = $item->ShippingDetails->ShippingServiceOptions->ShippingServiceAdditionalCost;
                $ShippingService = $item->ShippingDetails->ShippingServiceOptions->ShippingService;
                $ShippingServicePriority = $item->ShippingDetails->ShippingServiceOptions->ShippingServicePriority;
                $FreeShipping = @$item->ShippingDetails->ShippingServiceOptions->FreeShipping;
                $set2 = ",ShippingServicePriority='$ShippingServicePriority',ShippingService='$ShippingService' ,ShippingServiceCost='$ShippingServiceCost' ,ShippingServiceAdditionalCost='$ShippingServiceAdditionalCost'";

            }


            $shipcount = count($item->ShippingDetails->InternationalShippingServiceOption);
            if ($shipcount > 1) {
                $shipps = $item->ShippingDetails->InternationalShippingServiceOption;
                $i = 1;
                foreach ($shipps as $ship) {

                    if ($i == 1) {


                        $set2 .= ",InternationalShipToLocation='$ship->ShipToLocation',InternationalShippingServiceAdditionalCost='$ship->ShippingServiceAdditionalCost',InternationalShippingServiceCost='$ship->ShippingServiceCost',InternationalShippingService	='$ship->ShippingService', InternationalShippingServicePriority='$ship->ShippingServicePriority'";

                    } else {

                        $set2 .= ",InternationalShipToLocation2='$ship->ShipToLocation',InternationalShippingServiceAdditionalCost2='$ship->ShippingServiceAdditionalCost',InternationalShippingServiceCost2='$ship->ShippingServiceCost',InternationalShippingService2	='$ship->ShippingService', InternationalShippingServicePriority2='$ship->ShippingServicePriority'";

                    }

                    $i++;
                }

            } else {

                $InternationalShippingServiceAdditionalCost = $item->ShippingDetails->InternationalShippingServiceOption->ShippingServiceAdditionalCost;
                $InternationalShippingService = $item->ShippingDetails->InternationalShippingServiceOption->ShippingService;
                $InternationalShippingServiceCost = $item->ShippingDetails->InternationalShippingServiceOption->ShippingServiceCost;
                $InternationalShippingServicePriority = $item->ShippingDetails->InternationalShippingServiceOption->ShippingServicePriority;
                $ShipToLocation = $item->ShippingDetails->InternationalShippingServiceOption->ShipToLocation;

                $set2 .= ",InternationalShipToLocation='$ShipToLocation',InternationalShippingServiceAdditionalCost='$InternationalShippingServiceAdditionalCost',InternationalShippingServiceCost='$InternationalShippingServiceCost',InternationalShippingService	='$InternationalShippingService', InternationalShippingServicePriority='$InternationalShippingServicePriority'";

            }

            $newex="";
            $ExcludeShipToLocation=$item->ShippingDetails->ExcludeShipToLocation;

            $excount= count($ExcludeShipToLocation);
            if($excount >1){


                foreach($ExcludeShipToLocation as $exc){
                    if($newex==""){
                        $newex=$exc;

                    }else $newex.=",".$exc;
                }

            }else{
                $newex=$ExcludeShipToLocation;
            }


            $InternationalShipToLocation = $item->ShipToLocations;
            $PrivateListing = $item->PrivateListing;

            $ShippingType = $item->ShippingDetails->ShippingType;
            $RefundOption = $item->ReturnPolicy->RefundOption;
            $Refund = $item->ReturnPolicy->Refund;
            $ReturnsWithinOption = $item->ReturnPolicy->ReturnsWithinOption;
            $ReturnsAcceptedOption = $item->ReturnPolicy->ReturnsAcceptedOption;
            $ReturnsAccepted = $item->ReturnPolicy->ReturnsAccepted;
            $Description = $item->ReturnPolicy->Description;
            $ShippingCostPaidByOption = $item->ReturnPolicy->ShippingCostPaidByOption;

            $ConditionID = $item->ConditionID;
            $PaymentMethods = $item->PaymentMethods;
            $DispatchTimeMax = $item->DispatchTimeMax;
            $currencyID = $StartPrice->attributes()->currencyID;
            $AutoPay = $item->AutoPay;
            $StoreCategoryID = $item->Storefront->StoreCategoryID;
            $picurl = $item->PictureDetails->PictureURL;
            $Location = $item->Location;

            $set = "";
            if ($currencyID == "USD") {
                $set = ", StartPrice='$StartPrice' ";
            } else if ($currencyID == "AUD") {
                $set = ", PriceAUD='$StartPrice' ";
            } else if ($currencyID == "GBP") {
                $set = ", PriceGBP='$StartPrice' ";
            }


            $sql = "update productactive set  FreeShipping='$FreeShipping', Location='$Location',  ConditionID='$ConditionID',category='$CategoryID', Country='$Country',PayPalEmailAddress='$PayPalEmailAddress',pricetype='$currencyID',Quantity='$Quantity',ListingDuration='$ListingDuration' ";
            $sql .= ",   ReturnsAcceptedOption='$ReturnsAcceptedOption',RefundOption='$RefundOption',ReturnsWithinOption='$ReturnsWithinOption',ReturnsDescription='$Description' ,exclude='$newex' ";
            $sql .= " ,ShippingType='$ShippingType',ShippingCostPaidByOption ='$ShippingCostPaidByOption'";
            $sql .= " , ListingType='$ListingType' ";
            $sql .= " , StoreCategory='$StoreCategoryID', AutoPay='$AutoPay' ,PrivateListing='$PrivateListing',picurl='$picurl'";

            $sql .= ", PaymentMethods='$PaymentMethods', DispatchTimeMax='$DispatchTimeMax'   $set $set2 where productactiveid='$productid'";

            //echo $sql;
            $this->db->query($sql);


            $desc = simplexml_load_string($this->ebayapi_model->GetItemDesc($ItemID, $currencyID, $this->app));
            // print_r($desc);
            $des = $desc->Item->Description;
            //echo $des;
            $set = "";

            $count = count(@$desc->Item->ItemSpecifics->NameValueList);

            if ($count > 0) {
                foreach (@$desc->Item->ItemSpecifics->NameValueList as $nv) {
                    if ($nv->Name == "Brand") {

                        $set .= " ,brand = '" . $nv->Value . "'";

                    }

                    if ($nv->Name == "Model") {

                        $set .= " ,model = '" . $nv->Value . "'";
                    }

                    if ($nv->Name == "EAN") {

                        $set .= " ,ean = '" . $nv->Value . "'";

                    }

                    if ($nv->Name == "MPN") {

                        $set .= " ,mpn = '" . $nv->Value . "'";
                    }

                    if ($nv->Name == "UPC") {

                        $set .= " ,upc = '" . $nv->Value . "'";
                    }

                    if ($nv->Name == "SKU") {

                        $set .= " ,sku = '" . $nv->Value . "'";

                    }

                }
            }


            $ProductID = @$desc->Item->ProductID;

            if ($ProductID != "") {
                if ($set != "")
                    $set .= "  ,ProductReferenceID ='$ProductID' ";
            }
            $des = htmlspecialchars($des, ENT_QUOTES);
            $sql = "update productactive set spec=\"" . $des . "\" $set where productactiveid='" . $productid . "'";
            // echo $set;
            $this->db->query($sql);
        }


        function getEbaySellingListpre($accountid)
        {

            $token="";
            $sql = "select * from accounttoken where accounttokenid='" . $accountid . "'";
            $result = $this->db->query($sql);
            foreach ($result->result() as $row) {
                $token = $row->token;
            }

            $post_string = '<?xml version="1.0" encoding="utf-8"?>
        <GetMyeBaySellingRequest xmlns="urn:ebay:apis:eBLBaseComponents">
            <ActiveList>
                <Sort>TimeLeft</Sort>
                <Pagination><EntriesPerPage>1</EntriesPerPage>
                    <PageNumber>1</PageNumber>
                </Pagination>
            </ActiveList>
            <RequesterCredentials>
                <eBayAuthToken>' . $token . '</eBayAuthToken>
            </RequesterCredentials>
            <WarningLevel>High</WarningLevel>
        </GetMyeBaySellingRequest>​';

            return $this->runfunction($post_string, "GetMyeBaySelling");

        }


        function getEbaySellingList($accountid, $i)
        {

            $token="";
            $sql = "select * from accounttoken where accounttokenid='" . $accountid . "'";
            $result = $this->db->query($sql);
            foreach ($result->result() as $row) {
                $token = $row->token;
            }

            $post_string = '<?xml version="1.0" encoding="utf-8"?>
        <GetMyeBaySellingRequest xmlns="urn:ebay:apis:eBLBaseComponents">
            <ActiveList>
                <Sort>TimeLeft</Sort>
                <Pagination><EntriesPerPage>200</EntriesPerPage>
                    <PageNumber>' . $i . '</PageNumber>
                </Pagination>
            </ActiveList>
            <RequesterCredentials>
                <eBayAuthToken>' . $token . '</eBayAuthToken>
            </RequesterCredentials>
            <WarningLevel>High</WarningLevel>
        </GetMyeBaySellingRequest>​';

            return $this->runfunction($post_string, "GetMyeBaySelling");

        }


        function SearchTransaction($sdate, $edate)
        {

            $sql = "select * from paypalaccount where 1";
            $result = $this->db->query($sql);
            foreach ($result->result() as $row) {
                if ($row->paypalusername == "")
                    continue;

                $PF_USER = $row->paypalusername;
                $PF_PWD = $row->paypalpassword;
                $PF_SIG = $row->signature;


                $PF_METHOD = "TransactionSearch";
                $methodName_ = $PF_METHOD;

                if ($sdate == "" || $edate == "") {
                    $sdate = date('Y-m-d');
                    $edate = date("Y-m-d", strtotime("+1 day", strtotime($sdate)));
                }

                // Add request-specific fields to the request string.
                $nvpStr_ = "&STARTDATE=" . $sdate . "T0:0:0";
                //echo $nvpStr_;
                //&ENDDATE=".$edate."T24:0:0
//sandbox
                $environment = '';
                // Set up your API credentials, PayPal end point, and API version.
                $API_UserName = urlencode($PF_USER);
                $API_Password = urlencode($PF_PWD);
                $API_Signature = urlencode($PF_SIG);
                $API_Endpoint = "https://api-3t.paypal.com/nvp";
                if ("sandbox" === $environment || "beta-sandbox" === $environment) {
                    $API_Endpoint = "https://api-3t.$environment.paypal.com/nvp";
                }

               // echo $API_Endpoint;
                $version = urlencode('78.0');
                // Set the curl parameters.
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
                curl_setopt($ch, CURLOPT_VERBOSE, 1);
                // Turn off the server and peer verification (TrustManager Concept).
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);

                // Set the API operation, version, and API signature in the request.
                $nvpreq = "METHOD=$methodName_&VERSION=$version&PWD=$API_Password&USER=$API_UserName&SIGNATURE=$API_Signature" . "" . "$nvpStr_";
                //&TRXTYPE=Q
                // Set the request as a POST FIELD for curl.
                curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);
                // echo $API_Endpoint.".".$nvpreq;
                // Get response from the server.
                $httpResponse = curl_exec($ch);

                if (!$httpResponse) {
                   // exit("$methodName_ failed: " . curl_error($ch) . '(' . curl_errno($ch) . ')');
                }

                // Extract the response details.
                $httpResponseAr = explode("&", $httpResponse);

                $httpParsedResponseAr = array();
                foreach ($httpResponseAr as $i => $value) {
                    $tmpAr = explode("=", $value);
                    if (sizeof($tmpAr) > 1) {
                        $httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
                    }
                }

                if ((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr)) {
                    exit("Invalid HTTP Response for POST request($nvpreq) to $API_Endpoint.");
                }

                //print_r($httpParsedResponseAr);
                $transid = "";


                if ("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {


                    //print_r($httpParsedResponseAr);
                    $count = ((count($httpParsedResponseAr) - 5) / 11);
                    for ($i = 0; $i < $count; $i++) {

                        $TIMESTAMP = urldecode($httpParsedResponseAr["L_TIMESTAMP$i"]);
                        $TIMEZONE = urldecode($httpParsedResponseAr["L_TIMEZONE$i"]);
                        $TYPE = urldecode($httpParsedResponseAr["L_TYPE$i"]);
                        $EMAIL = @urldecode($httpParsedResponseAr["L_EMAIL$i"]);
                        $NAME = urldecode($httpParsedResponseAr["L_NAME$i"]);
                        $TRANSACTIONID = urldecode($httpParsedResponseAr["L_TRANSACTIONID$i"]);
                        $STATUS = urldecode($httpParsedResponseAr["L_STATUS$i"]);
                        $AMT = urldecode($httpParsedResponseAr["L_AMT$i"]);
                        $CURRENCYCODE = urldecode($httpParsedResponseAr["L_CURRENCYCODE$i"]);
                        $FEEAMT = urldecode($httpParsedResponseAr["L_FEEAMT$i"]);
                        $NETAMT = urldecode($httpParsedResponseAr["L_NETAMT$i"]);

                        $sql = "select count(paypaltransactionid) as co from  paypaltransaction where TIMESTAMP='$TIMESTAMP' and TIMEZONE='$TIMEZONE'  and AMT='$AMT' and EMAIL='$EMAIL' and TRANSACTIONID='$TRANSACTIONID'";
                        $query = $this->db->query($sql)->row();

                        if ($query->co == "0") {

                            $sql = "insert into paypaltransaction values ('','" . $TIMESTAMP . "','" . $TIMEZONE . "','" . $TYPE . "','" . $EMAIL . "',\"" . $NAME . "\",'" . $TRANSACTIONID . "','" . $STATUS . "','" . $AMT . "','" . $CURRENCYCODE . "','" . $FEEAMT . "','" . $NETAMT . "',NOW())";
                            $this->db->query($sql);

                            $this->all_model->GetTransactionDetails($TRANSACTIONID);
                            // echo "insert:"+$TRANSACTIONID;

                            $transid .= $TRANSACTIONID . ",";
                        } else {
                            // echo "hasdata".$TRANSACTIONID;
                        }

                    }

                    return $transid;

                   // exit('GetTransactionDetails Completed Successfully: ' . print_r($httpParsedResponseAr, true));
                } else {
                  //  exit('GetTransactionDetails failed: ' . print_r($httpParsedResponseAr, true));
                }

            }


        }


        function getMemberid($username, $password)
        {
            $sql = "select * from member where username='$username' and passwd='$password'";

            $query = $this->db->query($sql);
            $num = $query->num_rows();
            if ($num == 0) {
                return "0";
            } else {
                return $query->row()->memberid;
            }


        }


        function getStore($accountid)
        {

            $token="";
            $sql = "select * from accounttoken where accounttokenid='" . $accountid . "'";
            $result = $this->db->query($sql);
            foreach ($result->result() as $row) {
                $token = $row->token;
            }

            $post_string = '<?xml version="1.0" encoding="utf-8"?>
        <GetStoreRequest xmlns="urn:ebay:apis:eBLBaseComponents">
            <RequesterCredentials>
                <eBayAuthToken>' . $token . '</eBayAuthToken>
            </RequesterCredentials>
            <WarningLevel>High</WarningLevel>
              <LevelLimit>3</LevelLimit>
        </GetStoreRequest>​';

            return $this->runfunction($post_string, "GetStore");

        }


        function FindProducts($keyword)
        {

            //  echo $post_string;
            $url = $this->shoppingurl . "callname=FindProducts&responseencoding=xml&appid=" . $this->app . "&siteid=0&version=525&QueryKeywords=" . urlencode($keyword) . "&MaxEntries=100&AvailableItemsOnly=true";
            // echo $url;
            return file_get_contents($url);

        }

        function GetSuggestedCategories($accountid, $keyword)
        {

            $token="";
            $sql = "select * from accounttoken where accounttokenid='" . $accountid . "'";
           // echo $sql;
            $result = $this->db->query($sql);
            foreach ($result->result() as $row) {
                $token = $row->token;
            }

            $post_string = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
<GetSuggestedCategoriesRequest xmlns=\"urn:ebay:apis:eBLBaseComponents\">
<RequesterCredentials>
  <eBayAuthToken>" . $token . "</eBayAuthToken>
</RequesterCredentials>
<Query>" . $keyword . "</Query>
</GetSuggestedCategoriesRequest>​​​";

             // echo $post_string;

            return $this->runfunction($post_string, "GetSuggestedCategories");

        }


    }
    ?>
