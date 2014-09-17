<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Account extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/account/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/account/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index() {

		$bo = $this -> all_model -> getSecurity(64);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}

		$path = $this -> all_model -> getPathIndex();
		$date['currurl'] = $path[0];
		$date['url'] = $path[1];
		$date['menu'] = $this -> all_model -> getMenu($date['url'],64);
		
		$date['adminurl'] = $path[1] . "account/";
		
		
		$pdates = $this -> input -> get_post('pdates');
		$pdatee = $this -> input -> get_post('pdatee');
		
		$date['pdates']="";
				$date['pdatee']="";
		if($pdates!="" && $pdatee !=""){
			$sql="select m.*,r1.name as accountname,r2.companyname from invoice m left join accounttype r1 on r1.accounttypeid=m.accounttypeid left join company r2 on r2.companyid =m.companyid where pdate between  '$pdates' and '$pdatee'";
			$date['pdates']=$pdates;
				$date['pdatee']=$pdatee;
		}else{
			$sql='select m.*,r1.name as accountname,r2.companyname from invoice m left join accounttype r1 on r1.accounttypeid=m.accounttypeid left join company r2 on r2.companyid =m.companyid';
		
		}

		$date['query'] = $this -> db -> query($sql);

			$query = $this -> db -> query($sql);
			$string="";
			foreach($query->result() as $row){
				if($string==""){
					$string=$row->invoiceid;
				}else{
					$string.=",".$row->invoiceid;
				}
			}
			
			$date['invoiceid']=$string;
			
			
		$date['query1'] = $this -> db -> query("select * from accounttype ");
		$date['query2'] = $this -> db -> query("select * from accounttype where type='1'");
		$date['query3'] = $this -> db -> query("select * from accounttype where type='2'");
		$date['query4'] = $this -> db -> query("select * from accounttype where type='3'");

		$this -> master2 -> view('account/account_view', $date);
	}
	
	function invoicelist(){
		
		$bo = $this -> all_model -> getSecurity(64);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}

        $this -> session -> set_userdata('menuid',41);


        $path = $this -> all_model -> getPathIndex();
		$date['currurl'] = $path[0];
		$date['url'] = $path[1];
		$date['menu'] = $this -> all_model -> getMenu($date['url'],64);
		
		$date['adminurl'] = $path[1] . "account/";
		
		
		$pdates = $this -> input -> get_post('pdates');
		$pdatee = $this -> input -> get_post('pdatee');
		
		$date['pdates']="";
				$date['pdatee']="";
		if($pdates!="" && $pdatee !=""){
			$sql="select m.*,r1.name as accountname,r2.companyname from invoice m left join accounttype r1 on r1.accounttypeid=m.accounttypeid left join company r2 on r2.companyid =m.companyid where pdate between  '$pdates' and '$pdatee'";
			$date['pdates']=$pdates;
				$date['pdatee']=$pdatee;
		}else{
			$sql='select m.*,r1.name as accountname,r2.companyname from invoice m left join accounttype r1 on r1.accounttypeid=m.accounttypeid left join company r2 on r2.companyid =m.companyid';
		
		}

		$date['query'] = $this -> db -> query($sql);

			$query = $this -> db -> query($sql);
			$string="";
			foreach($query->result() as $row){
				if($string==""){
					$string=$row->invoiceid;
				}else{
					$string.=",".$row->invoiceid;
				}
			}
			
			$date['invoiceid']=$string;
        $set="";

        $keyword = $this -> input -> get_post('keyword');
        if($keyword !=''){

                $set .="  and r1.prodname  like '%$keyword%'";

        }


        $date['pdate'] =date('Y-m-d');

        $sql="SELECT m.*,r1.sku,r1.brand,r1.prodname,r1.model,r2.companyname,r3.category FROM `purchase` m ";
        $sql.="   left join product r1 on m.productid=r1.productid left join company r2 on m.companyid=r2.companyid ";
        $sql.="  left join category r3 on r1.categoryid=r3.categoryid  WHERE m.purchasetype !=  '1' and m.purchasetype !=  '2' and m.purchasetype !=  '3' and r1.prodname!=''";
        $sql.="  and m.purchasetype !='999' ". $set."  ";
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

		$this -> master2 -> view('account/invoice_view', $date);
		
	}
	

	
	function account_adds(){
		
		$bo = $this -> all_model -> getSecurity(64);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}
		
		$pdate = $this -> input -> get_post('pdate');
		$companyid = $this -> input -> get_post('companyid');
		$invoicetype = $this -> input -> get_post('invoicetype');
		$invoiceno = $this -> input -> get_post('invoiceno');
		$accounttypeid = $this -> input -> get_post('accounttypeid');
		$amount = $this -> input -> get_post('amount');
		$alpay = $this -> input -> get_post('alpay');
		$paytype = $this -> input -> get_post('paytype');

		if ($amount == null |$pdate==null) {
			echo "不能空白<br>
		<a href='javascript:history.back()'>back</a>";
			return;
		}

		$data = array('pdate' => $pdate,'companyid' => $companyid,'invoicetype' => $invoicetype,'invoiceno' => $invoiceno,'accounttypeid' => $accounttypeid,'amount'=>$amount ,'alpay'=>$alpay,'paytype'=>$paytype,'createtime' => NOW());
		$this -> db -> insert('invoice', $data);
		$id = $this -> db -> insert_id();
		redirect('account/invoicelist', 'refresh');
		
	}

	function account_del(){
			
		$bo = $this -> all_model -> getSecurity(64);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}
		
		$id = $this -> uri -> segment('3', 0);
		$sql = "delete from invoice where invoiceid='" . $id . "'";
		$this -> db -> query($sql);
		redirect('account/invoicelist', 'refresh');
	}
	
	
	function account_bath_update(){
		
		$bo = $this -> all_model -> getSecurity(16);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}
		
		//$companyid = $this -> input -> get_post("companyid");
		$invoiceid = $this -> input -> get_post("invoiceid");
		//$invoiceno= $this -> input -> get_post('no');
		$chk = $this -> input -> get_post("chk");

		$arr=explode(",",$invoiceid);
		//print_r($chk) ;
		foreach($arr as $ar){
		
		
			$paytype = $this -> input -> get_post('paytype'.$ar);
			$alpay = $this -> input -> get_post('alpay'.$ar);
			$amount = $this -> input -> get_post('amount'.$ar);
			$invoicetype = $this -> input -> get_post('invoicetype'.$ar);
			$accounttypeid = $this -> input -> get_post('accounttypeid'.$ar);
		
		
			
			foreach($chk as $ch){
			 if($ch==$ar){
				
			$sql=" update invoice set invoicetype ='$invoicetype',accounttypeid='$accounttypeid',alpay='$alpay',paytype='$paytype',amount='$amount'  where `invoiceid` ='$ar'";
				// echo $sql;
				$this -> db -> query($sql);
			 }
			}
		}
		
		redirect('/account/invoicelist', 'refresh');
	}

	function accounttype() {
		
		$bo = $this -> all_model -> getSecurity(64);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}

		$path = $this -> all_model -> getPathIndex();
		$date['currurl'] = $path[0];
		$date['url'] = $path[1];
		$date['menu'] = $this -> all_model -> getMenu($date['url'],64);
		
		$date['adminurl'] = $path[1] . "account/";
		
		$date['query1'] = $this -> db -> query("select * from accounttype ");
		$date['query2'] = $this -> db -> query("select * from accounttype where type='1'");
		$date['query3'] = $this -> db -> query("select * from accounttype where type='2'");
		$date['query4'] = $this -> db -> query("select * from accounttype where type='3'");

		$this -> master2 -> view('account/accounttype_view', $date);

	}

	function accounttype_edit() {
			
		$bo = $this -> all_model -> getSecurity(64);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}
		
		$date['id'] = $this -> uri -> segment('3', 0);
		$path = $this -> all_model -> getPathIndex();
		$date['currurl'] = $path[0];
		$date['url'] = $path[1];
		$date['adminurl'] = $path[1] . "account/";
		$sql = "select * from accounttype  where accounttypeid='" . $date['id'] . "'  ";
		$date['row'] = $this -> db -> query($sql) -> row();

		$this -> master2 -> view('accounttype_edit_view', $date);
	}

	function accounttype_adds() {
		
		$bo = $this -> all_model -> getSecurity(64);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}

		$name = $this -> input -> get_post('name');
		$no = $this -> input -> get_post('no');
		$type = $this -> input -> get_post('type');

		if ($name == null) {
			echo "不能空白<br>
		<a href='javascript:history.back()'>back</a>";
			return;
		}

		$data = array('name' => $name, 'no' => $no,'type'=>'4',  'createtime' => NOW());
		$this -> db -> insert('accounttype', $data);
		$id = $this -> db -> insert_id();
		redirect("welcome/as5km435#tabs-7", 'refresh');

	}

	function accounttype_update() {
		
		$bo = $this -> all_model -> getSecurity(64);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}

		$id = $this -> input -> get_post('id');
		$name = $this -> input -> get_post('name');
		$no = $this -> input -> get_post('no');
		$type = $this -> input -> get_post('type');
		
		$data = array('no' => $no, 'name' => $name);
		$this -> db -> where('accounttypeid', $id);
		$this -> db -> update('accounttype', $data);

		redirect("welcome/as5km435#tabs-7", 'refresh');

	}

	function accounttype_del() {
			
		$bo = $this -> all_model -> getSecurity(64);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}
		
		$id = $this -> uri -> segment('3', 0);
		$sql = "delete from accounttype where accounttypeid='" . $id . "'";
		$this -> db -> query($sql);
		redirect('welcome/as5km435#tabs-7', 'refresh');
	}
	
	
	///
	function income() {
		
		$bo = $this -> all_model -> getSecurity(64);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}

        $this -> session -> set_userdata('menuid',42);


        $path = $this -> all_model -> getPathIndex();
		$date['currurl'] = $path[0];
		$date['url'] = $path[1];
		$date['menu'] = $this -> all_model -> getMenu($date['url'],64);
		$date['adminurl'] = $path[1] . "account/";
		
		$pdates = $this -> input -> get_post('pdates');
		$pdatee = $this -> input -> get_post('pdatee');
		
		$date['pdates']="";
				$date['pdatee']="";
		if($pdates!="" && $pdatee !=""){
			$date['query'] = $this -> db -> query("select m.*,r1.name from income m left join accounttype r1 on  m.accounttypeid =r1.accounttypeid where pdate between  '$pdates' and '$pdatee'");
			$date['pdates']=$pdates;
				$date['pdatee']=$pdatee;
		}else{
			$date['query'] = $this -> db -> query("select m.*,r1.name from income m left join accounttype r1 on  m.accounttypeid =r1.accounttypeid");
			
		}
		
		
		$this -> master2 -> view('account/income_view', $date);

	}

	
	function income_adds() {
		
		$bo = $this -> all_model -> getSecurity(64);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}

		$asubject = $this -> input -> get_post('accounttypeid');
		$inout = $this -> input -> get_post('inout');
		$amount = $this -> input -> get_post('amount');
		$pdate = $this -> input -> get_post('pdate');

		if ($amount == null |$asubject==null) {
			echo "不能空白<br>
		<a href='javascript:history.back()'>back</a>";
			return;
		}

		$data = array('accounttypeid' => $asubject,'amount'=>$amount ,'pdate'=>$pdate,'type'=>$inout,'createtime' => NOW());
		$this -> db -> insert('income', $data);
		$id = $this -> db -> insert_id();
		redirect("account/income/", 'refresh');

	}
	
	function income_del() {
			
		$bo = $this -> all_model -> getSecurity(64);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}
		
		$id = $this -> uri -> segment('3', 0);
		$sql = "delete from income where incomeid='" . $id . "'";
		$this -> db -> query($sql);
		redirect('account/income', 'refresh');
	}
	

	function income_update() {
		
		$bo = $this -> all_model -> getSecurity(64);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}

		$id = $this -> input -> get_post('id');
		$name = $this -> input -> get_post('name');
		$no = $this -> input -> get_post('no');
		$data = array('no' => $no, 'name' => $name);
		$this -> db -> where('accounttypeid', $id);
		$this -> db -> update('accounttype', $data);

		redirect("account/accounttype", 'refresh');

	}
	
	function balance() {
	
		$bo = $this -> all_model -> getSecurity(64);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}

        $this -> session -> set_userdata('menuid',43);


        $path = $this -> all_model -> getPathIndex();
		$date['currurl'] = $path[0];
		$date['url'] = $path[1];
		$date['menu'] = $this -> all_model -> getMenu($date['url'],64);
		$date['adminurl'] = $path[1] . "account/";
		
		
		$pdates = $this -> input -> get_post('pdates');
		$pdatee = $this -> input -> get_post('pdatee');
		
		$date['pdates']="";
		$date['pdatee']="";
		if($pdates!="" && $pdatee !=""){
			$date['querytab1'] = $this -> db -> query("select m.*,r1.name from balance m left join accounttype r1 on  m.accounttypeid =r1.accounttypeid where m.type=1 and  pdate between  '$pdates' and '$pdatee'");
			
			$date['querytab2'] = $this -> db -> query("select m.*,r1.name from balance m left join accounttype r1 on  m.accounttypeid =r1.accounttypeid where m.type=2 and  pdate between  '$pdates' and '$pdatee'");
			$date['querytab3'] = $this -> db -> query("select m.*,r1.name from balance m left join accounttype r1 on  m.accounttypeid =r1.accounttypeid where m.type=3 and  pdate between  '$pdates' and '$pdatee'");
			
			$date['pdates']=$pdates;
			$date['pdatee']=$pdatee;
		}else{
			$date['querytab1'] = $this -> db -> query("select m.*,r1.name from balance m left join accounttype r1 on  m.accounttypeid =r1.accounttypeid where m.type=1 ");
			$date['querytab2'] = $this -> db -> query("select m.*,r1.name from balance m left join accounttype r1 on  m.accounttypeid =r1.accounttypeid where m.type=2");
			$date['querytab3'] = $this -> db -> query("select m.*,r1.name from balance m left join accounttype r1 on  m.accounttypeid =r1.accounttypeid where m.type=3 ");
			
		}
		
		
		$sql="select m.*,r1.name from balance m left join accounttype r1 on  m.accounttypeid =r1.accounttypeid where m.type=1";

		$date['query1'] = $this -> db -> query($sql);

			$query = $this -> db -> query($sql);
			$string="";
			foreach($query->result() as $row){
				if($string==""){
					$string=$row->balanceid;
				}else{
					$string.=",".$row->balanceid;
				}
			}
			
			$date['balanceid1']=$string;


		$sql="select m.*,r1.name from balance m left join accounttype r1 on  m.accounttypeid =r1.accounttypeid where m.type=2";
		//echo $sql;
		
		$date['query4'] = $this -> db -> query($sql);

			$query = $this -> db -> query($sql);
			$string="";
			foreach($query->result() as $row){
				if($string==""){
					$string=$row->balanceid;
				}else{
					$string.=",".$row->balanceid;
				}
			}
			
			$date['balanceid2']=$string;
		
		$sql="select m.*,r1.name from balance m left join accounttype r1 on  m.accounttypeid =r1.accounttypeid where m.type=3";
		//echo $sql;
		
		$date['query3'] = $this -> db -> query($sql);

			$query = $this -> db -> query($sql);
			$string="";
			foreach($query->result() as $row){
				if($string==""){
					$string=$row->balanceid;
				}else{
					$string.=",".$row->balanceid;
				}
			}
			
			$date['balanceid3']=$string;

		$this -> master2 -> view('account/balance_view', $date);

	}

	function balance_bath_update(){
		
		$bo = $this -> all_model -> getSecurity(16);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}

		$balanceid = $this -> input -> get_post("balanceid");
		$invoiceno= $this -> input -> get_post('no');

	
		$type = $this -> input -> get_post('type');
		$chk = $this -> input -> get_post("chk1");
		if($type=="1"){
			$chk = $this -> input -> get_post("chk1");
		}else if($type=="2"){
			$chk = $this -> input -> get_post("chk2");
		}else if($type=="3"){
			$chk = $this -> input -> get_post("chk3");
		}

		$arr=explode(",",$balanceid);
		//print_r($chk) ;
		foreach($arr as $ar){
		
				$amount = $this -> input -> get_post('amount'.$ar);
				$pdate = $this -> input -> get_post('pdate'.$ar);
				$accounttypeid = $this -> input -> get_post('accounttypeid'.$ar);
		
			$sql=" update balance set accounttypeid ='$accounttypeid',amount='$amount',type=$type,pdate='$pdate' where `balanceid` ='$ar'";
			
			foreach($chk as $ch){
			 if($ch==$ar){
				//echo $sql;
				$this -> db -> query($sql);
			 }
			}
		}
		
		redirect('account/balance', 'refresh');
		
	}
		
		function balance_del() {
			
		$bo = $this -> all_model -> getSecurity(64);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}
		
		$id = $this -> uri -> segment('3', 0);
		$sql = "delete from balance where balanceid='" . $id . "'";
		$this -> db -> query($sql);
		redirect('account/balance', 'refresh');
	}
		
	function balance_adds() {
		
		$bo = $this -> all_model -> getSecurity(64);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}

		$asubject = $this -> input -> get_post('accounttypeid');
		$inout = $this -> input -> get_post('inout');
		$pdate = $this -> input -> get_post('pdate');
		$amount = $this -> input -> get_post('amount');

		if ($amount == null |$asubject==null) {
			echo "不能空白<br>
		<a href='javascript:history.back()'>back</a>";
			return;
		}

		$data = array('pdate' => $pdate,'accounttypeid' => $asubject,'amount'=>$amount ,'type'=>$inout,'createtime' => NOW());
		$this -> db -> insert('balance', $data);
		$id = $this -> db -> insert_id();
		redirect("account/balance/", 'refresh');

	}



}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
