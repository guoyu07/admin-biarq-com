<form id="upload" action="/projectos/teste" method="POST" enctype="multipart/form-data">
    <input type="hidden"
            name="<?php echo ini_get("session.upload_progress.name"); ?>"
            value="upload" />

    <input id="file1" type="file" name="file1" />
    <input id="file2" type="file" name="file2" />

    <input class="btn primary" type="submit" value="Upload" /></form>
<script>

    //Holds the id from set interval
    var interval_id = 0;

    $(document).ready(function () {

        //jquery form options
        var options = {
            success:stopProgress, //Once the upload completes stop polling the server
            error:stopProgress
        };

        //Add the submit handler to the form
        $('#upload').submit(function (e) {

            //check there is at least one file
            if ($('#file1').val() == '' && $('#file2').val() == '') {
                e.preventDefault();
                return;
            }

            //Poll the server for progress
            interval_id = setInterval(function () {
                $.getJSON('/projectos/upload_progress', function (data) {

                    //if there is some progress then update the status
                    if (data) {
                        $('#progress').val(data.bytes_processed / data.content_length);
                        $('#progress-txt').html('Uploading ' +
                                Math.round((data.bytes_processed / data.content_length) * 100) +
                                '%');
                    }

                    //When there is no data the upload is complete
                    else {
                        $('#progress').val('1');
                        $('#progress-txt').html('Complete');
                        stopProgress();
                    }

                })
            }, 200);

            $('#upload').ajaxSubmit();

            e.preventDefault();
        });
    });

    function stopProgress() {
        clearInterval(interval_id);
    }
</script>
	
	
	
	
	
	
