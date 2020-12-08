<div class="main-card mb-3 card">
    <div class="card-header">
        <?php if ($activeModule['acc_create']) { ?>
            <a class="btn btn-outline-primary btn-sm fa fa-plus" style="text-transform: none" href="<?php echo site_url($module . '/create') ?>" title="Tambah"> Tambah <?= $activeModule['title'] ?></a>
        <?php } ?>
    </div>
    <div class="card-body">
        <form method="post">
            <table class="table data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th class="text-center">Pasal & Ayat</th>
                        <?php if ($this->session->userdata('user')['role'] == 'admin') { ?>
                            <th class="text-center">Perusahaan</th>
                        <?php } ?>
                        <th>Created by</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $k => $d) { ?>
                        <tr>
                            <td><?php echo $k + 1 ?></td>
                            <td><?php echo $d['name'] ?></td>
                            <td class="text-center"><span class="badge badge-info"><?php echo $d['detail'] ?></span></td>
                            <?php if ($this->session->userdata('user')['role'] == 'admin') { ?>
                                <td class="text-center"><div class="badge badge-info"><?php echo $d['used'] ?></div></td>
                            <?php } ?>
                            <td><?php echo $d['user'] ?></td>
                            <td>
                                <button class="btn btn-outline-primary btn-sm fa fa-search" title="Detail" name="detail" value="<?php echo $d['id'] ?>" formaction="<?php echo site_url($module . '/detail') ?>"></button>
                                <button class="btn btn-outline-primary btn-sm fa fa-edit" title="Edit" name="detail"></button>
                                <?php if (!$d['detail'] & !$d['used']) { ?>
                                    <?php if ($activeModule['acc_delete']) { ?>
                                        <button class="btn btn-outline-danger btn-sm fa fa-trash" title="Hapus" name="initHapus" value="<?php echo $d['id'] ?>" formaction="<?php echo site_url($module . '/delete') ?>"></button>
                                    <?php } ?>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
                <tfoot></tfoot>
            </table>
        </form>
    </div>
    <div class="box-footer"></div>
</div>
<div class="modal fade" id="modalDetailJadwal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Jadwal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                DETAIL
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btn-batal" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-danger btn-hapus" onclick="hapusJadwal()">Hapus</button>
            </div>
        </div>
    </div>
</div>
