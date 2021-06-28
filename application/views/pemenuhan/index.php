<?php
$role = $this->session->userdata['user']['role'];
$personil = 0;
if ($role == 'anggota') {
    $this->db->select('p.*');
    $this->db->join('users u', 'u.id_personil = p.id AND u.id = ' . $this->session->userdata['user']['id']);
    $personil = $this->db->get('personil p')->row_array()['id'];
}
?>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<style>
    .col-tgl{
        min-width: 110;
    }
    option{
        font-size: .88rem;
        height: .1rem;
        line-height: .1rem;
    }
    select{
        font-size: .88rem !important;
    }
    .no-wrap{
        white-space: nowrap;
        overflow: hidden;
    }
    .col-aksi{
        width: 75px;
    }
    .div-filter{
        padding-bottom: 10px;
    }
</style>
<!--CONTENT-->
<div class="main-card mb-3 card">   
    <div class="card-body">
        <div class="main-card mb-3 card">
            <div id="container" class="card-body">
                <!--TAB-->
                <ul class="nav nav-tabs">
                    <li class="nav-item"><a data-toggle="tab" href="#tab-pemenuhan" class="nav-link active">Pemenuhan</a></li>
                    <!--<li class="nav-item"><a data-toggle="tab" href="#tab-pemenuhan2" class="nav-link active">Pemenuhan 2</a></li>-->
                </ul>
                <div class="tab-content">
                    <div class="tab-pane" id="tab-test" role="tabpanel"></div>
                    <!--PEMENUHAN-->
                    <div class="tab-pane" id="tab-pemenuhan" role="tabpanel">
                        <div class="row div-filter">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-3"></div>
                            <div class="col-sm-3"></div>
                            <div class="col-sm-3"></div>
                        </div>
                        <table class="table table-striped" id="table-pemenuhan">
                            <thead>
                                <tr>
                                    <th>Pasal</th>
                                    <th>Judul</th>
                                    <th class="col-sm-1 text-center">Jumlah<br/>Dokumen</th>
                                    <th class="col-sm-1 text-center">Pemenuhan<br/>Dokumen</th>
                                    <th class="col-sm-1 text-center">Jumlah<br/>Jadwal</th>
                                    <th class="col-sm-1 text-center">Pemenuhan<br/>Implementasi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="tab-pane" id="tab-base" role="tabpanel">Base</div>
                    <div class="tab-pane" id="tab-pemenuhan2" role="tabpanel">
                        <div class="row div-filter">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-3"></div>
                            <div class="col-sm-3"></div>
                            <div class="col-sm-3"></div>
                        </div>
                        <table class="table table-striped" id="table-pemenuhan2">
                            <thead>
                                <tr>
                                    <th>Pasal</th>
                                    <th>Judul</th>
                                    <th class="col-sm-1 text-center">Jumlah<br/>Dokumen</th>
                                    <th class="col-sm-1 text-center">Pemenuhan<br/>Dokumen</th>
                                    <th class="col-sm-1 text-center">Jumlah<br/>Tugas</th>
                                    <th class="col-sm-1 text-center">Jumlah<br/>Jadwal</th>
                                    <th class="col-sm-1 text-center">Pemenuhan<br/>Implementasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pemenuhan2 as $k => $p) { ?>
                                <tr>
                                    <td><?= $p['name'] ?></td>
                                    <td><?= $p['sort_desc'] ?></td>
                                    <td><?= 'nDoc' ?></td>
                                    <td><?= '%Doc' ?></td>
                                    <td><?= $p['imp'] ?></td>
                                    <td><?= $p['imp_percent'] ?></td>
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
<script>
//    $('.app-page-title').first().hide();
    $(document).ready(function () {
        if (role != 'admin') {
            $('.group-select-perusahaan').hide();
            idPersonil = <?= $personil ?>;
        }
        $('#perusahaan').change();
        $('#tab-pemenuhan').addClass('active');
        $('.select-2').select2();
        $('.radio-ulangi-jadwal[value=TIDAK]').click();
        $('.input-path').hide();
        var dataTableConfig = {
            "order": [],
            "ordering": true,
            "paging": false,
            "search": {
                "smart": false
            },
            "bInfo": false,
            "bLengthChange": true,
            "language": {
                "emptyTable": "kosong"
            },
        }
        
        dataTableConfig['ordering'] = false;
        tbPemenuhan = $('#table-pemenuhan').DataTable(dataTableConfig);
        tbPasal = $('#table-pasal').DataTable(dataTableConfig);
        
    });
    function afterReady() {
        perusahaan = <?= $this->session->activeCompany['id'] ?>;
        standar = <?= $this->session->activeStandard['id'] ?>;
        
        getPasal();
    }
    function getPasal() {
        $.get('<?php echo site_url($module); ?>/pasal', {perusahaan: perusahaan, standar: standar}, function (data) {
            data = JSON.parse(data);
            for (var i = 0; i < data.length; i++) {
                var d = data[i];
                var element = '<div class="item-base" id="item-base' + d.id + '"><span>' + d.name + '</span><span class="index">' + i + '</span><div class="child"></div></div>';
                var parent = null;
                if (d.parent === null) {
                    $('#tab-base').append(element);
                } else {
                    $('#item-base' + d.parent).children('.child').append(element);
                }
                if (d.child == 0) {
                    if (d.doc == 0) {
                        d.pemenuhan_doc = 0;
                        d.pemenuhan_imp = 0;
                    } else {
                        d.pemenuhan_doc = 100;
                        if (d.upload == 0) {
                            d.pemenuhan_imp = 0;
                        } else {
                            d.pemenuhan_imp = d.upload / (+d.upload + +d.unupload) * 100;
                        }
                    }
                } else {
                    d.pemenuhan_doc = -1;
                    d.pemenuhan_imp = -1;
                }
                data[i] = d;
            }
            var element = $('.item-base').children('.index').get();
            sortPasal = [];
            for (var i = 0; i < element.length; i++) {
                var e = element[i];
                var index = $(e).text();
                sortPasal.push(data[index]);
                $(e).text(i);
            }
            for (var i = 0; i < sortPasal.length; i++) {
                var s = sortPasal[i];
                s.index_childs = [];
                s.index_documents = [];
                if (s.parent === null) {
                    s.parentIndex = null;
                    s.fullname = s.name;
                } else {
                    s.parentIndex = $('#item-base' + s.parent).children('.index').text();
                    s.fullname = sortPasal[s.parentIndex].fullname + ' - ' + s.name;
                    sortPasal[s.parentIndex].index_childs.push(i);
                }
                sortPasal[i] = s;
            }
            $('#tab-base').empty();
            tbPasal.clear();
            $('.select-pasal, .select-2-pasal').empty();
            $('.select-pasal').append('<option value="">-- pilih pasal --</option>');
            for (var i = 0; i < sortPasal.length; i++) {
                var d = sortPasal[i];
                var tr = tbPasal.row.add([
                    d.fullname,
                    (d.sort_desc == null ? '-' : d.sort_desc),
                    '<p style="white-space: pre-wrap">' + (d.long_desc == null ? '-' : d.long_desc) + '</p>',
                    '',
                    '<span class="fa fa-info-circle text-primary" onclick="detailPasal(' + i + ')" title="Detail"></span>&nbsp'
                            + (d.child == '0' ? '<span class="fa fa-upload text-primary" onclick="initAddDocument(' + i + ')" title="Upload"></span>&nbsp' : '')
                ]).node();
                if (d.parent == null) {
                    $(tr).addClass('table-success');
                }
                if (d.child == 0) {
                    $('.select-pasal, .select-2-pasal').append('<option value="' + d.id + '">' + d.fullname + '</option>');
                }
            }
            tbPasal.draw();
//            getDokumen();
            getPemenuhan();
        });
    }
    function loadPage(url, container) {
        $(container).html('Loading Data...');
        $.get('manajemen_dokumen/' + url, null, function (data) {
            $(container).html(data);
        }).fail(function () {
            $(container).html('Error load data');
        });
    }
    function getPemenuhan() {
        $.getJSON('<?= site_url($module); ?>/get_pemenuhan', {'company': perusahaan, 'standard': standar}, function (data) {
            tbPemenuhan.clear();
            for (var i = 0; i < sortPasal.length; i++) {
                sortPasal[i].pemenuhanImplementasi = 0;
                var ps = sortPasal[i];
                if (ps.parent == null) {//data detail dokumen
                    listPasalDocuments(i);
                }
                for (var j = 0; j < data.length; j++) {
                    var d = data[j];
                    if (d.id == ps.id) {
                        var tr = tbPemenuhan.row.add([
                            ps.name,
                            (ps.sort_desc == null ? '' : ps.sort_desc),
                            '<div class="text-center">' + d.doc + '</div>',
                            '<div class="text-center"><span class="badge badge-' + percentColor(d.pemenuhanDoc) + '">' + d.pemenuhanDoc + '%</span></div>',
                            '<div class="text-center">' + (d.parent == null & d.doc == 0 ? '' : (d.impStatus ? d.jadwal : '-')) + '</div>',
                            '<div class="text-center">' + (d.impStatus ? '<span class="badge badge-' + percentColor(d.pemenuhanImp) + '">' + d.pemenuhanImp + '%</span>' : '-') + '</div>',
                        ]).node();
                    }
                }
                if (ps.parent == null) {
                    $(tr).addClass('table-success');
                }
            }
            tbPemenuhan.draw();
            //update table pasal
            tbPasal.rows().every(function (rowIdx, tableLoop, rowLoop) {
                var row = this.data();
                txtDoc = '<ul>';
                var docs = sortPasal[rowIdx].index_child_documents;
                for (var i = 0; i < docs.length; i++) {
                    var doc = sortDokumen[docs[i]];
                    txtDoc += '<li>'+doc.judul+'</li>';
                }
                txtDoc += '</ul>';
                row[3] = txtDoc;
                this.invalidate();
            });
            tbPasal.draw();
//            tbJadwal.columns(6).visible(false);
        });
    }
    function percentColor(num) {
        num = parseInt(num);
        var col = '';
        switch (num) {
            case 100:
                col = 'success';
                break;
            case 0:
                col = 'danger';
                break;
            default :
                col = 'warning';
        }
        return col;
    }
    function listPasalDocuments(index) {//untuk menampilkan jumlah pasal
        var p = sortPasal[index];
        p.index_child_documents = [];
        Array.prototype.push.apply(p.index_child_documents, p.index_documents);
        for (var i = 0; i < p.index_childs.length; i++) {
            var ic = p.index_childs[i];
            listPasalDocuments(ic);
            Array.prototype.push.apply(p.index_child_documents, sortPasal[ic].index_child_documents);
        }
        sortPasal[index].index_child_documents = sortPasal[index].index_child_documents.filter(onlyUnique);
    }
    function onlyUnique(value, index, self) {
        return self.indexOf(value) === index;
    }
    var role = '<?= $role ?>';
    function detailPasal(index) {
        var m = $('#modalDetailPasal');
        var p = sortPasal[index];
        m.modal('show');
        m.find('.modal-title').text(p.fullname);
        m.find('.item-sort-desc').val(p.sort_desc);
        m.find('.item-long-desc').text(p.long_desc);
        m.find('.files').empty();
        for (var i = 0; i < p.index_child_documents.length; i++) {
            var d = sortDokumen[p.index_child_documents[i]];
            var link;
            if (d.type_doc == 'FILE') {
                link = '<a class="btn btn-primary btn-sm fa fa-download" target="_blank" href="<?= base_url('upload/dokumen') ?>/' + d.file + '"></a>';
            } else {
                link = '<a class="btn btn-primary btn-sm fa fa-search" target="_blank" href="' + d.url + '"></a>';
            }
            var show = true;
            if (role == 'anggota') {
                show = false;
                if ($.inArray(idPersonil + '', d.personil_distribusi_id) >= 0) {
                    show = true;
                }
            }
            if (show) {
                m.find('.files').append('<tr>'
                        + '<td>' + (i + 1) + '</td>'
                        + '<td>' + d.judul + '</td>'
                        + '<td>' + d.txt_pasals2 + '</td>'
                        + '<td style="white-space: pre-wrap">' + (d.custom_deskripsi) + '</td>'
                        + '<td>' + link
                        + '&nbsp<span class="btn btn-danger btn-sm fa fa-trash" onclick="initHapusDokumen(' + p.index_documents[i] + ')"></span>'
                        + '</td>'
                        + '</tr>');
            }
        }
    }
    $('.formDokumen').on("submit", function (e) {
        e.preventDefault();
        post(this, 'create_dokumen');
    });
    function initAddDocument(index) {
        var m = $('#modalDocument');
        m.modal('show');
        m.find('form').trigger("reset");
        m.find('.select-2').val(null);
        m.find('.select-2').val(sortPasal[index].id).trigger('change');
        m.find('.input-pasal').val(sortPasal[index].fullname);
        m.find('.input-pasal-id').val(sortPasal[index].id);
        m.find('.input-company-id').val(perusahaan);
        m.find('.input-url, .input-file').hide();
    }
    $('#formUploadDocument').on("submit", function (e) {
        e.preventDefault();
        post(this, 'create_dokumen');
    });
    $('.radio-type-dokumen').change(function () {
        var m = $('.modal');
        var type = $(this).val();
        m.find('.input-path').val('');
        if (type === 'FILE') {
            m.find('.input-file').show();
            m.find('.input-file').prop('required', true);
            m.find('.input-url').hide();
            m.find('.input-url').prop('required', false);
        } else if (type === 'URL') {
            m.find('.input-file').hide();
            m.find('.input-file').prop('required', false);
            m.find('.input-url').show();
            m.find('.input-url').prop('required', true);
        }
    });
    function showMorePasal(elem) {
        var p = $(elem).parents('.more-pasal-parent');
        p.find('.more-pasal-child').show();
        $(elem).hide();
    }
    function hideMorePasal(elem) {
        var p = $(elem).parents('.more-pasal-parent');
        p.find('.more-pasal-child').hide();
        p.find('.btn-show-more-pasal').show();
    }
    function showMoreDesc(elem) {
        var p = $(elem).parents('.desc-parent');
        p.find('.desc-more').show();
        $(elem).hide();
        p.find('.btn-less').show();
    }
    function hideMoreDesc(elem) {
        var p = $(elem).parents('.desc-parent');
        p.find('.desc-more').hide();
        $(elem).hide();
        p.find('.btn-more').show();
    }
    function detailDocument(index) {
        var d = sortDokumen[index];
        var m = $('#modalDetailDocument');
        m.modal('show');
        m.find('.modal-body').empty();
        var doc_terkait = '';
        for (var i = 0; i < d.index_documents_terkait.length; i++) {
            var d2 = sortDokumen[d.index_documents_terkait[i]];
            var d2link = '';
            if (d2.type_doc == 'FILE') {
                d2link = '<a class="btn btn-primary btn-sm fa fa-download pull-right" target="_blank" href="<?= base_url('upload/dokumen') ?>/' + d2.file + '"></a>';
            } else {
                d2link = '<a class="btn btn-primary btn-sm fa fa-search pull-right" target="_blank" href="' + d2.url + '"></a>';
            }
            doc_terkait += d2link + '<div class="no-wrap" style="width:85%; margin-bottom: 10px">' + d2.judul + '</div>';
        }
        var link = '';
        var txt_doc = '';
        if (d.type_doc == 'FILE') {
            link = '<a class="btn btn-primary btn-sm fa fa-download pull-right" target="_blank" href="<?= base_url('upload/dokumen') ?>/' + d.file + '"></a>';
            txt_doc = d.file;
        } else if (d.type_doc == 'URL') {
            link = '<a class="btn btn-primary btn-sm fa fa-search pull-right" target="_blank" href="' + d.url + '"></a>';
            txt_doc = d.url;
        }
        var data = {
            Nomor: d.nomor,
            Pasal: d.txt_pasals2,
            'Letak Pasal Pada Dokumen': '<div style="white-space: pre-wrap">' + (d.deskripsi == null ? '-' : d.deskripsi) + '<div>',
            Judul: d.judul,
            'Pembuat Dokumen': (d.index_creator == null ? '-' : personil[d.index_creator].fullname),
            'Jenis Dokumen': (d.jenis == null ? '-' : d.jenis),
            'Klasifikasi': (d.klasifikasi == null ? '-' : d.klasifikasi),
            'Revisi Dokumen': (d.versi == null ? '-' : d.versi),
            'Dokumen Terkait': doc_terkait,
            'Dokumen': link + '<div class="no-wrap" style="width:85%">' + txt_doc + '</div>',
        }
        for (var key in data) {
            m.find('.modal-body').append('<div class="row"><div class="col-sm-4"><label>' + key + '</label></div><div class="col-sm-8">' + data[key] + '</div></div>');
        }
    }
    function editDokumen(index) {
        var m = $('#modalDokumen');
        var d = sortDokumen[index];
        m.modal('show');
        m.find('.select-2-pasal').val(null).trigger('change');
        m.find('.select-2-pasal').val(d.dokumen_pasal).trigger('change');
        m.find('.btn-submit').hide();
        m.find('.select-pasal').val(d.id_pasal);
        m.find('.input-nomor').val(d.nomor);
        m.find('.input-judul').val(d.judul);
        m.find('.select-personil').val(d.pembuat);
        m.find('.select-jenis').val(d.jenis);
        m.find('.select-klasifikasi').val(d.klasifikasi);
        m.find('.select-dokumen').val(d.contoh);
        m.find('.textarea-deskripsi').val(d.deskripsi);
        m.find('.input-versi').val(d.versi);
        m.find('.input-path').hide();
        m.find('.fa-trash').hide();
        m.find('.select-2-document').val(d.document_terkait).trigger('change');
        m.find('.group-radio-dokumen').hide();
        m.find('.group-label-dokumen').show();
        if (d.type_doc == 'FILE') {
            m.find('.label-path').val(d.file);
            m.find('.input-group-append').val('<a class="btn btn-outline-primary btn-sm pull-right fa fa-download" onclick="downloadDocument()"></a>');
        } else if (d.type_doc == 'URL') {
            m.find('.label-path').val(d.url);
            m.find('.input-group-append').val('<a class="btn btn-outline-primary btn-sm pull-right fa fa-search" onclick="previewDocument()"></i>');
        } else {
            m.find('.label-path').val('-');
        }
        m.find('input, select, textarea').prop('disabled', true);
        m.find('.btn-submit').show();
        m.find('.radio-type-dokumen').prop('checked', false);
        m.find('.radio-type-dokumen').prop('required', false);
        m.find('.input-id').val(sortDokumen[index].id);
        m.find('input, select, textarea').prop('disabled', false);
        m.find('.input-path').prop('required', false);
        m.find('.fa-trash').show();
    }
    function initEditPathDocument() {
        var m = $('#modalDokumen');
        m.find('.group-label-dokumen').hide();
        m.find('.group-radio-dokumen').show();
    }
    function initHapusDokumen(index) {
        var m = $('#modalDeleteDokumen');
        var d = sortDokumen[index];
        m.modal('show');
        m.find('.input-pasal').val(sortPasal[d.index_pasal].fullname);
        m.find('.input-nomor').val(d.nomor);
        m.find('.input-judul').val(d.judul);
        m.find('.input-distribusi').val(d.distribution.length);
        m.find('.input-jadwal').val(d.c_imp);
        if (d.distribution.length != 0 | d.child_document != 0) {
            m.find('.alert').show();
        } else {
            m.find('.alert').hide();
        }
        deleteId = index;
    }
    function hapusDokumen() {
        $('#modalNotif').modal('show');
        $('#modalDeleteDokumen').modal('hide');
        $('#modalNotif .modal-title').text('Mengapus Data');
        $.post('<?php echo site_url($module); ?>/hapus_dokumen', {id: sortDokumen[deleteId].id}, function (data) {
            $('#modalNotif .modal-message').html('Sukses');
            getPasal();
            $('#modalDetailPasal').modal('hide');
        }).fail(function () {
            $('#modalNotif .modal-message').html('Error');
        });
    }
    function getStatusUpload(date) {
        var badge = '';
        var status = true;
        if (new Date(date).getTime() >= new Date().getTime()) {
            //belum diupload - aktif
            badge = '<span class="badge badge-sm badge-warning">Pending</span>';
        } else {
            badge = '<span class="badge badge-sm badge-danger">Terlambat</span>';
            //terlambat - selesai
            status = false;
        }
        return {status: status, badge: badge};
    }
    function detailDistribusi(index) {
        editDistribusi(index);
        var d = sortDokumen[index];
        var m = $('#modalDistribusi');
        m.find('.group-detail').show();
        m.find('.group-edit').hide();
        m.find('.label-user-disrtibusi').empty();
//        var user = sortDokumen[sortJadwal[index].index_dokumen].user_distribusi;
        m.find('.label-user-distribusi').html(d.txtDistribusi);
//        for (var i = 0; i < user.length; i++) {
//            m.find('.label-user-distribusi').append('<div>' + user[i] + '</div>');
//        }
    }
    function editDistribusi(index) {
        var m = $('#modalDistribusi');
        var d = sortDokumen[index];
        m.modal('show');
        m.find('.label-pasal').html(d.txt_pasals);
        m.find('form').trigger("reset");
        m.find('.label-judul').text(d.judul);
        m.find('.label-jenis').text('Level ' + d.jenis);
        m.find('.label-klasifikasi').text(d.klasifikasi);
        var doc = '';
        for (var i = 0; i < d.index_documents_terkait.length; i++) {
            var d2 = d.index_documents_terkait[i];
            doc += '<div>' + sortDokumen[d2].judul + '</div>';
        }
        m.find('.label-dokumen-terkait').html(doc);
        m.find('.label-pembuat-dokumen').text(d.creator_name);
        m.find('.input-dokumen-id').val(d.id);
        m.find('.group-detail').hide();
        m.find('.group-edit').show();
        m.find('.select-2').val(d.distribution).trigger('change');
    }
    $('#distribusi-unit-kerja').change(function () {
        var slct = $('#modalDistribusi').find('.select-personil');
        slct.val(null).trigger('change');
        var selected = [];
        for (var i = 0; i < personil.length; i++) {
            if (personil[i].id_unit_kerja == $(this).val()) {
                selected.push(personil[i].id);
            }
            slct.val(selected).trigger('change');
        }
    });
    $('#formDistribusi').submit(function (e) {
        e.preventDefault();
        post(this, 'set_distribusi');
//        $.post('<?php // echo site_url($module);       ?>/set_distribusi', $(this).serialize(), function (data) {
//            $('#modalDistribusi').modal('hide');
//            getPasal();
//        });
    });
    function deleteUserDistribusi(id) {
        //TODO: check child: upload_bukti
        $.post('<?php echo site_url($module); ?>/delete_distribusi', {id: id}, function (data) {
            getPasal();
        });
    }
    function initCreateTugas(index) {
        var m = $('#modalTugas');
        var d = sortDokumen[index];
        m.modal('show');
        m.find('form').trigger('reset');
        m.find('.modal-title').text('Tambah Tugas');
        m.find('.input-id').val('');
        m.find('.input-document-id').val(d.id);
        m.find('.input-document-judul').val(d.judul);
        m.find('.input-field').prop('disabled', false);
        m.find('.btn-save').show();
        m.find('.btn-delete').hide();
        m.find('.item-view').hide();
        loadUserDistribusi(index);
    }
    $('#formTugas').on("submit", function (e) {
        e.preventDefault();
        post(this, 'tugas2');
    });
    function detailTugas(index) {
        var t = sortTugas[index];
        var m = $('#modalTugas');
        m.modal('show');
        m.find('form').trigger('reset');
        m.find('.modal-title').text('Detail Tugas');
        m.find('.input-document-judul').val(sortDokumen[t.index_document].judul);
        m.find('.input-tugas').val(t.nama);
        m.find('.input-sifat').val(t.sifat);
        m.find('.input-form-terkait').val(t.form_terkait);
        m.find('.item-view').show();
        if (t.form_terkait != null) {
            var dt = sortDokumen[t.index_form_terkait];
            m.find('.input-detail-form-terkait').val(dt.judul);
            m.find('.input-group-append').empty();
            if (dt.type_doc == 'FILE') {
                m.find('.input-group-append').append('<a class="btn btn-outline-primary btn-sm pull-right fa fa-download" href="<?= base_url('upload/dokumen') ?>/' + dt.file + '"></a>');
            } else if (dt.type_doc == 'URL') {
                m.find('.input-group-append').append('<a class="btn btn-outline-primary btn-sm pull-right fa fa-search" href="' + dt.url + '"></a>');

            }
        } else {
            m.find('.group-form-terkait').hide();
        }
        m.find('.input-field').prop('disabled', true);
        m.find('.item-edit').hide();
        loadUserDistribusi(t.index_document);
        m.find('.select-2').val(t.personil).trigger('change');
    }
    function initEditTugas(index) {
        detailTugas(index);
        var t = sortTugas[index];
        var m = $('#modalTugas');
        m.find('.modal-title').text('Edit Tugas');
        m.find('.input-id').val(t.id);
        m.find('.input-document-id').val(t.id_document);
        m.find('.input-field').prop('disabled', false);
        m.find('.item-view').hide();
        m.find('.item-edit').show();
        m.find('.btn-delete').hide();
    }
    function initDeleteTugas(index) {
        detailTugas(index);
        var t = sortTugas[index];
        var m = $('#modalTugas');
        m.find('.modal-title').text('Hapus Tugas');
        m.find('.input-delete').val(t.id);
        m.find('.btn-delete').show();
    }
    function loadUserDistribusi(idx) {
        var d = sortDokumen[idx];
        var m = $('#modalTugas');
        m.find('.select-2').empty();
        for (var i = 0; i < d.distribution.length; i++) {
            m.find('.select-2').append(new Option(personil[d.indexDistribusi[i]].fullname, personil[d.indexDistribusi[i]].id, false, false));
        }
        m.find('select-2').trigger('change');
    }
    function post(form, url) {
        $('.modal').modal('hide');
        $('#modalNotif .modal-title').text('Menyimpan data');
        $('#modalNotif .modal-message').html('loading....');
        $('#modalNotif').modal('show');
        $.ajax({
            url: '<?php echo site_url($module . '/') ?>' + url,
            type: "post",
            data: new FormData(form),
            processData: false,
            contentType: false,
            cache: false,
            async: false,
            success: function (data) {
                try {
                    data = JSON.parse(data);
                    if (data.status == 'success') {
                        getPasal();
                        if (data.message) {
                            $('#modalNotif .modal-message').html(data.message);
                        } else {
                            $('#modalNotif .modal-message').html('Data Berhasil Disimpan');
                        }
                        $('#modalNotif .modal-title').text('Success');
                    } else if (data.status === 'error') {
                        $('#modalNotif .modal-title').text('Error');
                        $('#modalNotif .modal-message').html(data.message);
                    }
                } catch (e) {
                    $('#modalNotif .modal-message').html(data);
                }
            },
            error: function (data) {
                $('#modalNotif .modal-title').text('Error');
                $('#modalNotif .modal-message').text('Error 500');
            },
        });
    }
    function initCreateJadwal(index) {
        $('#formCreateJadwal').trigger('reset');
        var m = $('#modalCreateJadwal');
        var t = sortTugas[index];
        m.modal('show');
        m.find('.group-input-repeat').addClass('d-none');
        m.find('.input-tugas').val(t.nama);
        m.find('.input-id-tugas').val(t.id);
    }
    function tambahTanggal() {
        $('<tr class="addictional-date group-input-unrepeat"><td><button type="button" class="btn btn-sm btn-danger fa fa-trash" onclick="hapusTanggalJadwal(this)"></button></td><td>' +
                '<input class="form-control input-jadwal" name="tanggal[]" required="">' +
                '</td></tr>').insertBefore('#group-add-date');
        $('.input-jadwal').datepicker({
            format: 'dd-mm-yyyy',
//            startDate: new Date(),
            autoclose: true,
        });
    }
    function hapusTanggalJadwal(item) {
        $(item).parents('tr').remove();
    }
    $('#formCreateJadwal').on("submit", function (e) {
        e.preventDefault();
        post(this, 'set_jadwal');
    });
    $('#formJadwal').on("submit", function (e) {
        e.preventDefault();
        post(this, 'jadwal');
    });
    $('.select-dokumen-pasal').change(function () {
        var doc = sortDokumen[$(this).val()];
        $('.input-dokumen-id').val(doc.id);
        $('.select-personil-distribusi').empty();
        for (var i = 0; i < doc.distribusi.length; i++) {
            $('.select-personil-distribusi').append(new Option(doc.user_distribusi[i], doc.personil_distribusi_id[i], true, true)).trigger('change');
        }
    });
    $('.radio-ulangi-jadwal').change(function () {
        var ulangi = $(this).val();
        if (ulangi === 'YA') {
            $('.group-input-repeat').removeClass('d-none');
            $('.group-input-unrepeat').addClass('d-none');
            $('input[name=tanggal_selesai]').prop('required', true);
            $('#tglMulaiJadwal').text('Tanggal Mulai');
        } else if (ulangi === 'TIDAK') {
            $('.group-input-repeat').addClass('d-none');
            $('.group-input-unrepeat').removeClass('d-none');
            $('input[name=tanggal_selesai]').prop('required', false);
            $('#tglMulaiJadwal').text('Tanggal');
        }
    });

    function detailJadwal(index) {
        var m = $('#modalDetail');
        var j = sortJadwal[index];
        var t = sortTugas[j.indexTugas];
        m.modal('show');
        m.find('.modal-title').text('Detail Jadwal');
        m.find('.modal-body').empty();
        var dt_txt = '-';
        if (t.form_terkait != null) {
            var dt = sortDokumen[t.index_form_terkait];
            dt_txt = dt.judul;
            if (dt.type_doc == 'FILE') {
                dt_txt += '<a class="btn btn-outline-primary btn-sm pull-right fa fa-download" href="<?= base_url('upload/dokumen') ?>/' + dt.file + '"></a>';
            } else if (dt.type_doc == 'URL') {
                dt_txt += '<a class="btn btn-outline-primary btn-sm pull-right fa fa-search" href="' + dt.url + '"></a>';
            }
        } else {
            m.find('.group-form-terkait').hide();
        }
        var data = {
            Dokumen: sortDokumen[t.index_document].judul,
            Tugas: t.nama,
            'Form Terkait': dt_txt,
            Sifat: t.sifat,
            Pelaksana: t.txt_personil,
            Jadwal: j.tanggal,
            Periode: (j.periode == null ? '-' : j.periode),
        };
        for (var key in data) {
            m.find('.modal-body').append('<div class="row"><div class="col-sm-4"><label>' + key + '</label></div><div class="col-sm-8">' + data[key] + '</div></div>');
        }
    }
    function detailImplementasi(index) {
        detailJadwal(index);
        var j = sortJadwal[index];
        var bukti = '-';
        if (j.doc_type == 'FILE') {
            bukti = j.path + '<a class="btn btn-outline-primary btn-sm pull-right fa fa-download" target="_blank" href="<?= base_url('upload/implementasi') ?>/' + j.path + '"></a>';
        } else if (j.doc_type == 'URL') {
            bukti = j.path + '<a class="btn btn-outline-primary btn-sm pull-right fa fa-search" target="_blank" href="' + j.path + '"></a>'
        }
        var data = {
            Status: j.status,
            Keterlambatan: j.keterlambatan,
            Bukti: bukti,
        };
        var m = $('#modalDetail');
        m.find('.modal-title').text('Detail Implementasi');
        for (var key in data) {
            m.find('.modal-body').append('<div class="row"><div class="col-sm-4"><label>' + key + '</label></div><div class="col-sm-8">' + data[key] + '</div></div>');
        }
    }
    function initEditJadwal(index) {
        var m = $('#modalJadwal');
        var j = sortJadwal[index];
        var t = sortTugas[j.indexTugas];
        m.modal('show');
        m.find('.modal-title').text('Detail Jadwal');
        m.find('.input-tugas').val(sortTugas[j.indexTugas].nama);
        m.find('.input-jadwal').val(j.tanggal);
        m.find('.input-status').val(j.status);
        m.find('.input-sifat').val(t.sifat);
        m.find('.select-periode').val(j.periode);
        m.find('.input-field').prop('disabled', true);
        m.find('.btn-submit').hide();
        m.find('.detail-jadwal').show();
    }
    function editJadwal(index) {
        initEditJadwal(index);
        var m = $('#modalJadwal');
        m.find('.modal-title').text('Edit Jadwal');
        m.find('.input-id').val(sortJadwal[index].id);
        m.find('.input-field').prop('disabled', false);
        m.find('.btn-save').show();
        m.find('.detail-jadwal').hide();
    }
    function initDeleteJadwal(index) {
        initEditJadwal(index);
        var m = $('#modalJadwal');
        m.find('.modal-title').text('Modal Jadwal');
        m.find('.btn-delete').show();
        m.find('.input-delete-id').val(sortJadwal[index].id);
    }
    function hapusJadwal() {
        $.post('<?php echo site_url($module); ?>/hapus_jadwal', {id: sortImplementasi[deleteIndex].id}, function (data) {
            $('#modalDetailJadwal').modal('hide');
            getJadwal();
        });
    }
    function initUploadImplementasi(index) {
        $('#formUploadImplementasi').trigger('reset');
        var j = sortJadwal[index];
        var m = $('#modalUploadImplementasi');
        m.modal('show');
        m.find('.input-id').val(j.id);
        m.find('.input-tugas').val(sortTugas[j.indexTugas].nama);
        m.find('.input-jadwal').val(j.tanggal);
        m.find('.input-url, .input-file').hide();
    }
    $('#formUploadImplementasi').submit(function (e) {
        e.preventDefault();
        post(this, 'upload_bukti');
    });
    function showMoreJadwal(index) {
        $('.jadwal-more' + index).show();
        $('.jd-btn-more' + index).hide();
    }
    function hideMoreJadwal(index) {
        $('.jadwal-more' + index).hide();
        $('.jd-btn-more' + index).show();
    }
    function showMoreTugas(index) {
        $('.tgs-more' + index).show();
        $('.tgs-btn-more' + index).hide();
    }
    function hideMoreTugas(index) {
        $('.tgs-more' + index).hide();
        $('.tgs-btn-more' + index).show();
    }
    function filterUnitKerja(elem, table, index) {
        table.columns(index).search(elem.value).draw();
        var fp = $(elem).parents('.tab-pane').find('.filter-personil');
        fp.empty();
        fp.append('<option value="">-- Pilih Personil --</option>');
        for (var i = 0; i < personil.length; i++) {
            var p = personil[i];
            if (p.fullname.includes(elem.value)) {
                fp.append('<option value="' + p.fullname + '">' + p.fullname + '</option>');
            }
        }
    }
    function filterPersonil(elem, table, index) {
        table.columns(index).search(elem.value).draw();
    }
//==============================================
//fungsi untuk filtering data berdasarkan tanggal 
    var start_date;
    var end_date;
    var DateFilterFunction = (function (oSettings, aData, iDataIndex) {
        var dateStart = parseDateValue(start_date);
        var dateEnd = parseDateValue(end_date);
        //Kolom tanggal yang akan kita gunakan berada dalam urutan 2, karena dihitung mulai dari 0
        //nama depan = 0
        //nama belakang = 1
        //tanggal terdaftar =2
        var evalDate = parseDateValue(aData[4]);
        if ((isNaN(dateStart) && isNaN(dateEnd)) ||
                (isNaN(dateStart) && evalDate <= dateEnd) ||
                (dateStart <= evalDate && isNaN(dateEnd)) ||
                (dateStart <= evalDate && evalDate <= dateEnd))
        {
            return true;
        }
        return false;
    });
    var DateFilterFunction2 = (function (oSettings, aData, iDataIndex) {
        var dateStart = parseDateValue(start_date);
        var dateEnd = parseDateValue(end_date);
        //Kolom tanggal yang akan kita gunakan berada dalam urutan 2, karena dihitung mulai dari 0
        //nama depan = 0
        //nama belakang = 1
        //tanggal terdaftar =2
        var evalDate = parseDateValue(aData[2]);
        if ((isNaN(dateStart) && isNaN(dateEnd)) ||
                (isNaN(dateStart) && evalDate <= dateEnd) ||
                (dateStart <= evalDate && isNaN(dateEnd)) ||
                (dateStart <= evalDate && evalDate <= dateEnd))
        {
            return true;
        }
        return false;
    });

    // fungsi untuk converting format tanggal dd/mm/yyyy menjadi format tanggal javascript menggunakan zona aktubrowser
    function parseDateValue(rawDate) {
        var dateArray = rawDate.split("/");
        var parsedDate = new Date(dateArray[2], parseInt(dateArray[1]) - 1, dateArray[0]);  // -1 because months are from 0 to 11   
        return parsedDate;
    }

    $(document).ready(function () {
        if (role == 'anggota') {
            $('.filter-unit-kerja, .filter-personil').remove();
        }
        $('.datesearch').daterangepicker({
            autoUpdateInput: false
        });
        $('#datesearchJd').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
            start_date = picker.startDate.format('DD/MM/YYYY');
            end_date = picker.endDate.format('DD/MM/YYYY');
            $.fn.dataTableExt.afnFiltering.push(DateFilterFunction);
            tbJadwal.draw();
        });
        $('#datesearchJd').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
            start_date = '';
            end_date = '';
            $.fn.dataTable.ext.search.splice($.fn.dataTable.ext.search.indexOf(DateFilterFunction, 1));
            tbJadwal.draw();
        });
        $('#datesearchImp').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
            start_date = picker.startDate.format('DD/MM/YYYY');
            end_date = picker.endDate.format('DD/MM/YYYY');
            $.fn.dataTableExt.afnFiltering.push(DateFilterFunction2);
            tbImplementasi.draw();
        });
        $('#datesearchImp').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
            start_date = '';
            end_date = '';
            $.fn.dataTable.ext.search.splice($.fn.dataTable.ext.search.indexOf(DateFilterFunction2, 1));
            tbImplementasi.draw();
        });
    });
</script>