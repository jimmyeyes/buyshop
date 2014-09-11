<!-- BEGIN SAMPLE TABLE PORTLET-->
<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-cogs"></i>
        </div>
        <div class="tools">
            <a href="javascript:;" class="collapse"></a>
            <a href="javascript:;" class="remove"></a>
        </div>
    </div>
    <div class="portlet-body flip-scroll">
        <table class="table table-striped table-bordered table-hover" id="sample_3">
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