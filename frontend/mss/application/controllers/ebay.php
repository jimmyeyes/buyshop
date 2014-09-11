<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Ebay extends CI_Controller {

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
	public function message() {

		$bo = $this -> all_model -> getSecurity(2048);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}

        $this -> session -> set_userdata('menuid',23);

        $path = $this -> all_model -> getPathIndex();
		$date['currurl'] = $path[0];
		$date['url'] = $path[1];
		$date['menu'] = $this -> all_model -> getMenu($date['url'],2048);
		$date['adminurl'] = $path[1] . "product/";
        $date['authority']=$this->session->userdata('authority');

        $date["noscript"]="1";

		$sql="SELECT m.*,r1.companyname,r2.category FROM `product` m left join company r1 on m.companyid=r1.companyid left join category r2 on m.categoryid=r2.categoryid limit 10";
		//echo $sql;

		$date['query'] = $this -> db -> query($sql);
		
			$query = $this -> db -> query($sql);
			$string="";
			foreach($query->result() as $row){
				if($string==""){
					$string=$row->productid;
				}else{
					$string.=",".$row->productid;
				}
			}
			
			$date['productid']=$string;
		


        $this -> master2 -> view('ebay/message_view', $date);

	}


    public function eactive() {

        $bo = $this -> all_model -> getSecurity(2048);
        if (!$bo) {
            echo $this -> all_model -> getErr();
            return;
        }


        $this -> session -> set_userdata('menuid',21);

        $path = $this -> all_model -> getPathIndex();
        $date['currurl'] = $path[0];
        $date['url'] = $path[1];
        $date['menu'] = $this -> all_model -> getMenu($date['url'],2048);
        $date['adminurl'] = $path[1] . "product/";
        $date['authority']=$this->session->userdata('authority');

        $sql="SELECT m.*,r1.companyname,r2.category FROM `product` m left join company r1 on m.companyid=r1.companyid left join category r2 on m.categoryid=r2.categoryid limit 10";
        //echo $sql;

        $date['query'] = $this -> db -> query($sql);

        $query = $this -> db -> query($sql);
        $string="";
        foreach($query->result() as $row){
            if($string==""){
                $string=$row->productid;
            }else{
                $string.=",".$row->productid;
            }
        }

        $date['productid']=$string;


        $sql="SELECT * from  category ";
        //echo $sql;
        $date['querycate'] = $this -> db -> query($sql);
        //check getEbayactive();


        $string="";

        $date['prodcopriceid2']=$string;

        $sql="select * from accounttoken";
        $query=$this->db->query($sql);
        $count=0;
        $date['querypro2'] =$query;

        /*   $sql="select count(productid) as co,productid from productonebay where `on`='1' group by productid  ";

           $query=$this->db->query($sql);
           foreach($query->result() as $row){

               if($row->co > $count){
                   $sql="delete from prodtoebay where productid ='$row->productid'";
                   $this -> db -> query($sql);
               }
           }*/

        $sql="SELECT r3.*,r1.companyname,r2.category,m.prodtoebayid FROM `prodtoebay` m left join product r3 on m.productid=r3.productid left join company r1 on r3.companyid=r1.companyid left join category r2 on r3.categoryid=r2.categoryid ";
        //  echo $sql;
        $date['query3'] = $this -> db -> query($sql);

        $query = $this -> db -> query($sql);
        $string="";
        foreach($query->result() as $row){
            if($string==""){
                $string=$row->productid;
            }else{
                $string.=",".$row->productid;
            }
        }
        $date['productid3']=$string;
        //  $this->getEbayactive();


        $this -> master2 -> view('ebay/active_view', $date);

        //flush();

    }


    public function awaiting() {

        $bo = $this -> all_model -> getSecurity(2048);
        if (!$bo) {
            echo $this -> all_model -> getErr();
            return;
        }

        $this -> session -> set_userdata('menuid',22);


        $path = $this -> all_model -> getPathIndex();
        $date['currurl'] = $path[0];
        $date['url'] = $path[1];
        $date['menu'] = $this -> all_model -> getMenu($date['url'],2048);
        $date['adminurl'] = $path[1] . "product/";
        $date['authority']=$this->session->userdata('authority');

        $sql="SELECT m.*,r1.companyname,r2.category FROM `product` m left join company r1 on m.companyid=r1.companyid left join category r2 on m.categoryid=r2.categoryid limit 10";
        //echo $sql;

        $date['query'] = $this -> db -> query($sql);

        $query = $this -> db -> query($sql);
        $string="";
        foreach($query->result() as $row){
            if($string==""){
                $string=$row->productid;
            }else{
                $string.=",".$row->productid;
            }
        }

        $date['productid']=$string;


        $sql="SELECT * from  category ";
        //echo $sql;
        $date['querycate'] = $this -> db -> query($sql);
        //check getEbayactive();


        $string="";
        $date['prodcopriceid2']=$string;

        $sql="select * from accounttoken";
        $query=$this->db->query($sql);
        $count=0;
        $date['querypro2'] =$query;

        $sql="SELECT r3.*,r1.companyname,r2.category,m.prodtoebayid FROM `prodtoebay` m left join product r3 on m.productid=r3.productid left join company r1 on r3.companyid=r1.companyid left join category r2 on r3.categoryid=r2.categoryid ";
        //  echo $sql;
        $date['query3'] = $this -> db -> query($sql);

        $query = $this -> db -> query($sql);
        $string="";
        foreach($query->result() as $row){
            if($string==""){
                $string=$row->productid;
            }else{
                $string.=",".$row->productid;
            }
        }
        $date['productid3']=$string;
        //  $this->getEbayactive();


        $this -> master2 -> view('ebay/awaiting_view', $date);

        //flush();

    }



}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
