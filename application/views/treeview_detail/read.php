<?php
$role = $this->session->userdata['user']['role'];
?>
<div class="main-card mb-3 card">
    <div class="card-body">
        <div class="form-group">
            <label>Perusahaan</label>
            <select id="perusahaan" class="form-control" name="perusahaan" required="">
                <option value="">-- Perusahaan --</option>
                <?php foreach ($company as $c) { ?>
                    <option value="<?php echo $c['id'] ?>" <?php echo $c['id'] == $this->input->post('role') ? 'selected' : ''; ?>><?php echo $c['name'] ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label>Standar</label>
            <select id="standar" class="form-control" name="perusahaan" required=""></select>
        </div>
        <div class="main-card mb-3 card">
            <div id="container" class="card-body">
                <!--TAB-->
                <ul class="nav nav-tabs">
                    <li class="nav-item"><a data-toggle="tab" href="#tab-pemenuhan" class="nav-link active">Pemenuhan</a></li>
                    <li class="nav-item"><a data-toggle="tab" href="#tab-pasal" class="nav-link">Pasal</a></li>
                    <li class="nav-item"><a data-toggle="tab" href="#tab-dokumen" class="nav-link">Dokumen</a></li>
                    <li class="nav-item"><a data-toggle="tab" href="#tab-distribusi" class="nav-link">Distribusi</a></li>
                    <li class="nav-item"><a data-toggle="tab" href="#tab-jadwal" class="nav-link">Jadwal</a></li>
                    <li class="nav-item"><a data-toggle="tab" href="#tab-implementasi" class="nav-link">Implementasi</a></li>
                    <!--<li class="nav-item"><a data-toggle="tab" href="#tab-base" class="nav-link">Base</a></li>-->
                </ul>
                <div class="tab-content">
                    <!--PEMENUHAN-->
                    <div class="tab-pane" id="tab-pemenuhan" role="tabpanel">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Pasal</th>
                                    <th class="col-sm-2 text-center">Jumlah<br/>Dokumen</th>
                                    <th class="col-sm-2 text-center">Pemenuhan<br/>Dokumen</th>
                                    <!--<th>Implementasi</th>-->
                                </tr>
                            </thead>
                            <tbody id="table-pemenuhan"></tbody>
                        </table>
                    </div>
                    <!--PASAL-->
                    <div class="tab-pane" id="tab-pasal" role="tabpanel">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Pasal</th>
                                    <th>Judul</th>
                                    <th>Deskripsi</th>
                                    <th>Doc</th>
                                    <th>Detail</th>
                                </tr>
                            </thead>
                            <tbody id="table-pasal"></tbody>
                        </table>
                    </div>
                    <!--DOKUMEN-->
                    <div class="tab-pane" id="tab-dokumen" role="tabpanel">
                        <div class="text-right mb-2">
                            <label>Tambah Dokumen</label>
                            <button class="btn btn-outline-primary fa fa-plus" onclick="tambahDokumen()"></button>
                        </div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Jenis</th>
                                    <th class="col-sm-2">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="table-dokumen"></tbody>
                        </table>
                    </div>
                    <div class="tab-pane" id="tab-distribusi" role="tabpanel">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Pasal</th>
                                    <th>Judul Dokumen</th>
                                    <th>Pembuat dokumen</th>
                                    <th>Distribusi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="table-distribusi"></tbody>
                        </table>
                    </div>
                    <!--JADWAL-->
                    <div class="tab-pane" id="tab-jadwal" role="tabpanel">
                        <div class="text-right mb-2">
                            <label>Tambah Jadwal</label>
                            <button class="btn btn-outline-primary fa fa-plus" onclick="jadwal()"></button>
                        </div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Pasal</th>
                                    <th>Judul Dokumen</th>
                                    <th>Jadwal</th>
                                    <th>Distribusi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="table-jadwal"></tbody>
                        </table>
                    </div>
                    <!--IMPLEMENTASI-->
                    <div class="tab-pane" id="tab-implementasi" role="tabpanel">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Pasal</th>
                                    <th>Judul Dokumen</th>
                                    <th>Jadwal</th>
                                    <th>Distribusi</th>
                                    <th>Bukti</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody id="table-implementasi"></tbody>
                        </table>
                    </div>
                    <div class="tab-pane" id="tab-base" role="tabpanel">Base</div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--MODAL DETAIL PASAL-->
<div class="modal fade" id="modalDetailPasal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Pasal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body modal-message">
                    <div class="form-group">
                        <label for="namaModule">Judul</label>
                        <input class="form-control item-sort-desc" name="sort-desc" readonly="">
                    </div>
                    <div class="form-group">
                        <label for="namaModule">Deskripsi</label>
                        <textarea class="form-control item-long-desc" name="long-desc" readonly=""></textarea>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Dokumen</th>
                                <th>Jenis</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="files"></tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!--MODAL DOKUMEN-->
<div class="modal fade" id="modalDokumen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post" class="formDokumen">
            <input class="input-id" name="id" hidden="">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Form Dokumen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body modal-message">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>Pasal</td>
                                <td>
                                    <select name="pasal" class="form-control select-pasal" required=""></select>
                                </td>
                            </tr>
                            <tr>
                                <td>Nomor</td>
                                <td>
                                    <input class="form-control input-nomor" name="nomor" required="">
                                </td>
                            </tr>
                            <tr>
                                <td>Judul</td>
                                <td>
                                    <input class="form-control input-judul" name="judul" required="">
                                </td>
                            </tr>
                            <tr>
                                <td>Pembuat Dokumen</td>
                                <td>
                                    <select class="form-control select-anggota" name="creator" required=""></select>
                                </td>
                            </tr>
                            <tr>
                                <td>Jenis Dokumen</td>
                                <td>
                                    <select class="form-control select-jenis" name="jenis" required="">
                                        <option value="1">Level I</option>
                                        <option value="2">Level II</option>
                                        <option value="3">Level III</option>
                                        <option value="4">Level IV</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Klasifikasi</td>
                                <td>
                                    <select class="form-control select-klasifikasi" name="klasifikasi" required="">
                                        <option value="UMUM">Umum</option>
                                        <option value="INTERNAL">Internal</option>
                                        <option value="RAHASIA">Rahasia</option>
                                        <option value="SANGAT RAHASIA">Sangat Rahasia</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Deskripsi</td>
                                <td>
                                    <textarea class="form-control textarea-deskripsi" name="deskripsi"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>Versi Dokumen</td>
                                <td>
                                    <input class="form-control input-versi" name="versi" required="">
                                </td>
                            </tr>
                            <tr>
                                <td>Dokumen terkait</td>
                                <td>
                                    <select class="form-control select-dokumen" name="dokumen_terkait"></select>
                                </td>
                            </tr>
                            <tr>
                                <td>Dokumen</td>
                                <td>
                                    <input class="radio-type-dokumen" type="radio" name="type_dokumen" value="FILE" required="">
                                    <label>File</label>
                                    <input class="radio-type-dokumen" type="radio" name="type_dokumen" value="URL">
                                    <label>Url</label>
                                    <input class="form-control input-file d-none" type="file" name="dokumen" required="">
                                    <input class="form-control input-url d-none" type="url" name="url" required="">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-submit" name="submit">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!--MODAL DELETE DOKUMEN-->
<div class="modal fade" id="modalDeleteDokumen" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus Dokumen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body modal-message">
                <input class="form-control" disabled=""/>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" data-dismiss="modal">Batal</button>
                <button class="btn btn-danger" onclick="hapusDokumen(deleteId)">Hapus</button>
            </div>
        </div>
    </div>
</div>
<!-- MODAL DISTRIBUSI -->
<div class="modal fade" id="modalDistribusi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post" id="formDistribusi">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Distribusi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body modal-message">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td style="width: 120px">Pasal</td>
                                <td>
                                    <label class="label-pasal"></label>
                                </td>
                            </tr>
                            <tr>
                                <td>Judul Dokumen</td>
                                <td>
                                    <label class="label-judul"></label>
                                </td>
                            </tr>
                            <tr>
                                <td>Jenis Dokumen</td>
                                <td>
                                    <label class="label-jenis"></label>
                                </td>
                            </tr>
                            <tr>
                                <td>Klasifikasi</td>
                                <td>
                                    <label class="label-klasifikasi"></label>
                                </td>
                            </tr>
                            <tr>
                                <td>Dokumen Terkait</td>
                                <td>
                                    <input class="input-dokumen-id d-none" name="dokumen">
                                    <label class="label-dokumen-terkait"></label>
                                </td>
                            </tr>
                            <tr>
                                <td>Distribusi</td>
                                <td>
                                    <select class="form-control select-unit-kerja" id="distribusi-unit-kerja"></select>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <select class="form-control select-personil select-2 multiselect-dropdown" multiple="multiple" name="personil[]" required="" style="width: 330px !important;"></select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-submit" name="submit">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!--MODAL CREATE JADWAL-->
<div class="modal fade" id="modalJadwal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="formJadwal">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Jadwal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input class="input-id d-none" name="id"/>
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>Pasal</td>
                                <td>
                                    <select name="pasal" class="form-control select-pasal-has-dokumen" required=""></select>
                                </td>
                            </tr>
                            <tr>
                                <td>Judul Dokumen</td>
                                <td>
                                    <input name="dokumen_id" class="input-dokumen-id d-none">
                                    <select name="dokumen" class="form-control select-dokumen-pasal" required=""></select>
                                </td>
                            </tr>
                            <tr>
                                <td>Keterangan</td>
                                <td>
                                    <input name="desc" class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <td>Distribusi</td>
                                <td>
                                    <select name="dist[]" class="form-control select-personil-distribusi select-2 multiselect-dropdown" multiple="" style="width: 330px !important;"></select>
                                </td>
                            </tr>
                            <tr>
                                <td>Penjadwalan</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td id="tglMulaiJadwal">Tanggal</td>
                                <td>
                                    <input class="form-control input-jadwal" name="tanggal[]" required="">
                                </td>
                            </tr>
                            <tr id="group-add-date" class="group-input-unrepeat d-none">
                                <td></td>
                                <td>
                                    <div class="text-right mb-2">
                                        <label>Tambah Tanggal</label>
                                        <button type="button" class="btn btn-outline-primary fa fa-plus" onclick="tambahTanggal()"></button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Ulangi</td>
                                <td>
                                    <input class="radio-ulangi-jadwal" type="radio" name="ulangi" value="YA" required="">
                                    <label>Ya</label>
                                    <input class="radio-ulangi-jadwal" type="radio" name="ulangi" value="TIDAK">
                                    <label>Tidak</label>
                                </td>
                            </tr>
                            <tr class="group-input-repeat">
                                <td></td>
                                <td>
                                    <div class="row group-input-hari">
                                        <div class="col-sm-4">
                                            <input type="checkbox" name="hari[]" value="SENIN">
                                            <label for="vehicle1"> Senin</label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="checkbox" name="hari[]" value="SELASA">
                                            <label for="vehicle1"> Selasa</label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="checkbox" name="hari[]" value="RABU">
                                            <label for="vehicle1"> Rabu</label>
                                        </div>
                                    </div>
                                    <div class="row group-input-hari">
                                        <div class="col-sm-4">
                                            <input type="checkbox" name="hari[]" value="KAMIS">
                                            <label for="vehicle1"> Kamis</label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="checkbox" name="hari[]" value="JUMAT">
                                            <label for="vehicle1"> Jumat</label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="checkbox" name="hari[]" value="SABTU">
                                            <label for="vehicle1"> Sabtu</label>
                                        </div>
                                    </div>
                                    <div class="row group-input-hari">
                                        <div class="col-sm-4">
                                            <input type="checkbox" name="hari[]" value="MINGGU">
                                            <label for="vehicle1"> Minggu</label>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="group-input-repeat">
                                <td>Tanggal Selesai</td>
                                <td>
                                    <input class="form-control input-jadwal" name="tanggal_selesai" required="">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!--MODAL DETAIL JADWAL-->
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
<!--MODAL EDIT JADWAL-->
<div class="modal fade" id="modalEditJadwal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="formEditJadwal">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Jadwal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input class="input-id d-none" name="id"/>
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>Pasal</td>
                                <td>
                                    <input class="form-control input-pasal" disabled="">
                                </td>
                            </tr>
                            <tr>
                                <td>Judul Dokumen</td>
                                <td>
                                    <input class="form-control input-dokumen" disabled="">
                                </td>
                            </tr>
                            <tr>
                                <td>Keterangan</td>
                                <td>
                                    <input name="desc" class="form-control input-keterangan">
                                </td>
                            </tr>
                            <tr>
                                <td>Tanggal</td>
                                <td>
                                    <input class="form-control input-jadwal input-tanggal-jadwal" name="tanggal" required="">
                                </td>
                            </tr>
                            <tr>
                                <td>Distribusi</td>
                                <td>
                                    <select name="dist[]" class="form-control select-personil-distribusi select-2 multiselect-dropdown" multiple="" style="width: 330px !important;"></select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!--MODAL DELETE PERSONIL JADWAL-->
<div class="modal fade" id="modalDeletePersonilJadwal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus Personil Jadwal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body modal-message">
                <input class="form-control" disabled=""/>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" data-dismiss="modal">Batal</button>
                <button class="btn btn-danger" onclick="hapusPersonilJadwal(deleteId)">Hapus</button>
            </div>
        </div>
    </div>
</div>
<!--MODAL UPLOAD BUKTI-->
<div class="modal fade" id="modalUploadBukti">
    <div class="modal-dialog" role="document">
        <form id="formUploadBukti">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload Bukti</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formUploadBukti">
                        <input class="input-id d-none" name="id"/>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Judul Dokumen</td>
                                    <td>
                                        <input class="form-control input-judul" disabled=""/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Jadwal</td>
                                    <td>
                                        <input class="form-control input-jadwal" disabled=""/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Dokumen</td>
                                    <td>
                                        <input class="radio-type-dokumen" type="radio" name="type_dokumen" value="FILE" required="">
                                        <label>File</label>
                                        <input class="radio-type-dokumen" type="radio" name="type_dokumen" value="URL">
                                        <label>Url</label>
                                        <input class="form-control input-file d-none" type="file" name="dokumen" required="">
                                        <input class="form-control input-url d-none" type="url" name="url" required="">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#modalContainer').append($('.modal'));
        var clone = $('#modalDokumen').clone();
        clone.attr("id", "modalDokumenRead");
        clone.find('.modal-title').text('Detail Dokumen');
        clone.find('input').attr('disabled', true);
        clone.find('select').attr('disabled', true);
        clone.find('textarea').attr('disabled', true);
        $('#modalContainer').append(clone);
        $('#tab-pemenuhan').addClass('active');
        $('.select-2').select2();
        formSubmit();
        $('.radio-ulangi-jadwal[value=TIDAK]').click();
    });
    function afterReady() {}
    var idPerusahaan;
    var idStandar;
    var anggota;
    var pesonil;
    var dokumen;
    var listJadwal;
    $('#perusahaan').change(function (s) {
        if ($(this).val()) {
            $.post('<?php echo site_url($module); ?>/standard', {'id': $(this).val()}, function (data) {
                var d = JSON.parse(data);
                $('#standar').html('');
                $('#standar').append('<option value="">-- Standar --</option>');
                for (var i = 0; i < d.length; i++) {
                    $('#standar').append('<option value="' + d[i].id + '">' + d[i].name + '</option>');
                }
            });
            $.post('<?php echo site_url($module); ?>/anggota', {'perusahaan': $(this).val()}, function (data) {
                anggota = JSON.parse(data);
                $('.select-anggota').empty();
                for (var i = 0; i < anggota.length; i++) {
                    var a = anggota[i];
                    $('.select-anggota').append('<option value="' + a.id + '">' + a.fullname + '</option>');
                }
            });
            $.post('<?php echo site_url($module); ?>/unit_kerja', {'perusahaan': $(this).val()}, function (data) {
                unitKerja = JSON.parse(data);
                $('.select-unit-kerja').empty();
                $('.select-unit-kerja').append('<option value="">-- Pilih Unit Kerja --</option>');
                for (var i = 0; i < unitKerja.length; i++) {
                    var uk = unitKerja[i];
                    $('.select-unit-kerja').append('<option value="' + uk.id + '">' + uk.name + '</option>');
                }
            });
            $.post('<?php echo site_url($module); ?>/personil', {'perusahaan': $(this).val()}, function (data) {
                personil = JSON.parse(data);
                $('.select-personil').empty();
                for (var i = 0; i < personil.length; i++) {
                    var p = personil[i];
                    $('.select-personil').append('<option value="' + p.id + '">' + p.fullname + '</option>');
                }
            });
            perusahaan = $(this).val();
        }
    });
    $('#standar').change(function (s) {
        standar = $(this).val();
        if (standar) {
            $('#root span').text($('#standar option:selected').text());
            getPasal();
        }
    });
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
                    } else {
                        d.pemenuhan_doc = 100;
                    }
                } else {
                    d.pemenuhan_doc = -1;
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
                s.childsIndex = [];
                if (s.parent === null) {
                    s.parentIndex = null;
                    s.fullname = s.name;
                } else {
                    s.parentIndex = $('#item-base' + s.parent).children('.index').text();
                    s.fullname = sortPasal[s.parentIndex].fullname + ' - ' + s.name;
                    sortPasal[s.parentIndex].childsIndex.push(i);
                }
                sortPasal[i] = s;
            }
            for (var i = 0; i < sortPasal.length; i++) {
                if (sortPasal[i].parent === null) {
                    if (sortPasal[i].child != 0) {
                        pemenuhanDokumen(i);
                    } else {
                        sortPasal[i].pemenuhan_doc = 0;
                    }
                }
            }
            $('#tab-base').empty();
            $('#table-pemenuhan').empty();
            $('#table-pasal').empty();
            $('.select-pasal').empty();
            $('.select-pasal-has-dokumen').empty();
            $('.select-pasal').append('<option value="">-- pilih pasal --</option>');
            $('.select-pasal-has-dokumen').append('<option value="">-- pilih pasal --</option>');
            for (var i = 0; i < sortPasal.length; i++) {
                var d = sortPasal[i];
                var pCol;
                switch (d.pemenuhan_doc) {
                    case 100:
                        pCol = 'success';
                        break;
                    case 0:
                        pCol = 'danger';
                        break;
                    default :
                        pCol = 'warning';
                }
                $('#table-pemenuhan').append('<tr><td>' + d.fullname + '</td><td class="text-center">' + (d.doc == '0' ? '-' : d.doc) + '</td><td class="text-center"><span class="badge badge-' + pCol + '">' + d.pemenuhan_doc + '%</span></td></tr>');
                $('#table-pasal').append('<tr><td>' + d.fullname + '</td><td>' + (d.sort_desc == null ? '-' : d.sort_desc) + '</td><td>' + (d.long_desc == null ? '-' : d.long_desc) + '</td><td>' + d.doc + '</td><td><span class="fa fa-info-circle text-primary" onclick="detailPasal(' + i + ')" title="Detail"></span></td></tr>');
                if (d.child == 0) {
                    $('.select-pasal').append('<option value="' + d.id + '">' + d.fullname + '</option>');
                }
                if (d.doc != 0) {
                    $('.select-pasal-has-dokumen').append('<option value="' + i + '">' + d.fullname + '</option>');
                }
            }
            getDokumen();
        });
    }
    function pemenuhanDokumen(index) {
        var listPemenuhan = [];
        var d = sortPasal[index];
        for (var i = 0; i < d.childsIndex.length; i++) {
            if (sortPasal[d.childsIndex[i]].pemenuhan_doc === -1) {
                pemenuhanDokumen(d.childsIndex[i]);
            }
            listPemenuhan.push(sortPasal[d.childsIndex[i]].pemenuhan_doc);
        }
        var total = 0;
        for (var i = 0; i < listPemenuhan.length; i++) {
            total += listPemenuhan[i];
        }
        sortPasal[index].pemenuhan_doc = total / listPemenuhan.length;
    }
    function detailPasal(index) {
        var m = $('#modalDetailPasal');
        var d = sortPasal[index];
        m.modal('show');
        m.find('.modal-title').text(d.fullname);
        m.find('.item-sort-desc').val(d.sort_desc);
        m.find('.item-long-desc').text(d.long_desc);
        m.find('.files').empty();
        if (d.doc != 0) {
            for (var doc of dokumen) {
                if (d.id == doc.id_pasal) {
                    var link;
                    if (doc.type_doc == 'file') {
                        link = '<a class="btn btn-primary btn-sm fa fa-download" href="<?= base_url('upload/dokumen') ?>/' + doc.file + '"></a>';
                    } else {
                        link = '<a class="btn btn-primary btn-sm fa fa-search" target="_blank" href="' + doc.url + '"></a>';
                    }
                    m.find('.files').append('<tr><td>' + doc.judul + '</td><td>' + doc.type_doc + '</td><td>' + link + '</td></tr>');
                }
            }
        }
    }
    function formSubmit() {
        $('.formDokumen').on("submit", function (e) {
            e.preventDefault();
            var status = 'Undefined';
            $('.modal').modal('hide');
            $('#modalNotif .modal-title').text('Uploading...');
            $('#modalNotif').modal('show');
            $.ajax({
                url: '<?php echo site_url($module . '/create_dokumen') ?>',
                type: "post",
                data: new FormData(this),
                processData: false,
                contentType: false,
                cache: false,
                async: false,
                success: function (data) {
                    data = JSON.parse(data);
                    if (data.status === 'success') {
                        status = 'Success';
                        $(this).trigger("reset");
                        getDokumen();
                        $('#modalNotif .modal-message').html('Data Berhasil Disimpan');
                    } else if (data.status === 'error') {
                        status = 'Error';
                        $('#modalNotif .modal-message').html(data.message);
                    }
                },
                error: function (data) {
                    status = 'Error';
                    $('#modalNotif .modal-message').text('Error 500');
                },
                complete: function () {
                    $('#modalNotif .modal-title').text(status);
                }
            });
        });
    }
    function getDokumen() {
        $.post('<?php echo site_url($module); ?>/get_dokumen', {'perusahaan': perusahaan, 'standar': standar}, function (data) {
            $('#table-dokumen').empty();
            $('.select-dokumen').empty();
            $('.select-dokumen').append('<option value="">-- -- --</option>');
            sortDokumen = [];
            dokumen = JSON.parse(data);
            for (var i = 0; i < dokumen.length; i++) {
                var d = dokumen[i];
                if (dokumen[i].distribusi[0] == "") {
                    dokumen[i].distribusi = [];
                    dokumen[i].user_distribusi = [];
                }
                $('#table-dokumen').append('<tr><td>' + d.nomor + '</td><td>' + d.judul + '</td><td>Level ' + d.jenis + '</td><td><button class="btn btn-sm btn-primary fa fa-info-circle" onclick="detailDokumen(' + i + ')" title="Detail"></button>&nbsp<button class="btn btn-sm btn-primary fa fa-edit" onclick="editDokumen(' + i + ')"></button>&nbsp<button class="btn btn-sm btn-danger fa fa-trash" onclick="initHapusDokumen(' + i + ')"></button></td></tr>');
                $('.select-dokumen').append('<option value="' + d.id + '">' + d.judul + '</option>');
            }
//            for (var h = 0; h < sortPasal.length; h++) {
//                for (var i = 0; i < data.length; i++) {
//                    if(data[i].id_pasal=sortPasal[h].){
//                        
//                    }
//                }
//            }
            getDistribusi();
        });
    }
    function tambahDokumen() {
        var m = $('#modalDokumen');
        m.find('.modal-title').text('Tambah Dokumen');
        m.find('.btn-submit').val('tambah');
//        dokumenLoadData();
//        formDokumenReset();
        m.modal('show');
    }
    $('.radio-type-dokumen').change(function () {
        var m = $('.modal');
        var type = $(this).val();
        m.find('.input-url').val('');
        m.find('.input-file').val('');
        if (type === 'FILE') {
            m.find('.input-file').removeClass('d-none');
            m.find('.input-file').add('required');
            m.find('.input-url').addClass('d-none');
            m.find('.input-url').removeAttr('required');
        } else if (type === 'URL') {
            m.find('.input-file').addClass('d-none');
            m.find('.input-file').removeAttr('required');
            m.find('.input-url').removeClass('d-none');
            m.find('.input-url').attr('required');
        }
    });
    function detailDokumen(index) {
        var m = $('#modalDokumenRead');
        var d = dokumen[index];
        m.modal('show');
        m.find('.btn-submit').hide();
        m.find('.select-pasal').val(d.id_pasal);
        m.find('.input-nomor').val(d.nomor);
        m.find('.input-judul').val(d.judul);
        m.find('.select-anggota').val(d.creator);
        m.find('.select-jenis').val(d.jenis);
        m.find('.select-klasifikasi').val(d.klasifikasi);
        m.find('.select-dokumen').val(d.contoh);
        m.find('.textarea-deskripsi').val(d.deskripsi);
        m.find('.input-versi').val(d.versi);
        m.find('.radio-type-dokumen').filter('[value=' + d.type_doc + ']').prop('checked', true);
        m.find('input').prop('disabled', true);
        m.find('select').prop('disabled', true);
        m.find('textarea').prop('disabled', true);
    }
    function editDokumen(index) {
        detailDokumen(index);
        var m = $('#modalDokumenRead');
        m.find('.modal-title').text('Edit Dokumen');
        m.find('.btn-submit').show();
        m.find('.input-id').val(dokumen[index].id);
        m.find('input').prop('disabled', false);
        m.find('select').prop('disabled', false);
        m.find('textarea').prop('disabled', false);
        m.find('.input-file').prop('required', false);
        m.find('.input-url').prop('required', false);
    }
    function initHapusDokumen(index) {
        var m = $('#modalDeleteDokumen');
        m.modal('show');
        m.find('input').val(dokumen[index].judul);
        deleteId = index;
    }
    function hapusDokumen(index) {
        $.post('<?php echo site_url($module); ?>/hapus_dokumen', {id: dokumen[index].id}, function (data) {
            getPasal();
            $('#modalDeleteDokumen').modal('hide');
        });
    }
    function getDistribusi() {
        $.post('<?php echo site_url($module); ?>/get_distribusi', {'perusahaan': perusahaan, 'standar': standar}, function (data) {
            data = JSON.parse(data);
            listJadwal = [];
            distribusi = [];
            sortDokumen = [];
            $('#table-distribusi').empty();
            $('#table-jadwal').empty();
            $('#table-implementasi').empty();
            var indexJadwal = 0;
            for (var i = 0; i < sortPasal.length; i++) {
                sortPasal[i].dokumens = [];
                for (var j = 0; j < dokumen.length; j++) {
                    for (var k = 0; k < anggota.length; k++) {
                        if (dokumen[j].id_pasal === sortPasal[i].id) {
                            if (dokumen[j].creator === anggota[k].id) {
                                dokumen[j].index_pasal = i;
                                sortPasal[i].dokumens.push(j);
                                var userDis = dokumen[j].user_distribusi;
                                var idDis = dokumen[j].distribusi;
                                var strUserDis = '';
                                for (var l = 0; l < userDis.length; l++) {
                                    strUserDis += '<div><button class="btn btn-danger btn-sm fa fa-trash" onclick="deleteUserDistribusi(' + idDis[l] + ')"></button>&nbsp' + userDis[l] + '</div>';
                                    if (userDis[l] !== '') {
                                        for (var m = 0; m < data.length; m++) {
                                            if (dokumen[j].distribusi[l] == data[m].id) {
                                                distribusi.push(data[m]);
                                                break;
                                            }
                                        }
                                        var jd = new Object();
                                        jd.id = dokumen[j].distribusi[l];
                                        jd.id_pasal = i;
                                        jd.id_doc = j;
                                        jd.username = userDis[l];
                                        listJadwal.push(jd);
                                        var aksiDistribusi;
                                        var txtJadwal = '-';
                                        if (distribusi[indexJadwal].date == '0000-00-00' & distribusi[indexJadwal].repeat == null) {
                                            aksiDistribusi = '<button class="btn btn-primary fa fa-edit" title="Edit" onclick="jadwal(' + indexJadwal + ',\'create\')"></botton>';
                                        } else {
                                            aksiDistribusi = '<button class="btn btn-primary fa fa-search" title="Detail    " onclick="jadwal(' + indexJadwal + ',\'detail\')"></botton>';
                                            if (distribusi[indexJadwal].repeat == 'YA') {
                                                txtJadwal = 'Mingguan';
                                            } else {
                                                txtJadwal = distribusi[indexJadwal].date;
                                            }
                                        }
                                        indexJadwal++;
//                                        break;
                                    }
                                }
                                $('#table-distribusi').append('<tr><td>' + sortPasal[i].fullname + '</td><td>' + dokumen[j].judul + '</td><td>' + anggota[k].fullname + '</td><td>' + strUserDis + '</td><td><button class="btn btn-primary fa fa-edit" onclick="editDistribusi(' + j + ')"></botton></td></tr>');
                                sortDokumen.push(dokumen[j]);
                            }
                        }
                    }
                }
            }
            getJadwal();
        });
    }
    function getJadwal() {
        $.getJSON('<?php echo site_url($module); ?>/get_jadwal', {'perusahaan': perusahaan, 'standar': standar}, function (data) {
            sortJadwal = [];
            var pasal = '';
            var doc = '';
            var n = 0;
            for (var i = 0; i < sortDokumen.length; i++) {
                for (var j = 0; j < data.length; j++) {
                    if (sortDokumen[i].id == data[j].id_document) {
                        data[j].index_dokumen = i;
//                        var p = sortPasal[sortDokumen[i].index_pasal].fullname;
//                        var d = sortDokumen[i].judul;
//                        var dist = '';
//                        for (var k = 0; k < data[j].personil_name.length; k++) {
//                            dist += '<div>' + data[j].personil_name[k] + '</div>';
//                        }
//                        dist = '<td>' + dist + '</td>';
//                        var row = '<td>' + (pasal == p ? '' : p) + '</td><td>' + (doc == d ? '' : d) + '</td>';
//                        var status = '-';
//                        var control = '<button onclick="modalUploadBukti(' + j + ')" class="btn btn-sm btn-primary fa fa-upload"></button>';
//                        var today = new Date().getTime();
//                        var deadline = new Date(data[j].date).getTime();
//                        var aksi = '<td><button class="btn btn-sm btn-primary fa fa-info-circle" title="Detail" onclick="detailJadwal(' + n + ')"></button>&nbsp<button class="btn btn-sm btn-primary fa fa-edit" title="Detail" onclick="editJadwal(' + n + ')"></button>&nbsp<button class="btn btn-sm btn-danger fa fa-trash" title="Hapus" onclick="hapusJadwal(' + n + ')"></button></td>';
//                        var days = ['minggu', 'senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];
//                        data[j].tgl = $.format.date(new Date(data[j].date), "dd-MMM-yyyy");
//                        data[j].tgl_selesai = $.format.date(new Date(data[j].date_end), "dd-MMM-yyyy");
//                        if (data[j].repeat == 'YA') {
//                            status = '<span class="badge badge-sm badge-secondary">Berkala</span>';
//                            var tgl = new Date(data[j].date);
//                            var endDate = new Date(data[j].date_end);
//                            while (tgl.getTime() <= endDate.getTime()) {
//                                if (data[j][days[tgl.getDay()]] == 'YA') {
//                                    var txtDate = tgl.getFullYear() + '-' + ('0' + (tgl.getMonth() + 1)).slice(-2) + '-' + ('0' + tgl.getDate()).slice(-2);
//                                    var stat = getStatusUpload(txtDate);
//                                    txtDate = $.format.date(tgl, "dd-MMM-yyyy");
//                                    txtDate = '<td>' + txtDate + '</td>';
//                                    $('#table-jadwal').append('<tr>' + row + txtDate + dist + aksi + '</tr>');
//                                    $('#table-implementasi').append('<tr>' + row + txtDate + dist + '<td>' + (stat.status ? control : '') + '</td><td class="text-center">' + stat.badge + '</td></tr>');
//                                }
//                                tgl.setDate(tgl.getDate() + 1);
//                            }
//                        } else if (data[j].repeat == 'TIDAK') {
//                            $('#table-jadwal').append('<tr>' + row + '<td>' + data[j].tgl + '</td>' + dist + aksi + '</tr>');
//                            var stat = getStatusUpload(data[j].date);
//                            $('#table-implementasi').append('<tr>' + row + '<td>' + data[j].tgl + '</td>' + dist + '<td>' + (stat.status ? control : '') + '</td><td class="text-center">' + stat.badge + '</td></tr>');
//                        }
////                        $('#table-implementasi').append('<tr>' + row + '<td>' + control + '</td><td class="text-center">' + status + '</td></tr>');
////                        if (pasal != p)
////                            pasal = p;
////                        if (doc != d)
////                            doc = d;
//                        n++;
                        sortJadwal.push(data[j]);
                    }
                }
            }
            getImplementasi();
        });
    }
    function getImplementasi() {
        $.getJSON('<?php echo site_url($module); ?>/get_implementasi', null, function (data) {
            sortImplementasi = [];
            $('#table-jadwal').empty();
            var n = 0;
            for (var i = 0; i < sortJadwal.length; i++) {
                for (var j = 0; j < data.length; j++) {
                    if (data[j].id_jadwal == sortJadwal[i].id) {
                        data[j].index_jadwal = i;
                        var personil = '';
                        for (var k = 0; k < data[j].personil_id.length; k++) {
                            if (data[j].personil_id != '') {
                                personil += '<div><span class="text-danger fa fa-trash" title="Hapus" onclick="initHapusPersonilJadwal(' + data[j].personil_implementasi_id[k] + ')"></span>&nbsp' + data[j].personil_name[k] + '</div>';
                            }
                        }
                        $('#table-jadwal').append('<tr>'
                                + '<td>' + sortPasal[sortDokumen[sortJadwal[i].index_dokumen].index_pasal].fullname + '</td>'
                                + '<td>' + sortDokumen[sortJadwal[i].index_dokumen].judul + '</td>'
                                + '<td>' + $.format.date(new Date(data[j].date_jadwal), "dd-MMM-yyyy") + '</td>'
                                + '<td>' + personil + '</td>'
                                + '<td>'
                                + '<span class="btn btn-sm btn-primary fa fa-info-circle" title="Detail" onclick="detailJadwal(' + n + ')"></span>&nbsp'
                                + '<span class="btn btn-sm btn-primary fa fa-edit" title="Edit" onclick="editJadwal(' + n + ')"></span>&nbsp'
                                + '<span class="btn btn-sm btn-danger fa fa-trash" title="Hapus" onclick="initHapusJadwal(' + n + ')"></span>'
                                + '</td>'
                                + '</tr>');
                        n++;
                        sortImplementasi.push(data[j]);
                    }
                }
            }
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
    function editDistribusi(index) {
        var m = $('#modalDistribusi');
        var d = dokumen[index];
        m.modal('show');
        m.find('.label-pasal').text(sortPasal[d.index_pasal].fullname);
        m.find('.label-judul').text(d.judul);
        m.find('.label-jenis').text('Level ' + d.jenis);
        m.find('.label-klasifikasi').text(d.klasifikasi);
        m.find('.label-klasifikasi').text(d.klasifikasi);
        m.find('.input-dokumen-id').val(d.id);
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
        $.post('<?php echo site_url($module); ?>/set_distribusi', $(this).serialize(), function (data) {
            $('#modalDistribusi').modal('hide');
            $('#standar').change();
        });
    });
    function deleteUserDistribusi(id) {
        //TODO: check child: upload_bukti
        $.post('<?php echo site_url($module); ?>/delete_distribusi', {id: id}, function (data) {
            getPasal();
        });
    }
    function jadwal() {
        var m = $('#modalJadwal');
        m.modal('show');
    }
    function tambahTanggal() {
        $('<tr class="addictional-date group-input-unrepeat"><td><button type="button" class="btn btn-sm btn-danger fa fa-trash" onclick="hapusTanggalJadwal(this)"></button></td><td>' +
                '<input class="form-control input-jadwal" name="tanggal[]" required="">' +
                '</td></tr>').insertBefore('#group-add-date');
        $('.input-jadwal').datepicker({
            format: 'dd-mm-yyyy',
            startDate: new Date(),
            autoclose: true,
        });
    }
    function hapusTanggalJadwal(item) {
        $(item).parents('tr').remove();
    }
    $('.select-pasal-has-dokumen').change(function () {
        var index = $(this).val();
        $('.select-dokumen-pasal').empty();
        $('.select-dokumen-pasal').append('<option value="">-- -- --</option>');
        if (index != '') {
            var docs = sortPasal[index].dokumens;
            for (var i = 0; i < docs.length; i++) {
                var d = dokumen[docs[i]];
                $('.select-dokumen-pasal').append('<option value="' + docs[i] + '">' + d.judul + '</option>');
            }
        }
    });
    $('.select-dokumen-pasal').change(function () {
        var doc = dokumen[$(this).val()];
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
    $('#formJadwal').submit(function (e) {
        e.preventDefault();
        var postData = $(this).serializeArray();
        $.post('<?php echo site_url($module); ?>/set_jadwal', $(this).serialize(), function (data) {
            $('#modalJadwal').modal('hide');
            getPasal();
            $('#formJadwal').trigger("reset");
            $('#formJadwal').find(".addictional-date").remove();
            $('.radio-ulangi-jadwal[value=TIDAK]').click();
        });
    });
    function detailJadwal(index) {
        var imp = sortImplementasi[index];
        var jadwal = sortJadwal[imp.index_jadwal];
        var m = $('#modalDetailJadwal');
        m.modal('show');
        m.find('.modal-title').text('Detail Jadwal');
        m.find('.btn-batal').text('Tutup');
        m.find('.btn-hapus').addClass('d-none');
        m.find('.modal-body').empty();
        var data = {
            Dokumen: sortDokumen[jadwal.index_dokumen].judul,
            Keterangan: imp.desc == "" ? '-' : imp.desc,
            'Tanggal Implementasi': imp.date_jadwal,
            Ulangi: jadwal.repeat,
        };
        if (jadwal.repeat == 'YA') {
            var hari = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'];
            var txtHari = '';
            for (var h of hari) {
                var c = '';
                if (jadwal[h] == 'YA') {
                    c = 'success';
                } else {
                    c = 'secondary';
                }
                txtHari += '<span class="badge badge-' + c + '">' + h + '</span>&nbsp&nbsp';
            }
            data.Ulangi = '<span class="badge badge-success">YA</span>';
            data['Tanggal Mulai'] = jadwal.start_date;
            data['Tanggal Selesai'] = jadwal.end_date;
            data.Hari = txtHari;
        } else {
            data.Ulangi = '<span class="badge badge-secondary">TIDAK</span>';
        }
        for (var key in data) {
            m.find('.modal-body').append('<div class="row"><div class="col-sm-4"><label>' + key + '</label></div><div class="col-sm-8">' + data[key] + '</div></div>');
        }
    }
    function editJadwal(index) {
        var imp = sortImplementasi[index];
        var jd = sortJadwal[imp.index_jadwal];
        var doc = sortDokumen[jd.index_dokumen];
        var m = $('#modalEditJadwal');
        m.modal('show');
        m.find('.input-id').val(imp.id);
        m.find('.input-pasal').val(sortPasal[doc.index_pasal].fullname);
        m.find('.input-dokumen').val(doc.judul);
        m.find('.input-keterangan').val(imp.desc);
        m.find('.select-personil-distribusi').empty();
        m.find('.input-tanggal-jadwal').datepicker("setDate", new Date(imp.date_jadwal));
        for (var i = 0; i < doc.distribusi.length; i++) {
            m.find('.select-personil-distribusi').append(new Option(doc.user_distribusi[i], doc.personil_distribusi_id[i], true, true)).trigger('change');
        }
        m.find('.select-personil-distribusi').val(imp.personil_id).trigger('change');
    }
    $('#formEditJadwal').submit(function (e) {
        e.preventDefault();
        $.post('<?php echo site_url($module); ?>/edit_jadwal', $(this).serialize(), function (data) {
            getDistribusi();
            $('#modalEditJadwal').modal('hide');
        });
    });
    function initHapusJadwal(index) {
        deleteIndex = index;
        detailJadwal(index);
        var m = $('#modalDetailJadwal');
        m.find('.modal-title').text('Hapus Jadwal');
        m.find('.btn-batal').text('Batal');
        m.find('.btn-hapus').removeClass('d-none');
    }
    function hapusJadwal() {
        $.post('<?php echo site_url($module); ?>/hapus_jadwal', {id: sortImplementasi[deleteIndex].id}, function (data) {
            $('#modalDetailJadwal').modal('hide');
            getJadwal();
        });
    }
    function initHapusPersonilJadwal(id) {
        deleteId = id;
        $.post('<?php echo site_url($module); ?>/hapus_personil_jadwal', {id: deleteId}, function (data) {
            getJadwal();
        });
    }
    function modalUploadBukti(index) {
        var l = listJadwal[index];
        var m = $('#modalUploadBukti');
        m.modal('show');
        m.find('.input-id').val(l.id);
        m.find('.input-judul').val(dokumen[l.id_doc].judul);
    }
    $('#formUploadBukti').submit(function (e) {
        $('#modalUploadBukti').modal('hide');
        e.preventDefault();
        $.ajax({
            url: '<?php echo site_url($module . '/upload_bukti') ?>',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            async: false,
            success: function (data) {
//                data = JSON.parse(data);
//                if (data.status === 'success') {
//                    status = 'Success';
//                    $(this).trigger("reset");
//                    getDokumen();
//                } else if (data.status === 'error') {
//                    status = 'Error';
//                    $('#modalNotif .modal-message').html(data.message);
//                }
                status = 'Success';
            },
            error: function (data) {
                status = 'Error';
                $('#modalNotif .modal-message').text('Error 500');
            },
            complete: function () {
                $('#modalNotif .modal-title').text(status);
            }
        });
    });
</script>