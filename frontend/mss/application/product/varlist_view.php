<?= $menu ?>
<script>

</script>
<div id="subnavbar">
</div>
<div id="content">

    <div class="box themed_box">
        <h2 class="box-header">排除區域設定 </h2>
        <div class="box-content">


            <?php echo form_open_multipart('product/excludelist_adds'); ?>
            key
            <input class="form-field small" type="text" size="10" name="key">
          value  <input class="form-field small" type="text" size="10" name="value">
            <input type="submit" class="button white" value="ADD">
            </form>



            <table class="display" id="tabledata">
                    <thead>
                    <tr>
                        <th></th>

                        <th>VALUE</th>
                        <th>KEY</th>


                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i = 0;
                    foreach ($query->result() as $row) {
                        $i++;
                        $bgColor = ($i % 2 == 0) ? 'bgColor' : '';
                        ?>
                        <tr class="<?= $bgColor; ?>">
                            <form action="<?=$url?>product/excludelist_update" method="post">


                            <td class="nCategory"><a href="<?=$url?>product/excludelist_del/<?=$row->varlistid?>">DEL</a>  </td>

                            <td class="nCategory"> <input  type="text"  value="<?=$row->no?>" name="value" />  </td>

                            <td class="nCategory"> <input type="text"  value="<?=$row->name?>" name="key" />  <input type="hidden" value="<?=$row->varlistid?>" name="varlistid" />
                                <input type="submit" class="button themed" value="Update">

                            </td>


                            </form>
                        </tr>
                    <? }
                    ?>
                    </tbody>
                </table>



            <div class="clear"></div>
        </div>
    </div>

</div>