<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Welcome extends CI_Controller {

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
	}
	
	
	
	function as5km435(){
		 if ($this->session->userdata('username') == false) {
            redirect('/welcome/login', 'refresh');
        }

		
		$bo = $this -> all_model -> getSecurity(1);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}

        $this -> session -> set_userdata('menuid',51);


        $path = $this -> all_model -> getPathIndex();
		$date['currurl'] = $path[0];
		$date['url'] = $path[1];
		$date['adminurl'] = $path[1] . "welcome/";

		$date['menu'] = $this -> all_model -> getMenu($date['url'],1);

		$date['query'] = $this -> db -> query("select * from webprofile") -> row();
		$date['shipping'] = $this -> db -> query("select * from shipping");


        $query = $this -> db -> query("select * from shipping");
        $string="";
        foreach($query->result() as $row){
            if($string==""){
                $string=$row->shippingid;
            }else{
                $string.=",".$row->shippingid;
            }
        }

        $date['shippingid']=$string;

		$sql="select * from accounttoken ";
		$date['accounttoken']=$this->db->query($sql);


        $sql="select * from paypalaccount ";
        $date['paypalaccount']=$this->db->query($sql);


        $sql="select * from webprofile ";
        $date['webprpfile']=$this->db->query($sql)->row();

		$sql="select * from courier ";
		$date['courier']=$this->db->query($sql);


        $sql="SELECT * from varlist where `type`='20'";
        //echo $sql;
        $date['queryexce'] = $this -> db -> query($sql);


        $sql="SELECT count(*) as co FROM `orderlist` where OrderStatus='Completed' and CheckoutStatusStatus='Complete' and reserved='0'";

        $date['orderamount'] = $this -> db -> query($sql)->row()->co;

        $sql="SELECT count(*) as co FROM `orderlist` where OrderStatus='Completed' and CheckoutStatusStatus='Complete' and reserved='0' and BuyerCheckoutMessage!=''";

        $date['buyersnote'] = $this -> db -> query($sql)->row()->co;

        $sql="select sum(AMT) as co from paypalTransactionDetail where PAYMENTSTATUS='Completed'";


        $date['paypalamt'] = $this -> db -> query($sql)->row()->co;

        $date['queryaccounting'] = $this -> db -> query("select * from accounttype ");

        $date['querymember'] = $this -> db -> get('member');


        $this -> master2 -> view('webconfig/index_view', $date);
		
		
	}

    function shipping_add(){

        $bo = $this -> all_model -> getSecurity(1);
        if (!$bo) {
            echo $this -> all_model -> getErr();
            return;
        }

        $kg = $this -> input -> get_post('kg');
        $fee = $this -> input -> get_post('fee');


        $sql = "insert into shipping values (null,$kg,$fee) ";
        $this -> db -> query($sql);

        redirect('/welcome/as5km435', 'refresh');



    }


    function shipping_bath(){

        $bo = $this -> all_model -> getSecurity(1);
        if (!$bo) {
            echo $this -> all_model -> getErr();
            return;
        }


        $shippingid = $this -> input -> get_post("shippingid");
        $chk = $this -> input -> get_post("chk");
        $modtype = $this -> input -> get_post("modtype");

        $arr=explode(",",$shippingid);
        //print_r($chk) ;

        if($chk==""){
            echo "Error ";
            return;
        }

        foreach($arr as $ar){
            foreach(@$chk as $ch){
                //echo $ch;
                if($ch==$ar){
                    if($modtype==1 ){

                        $kg = $this -> input -> get_post("kg".$ar);
                        $fee = $this -> input -> get_post("fee".$ar);

                        $sql="update shipping  set kg='$kg',fee='$fee' where  shippingid ='$ar'";

                        $this->db->query($sql);

                    }else  if($modtype==2){

                        $sql="delete from  shipping where shippingid='".$ar."'";
                        $this->db->query($sql);

                    }else{

                    }
                }
            }
        }


        redirect('/welcome/as5km435', 'refresh');
        return;


    }


	public function first() {
		
		
		$path = $this -> all_model -> getPathIndex();
		$date['currurl'] = $path[0];
		$date['url'] = $path[1];
		$date['menu'] = $this -> all_model -> getMenu($date['url'],1);

		$date['adminurl'] = $path[1] . "welcome/";

		$this -> master2 -> view('webconfig/first_view', $date);
	}

	public function webconfig_update() {
		
		$bo = $this -> all_model -> getSecurity(1);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}

		$pus = $this -> input -> get_post('pus');
		$puk = $this -> input -> get_post('puk');
		$pau = $this -> input -> get_post('pau');
		$bus = $this -> input -> get_post('bus');

		$sql = "update webprofile set  pau='$pau' , puk='$puk' , pus='$pus', bus='$bus' ";
		$this -> db -> query($sql);

		redirect('/welcome/as5km435', 'refresh');
	}

	function webconfig_shipping_update() {
			
		$bo = $this -> all_model -> getSecurity(1);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}
		
		for ($i = 1; $i <= 8; $i++) {
			$sql = "update shipping set fee='" . $this -> input -> get_post('shipping' . $i) . "' where shippingid='" . $i . "' ";
			$this -> db -> query($sql);

		}

		redirect('/welcome/as5km435', 'refresh');

	}

	function webconfig_fun_update() {
		
		$bo = $this -> all_model -> getSecurity(1);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}

		$usfee1 = $this -> input -> get_post('usfee1');
		$usfee2 = $this -> input -> get_post('usfee2');
		$usfee3 = $this -> input -> get_post('usfee3');
		$usfee4 = $this -> input -> get_post('usfee4');
		$usfee5 = $this -> input -> get_post('usfee5');

		$ukfee1 = $this -> input -> get_post('ukfee1');
		$ukfee2 = $this -> input -> get_post('ukfee2');
		$ukfee3 = $this -> input -> get_post('ukfee3');

		$aufee1 = $this -> input -> get_post('aufee1');
		$aufee2 = $this -> input -> get_post('aufee2');
		$aufee3 = $this -> input -> get_post('aufee3');

		$busfee1 = $this -> input -> get_post('busfee1');

		$data = array('usfee1' => $usfee1, 'usfee2' => $usfee2, 'usfee3' => $usfee3, 'usfee4' => $usfee4, 'usfee5' => $usfee5, 'ukfee1' => $ukfee1, 'ukfee2' => $ukfee2, 'ukfee3' => $ukfee3, 'aufee1' => $aufee1, 'aufee2' => $aufee2, 'aufee3' => $aufee3, 'busfee1' => $busfee1, );

		$this -> db -> update('webprofile', $data);
		redirect('/welcome/as5km435', 'refresh');

	}

	function login() {
		$path = $this -> all_model -> getPathIndex();
		$date['currurl'] = $path[0];
		$date['url'] = $path[1];

		$this -> load -> view('login_view', $date);
	}

	function logout() {

		$this -> session -> sess_destroy();
		redirect(base_url(), 'refresh');
	}

	public function logining() {

		$path = $this -> all_model -> getPathIndex();
		$date['currurl'] = $path[0];
		$date['url'] = $path[1];
		ob_start();
		$user = $this -> input -> get_post('user');
		$pass = $this -> input -> get_post('pass');
	
		if (!empty($user) && !empty($pass)) {
			$pass = $pass;
			$sql = "SELECT * FROM member WHERE username='" . $user . "' and passwd='" . $pass . "'  ";
			//echo $sql;
			$sql2="insert into loginlog values (null,'".$user."','".$pass."',NOW(),'0','".$_SERVER["REMOTE_ADDR"]."')";
			$this -> db -> query($sql2);
			$loginid = $this -> db -> insert_id();
			
			$query = $this -> db -> query($sql);
			if ($query -> num_rows() > 0) {

				$this -> session -> set_userdata('username', $query -> row() -> username);
				$this -> session -> set_userdata('accountid', $query -> row() -> memberid);
				$this -> session -> set_userdata('authority', $query -> row() -> authority);
				
				if($loginid !=0){
					$sql2="update loginlog set islogin='1' where loginlogid='".$loginid."'";
						$this -> db -> query($sql2);
				}

				redirect('product/product', 'refresh');
			} else {
				$date["fail"] = " a();";
				$this -> load -> view('login_view', $date);
			}
		} else {
			$this -> load -> view('login_view', $date);
		}
	}

	function webconfig() {
		
		$bo = $this -> all_model -> getSecurity(1);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}

		$path = $this -> all_model -> getPathIndex();
		$date['currurl'] = $path[0];
		$date['url'] = $path[1];
		$date['menu'] = $this -> all_model -> getMenu($date['url'],1);
		
		$accountid = $this -> session -> userdata('accountid');

		$query = $this -> db -> query("select * from member where accountid='$accountid'") -> row();
		$date['authority'] = $query -> authority;

		$this -> master2 -> view('index_view', $date);

	}

	function member() {
		
		$bo = $this -> all_model -> getSecurity(1);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}

        $this -> session -> set_userdata('menuid',56);


        $path = $this -> all_model -> getPathIndex();
		$date['currurl'] = $path[0];
		$date['url'] = $path[1];
		$date['menu'] = $this -> all_model -> getMenu($date['url'],1);
		$date['adminurl'] = $path[1] . "welcome/";
		$date['query'] = $this -> db -> get('member');

		$this -> master2 -> view('webconfig/member_view', $date);

	}

	function member_edit_update() {
		
		$bo = $this -> all_model -> getSecurity(2);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}

		$date['url'] = base_url() . "application/views/admin/";
		$date['adminurl'] = base_url() . "index.php/admin/";

		$id = $this -> input -> get_post('id');
		$password = $this -> input -> get_post('password');
		$chkpassword = $this -> input -> get_post('chkpassword');

		$name = $this -> input -> get_post('name');
		$updatetime = $this -> all_model -> getTime();

		$authority = 0;
		$auth = $this -> input -> get_post('auth');
		$query=$this->db->query("select * from member where memberid='".$id."'")->row();
		
		if(!$auth || (!$query->passwd & $password==""& $chkpassword=="")){
				echo "資料不齊全喔<br><a href='javascript:history.back()'>back</a>";
			return;
		}

		foreach ($auth as $val) {
			$authority += $val;
		}
		
		$accountid = $this -> session -> userdata('accountid');
		if($accountid==$id){
			$this -> session -> set_userdata('authority', $authority);
		}

		if (empty($password) && empty($chkpassword)) {
			$sql = "update member set  name='$name' ,authority='$authority' where memberid='$id'";
			//echo $sql;
			$this -> db -> query($sql);
			redirect("welcome/member", 'refresh');
		} else {
			if ($password == $chkpassword) {
				$sql = "update member set passwd='" . $password . "',authority='$authority' ,  name='$name', updatetime='$updatetime' where memberid='$id'";
				//echo $sql;
				$this -> db -> query($sql);
				redirect("welcome/member", 'refresh');
			} else {
				echo "Please check your password<br><a href='javascript:history.back()'>back</a>";
			}
		}
	}

	function member_edit() {
			
		$bo = $this -> all_model -> getSecurity(1);
		if (!$bo) {
			echo "沒有權限<br>
		<a href='javascript:history.back()'>back</a>";
			return;
		}
		
		$date['id'] = $this -> uri -> segment('3', 0);
		$path = $this -> all_model -> getPathIndex();
		$date['currurl'] = $path[0];
		$date['url'] = $path[1];
		$date['menu'] = $this -> all_model -> getMenu($date['url'],2);
		$date['adminurl'] = $path[1] . "welcome/";
		$date['row'] = $this -> db -> get_where('member', array('memberid' => $date['id'])) -> row();
		$this -> master2 -> view('webconfig/member_edit_view', $date);
	}

	function member_del() {
		
		$bo = $this -> all_model -> getSecurity(2);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}
	
		$id = $this -> uri -> segment('3', 0);
		$sql = "delete from member where memberid='$id'";
		$this -> db -> query($sql);

		redirect("welcome/member", 'refresh');
	}

	function member_add() {
		$bo = $this -> all_model -> getSecurity(2);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}

		$username = $this -> input -> get_post('name');
		if ($username == null) {
			echo "不能空白<br><a href='javascript:history.back()'>back</a>";
			return;
		}
		
		$query=$this->db->query("select * from member where username='".$username."'");
		if($query->num_rows){
				echo "帳號重複<br><a href='javascript:history.back()'>back</a>";
			return;
		}
			
		$sql = "insert into member (name,username,passwd,	authority,createtime,updatetime) values ('$username','$username','0','0',NOW(),NOW())";
		$this -> db -> query($sql);
		$memberid = $this -> db -> insert_id();

		redirect("welcome/member_edit/" . $memberid, 'refresh');

	}

	function member_adds() {
		
		$bo = $this -> all_model -> getSecurity(2);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}
		

		$account = $this -> input -> get_post('username');
		$name = $this -> input -> get_post('name');
		$password = $this -> input -> get_post('password');
		$chkpassword = $this -> input -> get_post('chkpassword');
		$email = $this -> input -> get_post('email');

		$sql2 = "select * from member where username='$account'";
		$totle = $this -> db -> query($sql2) -> num_rows();
		if ($totle) {
			echo "can't use $account<br><a href='javascript:history.back()'>back</a>";
		} else {
			if ($password == $chkpassword) {
				$sql = "insert into member (`username`,`passwd`,`name`)
						values('$account','" . $password . "','$name','$email')";
				$this -> db -> query($sql);
				redirect("welcome/member", 'refresh');
			} else {
				echo "Please check your password<br>
		<a href='javascript:history.back()'>back</a>";
			}
		}
	}

		
	function transdata(){
		$sql="SELECT r1.productid,r1.price,r1.amount  FROM purchase r1 ";
		 $query= $this->db->query($sql);
		foreach($query->result() as $row){
			if($row->price !=null){
			$sql="select * from  inventorylist where productid='".$row->productid."' and price='".$row->price."'";
			$query2=$this->db->query($sql);
			if ($query2 -> num_rows() > 0) {
				
				$sql="update inventorylist set amount=amount+".$row->amount ." where  productid='".$row->productid."' and price='".$row->price."'";
				//echo $sql;
				$this->db->query($sql);
			}else{
				$sql="insert into inventorylist values(null,'0',NOW(),'".$row->productid."','0','".$row->price."','".$row->amount."',NOW())";
				$this->db->query($sql);
				
			}
			}
			
		}
		
	}
	
	function courier_update(){
			
		$name = $this -> input -> get_post('name');
		$courierid = $this -> input -> get_post('courierid');	
		$sql="update courier set name='$name' where  courierid='$courierid'";
		$this->db->query($sql);
		
		redirect("welcome/as5km435", 'refresh');
		
	}
	
		
	function courier_adds(){
			
		$name = $this -> input -> get_post('name');
		$sql="insert into  courier values (null,'$name',NOW() )";
		$this->db->query($sql);
		
		redirect("welcome/as5km435", 'refresh');
		
	}
	
	function courier_del(){
			
		$courierid = $this -> uri -> segment('3', 0);
		$sql="delete from courier  where  courierid='$courierid'";
		$this->db->query($sql);
		
		redirect("welcome/as5km435", 'refresh');
		
	}


    function ebayship_update(){

        $name = $this -> input -> get_post('name');
        $id = $this -> input -> get_post('id');
        $sql="update varlist set name='$name' where  varlistid='$id' and type='7'";
        $this->db->query($sql);

        redirect("welcome/as5km435#tabs-4", 'refresh');

    }


    function ebayship_adds(){

        $name = $this -> input -> get_post('name');
        $sql="insert into  varlist values (null,'$name','$name','7' )";
        $this->db->query($sql);

        redirect("welcome/as5km435#tabs-4", 'refresh');

    }

    function ebayship_del(){

        $id = $this -> uri -> segment('3', 0);
        $sql="delete from varlist  where  varlistid='$id' and `type`='7'";
        $this->db->query($sql);

        redirect("welcome/as5km435#tabs-4", 'refresh');

    }

    function dhl(){


     $post_string='<?xml version="1.0" encoding="UTF-8"?>
<req:ShipmentRequest xmlns:req="http://www.dhl.com" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.dhl.com ship-val-global-req.xsd" schemaVersion="1.0">
	<Request>
		<ServiceHeader>
			<MessageTime>2014-03-19T11:28:56.000-08:00</MessageTime>
			<MessageReference>1234567890123456789012345678901</MessageReference>
                <SiteID>HIHEAVENINT</SiteID>
			<Password>9vCeJmGthH</Password>
		</ServiceHeader>
	</Request>
	<RegionCode>AP</RegionCode>
	<LanguageCode>en</LanguageCode>
	<PiecesEnabled>Y</PiecesEnabled>
	<Billing>
		<ShipperAccountNumber>620828482</ShipperAccountNumber>
		<ShippingPaymentType>S</ShippingPaymentType>
	</Billing>
	<Consignee>
		<CompanyName>IBM Malaysia Sdn Bhd</CompanyName>
		<AddressLine>19th Floor, Plaza IBM</AddressLine>
		<AddressLine>No. 8, First Avenue,</AddressLine>
		<AddressLine>Persiaran Bandar Utama</AddressLine>
		<City>Petaling Jaya</City>
		<PostalCode>47800</PostalCode>
		<CountryCode>MY</CountryCode>
		<CountryName>Malaysia</CountryName>
		<Contact>
			<PersonName>Ms Ellie White</PersonName>
			<PhoneNumber>11234325423</PhoneNumber>
		</Contact>
	</Consignee>
	<Dutiable>
		<DeclaredValue>50.50</DeclaredValue>
		<DeclaredCurrency>HKD</DeclaredCurrency>
	</Dutiable>
	<ShipmentDetails>
		<NumberOfPieces>2</NumberOfPieces>
		<Pieces>
			<Piece>
				<PieceID>1</PieceID>
				<PackageType>YP</PackageType>
				<Weight>0.5</Weight>
				<Width>30</Width>
				<Height>40</Height>
				<Depth>20</Depth>
			</Piece>
			<Piece>
				<PieceID>2</PieceID>
				<PackageType>YP</PackageType>
				<Weight>2.0</Weight>
				<Width>60</Width>
				<Height>70</Height>
				<Depth>50</Depth>
			</Piece>
		</Pieces>
		<Weight>2.5</Weight>
		<WeightUnit>K</WeightUnit>
		<GlobalProductCode>P</GlobalProductCode>
		<LocalProductCode>P</LocalProductCode>
		<Date>2014-03-20</Date>
        <Contents>test</Contents>
		<DimensionUnit>C</DimensionUnit>
		<InsuredAmount>10.00</InsuredAmount>
		<PackageType>YP</PackageType>
		<IsDutiable>Y</IsDutiable>
		<CurrencyCode>HKD</CurrencyCode>
	</ShipmentDetails>
	<Shipper>
		<ShipperID>620828482</ShipperID>
		<CompanyName>HiHeaven International Co.,Ltd.</CompanyName>
		<AddressLine>7F., No.16, Ln. 66, </AddressLine>
		<AddressLine>Chongren St., East Dist.</AddressLine>
		<City>Tainan</City>
		<DivisionCode>East</DivisionCode>
		<!--PostalCode>6009</PostalCode-->
		<CountryCode>TW</CountryCode>
		<CountryName>Taiwan</CountryName>
		<Contact>
			<PersonName>buyshoptw</PersonName>
			<PhoneNumber>+88662896839</PhoneNumber>
		</Contact>
	</Shipper>
	<LabelImageFormat>PDF</LabelImageFormat>
</req:ShipmentRequest>';

        $xml=$this->runfunction($post_string);

        echo $xml;
        $xml=simplexml_load_string($xml);


        echo $xml->Response->Status->ActionStatus;


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

            $sql="insert into dhlserviceresponse values (null,'$RegionCode','$ActionNote','$MessageTime','$MessageReference','$SiteID','$AirwayBillNumber','$BillingCode','$CurrencyCode','$CourierMessage',";
            $sql.="'$DestinationServiceAreaServiceAreaCode','$DestinationServiceAreaFacilityCode','$DestinationServiceAreaInboundSortCode','$OriginServiceAreaServiceAreaCode','$OriginServiceAreaOutboundSortCode',";
            $sql.="'$Rated','$InsuredAmount','$WeightUnit','$ChargeableWeight','$DimensionalWeight','$CountryCode','$AWBBarCode','$OriginDestnBarcode','$DHLRoutingBarCode','$Piece','$Contents','$CustomerID',";
            $sql.="'$ShipmentDate','$GlobalProductCode','$ShipperAccountNumber','$ShippingPaymentType','$DutyPaymentType','$DeclaredValue','$DeclaredCurrency','$DHLRoutingCode','$DHLRoutingDataId',";
            $sql.="'$ProductContentCode','$ProductShortName','$InternalServiceCode','$OutputFormat','$OutputImage','0','0',NOW())";


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

       // print_r($xml);

    }

    function dhl2(){

        $string="iVBORw0KGgoAAAANSUhEUgAAAYwAAABeAQMAAAAKdrGZAAAABlBMVEX///8AAABVwtN+AAAAaklEQVR42mNkYGBIyL8whfvc4QsTzcRqu5IbxObeclgruSBK5CjDVyNvjWVvf325dYNt/rkDX+/NV1rAwMDEQDIY1TKqZVTLqJZRLaNaRrWMahnVMqplVMuollEto1pGtYxqGdUyqoVUAADpJxi85OXebwAAAABJRU5ErkJggg==";

        $string="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IDg0MS44OSA1OTUuMjhdPj4KZW5kb2JqCjQgMCBvYmoKPDwvQ291bnQgMy9UeXBlL1BhZ2VzL0lUWFQoMi4xLjcpL0tpZHNbMSAwIFIgMiAwIFIgMyAwIFJdPj4KZW5kb2JqCjE3IDAgb2JqCjw8L1R5cGUvQ2F0YWxvZy9QYWdlcyA0IDAgUj4+CmVuZG9iagoxOCAwIG9iago8PC9DcmVhdGlvbkRhdGUoRDoyMDE0MDMxOTA0MDU0N1opL1Byb2R1Y2VyKGlUZXh0IDIuMS43IGJ5IDFUM1hUKS9Nb2REYXRlKEQ6MjAxNDAzMTkwNDA1NDdaKT4+CmVuZG9iagp4cmVmCjAgMTkKMDAwMDAwMDAwMCA2NTUzNSBmIAowMDAwMDA4MzkwIDAwMDAwIG4gCjAwMDAwMTMzNjIgMDAwMDAgbiAKMDAwMDAwMzQxNyAwMDAwMCBuIAowMDAwMDEzNTI1IDAwMDAwIG4gCjAwMDAwMDgyNzMgMDAwMDAgbiAKMDAwMDAwMzU4MSAwMDAwMCBuIAowMDAwMDA4MDkyIDAwMDAwIG4gCjAwMDAwMDgxODUgMDAwMDAgbiAKMDAwMDAxMzI0NSAwMDAwMCBuIAowMDAwMDA4NTUyIDAwMDAwIG4gCjAwMDAwMTMwNjIgMDAwMDAgbiAKMDAwMDAxMzE1NiAwMDAwMCBuIAowMDAwMDAzMjk5IDAwMDAwIG4gCjAwMDAwMDAwMTUgMDAwMDAgbiAKMDAwMDAwMzExNiAwMDAwMCBuIAowMDAwMDAzMjEwIDAwMDAwIG4gCjAwMDAwMTM2MDAgMDAwMDAgbiAKMDAwMDAxMzY0NiAwMDAwMCBuIAp0cmFpbGVyCjw8L0lEIFs8YTllZmI0NWYzYTFiNmM2ZDY3OTNmNmM1MTliZmJlMWY+PDA3ZmMzZGIyNTA4YzMwNjUzYWFjNmRhZTQ2NjVmYjZjPl0vUm9vdCAxNyAwIFIvU2l6ZSAxOS9JbmZvIDE4IDAgUj4+CnN0YXJ0eHJlZgoxMzc1NwolJUVPRgo=";
       $data=  base64_decode($string);

        $dir=dirname(dirname(dirname(__FILE__)));
        echo $dir;
        file_put_contents($dir.'/uploads/image.pdf', $data);
    }

    function runfunction($post_string){

        //echo "start runfunction";

        $session  = curl_init("https://xmlpitest-ea.dhl.com/XMLShippingServlet");                       // create a curl session

        curl_setopt($session, CURLOPT_POST, true);              // POST request type
        curl_setopt($session, CURLOPT_POSTFIELDS, $post_string); // set the body of the POST
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);    // return values as a string - not to std out

        $responseXML = curl_exec($session);                     // send the request
        curl_close($session);

        //echo "end runfunction";

        return $responseXML;  // returns a string
    }


    function weather(){
        $url="http://opendata.cwb.gov.tw/opendata/MFC/F-C0032-001.xml";

        $xml=file_get_contents($url);
        $xml=simplexml_load_string($xml);
           // print_r($xml);
        $date=$xml->data;


        foreach($date->location as $loc){

            echo $loc->name."<br>";
            $i=0;
            $el="weather-elements";
            $wx=$loc->$el -> Wx->time;
           foreach( $wx as $w){
               echo "".$loc->$el->MaxT->time[$i]->value;
                echo $w->text."<br>";
                // echo $w->value;

               $i++;
            }

            echo "<br><br><br>";
        }

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


    function print_edit(){

        $width = $this -> input -> get_post('width');
        $height = $this -> input -> get_post('height');

        $firstleft = $this -> input -> get_post('firstleft');
        $firsttop = $this -> input -> get_post('firsttop');

        $secleft = $this -> input -> get_post('secleft');

        $sectop = $this -> input -> get_post('sectop');
        $thirdleft = $this -> input -> get_post('thirdleft');
        $thirdtop = $this -> input -> get_post('thirdtop');

        $sql="update webprofile set width='$width' ,height ='$height',firsttop='$firsttop',firstleft='$firstleft',sectop='$sectop',secleft='$secleft',thirdleft='$thirdleft',thirdtop='$thirdtop'";

        $this->db->query($sql);
        redirect("welcome/as5km435#tabs-5", 'refresh');

    }


    function delprint(){

        $id = $this -> uri -> segment('3', 0);
        if($id==""){

            echo "沒有選擇<br>
		    <a href='javascript:history.back()'>back</a>";
            return;
        }

        $sql="delete from printsetting where printsettingid='".$id."'";
        $this->db->query($sql);
        redirect('/welcome/as5km435#tabs-6', 'refresh');
    }


    function printsetting_update(){

        $path = $this -> all_model -> getPathIndex();
        $date['currurl'] = $path[0];
        $date['url'] = $path[1];
        $date['menu'] = $this -> all_model -> getMenu($date['url'],512);
        $date['adminurl'] = $path[1] . "welcome/";

        $edit=$this -> input -> get_post("edit");

        $printsettingid= $this -> input -> get_post("printsettingid");
        $name= $this -> input -> get_post("name");
        $width=$this -> input -> get_post("width");
        $height=$this -> input -> get_post("height");

        $sendtop=$this -> input -> get_post("sendtop");
        $sendleft= $this -> input -> get_post("sendleft");


        $rectop= $this -> input -> get_post("rectop");
        $recleft=$this -> input -> get_post("recleft");
        $orderidtop=$this -> input -> get_post("orderidtop");
        $orderidleft=$this -> input -> get_post("orderidleft");


        $sendyeartop= $this -> input -> get_post("sendyeartop");
        $sendyearleft=$this -> input -> get_post("sendyearleft");
        $sendmonthtop=$this -> input -> get_post("sendmonthtop");
        $sendmonthleft=$this -> input -> get_post("sendmonthleft");


        $senddaytop= $this -> input -> get_post("senddaytop");
        $senddayleft=$this -> input -> get_post("senddayleft");
        $desctop=$this -> input -> get_post("desctop");
        $descleft=$this -> input -> get_post("descleft");

        $ORIENTATION=$this -> input -> get_post("ORIENTATION");
        $size=$this -> input -> get_post("size");

        if(  $name==null){
            echo "沒有輸入資料<a href='".$date['url']."welcome/as5km435#tabs-6'>BACK</a>";
            return;

        }

        if($edit==1){
            $sql=" update printsetting set   name='$name',size='$size', width='$width',  height='$height',   sendtop='$sendtop',   sendleft='$sendleft',   rectop='$rectop',   recleft='$recleft',   orderidtop='$orderidtop',   orderidleft='$orderidleft',   sendyeartop='$sendyeartop',
              sendyearleft='$sendyearleft',sendmonthtop='$sendmonthtop', sendmonthleft='$sendmonthleft', senddaytop='$senddaytop', senddayleft='$senddayleft', descleft='$descleft',desctop='$desctop',ORIENTATION='$ORIENTATION'  where printsettingid='$printsettingid'";
            $this->db->query($sql);
          // echo $sql;
           // redirect('/welcome/as5km435#tabs-6', 'refresh');
        }else{

            $sql="insert into printsetting values (null,'$name','$size','$width','$height','$sendtop','$sendleft','$rectop','$recleft','$orderidtop','$orderidleft','$sendyeartop','$sendyearleft','$sendmonthtop','$sendmonthleft','$senddaytop','$senddayleft','$desctop','$descleft','$ORIENTATION',NOW())";
            $query=$this->db->query($sql);

        }


        redirect('/welcome/as5km435#tabs-6', 'refresh');


    }


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
