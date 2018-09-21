function fileInputOnChange(file,fileNameElementId){
    file.onchange = function(){
        if(file.files.length > 0){
            document.getElementById(fileNameElementId).innerHTML = file.files[0].name;
        }
    };
}
// Slide out for backend start
var slideout = new Slideout({
    'panel': document.getElementById('panel'),
    'menu': document.getElementById('menu'),
    'padding': 256,
    'tolerance': 70
});
if(document.getElementById('toggle-side-menu')){
    document.getElementById('toggle-side-menu').addEventListener('click', function(e) {
        slideout.toggle();
    });
}

function slideOutClose(eve) {
    eve.preventDefault();
    slideout.close();
}
slideout.on('beforeopen', function() {
    this.panel.classList.add('panel-mask-open');
}).on('open', function() {
    this.panel.addEventListener('click', slideOutClose);
}).on('beforeclose', function() {
    this.panel.classList.remove('panel-mask-open');
    this.panel.removeEventListener('click', slideOutClose);
});
// Slide out for backend end

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
                selectedDealer:null
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
            created: function(){
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