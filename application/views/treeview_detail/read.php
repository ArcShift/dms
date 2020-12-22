<?php
$role = $this->session->userdata['user']['role'];
?>
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
</style>
<div class="main-card mb-3 card">
    <div class="card-body">
        <div class="form-group group-select-perusahaan">
            <label>Perusahaan</label>
            <select id="perusahaan" class="form-control" name="perusahaan" required="">
                <?php if ($role == 'admin') { ?>
                    <option value="">-- Perusahaan --</option>
                <?php } ?>
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
                    <li class="nav-item"><a data-toggle="tab" href="#tab-tugas" class="nav-link">Tugas</a></li>
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
                                    <th class="col-sm-2 text-center">Jumlah<br/>Jadwal</th>
                                    <th class="col-sm-2 text-center">Pemenuhan<br/>Implementasi</th>
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
                                    <th>Sub Judul</th>
                                    <th>Deskripsi</th>
                                    <th>Dok</th>
                                    <th class="col-aksi" style="min-width: 50px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="table-pasal"></tbody>
                        </table>
                    </div>
                    <!--DOKUMEN-->
                    <div class="tab-pane" id="tab-dokumen" role="tabpanel">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Pasal</th>
                                    <th>Versi</th>
                                    <th>Level</th>
                                    <th>Klasifikasi</th>
                                    <th class="col-aksi" style="min-width: 70px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="table-dokumen"></tbody>
                        </table>
                    </div>
                    <!--DISTRIBUSI-->
                    <div class="tab-pane" id="tab-distribusi" role="tabpanel">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nomor Dokumen</th>
                                    <th>Judul Dokumen</th>
                                    <th>Level Dokumen</th>
                                    <th>Pembuat Dokumen</th>
                                    <th>Penerima</th>
                                    <th class="col-aksi" style="min-width: 70px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="table-distribusi"></tbody>
                        </table>
                    </div>
                    <!--TUGAS-->
                    <div class="tab-pane" id="tab-tugas" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Judul Dokumen</th>
                                        <th>Tugas</th>
                                        <th>Form Terkait</th>
                                        <th>Sifat</th>
                                        <th>PIC Pelakasana</th>
                                        <th class="col-aksi" style="min-width: 70px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="table-tugas"></tbody>
                            </table>
                        </div>
                    </div>
                    <!--JADWAL-->
                    <div class="tab-pane" id="tab-jadwal" role="tabpanel">
                        <div class="text-right mb-2 col-aksi">
                            <label>Tambah Jadwal</label>
                            <button class="btn btn-outline-primary fa fa-plus" onclick="jadwal()"></button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Dokumen</th>
                                        <th>Tugas</th>
                                        <th>Form</th>
                                        <th>Periode</th>
                                        <th class="col-tgl">Jadwal</th>
                                        <th class="col-aksi" style="min-width: 70px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="table-jadwal"></tbody>
                            </table>
                        </div>
                    </div>
                    <!--IMPLEMENTASI-->
                    <div class="tab-pane" id="tab-implementasi" role="tabpanel">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Tugas</th>
                                    <th>PIC Pelaksana Tugas</th>
                                    <th class="col-tgl">Jadwal</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Keterlambatan</th>
                                    <th class="text-center">Bukti</th>
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
    <div class="modal-dialog modal-lg" role="document">
        <form>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Pasal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body modal-message">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Judul Dokumen</th>
                                <th>Pasal Terkait</th>
                                <th>Letak Pasal<br>pada Dokumen</th>
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
<!--MODAL UPLOAD DOCUMENT-->
<div class="modal fade" id="modalDocument" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="formUploadDocument" class="needs-validation" novalidate>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Dokumen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body modal-message">
                    <input class="input-pasal-id" name="pasal" readonly="" hidden="">
                    <input class="input-company-id" name="company" readonly="" hidden="">
                    <div class="form-group">
                        <label>Pasal</label>
                        <input class="form-control input-pasal" readonly="">
                    </div>
                    <div class="form-group">
                        <label>Tambahkan Pasal Lain</label>
                        <select name="pasals[]" class="form-control select-2 select-2-pasal multiselect-dropdown" multiple="" style="width: 465px !important; margin-top: 100px"></select>
                    </div>
                    <div class="form-group">
                        <label>Nomor</label>
                        <input class="form-control" name="nomor" required="">
                    </div>
                    <div class="form-group">
                        <label>Judul</label>
                        <input class="form-control" name="judul" required="">
                    </div>
                    <div class="form-group">
                        <label>Letak pasal pada dokumen</label>
                        <textarea class="form-control" name="desc"></textarea>
                    </div>
                    <div>
                        <input class="radio-type-dokumen" type="radio" name="type_dokumen" value="FILE" required="">
                        <label>File</label>
                        <input class="radio-type-dokumen" type="radio" name="type_dokumen" value="URL">
                        <label>Url</label>
                        <input class="form-control input-path input-file" type="file" name="dokumen" required="">
                        <input class="form-control input-path input-url" type="url" name="url" required="" placeholder="https://">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
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
                                    <select name="pasal" class="form-control select-pasal" required="" hidden=""></select>
                                    <select name="pasals[]" class="form-control select-2 select-2-pasal multiselect-dropdown" multiple="" style="width: 320px !important; margin-top: 100px"></select>
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
                                    <select class="form-control select-anggota" name="creator"></select>
                                </td>
                            </tr>
                            <tr>
                                <td>Jenis Dokumen</td>
                                <td>
                                    <select class="form-control select-jenis" name="jenis">
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
                                    <select class="form-control select-klasifikasi" name="klasifikasi">
                                        <option value="UMUM">Umum</option>
                                        <option value="INTERNAL">Internal</option>
                                        <option value="RAHASIA">Rahasia</option>
                                        <option value="SANGAT RAHASIA">Sangat Rahasia</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Letak pasal<br>pada dokumen</td>
                                <td>
                                    <textarea class="form-control textarea-deskripsi" name="deskripsi"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>Versi Dokumen</td>
                                <td>
                                    <input class="form-control input-versi" name="versi">
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
                                    <div class="group-radio-dokumen">
                                        <input class="radio-type-dokumen" type="radio" name="type_dokumen" value="FILE" required="">
                                        <label>File</label>
                                        <input class="radio-type-dokumen" type="radio" name="type_dokumen" value="URL">
                                        <label>Url</label>
                                        <input class="form-control input-path input-file" type="file" name="dokumen" required="">
                                        <input class="form-control input-path input-url" type="url" name="url" required="">
                                    </div>
                                    <div class="input-group mb-3 group-label-dokumen">
                                        <input class="form-control label-path" readonly="">
                                        <div class="input-group-append">
                                            <i class="input-group-text btn btn-outline-danger btn-sm pull-right fa fa-trash" onclick="initUpdateDocument()"></i>
                                                <!--<span class="input-group-text" id="basic-addon2">@example.com</span>-->
                                        </div>
                                    </div>
                                    <div class="">
                                        <!--<label class="label-path" style="width: 60%; word-wrap: break-word; display: inline-block" ></label>-->
                                    </div>
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
                <table class="table">
                    <tbody>
                        <tr>
                            <td>Pasal</td>
                            <td>
                                <input class="form-control input-pasal" disabled=""/>
                            </td>
                        </tr>
                        <tr>
                            <td>Nomor</td>
                            <td>
                                <input class="form-control input-nomor" disabled=""/>
                            </td>
                        </tr>
                        <tr>
                            <td>Judul</td>
                            <td>
                                <input class="form-control input-judul" disabled=""/>
                            </td>
                        </tr>
                        <tr class="d-none">
                            <td>Distribusi</td>
                            <td>
                                <input class="form-control input-distribusi" disabled=""/>
                            </td>
                        </tr>
                        <tr class="d-none">
                            <td>Jadwal</td>
                            <td>
                                <input class="form-control input-jadwal" disabled=""/>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="alert alert-danger" role="alert">
                    Peringatan <i class="fa fa-exclamation"></i><br>
                    Dokumen ini sudah memiliki data distribusi, jadwal implementasi atau menjadi dokumen terkait.<br>Apa Anda yakin ingin menghapus dokumen ini?
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" data-dismiss="modal">Batal</button>
                <button class="btn btn-danger" onclick="hapusDokumen()">Hapus</button>
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
                                    <label class="label-dokumen-terkait"></label>
                                </td>
                            </tr>
                            <tr>
                                <td>Pembuat Dokumen</td>
                                <td>
                                    <label class="label-pembuat-dokumen"></label>
                                </td>
                            </tr>
                            <tr class="group-detail">
                                <td>Distribusi</td>
                                <td class="label-user-distribusi"></td>
                            </tr>
                            <tr class="group-edit">
                                <td>Distribusi</td>
                                <td class="td-distribusi-edit">
                                    <input class="input-dokumen-id d-none" name="dokumen">
                                    <select class="form-control select-unit-kerja" id="distribusi-unit-kerja"></select>
                                </td>
                            </tr>
                            <tr class="group-edit">
                                <td></td>
                                <td>
                                    <select name="dist[]" class="form-control select-personil select-2 multiselect-dropdown" multiple="multiple" name="personil[]" required="" style="width: 330px !important;"></select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-submit group-edit" name="submit">Simpan</button>
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
                                <td>Tugas</td>
                                <td>
                                    <input name="desc" class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <td>Form</td>
                                <td>
                                    <select name="form" class="form-control select-dokumen" required=""></select>
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
                            <tr class="group-input-repeat">
                                <td>Periode</td>
                                <td>
                                    <select name="periode" class="form-control select-periode">
                                        <option value="mingguan">Mingguan</option>
                                        <option value="bulanan">Bulanan</option>
                                        <option value="tahunan">Tahunan</option>
                                    </select>
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
                                <td>Tugas</td>
                                <td>
                                    <input name="desc" class="form-control input-keterangan">
                                </td>
                            </tr>
                            <tr>
                                <td>Form</td>
                                <td>
                                    <select name="form" class="form-control select-dokumen" required=""></select>
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
<!--MODAL UPLOAD IMPLEMENTASI-->
<div class="modal fade" id="modalUploadImplementasi">
    <div class="modal-dialog" role="document">
        <form id="formUploadImplementasi">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload Bukti</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input class="input-id d-none" name="id"/>
                    <input class="input-id-jadwal d-none" name="id_jadwal"/>
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
                            <tr class="group-upload">
                                <td>Dokumen</td>
                                <td id="tdUpload">
                                    <input class="radio-type-dokumen" type="radio" name="type_dokumen" value="FILE" required="">
                                    <label>File</label>
                                    <input class="radio-type-dokumen" type="radio" name="type_dokumen" value="URL">
                                    <label>Url</label>
                                    <input class="form-control input-path input-file" type="file" name="dokumen" required="">
                                    <input class="form-control input-path input-url" type="url" name="url" required="">
                                </td>
                            </tr>
                            <tr class="group-detail">
                                <td>Status</td>
                                <td class="label-status"></td>
                            </tr>
                            <tr class="group-detail">
                                <td>Dokumen</td>
                                <td class="label-dokumen"></td>
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
<!--MODAL TUGAS-->
<div class="modal fade" id="modalTugas">
    <div class="modal-dialog" role="document">
        <form id="formTugas">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <input class="form-control input-id" name="id" hidden="">
                    <input class="form-control input-document-id" name="id-document" hidden="" required="">
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Dokumen</label>
                        <input class="form-control input-document-judul" disabled="">
                    </div>
                    <div class="form-group">
                        <label>Tugas</label>
                        <input class="form-control input-tugas" name="tugas" required="">
                    </div>
                    <div class="form-group">
                        <label>Sifat</label>
                        <select class="form-control input-sifat" name="sifat" required="">
                            <option value="">-- sifat --</option>
                            <option value="WAJIB">Wajib</option>
                            <option value="SITUASIONAL">Situasional</option>
                        </select>
                    </div>
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
        if (role != 'admin') {
            $('.group-select-perusahaan').hide();
        }
//        $(".select-2").select2({ width: 'resolve' });
        $(".select-2").select2({width: '100%'});
        $('#perusahaan').change();
        $('#tab-pemenuhan').addClass('active');
        $('.select-2').select2();
        submitDokumen();
        $('.radio-ulangi-jadwal[value=TIDAK]').click();
        $('.input-path').hide();
    });
    function afterReady() {}
    var idPerusahaan;
    var idStandar;
    var anggota;
    var pesonil;
    var sortDokumen;
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
                s.childsIndex = [];
                s.index_documents = [];
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
                        sortPasal[i].pemenuhan_imp = 0;
                    }
                }
            }
            $('#tab-base').empty();
            $('#table-pemenuhan').empty();
            $('#table-pasal').empty();
            $('.select-pasal, .select-2-pasal').empty();
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
                $('#table-pemenuhan').append('<tr ' + (d.parent == null ? 'class="table-success"' : '') + '>'
                        + '<td>' + d.fullname + '</td>'
                        + '<td class="text-center">' + (d.doc == '0' ? '-' : d.doc) + '</td>'
                        + '<td class="text-center"><span class="badge badge-' + pCol + '">' + d.pemenuhan_doc + '%</span></td>'
                        + '<td class="text-center">' + d.imp + '</td>'
                        + '<td class="text-center">' + '<span class="badge badge-' + percentColor(d.pemenuhan_imp) + '">' + (+d.pemenuhan_imp).toFixed() + '%</span>' + '</td>'
//                        + '<td class="text-center">' + d.upload + ' - ' + d.unupload + '</td>'//data upload & unupload
                        + '</tr>');
                $('#table-pasal').append('<tr ' + (d.parent == null ? 'class="table-success"' : '') + '>'
                        + '<td>' + d.fullname + '</td>'
                        + '<td>' + (d.sort_desc == null ? '-' : d.sort_desc) + '</td>'
                        + '<td>' + (d.subtitle == null ? '-' : d.subtitle) + '</td>'
                        + '<td style="white-space: pre-wrap">' + (d.long_desc == null ? '-' : d.long_desc) + '</td>'
                        + '<td>' + d.doc + '</td>'
                        + '<td class="col-aksi">'
                        + '<span class="fa fa-info-circle text-primary" onclick="detailPasal(' + i + ')" title="Detail"></span>&nbsp'
                        + (d.child == '0' ? '<span class="fa fa-upload text-primary" onclick="initAddDocument(' + i + ')" title="Upload"></span>&nbsp' : '')
                        + '</td>'
                        + '</tr>');
                if (d.child == 0) {
                    $('.select-pasal, .select-2-pasal').append('<option value="' + d.id + '">' + d.fullname + '</option>');
                }
                if (d.doc != 0) {
                    $('.select-pasal-has-dokumen').append('<option value="' + i + '">' + d.fullname + '</option>');
                }
            }
            getDokumen();
        });
    }
    function percentColor(num) {
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
    function getDokumen() {
        $.post('<?php echo site_url($module); ?>/get_dokumen', {'perusahaan': perusahaan, 'standar': standar}, function (data) {
            $('#table-dokumen').empty();
            $('#table-distribusi').empty();
            $('.select-dokumen').empty();
            $('.select-dokumen').append('<option value="">-- -- --</option>');
            sortDokumen = [];
            data = JSON.parse(data);
            var n = 0;
            for (var i = 0; i < data.length; i++) {
                var d = data[i];
                d.index_dokumen_pasal = [];
                if (d.dokumen_pasal[0] == '') {
                    d.dokumen_pasal = [];
                }
                d.txt_pasals = '';
                for (var j = 0; j < d.dokumen_pasal.length; j++) {
                    for (var k = 0; k < sortPasal.length; k++) {
                        if (d.dokumen_pasal[j] == sortPasal[k].id) {
                            d.index_dokumen_pasal.push(k);
                            sortPasal[k].index_documents.push(i);
                            d.txt_pasals += '<div>' + sortPasal[k].fullname + '<div>';
                        }
                    }
                }
                for (var j = 0; j < sortPasal.length; j++) {//TODO: remove later
                    sortPasal[j].dokumens = [];
                    if (d.id_pasal == sortPasal[j].id) {
                        d.index_pasal = j;
                        sortPasal[j].dokumens.push(n);
                    }
                }
                var btnDelete = '<span class="text-secondary fa fa-trash"></span>';
                if (d.distribusi[0] == "") {
                    d.distribusi = [];
                    d.user_distribusi = [];
                }
                var idDis = d.distribusi;
                var userDis = d.user_distribusi;
                var strUserDis = '';
                d.txt_user_distribusi = '';
                for (var l = 0; l < userDis.length; l++) {
                    strUserDis += '<div><span class="text-danger fa fa-trash" title="Hapus" onclick="deleteUserDistribusi(' + idDis[l] + ')"></span>&nbsp' + userDis[l] + '</div>';
                    d.txt_user_distribusi += '<div>' + userDis[l] + '</div>';
                }
                for (var k = 0; k < anggota.length; k++) {
                    if (d.creator == null) {
                        d.index_creator = null;
                        d.creator_name = '-';
                    } else if (d.creator === anggota[k].id) {
                        d.index_creator = k;
                        d.creator_name = anggota[k].fullname;
                    }
                }
                d.index_form_terkait = null;
                for (var j = 0; j < data.length; j++) {
                    if (d.contoh == data[j].id) {
                        d.index_form_terkait = j;
                    }
                }
                btnDelete = '<span class="text-danger fa fa-trash" onclick="initHapusDokumen(' + n + ')"></span>';
                $('#table-dokumen').append('<tr>'
                        + '<td>' + d.nomor + '</td>'
                        + '<td>' + d.judul + '</td>'
                        + '<td>' + d.txt_pasals + '</td>'
                        + '<td>' + (d.versi == 0 | d.versi == null ? '-' : d.versi) + '</td>'
                        + '<td>Level ' + (d.jenis == null ? '-' : d.jenis) + '</td>'
                        + '<td>' + (d.klasifikasi == null ? '-' : d.klasifikasi) + '</td>'
                        + '<td class="col-aksi">'
                        + '<span class="text-primary fa fa-info-circle" onclick="detailDokumen(' + n + ')" title="Detail"></span>&nbsp'
                        + '<span class="text-primary fa fa-edit" onclick="editDokumen(' + n + ')"></span>&nbsp'
                        + btnDelete
                        + '</td>'
                        + '</tr>');
                $('.select-dokumen').append('<option value="' + d.id + '">' + d.judul + '</option>');
                $('#table-distribusi').append('<tr>'
                        + '<td>' + d.nomor + '</td>'
                        + '<td>' + d.judul + '</td>'
                        + '<td>' + (d.jenis == null ? '-' : 'Level ' + d.jenis) + '</td>'
                        + '<td>' + d.creator_name + '</td>'
                        + '<td>' + strUserDis + '</td>'
                        + '<td class="col-aksi">'
                        + '<span class="text-primary fa fa-info-circle" title="Detail" onclick="detailDistribusi(' + n + ')"></span>&nbsp'
                        + '<span class="text-primary fa fa-edit" title="Edit" onclick="editDistribusi(' + n + ')"></span>'
                        + '</td>'
                        + '</tr>');
                n++;
                sortDokumen.push(d);
            }
            getTugas();
        });
    }
    function getTugas() {
        $.getJSON('<?php echo site_url($module); ?>/get_tugas', {perusahaan: perusahaan, standar: standar}, function (data) {
            sortTugas = [];
            $('#table-tugas').empty();
            for (var i = 0; i < sortDokumen.length; i++) {
                var d = sortDokumen[i];
                $('#table-tugas').append('<tr>'
                        + '<td>' + d.judul + '</td>'
                        + '<td></td>'
                        + '<td></td>'
                        + '<td></td>'
                        + '<td></td>'
                        + '<td class="col-aksi">'
                        + '<span class="text-primary fa fa-plus" title="Tambah" onclick="initCreateTugas(' + i + ')"></span>'
                        + '</td>'
                        + '</tr>');
                for (var j = 0; j < data.length; j++) {
                    var t = data[j];
                    if (t.id_document == d.id) {
                        t.index_document = i;
                        $('#table-tugas').append('<tr>'
                                + '<td></td>'
                                + '<td>' + t.nama + '</td>'
                                + '<td>' + (d.index_form_terkait == null ? '-' : sortDokumen[d.index_form_terkait].judul) + '</td>'
                                + '<td><span class="badge badge-secondary">' + t.sifat + '</span></td>'
                                + '<td>' + d.txt_user_distribusi + '</td>'
                                + '<td class="col-aksi">'
                                + '<span class="text-primary fa fa-info-circle" title="Detail" onclick="detailTugas(' + j + ')"></span>&nbsp'
                                + '<span class="text-primary fa fa-edit" title="Edit" onclick="initEditTugas(' + j + ')"></span>&nbsp'
                                + '<span class="text-danger fa fa-trash" title="Hapus" onclick=""></span>'
                                + '</td>'
                                + '</tr>');
                        sortTugas.push(t);
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
            $('#table-implementasi').empty();
            var n = 0;
            for (var i = 0; i < sortJadwal.length; i++) {
                for (var j = 0; j < data.length; j++) {
                    if (data[j].id_jadwal == sortJadwal[i].id) {
                        data[j].index_jadwal = i;
                        var personil = '';
                        var personil2 = '';
                        for (var k = 0; k < data[j].personil_id.length; k++) {
                            if (data[j].personil_id != '') {
                                personil += '<div><span class="text-danger fa fa-trash" title="Hapus" onclick="initHapusPersonilJadwal(' + data[j].personil_implementasi_id[k] + ')"></span>&nbsp' + data[j].personil_name[k] + '</div>';
                                personil2 += '<div>' + data[j].personil_name[k] + '</div>';
                            }
                        }
                        if (data[j].form != null) {
                            for (var k = 0; k < sortDokumen.length; k++) {
                                if (data[j].form == sortDokumen[k].id) {
                                    data[j].index_form = k;
                                }
                            }
                        } else {
                            data[j].index_form = null;
                        }
                        var jadwal = new Date(data[j].date_jadwal);
                        var periode = sortJadwal[i].periode == null ? '-' : sortJadwal[i].periode;
                        $('#table-jadwal').append('<tr>'
                                + '<td>' + sortDokumen[sortJadwal[i].index_dokumen].judul + '</td>'
                                + '<td>' + data[j].desc + '</td>'
                                + '<td>' + (data[j].index_form == null ? '-' : sortDokumen[data[j].index_form].judul) + '</td>'
                                + '<td style="text-transform: capitalize">' + periode + '</td>'
                                + '<td>' + $.format.date(jadwal, "dd-MMM-yyyy") + '</td>'
                                + '<td class="col-aksi">'
                                + '<span class="text-primary fa fa-info-circle" title="Detail" onclick="detailJadwal(' + n + ')"></span>&nbsp'
                                + '<span class="text-primary fa fa-edit" title="Edit" onclick="editJadwal(' + n + ')"></span>&nbsp'
                                + '<span class="text-danger fa fa-trash" title="Hapus" onclick="initHapusJadwal(' + n + ')"></span>'
                                + '</td>'
                                + '</tr>');
                        var uploadStatus = '';
                        var diffDate = '-';
                        if (data[j].path) {
                            if (new Date(data[j].upload_date) > new Date(data[j].date_jadwal)) {
                                uploadStatus = '<span class="badge badge-danger">Terlambat</span>';
                            } else {
                                uploadStatus = '<span class="badge badge-primary">Selesai</span>';
                            }
                            diffDate = new Date(data[j].upload_date).getDate() - new Date(data[j].date_jadwal).getDate();
//                            diffDate = diffDate <= 0 ? '-' : diffDate;
                        } else {
                            uploadStatus = '-';
                        }
                        var uploadBtn = '-';
                        $('#table-implementasi').append('<tr>'
                                + '<td>' + data[j].desc + '</td>'
                                + '<td>' + personil2 + '</td>'
                                + '<td>' + $.format.date(jadwal, "dd-MMM-yyyy") + '</td>'
                                + '<td class="text-center">' + uploadStatus + '</td>'
                                + '<td class="text-center">' + (data[j].terlambat < 0 ? Math.abs(data[j].terlambat) : '-') + '</td>'
                                + '<td class="text-center">'
                                + '<span class="text-primary fa fa-upload" title="Upload" onclick="initUploadImplementasi(' + n + ')"></span>&nbsp'
                                + '<span class="text-primary fa fa-search" title="Detail" onclick="detailImplementasi(' + n + ')"></span>'
                                + '</td>'
                                + '</tr>');
                        n++;
                        sortImplementasi.push(data[j]);
                    }
                }
            }
            if (role == 'anggota') {
                $('.col-aksi').remove();
            }
        });
    }
    var role = '<?= $role ?>';
    function pemenuhanDokumen(index) {
        var listPemenuhan = [];
        var listImp = [];
        var d = sortPasal[index];
        for (var i = 0; i < d.childsIndex.length; i++) {
            if (sortPasal[d.childsIndex[i]].pemenuhan_doc === -1) {
                pemenuhanDokumen(d.childsIndex[i]);
            }
            listPemenuhan.push(sortPasal[d.childsIndex[i]].pemenuhan_doc);
            listImp.push(sortPasal[d.childsIndex[i]].pemenuhan_imp);
        }
        var total = 0;
        var totalImp = 0;
        for (var i = 0; i < listPemenuhan.length; i++) {
            total += listPemenuhan[i];
            totalImp += listImp[i];
        }
        sortPasal[index].pemenuhan_doc = Math.round(total / listPemenuhan.length);
        sortPasal[index].pemenuhan_imp = Math.round(totalImp / listImp.length);
    }
    function detailPasal(index) {
        var m = $('#modalDetailPasal');
        var p = sortPasal[index];
        m.modal('show');
        m.find('.modal-title').text(p.fullname);
        m.find('.item-sort-desc').val(p.sort_desc);
        m.find('.item-long-desc').text(p.long_desc);
        m.find('.files').empty();
        for (var i = 0; i < p.index_documents.length; i++) {
            var d = sortDokumen[p.index_documents[i]];
            var link;
            if (d.type_doc == 'FILE') {
                link = '<a class="btn btn-primary btn-sm fa fa-search" target="_blank" href="<?= base_url('upload/dokumen') ?>/' + d.file + '"></a>';
            } else {
                link = '<a class="btn btn-primary btn-sm fa fa-search" target="_blank" href="' + d.url + '"></a>';
            }
            var pasals = '';
            for (var j = 0; j < d.index_dokumen_pasal.length; j++) {
                var idx = d.index_dokumen_pasal[j];
                pasals += '<div>' + sortPasal[idx].fullname + '<div>';
            }
            m.find('.files').append('<tr>'
                    + '<td>' + d.judul + '</td>'
                    + '<td>' + pasals + '</td>'
                    + '<td>' + (d.deskripsi == null ? '-' : d.deskripsi) + '</td>'
                    + '<td>' + link
                    + '&nbsp<span class="btn btn-danger btn-sm fa fa-trash" onclick="initHapusDokumen(' + p.index_documents[i] + ')"></span>'
                    + '</td>'
                    + '</tr>');
        }
    }
    function submitDokumen() {//create dokumen
        $('.formDokumen').on("submit", function (e) {
            e.preventDefault();
            var status = 'Error';
            $('.modal').modal('hide');
            $('#modalNotif .modal-title').text('Uploading...');
            $('#modalNotif .modal-message').empty();
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
                        formDokumenReset = true;
                        getPasal();
                        $('#modalNotif .modal-message').html('Data Berhasil Disimpan');
                    } else if (data.status === 'error') {
                        $('#modalNotif .modal-message').html(data.message);
                    } else {
                        $('#modalNotif .modal-message').html(data);
                    }
                },
                error: function (data) {
                    $('#modalNotif .modal-message').text('Error 500');
                },
                complete: function () {
                    $('#modalNotif .modal-title').text(status);
                }
            });
        });
    }
    function initAddDocument(index) {
        var m = $('#modalDocument');
        m.modal('show');
        m.find('form').trigger("reset");
        m.find('.select-2').val(null);
        m.find('.select-2').val(sortPasal[index].id).trigger('change');
        m.find('.input-pasal').val(sortPasal[index].fullname);
        m.find('.input-pasal-id').val(sortPasal[index].id);
        m.find('.input-company-id').val(perusahaan);
    }
    $('#formUploadDocument').on("submit", function (e) {
        e.preventDefault();
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
                if (data.status == 'success') {
                    getPasal();
                    $('#modalNotif .modal-message').html('Data Berhasil Disimpan');
                    $('#modalNotif .modal-title').text('Success');
                } else if (data.status === 'error') {
                    $('#modalNotif .modal-message').html(data.message);
                } else {
                    $('#modalNotif .modal-message').html(data);
                }
            },
            error: function (data) {
                $('#modalNotif .modal-message').text('Error 500');
            },
        });
    });
    $('.radio-type-dokumen').change(function () {
        var m = $('.modal');
        var type = $(this).val();
        m.find('.input-path').val('');
        if (type === 'FILE') {
            m.find('.input-file').show();
            m.find('.input-file').add('required');
            m.find('.input-url').hide();
            m.find('.input-url').removeAttr('required');
        } else if (type === 'URL') {
            m.find('.input-file').hide();
            m.find('.input-file').removeAttr('required');
            m.find('.input-url').show();
            m.find('.input-url').attr('required');
        }
        console.log(type);
    });
    function initUpdateDocument() {
        var m = $('#modalDokumen');
        m.find('.group-radio-dokumen').show();
        m.find('.group-label-dokumen').hide();
    }
    function detailDokumen(index) {
        formDokumenReset = true;
        var m = $('#modalDokumen');
        var d = sortDokumen[index];
        m.modal('show');
        m.find('.modal-title').text('Detail Dokumen');
        m.find('.select-2').val(null).trigger('change');
        m.find('.select-2').val(d.dokumen_pasal).trigger('change');
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
//        m.find('.radio-type-dokumen').filter('[value=' + d.type_doc + ']').prop('checked', true);
        m.find('.input-path').hide();
        m.find('.fa-trash').hide();
        m.find('.group-radio-dokumen').hide();
        m.find('.group-label-dokumen').show();
        m.find('.label-path').val(d.type_doc == 'FILE' ? d.file : d.url);
        m.find('input, select, textarea').prop('disabled', true);
    }
    function editDokumen(index) {
        detailDokumen(index);
        formDokumenReset = true;
        var m = $('#modalDokumen');
        m.find('.modal-title').text('Edit Dokumen');
        m.find('.btn-submit').show();
        m.find('.radio-type-dokumen').prop('checked', false);
        m.find('.radio-type-dokumen').prop('required', false);
        m.find('.input-id').val(sortDokumen[index].id);
        m.find('input, select, textarea').prop('disabled', false);
        m.find('.input-path').prop('required', false);
        m.find('.fa-trash').show();
    }
    function initHapusDokumen(index) {
        var m = $('#modalDeleteDokumen');
        var d = sortDokumen[index];
        m.modal('show');
        m.find('.input-pasal').val(sortPasal[d.index_pasal].fullname);
        m.find('.input-nomor').val(d.nomor);
        m.find('.input-judul').val(d.judul);
        m.find('.input-distribusi').val(d.distribusi.length);
        m.find('.input-jadwal').val(d.c_imp);
        if (d.c_imp != 0 | d.distribusi.length != 0 | d.child_document != 0) {
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
        var m = $('#modalDistribusi');
        m.find('.group-detail').show();
        m.find('.group-edit').hide();
        m.find('.label-user-disrtibusi').empty();
        var user = sortDokumen[sortJadwal[index].index_dokumen].user_distribusi;
        m.find('.label-user-distribusi').empty();
        for (var i = 0; i < user.length; i++) {
            m.find('.label-user-distribusi').append('<div>' + user[i] + '</div>');
        }
    }
    function editDistribusi(index) {
        var m = $('#modalDistribusi');
        var d = sortDokumen[index];
        m.modal('show');
        m.find('.label-pasal').html(d.txt_pasals);
        m.find('.label-judul').text(d.judul);
        m.find('.label-jenis').text('Level ' + d.jenis);
        m.find('.label-klasifikasi').text(d.klasifikasi);
        m.find('.label-pembuat-dokumen').text(d.creator_name);
        m.find('.input-dokumen-id').val(d.id);
        m.find('.group-detail').hide();
        m.find('.group-edit').show();
        if (d.contoh != null) {
            m.find('.label-dokumen-terkait').text($('#modalDokumen').find('select[name=dokumen_terkait]').find('option[value=' + d.contoh + ']').text());
        } else {
            m.find('.label-dokumen-terkait').text('-');
        }
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
    function initCreateTugas(index) {
        var m = $('#modalTugas');
        var d = sortDokumen[index];
        m.modal('show');
        m.find('form').trigger('reset');
        m.find('.modal-title').text('Tambah Tugas');
        m.find('.input-id').val('');
        m.find('.input-document-id').val(d.id);
        m.find('.input-document-judul').val(d.judul);
    }
    $('#formTugas').on("submit", function (e) {
        console.log('post');
        e.preventDefault();
        post(this, 'tugas');
    });
    function detailTugas() {
        
    }
    function initEditTugas(index) {
        var t = sortTugas[index];
        var m = $('#modalTugas');
        m.modal('show');
        m.find('.modal-title').text('Edit Tugas');
        m.find('.input-id').val(t.id);
        m.find('.input-document-id').val(t.id_document);
        m.find('.input-document-judul').val(sortDokumen[t.index_document].judul);
        m.find('.input-tugas').val(t.nama);
        m.find('.input-sifat').val(t.sifat);
    }
    function post(form, url) {
        $('.modal').modal('hide');
        $('#modalNotif .modal-title').text('Menyimpan data...');
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
                        $('#modalNotif .modal-message').html('Data Berhasil Disimpan');
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
                var d = sortDokumen[docs[i]];
                $('.select-dokumen-pasal').append('<option value="' + docs[i] + '">' + d.judul + '</option>');
            }
        }
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
    function detailJadwal(index, disData = null) {
        var imp = sortImplementasi[index];
        var jadwal = sortJadwal[imp.index_jadwal];
        var m = $('#modalDetailJadwal');
        m.modal('show');
        m.find('.modal-title').text('Detail Jadwal');
        m.find('.btn-batal').text('Tutup');
        m.find('.btn-hapus').addClass('d-none');
        m.find('.modal-body').empty();
        var penerima_doc = '';
        var user = sortDokumen[jadwal.index_dokumen].user_distribusi;
        for (var i = 0; i < user.length; i++) {
            penerima_doc += '<div>' + user[i] + '</div>';
        }
        var data = {
            Pasal: sortPasal[sortDokumen[jadwal.index_dokumen].index_pasal].fullname,
            Dokumen: sortDokumen[jadwal.index_dokumen].judul,
            Tugas: imp.desc == "" ? '-' : imp.desc,
            'Pembuat Dokumen': (sortDokumen[jadwal.index_dokumen].index_creator == null ? '-' : anggota[sortDokumen[jadwal.index_dokumen].index_creator].fullname),
            'Penerima Dokumen': penerima_doc,
            'Tanggal Implementasi': $.format.date(new Date(imp.date_jadwal), "dd-MMM-yyyy"),
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
            data['Tanggal Mulai'] = $.format.date(new Date(jadwal.start_date), "dd-MMM-yyyy");
            data['Tanggal Selesai'] = $.format.date(new Date(jadwal.end_date), "dd-MMM-yyyy");
            data.Hari = txtHari;
            data.Periode = (jadwal.periode == null ? '-' : '<span class="badge badge-primary">' + jadwal.periode + '</span>');
        } else {
            data.Ulangi = '<span class="badge badge-secondary">TIDAK</span>';
        }
        if (disData != null) {
            data['Status Distribusi'] = disData.status;
            data['Dokumen Distribusi'] = disData.dokumen;
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
    function initUploadImplementasi(index) {
        var imp = sortImplementasi[index];
        var m = $('#modalUploadImplementasi');
        m.modal('show');
        m.find('.input-id').val(imp.id);
        m.find('.input-id-jadwal').val(imp.id_jadwal);
        m.find('.input-jadwal').val($.format.date(new Date(imp.date_jadwal), "dd-MMM-yyyy"));
        m.find('.input-judul').val(sortDokumen[sortJadwal[imp.index_jadwal].index_dokumen].judul);
        m.find('.modal-title').text('Upload Bukti');
        m.find('.group-upload').show();
        m.find('.group-detail').hide();
    }
    function detailImplementasi(index) {
        var imp = sortImplementasi[index];
        var uploadStatus = '';
        if (imp.path) {
            if (new Date() > new Date(imp.date_jadwal, 'YYYY-MM-DD')) {
                uploadStatus = '<span class="badge badge-danger">Terlambat</span>';
            } else {
                uploadStatus = '<span class="badge badge-primary">Selesai</span>';
            }
        }
        var data = {
            status: uploadStatus,
            dokumen: '<div><span class="badge badge-primary">' + imp.type + '</div>'
                    + '<div>' + imp.path + '</div>',
        }
        detailJadwal(index, data);
    }
    $('#formUploadImplementasi').submit(function (e) {
        var m = $('#modalUploadImplementasi');
        m.modal('hide');
        e.preventDefault();
        var status = 'Error';
        $('#modalNotif .modal-title').text('Uploading...');
        $('#modalNotif .modal-message').empty();
        $('#modalNotif').modal('show');
        $.ajax({
            url: '<?php echo site_url($module . '/upload_bukti') ?>',
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
//                        console.log($(this));
                    formDokumenReset = true;
                    getPasal();
                    $('#modalNotif .modal-message').html('Data Berhasil Disimpan');
                } else if (data.status === 'error') {
                    $('#modalNotif .modal-message').html(data.message);
                } else {
                    $('#modalNotif .modal-message').html(data);
                }
            },
            error: function (data) {
                $('#modalNotif .modal-message').text('Error 500');
            },
            complete: function () {
                $('#modalNotif .modal-title').text(status);
            }
        });
    });
</script>