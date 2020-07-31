var dsmEl = document.getElementById('dsm-app');
if(dsmEl){
    var dsmApp = new Vue({
        el:'#dsm-app',
        delimiters: ['${', '}'],
        data:{
            managerId: null,
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
            this.managerId = managerId;
            this.employeeCode = employeeCode;
            this.regions = regions;
            if(this.regions.length === 1){
                this.regionName = this.regions[0];
            }
        },
        methods:{
            handlerTerritoryReport: function(event, userId){
                event.preventDefault();
                var url = '/api/dsm/download-regional-data?member='+userId + '&dept=' + this.dept;
                if(this.keyword !== ''){
                    url += '&dealer=' + this.keyword;
                }
                window.location.href = url;
            },
            handlerActiveMemberList: function(event, userId){
                event.preventDefault();
                var url = '/api/dsm/download-active-member-list?member='+userId + '&dept=' + this.dept;
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
                        return 'hidden';
                    }else{
                        if(this.dept !== 'All'){
                            if(this.dept === row.row.s){
                                return defaultClass;
                            }else{
                                return 'hidden';
                            }
                        }else{
                            return defaultClass;
                        }
                    }
                }
            },
            filterHandler: function(value, row, column) {
                const property = column['property'];
                if(this.dept){
                    return row[property] === value && this.dept === row.sc;
                }else {
                    return row[property] === value;
                }
            },
            _loadArrayData: function(){
                if(this.regionName.trim().length === 0){
                    this.tableData = [];
                    return;
                }
                this.isLoadingRemoteData = true;
                var that = this;
                // axios.get(
                //     '/api/dsm/load-regional-data?manager='+this.managerId + '&regions=' + this.regionName.trim()
                // ).then(function(res){
                //     if(res.data.error_no === 100){
                //         that.tableData = res.data.data;
                //     }
                //     that.isLoadingRemoteData = false;
                // });
                $.get(
                    '/api/dsm/load-regional-data?manager='+this.managerId + '&regions=' + this.regionName.trim(),
                    function(res){
                        if(res.error_no === 100){
                            that.tableData = res.data;
                        }
                        that.isLoadingRemoteData = false;
                    },
                    'json'
                );
            },
            getMockUserUrl: function(employeeCode){
                return '/admin/fake-user?uc='+employeeCode+'&mock=1';
            },
            getFullPositionNameByCode: function(abbr){
                var fullName = null;
                switch (abbr){
                    case 'I':
                        fullName = 'F&I Manager';
                        break;
                    case 'R':
                        fullName = 'Retail Sales Consultant';
                        break;
                    case 'F':
                        fullName = 'Fleet Sales Executive';
                        break;
                    case 'FM':
                        fullName = 'Fleet Sales Manager';
                        break;
                    case 'M':
                        fullName = 'Sales Manager';
                        break;
                    case 'SA':
                        fullName = 'Service Advisor';
                        break;
                    case 'SC':
                        fullName = 'Stock Controller';
                        break;
                    case 'C':
                        fullName = 'Financial Controller';
                        break;
                    case 'PM':
                        fullName = 'Parts Manager';
                        break;
                    case 'PS':
                        fullName = 'Parts Sales';
                        break;
                    case 'SM':
                        fullName = 'Service Manager';
                        break;
                    default:
                        break;
                }
                return fullName;
            }
        }
    });
}