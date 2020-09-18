<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Content-Language" content="en">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title><?php echo $this->config->item('app_name') ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
        <meta name="description" content="This is an example dashboard created using build-in elements and components.">
        <meta name="msapplication-tap-highlight" content="no">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
        <link href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet">
        <link href="https://demo.dashboardpack.com/architectui-html-free/main.css" rel="stylesheet">
                <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>-->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
        <script type="text/javascript" src="https://demo.dashboardpack.com/architectui-html-free/assets/scripts/main.js"></script>       
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-dateFormat/1.0/jquery.dateFormat.min.js"></script>
        <script>
            function closeAlert(item) {
                console.log($(item).parent().remove());
            }
        </script>
        <style>
            .menu-item a{
                font-size: small;
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
                                    <div class="widget-content-left">
                                        <div class="btn-group">                                            
                                            <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn" onclick="userMenu()">
                                                <img width="42" class="rounded-circle" src="<?php echo empty($this->session->userdata('user')['photo']) ? $this->config->item('user_photo') : base_url('upload/profile_photo/' . $this->session->userdata('user')['photo']) ?>" alt="">
                                                <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                            </a>
                                            <div tabindex="-1" role="menu" aria-hidden="false" class="dropdown-menu dropdown-menu-right">
                                                <a href="<?php echo site_url('account') ?>" class="dropdown-item">Akun</a>
                                                <!--<button type="button" tabindex="0" class="dropdown-item">Settings</button>-->
                                                <!--<h6 tabindex="-1" class="dropdown-header">Header</h6>-->
                                                <!--<button type="button" tabindex="0" class="dropdown-item">Actions</button>-->
                                                <div class="dropdown-divider"></div>
                                                <a href="<?php echo site_url('account/logout') ?>" class="dropdown-item">Logout</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="widget-content-left  ml-3 header-user-info">
                                        <div class="widget-heading">
                                            <?php echo $this->session->userdata('user')['username'] ?>
                                        </div>
                                        <div class="widget-subheading">
                                            <?php echo $this->session->userdata('user')['title'] ?>                                            
                                        </div>
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
                    <div class="scrollbar-sidebar">
                        <div class="app-sidebar__inner">
                            <ul class="vertical-nav-menu">
                                <li class="app-sidebar__heading">DASHBOARDS</li>
                                <li id="menu-dashboard">-</li>
                                <li class="app-sidebar__heading">MANAJEMEN PENGGUNA</li>
                                <li id="menu-company">-</li>
                                <li id="menu-unit_kerja">-</li>
                                <li id="menu-personil">-</li>
                                <li id="menu-user">-</li>
                                <li class="app-sidebar__heading">STANDAR</li>
                                <li id="menu-standard">-</li>
                                <li id="menu-document_search">-</li>
                                <li id="menu-company_standard">-</li>
                                <?php foreach ($this->session->userdata('module') as $key => $m) { ?>
                                    <?php if ($m['on_menu'] == 'YES') { ?>
                                        <li id="module-<?php echo $m['name'] ?>" class="menu-item">
                                            <a href="<?php echo site_url($m['name']) ?>" class="<?php echo $m['name'] == $this->uri->segment(1) ? 'mm-active' : '' ?>">
                                                <i class="metismenu-icon fa fa-<?php echo $m['icon'] ?>"></i>
                                                <?php echo isset($m['title']) ? $m['title'] : ucwords(str_replace('_', ' ', $m['name'])); ?>
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
                                <div class="page-title-heading">
                                    <div class="page-title-icon">
                                        <i class="fa fa-<?php echo $activeModule['icon'] ?> icon-gradient bg-mean-fruit">
                                        </i>
                                    </div>
                                    <div>
                                        <?php echo empty($activeModule['title']) ? ucfirst($module) : $activeModule['title']; ?>
                                        <div class="page-title-subheading">
                                            <?php echo $subTitle ?>
                                        </div>
                                    </div>
                                </div>
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
<script>
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
</script>