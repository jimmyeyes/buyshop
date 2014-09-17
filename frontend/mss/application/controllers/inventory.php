<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Inventory extends CI_Controller {

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

		$bo = $this -> all_model -> getSecurity(32);
		if (!$bo) {
			echo "沒有權限<br>
		<a href='javascript:history.back()'>back</a>";
			return;
		}

		$path = $this -> all_model -> getPathIndex();
		$date['currurl'] = $path[0];
		$date['url'] = $path[1];
		$date['menu'] = $this -> all_model -> getMenu($date['url'],32);
		
		$date['adminurl'] = $path[1] . "inventory/";
		$sql="SELECT * from  category ";
		$date['querycate'] = $this -> db -> query($sql);
		
		$sql="select m.*,r2.*,r3.category from product m  left join company r2 on r2.companyid=m.companyid left join category r3 on r3.categoryid=m.categoryid";
		//echo $sql;
		$date['queryinvent'] =$this->db->query($sql);
		$typeid = $this -> input -> get_post('typeid');
		$keyword = $this -> input -> get_post('keyword');
		$date['keyword']="";
		$date['queryselect']=null;
		$date['purchaseid']="";
		$date['productid']="";
		if($keyword !="" ){
		
		$date['keyword']=$keyword;
			
		$sql="select m.*,r2.brand,r2.prodname,r2.model,r2.sku,r2.ean,r2.upc,r2.mpn,r4.category from inventorylist m  ";
			$sql.="left join product r2 on r2.productid=m.productid  left join company r3 on r3.companyid=r2.companyid ";
			$sql.="left join category r4 on r4.categoryid=r2.categoryid  where  r2.$typeid like '%".$keyword."%' and m.back=0 ";
			
		//echo $sql;
		$query = $this -> db -> query($sql);
		$num=$query->num_rows();
		
		if($num>1){
			$sql="select m.*,r2.brand,r2.prodname,r2.model,r2.sku,r2.ean,r2.upc,r2.mpn,r4.category from inventorylist m  ";
			$sql.="left join product r2 on r2.productid=m.productid  left join company r3 on r3.companyid=r2.companyid ";
			$sql.="left join category r4 on r4.categoryid=r2.categoryid  where  r2.$typeid like '%".$keyword."%' and m.back=0 ";
		}
		
		// group by productid ,price
		$date['query']=$this -> db ->query($sql);
		$query = $this -> db -> query($sql);
			$string="";
			$productid="";
			foreach($query->result() as $row){
				if($string==""){
					$string=$row->inventorylistid;
				}else{
					$string.=",".$row->inventorylistid;
				}
				if($productid==""){
					$productid=$row->inventorylistid;
				}else{
					$productid.=",".$row->productid;
				}
				
			}
			
			$date['inventorylistid']=$string;
			
			$date['productid']=$productid;
			$date['queryselect']=$this->db->query($sql);
			$date['isvisable']="1";
		}else{
			$date['isvisable']="0";
		}

        $date['pdate']="";
		
		
		$this -> master2 -> view('inventory/inventory_view', $date);

	}
	

	function inventory_update2(){
		
		$bo = $this -> all_model -> getSecurity(32);
		if (!$bo) {
			echo "沒有權限<br>
		<a href='javascript:history.back()'>back</a>";
			return;
		}
		
		$inventoryid = $this -> input -> get_post("inventoryid");
		$inventorylistid = $this -> input -> get_post("inventorylistid");
		$productid = $this -> input -> get_post("productid");
		$price = $this -> input -> get_post('price');
		$amount = $this -> input -> get_post('amount');
		$chk = $this -> input -> get_post("chk");

		if ($price == null | $amount == null) {
			echo "不能空白<br>
		<a href='javascript:history.back()'>back</a>";
			return;
		}


		$arr=explode(",",$inventorylistid);
		$prodarr=explode(",",$productid);
		//print_r($chk) ;
		$i=0;
		foreach($arr as $ar){

			foreach($chk as $ch){
			//	echo $ch;
			if($ch==$ar){
				
				$sql="update inventorylist set price='".$price."' , amount ='".$amount."' where  inventorylistid='".$ar."'";
				$this->db->query($sql);
			
				}
			}
			$i++;
			
		}
		
		if($inventoryid==""){
			redirect(base_url() . 'index.php/inventory/inventory', 'refresh');
		}else{
			redirect(base_url() . 'index.php/inventory/inventory_detail/'.$inventoryid, 'refresh');
		}
		
	}
	
	
	function inventory_update(){
		$bo = $this -> all_model -> getSecurity(32);
		if (!$bo) {
			echo "沒有權限<br>
		<a href='javascript:history.back()'>back</a>";
			return;
		}
		
		$inventorylistid = $this -> input -> get_post("inventorylistid");
		$inventoryid = $this -> input -> get_post("inventoryid");
		$chk = $this -> input -> get_post("chk");

		$arr=explode(",",$inventorylistid);
		//print_r($chk) ;
		$i=0;
		foreach($arr as $ar){
			foreach($chk as $ch){
			if($ch==$ar){
				
				$amount = $this -> input -> get_post('amount'.$ar);
					$price = $this -> input -> get_post('price'.$ar);
				
				$sql="update inventorylist set price='".$price."' , amount ='".$amount."' where  inventorylistid='".$ar."'";
				$this->db->query($sql);
				//echo $sql;
				}
			}
			$i++;
			
		}
		
		if($inventoryid==""){
			redirect(base_url() . 'index.php/inventory/inventory', 'refresh');
		}else{
			redirect(base_url() . 'index.php/inventory/inventory_detail/'.$inventoryid, 'refresh');
		}
		
	}
	
	function inventory_detail() {

		$bo = $this -> all_model -> getSecurity(32);
		if (!$bo) {
			echo "沒有權限<br>
		<a href='javascript:history.back()'>back</a>";
			return;
		}

		$id = $this -> uri -> segment('3', 0);

		$date['inventoryid']=$id;
		$path = $this -> all_model -> getPathIndex();
		$date['currurl'] = $path[0];
		$date['url'] = $path[1];
		$date['menu'] = $this -> all_model -> getMenu($date['url'],32);

		$date['adminurl'] = $path[1] . "inventory/";
		
		$sql="SELECT * from  category ";
		$date['querycate'] = $this -> db -> query($sql);
		
	
		 $sql="SELECT m.*,r2.prodname  FROM `inventorylist` m  ";
		 $sql.="  left join product r2 on m.productid=r2.productid where m.productid='".$id."' and m.back=0  ";
		
		///echo $sql;
		$query = $this -> db -> query($sql);
		foreach($query->result() as $row){
			if($row->prodname==""){
				$sql2="delete from inventorylist where inventorylistid='".$row->inventorylistid."'";
				//echo $sql2;
				$this->db->query($sql2);
			}	
		}
		

		$date['query']=$this -> db ->query($sql);
		$query = $this -> db -> query($sql);
			$string="";
			$productid="";
			foreach($query->result() as $row){
				if($string==""){
					$string=$row->inventorylistid;
				}else{
					$string.=",".$row->inventorylistid;
				}
				if($productid==""){
					$productid=$row->productid;
				}else{
					$productid.=",".$row->productid;
				}
			}
			$date['productid']=$productid;
			$date['inventorylistid']=$string;
			
		$this -> master2 -> view('inventory/inventory_detail_view', $date);

	}
	
	function inventory_adds(){
		$amount = $this -> input -> get_post('amount');
		$pdate = $this -> input -> get_post('pdate');
		$productid = $this -> input -> get_post('productid');
		$price = $this -> input -> get_post('price');

		if ($pdate == null | $amount == null  | $productid==null) {
			echo "不能空白<br><a href='javascript:history.back()'>back</a>";
			return;
		}
		
		$sql="select productid as co from inventorylist where productid='".$productid."' and price='".$price."'";
	//echo $sql;
		$query = $this -> db -> query($sql);
		if ($query -> num_rows() > 0) {
				$sql="update inventorylist set updatetime='".$pdate."' , amount=amount+".$amount." where productid='".$productid."' and price='".$price."'";
				$query = $this -> db -> query($sql);
		}else{
			
			$sql="insert into inventorylist values(null,NOW(),'".$productid."','0','".$price."','".$amount."',NOW())";
			$this->db->query($sql);
		}
		

		//echo $sql;

		
		redirect(base_url() . 'index.php/inventory/inventory/', 'refresh');
	}

	function inventory_back() {

		$bo = $this -> all_model -> getSecurity(32);
		if (!$bo) {
			echo "沒有權限<br>
		<a href='javascript:history.back()'>back</a>";
			return;
		}
		

		$path = $this -> all_model -> getPathIndex();
		$date['currurl'] = $path[0];
		$date['url'] = $path[1];
		$date['menu'] = $this -> all_model -> getMenu($date['url'],32);

		$date['adminurl'] = $path[1] . "inventory/";
		$sql="select m.*,r1.prodname,r1.model,r1.sku,r1.brand,r4.category from inventorylist m   left join product r1 on m.productid=r1.productid  left join category r4 on r1.categoryid=r4.categoryid where m.back=1";
		$query = $this -> db -> query($sql);
			$string="";
			foreach($query->result() as $row){
				if($string==""){
					$string=$row->inventorylistid;
				}else{
					$string.=",".$row->inventorylistid;
				}
			}
			
			$date['purchaseid']=$string;
		
		$date['query'] = $this -> db ->query($sql);
		$this -> master2 -> view('inventory/inventory_back_view', $date);

	}
	
	function inventory_brifdel() {
		
		$bo = $this -> all_model -> getSecurity(32);
		if (!$bo) {
			echo "沒有權限<br>
		<a href='javascript:history.back()'>back</a>";
			return;
		}
		
		$inventorylistid = $this -> uri -> segment('3', 0);
		
		$this -> db -> query("delete from inventorylist where inventorylistid='" . $inventorylistid. "'");
			
	   redirect(base_url() . 'index.php/inventory/inventory/', 'refresh');
		
	}
	

	function inventory_del() {
			
		$bo = $this -> all_model -> getSecurity(32);
		if (!$bo) {
			echo "沒有權限<br>
		<a href='javascript:history.back()'>back</a>";
			return;
		}
		
		$inventorylistid = $this -> uri -> segment('3', 0);
		$back = $this -> uri -> segment('4', 0);
		$productid = $this -> uri -> segment('5', 0);
		

		$this -> db -> query("delete from inventorylist where inventorylistid='" . $inventorylistid. "'");
		
		if($back=="1"){
			redirect(base_url() . 'index.php/inventory/inventory_back', 'refresh');
		}else if($back=="2"){
			redirect(base_url() . 'index.php/inventory/inventory_detail/'.$productid , 'refresh');
		}else{
			redirect(base_url() . 'index.php/inventory/inventory/', 'refresh');
		}
	}
	
	function inventory_back_bathupdate(){
				
		$bo = $this -> all_model -> getSecurity(32);
		if (!$bo) {
			echo "沒有權限<br>
		<a href='javascript:history.back()'>back</a>";
			return;
		}	
	    $companyid  = $this -> input -> get_post('companyid');
		$no = $this -> input -> get_post('no');
		$inventorylistid = $this -> input -> get_post("inventorylistid");
		$chk = $this -> input -> get_post("chk");

		$arr=explode(",",$inventorylistid);
		//print_r($chk) ;
		foreach($arr as $ar){
			foreach($chk as $ch){
			if($ch==$ar){
					//$sql="update purchase set no='".$no."' , companyid ='".$companyid."' where  purchaseid='".$ar."'";
					//$this->db->query($sql);
				}
			}
		}
		
		redirect(base_url() . 'index.php/inventory/inventory_back/', 'refresh');
		
	}
	
	function inventory_back_opt() {
			
		$bo = $this -> all_model -> getSecurity(32);
		if (!$bo) {
			echo "沒有權限<br>
		<a href='javascript:history.back()'>back</a>";
			return;
		}
		
		
		$id  = $this -> input -> get_post('inventorylistid');
		$amount  = $this -> input -> get_post('amount');
		
		$dbamount="";
		$pdate="";
		$productid="";
		$price="";
		$sql="select m.* from inventorylist m  where m.inventorylistid='" . $id. "'";
	//	echo $sql;
		$query=$this->db->query($sql);
		foreach($query->result() as $row){
			$dbamount=$row->amount;
			$productid=$row->productid;
			$pdate=$row->updatetime;
			$price=$row->price;
		}
		
		if($amount==$dbamount){
		
			$this -> db -> query("update   inventorylist set back=1 where inventorylistid='" . $id. "'");
		}else{
			$newam=$dbamount-$amount;
			$sql="update inventorylist set amount=amount-".$newam." where inventorylistid='".$id."'";
			//echo $sql;
			$this->db->query($sql);
			
			$sql="insert into inventorylist values(null,NOW(),'".$productid."','1','".$price."','".$newam."',NOW())";
			$this->db->query($sql);
			
		}
			redirect(base_url() . 'index.php/inventory/inventory/', 'refresh');
	}//
	



}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
