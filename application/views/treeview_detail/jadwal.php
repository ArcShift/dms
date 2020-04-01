<ul class="list-group">
    <?php for ($i = 0; $i < 10; $i++) { ?>
    <?php 
        $hour= rand(0, 23);
        $minute= rand(0, 59);
    ?>
        <li class="list-group-item">
            <div class="row">    
                <div class="col-sm-6">
                    Pasal
                </div>   
                <div class="col-sm-6">
                    <?php echo $hour.':'.$minute?>
                </div>
            </div>
        </li>
    <?php } ?>
</ul>