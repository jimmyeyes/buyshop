<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Product extends CI_Controller {

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

		$bo = $this -> all_model -> getSecurity(8);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}

        $this -> session -> set_userdata('menuid',11);

        $path = $this -> all_model -> getPathIndex();
		$date['currurl'] = $path[0];
		$date['url'] = $path[1];
		$date['menu'] = $this -> all_model -> getMenu($date['url'],8);
		$date['adminurl'] = $path[1] . "product/";
        $date['authority']=$this->session->userdata('authority');


        $date["noscript"]="1";

        $set="";
        $set2="";
        $category = $this -> input -> get_post('category');
        if($category !="" && $category !='All'){
            $set=" and  m.categoryid='".$category."'";
            $sql="SELECT * from  category where categoryid='$category'";
             $date['categoryname']= $this -> db -> query($sql)->row()->category;
        }else{
            $date['categoryname']="All";
        }

        $keyword = $this -> input -> get_post('keyword');
        $type = $this -> input -> get_post('type');
        if($keyword !='' && $type !=''){
            if($type=="sku"){
                $set .="  and m.$type = '$keyword'";
            }else{
                $set .="  and m.$type  like '%$keyword%'";
            }
        }

		$sql="SELECT m.*,r1.companyname,r2.category FROM `product` m left join company r1 on m.companyid=r1.companyid left join category r2 on m.categoryid=r2.categoryid and simprod='0' where 1   $set limit 1000  ";
		//echo $sql;
		$date['query'] = $this -> db -> query($sql);
        $date['productcount'] =		$date['query'] ->num_rows();
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



        $this -> master2 -> view('product/product_view', $date);

	}




    function  showpic(){


        $file = $this -> input -> get_post('path');



// File and new size
        $filename = $file;
        $percent = 0.1;

// Content type
        header('Content-Type: image/jpeg');

// Get new sizes
        list($width, $height) = getimagesize($filename);
        $newwidth = $width * $percent;
        $newheight = $height * $percent;

// Load
        $thumb = imagecreatetruecolor($newwidth, $newheight);
        $source = imagecreatefromjpeg($filename);

// Resize
        imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

// Output
        imagejpeg($thumb);




////
        //印在畫面上

    }


    function table_ajax(){


        $path = $this -> all_model -> getPathIndex();
        $currurl = $path[0];



        $records = array();
        $records["aaData"] = array();


$set="";

$sql="SELECT m.*,r1.companyname,r2.category FROM `product` m left join company r1 on m.companyid=r1.companyid left join category r2 on m.categoryid=r2.categoryid and simprod='0' where 1   $set limit 1000  ";
        //echo $sql;
        $query = $this -> db -> query($sql);

        foreach ($query->result() as $row) {


    if($row->Quantity==""){
        $qty=0;
    }else{
        $qty=$row->Quantity;
    }

    if($row->amount==""){
        $amount=0;
    }else{
        $amount=$row->amount;
    }
    $price=0;
    $amount=0;
    $total=0;
    $sim=   $this -> db -> query("SELECT * FROM inventorylist where  productid ='".$row->productid."' ");
    foreach($sim->result() as $row2){
        $amount+=$row2->amount;
        $price+=$row2->price;
        $total=$row2->amount*$row2->price;
    }

    if($amount ==0 || $price==0 || $total==0 || $row->Quantity==0){
        $avg=0;
    }else
        $avg=@($total)/$row->Quantity;

    if($row->avg==0)
        $avg=$avg;
    else{
        $avg=$row->avg;
    }

            $queryimg = $this -> db -> query("SELECT * FROM product_img where proid='" . $row->productid . "' limit 1");
            $count =$queryimg->num_rows();
            if($count >0){
                $queryimg=$queryimg->row();

            }



            $records["aaData"][] = array(
               '<input class="checkboxes" type="checkbox" value="'.$row->productid.'" name="chk[]"/>',
                'metrouser',


               '<td ><a href="<?= $adminurl . "product_edit" ?>/<?= $row->productid ?>"><?= $row->prodname ?></a></td>',


                '<td ></td>',

'<td >'.$row->sku.'</td>',
'<td >'.$row->brand.'</td>',
'<td >'.$row->category.'</td>',


                '    <input     type="text" value="<?=$avg?>"  name="avg'.$row->productid.'">  </td>',
                  '<td > <input    type="text" value="<?=$row->Quantity?>"  name="Quantity'.$row->productid.'">  </td>'

            );
        }

        $records["sEcho"] = "";
        $records["iTotalRecords"] = "1000";
        $records["iTotalDisplayRecords"] = "1000";

        echo json_encode($records);

    }

    function getProdSim(){

        $path = $this -> all_model -> getPathIndex();
        $currurl = $path[0];
        $url = $path[1];
        $sku = $this -> input -> get_post('sku');

        if($sku =="" ){
            return "";
        }

        $sql="select * from product where sku='$sku' ";
        $row=$this->db->query($sql)->row();
        $productid=$row->productid;

        $sql="select * from product where simprod ='$productid' ";
        //echo $sql;
        $query=$this->db->query($sql);
        $sOut = '<table class="table  table-striped table-bordered table-hover" >';
        $check="check_all(this,'chk".$productid."[]')";
       /* $sOut.='<thead>
            <tr>
                 <th ></th> <th style="width:3%;"></th>
                <th style="width:4.5%;"></th>
                <th style="width:50%;"> </th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            </thead>';
       */

        $sOut .= ' <tbody>';

        foreach($query->result() as $row){
            $queryimg = $this -> db -> query("SELECT * FROM product_img where proid='" . $row->productid . "' limit 1");
            $count =$queryimg->num_rows();
            if($count >0){
                $queryimg=$queryimg->row();
                $img='<img src="'.$currurl.$queryimg->url.'" width="50px" />';
            }else{
                $img="";
            }

            if($row->Quantity==""){
                $qty=0;
            }else{
                $qty=$row->Quantity;
            }

            if($row->amount==""){
                $amount=0;
            }else{
                $amount=$row->amount;
            }

            $sim=   $this -> db -> query("SELECT * FROM product_inventory where  productid ='".$row->productid."' ");
            foreach($sim->result() as $row2){
                $qty+=$row2->available;
                $amount+=$row2->cost;
            }

            if($amount ==0 || $qty==0){
                $avg=0;
            }else
                $avg=@($amount)/$qty;
             $avg;


            $sOut .='<tr><td style="width:2%;"></td><td  style="width:3.2%;"><input  id="a'.$sku.'" class="checkboxes"  type="checkbox" value="'.$row->productid.'" name="chk[]"/></td>';
            $sOut .= '<td style="width:4.8%;">'.$img.'</td><td  style="width:49%;"><a href="'.$url.'product/product_edit/'.$row->productid.'">'.$row->prodname.'</a></td><td style="width:5.6%;">'.$row->sku.'</td>';
            $sOut .= '<td style="width:4.8%;">'.$row->brand.'</td><td style="width:14%;">'.$row->category.'</td><td style="width:10.0%;">'.$avg.'</td><td style="width:6.2%;">'.$row->Quantity.'</td>';
             $sOut .= '</tr>';

        }



         $sOut .= ' </tbody></table>';

        $sOut.="
        <script>
          jQuery(document).ready(function() {
        $('.selectall$sku').click(function(event) {  //on click



            if(this.checked) { // check select status
                $('.check$sku').each(function() { //loop through each checkbox
                    this.checked = true;  //select all checkboxes with class
                });
            }else{
                $('.check$sku').each(function() { //loop through each checkbox
                    this.checked = false; //deselect all checkboxes with class
                });
            }
        });    }); </script> " ;


        echo $sOut;
        return $sOut;

    }


    public function ebay() {

        $bo = $this -> all_model -> getSecurity(2048);
        if (!$bo) {
            echo $this -> all_model -> getErr();
            return;
        }

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


        $this -> master2 -> view('product/ebay_view', $date);

        //flush();

    }


    function getEbayactive(){
        $sql="select * from accounttoken   ";
        $result =$this->db->query($sql);
        $itemarr="";

        foreach($result->result() as $row1){
         //   return;
            //echo $row1->accounttokenid;
            $tokencurrency=$row1->Currency;
            //flush();
            $totalnum="1";
            $xml=simplexml_load_string($this -> all_model ->  getEbaySellingListpre($row1->accounttokenid));
          // print_r($xml);
            $itemnum=@$xml->ActiveList->PaginationResult->TotalNumberOfEntries;

            if($itemnum >200){
                $count=$itemnum /200;
                $count2=$itemnum %200;
                if($count2 !=0){
                    $totalnum=$count+1;
                }else
                   $totalnum=$count;

            }
            $totalnum=floor($totalnum);
            $totalnum=$totalnum+1;

          //  echo " head :".$itemnum."   ".$totalnum;

            for($i=1;$i<$totalnum;$i++){

            $xml=simplexml_load_string($this -> all_model ->  getEbaySellingList($row1->accounttokenid,$i));
          // print_r($xml);
            if( $xml->ActiveList->ItemArray==null)
                continue;

            $ItemArray=$xml->ActiveList->ItemArray->Item;
            foreach($ItemArray as $row){
                $ItemID= $row->ItemID;

                if($itemarr==""){
                    $itemarr=$ItemID;
                }else{
                    $itemarr.=",". $ItemID;
                }
                $ListingType=$row->ListingType;
                $BuyItNowPrice=  $row->BuyItNowPrice;
                $currencyID=$BuyItNowPrice->attributes()->currencyID;
                $ListingDuration=$row->ListingDuration;
                $Quantity= $row->Quantity;
                $CurrentPrice= $row->SellingStatus->CurrentPrice;
                $Title=  $row->Title;
                $ShippingType= $row->ShippingDetails->ShippingType;
                $img= $row->PictureDetails->GalleryURL;
                $productid="";

                $sql="select productid from productonebay where ItemID='$ItemID'";
                $co=$this->db->query($sql)->num_rows();
                if($co >0)	{
                    $sql="select productid from productonebay where ItemID='$ItemID'";
                    $productrow=$this->db->query($sql)->row();

                    $sql="update productonebay set `on`='1' ,accounttokenid='$row1->accounttokenid'  where ItemID='$ItemID'";
                  //  echo $sql."<br >";
                    $this->db->query($sql);

                    //判斷必別是否吻合
                  //  $sql="select * from  productactive  where productactiveid='".$productrow->productid."' and currencyID ='".$currencyID."'";
                   // $co=$this->db->query($sql)->num_rows();
                    //if($co >0)	{
                        //吻合就更新資料
                        $sql=" update productactive set ebaytitle='$Title' ,picurl='$img' ,currencyID='$currencyID' , createtime=NOW() where productactiveid='$productrow->productid'  ";
                        $this->db->query($sql);
                        $productid=$productrow->productid;

                    //}else{
                        //不吻合新增資料
                      /*  $sql="insert into productactive (prodname,ebaytitle,picurl,StartPrice,PriceAUD,PriceGBP,ListingType,ListingDuration,Quantity,ShippingType,currencyID) values ('$Title','$Title','$img','$CurrentPrice','$CurrentPrice','$CurrentPrice','$ListingType','$ListingDuration','$Quantity','$ShippingType','$currencyID')";
                        $this->db->query($sql);
                        $productid=$this->db->insert_id();
                        $sql="insert into  productonebay values (null,'$productid','$row1->accounttokenid','$ItemID','1',NOW())";
                        $this->db->query($sql);

                        $productid=$productid;
                        */
                    //}


                }else{
                        $sql="insert into productactive (prodname,ebaytitle,picurl,StartPrice,PriceAUD,PriceGBP,ListingType,ListingDuration,Quantity,ShippingType,currencyID,createtime) values ('$Title','$Title','$img','$CurrentPrice','$CurrentPrice','$CurrentPrice','$ListingType','$ListingDuration','$Quantity','$ShippingType','$currencyID',NOW())";
                        $this->db->query($sql);
                        $productid=$this->db->insert_id();
                        $sql="insert into  productonebay values (null,'$productid','$row1->accounttokenid','$ItemID','1',NOW())";
                        $this->db->query($sql);

                        $productid=$productid;

                }

            }


                /*
                 *
                    //先尋找是否在產品列表
                    $sql="select productactiveid from productactive where ebaytitle like '%$Title%'";
                    $co=$this->db->query($sql)->num_rows();
                    if($co >0)	{

                        $productrow=$this->db->query($sql)->row();
                        $set="";
                        if($currencyID=="USD"){
                            $set=", StartPrice='$CurrentPrice'";
                        }else if($currencyID=="AUD"){
                            $set=", PriceAUD='$CurrentPrice'";
                        }else if($currencyID=="GBP"){
                            $set=", PriceGBP='$CurrentPrice'";
                        }


                        $sql="update productactive set ebaytitle='$Title', picurl ='$img',ListingType='$ListingType',ListingDuration='$ListingDuration',Quantity='$Quantity' ,ShippingType='$ShippingType' $set  where productactiveid='".$productrow->productactiveid."'";
                        $this->db->query($sql);
                       // echo $sql;

                        $sql="select productid from productonebay where ItemID like \"%$ItemID%\"";
                        $co=$this->db->query($sql)->num_rows();
                        if($co >0)	{

                            $sql="update productonebay set `on`='1' where ItemID='$ItemID'";
                            $this->db->query($sql);
                           // echo $sql;
                         }else{
                            $sql="insert into  productonebay values (null,'$productrow->productactiveid','$row1->accounttokenid','$ItemID','1',NOW())";
                            $this->db->query($sql);
                        }

                        $productid=$productrow->productactiveid;

                    }else{
                        ///如果完全沒有此產品自動增加
                 * */

              //  echo $currencyID.$ItemID."<br >";
            }

        }

        if($itemarr!=""){
            $sql="update productonebay set `on`='0' where ItemID not in ($itemarr)";
            $this->db->query($sql);
        }
       // echo $sql;

        redirect('ebay/eactive', 'refresh');



    }
    function category(){
        $bo = $this -> all_model -> getSecurity(8);
        if (!$bo) {
            echo $this -> all_model -> getErr();
            return;
        }

        $path = $this -> all_model -> getPathIndex();
        $date['currurl'] = $path[0];
        $date['url'] = $path[1];

        $date['menu'] = $this -> all_model -> getMenu($date['url'],8);

        $date['adminurl'] = $path[1] . "product/";
        $date['query'] = $this -> db -> get('category');

        $query =$this -> db -> get('category');
        $string="";
        foreach($query->result() as $row){
            if($string==""){
                $string=$row->categoryid;
            }else{
                $string.=",".$row->categoryid;
            }
        }
        $date['categoryid']=$string;
        $this -> master2 -> view('product/category_view', $date);

    }


   function getItemdes(){

       $xml=simplexml_load_string($this -> all_model ->  getEbaySellingListpre("27"));
       print_r($xml);
//      $xml= simplexml_load_string($this->all_model->updateproductebayitem("311","110138800745","23"));
  //      print_r($xml);

   }

    function getStore(){

        $accountid='19';

        $xml= $this -> all_model -> getStore($accountid);
        $xml=simplexml_load_string($xml);

        $order= $xml->Store->CustomCategories->CustomCategory;

        foreach($order as $row){
            echo $row->Name."<br >";
        }


     }
	

	function productcategory() {
		
		$bo = $this -> all_model -> getSecurity(8);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}

		$path = $this -> all_model -> getPathIndex();
		$date['currurl'] = $path[0];
		$date['url'] = $path[1];
		
		$date['menu'] = $this -> all_model -> getMenu($date['url'],8);
		
		$date['adminurl'] = $path[1] . "product/";
		$date['query'] = $this -> db -> get('category');
		$this -> master2 -> view('product/category_view', $date);

	}

	function productcate(){
	
		$bo = $this -> all_model -> getSecurity(8);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}

		$id = $this -> uri -> segment('3', 0);

		$path = $this -> all_model -> getPathIndex();
		$date['currurl'] = $path[0];
		$date['url'] = $path[1];
		
		$date['menu'] = $this -> all_model -> getMenu($date['url'],8);
		
		$date['adminurl'] = $path[1] . "product/";
		$sql="SELECT m.*,r1.companyname,r2.category FROM `product` m left join company r1 on m.companyid=r1.companyid left join category r2 on m.categoryid=r2.categoryid where m.categoryid='".$id."'";
		//echo $sql;
		$date['query'] = $this -> db -> query($sql);

		$this -> master2 -> view('product/cateproduct_view', $date);
	
	}

	public function category_add() {
		
		$bo = $this -> all_model -> getSecurity(8);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}
		$category = $this -> input -> get_post('category');
		$categoryno = $this -> input -> get_post('categoryno');
		
		$sql="select count(*) as count from category where categoryno='".$categoryno."' ";
//echo $sql;
		$query=$this->db->query($sql)->row();
		if($query->count >0){
			echo "代號重複<br><a href='javascript:history.back()'>back</a>";
			return;
		}		


		$sql = "insert into category (categoryno,category,createtime) values ('" . $categoryno . "','" . $category . "',NOW())";
		$this -> db -> query($sql);

		redirect('product/productcategory', 'refresh');
	}

	public function category_del() {
		
		$bo = $this -> all_model -> getSecurity(8);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}
		$id = $this -> input -> get_post('id');
		$sql = "delete from category where categoryid='" . $id . "'";
		$this -> db -> query($sql);
		redirect('product/productcategory', 'refresh');
	}

	function category_edit() {

		$bo = $this -> all_model -> getSecurity(8);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}
		$path = $this -> all_model -> getPath();
		$date['url'] = $path[0];
		$date['adminurl'] = $path[1];
		$date['menu'] = $this -> all_model -> getMenu($date['url'],8);
		$id = $this -> uri -> segment('3', '');
		$sql = "select * from category  where id='$id' order by sort asc";
		$date['category'] = $this -> db -> query($sql) -> row();
		$this -> master2 -> view('admin/categorydetail_view', $date);
	}

	public function category_update() {
		
		$bo = $this -> all_model -> getSecurity(8);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}

		$category = $this -> input -> get_post('o_category');
		$o_categoryno = $this -> input -> get_post('o_categoryno');
	    $sql="select count(*) as count from category where categoryno='".$o_categoryno."' ";
//echo $sql;
		$query=$this->db->query($sql)->row();
		if($query->count >1){
			echo "代號重複<br><a href='javascript:history.back()'>back</a>";
			return;
		}		
		

		$id = $this -> input -> get_post('id');
		$sql = "update category set categoryno='".$o_categoryno."', category='" . $category . "'  where categoryid='" . $id . "'";
		$this -> db -> query($sql);
		redirect('product/productcategory', 'refresh');
	}



	function product_adds() {
		
		$bo = $this -> all_model -> getSecurity(8);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}
		

		$sql = "insert into product (prodname,createtime) values ('',NOW())";
		$this -> db -> query($sql);
		$id = $this -> db -> insert_id();

		redirect("product/product_edit/" . $id, 'refresh');

	}
	

    function addSaveItem(){
        $bo = $this -> all_model -> getSecurity(8);
        if (!$bo) {
            echo $this -> all_model -> getErr();
            return;
        }

        $productid = $this -> input -> get_post('id');
        $category = $this -> input -> get_post('category');
        $condition = $this -> input -> get_post('condition');
        $Country = $this -> input -> get_post('Country');
        $PaymentMethods = $this -> input -> get_post('PaymentMethods');
        $PayPalEmailAddress = $this -> input -> get_post('PayPalEmailAddress');

       // $pricetype = $this -> input -> get_post('pricetype');

        $ListingDuration = $this -> input -> get_post('ListingDuration');
        $ReturnsAcceptedOption = $this -> input -> get_post('ReturnsAcceptedOption');
        $RefundOption = $this -> input -> get_post('RefundOption');
        $ReturnsWithinOption = $this -> input -> get_post('ReturnsWithinOption');
        $Description = $this -> input -> get_post('Description');
        $ShippingType = $this -> input -> get_post('ShippingType');
        $ShippingServicePriority = $this -> input -> get_post('ShippingServicePriority');
        $ShippingService = $this -> input -> get_post('ShippingService');
        $ShippingServiceCost = $this -> input -> get_post('ShippingServiceCost');
        $ListingType= $this -> input -> get_post('ListingType');
        $ShippingCostPaidByOption= $this -> input -> get_post('ShippingCostPaidByOption');
        $DispatchTimeMax= $this -> input -> get_post('DispatchTimeMax');


        $StartPrice = $this -> input -> get_post('StartPrice');
        $quantity = $this -> input -> get_post('quantity');
        $PriceAUD= $this -> input -> get_post('PriceAUD');
        $PriceGBP= $this -> input -> get_post('PriceGBP');

        $InternationalShippingService = $this -> input -> get_post('InternationalShippingService');
        $InternationalShippingServicePriority= $this -> input -> get_post('InternationalShippingServicePriority');
        $InternationalShippingServiceCost= $this -> input -> get_post('InternationalShippingServiceCost');
        $InternationalShippingServiceAdditionalCost= $this -> input -> get_post('InternationalShippingServiceAdditionalCost');
        $InternationalShipToLocation= $this -> input -> get_post('InternationalShipToLocation');
        $ebaytitle= $this -> input -> get_post('ebaytitle');

        if(mb_strlen($ebaytitle,'utf8') >80 ){
            echo "長度超過80<br><a href='javascript:history.back()'>back</a>";
            return;
        }


        $storecategory= $this -> input -> get_post('storecategory');
        $exclude= $this -> input -> get_post('exclude');
        $ProductReferenceID= $this -> input -> get_post('ProductReferenceID');
        $Location= $this -> input -> get_post('Location');
        $InternationalShippingService2 = $this -> input -> get_post('InternationalShippingService2');
        $InternationalShippingServicePriority2= $this -> input -> get_post('InternationalShippingServicePriority2');
        $InternationalShippingServiceCost2= $this -> input -> get_post('InternationalShippingServiceCost2');
        $InternationalShippingServiceAdditionalCost2= $this -> input -> get_post('InternationalShippingServiceAdditionalCost2');
        $InternationalShipToLocation2= $this -> input -> get_post('InternationalShipToLocation2');


        $ShippingServicePriority2 = $this -> input -> get_post('ShippingServicePriority2');
        $ShippingService2 = $this -> input -> get_post('ShippingService2');
        $ShippingServiceCost2 = $this -> input -> get_post('ShippingServiceCost2');


        $exlist="";
        if($exclude!=""){
            foreach(@$exclude as $ex){
               if($exlist==""){
                   $exlist=$ex;
               }else{
                   $exlist.=",".$ex;
               }
            }
        }

        $autopay= $this -> input -> get_post('autopay');
        if($autopay=="on"){
            $autopay="true";
        }else{
            $autopay="false";
        }

        $FreeShipping= $this -> input -> get_post('FreeShipping');
        if($FreeShipping=="on"){
            $FreeShipping="true";
        }else{
            $FreeShipping="false";
        }



        $PrivateListing= $this -> input -> get_post('PrivateListing');
        if($PrivateListing=="on"){
            $PrivateListing="true";
        }else{
            $PrivateListing="false";
        }

        /* $ean= $this -> input -> get_post('ean');
         $upc= $this -> input -> get_post('upc');
         $mpn= $this -> input -> get_post('mpn');
         $brand= $this -> input -> get_post('brand');
*/
        $pricetype= $this -> input -> get_post('pricetype');
        $InternationalShippingService2 = $this -> input -> get_post('InternationalShippingService2');
        $InternationalShippingServicePriority2= $this -> input -> get_post('InternationalShippingServicePriority2');
        $InternationalShippingServiceCost2= $this -> input -> get_post('InternationalShippingServiceCost2');
        $InternationalShippingServiceAdditionalCost2= $this -> input -> get_post('InternationalShippingServiceAdditionalCost2');
        $InternationalShipToLocation2= $this -> input -> get_post('InternationalShipToLocation2');
        $ShippingServicePriority2 = $this -> input -> get_post('ShippingServicePriority2');
        $ShippingService2 = $this -> input -> get_post('ShippingService2');
        $ShippingServiceCost2 = $this -> input -> get_post('ShippingServiceCost2');

        $ShippingServiceAdditionalCost=$this -> input -> get_post('ShippingServiceAdditionalCost');
        $ShippingServiceAdditionalCost2=$this -> input -> get_post('ShippingServiceAdditionalCost2');
        $ShippingCostPaidByOption="Buyer";
// 'brand'=>$brand, 'ean'=>$ean,'upc'=>$upc,'mpn'=>$mpn,
        $data = array(
            'ShippingServiceAdditionalCost'=>$ShippingServiceAdditionalCost, 'ShippingServiceAdditionalCost2'=>$ShippingServiceAdditionalCost2,
            'InternationalShippingService2'=>$InternationalShippingService2,'InternationalShippingServicePriority2'=>$InternationalShippingServicePriority2,'InternationalShippingServiceCost2'=>$InternationalShippingServiceCost2,'InternationalShippingServiceAdditionalCost2'=>$InternationalShippingServiceAdditionalCost2,'InternationalShipToLocation2'=>$InternationalShipToLocation2,
            'ShippingServicePriority2'=>$ShippingServicePriority2, 'ShippingService2'=>$ShippingService2, 'ShippingServiceCost2'=>$ShippingServiceCost2,
            'Location'=>$Location,'PrivateListing'=>$PrivateListing,'ProductReferenceID'=>$ProductReferenceID,'exclude'=> $exlist,'storecategory'=> $storecategory,'pricetype' => $pricetype,'AutoPay' => $autopay,'ebaytitle' => $ebaytitle,'PriceGBP' => $PriceGBP,'PriceAUD' => $PriceAUD,'FreeShipping' => $FreeShipping,'InternationalShipToLocation' => $InternationalShipToLocation,'InternationalShippingService' => $InternationalShippingService,'InternationalShippingServicePriority' => $InternationalShippingServicePriority,'InternationalShippingServiceCost' => $InternationalShippingServiceCost,'InternationalShippingServiceAdditionalCost' => $InternationalShippingServiceAdditionalCost,'DispatchTimeMax' => $DispatchTimeMax,'ShippingCostPaidByOption' => $ShippingCostPaidByOption,'ListingType' => $ListingType,'category' => $category,'ConditionID' => $condition,'Country' => $Country,  'PaymentMethods' => $PaymentMethods, 'PayPalEmailAddress' => $PayPalEmailAddress, 'StartPrice' => $StartPrice,  'Quantity' => $quantity, 'ListingDuration' => $ListingDuration, 'ReturnsAcceptedOption' => $ReturnsAcceptedOption, 'RefundOption' => $RefundOption, 'ReturnsWithinOption' => $ReturnsWithinOption, 'ReturnsDescription' => $Description, 'ShippingType' => $ShippingType, 'ShippingServicePriority' => $ShippingServicePriority, 'ShippingService' => $ShippingService, 'ShippingServiceCost' => $ShippingServiceCost);

        $this -> db -> where('productid', $productid);
        $this -> db -> update('product', $data);

        redirect("product/product_edit/" . $productid."#tabs-2", 'refresh');
    }

	
	function addItem(){
		$bo = $this -> all_model -> getSecurity(8);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}

		$productid = $this -> input -> get_post('id');
		$accounttokenid= $this -> input -> get_post('accounttokenid');
        $currency= $this -> input -> get_post('currency');
        $site= $this -> input -> get_post('site');



        $sql="select * from product where productid='$productid'";
        $query=$this->db->query($sql)->row();
        $pricetype=$query->pricetype;

		$xml="";
		if($pricetype=="auction"){
			$xml= $this -> all_model->AddItem($accounttokenid,$productid,$currency,$site);
		}else{
			$xml= $this -> all_model->AddFixPriceItem($accounttokenid,$productid,$currency,$site);
		}
		
	//	print_r($xml);
		
		$xml=simplexml_load_string($xml);
		if($xml->ItemID){

            $sql="select * from product where producutid='$productid'";
            $query=$this->db->query($sql);
            foreach($query->result() as $row){
                $sql="insert into productactive (prodname) values ('".$row->prodname."')";
                $this->db->query($sql);
                $newproductid=$this->db->insert_id();
            }



			$sql="insert into productonebay values ('','".$newproductid."','".$accounttokenid."','".$xml->ItemID."','1',NOW())";
		
			mysql_query($sql);
			//echo $xml->ItemID;
			redirect("product/product_edit/" . $productid, 'refresh');
		}else{
			
			if($xml->Ack=="Warning"){
		  foreach($xml->Errors as $row){
			echo $row->LongMessage."<br /><br />";
		  }
		}
	
		if($xml->Ack=="Failure"){
			foreach($xml->Errors as $row){
				echo $row->LongMessage."<br /><br />";
			}
		}
			
			
		}
		//
			
	}
	

	function product_edit_update() {
			
		$bo = $this -> all_model -> getSecurity(8);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}

        $authority=$this->session->userdata('authority');

		$id = $this -> input -> get_post('id');
		$prodname = $this -> input -> get_post('prodname');
		$model = $this -> input -> get_post('model');
		$brand = $this -> input -> get_post('brand');
		$imei = $this -> input -> get_post('imei');
		$ean = $this -> input -> get_post('ean');
		$upc = $this -> input -> get_post('upc');
		$sku = $this -> input -> get_post('sku');
		$mpn = $this -> input -> get_post('mpn');
		$imei = $this -> input -> get_post('imei');
		$spec = $this -> input -> get_post('spec');
		$feture = $this -> input -> get_post('feture');
		$companyid = $this -> input -> get_post('companyid');
		$categoryid = $this -> input -> get_post('categoryid');

        $temp1 = $this -> input -> get_post('temp1');
        $temp2 = $this -> input -> get_post('temp2');

        $qty=$this -> input -> get_post('qty');


     if (($authority & 128) == 128) {

         $shippingid = $this -> input -> get_post('shippingid');
         $amountother = $this -> input -> get_post('amountother');
         $currencyid = $this -> input -> get_post('currencyid');
         $amount = $this -> input -> get_post('amount');
         $gram = $this -> input -> get_post('gram');


         $sql="select * from product where productid='$id' and amount='$amount' and Quantity='$qty'";
         $count=$this->db->query($sql)->num_rows();

        if($count ==0){

         $sql="insert into product_inventory values (null,'$id','$amount','$qty',NOW())";
            $this->db->query($sql);
        }

     }



        $sql="select count(*) as count from product where sku='".$sku."' ";
//echo $sql;
		$query=$this->db->query($sql)->row();
		if($query->count >1){
			echo "sku重複<br><a href='javascript:history.back()'>back</a>";
			return;
		}

        $data = array('Quantity'=>$qty,'temp1' => $temp1,'temp2' => $temp2,'brand' => $brand,'categoryid' => $categoryid, 'companyid' => $companyid, 'prodname' => $prodname, 'model' => $model, 'ean' => $ean, 'upc' => $upc, 'sku' => $sku, 'mpn' => $mpn, 'imei' => $imei, 'spec' => $spec, 'feture' => $feture);


        if (($authority & 128) == 128) {
            $arr=array('usamount','ukamount','auamount','amountother');
		    $sql="update product set $arr[$currencyid]='".$amountother."' where productid='$id' ";
		    //echo $sql;
		    $this -> db ->query($sql);

         $data = array('Quantity'=>$qty,'shippingid' => $shippingid,  'currencyid' => $currencyid, 'amount' => $amount,'gram' => $gram,'temp1' => $temp1,'temp2' => $temp2,'brand' => $brand,'categoryid' => $categoryid, 'companyid' => $companyid, 'prodname' => $prodname, 'model' => $model, 'ean' => $ean, 'upc' => $upc, 'sku' => $sku, 'mpn' => $mpn, 'imei' => $imei, 'spec' => $spec, 'feture' => $feture);



        }

		$this -> db -> where('productid', $id);
		$this -> db -> update('product', $data);

		//$sql = "update member set passwd='" . $password . "',authority='$authority' ,  name='$name', updatetime='$updatetime' where accountid='$id'";
		//echo $sql;
		//$this -> db -> query($sql);
		redirect("product/product_edit/" . $id, 'refresh');

	}

	function product_addcompanyprice(){
		$bo = $this -> all_model -> getSecurity(8);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}

		$companyid = $this -> input -> get_post('companyid');
		$proid = $this -> input -> get_post('proid');
		$price = $this -> input -> get_post('price');
		
		if(!$price){
			echo "金額沒有輸入<br><a href='javascript:history.back()'>back</a>";
			return;
		}

		$sql="insert into prodcoprice (productid,companyid,createtime,price) values ('".$proid."','".$companyid."',NOW(),'".$price."')";
		$this -> db -> query($sql);
		redirect("product/product_edit/" . $proid, 'refresh');
	}

    function product_addsim(){
        $bo = $this -> all_model -> getSecurity(8);
        if (!$bo) {
            echo $this -> all_model -> getErr();
            return;
        }

        $productid = $this -> input -> get_post('productid');
        $prodname = $this -> input -> get_post('prodname');

        $model = $this -> input -> get_post('model');
        $brand = $this -> input -> get_post('brand');


        $sku = $this -> input -> get_post('sku');
        $upc = $this -> input -> get_post('upc');
        $ean = $this -> input -> get_post('ean');
        $mpn = $this -> input -> get_post('mpn');
        $amount = $this -> input -> get_post('cost');
        $qty = $this -> input -> get_post('qty');


        if(!$model || !$sku || !$qty){
            echo "沒有輸入<br><a href='javascript:history.back()'>back</a>";
            return;
        }

        $sql="select count(*) as count from product where sku='".$sku."' ";
//echo $sql;
        $query=$this->db->query($sql)->row();
        if($query->count >1){
            echo "sku重複<br><a href='javascript:history.back()'>back</a>";
            return;
        }

        $sql="insert into product (prodname,model,brand,sku,upc,ean,mpn,amount,Quantity,createtime,simprod) values ('".$prodname."',";
        $sql.="'".$model."','".$brand."','".$sku."','".$upc."','".$ean."','".$mpn."','".$amount."','".$qty."',NOW(),'".$productid."')";
        $this -> db -> query($sql);
        redirect("product/product_edit/" . $productid, 'refresh');

    }

	
	function product_companypricedel(){
		
		$bo = $this -> all_model -> getSecurity(8);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}

		$id = $this -> uri -> segment('3', 0);
		$proid = $this -> uri -> segment('4', 0);

		$this -> db -> query("delete from prodcoprice  where prodcopriceid='" . $id . "'");

		redirect("product/product_edit/" . $proid, 'refresh');
		
	}
	
	function product_companypriceupdate(){
		
		$bo = $this -> all_model -> getSecurity(8);
		if (!$bo) {
			echo "沒有權限<br>
		    <a href='javascript:history.back()'>back</a>";
			return;
		}
		
		$prodcopriceid = $this -> input -> get_post("prodcopriceid");
		$inventoryid = $this -> input -> get_post("inventoryid");

		$chk = $this -> input -> get_post("chk");
		$proid = $this -> input -> get_post("proid");
		
		$arr=explode(",",$prodcopriceid);
		//print_r($chk) ;
		
		foreach($arr as $ar){
			foreach($chk as $ch){
			if($ch==$ar){
			
				$price = $this -> input -> get_post('price'.$ar);
				
				$sql="update prodcoprice set price='".$price."'  where  prodcopriceid='".$ar."'";
				$this->db->query($sql);
				//echo $sql;
				}
			}
		}

		redirect('/product/product_edit/'.$proid, 'refresh');
		
		
	}
	

	function product_edit() {
		
		$bo = $this -> all_model -> getSecurity(8);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}
		 $date['authority']=$this->session->userdata('authority');
		$date['id'] = $this -> uri -> segment('3', 0);
		if($date['id'] ==""){
			$row= $this -> db -> query("select max(productid) as id from product ") -> row();
			$date['id']=$row->id;
				redirect("product/product_edit/" . $date['id'], 'refresh');
		}
		
		$path = $this -> all_model -> getPathIndex();
		$date['currurl'] = $path[0];
		$date['url'] = $path[1];
		$date['menu'] = $this -> all_model -> getMenu($date['url'],8);
		$date['adminurl'] = $path[1] . "product/";
		$date['row'] = $this -> db -> get_where('product', array('productid' => $date['id'])) -> row();
		$date['queryimg'] = $this -> db -> query("SELECT * FROM product_img where proid='" . $date['id'] . "'");

		$categoryid = $date['row'] -> categoryid;
		$sql = "select m.*,r1.price,r2.companyname,r2.companyid ,r1.prodcopriceid from product m left join prodcoprice r1 on m.productid=r1.productid left join company r2 on r1.companyid=r2.companyid  where m.productid='" . $date['id'] . "' and r1.prodcopriceid !=''";
	//	echo $sql;
		$date['querypro'] = $this -> db -> query($sql);
		$query = $this -> db -> query($sql);
			$string="";
			foreach($query->result() as $row){
				if($string==""){
					$string=$row->prodcopriceid;
				}else{
					$string.=",".$row->prodcopriceid;
				}
			}
				$date['prodcopriceid']=$string;
		
		
		$query=$this -> db -> query($sql);
		$where ="(0";
		foreach($query ->result() as $row ){
			
			if($row->companyid!="")
			$where .=",".$row->companyid."";
			
		}
		$where.=",0)";
	//	echo $where;
		
		 $sql = "select * from company where companyid not in ".$where;

       // echo $sql;
		$date['company']= $this -> db -> query($sql);


        $prodname=$date['row']->prodname;
        $sku=$date['row']->sku;
        $date['prodname']=$date['row']->prodname;
        $sql="select * from product where simprod ='".$date['id']."'";
     //   echo $sql;
        $date['querysim']=$this->db->query($sql);
        $query = $this -> db -> query($sql);
        $string="";
        foreach($query->result() as $row){
            if($string==""){
                $string=$row->productid;
            }else{
                $string.=",".$row->productid;
            }
        }
        $date['productidsim']=$string;


        $sql="select * from product_inventory where productid ='".$date['id']."'";
        $date['queryinventory']=$this->db->query($sql);


		$this -> master2 -> view('product/product_edit_view', $date);
	}

	function product_del() {
		
		$bo = $this -> all_model -> getSecurity(8);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}

		$id = $this -> uri -> segment('3', 0);
		$query = $this -> db -> query("select * from product_img where proid='" . $id . "'");
		foreach ($query->result() as $row) {
			if ($row -> url != "") {
				unlink($row -> url);
			}
		}
		$this -> db -> query("delete from product where productid='" . $id . "'");
		$this -> db -> query("delete from product_img  where proid='" . $id . "'");
		//$this -> db -> where('productid', $id);
		//$this -> db -> delete('product');

		redirect("product/product", 'refresh');
	}

	function product_add_img() {
			$bo = $this -> all_model -> getSecurity(8);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}
		

		$path = "./uploads/product/";
		$config['upload_path'] = $path;
		$config['allowed_types'] = 'gif|jpg|png|docx|doc|pdf|xls|ppt|pptx|zip|jpeg';
		$config['max_size'] = '100000';
		$config['max_width'] = '5000';
		$config['max_height'] = '5000';
		$id = $this -> input -> get_post('id');

		$this -> upload -> initialize($config);
		if (!$this -> upload -> do_upload()) {
			//錯誤發生時
			$error = array('error' => $this -> upload -> display_errors(), 'adminurl' => base_url() . "index.php/product/", 'url' => base_url() . "/application/views/");
			print_r($error);

		} else {

			// 成功上傳
			$da = $this -> upload -> data();
			$orgname = $da['orig_name'];
			$file = $da['file_name'];

			$this -> db -> query("INSERT INTO product_img (url, proid, name,createtime) values ('$path/" . $file . "', '" . $this -> input -> post('id') . "', '" . $orgname . "',NOW())");
			redirect('product/product_edit/' . $this -> input -> post('id'), 'refresh');
		}
	}

	function product_img_del() {
		
		$bo = $this -> all_model -> getSecurity(8);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}
		$id = $this -> input -> post("id");
		$proid = $this -> input -> post("proid");
		$query = $this -> db -> query("select * from product_img where id='" . $id . "'");

		foreach ($query->result() as $row) {
			unlink($row -> url);
		}
		$this -> db -> query("delete from product_img where id='" . $id . "'");
		redirect('/product/product_edit/' . $proid, 'refresh');
	}

    function productactive_add_img() {
        $bo = $this -> all_model -> getSecurity(8);
        if (!$bo) {
            echo $this -> all_model -> getErr();
            return;
        }


        $path = "./uploads/product/";
        $config['upload_path'] = $path;
        $config['allowed_types'] = 'gif|jpg|png|docx|doc|pdf|xls|ppt|pptx|zip|jpeg';
        $config['max_size'] = '100000';
        $config['max_width'] = '5000';
        $config['max_height'] = '5000';
        $id = $this -> input -> get_post('id');

        $accounttokenid= $this -> input -> get_post('accounttokenid');

        $this -> upload -> initialize($config);
        if (!$this -> upload -> do_upload()) {
            //錯誤發生時
            $error = array('error' => $this -> upload -> display_errors(), 'adminurl' => base_url() . "index.php/product/", 'url' => base_url() . "/application/views/");
            print_r($error);

        } else {

            // 成功上傳
            $da = $this -> upload -> data();
            $orgname = $da['orig_name'];
            $file = $da['file_name'];

            $this -> db -> query("INSERT INTO productactive_img (url, prodid, name,createtime) values ('$path/" . $file . "', '" . $this -> input -> post('id') . "', '" . $orgname . "',NOW())");
            redirect('product/updateebayitem/' . $id."/".$accounttokenid, 'refresh');
        }
    }

    function productactive_img_del() {

        $bo = $this -> all_model -> getSecurity(8);
        if (!$bo) {
            echo $this -> all_model -> getErr();
            return;
        }
        $id = $this -> input -> post("id");
        $accounttokenid= $this -> input -> get_post('accounttokenid');

        $proid = $this -> input -> post("proid");
        $query = $this -> db -> query("select * from productactive_img where productactive_imgid='" . $id . "'");

        foreach ($query->result() as $row) {
            unlink($row -> url);
        }
        $this -> db -> query("delete from productactive_img where productactive_imgid='" . $id . "'");
        redirect('product/updateebayitem/' . $id."/".$accounttokenid, 'refresh');
    }
	
	function product_updatebath(){
		
		$bo = $this -> all_model -> getSecurity(16);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}
		
		$productid = $this -> input -> get_post("productid");
		$chk = $this -> input -> get_post("chk");
		$arr=explode(",",$productid);
		//print_r($chk) ;

        if($chk ==null){
            echo "please select";
            return;
        }

		foreach($arr as $ar){

			foreach(@$chk as $ch){
				//echo $ch;
			if($ch==$ar){
				$prodname = $this -> input -> get_post('prodname'.$ar);
				$model = $this -> input -> get_post('model'.$ar);
				$sku = $this -> input -> get_post('sku'.$ar);
				$ean = $this -> input -> get_post('ean'.$ar);
				$upc = $this -> input -> get_post('upc'.$ar);
				$mpn = $this -> input -> get_post('mpn'.$ar);
                $Quantity=$this -> input -> get_post('Quantity'.$ar);
			

				$sql="update product set prodname='".$prodname."', model='".$model."' , sku='".$sku."', ean='".$ean."', upc='".$upc."', mpn='".$mpn."',Quantity='".$Quantity."' where productid='".$ar."'";
					//echo $sql;
				$query = $this -> db -> query($sql);
	
			}
			}
		}
	
	redirect('/product/product', 'refresh');

	}


    function product_ebayuploadbath(){
        $bo = $this -> all_model -> getSecurity(16);
        if (!$bo) {
            echo $this -> all_model -> getErr();
            return;
        }

        $productid = $this -> input -> get_post("productid");
        $chk = $this -> input -> get_post("chk3");
        $arr=explode(",",$productid);
        //print_r($chk) ;

       // echo count($chk);
        if($chk ==null){
            echo "沒有選擇";
            return;
        }
        foreach($arr as $ar){
            foreach(@$chk as $ch){
                //echo $ch;
                if($ch==$ar){
                    $productid =$ar;
                    $currency= "";
                    $site= "";
                    $accounttokenid= $this -> input -> get_post('accounttokenid');


                    if($accounttokenid =="del"){
                        $sql="delete from prodtoebay where productid='".$productid."'";
                        $this->db->query($sql);




                    }else{

                    $sql="select * from  accounttoken where accounttokenid='$accounttokenid'  ";
                    $query=$this->db->query($sql);
                    foreach($query->result() as $rowv){
                        $currency=$rowv->Currency;

                        if($currency=="USD"){
                            $site="US";
                        }else if($currency=="AUD"){
                            $site="Australia";
                        }else if($currency=="GBP"){
                            $site="UK";
                        }
                    }
                    $sql="select * from product where productid='$productid'";
                    $query=$this->db->query($sql)->row();
                    $pricetype=$query->pricetype;

                    $xml="";
                    if($pricetype=="auction"){
                        $xml= $this -> all_model->AddItem($accounttokenid,$productid,$currency,$site);
                    }else{
                        $xml= $this -> all_model->AddFixPriceItem($accounttokenid,$productid,$currency,$site);
                    }
                    //print_r($xml);

                    $xml=simplexml_load_string($xml);

                    if($xml->ItemID){


                    }else{
                        if($xml->Ack=="Warning"){
                            foreach($xml->Errors as $row){
                                // echo $row->LongMessage."<br /><br />";
                            }
                        }

                        if($xml->Ack=="Failure"){
                            foreach($xml->Errors as $row){
                                echo $row->LongMessage."<br /><br />";
                            }
                            return;
                        }
                    }
                    //
                    }
                }
            }
        }

        redirect("ebay/awaiting", 'refresh');

    }


    function product_addsimbath(){

        $bo = $this -> all_model -> getSecurity(16);
        if (!$bo) {
            echo $this -> all_model -> getErr();
            return;
        }

        $companylist="";
        $id = $this -> input -> get_post("productid");

        $productidsim = $this -> input -> get_post("productidsim");
        $chk = $this -> input -> get_post("chk");
        $modtype = $this -> input -> get_post("modtype");

        $arr=explode(",",$productidsim);
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

                        $qty = $this -> input -> get_post("qty".$ar);
                        $amount = $this -> input -> get_post("amount".$ar);

                        $sql="update product  set Quantity='$qty',amount='$amount' where  productid ='$ar'";

                        $this->db->query($sql);

                    }else  if($modtype==2){

                        $sql="delete from  product where productid='".$ar."'";
                        $this->db->query($sql);

                    }else{

                    }
                }
            }
        }


        redirect('/product/product_edit/'.$id, 'refresh');
        return;
    }


    function aa(){

        $AddressLine="Auhd ST, Bulding 6263Qatif DHL office";
      echo  substr($AddressLine,0,34);

        echo "<br /><br />";

       echo  $AddressLine2=substr($AddressLine,34,strlen($AddressLine)-34);

    }

    function category_bath(){

        $bo = $this -> all_model -> getSecurity(16);
        if (!$bo) {
            echo $this -> all_model -> getErr();
            return;
        }

        $companylist="";
        $productid = $this -> input -> get_post("categoryid");
        $chk = $this -> input -> get_post("chk");
        $modtype = $this -> input -> get_post("modtype");

        $arr=explode(",",$productid);
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

                        $no = $this -> input -> get_post("no".$ar);
                        $category = $this -> input -> get_post("category".$ar);

                        $sql="update category  set categoryno='$no',category='$category' where  categoryid ='$ar'";

                        $this->db->query($sql);

                    }else  if($modtype==2){

                        $sql="delete from  category where categoryid='".$ar."'";
                        $this->db->query($sql);

                    }else{

                    }
                }
            }
        }

            redirect('/product/category', 'refresh');
            return;

    }

	
	function product_bath(){
		
		$bo = $this -> all_model -> getSecurity(16);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}
		
		$companylist="";
		$productid = $this -> input -> get_post("productid");
		$chk = $this -> input -> get_post("chk");
		$modtype = $this -> input -> get_post("modtype");
		
		$arr=explode(",",$productid);
		//print_r($chk) ;

        if($chk ==""){
            echo "error";
            return;
        }
		foreach($arr as $ar){
			foreach(@$chk as $ch){
				//echo $ch;
			if($ch==$ar){
				if($modtype==1 ){
					if($companylist==""){
						$companylist=$ar;
					}else{
						$companylist.=",".$ar;
					}
				}else  if($modtype==3){

                    $sql="select count(prodtoebayid) as co from prodtoebay  where   productid='".$ar."'";
                   $row= $this->db->query($sql)->row();
                    if($row->co==0){
                       $sql="insert into  prodtoebay values (null,'".$ar."',NOW())";
                        $this->db->query($sql);
                       // echo $sql;
                     }

                }else if($modtype==4 ){

                    $Quantity = $this -> input -> get_post('Quantity'.$ar);
                    $avg = $this -> input -> get_post('avg'.$ar);


                    $sql="update  product set Quantity='".$Quantity."' ,avg='".$avg."' ,isIn='0' where productid='".$ar."'";
                    $this->db->query($sql);



                }else{
					$sql="delete from  product where productid='".$ar."'";
					$this->db->query($sql);	
				}
			}
			}
		}

        if($modtype==4 ){

            redirect('/product/product', 'refresh');
            return;
        }

		
		if($modtype==2){
			redirect('/product/product', 'refresh');			
			return;
		}


        if($modtype==3){
            redirect('/ebay/awaiting', 'refresh');
            return;
        }

      //  return;

        $path = $this -> all_model -> getPathIndex();
        $date['currurl'] = $path[0];
        $date['url'] = $path[1];
        $date['menu'] = $this -> all_model -> getMenu($date['url'],8);
        $date['adminurl'] = $path[1] . "product/";



		$sql="SELECT m.*,r1.companyname,r2.category FROM `product` m left join company r1 on m.companyid=r1.companyid left join category r2 on m.categoryid=r2.categoryid where m.productid in (".$companylist.")";
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


         if($modtype==1){

		    $this -> master2 -> view('product/productbath_view', $date);
        }
	}



    function updateebayitem(){
	
		$bo = $this -> all_model -> getSecurity(8);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}
		$date['authority']=$this->session->userdata('authority');
		$date['id'] = $this -> uri -> segment('3', 0);
        $date['accounttokenid'] = $this -> uri -> segment('4', 0);
        if($date['id'] ==""){
			echo "Access Denied";
            return;
			//$date['id']=$row->id;
			//redirect("product/product_edit/" . $date['id'], 'refresh');
		}
		
		$path = $this -> all_model -> getPathIndex();
		$date['currurl'] = $path[0];
		$date['url'] = $path[1];
		$date['menu'] = $this -> all_model -> getMenu($date['url'],8);
		$date['adminurl'] = $path[1] . "product/";

        $date['queryimg'] = $this -> db -> query("SELECT * FROM productactive_img where prodid='" . $date['id'] . "'");


        $this -> master2 -> view('product/updateebayitem_view', $date);
	
    }

    function ReviseItem(){
        $bo = $this -> all_model -> getSecurity(8);
        if (!$bo) {
            echo $this -> all_model -> getErr();
            return;
        }

        $productid = $this -> input -> get_post('productid');
        $accounttokenid = $this -> input -> get_post('accounttokenid');

        $accountitem = $this -> input -> get_post('accountitem');

        $arr=explode("-",$accountitem);
        $itemid=$arr[1];
        $accounttokenid=$arr[0];

        $spec= $this -> input -> get_post('spec');
        $category = $this -> input -> get_post('category');
        $condition = $this -> input -> get_post('condition');
        $Country = $this -> input -> get_post('Country');
        $PaymentMethods = $this -> input -> get_post('PaymentMethods');
        $PayPalEmailAddress = $this -> input -> get_post('PayPalEmailAddress');
        $quantity = $this -> input -> get_post('quantity');
        $ListingDuration = $this -> input -> get_post('ListingDuration');
        $ReturnsAcceptedOption = $this -> input -> get_post('ReturnsAcceptedOption');
        $RefundOption = $this -> input -> get_post('RefundOption');
        $ReturnsWithinOption = $this -> input -> get_post('ReturnsWithinOption');
        $Description = $this -> input -> get_post('Description');
        $ShippingType = $this -> input -> get_post('ShippingType');

        $ListingType= $this -> input -> get_post('ListingType');
        $DispatchTimeMax= $this -> input -> get_post('DispatchTimeMax');

        $StartPrice = $this -> input -> get_post('StartPrice');
        $PriceAUD= $this -> input -> get_post('PriceAUD');
        $PriceGBP= $this -> input -> get_post('PriceGBP');



        $ShippingServicePriority = $this -> input -> get_post('ShippingServicePriority');
        $ShippingService = $this -> input -> get_post('ShippingService');
        $ShippingServiceCost = $this -> input -> get_post('ShippingServiceCost');
        $ShippingServiceAdditionalCost=$this -> input -> get_post('ShippingServiceAdditionalCost');

        $ShippingServicePriority2 = $this -> input -> get_post('ShippingServicePriority2');
        $ShippingService2 = $this -> input -> get_post('ShippingService2');
        $ShippingServiceCost2 = $this -> input -> get_post('ShippingServiceCost2');
        $ShippingServiceAdditionalCost2=$this -> input -> get_post('ShippingServiceAdditionalCost2');

        $InternationalShippingService2 = $this -> input -> get_post('InternationalShippingService2');
        $InternationalShippingServicePriority2= $this -> input -> get_post('InternationalShippingServicePriority2');
        $InternationalShippingServiceCost2= $this -> input -> get_post('InternationalShippingServiceCost2');
        $InternationalShippingServiceAdditionalCost2= $this -> input -> get_post('InternationalShippingServiceAdditionalCost2');
        $InternationalShipToLocation2= $this -> input -> get_post('InternationalShipToLocation2');

        $InternationalShippingService = $this -> input -> get_post('InternationalShippingService');
        $InternationalShippingServicePriority= $this -> input -> get_post('InternationalShippingServicePriority');
        $InternationalShippingServiceCost= $this -> input -> get_post('InternationalShippingServiceCost');
        $InternationalShippingServiceAdditionalCost= $this -> input -> get_post('InternationalShippingServiceAdditionalCost');
        $InternationalShipToLocation= $this -> input -> get_post('InternationalShipToLocation');

        $ebaytitle= $this -> input -> get_post('ebaytitle');
        $storecategory= $this -> input -> get_post('storecategory');
        $exclude= $this -> input -> get_post('exclude');
        $ProductReferenceID= $this -> input -> get_post('ProductReferenceID');
        $Location= $this -> input -> get_post('Location');


        $exlist="";
        if($exclude!=""){
            foreach(@$exclude as $ex){
                if($exlist==""){
                    $exlist=$ex;
                }else{
                    $exlist.=",".$ex;
                }
            }
        }

        $autopay= $this -> input -> get_post('autopay');
        if($autopay=="on"){
            $autopay="true";
        }else{
            $autopay="fasle";
        }

        $FreeShipping= $this -> input -> get_post('FreeShipping');
        if($FreeShipping=="on"){
            $FreeShipping="true";
        }else{
            $FreeShipping="fasle";
        }

        $PrivateListing= $this -> input -> get_post('PrivateListing');
        if($PrivateListing=="on"){
            $PrivateListing="true";
        }else{
            $PrivateListing="fasle";
        }

        $ean= $this -> input -> get_post('ean');
        $upc= $this -> input -> get_post('upc');
        $mpn= $this -> input -> get_post('mpn');
        $brand= $this -> input -> get_post('brand');
        $sku= $this -> input -> get_post('sku');

        $ShippingCostPaidByOption="Buyer";

        $data = array('spec'=>$spec,'sku'=>$sku, 'brand'=>$brand, 'ean'=>$ean,'upc'=>$upc,'mpn'=>$mpn,
            'ShippingServiceAdditionalCost'=>$ShippingServiceAdditionalCost, 'ShippingServiceAdditionalCost2'=>$ShippingServiceAdditionalCost2,
            'InternationalShippingService2'=>$InternationalShippingService2,'InternationalShippingServicePriority2'=>$InternationalShippingServicePriority2,
            'InternationalShippingServiceCost2'=>$InternationalShippingServiceCost2,'InternationalShippingServiceAdditionalCost2'=>$InternationalShippingServiceAdditionalCost2,
            'InternationalShipToLocation2'=>$InternationalShipToLocation2,
            'ShippingServicePriority2'=>$ShippingServicePriority2, 'ShippingService2'=>$ShippingService2, 'ShippingServiceCost2'=>$ShippingServiceCost2,
            'Location'=>$Location,'PrivateListing'=>$PrivateListing,'ProductReferenceID'=>$ProductReferenceID,'exclude'=> $exlist,'storecategory'=> $storecategory,
            'AutoPay' => $autopay,'ebaytitle' => $ebaytitle,'PriceGBP' => $PriceGBP,'PriceAUD' => $PriceAUD,
            'FreeShipping' => $FreeShipping,'InternationalShipToLocation' => $InternationalShipToLocation,'InternationalShippingService' => $InternationalShippingService,
            'InternationalShippingServicePriority' => $InternationalShippingServicePriority,'InternationalShippingServiceCost' => $InternationalShippingServiceCost,
            'InternationalShippingServiceAdditionalCost' => $InternationalShippingServiceAdditionalCost,'DispatchTimeMax' => $DispatchTimeMax,
            'ShippingCostPaidByOption' => $ShippingCostPaidByOption,'ListingType' => $ListingType,'category' => $category,'ConditionID' => $condition,'Country' => $Country,
            'PaymentMethods' => $PaymentMethods, 'PayPalEmailAddress' => $PayPalEmailAddress, 'StartPrice' => $StartPrice,  'Quantity' => $quantity, 'ListingDuration' => $ListingDuration,
            'ReturnsAcceptedOption' => $ReturnsAcceptedOption, 'RefundOption' => $RefundOption, 'ReturnsWithinOption' => $ReturnsWithinOption, 'ReturnsDescription' => $Description,
            'ShippingType' => $ShippingType, 'ShippingServicePriority' => $ShippingServicePriority, 'ShippingService' => $ShippingService, 'ShippingServiceCost' => $ShippingServiceCost);
//////////////

        $this -> db -> where('productactiveid', $productid);
        $this -> db -> update('productactive', $data);
        $xml=   $this -> ebayapi_model ->ReviseItem($accounttokenid,$itemid,$productid);
        $xml=simplexml_load_string($xml);
       $ack= $xml->Ack;
        if($xml->Ack=="Failure"){
            foreach($xml->Errors as $row){
                echo $row->LongMessage."<br /><br />";
            }
            return;
        }else
            redirect("/product/updateebayitem/".$productid."/".$accounttokenid, 'refresh');
    }




    function product_ebay_pic_update(){
	
		$bo = $this -> all_model -> getSecurity(8);
		if (!$bo) {
			echo $this -> all_model -> getErr();
			return;
		}
		 
	   $productid =    $this -> uri -> segment('3', 0);

        $itemid =  $this -> uri -> segment('4', 0);
	     $accounttokenid =  $this -> uri -> segment('5', 0);
	
        $respXmlObj=$this->all_model->product_ebay_pic_update($accounttokenid,$productid,$itemid);

        $xml=simplexml_load_string($respXmlObj);

        //print_r($xml);

        $ack=$xml->Ack;

        if($ack=="Failure"){

            echo "Failure";

        }else{
            redirect("/product/updateebayitem/".$productid."/".$accounttokenid, 'refresh');

        }



	
    }

    public function excludelist() {

        $bo = $this -> all_model -> getSecurity(8);
        if (!$bo) {
            echo $this -> all_model -> getErr();
            return;
        }

        $path = $this -> all_model -> getPathIndex();
        $date['currurl'] = $path[0];
        $date['url'] = $path[1];
        $date['menu'] = $this -> all_model -> getMenu($date['url'],8);
        $date['adminurl'] = $path[1] . "product/";
        $sql="SELECT * from varlist where `type`='20'";
        //echo $sql;
        $date['query'] = $this -> db -> query($sql);

        $this -> master2 -> view('product/varlist_view', $date);


    }


    public function excludelist_adds() {

        $bo = $this -> all_model -> getSecurity(8);
        if (!$bo) {
            echo $this -> all_model -> getErr();
            return;
        }

        $key = $this -> input -> get_post('key');
        $value = $this -> input -> get_post('value');
        $sql="insert into  varlist value (null,'$key','$value','20')";

        $this -> db -> query($sql);

        redirect("/welcome/as5km435", 'refresh');

    }

    public function excludelist_update() {

        $bo = $this -> all_model -> getSecurity(8);
        if (!$bo) {
            echo $this -> all_model -> getErr();
            return;
        }

        $key = $this -> input -> get_post('key');
        $value = $this -> input -> get_post('value');
        $varlistid = $this -> input -> get_post('varlistid');

        $sql="update varlist set name='$key', no='$value' where varlistid='$varlistid'";

        $this -> db -> query($sql);

        redirect("/welcome/as5km435", 'refresh');

    }

    public function excludelist_del() {

        $bo = $this -> all_model -> getSecurity(8);
        if (!$bo) {
            echo $this -> all_model -> getErr();
            return;
        }


        $varlistid= $this -> uri -> segment('3', 0);
        $sql="delete from varlist where varlistid='$varlistid'";
        $this -> db -> query($sql);

        redirect("/welcome/as5km435", 'refresh');

    }

    function SuggestedCategories(){
        $path = $this -> all_model -> getPathIndex();
        $date['currurl'] = $path[0];
        $date['url'] = $path[1];
        $date['menu'] = $this -> all_model -> getMenu($date['url'],8);
        $date['adminurl'] = $path[1] . "product/";

        $bo = $this -> all_model -> getSecurity(8);
        if (!$bo) {
            echo $this -> all_model -> getErr();
            return;
        }
        $accountid= $this -> uri -> segment('3', 0);

        $sql="select count(accounttokenid) as co from accounttoken where accounttokenid='".$accountid."'";
       $co= $this->db->query($sql)->row()->co;

        if($co==0){
            $sql="select * from accounttoken limit 1";
          $row=  $this->db->query($sql)->row();
            $accountid=$row->accounttokenid;

        }

        $keyword= $this -> uri -> segment('4', 0);
        $keyword=str_replace("%20"," ",$keyword);

        $xml=$this -> all_model -> GetSuggestedCategories($accountid,$keyword);
       // echo $xml;
        $xml=simplexml_load_string($xml);
      //  print_r($xml);
        $query=$xml->SuggestedCategoryArray->SuggestedCategory;
        $date['query']=$query;
        $this -> master2 -> view('product/suggestcata_view', $date);


    }

    function FindProduct(){
        $path = $this -> all_model -> getPathIndex();
        $date['currurl'] = $path[0];
        $date['url'] = $path[1];
        $date['menu'] = $this -> all_model -> getMenu($date['url'],8);
        $date['adminurl'] = $path[1] . "product/";

        $bo = $this -> all_model -> getSecurity(8);
        if (!$bo) {
            echo $this -> all_model -> getErr();
            return;
        }

        $keyword= $this -> uri -> segment('3', 0);

        $keyword=str_replace("%20"," ",$keyword);

        $xml=$this -> all_model -> FindProducts($keyword);
      //  echo $xml;
        $xml=simplexml_load_string($xml);
        // print_r($xml);
        $query=$xml->Product;

        $date['query']=$query;

        $this -> master2 -> view('product/findproduct_view', $date);


    }


    function  product_toebaydel(){
        $bo = $this -> all_model -> getSecurity(16);
        if (!$bo) {
            echo $this -> all_model -> getErr();
            return;
        }

        $prodtoebayid= $this -> uri -> segment('3', 0);

          $sql="delete from prodtoebay where prodtoebayid='".$prodtoebayid."'";
        $this->db->query($sql);

        redirect("/ebay/awaiting", 'refresh');


    }

    function productonebayupdate_bath(){

        $bo = $this -> all_model -> getSecurity(16);
        if (!$bo) {
            echo $this -> all_model -> getErr();
            return;
        }

        $productid = $this -> input -> get_post("productid");
        $chk = $this -> input -> get_post("chk");
        $arr=explode(",",$productid);

        if($chk==null){
            echo "請選擇";
            return;
        }
        //print_r($chk) ;
        foreach($arr as $ar){
            foreach(@$chk as $ch){
                //echo $ch;
                if($ch==$ar){
                    $StartPrice = $this -> input -> get_post('StartPrice'.$ar);
                    $quantity = $this -> input -> get_post('Quantity'.$ar);
                    $PriceAUD= $this -> input -> get_post('PriceAUD'.$ar);
                    $PriceGBP= $this -> input -> get_post('PriceGBP'.$ar);
                    $accounttokenid= $this -> input -> get_post('accounttokenid');
                    $itemid= $this -> input -> get_post('itemid'.$ar);


                    $sql="update productactive set StartPrice='".$StartPrice."', Quantity='".$quantity."' , PriceAUD='".$PriceAUD."', PriceGBP='".$PriceGBP."' where productactiveid='".$ar."'";
                    $query = $this -> db -> query($sql);

                   // echo $sql."   " .$accounttokenid." ".$itemid;
                    $xml=   $this -> ebayapi_model ->ReviseItemPriceQua($accounttokenid,$itemid,$ar);
                    // echo $xml;
                    $xml=simplexml_load_string($xml);

                   // print_r($xml);
                    $ack= $xml->Ack;
                    if($xml->Ack=="Failure"){
                        foreach($xml->Errors as $row){
                            echo $row->LongMessage."<br /><br />";
                        }
                        return;
                    }else{
                        redirect('/ebay/eactive', 'refresh');
                    }

                }
            }
        }

    }

    function message(){


        $bo = $this -> all_model -> getSecurity(2048);
        if (!$bo) {
            echo $this -> all_model -> getErr();
            return;
        }

        $path = $this -> all_model -> getPathIndex();
        $date['currurl'] = $path[0];
        $date['url'] = $path[1];
        $date['menu'] = $this -> all_model -> getMenu($date['url'],2048);
        $date['adminurl'] = $path[1] . "product/";
        $date['authority']=$this->session->userdata('authority');

    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
