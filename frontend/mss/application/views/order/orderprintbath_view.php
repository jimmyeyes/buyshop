

<style type='text/css'>
    body {
        margin: 0;
        padding: 0;
        background-color: #FAFAFA;
        font: 12pt "Tahoma";
    }
    * {
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }
    .page {
        width: 10.2cm;
        min-height:  19cm;
        padding: 1cm;
        margin: 0cm auto;
        border: 1px #D3D3D3 solid;
        border-radius: 5px;
        background: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }

    @page {

        margin: 0;
    }
    @media print {
        .page {
            margin: 0;
            border: initial;
            border-radius: initial;
            width: initial;
            min-height: initial;
            box-shadow: initial;
            background: initial;
            page-break-after: always;
        }
    }
</style>

<script type='text/javascript'>//<![CDATA[
    window.onload=function(){
        window.print();
    }//]]>

</script>

<?

$arr=explode(",",$orderlistidarr);
$i=1;
foreach($arr as $ar){

   // echo $i;
    $sql="select * from accounttoken order by  accounttokenid asc limit 1";
    $row=$this->db->query($sql)->row();

    $sql="select r1.*,m.itemidarr,m.transactionidarr from orderlist m  left join customerlist r1 on m.BuyerUserID =r1.BuyerUserID where m.orderlistid in ($ar)";
    $row2=$this->db->query($sql)->row();

    $orderlistid=$ar;
    $name2=$row2->Name;
    $addr2=$row2->Street1;
    $city2=$row2->CityName;
    $zipcode2=$row2->PostalCode;
    $phone2=$row2->Phone;
    $country2=$row2->Country;

    $itemarr=explode(',',$row2->itemidarr);
    $count=count($itemarr);


    if($row2->itemidarr=="" && $row2->transactionidarr=="")
        continue;

    $sql="select * from orderlistprod where orderlistid='$ar' and ItemID in ($row2->itemidarr) and TransactionID in ($row2->transactionidarr)";
    $row3=$this->db->query($sql)->row();

    $name=$row->name;
    $addr=$row->addr;
    $zipcode=$row->zipcode;
    $phone=$row->phone;
    $country=$row->country;
    $sku=$row3->SKU;
    $city=$row->city;

    if($i==1){

    ?>
    <div class="page">
    <?
    }
    ?>

    <?=$orderlistid?>-<?=$sku?>  Qty:X<?=$count?><br />
    <b>From</b>:<?=$name?><br />
    <?=$addr?><br />
    <?=$city?><br />
    <?=$country." ,".$zipcode?><br />
    (TEL) <?=$phone?><br />

    <br />


    <?
?>

    <b>To</b>:<?=$name2?><br />
    <?=$addr2?><br />
    <?=$city2?><br />
    <?=$country2." ,".$zipcode2?><br />
    (TEL) <?=$phone2?><br />
<br /><br />
    <?
    if($i==2){
        $i=0;
        ?>
        </div>
    <?
    }
    ?>

<?
$i++;
}
?>

