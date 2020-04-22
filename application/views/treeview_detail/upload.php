<style>
    .bar {
        height: 18px;
        background: green;
    }
</style>
<div class="title">title</div>
<input id="fileupload" type="file" name="files[]" data-url="<?php echo base_url('upload/form2') ?>" multiple>
<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>-->
<script src="https://blueimp.github.io/jQuery-File-Upload/js/vendor/jquery.ui.widget.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.iframe-transport/1.0.1/jquery.iframe-transport.min.js"></script>
<script src="https://blueimp.github.io/jQuery-File-Upload/js/jquery.fileupload.js"></script>
<div id="progress">
    <div class="bar" style="width: 0%;"></div>
</div>
<script>
    $(function () {
        $('#fileupload').fileupload({
            dataType: '.sql',
            done: function (e, data) {
                $.each(data.result.files, function (index, file) {
                    console.log(file.name);
//                    $('<p></p>').text(file.name).appendTo($('.title'));
                });
            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .bar').css(
                        'width',
                        progress + '%'
                        );
            }
        });
    });
</script>