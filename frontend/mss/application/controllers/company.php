<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Company extends CI_Controller {

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

		$bo = $this -> all_model -> getSecurity(4);
		if (!$bo) {
			echo "沒有權限<br>
		<a href='javascript:history.back()'>back</a>";
			return;
		}

        $this -> session -> set_userdata('menuid',13);


        $path = $this -> all_model -> getPathIndex();
		$date['currurl'] = $path[0];
		$date['url'] = $path[1];
		$date['menu'] = $this -> all_model -> getMenu($date['url'],4);
		$date['adminurl'] = $path[1] . "company/";



        $sql="select * from company";
		$date['query'] = $this -> db -> query($sql);
		
			$query = $this -> db -> query($sql);
			$string="";
			foreach($query->result() as $row){
				if($string==""){
					$string=$row->companyid;
				}else{
					$string.=",".$row->companyid;
				}
			}
			
			$date['companyid']=$string;
		
		

		$this -> master2 -> view('company/company_view', $date);

	}
	
	function company_adds() {
		
		$bo = $this -> all_model -> getSecurity(4);
		if (!$bo) {
			echo "沒有權限<br>
		<a href='javascript:history.back()'>back</a>";
			return;
		}
		$name = $this -> input -> get_post('name');
		if ($name == null) {
			echo "不能空白<br>
		<a href='javascript:history.back()'>back</a>";
			return;
		}
		$query=$this->db->query("select * from company where companyname='".$name."'");
		if($query->num_rows){
				echo "廠商重複<br><a href='javascript:history.back()'>back</a>";
			return;
		}
		$sql = "insert into company (companyname,createtime) values ('$name',NOW())";
		$this -> db -> query($sql);
		$memberid = $this -> db -> insert_id();

		redirect("company/company_edit/" . $memberid, 'refresh');

	}

	function company_edit_update() {
		
		$bo = $this -> all_model -> getSecurity(4);
		if (!$bo) {
			echo "沒有權限<br>
		<a href='javascript:history.back()'>back</a>";
			return;
		}

		$id = $this -> input -> get_post('id');
		$companyname = $this -> input -> get_post('companyname');
		$addr = $this -> input -> get_post('addr');
		$contactname = $this -> input -> get_post('contactname');
		$tel = $this -> input -> get_post('tel');
		$mobile = $this -> input -> get_post('mobile');
		$fax = $this -> input -> get_post('fax');
		$website = $this -> input -> get_post('website');
		$bankid = $this -> input -> get_post('bankid');
		$email = $this -> input -> get_post('email');
		$companyno = $this -> input -> get_post('companyno');
		
		$query=$this->db->query("select * from company where companyno='".$companyno."'");
		//echo $query->num_rows;
		if($query->num_rows>=2){
				echo "公司代號重複<br><a href='javascript:history.back()'>back</a>";
			return;
		}
		

		$data = array('companyno' => $companyno, 'companyname' => $companyname, 'addr' => $addr, 'contactname' => $contactname, 'tel' => $tel, 'mobile' => $mobile, 'fax' => $fax, 'website' => $website, 'bankid' => $bankid, 'email' => $email);

		$this -> db -> where('companyid', $id);
		$this -> db -> update('company', $data);

		//$sql = "update member set passwd='" . $password . "',authority='$authority' ,  name='$name', updatetime='$updatetime' where memberid='$id'";
		//echo $sql;
		//$this -> db -> query($sql);
		redirect("company/company", 'refresh');

	}

	function company_edit() {
		
		$bo = $this -> all_model -> getSecurity(4);
		if (!$bo) {
			echo "沒有權限<br>
		<a href='javascript:history.back()'>back</a>";
			return;
		}

		$date['id'] = $this -> uri -> segment('3', 0);
		$path = $this -> all_model -> getPathIndex();
		$date['currurl'] = $path[0];
		$date['url'] = $path[1];
		
		$date['menu'] = $this -> all_model -> getMenu($date['url'],4);
		
		$date['adminurl'] = $path[1] . "company/";
		$date['row'] = $this -> db -> get_where('company', array('companyid' => $date['id'])) -> row();
		$sql = "select m.*,r1.price,r2.companyname,r3.category from product m left join prodcoprice r1 on m.productid=r1.productid left join company r2 on r1.companyid=r2.companyid left join category r3 on r3.categoryid=m.categoryid  where r1.companyid='" . $date['id'] . "'";
		//echo $sql;
		
		$date['authority']  = $this -> session -> userdata('authority');
		
		$date['query'] = $this -> db -> query($sql);
		$this -> master2 -> view('company/company_edit_view', $date);
	}

	function company_del() {
	
		$bo = $this -> all_model -> getSecurity(4);
		if (!$bo) {
			echo "沒有權限<br>
		<a href='javascript:history.back()'>back</a>";
			return;
		}
		$id = $this -> uri -> segment('3', 0);
		$this -> db -> where('companyid', $id);
		$this -> db -> delete('company');
		redirect("company/company", 'refresh');
	}
	
	function company_bath(){
		
		$bo = $this -> all_model -> getSecurity(16);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}
		
		$companylist="";
		
		$companyid = $this -> input -> get_post("companyid");
		$modtype = $this -> input -> get_post("modtype");
		
		$chk = $this -> input -> get_post("chk");
		$arr=explode(",",$companyid);

        if($chk ==null){
            echo "please select ";
            return;
        }


		foreach($arr as $ar){
			foreach(@$chk as $ch){
			if($ch==$ar){
				
				if($modtype==1){
					if($companylist==""){
						$companylist=$ar;
					}else{
						$companylist.=",".$ar;
					}
				}else{
					
					$sql="delete from  company where companyid='".$ar."'";
					$this->db->query($sql);
						
				}
			}
			}
		}
		if($modtype==2){
			redirect('/company/company', 'refresh');			
			return;
		}
		
		$path = $this -> all_model -> getPathIndex();
		$date['currurl'] = $path[0];
		$date['url'] = $path[1];
		$date['menu'] = $this -> all_model -> getMenu($date['url'],4);
		$date['adminurl'] = $path[1] . "company/";
		
		$sql="select * from company where companyid in (".$companylist.")";
		$date['query'] = $this -> db -> query($sql);
		
			$query = $this -> db -> query($sql);
			$string="";
			foreach($query->result() as $row){
				if($string==""){
					$string=$row->companyid;
				}else{
					$string.=",".$row->companyid;
				}
			}
			
			$date['companyid']=$string;
		
		$this -> master2 -> view('company/companybath_view', $date);
		
	}
	
	
	
	function company_updatebath(){
		
		$bo = $this -> all_model -> getSecurity(16);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}
		
		$companyid = $this -> input -> get_post("companyid");
		$chk = $this -> input -> get_post("chk");
		$arr=explode(",",$companyid);
		//print_r($chk) ;
		foreach($arr as $ar){

			foreach(@$chk as $ch){
				//echo $ch;
			if($ch==$ar){
				$companyno = $this -> input -> get_post('companyno'.$ar);
				$contactname = $this -> input -> get_post('contactname'.$ar);
				$tel = $this -> input -> get_post('tel'.$ar);
				$mobile = $this -> input -> get_post('mobile'.$ar);
				$website = $this -> input -> get_post('website'.$ar);
				$bankid = $this -> input -> get_post('bankid'.$ar);

				$sql="update company set companyno='".$companyno."' , contactname='".$contactname."', tel='".$tel."', mobile='".$mobile."', website='".$website."', bankid='".$bankid."' where companyid='".$ar."'";
					//echo $sql;
				$query = $this -> db -> query($sql);
	
			}
			}
		}
	
	redirect('/company/company', 'refresh');
		
		
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
