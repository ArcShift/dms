<?php
$n = 1;
$n2 = 0;
$komponen = [//header, title1, title2, aksi
    ['h' => 'gap_analisa', 't1' => 'Gap Analisa', 't2' => '', 'a' => 1],
    ['h' => 'training_awareness', 't1' => 'Training', 't2' => 'Training Awareness', 'a' => 1],
    ['h' => 'training_audit_internal', 't1' => '', 't2' => 'Training Audit Internal', 'a' => 1],
    ['h' => 'analisa_resiko', 't1' => 'Analisa Resiko', 't2' => '', 'a' => 2],
    ['h' => 'pengembangan_dokumen', 't1' => 'Pengembangan Dokumen', 't2' => '', 'a' => 1],
    ['h' => 'distribusi_dokumen', 't1' => 'Distribusi Dokumen', 't2' => '', 'a' => 1],
    ['h' => 'implementasi_dokumen', 't1' => 'Implementasi Dokumen', 't2' => '', 'a' => 1],
    ['h' => 'pentest', 't1' => 'Penetration Testing', 't2' => '', 'a' => 1],
    ['h' => 'bcp', 't1' => 'Business Continuity Planning', 't2' => '', 'a' => 1],
    ['h' => 'audit_internal', 't1' => 'Audit Internal Sistem', 't2' => '', 'a' => 2],
    ['h' => 'tinjauan_manajemen', 't1' => 'Tinjauan Manajemen', 't2' => '', 'a' => 2],
    ['h' => 'submit_dokumen', 't1' => 'Submit Dokumen', 't2' => '', 'a' => 1],
    ['h' => 'jadwal_audit', 't1' => 'Audit Eksternal Stage 1', 't2' => 'Jadwal Audit Eksternal Stage 1', 'a' => 1],
    ['h' => 'audit_plan', 't1' => '', 't2' => 'Audit Plan', 'a' => 1],
    ['h' => 'foto_audit', 't1' => '', 't2' => 'Foto Audit', 'a' => 1],
    ['h' => 'temuan_audit', 't1' => '', 't2' => 'Temuan Audit', 'a' => 1],
    ['h' => 'hasil_perbaikan_audit', 't1' => '', 't2' => 'Hasil Perbaikan Audit', 'a' => 1],
    ['h' => 'gap_analisa_audit', 't1' => 'Audit Eksternal Stage 2', 't2' => 'Gap Analisa 2021', 'a' => 1],
    ['h' => 'jadwal_audit2', 't1' => '', 't2' => 'Jadwal Audit Eksternal Stage 2', 'a' => 1],
    ['h' => 'audit_plan2', 't1' => '', 't2' => 'Audit Plan', 'a' => 1],
    ['h' => 'foto_audit2', 't1' => '', 't2' => 'Foto Audit', 'a' => 1],
    ['h' => 'temuan_audit2', 't1' => '', 't2' => 'Temuan Audit', 'a' => 1],
    ['h' => 'hasil_perbaikan_audit2', 't1' => '', 't2' => 'Hasil Perbaikan Audit', 'a' => 1],
//    ['h'=>'', 't1'=>'','t2'=>'','a'=>1],
];
?>
<style>
    .col-cust{
        width: 20%;
    }
</style>
<div class="card">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Timeline</th>
                    <th>Paramater</th>
                    <th>Aksi</th>
                    <th>Asal Data</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($komponen as $k => $km) { ?>
                    <tr>
                        <td><?= empty($km['t1']) ? '' : ++$n2 ?></td>
                        <td><?= $km['t1'] ?></td>
                        <?php if ($km['a'] == 2) { ?>
                            <td id="pasal_<?= $km['h'] ?>"></td>
                        <?php } else { ?>
                            <td><?= $km['t2'] ?></td>
                        <?php } ?>
                        <td>
                            <button class="btn btn-sm btn-outline-primary fa fa-edit" onclick="edit('<?= $k ?>')"></button> 
                        </td>
                        <td id="desc_<?= $km['h'] ?>"></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<!--MODAL EDIT-->
<div class="modal fade" id="modalEdit">
    <form id="formEdit" method="post">    
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input id="inputHeader" name="header" hidden="">
                    <input id="inputSetPasal" name="set_pasal" hidden="">
                    <div class="form-group" id="selectPasalGroup">
                        <label><b>Pasal Pemenuhan</b></label>
                        <select class="form-control" id="selectPasal" name="pasal">
                            <option value="">~ Pasal ~</option>
                            <?php foreach ($pasal as $k => $p) { ?>
                                <option value="<?= $p['id'] ?>"><?= $p['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label><b>Asal Data</b></label>
                        <textarea class="form-control" id="inputAsalData" name="asal_data"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-dismiss="modal">Tutup</button>
                    <button class="btn btn-primary" id="btnSubmit" name="tambah" value="ok">Simpan</button>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    var comp = <?= json_encode($komponen) ?>;
    var timeline
    function afterReady() {}
    getTimeline();
    function getTimeline() {
        $.getJSON('<?= site_url($module . '/get_for_admin') ?>', null, function (data) {
            timeline = data;
            for (var c of comp) {
                $('#desc_' + c.h).html(data['desc_' + c.h]);
                if (data['pasal_' + c.h] != undefined) {
                    var ps = $('#selectPasal option[value="' + data['pasal_' + c.h] + '"]').text();
                    $('#pasal_' + c.h).html(ps);
                }
            }
        });
    }
    function edit(idx) {
        var c = comp[idx];
        var m = $('#modalEdit');
        m.modal('show');
        m.find('.modal-title').html('Edit ' + (c.t2 == '' ? c.t1 : c.t2));
        $('#inputHeader').val(c.h);
        $('#inputSetPasal').val(c.a);
        $('#inputAsalData').val(timeline['desc_' + c.h]);
        if (c.a == 2) {
            $('#selectPasalGroup').show();
            $('#selectPasal').val(timeline['pasal_' + c.h]);
            console.log(timeline['pasal_' + c.h]);
        } else {
            $('#selectPasalGroup').hide();
        }
    }
    $('#formEdit').submit(function (e) {
        e.preventDefault();
        $('#modalEdit').modal('hide');
        $.post('<?= site_url($module . '/edit') ?>', $(this).serialize(), function (data) {
            modalStatus(data);
            getTimeline();
        });
    });
</script>