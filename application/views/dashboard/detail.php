<?php
if (empty($this->session->activeCompany)) {
    echo 'Belum ada perusahaan';
} else {
    $activeStandard = $this->session->userdata('activeStandard');
    ?>
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-home icon-gradient bg-mean-fruit">
                    </i>
                </div>
                <?php if (empty($this->session->user['id_company'])) { ?>
                    <button type="button" title="Pilih Perusahaan" data-toggle="dropdown" class="btn-shadow mr-3 btn btn-dark">
                        <i class="fa fa-angle-double-down"></i>
                    </button>
                    <div id="company-dropdown" tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu">
                        <ul class="nav flex-column">
                            <?php foreach ($companies as $k => $c) { ?>
                                <li class="nav-item">
                                    <a href="<?= site_url($module . '?company=' . $c['id']); ?>" class="nav-link">
                                        <i class="nav-link-icon lnr-inbox"></i>
                                        <span>
                                            <?= $c['name'] ?>
                                        </span>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>
                <div>
                    <span id="company-title">
                        <?= $this->session->activeCompany['name'] ?>
                    </span>
                    <!--                <div class="page-title-subheading">
                                        Informasi penting seperti executive summary ditampilkan pada halaman dashboard ini.
                                    </div>-->
                </div>
            </div>
            <div class="page-title-actions">
                <button type="button" data-toggle="tooltip" title="Standar Aktif" data-placement="bottom" class="btn-shadow mr-3 btn btn-dark">
                    <i class="fa fa-star"></i>
                </button>
                <div class="d-inline-block dropdown">
                    <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn-shadow dropdown-toggle btn btn-info">
                        <span class="btn-icon-wrapper pr-2 opacity-7">
                            <i class="fa fa-file fa-w-20"></i>
                        </span>
                        <?= empty($activeStandard) ? '-' : $activeStandard['name'] ?>
                    </button>
                    <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                        <ul class="nav flex-column">
                            <?php foreach ($company_standard as $cs) { ?>
                                <li class="nav-item">
                                    <a href="<?= site_url($module . '?standard=' . $cs['id']); ?>" class="nav-link">
                                        <i class="nav-link-icon lnr-inbox"></i>
                                        <span>
                                            <?= $cs['name'] ?>
                                        </span>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>   
        </div>
    </div>
    <?php
    if (empty($activeStandard)) {
        echo 'Perusahaan ini belum memiliki standar';
    } else {
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
                        <!--<canvas id="radar-chart"></canvas>-->
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-6">
                <div class="mb-3 card">
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
                                <canvas id="chart-area"></canvas>
                            </div>
                        </div>
                        <div class="pt-2 card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="widget-content">
                                        <div class="widget-content-outer">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left">
                                                    <div class="widget-numbers fsize-3 text-muted">63%</div>
                                                </div>
                                                <div class="widget-content-right">
                                                    <div class="text-muted opacity-6">Terlambat</div>
                                                </div>
                                            </div>
                                            <div class="widget-progress-wrapper mt-1">
                                                <div class="progress-bar-sm progress-bar-animated-alt progress">
                                                    <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="63" aria-valuemin="0" aria-valuemax="100" style="width: 63%;"></div>
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
                                                    <div class="widget-numbers fsize-3 text-muted">32%</div>
                                                </div>
                                                <div class="widget-content-right">
                                                    <div class="text-muted opacity-6">Selesai</div>
                                                </div>
                                            </div>
                                            <div class="widget-progress-wrapper mt-1">
                                                <div class="progress-bar-sm progress-bar-animated-alt progress">
                                                    <div class="progress-bar bg-success" role="progressbar" aria-valuenow="32" aria-valuemin="0" aria-valuemax="100" style="width: 32%;"></div>
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
                                                    <div class="widget-numbers fsize-3 text-muted">71%</div>
                                                </div>
                                                <div class="widget-content-right">
                                                    <div class="text-muted opacity-6">Mendatang</div>
                                                </div>
                                            </div>
                                            <div class="widget-progress-wrapper mt-1">
                                                <div class="progress-bar-sm progress-bar-animated-alt progress">
                                                    <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="71" aria-valuemin="0" aria-valuemax="100" style="width: 71%;"></div>
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
                                                    <div class="widget-numbers fsize-3 text-muted">41%</div>
                                                </div>
                                                <div class="widget-content-right">
                                                    <div class="text-muted opacity-6">Hari Ini</div>
                                                </div>
                                            </div>
                                            <div class="widget-progress-wrapper mt-1">
                                                <div class="progress-bar-sm progress-bar-animated-alt progress">
                                                    <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="41" aria-valuemin="0" aria-valuemax="100" style="width: 41%;"></div>
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
                <div class="mb-3 card">
                    <div class="card-header-tab card-header">
                        <div class="card-header-title">
                            <i class="header-icon lnr-rocket icon-gradient bg-tempting-azure"> </i>
                            Distribusi Pasal dan Dokumen
                        </div>
                        <div class="btn-actions-pane-right">
                            <div class="nav">
                                <a href="javascript:void(0);" class="border-0 btn-pill btn-wide btn-transition active btn btn-outline-alternate">1</a>
                                <a href="javascript:void(0);" class="ml-1 btn-pill btn-wide border-0 btn-transition  btn btn-outline-alternate second-tab-toggle-alt">2</a>
                                <a href="javascript:void(0);" class="ml-1 btn-pill btn-wide border-0 btn-transition  btn btn-outline-alternate second-tab-toggle-alt">3</a>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="tab-eg-55">

                            <div class="card-body"><h6 class="">-</h6>
                                <table class="mb-0 table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Unit Kerja</th>
                                            <th>Pasal</th>
                                            <th>Dokumen</th>
                                            <th>Implementasi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>IT</td>
                                            <td>Pasal 1</td>
                                            <td class="text-center">13</td>
                                            <td class="text-center">17</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">2</th>
                                            <td>Pengadaan</td>
                                            <td>Pasal 2</td>
                                            <td class="text-center">36</td>
                                            <td class="text-center">76</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">3</th>
                                            <td>Sumber Daya Manusia</td>
                                            <td>Pasal 3</td>
                                            <td class="text-center">24</td>
                                            <td class="text-center">54</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">4</th>
                                            <td>Administrasi</td>
                                            <td>Pasal 4</td>
                                            <td class="text-center">20</td>
                                            <td class="text-center">14</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">5</th>
                                            <td>General Affair</td>
                                            <td>Pasal 5</td>
                                            <td class="text-center">19</td>
                                            <td class="text-center">13</td>
                                        </tr>
                                        <tr>
                                            <th scope="row"></th>
                                            <td></td>
                                            <td>Pasal 6</td>
                                            <td class="text-center">19</td>
                                            <td class="text-center">12</td>
                                        </tr>
                                        <tr>
                                            <th scope="row"></th>
                                            <td></td>
                                            <td>Pasal 7</td>
                                            <td class="text-center">10</td>
                                            <td class="text-center">3</td>
                                        </tr>
                                        <tr>
                                            <th scope="row"></th>
                                            <td></td>
                                            <td>Pasal 8</td>
                                            <td class="text-center">2</td>
                                            <td class="text-center">1</td>
                                        </tr>
                                        <tr>
                                            <th scope="row"></th>
                                            <td></td>
                                            <td>Pasal 9</td>
                                            <td class="text-center">13</td>
                                            <td class="text-center">8</td>
                                        </tr>
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
                                <div class="widget-numbers text-success">17</div>
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
                                <div class="widget-numbers text-warning">4</div>
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
                                <div class="widget-numbers text-danger">14</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-header">Tugas Hari Ini
                        <div class="btn-actions-pane-right">
                            <div role="group" class="btn-group-sm btn-group">
                                <button class="active btn btn-focus">Hari ini</button>
                                <button class="active btn btn-focus">Minggu ini</button>
                                <button class="active btn btn-focus">Bulan ini</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">Total Tugas: 11, Selesai: 9</div>
                    <div class="table-responsive">
                        <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Personil</th>
                                    <th class="text-center">Tugas</th>
                                    <th class="text-center">Pasal</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center text-muted">#345</td>
                                    <td>
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left mr-3">
                                                    <div class="widget-content-left">
                                                        <img width="40" class="rounded-circle" src="assets/images/avatars/4.jpg" alt="">
                                                    </div>
                                                </div>
                                                <div class="widget-content-left flex2">
                                                    <div class="widget-heading">John Doe</div>
                                                    <div class="widget-subheading opacity-7">IT</div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">Melakukan Back Up Server</td>
                                    <td class="text-center">Pasal 8</td>
                                    <td class="text-center">
                                        <div class="badge badge-success">Completed</div>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" id="PopoverCustomT-1" class="btn btn-primary btn-sm">Details</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center text-muted">#347</td>
                                    <td>
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left mr-3">
                                                    <div class="widget-content-left">
                                                        <img width="40" class="rounded-circle" src="assets/images/avatars/3.jpg" alt="">
                                                    </div>
                                                </div>
                                                <div class="widget-content-left flex2">
                                                    <div class="widget-heading">Ruben Tillman</div>
                                                    <div class="widget-subheading opacity-7">SDM</div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">Membuat Matriks Kompetensi</td>
                                    <td class="text-center">Pasal 6</td>
                                    <td class="text-center">
                                        <div class="badge badge-success">Completed</div>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" id="PopoverCustomT-2" class="btn btn-primary btn-sm">Details</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center text-muted">#321</td>
                                    <td>
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left mr-3">
                                                    <div class="widget-content-left">
                                                        <img width="40" class="rounded-circle" src="assets/images/avatars/2.jpg" alt="">
                                                    </div>
                                                </div>
                                                <div class="widget-content-left flex2">
                                                    <div class="widget-heading">Elliot Huber</div>
                                                    <div class="widget-subheading opacity-7">GA</div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">Melakukan Review Jadwal Perawatan</td>
                                    <td class="text-center">Pasal 8</td>
                                    <td class="text-center">
                                        <div class="badge badge-danger">Terlambat</div>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" id="PopoverCustomT-3" class="btn btn-primary btn-sm">Details</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center text-muted">#55</td>
                                    <td>
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left mr-3">
                                                    <div class="widget-content-left">
                                                        <img width="40" class="rounded-circle" src="assets/images/avatars/1.jpg" alt=""></div>
                                                </div>
                                                <div class="widget-content-left flex2">
                                                    <div class="widget-heading">Vinnie Wagstaff</div>
                                                    <div class="widget-subheading opacity-7">IT</div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">Backup Data Pengguna Aplikasi</td>
                                    <td class="text-center">Pasal 8</td>
                                    <td class="text-center">
                                        <div class="badge badge-info">Menunggu</div>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" id="PopoverCustomT-4" class="btn btn-primary btn-sm">Details</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-block text-center card-footer">
                        <!-- <button class="mr-2 btn-icon btn-icon-only btn btn-outline-danger"><i class="pe-7s-trash btn-icon-wrapper"> </i></button>
                        <button class="btn-wide btn btn-success">Save</button> -->
                        <button class="mr-2 btn-icon btn-icon-only btn btn-outline-info"><i class="pe-7s-right-arrow btn-icon-wrapper"> </i></button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            console.log(<?= $progressImp ?>);
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
                hope.push(70);
            }
            $('#averageDoc').text(average(doc));
            $('#averageImp').text(average(imp));
            chart = new Chart(document.getElementById('chartPemenuhan'), {
                type: 'radar',
                data: {
                    labels: label,
                    datasets: [{
                            label: 'Dokumen',
                            data: doc,
                            borderColor: 'rgba(255, 0, 0, 1)',
                            borderWidth: 1
                        }, {
                            label: 'Harapan',
                            data: hope,
                            borderColor: 'rgba(0, 255, 0, 1)',
                            borderWidth: 1
                        }, {
                            label: 'Implementasi',
                            data: imp,
                            borderColor: 'rgba(0, 0, 255, 1)',
                            borderWidth: 1
                        }]
                },
                options: {
        //                    title: {
        //                        display: true,
        //                        text: 'Grafik Pemenuhan Dokumen dan Standar',
        //                        position: 'bottom',
        //                    },
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
        </script>
    <?php } ?>
    <script>
        function afterReady() {}
        $('.app-page-title').first().hide();
    </script>
<?php } ?>