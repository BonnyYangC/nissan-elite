function fileInputOnChange(file,fileNameElementId){
    file.onchange = function(){
        if(file.files.length > 0){
            document.getElementById(fileNameElementId).innerHTML = file.files[0].name;
        }
    };
}

Zepto(function($){
    $('#submit-import-btn').on('click',function(e){
        $('#submit-btn-waiting').addClass('fa-spin');
        $('#submit-btn-txt').text('Please wait ...')
    });

    /**
     * Double check when user trying to remove anything
     */
    $('.btn-need-confirm').on('click',function(e){
        e.preventDefault();
        if(confirm('Are you sure to remove this record?')){
            window.location.href = $(this).attr('href');
        }
    });

    var csvFile = document.getElementById("csv-file-input");
    if(csvFile){
        fileInputOnChange(csvFile, 'csv-file-input-text');
    }

    var imageFile = document.getElementById("image-file-input");
    if(imageFile){
        fileInputOnChange(imageFile, 'image-file-input-text');
    }

    var pdfFile = document.getElementById("pdf-file-input");
    if(pdfFile){
        fileInputOnChange(pdfFile, 'pdf-file-input-text');
    }

});
