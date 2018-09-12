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
                selectedDealer:null
            },
            created(){
            },
            methods:{
                querySearchAsync: function(queryString, cb){
                    if(queryString.length < 2){
                        return;
                    }
                    var that = this;
                    axios.get(
                        '/api/users-search?q=' + queryString
                    ).then(function(res){
                        if(res.status === 200 && res.data.error_no === 100){
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
                    if(item.user_id === undefined){
                        console.log(1111);
                        item = this.users[0];
                    }
                    window.open('/admin/fake-user?uid=' + item.user_id, '_blank');
                }
            }
        });
    }

    var userLocatorEl = document.getElementById('user-locator-app');
    if(userLocatorEl){
        var userLocatorApp = new Vue({
            el:'#user-locator-app',
            delimiters: ['${', '}'],
            data:{
                users: [],
                keyword: '',
                select:'',
                selectedDealer:null,
                dealers:[],
                form:{
                    positions:[]
                },
                advanceMode: false,

            },
            created(){
                this._LoadNissanDealers();
            },
            methods:{
                onSubmit: function(){

                },
                _LoadNissanDealers: function(){
                    var that = this;
                    axios.get('/api/admin/load-nissan-dealers').then(function (res) {
                        if(res.data.error_no === 100){
                            that.dealers = res.data.data;
                        }
                    })
                },
                switchOnAdvance: function(){
                    this.advanceMode = !this.advanceMode;
                }
            }
        });
    }
});