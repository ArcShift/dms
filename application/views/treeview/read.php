<div class="main-card mb-3 card">
    <div class="card-header">
        <a class="btn btn-primary fa fa-plus" href="<?php echo site_url($module.'/create')?>" title="Tambah"></a>
    </div>
    <div class="card-body">
        <form method="post">            
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $k => $d) { ?>
                        <tr>
                            <td><?php echo $k + 1 ?></td>
                            <td><?php echo $d['name'] ?></td>
                            <td><button class="btn btn-primary fa fa-search" title="Detail" name="detail" value="<?php echo $d['id']?>" formaction="<?php echo site_url($module.'/detail')?>"></button></td>
                        </tr>
                    <?php } ?>
                </tbody>
                <tfoot></tfoot>
            </table>
        </form>
    </div>
    <div class="box-footer"></div>
</div>