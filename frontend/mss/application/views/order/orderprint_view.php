<style>
    @media print and (width: 10.2cm) and (height: 20cm) {
        @page {
            margin: 0;
        }
    }
    .pos1{
        position:relative;
        top:2px;
        left:0px;
    }
    .pos2{
        position:relative;
        top:2px;
        left:0px;
    }
    .pos3{
        position:relative;
        top:2px;
        left:0px;
    }
  
</style>

<div class="pos1">
<?=$orderlistid?>-<?=$sku?> <?=$orderdate?>  Qty:X<?=$count?>
</div>
<div class="pos2">
<b>From</b>:<?=$name?><br />
<?=$addr?><br />
<?=$city?><br />
<?=$country." ,".$zipcode?><br />
(TEL) <?=$phone?><br />
</div>
<br />
<div class="pos3">
<b>To</b>:<?=$name2?><br />
<?=$addr2?><br />
<?=$city2?><br />
<?=$country2." ,".$zipcode2?><br />
(TEL) <?=$phone2?><br />
</div>