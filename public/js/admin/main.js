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

    // search bar
    var navEl = document.getElementById('nav-app-wrap');
    if(navEl){
        var navApp = new Vue({
            el: '#nav-app-wrap',
            delimiters: ['${', '}'],
            data:{
                users: [],
                keyword: '',
                select:'',
                selectedDealer:null,
                dialogVisible: false,
                currentItem: null
            },
            created:function(){
            },
            methods:{
                querySearchAsync: function(queryString, cb){
                    if(queryString.length < 2){
                        return;
                    }
                    var that = this;
                    axios.get(
                        '/admin/users/search?q=' + queryString
                    ).then(function(res){
                        if(res.status === 200 && res.data.success){
                            // 表示找到了结果
                            that.users = res.data.data;
                            cb(res.data.data)
                        }else{
                            cb([]);
                            that.$message('No user is found');
                        }
                    });
                },
                handleSelect: function(item){
                    if(item.id === undefined){
                        item = this.users[0];
                    }
                    this.dialogVisible = true;
                    this.currentItem = item;
                },
                mockHandler: function(){
                    this.dialogVisible = false;
                    if(!this.currentItem.dealer_code){
                        // nissan staff
                        window.open('/admin/region_staff/mock/' + this.currentItem.id, '_blank');
                    }else{
                        window.open('/admin/users/mock/' + this.currentItem.id, '_blank');
                    }
                },
                editHandler: function(){
                    this.dialogVisible = false;
                    window.location.href = '/admin/users/' + this.currentItem.id;
                }

            }
        });
    }
});
