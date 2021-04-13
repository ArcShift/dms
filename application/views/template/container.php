<?php
//echo $x
$this->db->get('users');
$activeCompany = $this->session->activeCompany;
$this->db->join('company_standard cs', 'cs.id_standard = s.id AND cs.id_company = ' . $activeCompany['id']);
$company_standard = $this->db->get('standard s')->result_array();
if ($this->input->get('standard')) {
    redirect($module);
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Content-Language" content="en">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title><?= $this->config->item('short_app_name') . ' - ' . $this->config->item('app_name') ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
        <meta name="description" content="This is an example dashboard created using build-in elements and components.">
        <meta name="msapplication-tap-highlight" content="no">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css"/>
        <link rel="stylesheet" href="<?= base_url('assets/architectui/main.css') ?>" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
        <script type="text/javascript" src="<?= base_url('assets/js/main.js') ?>"></script>    
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-dateFormat/1.0/jquery.dateFormat.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw==" crossorigin="anonymous"></script>
        <script>
            function closeAlert(item) {
                console.log($(item).parent().remove());
            }
        </script>
        <style>
            .menu-item a{
                font-size: small;
            }
            table{
                font-size: .88rem;
            }
            .app-page-title{
                margin-bottom: 0px;
                padding: 20px;
                padding-left: 30px;
            }
        </style>
    </head>
    <body>
        <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
            <div class="app-header header-shadow">
                <div class="app-header__logo">
                    <div class="header__pane ml-auto">
                        <div>
                            <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="app-header__mobile-menu">
                    <div>
                        <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
                <div class="app-header__menu">
                    <span>
                        <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                            <span class="btn-icon-wrapper">
                                <i class="fa fa-ellipsis-v fa-w-6"></i>
                            </span>
                        </button>
                    </span>
                </div>
                <div class="app-header__content">
                    <div class="app-header-left">
                        <div class="search-wrapper">
                            <!--<form action="<?= site_url('document_search') ?>">-->
                            <div class="input-holder">
                                <input name="judul" class="search-input" placeholder="Cari judul dokumen">
                                <button type="button" class="search-icon"><span></span></button>
                            </div>
                            <!--</form>-->
                            <button class="close"></button>
                        </div>
                        <ul class="header-menu nav">
                            <li class="nav-item">
                                <a href="<?php echo site_url('dashboard') ?>" class="nav-link">
                                    <i class="nav-link-icon fa fa-home"> </i>
                                    <?php echo $this->config->item('app_name') ?>
                                </a>
                            </li>
                        </ul>    
                    </div>
                    <div class="app-header-right">
                        <div class="header-btn-lg pr-0">
                            <div class="widget-content p-0">
                                <div class="widget-content-wrapper">
                                    <a href="<?php echo site_url('account') ?>" class="nav-link font-weight-normal text-dark">
                                        <img width="42" height="42" class="rounded-circle" style="object-fit: cover" src="<?php echo empty($this->session->userdata('user')['photo']) ? base_url('assets/images/default_user.jpg') : base_url('upload/profile_photo/' . $this->session->userdata('user')['photo']) ?>" alt="">
                                        &nbsp;
                                        <div>
                                            <?= $this->session->userdata('user')['fullname'] . ' - ' . $this->session->userdata('user')['title'] ?>
                                        </div>
                                    </a>
                                    &nbsp;&nbsp;&nbsp;
                                    <a class="nav-link fa fa-bell text-dark" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        &nbsp;
                                        Notifikasi
                                        <?php if (!empty($count_unread)) { ?>
                                            <span class="text-danger"><?= $count_unread == 10 ? '+9' : $count_unread ?></span>
                                        <?php } ?>
                                    </a>
                                    <div class="dropdown-menu">
                                        <?php foreach ($notif as $k => $n) { ?>
                                            <?php if ($k < 4) { ?>
                                                <div class="alert alert-<?= $n['status'] == 'READ' ? 'secondary' : 'info' ?>" role="alert" style="margin-bottom: 3px; width: 350px">
                                                    <?= $n['pesan'] ?>
                                                    <div class="text-right"><small><?= $n['ago'] ?></small></div>
                                                </div>
                                            <?php } ?>
                                        <?php } ?>
                                        <a class="btn btn-sm btn-outline-primary form-control" href="<?= site_url('notif') ?>">Tampilkan lebih banyak</a>
                                    </div>
                                    &nbsp;&nbsp;&nbsp;
                                    <div >
                                        <a href="<?php echo site_url('account/logout') ?>" class="nav-link fa fa-sign-out-alt text-dark">
                                            &nbsp;
                                            <span>
                                                Logout
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="app-main">
                <div class="app-sidebar sidebar-shadow">
                    <div class="app-header__logo">
                        <div class="logo-src"></div>
                        <div class="header__pane ml-auto">
                            <div>
                                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                                    <span class="hamburger-box">
                                        <span class="hamburger-inner"></span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="app-header__mobile-menu">
                        <div>
                            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="app-header__menu">
                        <span>
                            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                                <span class="btn-icon-wrapper">
                                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                                </span>
                            </button>
                        </span>
                    </div>
                    <div class="scrollbar-sidebar overflow-auto">
                        <div class="app-sidebar__inner">
                            <ul class="vertical-nav-menu">
                                <li class="app-sidebar__heading">DASHBOARDS</li>
                                <li id="menu-dashboard">-</li>
                                <li class="app-sidebar__heading">MANAJEMEN PENGGUNA</li>
                                <li id="menu-company">-</li>
                                <li id="menu-unit_kerja">-</li>
                                <li id="menu-personil">-</li>
                                <li id="menu-user">-</li>
                                <li class="app-sidebar__heading">PASAL STANDAR</li>
                                <li id="menu-standard">-</li>
                                <li id="menu-company_standard">-</li>
                                <li id="menu-deskripsi_pasal">-</li>
                                <li id="menu-pemahaman_pasal">-</li>
                                <li id="menu-bukti_pasal">-</li>
                                <li class="app-sidebar__heading">PENGATURAN PASAL</li>
                                <li id="menu-akses_pasal">-</li>
                                <li id="menu-management_hope">-</li>
                                <li class="app-sidebar__heading">DOKUMEN & IMPLEMENTASI</li>
                                <li id="menu-treeview_detail">-</li>
                                <li id="menu-dokumen">-</li>
                                <li id="menu-implementasi">-</li>
                                <li id="menu-document_search">-</li>
                                <li class="app-sidebar__heading">MONITORING & EVALUASI</li>
                                <li id="menu-pemenuhan">-</li>
                                <li class="app-sidebar__heading">GAP ANALISA</li>
                                <li id="menu-gap_analisa1">-</li>
                                <li id="menu-gap_analisa">-</li>
                                <li id="menu-hasil_gap_analisa">-</li>
                                <li id="menu-perbaikan_gap_analisa">-</li>
                                <li class="app-sidebar__heading">RIWAYAT</li>
                                <li id="menu-log">-</li>
                                <li class="app-sidebar__heading">PENGATURAN</li>
                                <li id="menu-pengaturan">-</li>
                                <li id="menu-account">-</li>
                                <li id="menu-notifikasi_email">-</li>
                                <li class="app-sidebar__heading">PANDUAN</li>
                                <li id="menu-panduan">-</li>
                                <?php foreach ($this->session->userdata('module') as $key => $m) { ?>
                                    <?php if ($m['on_menu'] == 'YES' & $m['acc_read']) { ?>
                                        <li id="module-<?php echo $m['name'] ?>" class="menu-item">
                                            <a href="<?php echo site_url($m['name']) ?>" class="<?php echo $m['name'] == $this->uri->segment(1) ? 'mm-active' : '' ?>">
                                                <i class="metismenu-icon fa fa-<?php echo $m['icon'] ?>"></i>
                                                <b>
                                                    <?= isset($m['title']) ? $m['title'] : ucwords(str_replace('_', ' ', $m['name'])); ?>
                                                </b>
                                            </a>
                                        </li>
                                    <?php } ?>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="app-main__outer">
                    <div class="app-main__inner">
                        <div class="app-page-title">
                            <div class="page-title-wrapper">
                                <div class="page-title-heading col-sm-6">
                                    <div class="page-title-icon">
                                        <i class="fa fa-<?= empty($activeModule['icon']) ? 'eye-slash' : $activeModule['icon'] ?> icon-gradient bg-mean-fruit">
                                        </i>
                                    </div>
                                    <div>
                                        <?php if (isset($menuStandard)) { ?>
                                            <?php if (empty($this->session->user['id_company'])) { ?>
                                                <button type="button" title="Pilih Perusahaan" data-toggle="dropdown" class="btn-shadow mr-3 btn btn-dark">
                                                    <i class="fa fa-angle-double-down"></i>
                                                </button>
                                                <div id="company-dropdown" tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu">
                                                    <ul class="nav flex-column">
                                                        <?php foreach ($companies as $k => $c) { ?>
                                                            <li class="nav-item">
                                                                <a class="nav-link" onclick="switchCompany(<?= $c['id'] ?>)">
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
                                            <span id="company-title">
                                                <?= $this->session->activeCompany['name'] ?>
                                            </span>
                                        <?php } else { ?>
                                            <?= empty($activeModule['title']) ? ucfirst($module) : $activeModule['title']; ?>
                                            <div class="page-title-subheading">
                                                <?php echo $subTitle ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <!--=========================-->
                                <?php if (isset($menuStandard)) { ?>

                                    <?php if ($menuStandard === 'standard') { ?>
                                        <div class="page-title-actions">
                                            <div class="d-inline-block dropdown">
                                                <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn-shadow dropdown-toggle btn btn-info">
                                                    <span class="btn-icon-wrapper pr-2 opacity-7">
                                                        <i class="fa fa-file fa-w-20"></i>
                                                    </span>
                                                    <?= empty($this->session->activeStandard) ? '-' : $this->session->activeStandard['name'] ?>
                                                </button>
                                                <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                                                    <ul class="nav flex-column">
                                                        <?php foreach ($company_standard as $cs) { ?>
                                                            <li class="nav-item">
                                                                <a class="nav-link" onclick="switchStandard(<?= $cs['id'] ?>)">
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
                                    <?php } ?>
                                <?php } ?>
                                <!--=========================-->
                            </div>
                        </div>
                        <?php
                        if ($this->session->flashdata('msgSuccess')) {
                            $alertType = 'success';
                            $alert_message = $this->session->flashdata('msgSuccess');
                            $is_alert = true;
                        } elseif ($this->session->flashdata('msgError')) {
                            $alertType = 'danger';
                            $alert_message = $this->session->flashdata('msgError');
                            $is_alert = true;
                        } elseif (isset($msgSuccess)) {
                            $alertType = 'success';
                            $alert_message = $msgSuccess;
                            $is_alert = true;
                        } elseif (isset($msgError)) {
                            $alertType = 'danger';
                            $alert_message = $msgError;
                            $is_alert = true;
                        }
                        ?>
                        <?php if (isset($is_alert)) { ?>
                            <div class="alert alert-<?php echo $alertType ?> alert-dismissible fade show" role="alert">
                                <button type="button" class="close" onclick="closeAlert(this)"><span aria-hidden="true">×</span></button>
                                <?php echo $alert_message ?>
                            </div>
                        <?php } ?>
                        <?php $this->load->view($view) ?>
                    </div>
                    <div class="app-wrapper-footer d-none">
                        <div class="app-footer">
                            <div class="app-footer__inner">
                                <div class="app-footer-left">
                                    <ul class="nav">
                                        <li class="nav-item">
                                            <a href="javascript:void(0);" class="nav-link">
                                                Footer Link 1
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="javascript:void(0);" class="nav-link">
                                                Footer Link 2
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="app-footer-right">
                                    <ul class="nav">
                                        <li class="nav-item">
                                            <a href="javascript:void(0);" class="nav-link">
                                                Footer Link 3
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="javascript:void(0);" class="nav-link">
                                                <div class="badge badge-success mr-1 ml-0">
                                                    <small>NEW</small>
                                                </div>
                                                Footer Link 4
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function () {
                $('#modalContainer').append($('.modal'));
                $('.input-jadwal').datepicker({
                    format: 'dd-mm-yyyy',
//                    startDate: new Date(),
                    autoclose: true,
                });
                $('.data-table').DataTable();
                afterReady();
            });
            var module = <?php echo json_encode($this->session->userdata('module')) ?>;
            for (var i = 0; i < module.length; i++) {
                var m = module[i];
                $('#menu-' + m.name).replaceWith($('#module-' + m.name));
            }
            var menu = $('.vertical-nav-menu li');
            for (var i = 0; i < menu.length; i++) {//remove menu item
                if ($(menu[i]).text() == '-') {
                    $(menu[i]).remove();
                }
            }
            var menuHead = $('.app-sidebar__heading');
            for (var i = 0; i < menuHead.length; i++) {//remove menuhead with 0 menu item
                if (!$(menuHead[i]).next().hasClass('menu-item')) {
                    $(menuHead[i]).remove();
                }
            }
            function modalStatus(data) {
                try {
                    data = JSON.parse(data);
                    $('.modal-message').html(data.message);
                } catch (e) {
                    $('.modal-message').text('error!!!');
                }
                $('#modalNotif').modal('show');
            }
            function closeAlert(obj) {
                $(obj).parent().addClass('d-none');
            }
            $('.search-wrapper .search-icon').click(function () {
                if ($('.search-wrapper').hasClass('active')) {
                    window.location.href = "<?= site_url('document_search') ?>?judul=" + $('.search-input').val();
                }
            });
            $('.search-input').keypress(function (e) {
                if (e.which == 13) {
                    window.location.href = "<?= site_url('document_search') ?>?judul=" + $('.search-input').val();
                }
            });
            function switchCompany(company) {
                $.get('<?= site_url('dashboard/switch_company') ?>', {company: company}, function (data) {
                    if (data == 'success') {
                        location.reload();
                    }
                });
            }
            function switchStandard(standard) {
                $.get('<?= site_url('dashboard/switch_standard') ?>', {standard: standard}, function (data) {
                    if (data == 'success') {
                        location.reload();
                    }
                });
            }
        </script>
    </body>
</html>
<div id="modalContainer">
    <div class="modal fade" id="modalNotif" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form>
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Message</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body modal-message">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>