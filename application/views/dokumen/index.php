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
                    <li class="nav-item"><a data-toggle="tab" href="#tab-pasal" class="nav-link">Pasal</a></li>
                    <li class="nav-item"><a data-toggle="tab" href="#tab-dokumen" class="nav-link">Dokumen</a></li>
                    <li class="nav-item"><a data-toggle="tab" href="#tab-distribusi" class="nav-link">Distribusi</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane" id="tab-test" role="tabpanel"></div>
                    <!--PASAL-->
                    <div class="tab-pane" id="tab-pasal" role="tabpanel">
                        <div class="row div-filter">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-3"></div>
                            <div class="col-sm-3"></div>
                            <div class="col-sm-3"></div>
                        </div>
                        <table class="table table-striped" id="table-pasal">
                            <thead>
                                <tr>
                                    <th>Pasal</th>
                                    <th>Judul</th>
                                    <th>Deskripsi</th>
                                    <th>Dokumen</th>
                                    <th style="min-width: 0px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <!--DOKUMEN-->
                    <div class="tab-pane" id="tab-dokumen" role="tabpanel">
                        <div class="row div-filter">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-3"></div>
                            <div class="col-sm-3"></div>
                            <div class="col-sm-3"></div>
                        </div>
                        <table class="table table-striped" id="table-document">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Pasal</th>
                                    <th>Revisi</th>
                                    <th>Level</th>
                                    <th>Klasifikasi</th>
                                    <th class="col-aksi" style="min-width: 70px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <!--DISTRIBUSI-->
                    <div class="tab-pane" id="tab-distribusi" role="tabpanel">
                        <div class="row div-filter">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-3"></div>
                            <div class="col-sm-3">
                                <select class="form-control form-control-sm filter-unit-kerja" onchange="filterUnitKerja(this, tbDistribusi, 4)"></select>
                            </div>
                            <div class="col-sm-3">
                                <select class="form-control form-control-sm filter-personil" onchange="filterPersonil(this, tbDistribusi, 4)"></select>
                            </div>
                        </div>
                        <table class="table table-striped" id="table-distribusi">
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
                            <tbody></tbody>
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
    <div class="modal-dialog modal-xl" style="max-width:900px">
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
                                <th>No</th>
                                <th>Judul Dokumen</th>
                                <th>Pasal Terkait</th>
                                <th style="width: 40%">Letak Pasal pada Dokumen</th>
                                <th style="width: 90px">Aksi</th>
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
        <form id="formUploadDocument">
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
<!--MODAL DETAIL DOCUMENT-->
<div class="modal fade" id="modalDetailDocument">
    <div class="modal-dialog" role="document">
        <form method="post">
            <input class="input-id" name="id" hidden="">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Dokumen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body modal-message"></div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!--MODAL EDIT DOKUMEN-->
<div class="modal fade" id="modalDokumen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post" class="formDokumen">
            <input class="input-id" name="id" hidden="">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Dokumen</h5>
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
                                    <select class="form-control select-personil select-creator" name="creator"></select>
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
                                    <textarea class="form-control textarea-deskripsi" name="desc"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>Revisi Dokumen</td>
                                <td>
                                    <input class="form-control input-versi" name="versi">
                                </td>
                            </tr>
                            <tr>
                                <td>Dokumen terkait</td>
                                <td>
                                    <select name="documents[]" class="form-control select-2 select-2-document multiselect-dropdown" multiple="" style="width: 330px !important; margin-top: 100px"></select>
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
                                        <input class="form-control input-path input-url" type="url" name="url" required="" placeholder="http://">
                                    </div>
                                    <div class="input-group mb-3 group-label-dokumen">
                                        <input class="form-control label-path" readonly="">
                                        <div class="input-group-append">
                                            <i class="btn btn-outline-danger btn-sm pull-right fa fa-trash" onclick="initEditPathDocument()"></i>
                                        </div>
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
                    <input class="form-control input-delete" name="delete-id" hidden="">
                    <input class="form-control input-document-id" name="id-document" hidden="">
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Dokumen</label>
                        <input class="form-control input-document-judul" disabled="">
                    </div>
                    <div class="form-group">
                        <label>Tugas</label>
                        <input class="form-control input-field input-tugas" name="tugas" required="">
                    </div>
                    <div class="form-group item-edit">
                        <label>Form Terkait</label>
                        <select class="form-control input-field input-form-terkait" name="form_terkait"></select>
                    </div>
                    <div class="form-group item-view group-form-terkait">
                        <label>Form Terkait</label>
                        <div class="input-group">
                            <input class="form-control input-detail-form-terkait" readonly="">
                            <div class="input-group-append">
                                <i class="btn btn-outline-primary btn-sm pull-right fa fa-search" onclick=""></i>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Sifat</label>
                        <select class="form-control input-field input-sifat" name="sifat" required="">
                            <option value="">-- sifat --</option>
                            <option value="WAJIB">Wajib</option>
                            <option value="SITUASIONAL">Situasional</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>PIC Pelaksana</label>
                        <br>
                        <select class="form-control input-field select-2 multiselect-dropdown" multiple="" style="width: 450px !important;" name="penerima[]"></select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary item-edit btn-save">Simpan</button>
                    <button type="submit" class="btn btn-danger item-edit btn-delete" name="delete">Hapus</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!--MODAL CREATE JADWAL-->
<div class="modal fade" id="modalCreateJadwal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="formCreateJadwal">
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
                                <td>Tugas</td>
                                <td>
                                    <input class="form-control input-tugas" readonly="">
                                    <input class="input-id-tugas" name="id-tugas" hidden="">
                                </td>
                            </tr>
                            <tr>
                                <td id="tglMulaiJadwal">Tanggal</td>
                                <td>
                                    <input class="form-control input-jadwal" autocomplete="off" name="tanggal[]" required="">
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
                                    <input class="form-control input-jadwal" autocomplete="off" name="tanggal_selesai" required="">
                                </td>
                            </tr>
                            <tr class="group-input-repeat">
                                <td>Periode</td>
                                <td>
                                    <select name="periode" class="form-control select-periode">
                                        <option value="MINGGU">Mingguan</option>
                                        <option value="BULAN">Bulanan</option>
                                        <option value="TAHUN">Tahunan</option>
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
<!--MODAL JADWAL-->
<div class="modal fade" id="modalJadwal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="formJadwal">
                <div class="modal-header">
                    <h5 class="modal-title">Jadwal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <input class="form-control input-id" name="id" hidden="">
                    <input class="form-control input-delete-id" name="id-delete" hidden="">
                </div>
                <div class="modal-body modal-message">
                    <div class="form-group">
                        <label>Tugas</label>
                        <input class="form-control input-tugas" disabled="">
                    </div>
                    <div class="form-group">
                        <label>Tanggal</label>
                        <input class="form-control input-field input-jadwal" name="tanggal">
                    </div>
                    <div class="form-group detail-jadwal">
                        <label>Status</label>
                        <input class="form-control input-field input-status">
                    </div>
                    <div class="form-group detail-jadwal">
                        <label>Sifat</label>
                        <input class="form-control input-field input-sifat">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-dismiss="modal">Batal</button>
                    <button class="btn btn-primary btn-submit btn-save">Simpan</button>
                    <button class="btn btn-danger btn-submit btn-delete">Hapus</button>
                </div>
            </form>
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
                <input class="input-id" name="id" hidden=""/>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Tugas</label>
                        <input class="form-control input-tugas" disabled="">
                    </div>
                    <div class="form-group">
                        <label>Tanggal</label>
                        <input class="form-control input-field input-jadwal" name="tanggal" disabled="">
                    </div>
                    <div class="form-group">
                        <label>Dokumen</label>
                        <div id="tdUpload">
                            <input class="radio-type-dokumen" type="radio" name="type_dokumen" value="FILE" required="">
                            <label>File</label>
                            <input class="radio-type-dokumen" type="radio" name="type_dokumen" value="URL">
                            <label>Url</label>
                            <input class="form-control input-path input-file" type="file" name="dokumen" required="">
                            <input class="form-control input-path input-url" type="url" name="url" required="">
                        </div>
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
<!--MODAL DETAIL-->
<div class="modal fade" id="modalDetail">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button class="btn btn-primary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        if (role != 'admin') {
            $('.group-select-perusahaan').hide();
            idPersonil = <?= $personil ?>;
        }
        $('#perusahaan').change();
        $('#tab-pasal').addClass('active');
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
        tbDocument = $('#table-document').DataTable({
            "order": [],
            "ordering": true,
            "paging": false,
            "search": {
                "smart": false
            },
            "bInfo": false,
            "bLengthChange": true,
            "language": {
                "emptyTable": "Maaf, Anda masih belum memiliki dokumen. Upload dokumen Anda pada Tab Pasal."
            },
        });
        tbDistribusi = $('#table-distribusi').DataTable({
            "order": [],
            "ordering": true,
            "paging": false,
            "search": {
                "smart": false
            },
            "bInfo": false,
            "bLengthChange": true,
            "language": {
                "emptyTable": "Untuk melakukan distribusi dokumen, pertama ubah dahulu data Jenis Dokumen pada Tab Dokumen, menjadi Level 1 / Level 2 / Level 3. Untuk dokumen Level 4 akan diatur distribusinya pada Tab Tugas."
            },
        });
        tbImplementasi = $('#table-implementasi').DataTable({
            "order": [],
            "ordering": true,
            "paging": false,
            "search": {
                "smart": false
            },
            "bInfo": false,
            "bLengthChange": true,
            "language": {
                "emptyTable": "Belum ada jadwal implementasi yang dibuat."
            },
        });
        dataTableConfig['ordering'] = false;
        tbPemenuhan = $('#table-pemenuhan').DataTable(dataTableConfig);
        tbPasal = $('#table-pasal').DataTable(dataTableConfig);
        tbJadwal = $('#table-jadwal').DataTable({
            "order": [],
            "ordering": false,
            "paging": false,
            "search": {
                "smart": false
            },
            "bInfo": false,
            "bLengthChange": true,
            "language": {
                "emptyTable": "Untuk membuat jadwal, buat dahulu detail tugas yang perlu dikerjakan pada Tab Tugas."
            },
        });
        tbTugas = $('#table-tugas').DataTable({
            "order": [],
            "ordering": false,
            "paging": false,
            "search": {
                "smart": false
            },
            "bInfo": false,
            "bLengthChange": true,
            "language": {
                "emptyTable": "Untuk membuat tugas, pertama ubah dahulu data Jenis Dokumen pada Tab Dokumen, menjadi Level 1 / Level 2 / Level 3 / Level 4"
            },
        });
        $('.dataTables_filter').hide();
        $('.dataTables_filter .form-control').attr('placeholder', 'Search');
        $('.tab-pane').each(function (index) {
            $(this).find('.div-filter .col-sm-3').eq(0).append($(this).find('.dataTables_filter .form-control'));
        });
    });
    function afterReady() {
        perusahaan = <?= $this->session->activeCompany['id'] ?>;
        standar = <?= $this->session->activeStandard['id'] ?>;
        $.post('<?php echo site_url($module); ?>/unit_kerja', {'perusahaan': perusahaan}, function (data) {
            unitKerja = JSON.parse(data);
            $('.select-unit-kerja').empty();
            $('.filter-unit-kerja').empty();
            $('.select-unit-kerja').append('<option value="">-- Pilih Unit Kerja --</option>');
            $('.filter-unit-kerja').append('<option value="">-- Pilih Unit Kerja --</option>');
            for (var i = 0; i < unitKerja.length; i++) {
                var uk = unitKerja[i];
                $('.select-unit-kerja').append('<option value="' + uk.id + '">' + uk.name + '</option>');
                $('.filter-unit-kerja').append('<option value="' + uk.name + '">' + uk.name + '</option>');
            }
        });
        $.post('<?php echo site_url($module); ?>/personil', {'perusahaan': perusahaan}, function (data) {
            personil = JSON.parse(data);
            $('.select-personil').empty();
            $('.filter-personil').empty();
            $('.select-creator').append('<option value="">---</option>');
            $('.filter-personil').append('<option value="">-- Pilih Personil --</option>');
            for (var i = 0; i < personil.length; i++) {
                var p = personil[i];
                $('.select-personil').append('<option value="' + p.id + '">' + p.fullname + '</option>');
                $('.filter-personil').append('<option value="' + p.fullname + '">' + p.fullname + '</option>');
            }
        });
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
            getDokumen();
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
    function getDokumen() {
//        loadPage('dokumen_tabel', '#tab-test');
        $.getJSON('<?php echo site_url($module); ?>/get_dokumen', {'perusahaan': perusahaan, 'standar': standar}, function (data) {
            tbDocument.clear();
            tbDistribusi.clear();
            $('.select-dokumen').empty();
            $('.select-2-document').empty();
            $('.select-dokumen').append('<option value="">-- -- --</option>');
            sortDokumen = [];
            var n = 0;
            var nDoc = 0;
            var descLimit = 160;
            for (var i = 0; i < data.length; i++) {
                var d = data[i];
                d.index_dokumen_pasal = [];
                d.txt_pasals = '';
                d.txt_pasals2 = '<div class="more-pasal-parent">';
                var n2 = 0;
                for (var j = 0; j < d.dokumen_pasal.length; j++) {
                    for (var k = 0; k < sortPasal.length; k++) {
                        if (d.dokumen_pasal[j] == sortPasal[k].id) {
                            d.index_dokumen_pasal.push(k);
                            sortPasal[k].index_documents.push(i);
                            if (d.deskripsi != null) {
                                if (d.deskripsi.length > descLimit) {
                                    d.custom_deskripsi = '<div class="desc-parent">' + d.deskripsi.substring(0, descLimit);
                                    d.custom_deskripsi += '<span class="desc-more" style="display: none">' + d.deskripsi.substring(descLimit)
                                            + '<div class="text-primary btn-less" style="cursor:pointer" onclick="hideMoreDesc(this)">Sembunyikan</div></span>';
                                    d.custom_deskripsi += '<div class="text-primary btn-more" style="cursor:pointer" onclick="showMoreDesc(this)">lihat lebih lengkap</div>';
                                    d.custom_deskripsi += '</div>';
                                } else {
                                    d.custom_deskripsi = d.deskripsi;
                                }
                            } else {
                                d.custom_deskripsi = '-';
                            }
                            d.txt_pasals += '<div><span class="badge badge-secondary">' + sortPasal[k].fullname + '</span></div>';
                            if (n2 == 10) {
                                d.txt_pasals2 += '<div class="text-primary btn-show-more-pasal" style="cursor:pointer" onclick="showMorePasal(this)">lihat lebih lengkap</div>'
                                        + '<div class="more-pasal-child" style="display: none">'
                            }
                            d.txt_pasals2 += '<div><span class="badge badge-secondary">' + sortPasal[k].fullname + '</span></div>';
                            n2++;
                        }
                    }
                }
                if (n2 > 10) {
                    d.txt_pasals2 += '<div class="text-primary btn-hide" style="cursor:pointer" onclick="hideMorePasal(this)">Sembunyikan</div></div>';
                }
                d.txt_pasals2 += '</div>';
                for (var j = 0; j < sortPasal.length; j++) {//TODO: remove later
                    sortPasal[j].dokumens = [];
                    var p = sortPasal[j];
                    if (d.id_pasal = p.id) {
                        d.index_pasal = j;
                        sortPasal[j].dokumens.push(n);
                    }
                }
                d.indexDistribusi = [];
                d.txtDistribusi = '';
                if (role == 'anggota') {
                    d.show = false
                } else {
                    d.show = true
                }
                for (var j = 0; j < d.distribution.length; j++) {
                    for (var k = 0; k < personil.length; k++) {
                        if (d.distribution[j] == personil[k].id) {
                            d.indexDistribusi.push(k);
                            d.txtDistribusi += '<div>' + personil[k].fullname + '</div>';
                            if (role == 'anggota') {
                                if (personil[k].id_personil == idPersonil) {
                                    d.show = true;
                                }
                            }
                            break;
                        }
                    }
                }
                if (d.pembuat == null) {
                    d.index_creator = null;
                    d.creator_name = '-';
                } else {
                    for (var j = 0; j < personil.length; j++) {
                        if (d.pembuat === personil[j].id) {
                            d.index_creator = j;
                            d.creator_name = personil[j].fullname;
                        }
                    }
                }
                d.index_form_terkait = null;
                for (var j = 0; j < data.length; j++) {
                    if (d.contoh == data[j].id) {
                        d.index_form_terkait = j;
                    }
                }
                d.index_documents_terkait = [];
                for (var j = 0; j < d.document_terkait.length; j++) {
                    for (var k = 0; k < data.length; k++) {
                        if (d.document_terkait[j] == data[k].id) {
                            d.index_documents_terkait.push(k);
                            break;
                        }
                    }
                }
                var btnDetail = '<span class="text-primary fa fa-info-circle" onclick="detailDocument(' + n + ')" title="Detail"></span>&nbsp';
                var btnEdit = '<span class="text-primary fa fa-edit" onclick="editDokumen(' + n + ')"></span>&nbsp';
                var btnDelete = '<span class="text-danger fa fa-trash" onclick="initHapusDokumen(' + n + ')"></span>';
                var show = true;
                if (d.show) {
                    tbDocument.row.add([
                        d.nomor,
                        d.judul,
                        d.txt_pasals2,
                        (d.versi == 0 | d.versi == null ? '-' : d.versi),
                        (d.jenis == null ? '-' : d.jenis),
                        (d.klasifikasi == null ? '-' : d.klasifikasi),
                        (role == 'anggota' ? btnDetail : btnDetail + btnEdit + btnDelete),
                    ]);
                    $('.select-dokumen').append('<option value="' + d.id + '">' + d.judul + '</option>');
                    $('.select-2-document').append('<option value="' + d.id + '">' + d.judul + '</option>');
                    var btnDetail = '<span class="text-primary fa fa-info-circle" title="Detail" onclick="detailDistribusi(' + n + ')"></span>&nbsp';
                    var btnEdit = '<span class="text-primary fa fa-edit" title="Edit" onclick="editDistribusi(' + n + ')"></span>';
                    if (d.jenis < 4 & d.jenis >= 1) {
                        nDoc++;
                        tbDistribusi.row.add([
                            d.nomor,
                            d.judul,
                            (d.jenis == null ? '-' : 'Level ' + d.jenis),
                            d.creator_name,
                            (role == 'anggota' ? d.txtDistribusi : d.txtDistribusi),
                            (role == 'anggota' ? btnDetail : btnDetail + btnEdit),
                        ]);
                    }
                }
                n++;
                d.index_tugas = [];
                sortDokumen.push(d);
            }
            tbDocument.draw();
            tbDistribusi.draw();
            getTugas();
        });
    }
    function getTugas() {
        $.getJSON('<?php echo site_url($module); ?>/get_tugas', {perusahaan: perusahaan, standar: standar}, function (data) {
            sortTugas = [];
            tbTugas.clear();
            $('.input-form-terkait').empty();
            $('.input-form-terkait').append('<option value="">-- form terkait --</option>');
            var nDoc = 0;
            for (var i = 0; i < sortDokumen.length; i++) {
                var d = sortDokumen[i];
                if (d.jenis < 4 & d.jenis >= 1) {
                    nDoc++;
                    if (d.show) {
                        tbTugas.row.add([
                            d.judul,
                            '',
                            '',
                            '',
                            '',
                            (role == 'anggota' ? '' : '<span class="text-primary fa fa-plus" title="Tambah" onclick="initCreateTugas(' + i + ')"></span>'),
                        ]);
                        var nTgs = 0;
                        for (var j = 0; j < data.length; j++) {
                            var t = data[j];
                            if (t.id_document == d.id) {
                                t.index_document = i;
                                sortDokumen[i].index_tugas.push(sortTugas.length);
                                t.indexPelaksana = [];
                                t.txt_personil = '';
                                if (role == 'anggota') {
                                    t.show = false
                                } else {
                                    t.show = true
                                }
                                for (var k = 0; k < t.personil.length; k++) {
                                    for (var l = 0; l < personil.length; l++) {
                                        if (t.personil[k] == personil[l].id) {
                                            t.indexPelaksana.push(l);
                                            t.txt_personil += '<div>' + personil[l].fullname + '</div>';
                                            if (role == 'anggota') {
                                                if (personil[l].id_personil == idPersonil) {
                                                    t.show = true;
                                                }
                                            }
                                            break;
                                        }
                                    }
                                }
                                t.index_form_terkait = null;
                                for (var k = 0; k < sortDokumen.length; k++) {
                                    if (t.form_terkait == sortDokumen[k].id) {
                                        t.index_form_terkait = k;
                                        break;
                                    }
                                }
                                var btnDetail = '<span class="text-primary fa fa-info-circle" title="Detail" onclick="detailTugas(' + sortTugas.length + ')"></span>&nbsp';
                                var btnEdit = '<span class="text-primary fa fa-edit" title="Edit" onclick="initEditTugas(' + sortTugas.length + ')"></span>&nbsp';
                                var btnHapus = '<span class="text-danger fa fa-trash" title="Hapus" onclick="initDeleteTugas(' + sortTugas.length + ')"></span>';
                                if (t.show) {
                                    if (nTgs == 3) {
                                        tbTugas.row.add([
                                            '',
                                            '',
                                            '',
                                            '<a class="text-primary tgs-btn-more' + i + '" onclick="showMoreTugas(' + i + ')">lihat lainnya</a>',
                                            '',
                                            '',
                                        ]);
                                    }
                                    var tr = tbTugas.row.add([
                                        '',
                                        t.nama,
                                        (t.index_form_terkait == null ? '-' : sortDokumen[t.index_form_terkait].judul),
                                        '<span class="badge badge-secondary">' + t.sifat + '</span>',
                                        t.txt_personil,
                                        (role == 'anggota' ? btnDetail : btnDetail + btnEdit + btnHapus),
                                    ]).node();
                                    if (nTgs >= 3) {
                                        $(tr).addClass('tgs-more' + i);
                                        $(tr).addClass('tgs-more');
                                    }
                                    nTgs++;
                                }
                                t.indexJadwal = [];
                                sortTugas.push(t);
                            }
                        }
                        if (nTgs >= 3) {
                            tbTugas.row.add([
                                '',
                                '',
                                '',
                                '<a class="text-primary tgs-more tgs-more' + i + '" onclick="hideMoreTugas(' + i + ')">sembunyikan</a>',
                                '',
                                '',
                            ]);
                        }
                    }
                } else if (d.jenis == 4) {
                    $('.input-form-terkait').append('<option value="' + d.id + '">' + d.judul + '</option>');
                }
            }
            tbTugas.draw();
            getJadwal();
            $('.tgs-more').hide();
        });
    }
    function getJadwal() {
        $.getJSON('<?= site_url($module); ?>/get_jadwal', {'perusahaan': perusahaan, 'standar': standar}, function (data) {
            tbJadwal.clear();
            tbImplementasi.clear();
            sortJadwal = [];
            var n = 0;
            for (var i = 0; i < sortTugas.length; i++) {
                var t = sortTugas[i];
                if (t.show) {
                    tbJadwal.row.add([
                        sortDokumen[t.index_document].judul,
                        t.nama,
                        (t.index_form_terkait == null ? '-' : sortDokumen[t.index_form_terkait].judul),
                        '---',
                        '---',
                        '---',
                        (role == 'anggota' ? '' : '<span class="text-primary fa fa-plus" title="Tambah" onclick="initCreateJadwal(' + i + ')"></span>'),
                    ]);
                    var nJd = 0;
                    for (var j = 0; j < data.length; j++) {
                        var jd = data[j];
                        if (jd.id_tugas == t.id) {
                            jd.status = 'menunggu';
                            var diffDate = '-';
                            uploadStatus = '<span class="badge badge-primary">Menunggu</span>';
                            if (jd.path && jd.upload_date && jd.doc_type) {
                                diffDate = new Date(jd.upload_date) - new Date(jd.tanggal);
                                diffDate = Math.ceil(diffDate / (1000 * 60 * 60 * 24));
                                if (new Date(jd.upload_date) > new Date(jd.tanggal)) {
                                    jd.status = 'terlambat';
                                    uploadStatus = '<span class="badge badge-danger">Terlambat</span>';
                                } else {
                                    jd.status = 'selesai';
                                    uploadStatus = '<span class="badge badge-success">Selesai</span>';
                                }
                            }
                            var btnDetail = '<span class="text-primary fa fa-info-circle" title="Detail" onclick="detailJadwal(' + n + ')"></span> ';
                            var btnEdit = '<span class="text-primary fa fa-edit" title="Edit" onclick="editJadwal(' + n + ')"></span> ';
                            var btnDelete = '<span class="text-danger fa fa-trash" title="Hapus" onclick="initDeleteJadwal(' + n + ')"></span>';
                            if (nJd == 3) {
                                tbJadwal.row.add([
                                    '',
                                    '',
                                    '',
                                    '<a class="text-primary jd-btn-more' + i + '" onclick="showMoreJadwal(' + i + ')">lihat lainnya</a>',
                                    '',
                                    '',
                                    '',
                                ]);
                            }
                            var tr = tbJadwal.row.add([
                                '---',
                                '---',
                                '---',
                                (jd.periode == null ? '-' : (jd.periode + 'AN')),
                                jd.tgl,
                                t.txt_personil,
                                btnDetail + (role == 'anggota' ? '' : btnEdit + btnDelete),
                            ]).node();
                            if (nJd >= 3) {
                                $(tr).addClass('jadwal-more' + i);
                                $(tr).addClass('jd-more');
                            }
                            var btnPreview = '';
                            if (jd.doc_type == 'FILE') {
                                btnPreview = '<a class="text-primary fa fa-download" href="<?= base_url('upload/implementasi') ?>/' + jd.path + '"></a>';
                            } else if (jd.doc_type == 'URL') {
                                btnPreview = '<a class="text-primary fa fa-search" target="_blank" href="' + jd.path + '"></a>';
                            }
                            jd.keterlambatan = diffDate > 0 ? diffDate + ' Hari' : '-';
                            tbImplementasi.row.add([
                                t.nama,
                                t.txt_personil,
                                jd.tgl,
                                '<div class="text-center">' + uploadStatus + '</div>',
                                '<div class="text-center">' + jd.keterlambatan + '</div>',
                                '<span class="text-primary fa fa-info-circle" title="Detail" onclick="detailImplementasi(' + n + ')"></span> '
                                        + '<span class="text-primary fa fa-upload" title="Edit" onclick="initUploadImplementasi(' + n + ')"></span> '
                                        + btnPreview
                            ]);
                            jd.indexTugas = i;
                            sortTugas[i].indexJadwal.push(n);
                            sortJadwal.push(jd);
                            n++;
                            nJd++;
                        }
                    }
                    if (nJd >= 3) {
                        tbJadwal.row.add([
                            '',
                            '',
                            '',
                            '<a class="text-primary jd-more jadwal-more' + i + '" onclick="hideMoreJadwal(' + i + ')">sembunyikan</a>',
                            '',
                            '',
                            '',
                        ]);
                    }
                }
            }
            tbJadwal.draw();
            tbImplementasi.draw();
            $('.jd-more').hide();
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
                            ps.fullname,
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
                    txtDoc += '<li>' + doc.judul + '</li>';
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
//        $.post('<?php // echo site_url($module);        ?>/set_distribusi', $(this).serialize(), function (data) {
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
    });
</script>