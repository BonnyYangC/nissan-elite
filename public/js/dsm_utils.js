var dsmEl = document.getElementById('dsm-app');
if(dsmEl){
    var dsmApp = new Vue({
        el:'#dsm-app',
        delimiters: ['${', '}'],
        data:{
            window: window,
            employeeCode: null,
            regions:[],
            regionCodes:'',
            regionName:'',
            tableData:[],
            keyword:'', // for filtering dealer
            dept:'All', // for filtering department
            departments:[
                {
                    label:'All Departments',
                    value:'All'
                },
                {
                    label:'Administration',
                    value:'Administration'
                },
                {
                    label:'Sales',
                    value:'Sales'
                },
                {
                    label:'Parts',
                    value:'Parts'
                },
                {
                    label:'Service',
                    value:'Service'
                },
            ],
            isLoadingRemoteData: false
        },
        watch:{
            'regionName': function(newValue, oldValue){
                if(newValue !== oldValue){
                    this.tableData = [];
                    this.dept = 'All';
                    this.keyword = '';
                    this._loadArrayData();
                }
            }
        },
        created: function(){
            /*this.employeeCode = employeeCode;
            this.regions = regions;
            if(this.regions.length === 1){
                this.regionName = this.regions[0];
            }*/
        },
        methods:{
            handlerTerritoryReport: function(event, userId){
                event.preventDefault();
                var url = '/admin/data_export/territory_report?dept=' + this.dept;
                if(this.keyword !== ''){
                    url += '&dealer=' + this.keyword;
                }
                window.location.href = url;
            },
            handlerActiveMemberList: function(event, userId){
                event.preventDefault();
                var url = '/admin/data_export/user';//?dept=' + this.dept;
                //var url = '/api/dsm/download-active-member-list?member='+userId + '&dept=' + this.dept;
                if(this.keyword !== ''){
                    url += '&dealer=' + this.keyword;
                }
                window.location.href = url;
            },
            arraySpanMethod: function(row, column, rowIndex, columnIndex) {
                if (rowIndex % 2 === 0) {
                    if (columnIndex === 0) {
                        return [1, 2];
                    } else if (columnIndex === 1) {
                        return [0, 0];
                    }
                }
            },
            showOnly: function(dept){
                for (var rowIndex=0;rowIndex<this.tableData.length;rowIndex++){
                    this.showMe({row:this.tableData[rowIndex]},rowIndex);
                }
            },
            showMe:function(row, rowIndex){
                var defaultClass = 'txt-black-tr';
                if(this.keyword.trim().length === 0 && this.dept === 'All'){
                    return defaultClass;
                }else{
                    if(row.row.d.toLowerCase().indexOf(this.keyword.toLowerCase()) === -1){
                        // not found
                        return 'd-none';
                    }else{
                        if(this.dept !== 'All'){
                            if(this.dept === row.row.s){
                                return defaultClass;
                            }else{
                                return 'd-none';
                            }
                        }else{
                            return defaultClass;
                        }
                    }
                }
            },
            _loadArrayData: function(){
                if(this.regionName.trim().length === 0){
                    this.tableData = [];
                    return;
                }
                this.isLoadingRemoteData = true;
                var that = this;
                $.get(
                    '/region/load_report?region=' + this.regionName.trim(),
                    function(res){
                        if(res.error_no === 100){
                            that.tableData = res.data;
                        }
                        that.isLoadingRemoteData = false;
                    },
                    'json'
                );
            },
            getMockUserUrl: function(userId){
                return '/admin/users/mock/'+userId;
            }
        }
    });
}
