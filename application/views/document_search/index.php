<?php
//$data = [];
?>
<div class="row">
    <div class="col-sm-3">
        <div class="main-card card">
            <form>                
                <div class="card-body">
                    <div class="form-group">
                        <label>Standar</label>
                        <select class="form-control" name="standar">
                            <option value="">-- -- --</option>
                            <?php foreach ($standar as $s) { ?>
                            <option value="<?= $s['id']?>" <?= $this->input->get('standar')==$s['id']?'selected':'' ?>><?= $s['name']?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group d-none">
                        <label>Pasal</label>
                        <input class="form-control" name="pasal" value="<?php echo $this->input->get('pasal') ?>">
                    </div>
                    <div class="form-group">
                        <label>Pembuat Dokumen</label>
                        <select class="form-control" name="creator">
                            <option value="">-- -- --</option>
                            <?php foreach ($creator as $c) { ?>
                            <option value="<?= $c['id']?>" <?= $this->input->get('creator')==$c['id']?'selected':'' ?>><?= $c['username']?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Distribusi</label>
                        <select class="form-control" name="distribusi">
                            <option value="">-- -- --</option>
                            <?php foreach ($distribusi as $d) { ?>
                            <option value="<?= $d['id']?>" <?= $this->input->get('distribusi')==$d['id']?'selected':'' ?>><?= $d['username']?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Judul Dokumen</label>
                        <input class="form-control" name="judul" value="<?php echo $this->input->get('judul') ?>">
                    </div>
                </div>
                <div class="card-footer ">
                    <button class="btn btn-primary fa fa-search" type="submit"> Cari</button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-sm-9">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <form method="post">
                    <table class="table data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Creator</th>
                                <th class="text-center <?= $this->input->get('distribusi')?'d-none':''?>">Distribusi</th>
                                <!--<th>-</th>-->
                                <!--<th>-</th>-->
                                <!--<th>*</th>-->
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $k => $r) { ?>
                                <tr>
                                    <td><?php echo $k + 1 ?></td>
                                    <td><?php echo $r['judul'] ?></td>
                                    <td><?php echo $r['username'] ?></td>
                                    <td class="text-center <?= $this->input->get('distribusi')?'d-none':''?>"><div class="badge badge-<?= $r['distribusi']==0?'danger':'success' ?>"><?= $r['distribusi'] ?></div></td>
<!--                                    <td>
                                        <a class="btn btn-primary fa fa-eye" href="" title="Lihat Detail" name="detail"></a>
                                    </td>-->
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function afterReady() {
        $('.dataTables_filter').addClass('d-none');
    }
</script>
