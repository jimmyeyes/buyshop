<?= $menu ?>
<script>
function check()
{
if (!confirm("確認刪除!"))
return false;
}
</script>

<div id="subnavbar">
</div>
<div id="content">
    <div class="box themed_box">

        <div class="box themed_box">
            <h2 class="box-header"></h2>
            <div class="box-content">
                <table class="display" id="tabledata">
                    <thead>
                    <tr>

                        <th>DomainName</th>
                        <th>Title</th>

                        <th>Product Reference</th>
                        <th>URL</th>
                        <th>StockPhotoURL</th>


                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    $len=count($query);
                    if($len >0){
                    foreach ($query as $row): ?>

                                <tr class="">
                                    <td><?=$row->DomainName?></td>
                                    <td><?=$row->Title?></td>
                                    <td><?
                                        echo  $row->ProductID;

                                        ?></td>
                                    <td class="nCategory"><a href="<?=$row->DetailsURL?>" target="_blank">Click</a>  </td>
                                    <td class="nCategory"><a href="<?=$row->StockPhotoURL?>" target="_blank">Click</a>  </td>

                                </tr>

                    <?php endforeach;
                    }?>

                    </tbody>
                </table>
            </div>

        </div>
    </div>
   </div>