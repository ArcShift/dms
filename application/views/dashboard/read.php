<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-home icon-gradient bg-mean-fruit">
                </i>
            </div>
            <div>
                <?php if (empty($this->session->user['id_company'])) { ?>
                    <button type="button" title="Pilih Perusahaan" data-toggle="dropdown" class="btn-shadow mr-3 btn btn-dark">
                        <i class="fa fa-angle-double-down"></i>
                    </button>
                    <div id="company-dropdown" tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu">
                        <ul class="nav flex-column">
                            <?php foreach ($company as $k => $c) { ?>
                                <li class="nav-item">
                                    <a href="javascript:selectCompany(<?= $c['id'] ?>,'<?= $c['name'] ?>');" class="nav-link">
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
                    <?= empty($this->session->company) ? '~ Pilih Perusahaan ~' : $this->session->company['name'] ?>
                </span>
                <div class="page-title-subheading"></div>
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
                    <span id="standard-title"></span>
                </button>
                <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                    <ul id="ul-standard" class="nav flex-column"></ul>
                </div>
            </div>
        </div>   
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="card mb-3 widget-content bg-midnight-bloom">
            <div class="widget-content-wrapper text-white">
                <div class="widget-content-left">
                    <div class="widget-heading">Dokumen</div>
                    <div class="widget-subheading">Pembuatan dokumen</div>
                </div>
                <div class="widget-content-right">
                    <div class="widget-numbers text-white"><span id="averageDoc"></span></div>
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
                    <div class="widget-numbers text-white"><span id="averageImp"></span></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="main-card mb-3 card">
    <div id="divGraph" class="card-body text-center">
        Pilih perusahaan dan standar untuk melihat grafik pemenuhan dokumen dan standar
    </div>
</div>
<div class="row">
    <?php foreach ($box as $key => $b) { ?>
        <?php if (empty($this->session->user['id_company']) | $b['company'] == 'Y') { ?>
            <div class="col-md-6 col-xl-4">
                <div class="card mb-3 widget-content bg-<?= $b['color'] ?>">
                    <div class="widget-content-wrapper text-white">
                        <!--                    <div>
                                                <i class="fa fa-<?php // $b['icon']                                                                            ?>"></i>&nbsp;
                                            </div>-->
                        <div class="widget-content-left">
                            <div class="widget-heading"><?= $b['title'] ?></div>
                            <div class="widget-subheading"><?= empty($b['subtitle']) ? '-' : $b['subtitle']; ?></div>
                        </div>
                        <div class="widget-content-right">
                            <div class="widget-numbers text-white"><span><?= $b['value'] ?></span></div>
                        </div>
                    </div>
                </div>  
            </div>
        <?php } ?>
    <?php } ?>
</div>
<script>
    function afterReady() {
        $('.app-page-title').first().hide();
    }
    function selectCompany(id, name) {
            company = id;
            $.getJSON('<?= site_url('dashboard/standard') ?>', {company: id}, function (data) {
                $('#company-title').text(name);
                $('#standard-title').text('~ Pilih Standar ~');
                $(".dropdown-menu").removeClass('show');
                $("#ul-standard").empty();
                for (var i = 0; i < data.length; i++) {
                    $("#ul-standard").append('<li class="nav-item">'
                            + '<a href="javascript:selectStandard(' + data[i].id + ')" class="nav-link">'
                            //                            + '<a href="javascript:selectStandard(' + data[i].id + ')" class="nav-link">'
                            + '<i class="nav-link-icon lnr-inbox"></i>'
                            + '<span>' + data[i].name + '</span>'
                            + '</a>'
                            + '</li>');
                }
            }
            );
        }
<?php if (empty($this->session->user['id_company'])) { ?>
        
<?php }else{ ?>
     selectCompany(<?= $this->session->company['id']?>, <?= $this->session->company['name']?>);
<?php } ?>
    function selectStandard(id) {
        $.getJSON('<?= site_url('dashboard/grafik') ?>', {company: company, standard: id}, function (data) {
            $.getJSON('treeview_detail/get_pemenuhan', {'company': company, 'standard': id}, function (data2) {
                $(".dropdown-menu").removeClass('show');
                pasal = [];
                for (var i = 0; i < data.length; i++) {
                    var d = data[i];
                    d.indexChild = [];
                    for (var j = 0; j < data.length; j++) {//get child
                        var d2 = data[j];
                        if (d.id == d2.parent) {
                            d.indexChild.push(j);
                        }
                    }
                    pasal.push(d);
                }
                var labels = [];
                var gData = [];
                var hopeData = [];
                var impData = [];
                for (var i = 0; i < data.length; i++) {
                    var d = data[i];
                    if (d.parent == null) {
                        labels.push(d.name);
                        getPercent(i);
                        gData.push(pasal[i].percent);
                        hopeData.push(d.harapan);
                    }
                }
                for (var i = 0; i < data2.length; i++) {
                    impData.push(data2[i].pemenuhanImp);
                }
                newGraph(labels, gData, hopeData, impData);
            });
        });
    }
    var pasal = [];
    function getPercent(index) {
        var p = pasal[index];
        p.percent = 0;
        if (p.indexChild.length == 0) {
            if (p.doc > 0) {
                p.percent = 100;
            }
        } else {
            for (var i = 0; i < p.indexChild.length; i++) {
                var pc = p.indexChild[i];
                getPercent(pc);
                p.percent += pasal[pc].percent;
            }
            p.percent = Math.round(p.percent / p.indexChild.length);
        }
        pasal[index] = p;
    }
    function newGraph(labels, doc, harapan, imp) {
        $('#averageDoc').text(average(doc) + '%');
        $('#averageImp').text(average(imp) + '%');
        console.log(imp);
        $('#divGraph').empty();
        $('#divGraph').append('<canvas id="myChart" height="100"></canvas>');
        var ctx = document.getElementById('myChart');
        chart = new Chart(ctx, {
            type: 'radar',
            data: {
                labels: labels,
                datasets: [{
                        label: 'Dokumen',
                        data: doc,
                        borderColor: 'rgba(255, 0, 0, 1)',
                        borderWidth: 1
                    }, {
                        label: 'Harapan',
                        data: harapan,
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
                title: {
                    display: true,
                    text: 'Grafik Pemenuhan Dokumen dan Standar',
                    position: 'bottom',
                },
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
    }
    function average(arr) {
        var sum = 0;
        for (var i = 0; i < arr.length; i++) {
            sum += parseInt(arr[i], 10);
        }
        return Math.round(sum / arr.length);
    }
</script>