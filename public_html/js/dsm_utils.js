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
            keyword:'',
            dept:'All',
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
            ]
        },
        created: function(){
            this.managerId = managerId;
            this.employeeCode = employeeCode;
            this.regions = regions;
            for (var i = 0; i < this.regions.length; i++) {
                this.regionName += this.regions[i] + ' ';
            }
            this._loadArrayData();
        },
        methods:{
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
                if(this.keyword.trim().length === 0 && this.dept === 'All'){
                    return null;
                }else{
                    if(row.row.dn.toLowerCase().indexOf(this.keyword.toLowerCase()) === -1){
                        // not found
                        return 'hidden';
                    }else{
                        if(this.dept !== 'All'){
                            if(this.dept === row.row.sc){
                                return null;
                            }else{
                                return 'hidden';
                            }
                        }else{
                            return null;
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
                var that = this;
                axios.get(
                    '/api/dsm/load-regional-data?manager='+this.managerId + '&regions=' + this.regionName.trim()
                ).then(function(res){
                    if(res.data.error_no === 100){
                        that.tableData = res.data.data;
                    }
                });
            },
            getMockUserUrl: function(employeeCode){
                return '/admin/fake-user?uc='+employeeCode;
            }
        }
    });
}