<div class="card">
    <div class="card-body">
        <table class="table">
            <thead >
                <tr>
                    <th>Pasal</th>
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th>Penjelasan</th>
                    <th style="width:100px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pasal as $k => $v) { ?>
                    <tr <?= empty($v['parent']) ? 'class="table-success"' : '' ?>>
                        <td><?= $v['name'] ?></td>
                        <td><?= $v['sort_desc'] ?></td>
                        <td style="white-space: pre-wrap"><?= $v['long_desc'] ?></td>
                        <td>-</td>
                        <td>
                            <a href="<?= site_url($module . '?detail=' . $v['id']) ?>" class="text-primary fa fa-info-circle" title="Detail" value="<?= $v['id'] ?>"></a>
                            <span class="text-primary fa fa-edit" title="Edit" onclick="edit(<?= $k ?>)"></span>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<div id="btm"></div>
<!--MODAL DETAIL-->
<div class="modal fade" id="modalDetail">
    <div class="modal-dialog modal-xl" role="document">
        <form>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pasal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Judul</label>
                        <input class="input-judul" readonly="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    function edit(idx) {
        var p = pasal[idx];
        var m = $('#modalDetail');
        m.modal('show');
        m.find('.modal-title').text(p.name);
        m.find('.input-judul').text(p.sort_desc);
    }
    pasal = <?= json_encode($pasal) ?>;
</script>
<?php
// print_r($pasal) ?>