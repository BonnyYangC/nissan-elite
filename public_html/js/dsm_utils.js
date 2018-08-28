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
            tableData:[],
            keyword:''
        },
        created: function(){
            this.managerId = managerId;
            this.employeeCode = employeeCode;
            this.regions = regions;
            for (var i = 0; i < this.regions.length; i++) {
                this.regionCodes += this.regions[i].region_code + ' ';
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
            showMe:function(row, rowIndex){
                if(this.keyword.trim().length === 0){
                    return null;
                }else{
                    if(row.row.dn.toLowerCase().indexOf(this.keyword.toLowerCase()) === -1){
                        // not found
                        return 'hidden';
                    }else{
                        return null;
                    }
                }
            },
            filterHandler: function(value, row, column) {
                const property = column['property'];
                return row[property] === value;
            },
            _loadArrayData: function(){
                var that = this;
                axios.get(
                    '/api/dsm/load-regional-data?manager='+this.managerId + '&regions=' + this.regionCodes.trim()
                ).then(function(res){
                    if(res.data.error_no === 100){
                        that.tableData = res.data.data;
                    }
                });
            }
        }
    });
}