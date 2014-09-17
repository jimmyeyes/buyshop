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
        <h2 class="box-header">商品類別維護</h2>
        <div class="box-content">
            <form id="categoryval" method="post" action='<?php echo $adminurl; ?>category_add'>
              類別代號   <input class="form-field 10px" type="text" name="categoryno"> 類別名稱<input class="form-field small" type="text" name="category">
                <input id="validate" type="submit"  class="button white" value="ADD">
            </form>
        </div>
        <br>
        <div class="box themed_box">
            <h2 class="box-header">商品類別維護</h2>
            <div class="box-content">
                <ul>
                    <?php foreach ($query->result() as $row): ?>
                        <li> <table ><tr><td width="500px">
                                        <form action='<?php echo $adminurl; ?>category_update' method='post'>
                                           <input  type="text" name="o_categoryno" class="form-field 10px" value='<?php echo $row->categoryno; ?>'>
                               <input  type="text" name="o_category" class="form-field width50" value='<?php echo $row->category; ?>'>

                                   <input type="hidden" value="<?php echo $row->categoryid; ?>" name='id'>
                                   <input type='submit'  class="button white" value='UPDATE'>
                                   </form>
                                        </td>
                                    <td>   <form action='<?php echo $adminurl; ?>category_del'   method='post'>
                                            <input type="hidden" value="<?php echo $row->categoryid; ?>" name='id' />
                                            <input type='submit'  class="button white" onClick="return check();" value='DEL'></form>
                                            </td></tr></table></li>

                    <?php endforeach; ?>

            </div>
            </ul>
        </div>
    </div>
   </div>