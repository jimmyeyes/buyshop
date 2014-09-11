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

                        <th>編號</th>
                        <th>名稱</th>


                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    $len=count($query);
                    if($len >0){
                    foreach ($query as $row): ?>

                                <tr class="">
                                    <td><?=$row->Category->CategoryID?></td>
                                    <td class="nCategory"><?=$row->Category->CategoryName?>  </td>

                                </tr>

                    <?php endforeach;
                    }?>

                    </tbody>
                </table>
            </div>

        </div>
    </div>
   </div>