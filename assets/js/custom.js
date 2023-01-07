$( document ).ready(function() {
    
    // Write your custom Javascript codes here...
    $('input[type="file"]').bind('change', function(){
        if ($(this).data("filesize")) {
            var FileSize = this.files[0].size / 1024 / 1024; // in MB
            if (FileSize > 2) {
                custom_alert_popup('File size limit 2 MB');
                $(this).val('');
            } else {
                var file_type = this.files[0].type;
                var ext = file_type.split('/').pop();
                ext = ext.toLowerCase();

                if ($(this).data("filetype")) {
                    var str = $(this).data("filetype");
                    str = str.toLowerCase();
                    var hasExtension = str.indexOf(ext) != -1;
                    if(hasExtension == false){
                        custom_alert_popup('Please select valid file type ['+ str + '] only.');
                        $(this).val('');
                    }
                } else {
                    if(ext != 'jpeg' && ext != 'jpg' && ext != 'png' && ext != 'gif'){
                        custom_alert_popup('Please select valid file type [jpeg,jpg,png] only.');
                        $(this).val('');
                    }    
                }
            }
        } else {
            // 1 mb file validation
            var maxfilesize = 1024 * 1024;
            if(this.files[0].size > maxfilesize) {
                custom_alert_popup('File size limit 1 MB');
                $(this).val('');
            } else {
                var file_type = this.files[0].type;
                var ext = file_type.split('/').pop();
                ext = ext.toLowerCase();
                if ($(this).data("filetype")) {
                    var str = $(this).data("filetype");
                    str = str.toLowerCase();
                    var hasExtension = str.indexOf(ext) != -1;
                    if(hasExtension == false){
                        custom_alert_popup('Please select valid file type ['+ str + '] only.');
                        $(this).val('');
                    }
                } else {
                    if(ext != 'jpeg' && ext != 'jpg' && ext != 'png' && ext != 'gif'){
                        custom_alert_popup('Please select valid file type [jpeg,jpg,png] only.');
                        $(this).val('');
                    }    
                }    
            }
            
        }
    });

    setTimeout(function() {
        $("#fmsg").hide('blind', {}, 500)
    }, 5000);
});