<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Content-Language" content="en">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Dashboard - This is an example dashboard for Delta Management System.</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
        <meta name="description" content="Dashboard - This is an example dashboard for Delta Management System.">
        <meta name="msapplication-tap-highlight" content="no">
        <!--
        =========================================================
        * ArchitectUI HTML Theme Dashboard - v1.0.0
        =========================================================
        * Product Page: https://dashboardpack.com
        * Copyright 2019 DashboardPack (https://dashboardpack.com)
        * Licensed under MIT (https://github.com/DashboardPack/architectui-html-theme-free/blob/master/LICENSE)
        =========================================================
        * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
        -->
        <link href="./main.css" rel="stylesheet"></head>
    <body>
        <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
            <div class="app-header header-shadow">
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
                </div>    <div class="app-header__content">
                    <div class="app-header-left">
                        <div class="search-wrapper">
                            <div class="input-holder">
                                <input type="text" class="search-input" placeholder="Type to search">
                                <button class="search-icon"><span></span></button>
                            </div>
                            <button class="close"></button>
                        </div>
                        <!-- <ul class="header-menu nav">
                            <li class="nav-item">
                                <a href="javascript:void(0);" class="nav-link">
                                    <i class="nav-link-icon fa fa-database"> </i>
                                    Statistics
                                </a>
                            </li>
                            <li class="btn-group nav-item">
                                <a href="javascript:void(0);" class="nav-link">
                                    <i class="nav-link-icon fa fa-edit"></i>
                                    Projects
                                </a>
                            </li>
                            <li class="dropdown nav-item">
                                <a href="javascript:void(0);" class="nav-link">
                                    <i class="nav-link-icon fa fa-cog"></i>
                                    Settings
                                </a>
                            </li>
                        </ul> -->        </div>
                    <div class="app-header-right">
                        <div class="header-btn-lg pr-0">
                            <div class="widget-content p-0">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left">
                                        <div class="btn-group">
                                            <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                                                <img width="42" class="rounded-circle" src="assets/images/avatars/1.jpg" alt="">
                                                <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                            </a>
                                            <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                                                <button type="button" tabindex="0" class="dropdown-item">User Account</button>
                                                <button type="button" tabindex="0" class="dropdown-item">Settings</button>
                                                <h6 tabindex="-1" class="dropdown-header">Header</h6>
                                                <button type="button" tabindex="0" class="dropdown-item">Actions</button>
                                                <div tabindex="-1" class="dropdown-divider"></div>
                                                <button type="button" tabindex="0" class="dropdown-item">Dividers</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="widget-content-left  ml-3 header-user-info">
                                        <div class="widget-heading">
                                            Alina Mclourd
                                        </div>
                                        <div class="widget-subheading">
                                            VP People Manager
                                        </div>
                                    </div>
                                    <!-- <div class="widget-content-right header-user-info ml-3">
                                        <button type="button" class="btn-shadow p-1 btn btn-primary btn-sm show-toastr-example">
                                            <i class="fa text-white fa-calendar pr-1 pl-1"></i>
                                        </button>
                                    </div> -->
                                </div>
                            </div>
                        </div>        </div>
                </div>
            </div>        <div class="ui-theme-settings">
                <button type="button" id="TooltipDemo" class="btn-open-options btn btn-warning">
                    <i class="fa fa-cog fa-w-16 fa-spin fa-2x"></i>
                </button>
            </div>        <div class="app-main">
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
                    </div>    <div class="scrollbar-sidebar">
                        <div class="app-sidebar__inner">
                            <ul class="vertical-nav-menu">
                                <li class="app-sidebar__heading">Dashboards</li>
                                <li>
                                    <a href="index.html" class="">
                                        <i class="metismenu-icon pe-7s-rocket"></i>
                                        Dashboard
                                    </a>
                                </li>

                                <!-- <li class="app-sidebar__heading">Charts</li>
                                <li>
                                    <a href="charts-chartjs.html">
                                        <i class="metismenu-icon pe-7s-graph2">
                                        </i>ChartJS
                                    </a>
                                </li> -->

                            </ul>
                        </div>
                    </div>
                </div>    <div class="app-main__outer">
                    <div class="app-main__inner">
                        <div class="app-page-title">
                            <div class="page-title-wrapper">
                                <div class="page-title-heading">
                                    <div class="page-title-icon">
                                        <i class="pe-7s-home icon-gradient bg-mean-fruit">
                                        </i>
                                    </div>
                                    <div>PT. Delta Sinergi Prima
                                        <div class="page-title-subheading">Informasi penting seperti executive summary ditampilkan pada halaman dashboard ini.
                                        </div>
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
                                            ISO 27001:2013
                                        </button>
                                        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                                            <ul class="nav flex-column">
                                                <li class="nav-item">
                                                    <a href="javascript:void(0);" class="nav-link">
                                                        <i class="nav-link-icon lnr-inbox"></i>
                                                        <span>
                                                            ISO 27001:2013
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="javascript:void(0);" class="nav-link">
                                                        <i class="nav-link-icon lnr-book"></i>
                                                        <span>
                                                            ISO 9001:2002
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="javascript:void(0);" class="nav-link">
                                                        <i class="nav-link-icon lnr-picture"></i>
                                                        <span>
                                                            ISO 277001:2013
                                                        </span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- <div class="d-inline-block dropdown">
                                        <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn-shadow dropdown-toggle btn btn-info">
                                            <span class="btn-icon-wrapper pr-2 opacity-7">
                                                <i class="fa fa-calendar fa-w-20"></i>
                                            </span>
                                            2021
                                        </button>
                                        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                                            <ul class="nav flex-column">
                                                <li class="nav-item">
                                                    <a href="javascript:void(0);" class="nav-link">
                                                        <i class="nav-link-icon lnr-inbox"></i>
                                                        <span>
                                                            2021
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="javascript:void(0);" class="nav-link">
                                                        <i class="nav-link-icon lnr-book"></i>
                                                        <span>
                                                            2020
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="javascript:void(0);" class="nav-link">
                                                        <i class="nav-link-icon lnr-picture"></i>
                                                        <span>
                                                            2019
                                                        </span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div> -->
                                </div>   
                            </div>
                        </div>       
                        <div class="row">
                            <div class="col-md-5 col-xl-6">
                                <div class="card mb-3 widget-content bg-midnight-bloom">
                                    <div class="widget-content-wrapper text-white">
                                        <div class="widget-content-left">
                                            <div class="widget-heading">Dokumen</div>
                                            <div class="widget-subheading">Pembuatan dokumen</div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-white"><span>70%</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-6">
                                <div class="card mb-3 widget-content bg-arielle-smile">
                                    <div class="widget-content-wrapper text-white">
                                        <div class="widget-content-left">
                                            <div class="widget-heading">Implementasi</div>
                                            <div class="widget-subheading">Penerapan dokumen</div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-white"><span>35%</span></div>
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
                                        <canvas id="radar-chart"></canvas>
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
                        <!-- <div class="row">
                            <div class="col-md-6 col-lg-3">
                                <div class="card-shadow-danger mb-3 widget-chart widget-chart2 text-left card">
                                    <div class="widget-content">
                                        <div class="widget-content-outer">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left pr-2 fsize-1">
                                                    <div class="widget-numbers mt-0 fsize-3 text-danger">71%</div>
                                                </div>
                                                <div class="widget-content-right w-100">
                                                    <div class="progress-bar-xs progress">
                                                        <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="71" aria-valuemin="0" aria-valuemax="100" style="width: 71%;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="widget-content-left fsize-1">
                                                <div class="text-muted opacity-6">Income Target</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="card-shadow-success mb-3 widget-chart widget-chart2 text-left card">
                                    <div class="widget-content">
                                        <div class="widget-content-outer">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left pr-2 fsize-1">
                                                    <div class="widget-numbers mt-0 fsize-3 text-success">54%</div>
                                                </div>
                                                <div class="widget-content-right w-100">
                                                    <div class="progress-bar-xs progress">
                                                        <div class="progress-bar bg-success" role="progressbar" aria-valuenow="54" aria-valuemin="0" aria-valuemax="100" style="width: 54%;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="widget-content-left fsize-1">
                                                <div class="text-muted opacity-6">Expenses Target</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="card-shadow-warning mb-3 widget-chart widget-chart2 text-left card">
                                    <div class="widget-content">
                                        <div class="widget-content-outer">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left pr-2 fsize-1">
                                                    <div class="widget-numbers mt-0 fsize-3 text-warning">32%</div>
                                                </div>
                                                <div class="widget-content-right w-100">
                                                    <div class="progress-bar-xs progress">
                                                        <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="32" aria-valuemin="0" aria-valuemax="100" style="width: 32%;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="widget-content-left fsize-1">
                                                <div class="text-muted opacity-6">Spendings Target</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="card-shadow-info mb-3 widget-chart widget-chart2 text-left card">
                                    <div class="widget-content">
                                        <div class="widget-content-outer">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left pr-2 fsize-1">
                                                    <div class="widget-numbers mt-0 fsize-3 text-info">89%</div>
                                                </div>
                                                <div class="widget-content-right w-100">
                                                    <div class="progress-bar-xs progress">
                                                        <div class="progress-bar bg-info" role="progressbar" aria-valuenow="89" aria-valuemin="0" aria-valuemax="100" style="width: 89%;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="widget-content-left fsize-1">
                                                <div class="text-muted opacity-6">Totals Target</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </div>
                    <div class="app-wrapper-footer">
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
                    </div>    </div>
                <script src="http://maps.google.com/maps/api/js?sensor=true"></script>
            </div>
        </div>
        <script type="text/javascript" src="./assets/scripts/main.js"></script></body>
</html>
