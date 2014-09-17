<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Purchase extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/purchase/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/purchase/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index() {

		$bo = $this -> all_model -> getSecurity(16);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}

        $this -> session -> set_userdata('menuid',12);

        $path = $this -> all_model -> getPathIndex();
		$date['currurl'] = $path[0];
		$date['url'] = $path[1];
		$date['menu'] = $this -> all_model -> getMenu($date['url'],16);
		
		$date['adminurl'] = $path[1] . "purchase/";



        $type = $this -> uri -> segment('3', 0);
		
		if ($type != "") {
			$sql="SELECT m.*,r1.sku,r1.brand,r1.prodname,r1.model,r2.companyname,r3.category FROM `purchase` m ";
			$sql.="   left join product r1 on m.productid=r1.productid left join company r2 on m.companyid=r2.companyid ";
			$sql.="  left join category r3 on r1.categoryid=r3.categoryid  WHERE m.purchasetype =  '$type'";
			
			//echo $sql;
			$date['query'] = $this -> db -> query($sql);
		
			$query = $this -> db -> query($sql);
			$string="";
			foreach($query->result() as $row){
				if($string==""){
					$string=$row->purchaseid;
				}else{
					$string.=",".$row->purchaseid;
				}
			}
			
			$date['purchaseid']=$string;


			$date['type']=$type;
			if ($type == "1") {
				$this -> master2 -> view('purchase/preorder_view', $date);
			} else if ($type == "2") {
				$this -> master2 -> view('purchase/order_view', $date);
			} else if ($type == "3") {
				$this -> master2 -> view('purchase/purinvent_view', $date);
			} else if ($type == "4") {
				
                $sql="SELECT m.*,r1.sku,r1.brand,r1.prodname,r1.model,r2.companyname,r3.category FROM `purchase` m ";
                $sql.="   left join product r1 on m.productid=r1.productid left join company r2 on m.companyid=r2.companyid ";
                $sql.="  left join category r3 on r1.categoryid=r3.categoryid  WHERE m.purchasetype !=  '1' and m.purchasetype !=  '2' and m.purchasetype !=  '3' and r1.prodname!=''";

                //echo $sql;
                $date['query'] = $this -> db -> query($sql);

                $query = $this -> db -> query($sql);
                $string="";
                foreach($query->result() as $row){
                    if($string==""){
                        $string=$row->purchaseid;
                    }else{
                        $string.=",".$row->purchaseid;
                    }
                }
                    $date['purchaseid']=$string;
                    $this -> master2 -> view('purchase/historypur_view', $date);
			}

		}else {
			
			$date['productid']="";
			$date['amount']="";
			$date['pdate']="";
			$date['prodname']="";
			$date['sku']="";
			
			$sql="select m.*,r1.prodname,r1.sku,r1.prodname,r1.brand,r1.model,r3.category  from purchase m  left join product r1 on m.productid=r1.productid left join category r3 on r1.categoryid=r3.categoryid  where m.purchasetype='999'";
			$date['querylist']=$this->db->query($sql);
			
			
			$string="";
			foreach($date['querylist']->result() as $row){
				if($string==""){
					$string=$row->purchaseid;
				}else{
					$string.=",".$row->purchaseid;
				}
			}
				$date['purchaseid']=$string;
			
			
			$date['has']=$this->db->query($sql)->num_rows();



            //////
            $sql="SELECT m.*,r1.sku,r1.brand,r1.prodname,r1.model,r2.companyname,r3.category FROM `purchase` m ";
            $sql.="   left join product r1 on m.productid=r1.productid left join company r2 on m.companyid=r2.companyid ";
            $sql.="  left join category r3 on r1.categoryid=r3.categoryid  WHERE m.purchasetype =  '1'";
            //echo $sql;
            $date['query1'] = $this -> db -> query($sql);
            $query = $this -> db -> query($sql);
            $string="";
            foreach($query->result() as $row){
                if($string==""){
                    $string=$row->purchaseid;
                }else{
                    $string.=",".$row->purchaseid;
                }
            }

            $date['purchaseid1']=$string;


            $sql="SELECT m.*,r1.sku,r1.brand,r1.prodname,r1.model,r2.companyname,r3.category FROM `purchase` m ";
            $sql.="   left join product r1 on m.productid=r1.productid left join company r2 on m.companyid=r2.companyid ";
            $sql.="  left join category r3 on r1.categoryid=r3.categoryid  WHERE m.purchasetype =  '2'";
            //echo $sql;
            $date['query22'] = $this -> db -> query($sql);
            $query = $this -> db -> query($sql);
            $string="";
            foreach($query->result() as $row){
                if($string==""){
                    $string=$row->purchaseid;
                }else{
                    $string.=",".$row->purchaseid;
                }
            }

            $date['purchaseid2']=$string;

            flush();

            $sql="SELECT m.*,r1.sku,r1.brand,r1.prodname,r1.model,r2.companyname,r3.category FROM `purchase` m ";
            $sql.="   left join product r1 on m.productid=r1.productid left join company r2 on m.companyid=r2.companyid ";
            $sql.="  left join category r3 on r1.categoryid=r3.categoryid  WHERE m.purchasetype !=  '1' and m.purchasetype !=  '2' and m.purchasetype !=  '3' and r1.prodname!=''";
            $sql.="  and m.purchasetype !='999'  ";
           // echo $sql;
            $date['query4'] = $this -> db -> query($sql);

            $query = $this -> db -> query($sql);
            $string="";
            foreach($query->result() as $row){
                if($string==""){
                    $string=$row->purchaseid;
                }else{
                    $string.=",".$row->purchaseid;
                }
            }
            $date['purchaseid4']=$string;



            //////



            $this -> master2 -> view('purchase/purchase_view', $date);
		}
	}

    function oldlist(){


        $bo = $this -> all_model -> getSecurity(16);
        if (!$bo) {
            echo $this -> all_model -> getErr();
            return;
        }

        $path = $this -> all_model -> getPathIndex();
        $date['currurl'] = $path[0];
        $date['url'] = $path[1];
        $date['menu'] = $this -> all_model -> getMenu($date['url'],16);
        $date['adminurl'] = $path[1] . "purchase/";
        $date['pdate'] =date('Y-m-d');

        $sql="SELECT m.*,r1.sku,r1.brand,r1.prodname,r1.model,r2.companyname,r3.category FROM `purchase` m ";
        $sql.="   left join product r1 on m.productid=r1.productid left join company r2 on m.companyid=r2.companyid ";
        $sql.="  left join category r3 on r1.categoryid=r3.categoryid  WHERE m.purchasetype !=  '1' and m.purchasetype !=  '2' and m.purchasetype !=  '3' and r1.prodname!=''";
        $sql.="  and m.purchasetype !='999' limit 2000 ";
        // echo $sql;
        $date['query4'] = $this -> db -> query($sql);

        $query = $this -> db -> query($sql);
        $string="";
        foreach($query->result() as $row){
            if($string==""){
                $string=$row->purchaseid;
            }else{
                $string.=",".$row->purchaseid;
            }
        }
        $date['purchaseid4']=$string;



        //////



        $this -> load -> view('purchase/purchase_oldlist_view', $date);

    }

	function detail(){
		
		
		$bo = $this -> all_model -> getSecurity(16);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}

		$path = $this -> all_model -> getPathIndex();
		$date['currurl'] = $path[0];
		$date['url'] = $path[1];
		$date['menu'] = $this -> all_model -> getMenu($date['url'],16);
		$date['adminurl'] = $path[1] . "purchase/";
		$date['pdate'] =date('Y-m-d');

		
			$sql="SELECT m.*,r1.sku,r1.brand,r1.prodname,r1.model,r2.companyname,r3.category FROM `purchase` m ";
			$sql.="   left join product r1 on m.productid=r1.productid left join company r2 on m.companyid=r2.companyid ";
			$sql.="  left join category r3 on r1.categoryid=r3.categoryid  WHERE m.purchasetype =  '1'";
			//echo $sql;
			$date['query1'] = $this -> db -> query($sql);
			$query = $this -> db -> query($sql);
			$string="";
			foreach($query->result() as $row){
				if($string==""){
					$string=$row->purchaseid;
				}else{
					$string.=",".$row->purchaseid;
				}
			}
			
			$date['purchaseid1']=$string;
			
			
			$sql="SELECT m.*,r1.sku,r1.brand,r1.prodname,r1.model,r2.companyname,r3.category FROM `purchase` m ";
			$sql.="   left join product r1 on m.productid=r1.productid left join company r2 on m.companyid=r2.companyid ";
			$sql.="  left join category r3 on r1.categoryid=r3.categoryid  WHERE m.purchasetype =  '2'";
			//echo $sql;
			$date['query2'] = $this -> db -> query($sql);
			$query = $this -> db -> query($sql);
			$string="";
			foreach($query->result() as $row){
				if($string==""){
					$string=$row->purchaseid;
				}else{
					$string.=",".$row->purchaseid;
				}
			}
			
			$date['purchaseid2']=$string;
			
			
			$sql="SELECT m.*,r1.sku,r1.brand,r1.prodname,r1.model,r2.companyname,r3.category FROM `purchase` m ";
			$sql.="   left join product r1 on m.productid=r1.productid left join company r2 on m.companyid=r2.companyid ";
			$sql.="  left join category r3 on r1.categoryid=r3.categoryid  WHERE m.purchasetype !=  '1' and m.purchasetype !=  '2' and m.purchasetype !=  '3' and r1.prodname!=''";
			$sql.="  and m.purchasetype !='999'  ";
			//echo $sql;
			$date['query4'] = $this -> db -> query($sql);
		
			$query = $this -> db -> query($sql);
			$string="";
			foreach($query->result() as $row){
				if($string==""){
					$string=$row->purchaseid;
				}else{
					$string.=",".$row->purchaseid;
				}
			}
			$date['purchaseid4']=$string;
			
		
		$this -> master2 -> view('purchase/tabs_view', $date);
	}
	
	
	function purchaseaddbath(){
		
			$bo = $this -> all_model -> getSecurity(16);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}
		
		$companylist="";
		
		$purchaseid = $this -> input -> get_post("purchaseid");
		$modtype = $this -> input -> get_post("modtype");
		
		$chk = $this -> input -> get_post("chk");
		$arr=explode(",",$purchaseid);

		foreach($arr as $ar){
			foreach(@$chk as $ch){
			if($ch==$ar){
				$sql="";
				if($modtype==1){
					
					$sql="update purchase set `purchasetype`= '1'  where purchaseid='".$ar."'";
					$query=$this->db->query($sql);
					//	echo $sql;
					
				}else{
					
					$sql="delete from  purchase where purchaseid='".$ar."'";
					$this->db->query($sql);
					//echo $sql;
						
				}
			}
			}
		}

			redirect(base_url() . "index.php/purchase", 'refresh');
			

	}
	

	function order_detail_back(){
			
		$bo = $this -> all_model -> getSecurity(16);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}
		
		
		$purchaseid = $this -> input -> get_post("purchaseid");
		$paytype = $this -> input -> get_post('paytype');
		$alpay = $this -> input -> get_post('alpay');
		$no = $this -> input -> get_post('no');
		$price = $this -> input -> get_post('price');
        $pdate = $this -> input -> get_post('pdate');
		$amount = $this -> input -> get_post('amount');
		$data = array('pdate' => $pdate,'alpay' => $alpay, 'no' => $no, 'paytype' => $paytype, 'price' => $price, 'purchasetype' => '5');

		$this -> db -> where('purchaseid', $purchaseid);
		$this -> db -> update('purchase', $data);
		
		$query=$this->db->query("select * from purchase where purchaseid='".$purchaseid."'");
			$productid="";
			$amount="";
			$price="";
			
		foreach($query->result() as $row){
			$productid=$row->productid;
			$amount=$row->amount;
			$price=$row->price;
			
		}
		
		$sql="insert into inventory values (null,'1',".$purchaseid.",NOW())";
		$this -> db -> query($sql);
					
				
		redirect(base_url() . "index.php/purchase/detail", 'refresh');
		
	}

	function orderbathupdate(){
		
		$bo = $this -> all_model -> getSecurity(16);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}
		
		$companyid = $this -> input -> get_post("companyid");
		$purchaseid = $this -> input -> get_post("purchaseid");
		$type = $this -> input -> get_post("type");
		$id = $this -> input -> get_post('id');
		$paytype = $this -> input -> get_post('paytype');
		$alpay = $this -> input -> get_post('alpay');			
		$no = $this -> input -> get_post('no');		
		$price = $this -> input -> get_post('price');
		$amount = $this -> input -> get_post('amount');
		$sku = $this -> input -> get_post('sku');			
		$pdate = $this -> input -> get_post('pdate');
		
		$chk1 = $this -> input -> get_post("chk1");
		$chk2 = $this -> input -> get_post("chk2");
		$chk3 = $this -> input -> get_post("chk3");
		$set="";
			
		$arr=explode(",",$purchaseid);
		//print_r($chk) ;
		foreach($arr as $ar){
		//	echo $ar."<br>";
			
			//echo $chk;
			if($type!="4"){
				if ( $pdate==null) {
						//echo "日期不能空白<br>
					//<a href='javascript:history.back()'>back</a>";
				//return;
				}
			}
			$set2="";
			if($type=="1"){
				if ($companyid == null ) {
						echo "公司不能空白<br>
					<a href='javascript:history.back()'>back</a>";
				return;
				}
				
				$amount = $this -> input -> get_post('amount'.$ar);
				//$data = array('amount'=>$amount,'pdate' => $pdate,'companyid' => $companyid,  'purchasetype' => '2');
				
				$set=" amount ='".$amount."',  pdate='".$pdate."',companyid='".$companyid."' ,purchasetype='2' "; 

			}else if($type=="2"){
				if ($no == null ) {
						//echo "發票不能空白<br><a href='javascript:history.back()'>back</a>";
				//return;
				}
					$pdate = $this -> input -> get_post('pdate'.$ar);
					$alpay = $this -> input -> get_post('alpay'.$ar);
					$no = $this -> input -> get_post('no'.$ar);
					$paytype = $this -> input -> get_post('paytype'.$ar);
					$amount = $this -> input -> get_post('amount'.$ar);
					$price = $this -> input -> get_post('price'.$ar);
				
				
					$set2=" alpay ='".$alpay."', `amount` ='".$amount."',`no` ='".$no."', paytype ='".$paytype."',price ='".$price."', pdate='".$pdate."'  ,purchasetype='5' "; 
					$set=" alpay ='".$alpay."', `amount` ='".$amount."',`no` ='".$no."', paytype ='".$paytype."',price ='".$price."', pdate='".$pdate."' ,purchasetype='5' "; 
					
			}else if($type=="3"){
				
					$set=" alpay ='".$alpay."', `no` ='".$no."', paytype ='".$paytype."',price ='".$price."', pdate='".$pdate."' ,purchasetype='5' "; 
			}else if($type=="4"){
					$alpay = $this -> input -> get_post('alpay'.$ar);
					$no = $this -> input -> get_post('no'.$ar);
					$paytype = $this -> input -> get_post('paytype'.$ar);
					$amount = $this -> input -> get_post('amount'.$ar);
					$price = $this -> input -> get_post('price'.$ar);
			
				$set=" amount ='".$amount."',alpay ='".$alpay."', `no` ='".$no."', paytype ='".$paytype."',price ='".$price."', pdate='".$pdate."' ,purchasetype='5' "; 
				//echo $set;
			}
			
			if($type=="1"){
				$chk=$chk1;
			}else if($type=="2"){
				$chk=$chk2;
				
			}else if($type=="4"){
				$chk=$chk3;
				
			}
			
			
			foreach(@$chk as $ch){
				//echo $ch;
			if($ch==$ar){

                $productid="";
                //$amount="";
                $sql2="select * from purchase where purchaseid=$ar";
                $query2=$this->db->query($sql2);

                foreach($query2->result() as $row){
                    $productid=$row->productid;
                    //$amount=$row->amount;
                }

				if($type=="2"){

					$sql="select productid as co from inventorylist where productid='".$productid."' and price='".$price."' ";
		
					$query = $this -> db -> query($sql);
					if ($query -> num_rows() > 0) {
						
						$sql="update inventorylist set amount=amount+".$amount." where productid='".$productid."' and price='".$price."'";
						$query = $this -> db -> query($sql);
	
					}else{
									
						$sql="insert into inventorylist values(null,NOW(),'".$productid."','0','".$price."','".$amount."',NOW())";
						$this->db->query($sql);
						
					}
						$sql="update purchase set ".$set." where purchaseid ='".$ar."'";
						$this->db->query($sql);

                    $sql="update product set Quantity=Quantity+".$amount." where productid='".$productid."' ";
                    $query = $this -> db -> query($sql);

				
				}else if($type==4){

                    $sql="select * from purchase where purchaseid='".$ar."' ";
                    $row = $this -> db -> query($sql)->row();
                   $oldamount= $row->amount;
                    $orgprice=$row->price;
                    $productid=$row->productid;


                    $sql="update product set Quantity=Quantity+".$amount."-".$oldamount." where productid='".$productid."' ";
                    $query = $this -> db -> query($sql);

                    $sql="update purchase set ".$set." where purchaseid ='".$ar."'";
                    //echo $sql;
                    $this->db->query($sql);

                    ////



                    $amount = $this -> input -> get_post('amount'.$ar);
                    $price = $this -> input -> get_post('price'.$ar);

                    $sql="update inventorylist set price='".$price."' ,amount ='".$amount."' where productid='".$productid."' and price='".$orgprice."' and amount='".$oldamount."'";
                    $this->db->query($sql);

                   // echo $sql;


                }else{

                        $sql="update purchase set ".$set." where purchaseid ='".$ar."'";
                        //echo $sql;
                        $this->db->query($sql);

                    }
                }
			}
		}
	
		redirect('/account/invoicelist', 'refresh');
		//redirect('/purchase/purchase/' . $type, 'refresh');
	}
	
	function purchase_del() {
		
		$bo = $this -> all_model -> getSecurity(16);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}

		$id = $this -> uri -> segment('3', 0);
		$type = $this -> uri -> segment('4', 0);
		$this -> db -> query("delete from purchase  where purchaseid='" . $id . "'");
		redirect(base_url() . "index.php/purchase/purchase", 'refresh');
	}
	



	function purchase_adds() {
		
		$bo = $this -> all_model -> getSecurity(16);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}

		for($i=1;$i<4;$i++){

		$amount = $this -> input -> get_post('amount'.$i);
		$pdate = $this -> input -> get_post('pdate'.$i);
		$productid = $this -> input -> get_post('productid'.$i);
		$purchasetype = $this -> input -> get_post('purchasetype'.$i);
		
		$sure = $this -> input -> get_post('sure');
		

		if ($pdate == null | $amount == null  | $productid==null) {
			//echo "不能空白<br><a href='javascript:history.back()'>back</a>";
			//return;
		}else{
			
			if($sure=="1"){
				
				$sql="select purchaseid from purchase where purchasetype='999'";
			$query=$this->db->query($sql)->row();
			
			if($query->purchaseid!=""){
			
				$sql="update purchase set `productid` = '$productid', `purchasetype`= '1',   `amount` = '$amount', `pdate` = '$pdate'  where purchaseid='".$query->purchaseid."'";
				$query=$this->db->query($sql);
			}
				
				
			}else{
			
			
		/*	$sql="select purchaseid from purchase where purchasetype='999'";
			$num=$this->db->query($sql)->num_rows();
			$query=$this->db->query($sql)->row();
			
			if($num){
			
				$sql="update purchase set `productid` = '$productid', `purchasetype`= '$purchasetype',   `amount` = '$amount', `pdate` = '$pdate'  where purchaseid='".$query->purchaseid."'";
				$query=$this->db->query($sql);
			}else{
				$data = array('productid' => $productid, 'purchasetype' => $purchasetype,   'amount' => $amount, 'pdate' => $pdate);
				$this -> db -> insert('purchase', $data);
			}*/
			
			$data = array('productid' => $productid, 'purchasetype' => $purchasetype,   'amount' => $amount, 'pdate' => $pdate);
				$this -> db -> insert('purchase', $data);
			
			}
			
			
				
		}

		}
		
		redirect(base_url() . "index.php/purchase", 'refresh');

	}
	
	function preorder_detail() {

		$bo = $this -> all_model -> getSecurity(16);
		if (!$bo) {
			echo "沒有權限<br>
		<a href='javascript:history.back()'>back</a>";
			return;
		}

		$date['id'] = $this -> uri -> segment('3', 0);
		$path = $this -> all_model -> getPathIndex();
		$date['currurl'] = $path[0];
		$date['url'] = $path[1];
		$date['adminurl'] = $path[1] . "purchase/";
		$date['row'] = $this -> db -> query("select m.*,r2.sku,r1.companyname from purchase m left join company r1 on m.companyid=r1.companyid left join product r2 on m.productid=r2.productid where m.purchaseid ='".$date['id']."'") -> row();

		$this -> master2 -> view('purchase/preorder_detail_view', $date);

	}

	function preorder_detail_update() {

		$bo = $this -> all_model -> getSecurity(16);
		if (!$bo) {
			echo "沒有權限<br>
		<a href='javascript:history.back()'>back</a>";
			return;
		}

		$id = $this -> input -> get_post('id');

		$companyid = $this -> input -> get_post('companyid');
		$paytype = $this -> input -> get_post('paytype');
		$pdate = $this -> input -> get_post('pdate');
		$alpay = $this -> input -> get_post('alpay');
		//$no = $this -> input -> get_post('no');

		if ($paytype == null | $alpay == null) {
			echo "不能空白<br>
		<a href='javascript:history.back()'>back</a>";
			return;
		}

		$data = array('pdate' => $pdate,'alpay' => $alpay,'companyid' => $companyid, 'paytype' => $paytype, 'purchasetype' => '2');

		$this -> db -> where('purchaseid', $id);
		$this -> db -> update('purchase', $data);

		redirect(base_url() . "index.php/purchase/detail", 'refresh');

	}

	function order_detail() {

		$bo = $this -> all_model -> getSecurity(16);
		if (!$bo) {
			echo "沒有權限<br>
		<a href='javascript:history.back()'>back</a>";
			return;
		}

		$date['id'] = $this -> uri -> segment('3', 0);
		$path = $this -> all_model -> getPathIndex();
		$date['currurl'] = $path[0];
		$date['url'] = $path[1];
		$date['adminurl'] = $path[1] . "purchase/";
		$date['row'] = $this -> db -> query("select m.*,r2.sku,r1.companyname from purchase m left join company r1 on m.companyid=r1.companyid left join product r2 on m.productid=r2.productid where m.purchaseid ='".$date['id']."'") -> row();

		$this -> master2 -> view('purchase/order_detail_view', $date);

	}

	function order_detail_update() {

		$bo = $this -> all_model -> getSecurity(16);
		if (!$bo) {
			echo "沒有權限<br>
		<a href='javascript:history.back()'>back</a>";
			return;
		}
		$id = $this -> input -> get_post('id');
		$paytype = $this -> input -> get_post('paytype');
		$alpay = $this -> input -> get_post('alpay');
		$pdate = $this -> input -> get_post('pdate');
		$no = $this -> input -> get_post('no');
		$price = $this -> input -> get_post('price');

		$productid = $this -> input -> get_post('productid');
		$amount = $this -> input -> get_post('amount');
		if ($paytype == null | $alpay == null) {
			echo "不能空白<br>
		<a href='javascript:history.back()'>back</a>";
			return;
		}

		$data = array('pdate' => $pdate,'alpay' => $alpay, 'no' => $no, 'paytype' => $paytype, 'price' => $price, 'purchasetype' => '5');

		$this -> db -> where('purchaseid', $id);
		$this -> db -> update('purchase', $data);
		
		
		$sql2="select * from purchase where purchaseid=$id";
				$query2=$this->db->query($sql2);
				$productid="";
				foreach($query2->result() as $row){
					$productid=$row->productid;
				}
				
				$sql="insert into inventorylist values (null,".$id.",NOW(),'".$productid."','0')";
				$this -> db -> query($sql);

		redirect(base_url() . "index.php/purchase/detail", 'refresh');

	}


	function order_detail_mod(){
		$bo = $this -> all_model -> getSecurity(16);
		if (!$bo) {
			echo "沒有權限<br>
		<a href='javascript:history.back()'>back</a>";
			return;
		}
		$id = $this -> input -> get_post('id');
		$companyid = $this -> input -> get_post('companyid');
		$productid = $this -> input -> get_post('productid');
		$amount = $this -> input -> get_post('amount');
		

		$data = array('companyid' => $companyid,'productid' => $productid, 'amount' => $amount);

		$this -> db -> where('purchaseid', $id);
		$this -> db -> update('purchase', $data);
		
	
		redirect(base_url() . "index.php/purchase/order_detail/".$id, 'refresh');	
		
	}


	function preorder_detail_mod(){
		$bo = $this -> all_model -> getSecurity(16);
		if (!$bo) {
			echo "沒有權限<br>
		<a href='javascript:history.back()'>back</a>";
			return;
		}
		$id = $this -> input -> get_post('id');
		
		$productid = $this -> input -> get_post('productid');
		$amount = $this -> input -> get_post('amount');
		

		$data = array('productid' => $productid, 'amount' => $amount);

		$this -> db -> where('purchaseid', $id);
		$this -> db -> update('purchase', $data);
		
	
		redirect(base_url() . "index.php/purchase/preorder_detail/".$id, 'refresh');	
		
	}
	
	function purinvent_detail() {

		$bo = $this -> all_model -> getSecurity(16);
		if (!$bo) {
			echo "沒有權限<br>
		<a href='javascript:history.back()'>back</a>";
			return;
		}

		$date['id'] = $this -> uri -> segment('3', 0);
		$path = $this -> all_model -> getPathIndex();
		$date['currurl'] = $path[0];
		$date['url'] = $path[1];
		$date['adminurl'] = $path[1] . "purchase/";
		$date['row'] = $this -> db -> query("select m.*,r1.companyname from purchase m left join company r1 on m.companyid=r1.companyid where m.purchaseid ='".$date['id']."'") -> row();

		$this -> master2 -> view('purchase/purinvent_detail_view', $date);

	}

	function purinvent_detail_update() {

		$bo = $this -> all_model -> getSecurity(16);
		if (!$bo) {
			echo "沒有權限<br>
		<a href='javascript:history.back()'>back</a>";
			return;
		}
		$id = $this -> input -> get_post('id');
		$paytype = $this -> input -> get_post('paytype');
		$alpay = $this -> input -> get_post('alpay');
		$no = $this -> input -> get_post('no');
		$price = $this -> input -> get_post('price');
		$amount = $this -> input -> get_post('amount');
		$productid = $this -> input -> get_post('productid');
		$sku = $this -> input -> get_post('sku');
		$pdate = $this -> input -> get_post('pdate');

		if ($paytype == null | $alpay == null) {
			echo "不能空白<br>
		<a href='javascript:history.back()'>back</a>";
			return;
		}

		$data = array('pdate' => $pdate,'alpay' => $alpay, 'no' => $no, 'paytype' => $paytype, 'price' => $price, 'purchasetype' => '5');

		$this -> db -> where('purchaseid', $id);
		$this -> db -> update('purchase', $data);

		$data = array('productid' => $productid, 'sku' => $sku, 'amount' => $amount, 'price' => $price);

		$this -> db -> insert('inventory', $data);

		redirect(base_url() . "index.php/purchase/detail", 'refresh');

	}

	function historyorderbath(){
		
		$bo = $this -> all_model -> getSecurity(16);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}
		
		$companyid = $this -> input -> get_post("companyid");
		$purchaseid = $this -> input -> get_post("purchaseid");
		$type = $this -> input -> get_post("type");
		$id = $this -> input -> get_post('id');
		$paytype = $this -> input -> get_post('paytype');
		$alpay = $this -> input -> get_post('alpay');			
		$no = $this -> input -> get_post('no');		
		$price = $this -> input -> get_post('price');
		$amount = $this -> input -> get_post('amount');
		$sku = $this -> input -> get_post('sku');			
		$pdate = $this -> input -> get_post('pdate');
		$chk = $this -> input -> get_post("chk3");
		$modtype = $this -> input -> get_post("modtype");
		$set="";
		
		
	
			
		$companylist="";
		$arr=explode(",",$purchaseid);
		//print_r($chk) ;
		foreach($arr as $ar){
		
	
			foreach(@$chk as $ch){
				//echo $ch;
			if($ch==$ar){
			
				if($modtype==1){
					if($companylist==""){
						$companylist=$ar;
					}else{
						$companylist.=",".$ar;
					}
				}else{
					
					$sql="delete from  purchase where purchaseid='".$ar."'";
					$this->db->query($sql);
						
				}
			
			}
			}
		}
	
		if($modtype==2){
			redirect('/purchase/detail', 'refresh');			
			return;
		}
	
		$date['pdate'] =date('Y-m-d');
	
		$path = $this -> all_model -> getPathIndex();
		$date['currurl'] = $path[0];
		$date['url'] = $path[1];
		$date['menu'] = $this -> all_model -> getMenu($date['url'],16);
		$date['adminurl'] = $path[1] . "purchase/";
		
			$sql="SELECT m.*,r1.sku,r1.brand,r1.prodname,r1.model,r2.companyname,r3.category FROM `purchase` m ";
			$sql.="   left join product r1 on m.productid=r1.productid left join company r2 on m.companyid=r2.companyid ";
			$sql.="  left join category r3 on r1.categoryid=r3.categoryid  WHERE m.purchasetype !=  '1' and m.purchasetype !=  '2' and m.purchasetype !=  '3' and r1.prodname!='' and m.purchaseid in (".$companylist.")";
			
			//echo $sql;
			$date['query4'] = $this -> db -> query($sql);
		
			$query = $this -> db -> query($sql);
			$string="";
			foreach($query->result() as $row){
				if($string==""){
					$string=$row->purchaseid;
				}else{
					$string.=",".$row->purchaseid;
				}
			}
			$date['purchaseid4']=$string;
			
		
		$this -> master2 -> view('purchase/tabsbath_view', $date);
		
	}




}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
