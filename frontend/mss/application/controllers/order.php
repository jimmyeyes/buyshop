<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Order extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/inventory/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/inventory/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index() {

		$bo = $this -> all_model -> getSecurity(512);
		if (!$bo) {
			echo "沒有權限<br><a href='javascript:history.back()'>back</a>";
			return;
		}

		$path = $this -> all_model -> getPathIndex();
		$date['currurl'] = $path[0];
		$date['url'] = $path[1];
		$date['menu'] = $this -> all_model -> getMenu($date['url'],512);
		$date['adminurl'] = $path[1] . "order/";
	
		$spdate = $this -> input -> get_post('spdate');
		$epdate = $this -> input -> get_post('epdate');
		$type = $this -> input -> get_post('type');
		$keyword = $this -> input -> get_post('keyword');
		$searchtrack = $this -> input -> get_post('tracksearch');
		
		if($spdate=="" &&  $epdate=="" && $this->session->userdata('sdate') !="" &&  $this->session->userdata('edate') !="" ){
				
			$spdate=$this->session->userdata('sdate');
			$epdate=$this->session->userdata('edate') ;
			$date['sdate']=$spdate;
			$date['edate']=$epdate;
		}else{
		
			$date['sdate']=date('Y-m-d') ;
			$date['edate']=date('Y-m-d') ;
			$date['edate']=date("Y-m-d", strtotime("+1 day", strtotime($date['sdate'])));
			$date['sdate']=date('Y-m-d') ;
			$date['edate']=date('Y-m-d') ;
			$date['edate']=date("Y-m-d", strtotime("+1 day", strtotime($date['sdate'])));
		
			if($spdate==null || $epdate==null){
				$spdate=$date['sdate'];
				$epdate=$date['edate'];
		
			}else if($spdate!="" && $epdate !=""){
				//echo "set session".$spdate."  ".$epdate;
				$this -> session -> set_userdata("sdate",$spdate);
				$this -> session -> set_userdata("edate",$epdate);
				$date['sdate']=$spdate;
				$date['edate']=$epdate;
			
				$sdate=$this->session->userdata('sdate');
				$edate=$this->session->userdata('edate') ;

			}else{
				$date['sdate']=$spdate;
				$date['edate']=$epdate;
			}
		
		}
	
		$sql="SELECT * from  accounttoken  ";
		$query=$this->db->query($sql);
		
		foreach($query->result() as $row2){
			$accountid=$row2->accounttokenid;
			$sql="SELECT * from  accounttoken where accounttokenid='".$accountid."' ";
			$orderupdatetime = $this -> db -> query($sql)->row()->orderupdatetime;
	 		//echo $orderupdatetime;
			$date1 = new DateTime($orderupdatetime);
			$temp=@date('Y',$orderupdatetime);
		
			$dateTime = new DateTime($orderupdatetime); 
			$timestr=$dateTime->format('U'); 
			$dateTime = new DateTime(); 
			$nowtimestr= $dateTime->format('U'); 
			
			$add30timestr= $dateTime->format('U'); 
			$add30timestr=strtotime('+10 minutes', $timestr);

			if($temp >1970 || $nowtimestr >$add30timestr){
				$this->refreshorderlist();
				$sql="update accounttoken set orderupdatetime =NOW() where accounttokenid='".$accountid."'";
				$this->db->query($sql);
			}
		}
	

		//,r1.SHIPTOCOUNTRYNAME,r1.TransactionID as txnid,r1.TRANSACTIONTYPE,r1.FIRSTNAME,r1.LASTNAME,r1.PROTECTIONELIGIBILITY,r1.PAYMENTSTATUS,r1.SHIPPINGAMT,r1.SHIPTOCOUNTRYCODE
		//$sql.="  left join paypalTransactionDetail r1 on r1.L_EBAYITEMTXNID0 in (m.transactionidarr) and r1.L_NUMBER0 in (m.itemidarr) ";
		$sql="select r3.Name,r2.username as sellername,m.* from orderlist m ";
		$sql.=" left join customerlist r3 on m.BuyerUserID =r3.BuyerUserID";
		$sql.=" left join accounttoken r2 on m.accounttokenid =r2.accounttokenid ";
		$sql.=" where m.reserved='0' and m.CheckoutStatusStatus='Complete' and m.BuyerUserID    in (select BuyerUserID from (select count(BuyerUserID) as co,BuyerUserID "; //not
		$sql.="  from  orderlist where 1 and reserved='0' and  CheckoutStatusStatus='Complete' AND orderlistid NOT  IN ( SELECT orderlistid FROM tracknumber) ";
		$sql.="  group by BuyerUserID ) m where 1) AND orderlistid NOT  IN ( SELECT orderlistid FROM tracknumber) ORDER BY orderlistid desc ";
	//	echo $sql."<br />";
		$query=$this->db->query($sql);
		$date['query']=$query;
		
		$query = $this -> db -> query($sql);
			$string="";
			foreach($query->result() as $row){
				if($string==""){
					$string=$row->orderlistid;
				}else{
					$string.=",".$row->orderlistid;
				}
			}
			
			$date['orderlistids1']=$string;
		//end signle
		
		//start muti
		
		//r1.SHIPTOCOUNTRYNAME,r1.TransactionID as txnid,r1.TRANSACTIONTYPE,r1.FIRSTNAME,r1.LASTNAME,r1.PROTECTIONELIGIBILITY,r1.PAYMENTSTATUS,r1.SHIPPINGAMT,r1.SHIPTOCOUNTRYCODE 
		$sql="select r3.Name,r2.username as sellername,m.* from orderlist m";
		$sql.=" left join customerlist r3 on m.BuyerUserID =r3.BuyerUserID";
		$sql.=" left join accounttoken r2 on m.accounttokenid =r2.accounttokenid ";
		$sql.="   where m.reserved='0' and m.CheckoutStatusStatus='Complete' and  m.BuyerUserID   in (select BuyerUserID from (select count(BuyerUserID) as co,BuyerUserID  from  ";
		$sql .=" orderlist where 1 and reserved='0' and CheckoutStatusStatus='Complete' AND orderlistid NOT  IN ( SELECT orderlistid FROM tracknumber) ";
		$sql.="  group by BuyerUserID ) m where m.co >=2) AND orderlistid NOT  IN ( SELECT orderlistid FROM tracknumber) ORDER BY orderlistid desc ";
		//echo $sql;
		$query=$this->db->query($sql);
		$date['querymulti']=$query;
		
		$string="";
			foreach($query->result() as $row){
				if($string==""){
					$string=$row->orderlistid;
				}else{
					$string.=",".$row->orderlistid;
				}
			}
			$date['orderlistids2']=$string;
		//end muti
		
		//start problem		
		$sql="select r2.username as sellername,m.*,r3.Name  from orderlist m";
		//$sql.="  left join paypalTransactionDetail r1 on r1.L_EBAYITEMTXNID0 in (m.transactionidarr) and r1.L_NUMBER0 in (m.itemidarr) ";
		$sql.=" left join customerlist r3 on m.BuyerUserID =r3.BuyerUserID";
		$sql.=" left join accounttoken r2 on m.accounttokenid =r2.accounttokenid ";
		$sql.="   where m.BuyerUserID   in (select BuyerUserID from (select count(BuyerUserID) as co,BuyerUserID  from  ";
		$sql .=" orderlist where 1 group by BuyerUserID ) m where m.co >=1) ORDER BY orderlistid desc  ";
		//echo $sql;
		$query=$this->db->query($sql);
		$date['problemquery']=$query;

        $query = $this -> db -> query($sql);
        $string="";
        $productid="";
        foreach($query->result() as $row){
            if($string==""){
                $string=$row->orderlistid;
            }else{
                $string.=",".$row->orderlistid;
            }
        }

        $date['problemqueryids']=$string;


		//end problem
		
		//start tracker number
		//left join paypalTransactionDetail r1 on r1.L_EBAYITEMTXNID0 =m.TransactionID
		$sql="select r2.username as sellername,m.*,r3.Name,r3.Email as buyerEmail from orderlist m ";
		$sql.=" left join customerlist r3 on m.BuyerUserID =r3.BuyerUserID";
        $sql.=" left join accounttoken r2 on m.accounttokenid =r2.accounttokenid ";
		$sql.="  where  createdtime between '".$spdate." 01:00' and '".$epdate." 23:59' ORDER BY orderlistid desc";
       // echo $sql;
		//echo $searchtrack ."<br />";
		if($searchtrack!=""){
			$date['querytrachrownum']=1;
			
			$query=$this->db->query($sql);
			$date['trackerrownum']=$query->num_rows();
			$date['trackerquery']=$query;	
			
			$query = $this -> db -> query($sql);
			$string="";
			$productid="";
			foreach($query->result() as $row){
				if($string==""){
					$string=$row->orderlistid;
				}else{
					$string.=",".$row->orderlistid;
				}
			}
			
			$date['orderlistids']=$string;
				
		}else{
			$date['querytrachrownum']=0;	
		}
		//end tracker number
		
		//search 
		
		//,r1.SHIPTOCOUNTRYNAME,r1.TransactionID as txnid,r1.TRANSACTIONTYPE,r1.FIRSTNAME,r1.LASTNAME,r1.PROTECTIONELIGIBILITY,r1.PAYMENTSTATUS,r1.SHIPPINGAMT,r1.SHIPTOCOUNTRYCODE
		// m left join paypalTransactionDetail r1 on r1.L_EBAYITEMTXNID0 =m.TransactionID
		$sql=" select r4.username as sellername,r3.Email as buyerEmail,r3.BuyerUserID,m.*,r3.Name from orderlist m  ";
   		$sql.="left join customerlist r3 on m.BuyerUserID =r3.BuyerUserID  ";
        $sql.="LEFT JOIN accounttoken r4 ON m.accounttokenid = r4.accounttokenid";
		$sql.=" where 1 ";
		//echo $sql;
		if($type!="" && $keyword!=""){
            if($type=='m.orderlistid'){
                $sql.="  and $type = '$keyword'";
            }else  if($type=='r2.number'){

                $sql=" select r4.username as sellername,r3.Email as buyerEmail,r3.BuyerUserID,m.*,r3.Name,r2.number from orderlist m  ";
                $sql.="left join customerlist r3 on m.BuyerUserID =r3.BuyerUserID  ";
                $sql.=" left join tracknumber r2 on m.orderlistid =r2.orderlistid ";
                $sql.="LEFT JOIN accounttoken r4 ON m.accounttokenid = r4.accounttokenid";
                $sql.=" where 1 ";
                $sql.="  and $type = '$keyword'";

            }else if($type=="r3.Name"){

                $sql.="  and $type like '%$keyword%'";
            }else if($type=="r5.TRANSACTIONID"){
                $sql="   select r4.username as sellername,r3.Email as buyerEmail,r3.BuyerUserID,m.*,r3.Name from orderlist m ";
                $sql.="left join customerlist r3 on m.BuyerUserID =r3.BuyerUserID ";
                $sql.="LEFT JOIN accounttoken r4 ON m.accounttokenid = r4.accounttokenid ";
                $sql.="left join paypalTransactionDetail r5 on r5.RECEIVEREMAIL =m.SellerEmail and ";
                $sql.=" r5.L_NUMBER0 in (m.itemidarr) and r5.L_EBAYITEMTXNID0 in (m.transactionidarr) ";
                $sql.="where 1 and r5.TRANSACTIONID = '".$keyword."' ";
            }
            else {

                $sql.="  and $type = '$keyword'";
            }
			$date['querysearchrownum']=1;
			$date['type']=$type;
			$date['keyword']=$keyword;			
		}else{
			$date['querysearchrownum']=0;
			$date['type']="";
			$date['keyword']="";		
		}
		//echo $sql."  ";
       // $sql.="  limit 1";
		$query=$this->db->query($sql ."  ORDER BY orderlistid desc");
		$date['querysearch']=$query;
		
		//end search
		
		//back orderlist
		
		$sql="select r3.Name,r2.username  as sellername,m.* from orderlist m";
		$sql.=" left join customerlist r3 on m.BuyerUserID =r3.BuyerUserID";
		$sql.=" left join accounttoken r2 on m.accounttokenid =r2.accounttokenid ";
		$sql.="   where m.reserved='0' and m.CheckoutStatusStatus='Complete'";
	//	echo $sql;
		$query=$this->db->query($sql);
		$date['backquery']=$query;
		
		
		//end back orderlist
		
		$this -> master2 -> view('order/orderlist_view', $date);

	}

	
	function refreshorderlist(){
		
		$sql="SELECT * from  accounttoken  ";
		$query=$this->db->query($sql);
		foreach($query->result() as $row2){
			$accountid=$row2->accounttokenid;
			$sql="update accounttoken set orderupdatetime =NOW() where accounttokenid='".$accountid."'";
			$this->db->query($sql);
			$xml=simplexml_load_string( $this -> all_model ->GetOrders($accountid));
			//echo "ReturnedOrderCountActual :".$xml->ReturnedOrderCountActual;
		//	print_r($xml);
				$order=$xml->OrderArray->Order;
				
				foreach($order as $row){
				//	echo $row->OrderID;
					$sqlorderlist="select count( orderlistid) as co from  orderlist where OrderID='".$row->OrderID."'";
					//echo $sqlorderlist;
					$orderlistid="";
					$co=$this->db->query($sqlorderlist)->row();
					if($co->co ==0)	{

                        $BuyerCheckoutMessage=$row->BuyerCheckoutMessage;

                        $BuyerCheckoutMessage=str_replace('"',"'",$BuyerCheckoutMessage);

						$sql="insert into orderlist values ('','".$xml."','".$row->OrderID."','".$row->OrderStatus."','".$row->AmountPaid."','".$row->CheckoutStatus->eBayPaymentStatus."','".$row->CheckoutStatus->LastModifiedTime."',";
						$sql.="'".$row->CheckoutStatus->PaymentMethod."','".$row->CheckoutStatus->Status."','".$row->CreatedTime."','".$row->PaymentMethods."','".$row->SellerEmail."','".$row->BuyerUserID."',";
						$sql.="'".$row->PaidTime."','".$row->EIASToken."','".$row->ShippingServiceSelected->ShippingService."','".$row->ShippingServiceSelected->ShippingServiceCost."',";
						$sql.="'".$row->Subtotal."','".$row->Total."','','',";
						$sql.="'".$accountid."',\"".$BuyerCheckoutMessage."\",'0','','','0',NOW())";
						$this->db->query($sql);
						
						$orderlistid=$this->db->insert_id();
						$Transactionarr=$row->TransactionArray->Transaction;

						foreach($Transactionarr as $row2){
							$sql="select count( orderlistid) as co from  orderlistprod where OrderLineItemID='".$row2->OrderLineItemID."'";
							//echo $sql;
							$co=$this->db->query($sql)->row();
							if($co->co ==0)	{
								$sql="insert into orderlistprod values (null,'".$orderlistid."','".$row2->Buyer->Email."','".$row2->CreatedDate."','".$row2->Item->ItemID."','".$row2->Item->Site."','".$row2->Item->Title."','".$row2->Item->SKU."',";
								$sql.="'".$row2->QuantityPurchased."','".$row2->TransactionID."','".$row2->TransactionPrice."','".$row2->TransactionSiteID."','".$row2->Platform."',";
								$sql.="'".$row2->ActualShippingCost."','".$row2->ActualHandlingCost."','".$row2->OrderLineItemID."',NOW())";
								
								$this->db->query($sql);
						//echo $sql;
							}else{

                                $sql="update orderlistprod set SKU='".$row2->Item->SKU."' where  OrderLineItemID='".$row2->OrderLineItemID."'";
                                $this->db->query($sql);
								}
						}
						
						$sql="select * from  orderlistprod where orderlistid='".$orderlistid."'";
						$query=$this->db->query($sql);
						
						$ItemID="";
						$TransactionID="";
						foreach($query->result() as $row3){
							if($TransactionID=="")
								$TransactionID=$row3->TransactionID;
							else {
								$TransactionID.=",".$row3->TransactionID;
							}
							if($ItemID=="")
								$ItemID=$row3->ItemID;
							else {
								$ItemID.=",".$row3->ItemID;
							}
							
							
						}
						
						$sql="update orderlist set itemidarr='$ItemID' ,transactionidarr='$TransactionID' where orderlistid ='$orderlistid'";
						$this->db->query($sql);
					
					}else{

                        $BuyerCheckoutMessage=$row->BuyerCheckoutMessage;

                        $BuyerCheckoutMessage=str_replace('"',"'",$BuyerCheckoutMessage);

                        $sql="update orderlist set  ShippingServiceCost='".$row->ShippingServiceSelected->ShippingServiceCost."',ShippingService='".$row->ShippingServiceSelected->ShippingService."',  OrderStatus='".$row->OrderStatus."' ,eBayPaymentStatus ='".$row->CheckoutStatus->eBayPaymentStatus."'";
						$sql.=",CheckoutStatusStatus='".$row->CheckoutStatus->Status."', PaymentMethod='".$row->CheckoutStatus->PaymentMethod."',PaymentMethods='".$row->PaymentMethods."' ,PaidTime='".$row->PaidTime."'  , EIASToken='".$row->EIASToken."'  , BuyerCheckoutMessage= \"".$BuyerCheckoutMessage."\"   where OrderID='".$row->OrderID."' ";
						$this->db->query($sql);
						
						$sqlorderlist="select  orderlistid from  orderlist where OrderID='".$row->OrderID."'";

						$co=$this->db->query($sqlorderlist)->row();
						$orderlistid=$co->orderlistid;
						
						$Transactionarr=$row->TransactionArray->Transaction;
						//print_r($Transactionarr);
						foreach($Transactionarr as $row2){
						
							$sql="select count( orderlistid) as co from  orderlistprod where OrderLineItemID='".$row2->OrderLineItemID."'";
							//echo $sql;
							$co=$this->db->query($sql)->row();
							if($co->co ==0)	{
								$sql="insert into orderlistprod values (null,'".$orderlistid."','".$row2->Buyer->Email."','".$row2->CreatedDate."','".$row2->Item->ItemID."','".$row2->Item->Site."','".$row2->Item->Title."','".$row2->Item->SKU."',";
								$sql.="'".$row2->QuantityPurchased."','".$row2->TransactionID."','".$row2->TransactionPrice."','".$row2->TransactionSiteID."','".$row2->Platform."',";
								$sql.="'".$row2->ActualShippingCost."','".$row2->ActualHandlingCost."','".$row2->OrderLineItemID."',NOW())";
								
								$this->db->query($sql);
								//echo $sql;
							}else{
                                $sql="update orderlistprod set SKU='".$row2->Item->SKU."' where  OrderLineItemID='".$row2->OrderLineItemID."'";
                                $this->db->query($sql);
							}
						}
						
						$sql="select * from  orderlistprod where orderlistid='".$orderlistid."'";
						$query=$this->db->query($sql);
						
						$ItemID="";
						$TransactionID="";
						foreach($query->result() as $row3){
							if($TransactionID=="")
								$TransactionID=$row3->TransactionID;
							else {
								$TransactionID.=",".$row3->TransactionID;
							}
							if($ItemID=="")
								$ItemID=$row3->ItemID;
							else {
								$ItemID.=",".$row3->ItemID;
							}
						}
						
						$sql="update orderlist set itemidarr='$ItemID' ,transactionidarr='$TransactionID' where orderlistid ='$orderlistid'";
						$this->db->query($sql);
						
					}
				
					$sql="select count( BuyerUserID) as co from  customerlist where BuyerUserID='".$row->BuyerUserID."'";
					$co=$this->db->query($sql)->row();
					if($co->co ==0)	{

                        $Street1= $row->ShippingAddress->Street1;
                        $Street1=str_replace('"',"'",$Street1);

                        $Street2= $row->ShippingAddress->Street2;
                        $Street2=str_replace('"',"'",$Street2);

						$sql="insert into customerlist values ('','".$row->TransactionArray->Transaction->Buyer->Email."','".$row->BuyerUserID."',\"".$row->ShippingAddress->Name."\",\"".$Street1."\",\"".$Street2."\",\"".$row->ShippingAddress->CityName."\",\"".$row->ShippingAddress->StateOrProvince."\",\"".$row->ShippingAddress->Country."\",\"".$row->ShippingAddress->CountryName."\",'".$row->ShippingAddress->Phone."','".$row->ShippingAddress->PostalCode."','".$row->ShippingAddress->AddressID."','".$row->ShippingAddress->AddressOwner."',NOW())";
						$this->db->query($sql);
					}
				}
			}

		$this->getPaypalTrans();
		redirect('/order/index', 'refresh');
	}

    function ipnRefeshOrder(){

        $sql="SELECT * from  accounttoken  ";
        $query=$this->db->query($sql);
        foreach($query->result() as $row2){
            $accountid=$row2->accounttokenid;
            $sql="update accounttoken set orderupdatetime =NOW() where accounttokenid='".$accountid."'";
            $this->db->query($sql);
            $xml=simplexml_load_string( $this -> all_model ->GetOrdersOneDay($accountid));
            //echo "ReturnedOrderCountActual :".$xml->ReturnedOrderCountActual;
            //	print_r($xml);
            $order=$xml->OrderArray->Order;

            foreach($order as $row){
                //	echo $row->OrderID;
                $sqlorderlist="select count( orderlistid) as co from  orderlist where OrderID='".$row->OrderID."'";
                //echo $sqlorderlist;
                $orderlistid="";
                $co=$this->db->query($sqlorderlist)->row();
                if($co->co ==0)	{
                    $sql="insert into orderlist values ('','".$xml."','".$row->OrderID."','".$row->OrderStatus."','".$row->AmountPaid."','".$row->CheckoutStatus->eBayPaymentStatus."','".$row->CheckoutStatus->LastModifiedTime."',";
                    $sql.="'".$row->CheckoutStatus->PaymentMethod."','".$row->CheckoutStatus->Status."','".$row->CreatedTime."','".$row->PaymentMethods."','".$row->SellerEmail."','".$row->BuyerUserID."',";
                    $sql.="'".$row->PaidTime."','".$row->EIASToken."','".$row->ShippingServiceSelected->ShippingService."','".$row->ShippingServiceSelected->ShippingServiceCost."',";
                    $sql.="'".$row->Subtotal."','".$row->Total."','','',";
                    $sql.="'".$accountid."','".$row->BuyerCheckoutMessage."','0','','','0',NOW())";
                    $this->db->query($sql);

                    $orderlistid=$this->db->insert_id();
                    $Transactionarr=$row->TransactionArray->Transaction;
                    //print_r($Transactionarr);
                    foreach($Transactionarr as $row2){
                        $sql="select count( orderlistid) as co from  orderlistprod where OrderLineItemID='".$row2->OrderLineItemID."'";
                        //echo $sql;
                        $co=$this->db->query($sql)->row();
                        if($co->co ==0)	{
                            $sql="insert into orderlistprod values (null,'".$orderlistid."','".$row2->Buyer->Email."','".$row2->CreatedDate."','".$row2->Item->ItemID."','".$row2->Item->Site."','".$row2->Item->Title."','".$row2->Item->SKU."',";
                            $sql.="'".$row2->QuantityPurchased."','".$row2->TransactionID."','".$row2->TransactionPrice."','".$row2->TransactionSiteID."','".$row2->Platform."',";
                            $sql.="'".$row2->ActualShippingCost."','".$row2->ActualHandlingCost."','".$row2->OrderLineItemID."',NOW())";

                            $this->db->query($sql);
                            //echo $sql;
                        }else{

                            $sql="update orderlistprod set SKU='".$row2->Item->SKU."' where  OrderLineItemID='".$row2->OrderLineItemID."'";
                            $this->db->query($sql);
                        }
                    }

                    $sql="select * from  orderlistprod where orderlistid='".$orderlistid."'";
                    $query=$this->db->query($sql);

                    $ItemID="";
                    $TransactionID="";
                    foreach($query->result() as $row3){
                        if($TransactionID=="")
                            $TransactionID=$row3->TransactionID;
                        else {
                            $TransactionID.=",".$row3->TransactionID;
                        }
                        if($ItemID=="")
                            $ItemID=$row3->ItemID;
                        else {
                            $ItemID.=",".$row3->ItemID;
                        }


                    }

                    $sql="update orderlist set itemidarr='$ItemID' ,transactionidarr='$TransactionID' where orderlistid ='$orderlistid'";
                    $this->db->query($sql);

                }else{

                }

                $sql="select count( BuyerUserID) as co from  customerlist where BuyerUserID='".$row->BuyerUserID."'";
                $co=$this->db->query($sql)->row();
                if($co->co ==0)	{

                    $Street1= $row->ShippingAddress->Street1;
                    $Street1=str_replace('"',"'",$Street1);

                    $Street2= $row->ShippingAddress->Street2;
                    $Street2=str_replace('"',"'",$Street2);

                    $sql="insert into customerlist values ('','".$row->TransactionArray->Transaction->Buyer->Email."','".$row->BuyerUserID."',\"".$row->ShippingAddress->Name."\",\"".$Street1."\",\"".$Street2."\",\"".$row->ShippingAddress->CityName."\",\"".$row->ShippingAddress->StateOrProvince."\",\"".$row->ShippingAddress->Country."\",\"".$row->ShippingAddress->CountryName."\",'".$row->ShippingAddress->Phone."','".$row->ShippingAddress->PostalCode."','".$row->ShippingAddress->AddressID."','".$row->ShippingAddress->AddressOwner."',NOW())";
                    $this->db->query($sql);
                }
            }
        }


    }


    function getPaypalTrans(){
		$sdate=date('Y-m-d');
		$sdate=date('Y-m-d',strtotime("-10 day", strtotime($sdate))) ;
		$edate=date("Y-m-d", strtotime("+11 day", strtotime($sdate)));
			
		$trand=$this->all_model->SearchTransaction($sdate,$edate);	
		$sql="SELECT * FROM `paypaltransaction` WHERE createtime between '".$sdate."' and '".$edate."'";
	//	echo $sql;
		$query=$this->db->query($sql);
		foreach($query->result() as $row){
			if($row->STATUS=="Completed"){
				//echo $row->STATUS."<br />";
				$this->all_model->GetTransactionDetails($row->TRANSACTIONID);
			   // echo $row->TRANSACTIONID."<br />";
			}
		}

		$sql="select * from paypalTransactionDetail where PAYMENTSTATUS !='Completed'";
		$query=$this->db->query($sql);
		foreach($query->result() as $row){

            if($row->L_EBAYITEMTXNID0 !=""){
			$sql="select * from orderlist where itemidarr in ($row->L_NUMBER0) and transactionidarr in ($row->L_EBAYITEMTXNID0) ";
			$row2=$this->db->query($sql)->row();
			
			$sql="update orderlist set CheckoutStatusStatus ='$row->PAYMENTSTATUS' where orderlistid='$row2->orderlistid'";
			$this->db->query($sql);
            }
			
		}
		
		
	}
	

	function updatetrackerbath(){
		$bo = $this -> all_model -> getSecurity(1024);
		if (!$bo) {
			echo "沒有權限<br>
		<a href='javascript:history.back()'>back</a>";
			return;
		}
		
		$orderlistid = $this -> input -> get_post("orderlistid");
		$chk = $this -> input -> get_post("chk4");
		$arr=explode(",",$orderlistid);


        if($chk==""){
            echo "不能為空";
            return;

        }
		//print_r($chk) ;
		foreach($arr as $ar){
			foreach(@$chk as $ch){
				//echo $ch;
			if($ch==$ar){
			
				//echo $ch;
			
				//$sql="select m.*,r1.accounttokenid,r1.TransactionID,r1.OrderID from tracknumber m left join orderlistid r1 on m.orderlistid=r1.orderlistid  where orderlistid='".$ar."' ";
				$sql="select m.*,r1.name from tracknumber m left join courier r1 on m.courierid=r1.courierid where m.orderlistid='".$ar."' limit 1";
				$query2=$this->db->query($sql);
			
				$number="";
				$courierid="";
				
				foreach($query2->result() as $row2){
					
					$number=$row2->number;
					$courierid=$row2->name;
					
					$sql="select m.accounttokenid,m.OrderID,r1.TransactionID,r1.OrderLineItemID,r1.ItemID from orderlist m left join orderlistprod r1 on m.orderlistid=r1.orderlistid where m.orderlistid='".$ar."' ";
					$query=$this->db->query($sql);
					foreach($query->result() as $row){
						$orderid=$row->OrderID;
						$TransactionID=$row->TransactionID;
						$accounttokenid=$row->accounttokenid;
						$OrderLineItemID=$row->OrderLineItemID;
                        $ItemID=$row->ItemID;

						$res=$this->all_model->UpdateTrackNumber($accounttokenid,$number,$courierid,$orderid,$OrderLineItemID,$TransactionID,$ItemID);

                      //  print_r("asdfasdf:".$res);

						$xml=simplexml_load_string($res);

						if($xml->Ack=="Failure"){
							print_r($xml);
							//exit;
						}else{
                           // print_r("ok".$res);
                            redirect('/order/order#tabs-5', 'refresh');
                        }
					}
			
				}
			}
			}
		}	
		
		//
	}
	
	function ordernote(){
		$bo = $this -> all_model -> getSecurity(512);
		if (!$bo) {
			echo "沒有權限<br><a href='javascript:history.back()'>back</a>";
			return;
		}
		
		$path = $this -> all_model -> getPathIndex();
		$date['currurl'] = $path[0];
		$date['url'] = $path[1];
		$date['menu'] = $this -> all_model -> getMenu($date['url'],512);
		$date['adminurl'] = $path[1] . "order/";
		$orderlistid = $this -> uri -> segment('3', 0);
		$sql="select * from orderlist where orderlistid='$orderlistid' ";
		$num=$this->db->query($sql)->num_rows;
		
		if($num==0) {
			echo "沒有權限<br><a href='javascript:history.back()'>back</a>";
			return;
		}
		
		$date['row']=$this->db->query($sql)->row();
		$sql="select * from ordernote where orderlistid='$orderlistid' ";
		$num=$this->db->query($sql)->num_rows;
		if($num==0){
			$sql="insert into ordernote values (null,'$orderlistid','','',NOW(),NOW()) ";
			$this->db->query($sql);
		}
		
		$sql="select * from ordernote where orderlistid='$orderlistid'";
		//echo $sql;
		$date['query']=$this->db->query($sql)->row();
		$this -> master2 -> view('order/ordernote_view', $date);
		
	}
	
	function buyernote(){
		$bo = $this -> all_model -> getSecurity(512);
		if (!$bo) {
			echo "沒有權限<br><a href='javascript:history.back()'>back</a>";
			return;
		}
		
		$path = $this -> all_model -> getPathIndex();
		$date['currurl'] = $path[0];
		$date['url'] = $path[1];
		$date['menu'] = $this -> all_model -> getMenu($date['url'],512);
		$date['adminurl'] = $path[1] . "order/";
		$orderlistid = $this -> uri -> segment('3', 0);
		
		$sql="select * from orderlist where orderlistid='$orderlistid' ";
		$row=$this->db->query($sql)->row();
		
	
		
		$date['row']=$row;
		
		$this -> master2 -> view('order/buyernote_view', $date);
		
	}

	function updateordernote(){
			
		$bo = $this -> all_model -> getSecurity(512);
		if (!$bo) {
			echo "沒有權限<br><a href='javascript:history.back()'>back</a>";
			return;
		}
		
		$path = $this -> all_model -> getPathIndex();
		$date['currurl'] = $path[0];
		$date['url'] = $path[1];
		$date['menu'] = $this -> all_model -> getMenu($date['url'],512);
		$date['adminurl'] = $path[1] . "order/";
		
		$ordernoteid = $this -> input -> get_post('ordernoteid');
		$note = $this -> input -> get_post('note');
		$modify = $this -> input -> get_post('modify');
		
	
		$sql="update ordernote set note='$note' ,modifyusername='".$modify."'  , updatetime=NOW() where ordernoteid='$ordernoteid'";
		$this->db->query($sql);
			
		
		redirect('/order/order', 'refresh');
	}


	
	function updateorderlist(){
		
		$bo = $this -> all_model -> getSecurity(512);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}
		
		$orderlistid = $this -> input -> get_post("orderlistid");
		$modtype = $this -> input -> get_post("modtype");
		$type = $this -> input -> get_post("type");
		
		
		$chk ="";
		if($type=="1"){
			$chk = $this -> input -> get_post("chk1");
		}else if($type=="2"){
			$chk = $this -> input -> get_post("chk2");
		}
		
		$arr=explode(",",$orderlistid);
		$orderlistidarr="";
		//print_r($chk) ;

        if($arr==null | $chk==null){
            echo "error";
            return;
        }

		foreach($arr as $ar){
			foreach(@$chk as $ch){
			if($ch==$ar){
				
				if($modtype=="Reserved"){
				
					$sql="update orderlist set reserved='1' where orderlistid='".$ar."'";
					//echo $sql;
					$query = $this -> db -> query($sql);
				}else if($modtype=="Shipping"){
					
					if($orderlistidarr==""){
						$orderlistidarr=$ar;
					}else{
						$orderlistidarr.=",".$ar;
					}
					
					
				}else if($modtype=="return"){
					$sql="update orderlist set backnumber='1' where orderlistid='".$ar."'";
					$this->db->query($sql);
					//echo $sql;
                }else if($modtype=="dhl"){


                    $sql="select * from orderlist m where orderlistid ='$ar' and dhl ='1'";
                    $count=$this->db->query($sql)->num_rows();
                    if($count >0){

                        continue;
                    }


                    $sql= "select * from orderlist  where orderlistid='$ar'";
                    $row=$this->db->query($sql)->row();

                    $json = new stdClass();
                    $json->MessageReference=$row->OrderID;
                    $json->PackageType="YP";
                    $date=date('Y-m-d');
                    $json->Date=$date;
                    $json->orderid=$ar;

                    $dhlrtn=$this->dhl_model-> dhlapi(json_encode($json));
                    if($dhlrtn !=""){
                        echo $dhlrtn;
                        return;
                    }

                    $sql="update orderlist set dhl='1' where orderlistid='".$ar."'";
                    $this->db->query($sql);

                  //  return;

				}else{

                    if($orderlistidarr==""){
                        $orderlistidarr=$ar;
                    }else{
                        $orderlistidarr.=",".$ar;
                    }

                }
			}
			}
		}


        if($modtype=="print"){

            $path = $this -> all_model -> getPathIndex();
            $date['currurl'] = $path[0];
            $date['url'] = $path[1];
            $date['menu'] = $this -> all_model -> getMenu($date['url'],512);
            $date['adminurl'] = $path[1] . "order/";



            $date['orderlistidarr']=$orderlistidarr;


            $this -> load -> view('order/orderprintbath_view', $date);
            return;

        }


		if($modtype=="return"){
					
		}
		
		
		if($modtype=="Shipping"){
			$path = $this -> all_model -> getPathIndex();
			$date['currurl'] = $path[0];
			$date['url'] = $path[1];
			$date['menu'] = $this -> all_model -> getMenu($date['url'],512);
			$date['adminurl'] = $path[1] . "order/";
			
			$sql="select * from orderlist m left join orderlistprod r1 on r1.itemID in (m.itemidarr) and r1.TransactionID in (m.transactionidarr) where m.orderlistid in ($orderlistidarr)";
			$date['query']=$this->db->query($sql);
			$date['date']=$this->all_model->getDate();
			$sql="select * from courier";
			$date['courier']=$this->db->query($sql);
		
			$sql="select * from package";
			$date['package']=$this->db->query($sql);
			
			
			$date['orderlistid']=$orderlistidarr;
			$this -> master2 -> view('order/order_bath_tracknumber_view', $date);
			return;
		}
	
		redirect('/order/order', 'refresh');
		
	}

    function dhl_print(){

        $ar = $this -> uri -> segment('3', 0);
        $check = $this -> uri -> segment('4', 0);
        if($check!="0"){

            $sql="select * from orderlist m where orderlistid ='$ar' and dhl ='1'";
            $count=$this->db->query($sql)->num_rows();
            if($count >0){

                $sql="select * from dhlserviceresponse where orderlistid='$ar' ";
                $query=$this->db->query($sql);
                $count=$query->num_rows();
                if($count ==0){
                  //  echo "error data";
                   $this->dhl_api($ar);
                }else{

                    $AWBBarCode="";
                    $MessageReference="";
                    foreach($query->result() as $row){
                        $OutputImage=$row->OutputImage;
                        $MessageReference=$row->MessageReference;
                    }

                    $this->dhl_api($ar);

                   redirect(base_url().'pdf.php?name='.$MessageReference.'', 'refresh');
                    return;
                }
            }else{

                $this->dhl_api($ar);

            }

        }else{
            $sql="select * from orderlist m where orderlistid ='$ar' and dhl ='1'";
            $count=$this->db->query($sql)->num_rows();
            if($count >0){

                $sql="select * from dhlserviceresponse where orderlistid='$ar' ";
                $query=$this->db->query($sql);
                $count=$query->num_rows();
                if($count ==0){
                    //  echo "error data";
                    $this->dhl_api($ar);
                }else{

                    $AWBBarCode="";
                    $MessageReference="";
                    foreach($query->result() as $row){
                        $OutputImage=$row->OutputImage;
                        $MessageReference=$row->MessageReference;
                    }

                    $this->dhl_api($ar);
                    redirect(base_url().'pdf.php?name='.$MessageReference.'', 'refresh');
                    return;
                }
            }else{
                $this->dhl_api($ar);
            }
        }

    }

    function dhl_api($ar){

       // echo "dhl_api";
        $sql= "select * from orderlist  where orderlistid='$ar'";
        $row=$this->db->query($sql)->row();

        $json = new stdClass();
        $json->MessageReference=$row->OrderID;
        $json->PackageType="YP";
        $date1=date('Y-m-d');
        $date=date('Y-m-d',strtotime($date1.'+1 days'));
        $json->Date=$date;
        $json->orderid=$ar;
        $dhlrtn=$this->dhl_model-> dhlapi(json_encode($json));

        if($dhlrtn !=""){
            echo $dhlrtn;
            return;
        }else{
            $sql="update orderlist set dhl='1' where orderlistid='".$ar."'";
            $this->db->query($sql);

            $sql="select * from dhlserviceresponse where orderlistid='$ar' ";
            $query=$this->db->query($sql);
            $count=$query->num_rows();
            if($count ==0){
                echo $dhlrtn."234  :3:  ";
                echo " dhl_api error data";
                return;
            }

            $AWBBarCode="";
            $MessageReference="";
            foreach($query->result() as $row){
                $OutputImage=$row->OutputImage;
                $MessageReference=$row->MessageReference;
            }


          //  echo "success";

           redirect('/order/dhl_label/'.$ar.'', 'refresh');
            return;

        }

    }




    function dhl_label(){

        $id = $this -> uri -> segment('3', 0);
        $sql="select * from dhlserviceresponse where orderlistid='$id' order by createtime desc limit 1 ";
        $query=$this->db->query($sql);
        $count=$query->num_rows();
        if($count ==0){
            echo "error data";
            return;
        }
        $AWBBarCode="";
        $MessageReference="";
        foreach($query->result() as $row){
            $OutputImage=$row->OutputImage;
            $MessageReference=$row->MessageReference;
        }

        $data=  base64_decode($OutputImage);
        $dir=dirname(dirname(dirname(__FILE__)));
        // echo $dir;
        file_put_contents($dir.'/uploads/'.$MessageReference.'.pdf', $data);

        redirect(base_url().'pdf.php?name='.$MessageReference.'', 'refresh');

      //  $item=base_url().'/uploads/'.$MessageReference.'.pdf';
      //  header('Expires: 0');
      // header("location: $item");
    }



    function ordershipinfo(){
	
		$bo = $this -> all_model -> getSecurity(512);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}
		
		$path = $this -> all_model -> getPathIndex();
		$date['currurl'] = $path[0];
		$date['url'] = $path[1];
		$date['menu'] = $this -> all_model -> getMenu($date['url'],512);
		$date['adminurl'] = $path[1] . "order/";
		$orderlistid = $this -> uri -> segment('3', 0);
		
		if($orderlistid ==""){
			echo "error";
			return;
		}

        $sql="  SELECT * FROM `orderlist` m where  m.orderlistid='".$orderlistid."'";
        $query=$this->db->query($sql);
        foreach($query->result() as $row2){

         $BuyerUserID=$row2->BuyerUserID;

         $sql="select * from paypalTransactionDetail  where L_EBAYITEMTXNID0 in ($row2->transactionidarr) and itemidarr in ($row2->itemidarr)";
         $query=$this->db->query($sql);
        // echo $sql;

            $row=$query->row();

            $sql="select * from shippingaddr where orderlistid ='$orderlistid'";
            $count=$this->db->query($sql)->num_rows();

            if($count ==0){

            $sql=" update  customerlist set Name=\"".$row->SHIPTONAME."\" ,Street1=\"".$row->SHIPTOSTREET."\" ,CityName=\"".$row->SHIPTOCITY."\", StateOrProvince=\"".$row->SHIPTOSTATE."\",CountryName=\"".$row->SHIPTOCOUNTRYNAME."\",PostalCode ='$row->SHIPTOZIP' where BuyerUserID='$BuyerUserID' ";
           // echo $sql;
            $this->db->query($sql);
            }
         }



    /*    $sql="select * from dhlserviceresponse where orderlistid  ='".$row->orderlistid."'";
        $dhlcount=$this->db->query($sql)->num_rows();

        if($dhlcount>0){
            echo "<a href='".$adminurl."dhl_label/$row->orderlistid' target='_blank'>(D)</a>";
        }
*/

		$sql="select r1.*,m.accounttokenid,m.tonumber,m.backnumber from orderlist m left join customerlist r1 on m.BuyerUserID=r1.BuyerUserID where orderlistid='".$orderlistid."'";
		//echo $sql;
        $query=$this->db->query($sql)->row();
		$date['trans'] = $query;

		$sql="select m.*,r1.name from shippingaddr m left join member r1 on r1.memberid=m.memberid where orderlistid='".$orderlistid."'";
		
		$query2=$this->db->query($sql);
		$date['orderlist'] = $query;
		$date['shippingaddr'] = $query2;
		if($query2->num_rows==0){
			$date['status']="";
		}else{
			foreach($query2->result() as $row){
			$date['status']=$row->status;
			}
		}
	
		$date['orderlistid']=$orderlistid;
		$this -> master2 -> view('order/ordershipinfo_view', $date);
		
}

    function updateContent(){

        $orderlistid = $this -> input->get_post('orderlistid');

        $content = $this -> input -> get_post("content");

        $sql="select * from mynote where orderlistid='$orderlistid'";
        $count=$this->db->query($sql)->num_rows();

        if($count >0){
            $sql="update  mynote set content='$content' where orderlistid='$orderlistid'";
        }else{
            $sql="insert into  mynote values(null,'$orderlistid','$content')";

            }

        $this->db->query($sql);

        redirect('/order/ordershipinfo/'.$orderlistid, 'refresh');

    }

	function updateordershipinfo(){
	
		$bo = $this -> all_model -> getSecurity(512);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}
		
		$SHIPTONAME = $this -> input -> get_post("SHIPTONAME");
		$SHIPTOSTREET = $this -> input -> get_post("SHIPTOSTREET");
		$SHIPTOCITY = $this -> input -> get_post("SHIPTOCITY");
		$SHIPTOSTATE = $this -> input -> get_post("SHIPTOSTATE");
		$SHIPTOZIP = $this -> input -> get_post("SHIPTOZIP");
		$SHIPTOCOUNTRYNAME = $this -> input -> get_post("SHIPTOCOUNTRYNAME");
		$phone = $this -> input -> get_post("phone");	
		$status = $this -> input -> get_post("status");
		$username = $this -> input -> get_post("username");
		$password = $this -> input -> get_post("password");
		$orderlistid = $this -> input -> get_post("orderlistid");
		$BuyerUserID = $this -> input -> get_post("BuyerUserID");
        $Country = $this -> input -> get_post("Country");

		$memberid=$this -> all_model -> getMemberid($username,$password);
		if($memberid=="0"){
			echo $this -> all_model -> getErr();
			return;
		}
		
		if($status=="Reversed"){
			$sql="update  orderlist set reserved='1' where orderlistid='$orderlistid'";
			$this->db->query($sql);


            redirect('/order/ordershipinfo/'.$orderlistid, 'refresh');
		}else{

			$sql="insert into shippingaddr values (null,'".$orderlistid."','".$SHIPTONAME."','".$SHIPTOSTREET."','".$SHIPTOCITY."','".$SHIPTOSTATE."','".$SHIPTOZIP."','".$SHIPTOCOUNTRYNAME."','".$Country."','".$phone."','".$status."','".$memberid."',NOW())";
			$this->db->query($sql);
			
			$sql=" update  customerlist set Country='$Country', Name='$SHIPTONAME' ,Street1='$SHIPTOSTREET' ,CityName='$SHIPTOCITY', StateOrProvince='$SHIPTOSTATE',CountryName='$SHIPTOCOUNTRYNAME',Phone='$phone',PostalCode ='$SHIPTOZIP' where BuyerUserID='$BuyerUserID' ";
			//echo $sql;
            $this->db->query($sql);


           // $this->dhl_print("0");
            redirect('/order/dhl_print/'.$orderlistid.'/0', 'refresh');

		}

	
	}

	function shippinginfo(){
		$bo = $this -> all_model -> getSecurity(512);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}
		
		$path = $this -> all_model -> getPathIndex();
		$date['currurl'] = $path[0];
		$date['url'] = $path[1];
		$date['menu'] = $this -> all_model -> getMenu($date['url'],512);
		$date['adminurl'] = $path[1] . "order/";
		
		$orderlistid = $this -> uri -> segment('3', 0);
		
		if($orderlistid==""){
			echo "error";		
			return;
		}
		
		$sql="select m.*,r2.name as couriername from tracknumber m left join orderlist r1 on m.orderlistid=r1.orderlistid  ";
		$sql.=" left join courier r2 on m.courierid= r2.courierid   where m.orderlistid='".$orderlistid."'";
		$date['querylist']=$this->db->query($sql);
		
		
		$sql="select m.* from orderlist m   where m.orderlistid='".$orderlistid."'";
		$date['orderlist']=$this->db->query($sql)->row();
		
		
		$sql="select * from courier";
		$date['courier']=$this->db->query($sql);
		
		$sql="select * from package";
		$date['package']=$this->db->query($sql);

		$date['date']=$this->all_model->getDate();
		$this -> master2 -> view('order/ordertracknumber_view', $date);
		
		
	}

	function tracknumber_adds(){
		$bo = $this -> all_model -> getSecurity(512);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}

		$number = $this -> input -> get_post("number");
		$weight = $this -> input -> get_post("weight");
		$courierid = $this -> input -> get_post("courierid");
		$package = $this -> input -> get_post("package");
		$orderlistid = $this -> input -> get_post("orderlistid");
		$date=$this -> input -> get_post("date");
		$sn=$this -> input -> get_post("sn");
		$shippreturn=$this -> input -> get_post("shippreturn");


        if($package ==null ||  $courierid ==null || $weight ==null ){
            echo "error no null";
            return;
        }


		$sql="insert into tracknumber values (null,'$courierid','$number','$orderlistid','$package','$weight','$sn','$shippreturn','$date',NOW())";
		$this->db->query($sql);
		
		redirect('/order/shippinginfo/'.$orderlistid, 'refresh');
		
	}
	
	function tracknumber_del(){
		
		$bo = $this -> all_model -> getSecurity(512);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}
		
		$tracknumberid = $this -> uri -> segment('3', 0);
		$orderlistid = $this -> uri -> segment('4', 0);
		$sql="delete from tracknumber where tracknumberid='$tracknumberid'";
		$this->db->query($sql);
		
		redirect('/order/shippinginfo/'.$orderlistid, 'refresh');
		
	}
	
	
	
	
	function toback_update(){
		$bo = $this -> all_model -> getSecurity(512);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}

		$orderlistid = $this -> uri -> segment('3', 0);
		$sql="update orderlist set backnumber='1' where orderlistid='$orderlistid'";
		$this->db->query($sql);
	//	echo $sql;
		redirect('/order/ordershipinfo/'.$orderlistid, 'refresh');
		
	}

	
	function tracknumber_update(){
		$bo = $this -> all_model -> getSecurity(512);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}
		$tonumber=$this -> input -> get_post("tonumber");
		$backnumber=$this -> input -> get_post("backnumber");
		$tracknumberid=$this -> input -> get_post("tracknumberid");
		$orderlistid=$this -> input -> get_post("orderlistid");
		
		
		$sql="update tracknumber set tonumber='$tonumber', backnumber='$backnumber' where tracknumberid='$tracknumberid'";
		$this->db->query($sql);
		
		redirect('/order/shippinginfo/'.$orderlistid, 'refresh');
		
	}
	
	function tracknumber_bathadds(){
	
	$bo = $this -> all_model -> getSecurity(512);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}
		
		$orderlistid = $this -> input -> get_post("orderlistid");
	
		
		$arr=explode(",",$orderlistid);
		$orderlistidarr="";
		//print_r($chk) ;
		foreach($arr as $ar){

				$number = $this -> input -> get_post("number".$ar);
				$weight = $this -> input -> get_post("weight".$ar);
				$courierid = $this -> input -> get_post("courierid".$ar);
				$package = $this -> input -> get_post("package".$ar);
				$date=$this -> input -> get_post("date".$ar);		
				$sql="insert into tracknumber values (null,'$courierid','$number','$ar','$package','$weight','$date',NOW())";
				$this->db->query($sql);
			
		}
		redirect('/order/order', 'refresh');

	}
		
	
	function ipn(){

			// STEP 1: read POST data
			 
			// Reading POSTed data directly from $_POST causes serialization issues with array data in the POST.
			// Instead, read raw POST data from the input stream. 
			$raw_post_data = file_get_contents('php://input');
			$raw_post_array = explode('&', $raw_post_data);
			$myPost = array();
			foreach ($raw_post_array as $keyval) {
			  $keyval = explode ('=', $keyval);
			  if (count($keyval) == 2)
			     $myPost[$keyval[0]] = urldecode($keyval[1]);
			}
			// read the IPN message sent from PayPal and prepend 'cmd=_notify-validate'
			$req = 'cmd=_notify-validate';
			if(function_exists('get_magic_quotes_gpc')) {
			   $get_magic_quotes_exists = true;
			} 
			foreach ($myPost as $key => $value) {        
			   if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) { 
			        $value = urlencode(stripslashes($value)); 
			   } else {
			        $value = urlencode($value);
			   }
			   $req .= "&$key=$value";
			}
 
 
			// STEP 2: POST IPN data back to PayPal to validate
			 
			$ch = curl_init('https://www.paypal.com/cgi-bin/webscr');
			curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
			curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
			 
			// In wamp-like environments that do not come bundled with root authority certificates,
			// please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set 
			// the directory path of the certificate as shown below:
			// curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . '/cacert.pem');
			if( !($res = curl_exec($ch)) ) {
			    // error_log("Got " . curl_error($ch) . " when processing IPN data");
			    curl_close($ch);
			    exit;
			}
			curl_close($ch);
 
 
		// STEP 3: Inspect IPN validation result and act accordingly
 
		if (strcmp ($res, "VERIFIED") == 0) {
		   
		    $item_name = $_POST['item_name'];
		    $item_number = $_POST['item_number'];
		    $payment_status = $_POST['payment_status'];
		    $payment_amount = $_POST['mc_gross'];
		    $payment_currency = $_POST['mc_currency'];
		    $txn_id = $_POST['txn_id'];
		    $receiver_email = $_POST['receiver_email'];
		    $payer_email = $_POST['payer_email'];
			
			$sql="insert into ipn values (null,'$item_name','$item_number','$payment_status','$payment_amount','$payment_currency','$txn_id','$receiver_email','$payer_email',NOW())";
			$this->db->query($sql);
			
			if($payment_status=="Completed"){
				$sql="insert into paypaltransaction values (null,NOW(),'GMT','IPN','$payer_email','','$txn_id','$payment_status','$payment_amount','$payment_currency','','',NOW())";
				$this->db->query($sql);
                $this->all_model->GetTransactionDetails($txn_id);

                $sql="select * from  paypalTransactionDetail where TRANSACTIONID ='$txn_id'";
                $row=$this->db->query($sql)->row();
                $L_EBAYITEMTXNID0=$row->L_EBAYITEMTXNID0;

                $this->ipnRefeshOrder();

                $sql="select * from orderlist where transactionidarr in  ($L_EBAYITEMTXNID0)";
                $row=$this->db->query($sql)->row();
                $orderlistid=$row->orderlistid;
			    $this->dhlprintbyorderid($orderlistid);
			}
		 
		    // IPN message values depend upon the type of notification sent.
		    // To loop through the &_POST array and print the NV pairs to the screen:
		    foreach($_POST as $key => $value) {
		     // echo $key." = ". $value."<br>";
		    }
		} else if (strcmp ($res, "INVALID") == 0) {
		    // IPN invalid, log for manual investigation
		    echo "The response from IPN was: <b>" .$res ."</b>";
		}

	}


    function checktrans(){

       echo  $this->all_model->GetTransactionDetails("8SF18980J8685935N");
    }


    function dhlprintbyorderid($orderlistid){

        $ar = $orderlistid;

        $sql="select * from orderlist m where orderlistid ='$ar' and dhl ='1'";
        $count=$this->db->query($sql)->num_rows();
        if($count >0){

           // redirect('/order/dhl_label/'.$ar.'', 'refresh');
            return;
        }


        $sql= "select * from orderlist  where orderlistid='$ar'";
        $row=$this->db->query($sql)->row();

        $json = new stdClass();
        $json->MessageReference=$row->OrderID;
        $json->PackageType="YP";
        $date=date('Y-m-d');
        $json->Date=$date;
        $json->orderid=$ar;

        $dhlrtn=$this->dhl_model-> dhlapi(json_encode($json));
        if($dhlrtn !=""){
            echo $dhlrtn;
            return;
        }else{
            $sql="update orderlist set dhl='1' where orderlistid='".$ar."'";
            $this->db->query($sql);
              $this->dhllabelbyorderlistid($ar);
        }
        //  return;

    }


    function dhllabelbyorderlistid($orderlistid){

        $id = $orderlistid;


        $sql="select * from dhlserviceresponse where orderlistid='$id' ";

        $query=$this->db->query($sql);

        $count=$query->num_rows();
        if($count ==0){
            echo "error data";
            return;
        }

        $AWBBarCode="";
        $MessageReference="";
        foreach($query->result() as $row){
            $OutputImage=$row->OutputImage;
            $MessageReference=$row->MessageReference;

        }

        $data=  base64_decode($OutputImage);

        $dir=dirname(dirname(dirname(__FILE__)));
        // echo $dir;
        file_put_contents($dir.'/uploads/'.$MessageReference.'.pdf', $data);

        $item=base_url().'/uploads/'.$MessageReference.'.pdf';

        header('Expires: 0');

        header("location: $item");


    }


	function printaddr(){
		
		$bo = $this -> all_model -> getSecurity(512);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}
		
		$accountid = $this -> uri -> segment('3', 0);
		$orderlistid = $this -> uri -> segment('4', 0);

      //  if($accountid !="0"){
		//    $sql="select * from accounttoken where accounttokenid='$accountid'";
        //}else{
            $sql="select * from accounttoken order by  accounttokenid asc limit 1";
        //}

        $date['orderlistid']=$orderlistid;

		$row=$this->db->query($sql)->row(); 
		$date['name']=$row->name;
		$date['addr']=$row->addr;
		$date['zipcode']=$row->zipcode;
		$date['phone']=$row->phone;
		$date['country']=$row->country;
		$date['sku']='DF3D';
		$date['city']=$row->city;
		
		$sql="select r1.*,m.itemidarr,m.CreatedTime from orderlist m  left join customerlist r1 on m.BuyerUserID =r1.BuyerUserID where m.orderlistid='$orderlistid'";
	//	echo $sql;
        $row=$this->db->query($sql)->row();
		
	    $date['name2']=$row->Name;
		$date['addr2']=$row->Street1;
		$date['city2']=$row->CityName;
		$date['zipcode2']=$row->PostalCode;
		$date['phone2']=$row->Phone;
		$date['country2']=$row->Country;
		
		$itemarr=explode(',',$row->itemidarr);
		$date['count']=count($itemarr);

        $datee = $row->CreatedTime;
        $time = strtotime($datee);
       // echo $time;

        $date['orderdate']=date('Y-m-d',$time);
		$this -> load -> view('order/orderprint_view', $date);
	}


    function printaddrpdf(){

        $accountid = $this -> uri -> segment('3', 0);
        $orderlistid = $this -> uri -> segment('4', 0);

        //  if($accountid !="0"){
        //    $sql="select * from accounttoken where accounttokenid='$accountid'";
        //}else{
        $sql="select * from accounttoken order by  accounttokenid asc limit 1";
        //}

        $date['orderlistid']=$orderlistid;

        $row=$this->db->query($sql)->row();
        $name=$row->name;
        $addr=$row->addr;
        $zipcode=$row->zipcode;
        $phone=$row->phone;
        $country=$row->country;
        $sku='DF3D';
        $city=$row->city;

        $sql="select r1.*,m.itemidarr,m.CreatedTime from orderlist m  left join customerlist r1 on m.BuyerUserID =r1.BuyerUserID where m.orderlistid='$orderlistid'";
        //	echo $sql;
        $row=$this->db->query($sql)->row();

        $name2=$row->Name;
        $addr2=$row->Street1;
        $city2=$row->CityName;
        $zipcode2=$row->PostalCode;
        $phone2=$row->Phone;
        $country2=$row->Country;

        $itemarr=explode(',',$row->itemidarr);
        $count=count($itemarr);

        $datee = $row->CreatedTime;


        $time = strtotime($datee);
        // echo $time;

        $orderdate=date('Y-m-d',$time);

        $dir=dirname(dirname(dirname(__FILE__)));
        //  echo $dir;

        $sql="select * from webprofile ";
        $webprpfile=$this->db->query($sql)->row();


        require_once($dir.'/tcpdf/tcpdf.php');
        $width = $webprpfile->width;
        $height = $webprpfile->height;


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
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
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
        $pdf->SetFont('dejavusans', '', 12, '', true);

        // Add a page
        // This method has several options, check the source code documentation for more information.
        $pdf->AddPage();

        // set text shadow effect
        //$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

        // Set some content to print
        $html = <<<EOD
       <div class="">
$orderlistid-$sku  Qty:X$count $orderdate
</div>
EOD;

        // Print text using writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, $webprpfile->firstleft, $webprpfile->firsttop, $html, 0, 0, 0, true, '', true);


        // Set some content to print
        $html = <<<EOD
<div class="">
<b>From</b>:$name<br />
$addr<br />
$city<br />
$country." ,".$zipcode<br />
(TEL) $phone<br />
</div>
EOD;

        // Print text using writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, $webprpfile->secleft, $webprpfile->sectop, $html, 0, 0, 0, true, '', true);


        $html = <<<EOD
      <div class="">
<b>To</b>:$name2<br />
$addr2<br />
$city2<br />
$country2." ,".$zipcode2<br />
(TEL) $phone2<br />
</div>
EOD;

        // Print text using writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, $webprpfile->thirdleft, $webprpfile->thirdtop, $html, 0, 0, 0, true, '', true);



        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $pdf->Output($dir.'/uploads/'.$orderlistid.'.pdf', 'I');

        //============================================================+
        // END OF FILE
        //============================================================+


    }

	function printvoice(){
		
		$bo = $this -> all_model -> getSecurity(512);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}
		
		$accountid = $this -> uri -> segment('3', 0);
		$orderlistid = $this -> uri -> segment('4', 0);

        if($accountid !="0"){
            $sql="select * from accounttoken where accounttokenid='$accountid'";
        }else{
            $sql="select * from accounttoken order by  accounttokenid asc limit 1";
        }		$row=$this->db->query($sql)->row();
		$date['name']=$row->name;
		$date['addr']=$row->addr;
		$date['zipcode']=$row->zipcode;
		$date['phone']=$row->phone;
		$date['country']=$row->country;
		$date['sku']='';
		$date['city']=$row->city;
		
		$sql="select r1.*,m.orderlistid,m.Subtotal,m.Total,m.itemidarr,m.transactionidarr,m.ShippingServiceCost from orderlist m  left join customerlist r1 on m.BuyerUserID =r1.BuyerUserID where m.orderlistid='$orderlistid'";
		$row=$this->db->query($sql)->row(); 
		
		 $date['orderlistid']=$row->orderlistid;
		 $date['name2']=$row->Name;
		$date['addr2']=$row->Street1;
        $date['addr21']=$row->Street2;
		$date['city2']=$row->CityName;
		$date['zipcode2']=$row->PostalCode;
		$date['phone2']=$row->Phone;
		$date['country2']=$row->CountryName;
		$date['email']=$row->Email;

        $sql="select * from paypalTransactionDetail  where L_EBAYITEMTXNID0 in ($row->transactionidarr) and itemidarr in ($row->itemidarr)";
        $query=$this->db->query($sql);
        // echo $sql;

        foreach($query->result() as $row2){
            $date['ShippingServiceCurrency']=$row2->CURRENCYCODE;
        }
		
	

		$date['total']=$row->Total;
		$date['subtotal']=$row->Subtotal;
		$date['ShippingServiceCost']=$row->ShippingServiceCost;

		
		$itemarr=explode(',',$row->itemidarr);
		$date['count']=count($itemarr);
		
		$date['date'] = $this -> all_model -> getDate();
		
		$this -> load -> view('order/orderprintinvoice_view', $date);
	}
	
	function seller(){
		
		$bo = $this -> all_model -> getSecurity(512);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}
		
		$path = $this -> all_model -> getPathIndex();
		$date['currurl'] = $path[0];
		$date['url'] = $path[1];
		$date['menu'] = $this -> all_model -> getMenu($date['url'],512);
		$date['adminurl'] = $path[1] . "order/";
		
		$sql="select * from accounttoken ";
		$date['query']=$this->db->query($sql); 
		$this -> master2 -> view('order/seller_view', $date);
	}
	
	function seller_detail(){
			$bo = $this -> all_model -> getSecurity(512);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}
		
		$path = $this -> all_model -> getPathIndex();
		$date['currurl'] = $path[0];
		$date['url'] = $path[1];
		$date['menu'] = $this -> all_model -> getMenu($date['url'],512);
		$date['adminurl'] = $path[1] . "order/";
		
		$id = $this -> uri -> segment('3', 0);
		
		$sql="select * from accounttoken where accounttokenid='$id'  ";
		$date['row']=$this->db->query($sql)->row(); 
		
		$this -> master2 -> view('order/seller_detail_view', $date);
	}
	
	function seller_del(){
			$bo = $this -> all_model -> getSecurity(512);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}
	
		$id = $this -> uri -> segment('3', 0);
		
		$sql="delete  from accounttoken where accounttokenid='$id'  ";
		$this->db->query($sql); 
		
		redirect('welcome/as5km435#tabs-2', 'refresh');
	}
	
	
	function seller_update(){
		$bo = $this -> all_model -> getSecurity(512);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}

		$paypal= $this -> input -> get_post("paypal");
		$name=$this -> input -> get_post("name");
		$zipcode=$this -> input -> get_post("zipcode");
		$addr=$this -> input -> get_post("addr");
		$phone=$this -> input -> get_post("phone");
		$country=$this -> input -> get_post("country");
		$accounttokenid=$this -> input -> get_post("accounttokenid");
		$city=$this -> input -> get_post("city");
		
		
		$sql=" update accounttoken set city='$city' , paypal='$paypal',name='$name',addr='$addr',zipcode='$zipcode',phone='$phone',country='$country' where accounttokenid='$accounttokenid'";
	
		$this->db->query($sql);
		redirect('/order/seller_detail/'.$accounttokenid, 'refresh');
	}


    function delTokenpaypal(){

        $username = $this -> uri -> segment('3', 0);



        if($username==""){

            echo "沒有選擇<br>
		    <a href='javascript:history.back()'>back</a>";
            return;
        }

        $sql="delete from paypalaccount where paypalaccountid='".$username."'";
        $this->db->query($sql);


        redirect('/welcome/as5km435#tabs-3', 'refresh');
    }


    function   paypal_adds(){

        $path = $this -> all_model -> getPathIndex();
        $date['currurl'] = $path[0];
        $date['url'] = $path[1];
        $date['menu'] = $this -> all_model -> getMenu($date['url'],512);
        $date['adminurl'] = $path[1] . "order/";

        $edit=$this -> input -> get_post("edit");

        $paypalid= $this -> input -> get_post("paypalsel");
        $paypal= $this -> input -> get_post("paypal");
        $signature=$this -> input -> get_post("signature");
        $paypalusername=$this -> input -> get_post("paypalusername");
        $paypalpassword=$this -> input -> get_post("paypalpassword");

        if( $paypalusername==null || $paypalpassword==null){
            echo "沒有輸入資料<a href='".$date['url']."welcome/as5km435#tabs-3'>BACK</a>";
            return;

        }

        if($edit==1){
            $sql=" update paypalaccount set   signature='$signature', paypalusername='$paypalusername',  paypalpassword='$paypalpassword',   paypal='$paypal'  where paypalaccountid='$paypalid'";
            $this->db->query($sql);
            redirect('/welcome/as5km435#tabs-3', 'refresh');
        }else{

            $sql="insert into paypalaccount values (null,'$paypalusername','$paypal','$paypalpassword','$signature',NOW())";
            $query=$this->db->query($sql);
            redirect('/welcome/as5km435#tabs-3', 'refresh');

        }

    }

	function seller_adds(){
		$path = $this -> all_model -> getPathIndex();
		$date['currurl'] = $path[0];
		$date['url'] = $path[1];
		$date['menu'] = $this -> all_model -> getMenu($date['url'],512);
		$date['adminurl'] = $path[1] . "order/";
		
		$edit=$this -> input -> get_post("edit");
		
		$paypal= $this -> input -> get_post("paypal");
		$name=$this -> input -> get_post("name");
		$zipcode=$this -> input -> get_post("zipcode");
		$addr=$this -> input -> get_post("addr");
        $addr2=$this -> input -> get_post("addr2");

        $phone=$this -> input -> get_post("phone");
		$country=$this -> input -> get_post("country");
		$username=$this -> input -> get_post("username");
		$city=$this -> input -> get_post("city");
		$accounttokenid=$this -> input -> get_post("accounttokenid");
        $PersonName=$this -> input -> get_post("PersonName");
        $Currency=$this -> input -> get_post("Currency");

        $signature=$this -> input -> get_post("signature");
        $paypalusername=$this -> input -> get_post("paypalusername");
        $paypalpassword=$this -> input -> get_post("paypalpassword");



         if($paypal ==null || $name==null || $Currency ==null){
             echo "沒有輸入資料<a href='".$date['url']."welcome/as5km435#tabs-2'>BACK</a>";
             return;

         }


        if($edit==1){
				$sql=" update accounttoken set addr2='$addr2', PersonName='$PersonName',   signature='$signature', paypalusername='$paypalusername',  paypalpassword='$paypalpassword',   city='$city' , paypal='$paypal',Currency='$Currency',name='$name',addr='$addr',zipcode='$zipcode',phone='$phone',country='$country' where accounttokenid='$accounttokenid'";
			$this->db->query($sql);
			redirect('/welcome/as5km435#tabs-2', 'refresh');
		}else{
			$xml = simplexml_load_string($this -> all_model ->getsession());
			//print_r($xml);
			$sql="insert into accounttoken values (null,'','','".$xml->SessionID."','$username','$paypal','$paypalusername','$paypalpassword','$signature','$name','$PersonName','$addr','$addr2','$zipcode','$phone','$city','$country','$Currency',NOW(),NOW())";
			$query=$this->db->query($sql);
			$xml = $this -> all_model->gettoken($xml ->SessionID);
		 	print_r($xml);
		 	echo "<a href='".$date['url']."welcome/as5km435#tabs-2'>BACK</a>";
		 }
		
	}

    function orderlist_adds(){

        $path = $this -> all_model -> getPathIndex();
        $date['currurl'] = $path[0];
        $date['url'] = $path[1];
        $date['menu'] = $this -> all_model -> getMenu($date['url'],512);
        $date['adminurl'] = $path[1] . "order/";

        $buyeruserid=$this -> input -> get_post("buyeruserid");

        $sql="insert into orderlist values (null,'','','Active','0','','','','Complete',NOW(),'trans','','$buyeruserid','','','','','','','','','','','','','','',NOW())";

        $this->db->query($sql);

        $orderlistid=$this->db->insert_id();


        $date['orderlistid']=$orderlistid;
        $date['buyeruserid']=$buyeruserid;

        //$this -> master2 -> view('order/addorderlist_view', $date);
        redirect('order/addorderlist_detail/'.$orderlistid, 'refresh');

    }

    function addorderlist_detail(){

        $path = $this -> all_model -> getPathIndex();
        $date['currurl'] = $path[0];
        $date['url'] = $path[1];
        $date['menu'] = $this -> all_model -> getMenu($date['url'],512);
        $date['adminurl'] = $path[1] . "order/";

        $orderlistid = $this -> uri -> segment('3', 0);


        $sql="select * from orderlist where orderlistid='$orderlistid'";
        $row=$this->db->query($sql)->row();

        $date['orderlistid']=$orderlistid;
        $date['buyeruserid']=$row->BuyerUserID;
        $date['total']=$row->Total;
        $date['selleremail']=$row->SellerEmail;

        $date['date']=$row->CreatedTime;


        $date['shippingpaid']=$row->ShippingServiceCost;
        $date['txn']=$row->PaymentMethods;
        $date['paystatus']=$row->OrderStatus;
        $date['shipinfor']=$row->ShippingService;
        $date['buynote']=$row->BuyerCheckoutMessage;



        $shippingpaid=$this -> input -> get_post("shippingpaid");
        $txn=$this -> input -> get_post("txn");
        $paystatus=$this -> input -> get_post("paystatus");
        $shipinfor=$this -> input -> get_post("shipinfor");
        $buynote=$this -> input -> get_post("buynote");



        $sql="select count( BuyerUserID) as co from  customerlist where BuyerUserID='". $date['buyeruserid']."'";
        $co=$this->db->query($sql)->row();
        if($co->co ==0)	{
            $sql="insert into customerlist values ('','','". $date['buyeruserid']."','". $date['buyeruserid']."','','','','','','','','','','',NOW())";
            $this->db->query($sql);
        }

        $sql="select * from orderlistprod where orderlistid='$orderlistid'";

        $date['prodlist']=$this->db->query($sql);
        $date['num_rows']=$date['prodlist']->num_rows();

        if( $date['num_rows'] >0){
            $date['BuyerEmail']=$date['prodlist']->row()->BuyerEmail;
        }else{
            $date['BuyerEmail']="";
        }

         $this -> master2 -> view('order/addorderlist_view', $date);
    }


    function  addorderlist_prodadd(){
        $orderlistid=$this -> input -> get_post("orderlistid");
        $productid=$this -> input -> get_post("productid");
        $amount=$this -> input -> get_post("amount");
        $qty=$this -> input -> get_post("qty");


        $sql="select * from product where productid='$productid'";
        $row=$this->db->query($sql)->row();
        $prodtitle=$row->prodname;

        $sql=" insert into orderlistprod values (null,'$orderlistid','','','','','$prodtitle','$qty','','$amount','','','','','',NOW())";
        $this->db->query($sql);

        redirect('/order/addorderlist_detail/'.$orderlistid, 'refresh');
    }


    function  addorderlist_update(){
        $orderlistid=$this -> input -> get_post("orderlistid");
        $total=$this -> input -> get_post("total");
        $buyerpaypalemail=$this -> input -> get_post("buyerpaypalemail");
        $sellerpaypalemail=$this -> input -> get_post("sellerpaypalemail");

        $shippingpaid=$this -> input -> get_post("shippingpaid");
        $paystatus=$this -> input -> get_post("paystatus");
        $shipinfor=$this -> input -> get_post("shipinfor");
        $buynote=$this -> input -> get_post("buynote");
        $date=$this -> input -> get_post("date");
        $total2=$total+$shippingpaid;

        $sql="update orderlist set CreatedTime='$date', xml='$buyerpaypalemail',  ShippingService='$shipinfor', OrderStatus='$paystatus',Total='$total2',Subtotal='$total',ShippingServiceCost='$shippingpaid',BuyerCheckoutMessage='$buynote',SellerEmail='$sellerpaypalemail' where orderlistid='$orderlistid'";
        $this->db->query($sql);
        redirect('/order/addorderlist_detail/'.$orderlistid, 'refresh');

    }

    function checkaddorderlist(){
        $path = $this -> all_model -> getPathIndex();
        $date['currurl'] = $path[0];
        $date['url'] = $path[1];
        $date['menu'] = $this -> all_model -> getMenu($date['url'],512);
        $date['adminurl'] = $path[1] . "order/";

        $sql="select * from orderlist where OrderStatus ='Active' and OrderID=''";
        $date['query']=$this->db->query($sql);

       $this -> master2 -> view('order/checkorderlist_view', $date);
    }

    function delToken(){

        $username = $this -> uri -> segment('3', 0);
        if($username==""){

            echo "沒有選擇<br>
		    <a href='javascript:history.back()'>back</a>";
            return;
        }

        $sql="delete from accounttoken where username='".$username."'";
        $this->db->query($sql);


        redirect('/welcome/as5km435#tabs-2', 'refresh');


    }


    function bathdel(){
        $bo = $this -> all_model -> getSecurity(1024);
        if (!$bo) {
            echo "沒有權限<br>
		<a href='javascript:history.back()'>back</a>";
            return;
        }

        $orderlistid = $this -> input -> get_post("problemqueryids");
        $chk = $this -> input -> get_post("chk4");
        $arr=explode(",",$orderlistid);


        if($chk==""){
            echo "不能為空";
            return;

        }
        //print_r($chk) ;
        foreach($arr as $ar){
            foreach(@$chk as $ch){
                //echo $ch;
                if($ch==$ar){
                    $sql="update orderlist m set reserved='1' where m.orderlistid='".$ar."'";
                    $query2=$this->db->query($sql);
                }
            }
        }
        redirect('order/index#tabs-3', 'refresh');

    }

    function print_label(){
 		$orderlistid=$this -> input -> get_post("orderlistid");
 		$type=$this -> input -> get_post("type");
		$accounttokenid=$this -> input -> get_post("accounttokenid");

		//echo $type." ".$orderlistid." ".$accounttokenid ;
 		if($type=="address"){
 			redirect("order/printaddrpdf/$accounttokenid/$orderlistid");
 		}else if ($type=="dhl"){
 			redirect("order/dhl_print/$orderlistid");

 		}else if ($type=="invoice"){
 			 redirect("order/printvoice/$accounttokenid/$orderlistid");

 		}else if ($type=="ems"){
 			redirect("order/printems/$accounttokenid/$orderlistid");

 		}else if ($type=="fedex"){
 			 redirect("order/printfedex/$accounttokenid/$orderlistid");

 		}else{

            $sql="select * from printsetting where printsettingid='$type'";
            $query=$this->db->query($sql);
            $count=$query->num_rows();

            if($count ==0){
                echo "no select ";

            }else{
                redirect("order/printfunction/$accounttokenid/$orderlistid/$type");

            }



 		}

    }


    function printfunction(){

        $bo = $this -> all_model -> getSecurity(512);
        if (!$bo) {
            echo $this -> all_model -> getErr();
            return;
        }

        $accountid = $this -> uri -> segment('3', 0);
        $orderlistid = $this -> uri -> segment('4', 0);
        $type = $this -> uri -> segment('5', 0);
        $sql="select * from accounttoken order by  accounttokenid asc limit 1";
        //}


        $row=$this->db->query($sql)->row();
        $name=$row->name;
        $addr=$row->addr;
        $zipcode=$row->zipcode;
        $phone=$row->phone;
        $country=$row->country;
        $sku='';
        $city=$row->city;

        $sql="select r1.*,m.itemidarr,m.CreatedTime from orderlist m  left join customerlist r1 on m.BuyerUserID =r1.BuyerUserID where m.orderlistid='$orderlistid'";
        //	echo $sql;
        $row=$this->db->query($sql)->row();

        $name2=$row->Name;
        $addr2=$row->Street1.$row->Street2;
        $city2=$row->CityName;
        $zipcode2=$row->PostalCode;
        $phone2=$row->Phone;
        $country2=$row->CountryName;
        $state=$row->StateOrProvince;

        $itemarr=explode(',',$row->itemidarr);
        $count=count($itemarr);

        $datee = $row->CreatedTime;


        $time = strtotime($datee);
        // echo $time;

        $orderdate=date('Y-m-d',$time);


        $sql="select * from orderlistprod where orderlistid='$orderlistid' ";
        $query=$this->db->query($sql);
        foreach($query->result() as $row){
            if($sku==""){
                $sku=$row->SKU;
            }else{
                $sku.=','.$row->SKU;
            }
        }

        $dir=dirname(dirname(dirname(__FILE__)));
        //  echo $dir;

        $sql="select * from printsetting where printsettingid='$type' ";
        $setting=$this->db->query($sql)->row();


        $dir=dirname(dirname(dirname(__FILE__)));
        //  echo $dir;

        require_once($dir.'/tcpdf/tcpdf.php');
        $width = $setting->width;
        $height = $setting->height;


        $pagelayout = array($width, $height); //  or array($height, $width)


        // create new PDF document L P
        $pdf = new TCPDF($setting->ORIENTATION, PDF_UNIT, $pagelayout, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('mikeliu');
        $pdf->SetTitle('');
        $pdf->SetSubject('');
        $pdf->SetKeywords('');

        // set default header data
        $pdf->SetHeaderData();
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
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

        $size="10";
        if($setting->size!="")
            $size=$setting->size;


        $pdf->SetFont('times', '',$size , '', true);

        // Add a page
        // This method has several options, check the source code documentation for more information.
        $pdf->AddPage();

        // set text shadow effect
        //$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

        // Set some content to print
        $html = <<<EOD
      <div class="">
<b>From</b>:$name<br />
$addr<br />
$city<br />
$country , $zipcode<br />
(TEL) $phone<br />
</div>
EOD;

        // Print text using writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, $setting->sendleft, $setting->sendtop, $html, 0, 0, 0, true, '', true);


        $html = <<<EOD
         <div class="">
<b>To</b>:$name2<br />
$addr2<br />
$city2<br />
$state  $zipcode2<br />
$country2 <br />
(TEL) $phone2<br />
</div>
EOD;

        // Print text using writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, $setting->recleft, $setting->rectop, $html, 0, 0, 0, true, '', true);


        $html =$orderlistid;

        // Print text using writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, $setting->orderidleft, $setting->orderidtop, $html, 0, 0, 0, true, '', true);



        $html = date('Y',$time)-1911;


        // Print text using writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, $setting->sendyearleft, $setting->sendyeartop, $html, 0, 0, 0, true, '', true);



        $html =date('m',$time);

        // Print text using writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, $setting->sendmonthleft, $setting->sendmonthtop, $html, 0, 0, 0, true, '', true);


        $html = date('d',$time);

        // Print text using writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, $setting->senddayleft, $setting->senddaytop, $html, 0, 0, 0, true, '', true);


        $html =$sku;

        // Print text using writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, $setting->descleft, $setting->desctop, $html, 0, 0, 0, true, '', true);

        // ---------------------------------------------------------

        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $pdf->Output($dir."/uploads/$orderlistid.$type.pdf", 'I');

        //============================================================+
        // END OF FILE
        //============================================================+


    }



    function printems(){
		
		$bo = $this -> all_model -> getSecurity(512);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}
		
		$accountid = $this -> uri -> segment('3', 0);
		$orderlistid = $this -> uri -> segment('4', 0);


    $sql="select * from accounttoken order by  accounttokenid asc limit 1";
    //}


    $row=$this->db->query($sql)->row();
    $name=$row->name;
    $addr=$row->addr;
    $zipcode=$row->zipcode;
    $phone=$row->phone;
    $country=$row->country;
    $sku='';
    $city=$row->city;

    $sql="select r1.*,m.itemidarr,m.CreatedTime from orderlist m  left join customerlist r1 on m.BuyerUserID =r1.BuyerUserID where m.orderlistid='$orderlistid'";
    //	echo $sql;
    $row=$this->db->query($sql)->row();

    $name2=$row->Name;
    $addr2=$row->Street1;
    $city2=$row->CityName;
    $zipcode2=$row->PostalCode;
    $phone2=$row->Phone;
    $country2=$row->Country;

    $itemarr=explode(',',$row->itemidarr);
    $count=count($itemarr);

    $datee = $row->CreatedTime;


    $time = strtotime($datee);
    // echo $time;

    $orderdate=date('Y-m-d',$time);


    $sql="select * from orderlistprod where orderlistid='$orderlistid' ";
    $query=$this->db->query($sql);
    foreach($query->result() as $row){
        if($sku==""){
            $sku=$row->SKU;
        }else{
            $sku.=','.$row->SKU;
        }
    }

    $dir=dirname(dirname(dirname(__FILE__)));
    //  echo $dir;

    $sql="select * from printsetting where printsettingid='1' ";
    $setting=$this->db->query($sql)->row();


    $dir=dirname(dirname(dirname(__FILE__)));
    //  echo $dir;

    require_once($dir.'/tcpdf/tcpdf.php');
    $width = $setting->width;
    $height = $setting->height;


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
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
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
    $pdf->SetFont('times', '', 10, '', true);

    // Add a page
    // This method has several options, check the source code documentation for more information.
    $pdf->AddPage();

    // set text shadow effect
    //$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

    // Set some content to print
    $html = <<<EOD
      <div class="">
<b>From</b>:$name<br />
$addr<br />
$city<br />
$country." ,".$zipcode<br />
(TEL) $phone<br />
</div>
EOD;

    // Print text using writeHTMLCell()
    $pdf->writeHTMLCell(0, 0, $setting->sendleft, $setting->sendtop, $html, 0, 0, 0, true, '', true);


    $html = <<<EOD
         <div class="">
<b>To</b>:$name2<br />
$addr2<br />
$city2<br />
$country2." ,".$zipcode2<br />
(TEL) $phone2<br />
</div>
EOD;

    // Print text using writeHTMLCell()
    $pdf->writeHTMLCell(0, 0, $setting->recleft, $setting->rectop, $html, 0, 0, 0, true, '', true);


    $html = <<<EOD
        $orderlistid
EOD;

    // Print text using writeHTMLCell()
    $pdf->writeHTMLCell(0, 0, $setting->orderidleft, $setting->orderidtop, $html, 0, 0, 0, true, '', true);



    $html = date('Y',$time)-1911;


    // Print text using writeHTMLCell()
    $pdf->writeHTMLCell(0, 0, $setting->sendyearleft, $setting->sendyeartop, $html, 0, 0, 0, true, '', true);



    $html =date('m',$time);

    // Print text using writeHTMLCell()
    $pdf->writeHTMLCell(0, 0, $setting->sendmonthleft, $setting->sendmonthtop, $html, 0, 0, 0, true, '', true);


    $html = date('d',$time);

    // Print text using writeHTMLCell()
    $pdf->writeHTMLCell(0, 0, $setting->senddayleft, $setting->senddaytop, $html, 0, 0, 0, true, '', true);


    $html =$sku;

    // Print text using writeHTMLCell()
    $pdf->writeHTMLCell(0, 0, $setting->descleft, $setting->desctop, $html, 0, 0, 0, true, '', true);

    // ---------------------------------------------------------

    // Close and output PDF document
    // This method has several options, check the source code documentation for more information.
    $pdf->Output($dir.'/uploads/example_001.pdf', 'I');

    //============================================================+
    // END OF FILE
    //============================================================+


	}


function printfedex(){
		
		$bo = $this -> all_model -> getSecurity(512);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}
		
		$accountid = $this -> uri -> segment('3', 0);
		$orderlistid = $this -> uri -> segment('4', 0);

      //  if($accountid !="0"){
		//    $sql="select * from accounttoken where accounttokenid='$accountid'";
        //}else{
            $sql="select * from accounttoken order by  accounttokenid asc limit 1";
        //}

        $date['orderlistid']=$orderlistid;

		$row=$this->db->query($sql)->row(); 
		 $date['name']=$row->name;
		$date['addr']=$row->addr;
		$date['zipcode']=$row->zipcode;
		$date['phone']=$row->phone;
		$date['country']=$row->country;
		$date['sku']='DF3D';
		$date['city']=$row->city;
		
		$sql="select r1.*,m.itemidarr from orderlist m  left join customerlist r1 on m.BuyerUserID =r1.BuyerUserID where m.orderlistid='$orderlistid'";
		$row=$this->db->query($sql)->row(); 
		
		 $date['name2']=$row->Name;
		$date['addr2']=$row->Street1;
		$date['city2']=$row->CityName;
		$date['zipcode2']=$row->PostalCode;
		$date['phone2']=$row->Phone;
		$date['country2']=$row->Country;
		
		$itemarr=explode(',',$row->itemidarr);
		$date['count']=count($itemarr);
		
		$date['date'] = $this -> all_model -> getDate();
		
		$this -> load -> view('order/orderprint_view', $date);
	}
	


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
