<div class="row">
    <div class="col-md-12">
        <img width="100%" class="rounded" align="right" src="<?php echo base_url('assets/images/dms-header.jpg') ?>" alt="no picture">
    </div>
</div>
<br/>
<div class="row">
    <?php foreach ($box as $key => $b) { ?>
        <?php if (empty($this->session->user['id_company']) | $b['company'] == 'Y') { ?>
            <div class="col-md-6 col-xl-4">
                <div class="card mb-3 widget-content bg-<?= $b['color'] ?>">
                    <div class="widget-content-wrapper text-white">
                        <!--                    <div>
                                                <i class="fa fa-<?php // $b['icon']                ?>"></i>&nbsp;
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
<canvas id="myChart" height="100"></canvas>
<script>
    function afterReady() {

    }
    var pasal = <?= $grafik ?>;
    var labelData = [];
    var docData = [];
    for (var i = 0; i < pasal.length; i++) {
        var p = pasal[i];
        p.indexChild = [];
        for (var j = 0; j < pasal.length; j++) {//get child
            var p2 = pasal[j];
            if (p.id == p2.parent) {
                p.indexChild.push(j);
            }
        }
        pasal[i] = p;
    }
    for (var i = 0; i < pasal.length; i++) {
        var p = pasal[i];
        if (p.parent == null) {
            getPercent(i);
            labelData.push(p.name);
            docData.push(p.percent);
        }
    }
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
    console.log(pasal);
    var ctx = document.getElementById('myChart');
    var myChart = new Chart(ctx, {
        type: 'radar',
        data: {
//            labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            labels: labelData,
            datasets: [{
                    label: 'Dokumen',
                    data: docData,
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
        },
        options: {
            scale: {
                angleLines: {
                    display: false
                },
                ticks: {
                    suggestedMin: 50,
                    suggestedMax: 100
                }
            }
        }
    });
</script>

