<?php
$activeStandard = $this->session->userdata('activeStandard');
$module = 'users/dashboard/'
?>
<style>
    #tableDistribusi_paginate{
        margin-top: 20px;
    }
</style>
<script type="text/javascript" src="<?= base_url('assets/js/detect-zoom.min.js') ?>"></script>
<!--MODAL TUGAS-->
<div class="modal fade" id="modalTugas">
    <div class="modal-dialog" role="document">
        <form id="formTugas">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Tugas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <dl>
                        <dt>Tugas</dt>
                        <dd id="tugas-nama">value</dd>
                    </dl>
                    <dl>
                        <dt>Tanggal Jadwal</dt>
                        <dd id="tugas-tanggal">value</dd>
                    </dl>
                    <dl>
                        <dt>Dokumen</dt>
                        <dd id="tugas-dokumen">value</dd>
                    </dl>
                    <dl>
                        <dt>Form Terkait</dt>
                        <dd id="tugas-form-terkait">value</dd>
                    </dl>
                    <dl>
                        <dt>Sifat</dt>
                        <dd id="tugas-sifat">value</dd>
                    </dl>
                    <dl>
                        <dt>PIC Pelaksana</dt>
                        <dd id="tugas-pic">value</dd>
                    </dl>
                    <dl>
                        <dt>Status</dt>
                        <dd id="tugas-status">value</dd>
                    </dl>
                    <dl>
                        <dt>Preview Dokumen</dt>
                        <dd id="tugas-preview">value</dd>
                    </dl>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php
$g2 = json_decode($progressImp);
$pImp = json_decode($pemenuhan);
?>
<div class="row">
    <div class="col-sm-6">
        <div class="card mb-3 widget-content bg-midnight-bloom">
            <div class="widget-content-wrapper text-white">
                <div class="widget-content-left">
                    <div class="widget-heading">Dokumen</div>
                    <div class="widget-subheading">Pembuatan dokumen</div>
                </div>
                <div class="widget-content-right">
                    <div class="widget-numbers text-white"><span id="averageDoc"></span>%</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card mb-3 widget-content bg-arielle-smile">
            <div class="widget-content-wrapper text-white">
                <div class="widget-content-left">
                    <div class="widget-heading">Implementasi</div>
                    <div class="widget-subheading">Penerapan dokumen</div>
                </div>
                <div class="widget-content-right">
                    <div class="widget-numbers text-white"><span id="averageImp"></span>%</div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h5 class="card-title">Nilai Pemenuhan Dokumen dan Implementasi</h5>
                <canvas id="chartPemenuhan"></canvas>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-lg-6">
        <div class="mb-3 card div-zoom">
            <div class="card-header-tab card-header-tab-animation card-header">
                <div class="card-header-title">
                    <i class="header-icon lnr-apartment icon-gradient bg-love-kiss"> </i>
                    Progres Implementasi
                </div>
                <!-- <div class="btn-actions-pane-right">
                    <button type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" class="mb-2 mr-2 dropdown-toggle btn btn-outline-secondary btn-sm">2021</button>
                    <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu">
                        <h5 tabindex="-1" class="dropdown-header">2021</h5>
                        <div tabindex="-1" class="dropdown-divider"></div>
                        <button type="button" tabindex="0" class="dropdown-item">2020</button>
                        <div tabindex="-1" class="dropdown-divider"></div>
                        <button type="button" tabindex="0" class="dropdown-item">2019</button>
                    </div>
                </div> -->
            </div>
            <div class="tab-content">
                <div class="tab-pane fade active show" id="tab-eg-55">
                    <div class="card-body">
                        <canvas id="chartProgressImp"></canvas>
                    </div>
                </div>
                <div class="pt-2 card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="widget-content">
                                <div class="widget-content-outer">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left">
                                            <div class="widget-numbers fsize-3 text-muted"><?= $g2[1]->percent ?>%</div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="text-muted opacity-6">Terlambat</div>
                                        </div>
                                    </div>
                                    <div class="widget-progress-wrapper mt-1">
                                        <div class="progress-bar-sm progress-bar-animated-alt progress">
                                            <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="<?= $g2[1]->percent ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $g2[1]->percent ?>%;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="widget-content">
                                <div class="widget-content-outer">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left">
                                            <div class="widget-numbers fsize-3 text-muted"><?= $g2[4]->percent ?>%</div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="text-muted opacity-6">Selesai</div>
                                        </div>
                                    </div>
                                    <div class="widget-progress-wrapper mt-1">
                                        <div class="progress-bar-sm progress-bar-animated-alt progress">
                                            <div class="progress-bar bg-success" role="progressbar" aria-valuenow="<?= $g2[4]->percent ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $g2[4]->percent ?>%;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="widget-content">
                                <div class="widget-content-outer">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left">
                                            <div class="widget-numbers fsize-3 text-muted"><?= $g2[5]->percent ?>%</div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="text-muted opacity-6">Mendatang</div>
                                        </div>
                                    </div>
                                    <div class="widget-progress-wrapper mt-1">
                                        <div class="progress-bar-sm progress-bar-animated-alt progress">
                                            <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="<?= $g2[5]->percent ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $g2[5]->percent ?>%;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="widget-content">
                                <div class="widget-content-outer">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left">
                                            <div class="widget-numbers fsize-3 text-muted"><?= $g2[2]->percent ?>%</div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="text-muted opacity-6">Hari Ini</div>
                                        </div>
                                    </div>
                                    <div class="widget-progress-wrapper mt-1">
                                        <div class="progress-bar-sm progress-bar-animated-alt progress">
                                            <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="<?= $g2[2]->percent ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $g2[2]->percent ?>%;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-6">
        <div class="mb-3 card div-zoom">
            <div class="card-header-tab card-header">
                <div class="card-header-title">
                    <!--<i class="header-icon lnr-rocket icon-gradient bg-tempting-azure"> </i>-->
                    Distribusi Dokumen dan Implementasi
                </div>
                <!--<div class="btn-actions-pane-right"></div>-->
            </div>
            <div class="tab-content">
                <div class="tab-pane fade active show">
                    <div class="card-body">
                        <table class="mb-0 table table-striped" id="tableDistribusi">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Unit Kerja</th>
                                    <th class="text-center">Dokumen</th>
                                    <th class="text-center">Implementasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($distribusi2 as $k => $d) { ?>
                                    <tr>
                                        <th><?= $k + 1 ?></th>
                                        <td><?= $d['name'] ?></td>
                                        <td class="text-center"><?= $d['doc'] ?></td>
                                        <td class="text-center"><?= $d['imp'] ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-xl-4">
        <div class="card mb-3 widget-content">
            <div class="widget-content-outer">
                <div class="widget-content-wrapper">
                    <div class="widget-content-left">
                        <div class="widget-heading">Personil</div>
                        <div class="widget-subheading">Personil yang terdaftar</div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-success"><?= $countPersonil ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-4">
        <div class="card mb-3 widget-content">
            <div class="widget-content-outer">
                <div class="widget-content-wrapper">
                    <div class="widget-content-left">
                        <div class="widget-heading">Unit Kerja</div>
                        <div class="widget-subheading">Unit kerja terkait</div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-warning"><?= $countUnitKerja ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-4">
        <div class="card mb-3 widget-content">
            <div class="widget-content-outer">
                <div class="widget-content-wrapper">
                    <div class="widget-content-left">
                        <div class="widget-heading">Pasal</div>
                        <div class="widget-subheading">Pasal aktif yang diterapkan</div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-danger"><?= count($pImp) ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header">
                <span id="periodeTugasTitle"></span>
                <div class="btn-actions-pane-right">
                    <div role="group" class="btn-group-sm btn-group">
                        <button class="btn btn-focus" onclick="periodeTugas('<?= date('Y-m-d') ?>', 'Hari')">Hari ini</button>
                        <button class="btn btn-focus" onclick="periodeTugas('<?= date('Y-m') ?>', 'Bulan')">Bulan ini</button>
                        <button class="btn btn-focus" onclick="periodeTugas('<?= date('Y') ?>', 'Tahun')">Tahun ini</button>
                    </div>
                </div>
            </div>
            <?php
            // menghitung tugas selesai
            $totalSelesai = 0;
            foreach ($listTugas as $k => $t) {
                if ($t['upload_date'] != null) {
                    $totalSelesai++;
                }
            }
            ?>
            <div class="card-body">Total Tugas: <?= count($listJadwal) ?>, Selesai: <?= $totalSelesai ?>
                <div class="table-responsive">
                    <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="tableTugas">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Personil</th>
                                <th class="text-center">Tugas</th>
                                <th class="text-center">Tanggal</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($listJadwal as $k => $j) { ?>
                                <tr>
                                    <td class="text-center text-muted"><?= $k + 1 ?></td>
                                    <td>
                                        <ul>
                                            <?php foreach ($j->tugas->pelaksana as $p) { ?>
                                                <li>
                                                    <b><?= $p->fullname ?></b>
                                                    (<?= $p->unit_kerja ?>)
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </td>
                                    <td class="text-center"><?= $j->tugas->nama ?></td>
                                    <td class="text-center"><?= $j->tanggal ?></td>
                                    <?php
                                    $status = '-';
                                    $statusString = '-';
                                    if ($j->upload_date > $j->tanggal) {
                                        $status = '<div class="badge badge-danger">Terlambat</div>';
                                        $statusString = 'Terlambat';
                                    } else if ($j->upload_date == null) {
                                        $status = '<div class="badge badge-info">Menunggu</div>';
                                        $statusString = 'Menunggu';
                                    } else {
                                        $status = '<div class="badge badge-success">Selesai</div>';
                                        $statusString = 'Selesai';
                                    }
                                    $url_document = '-';
//                                    if ($j->file !== null) {
//                                        $url_document = $t['file'];
//                                    } else if ($t['url'] !== null) {
//                                        $url_document = $t['url'];
//                                    }
                                    // form terkait
                                    $formTerkait = '';
                                    $this->db->reset_query();
//                                    $tugas = $this->db->select('*')->from('tugas')->where('id', $t['id_tugas'])->get()->row();
//                                    if ($tugas->form_terkait) {
//                                        $formTerkait = $this->db->select('*')->from('document')->where('id', $tugas->form_terkait)->get()->row()->judul;
//                                    }
                                    ?>
                                    <td class="text-center">
                                        <?= $status ?>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-primary btn-sm" 
                                                onclick="detailTugas(
                                                                '<?= $j->tugas->nama ?>',
                                                                '<?= $j->tanggal ?>',
                                                                '<?php // $t['judul'] ?>',
                                                                '<?php // $formTerkait ?>',
                                                                '<?= $j->tugas->sifat ?>',
                                                                '<?php // $t['name'] ?>',
                                                                '<?= $statusString ?>',
                                                                '<?php // $url_document ?>'
                                                                )">Detail Tugas</button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="d-block text-center card-footer"></div>
        </div>
    </div>
</div>
<script>
//        var zoom = detectZoom.zoom();
//        var device = detectZoom.device();
//        if (zoom > 0.7) {
//            $('.div-zoom').css('height', '560px');
//            console.log('zoom');
//        }
//        console.log(zoom, device);
    var pemenuhan = <?= $pemenuhan ?>;
    var label = [];
    var doc = [];
    var hope = [];
    var imp = [];
    for (var i = 0; i < pemenuhan.length; i++) {
        var p = pemenuhan[i];
        label.push(p.name);
        doc.push(p.pemenuhanDoc);
        imp.push(p.pemenuhanImp);
        hope.push((p.hope == null ? 70 : p.hope));
    }
    $('#averageDoc').text(average(doc));
    $('#averageImp').text(average(imp));
    chart = new Chart(document.getElementById('chartPemenuhan'), {
        type: 'radar',
        data: {
            labels: label,
            datasets: [{
                    label: 'Harapan',
                    data: hope,
                    backgroundColor: 'rgba(255, 0, 0, 0.2)',
                    borderColor: 'rgb(255, 0, 0)',
                    pointBackgroundColor: 'rgb(255, 0, 0)',
                }, {
                    label: 'Dokumen',
                    data: doc,
                    backgroundColor: 'rgba(0, 0, 255, 0.2)',
                    borderColor: 'rgb(0, 0, 255)',
                    pointBackgroundColor: 'rgb(0, 0, 255)',
                }, {
                    label: 'Implementasi',
                    data: imp,
                    backgroundColor: 'rgba(255, 255, 0, 0.2)',
                    borderColor: 'rgb(255, 255, 0)',
                    pointBackgroundColor: 'rgb(255, 255, 0)',
                }]
        },
        options: {
            scale: {
                angleLines: {
                    display: false
                },
                ticks: {
                    suggestedMin: 0,
                    suggestedMax: 100
                }
            }
        }
    });
    function average(arr) {
        var sum = 0;
        for (var i = 0; i < arr.length; i++) {
            sum += parseInt(arr[i], 10);
        }
        return Math.round(sum / arr.length);
    }
    var progressImp = <?= $progressImp ?>;
    var data = [];
    var label = [];
    for (var i = 0; i < progressImp.length; i++) {
        var p = progressImp[i];
        if (i != 0) {
            data.push(p.count);
            label.push(p.status);
        }
    }
    chartProgress = new Chart(document.getElementById('chartProgressImp'), {
        type: 'pie',
        data: {
            datasets: [{
                    data: data,
                    backgroundColor: ['#d92550', 'rgb(255,165,0)', 'rgb(255, 255, 0)', '#3ac47d', '#3f6ad8'],
                }],
            labels: label,
        },
        options: {}
    });
    var dataTableConfig = {
        "ordering": false,
//        "searching": false,
        "info": false,
        "lengthChange": false,
        "pageLength": 9,
        sDom: 'lrtip',
    }
    $('#tableDistribusi').DataTable(dataTableConfig);
    dataTableConfig.pageLength = 5;
    var tbTugas = $('#tableTugas').DataTable(dataTableConfig);

    function detailTugas(tugas, tanggal, dokumen, form_terkait, sifat, pic, status, preview) {
        var m = $('#modalTugas');
        m.find('#tugas-nama').text(tugas);
        m.find('#tugas-tanggal').text(tanggal);
        m.find('#tugas-dokumen').text(dokumen);
        m.find('#tugas-form-terkait').text(form_terkait);
        m.find('#tugas-sifat').text(sifat);
        m.find('#tugas-pic').text(pic);
        m.find('#tugas-status').text(status);
        m.find('#tugas-preview').html('<a href="' + preview + '">' + preview + '</a>');
        m.modal('show');
    }
    function periodeTugas(periode, label) {
        tbTugas.column(3).search(periode).draw();
        $('#periodeTugasTitle').html('Tugas '+label+' ini');
    }
//    periodeTugas('<?= date('Y-m-d') ?>', 'Hari');
</script>