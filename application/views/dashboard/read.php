<!--<div class="row">
    <div class="col-md-12">
        <img width="100%" class="rounded" align="right" src="<?php // echo base_url('assets/images/dms-header.jpg')                                 ?>" alt="no picture">
    </div>
</div>
<br/>-->
<div class="main-card mb-3 card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6"></div>
            <div class="col-sm-3">
                <select class="form-control" id="selectCompany">
                    <option>~ Pilih Perusahaan ~</option>
                    <?php foreach ($company as $k => $c) { ?>
                        <option value="<?= $c['id'] ?>"><?= $c['name'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-sm-3">
                <select class="form-control" id="selectStandar">
                    <option>~ Pilih Standar ~</option>
                </select>
            </div>
        </div>
        <br/>
        <div id="divGraph" class="text-center">
            Pilih perusahaan dan standar untuk melihat grafik pemenuhan dokumen dan standar
        </div>
        <!--<canvas id="myChart" height="100"></canvas>-->
    </div>
</div>
<div class="row">
    <?php foreach ($box as $key => $b) { ?>
        <?php if (empty($this->session->user['id_company']) | $b['company'] == 'Y') { ?>
            <div class="col-md-6 col-xl-4">
                <div class="card mb-3 widget-content bg-<?= $b['color'] ?>">
                    <div class="widget-content-wrapper text-white">
                        <!--                    <div>
                                                <i class="fa fa-<?php // $b['icon']                                                    ?>"></i>&nbsp;
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
    function afterReady() {}
    $('#selectCompany').change(function () {
        $('#initLabelGrafik').hide();
        $.getJSON('<?= site_url('dashboard/standard') ?>', {company: $(this).val()}, function (data) {
            $('#selectStandar').empty();
            $('#selectStandar').append('<option>~ pilih standar ~</option>');
            for (var i = 0; i < data.length; i++) {
                $('#selectStandar').append('<option value="' + data[i].id + '">' + data[i].name + '</option>');
            }
            $('#selectStandar').change();
        });
    });
    $('#selectStandar').change(function () {
        $.getJSON('<?= site_url('dashboard/grafik') ?>', {company: $('#selectCompany').val(), standard: $(this).val()}, function (data) {
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
            for (var i = 0; i < data.length; i++) {
                var d = data[i];
                if (d.parent == null) {
                    labels.push(d.name);
                    getPercent(i);
                    gData.push(pasal[i].percent);
                    hopeData.push(d.harapan);
                }
            }
            newGraph(labels, gData, hopeData);
        });
    });
    var pasal = []
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
    function newGraph(labels, data, harapan) {
        console.log(harapan);
        $('#divGraph').empty();
        $('#divGraph').append('<canvas id="myChart" height="100"></canvas>');
        var ctx = document.getElementById('myChart');
        chart = new Chart(ctx, {
            type: 'radar',
            data: {
                labels: labels,
                datasets: [{
                        label: 'Dokumen',
                        data: data,
                        borderColor: 'rgba(255, 0, 0, 1)',
                        borderWidth: 1
                    }, {
                        label: 'Harapan',
                        data: harapan,
                        borderColor: 'rgba(0, 255, 0, 1)',
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
</script>