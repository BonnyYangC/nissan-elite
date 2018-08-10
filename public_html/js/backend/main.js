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

    // search bar
    var navEl = document.getElementById('nav-app-wrap');
    if(navEl){
        var navApp = new Vue({
            el: '#nav-app-wrap',
            data:{
                restaurants: [],
                keyword: '',
                select:'',
                selectedDealer:null,
                dealers:[]
            },
            created(){
                console.log(22222);
            },
            methods:{
                querySearchAsync: function(queryString, cb){
                    if(queryString.length < 2){
                        return;
                    }
                    axios.get(
                        '/api/users-search?q=' + queryString
                    ).then(function(res){
                        if(res.status==200 && res.data.error_no == 100){
                            // 表示找到了结果
                            cb(res.data.data.result)
                        }
                    });
                },
                handleSelect: function(){

                },
                getDealers: function(){

                }
            }
        });
    }
});