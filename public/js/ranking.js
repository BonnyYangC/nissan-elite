
// Member rankings
//var memberRankingsEl = document.getElementById('member-ranking-app');
//if(memberRankingsEl){
    var MemberRankingsApp = new Vue({
        el: '#member-ranking-app',
        delimiters: ['${', '}'],
        data: {
            tableData: [{
                    date: '2016-05-03',
                    name: 'Tom',
                    address: 'No. 189, Grove St, Los Angeles'
                }, {
                    date: '2016-05-02',
                    name: 'Tom',
                    address: 'No. 189, Grove St, Los Angeles'
                }, {
                    date: '2016-05-04',
                    name: 'Tom',
                    address: 'No. 189, Grove St, Los Angeles'
                }, {
                    date: '2016-05-01',
                    name: 'Tom',
                    address: 'No. 189, Grove St, Los Angeles'
                }],
                blocks:[],
                modalTitle:'',
                type:'',
                dialogTableVisible:false,
                tableTitle:'',
                lastSelectedRole:null,
                lastSelectedAction: null,
                sales_manager_status: false,
                sales_manager_platinum: false,
                retail_sales_consultant_status: false,
                retail_sales_consultant_platinum: false,
                fleet_sales_executive_status: false,
                fleet_sales_executive_platinum: false,

        },
        created: function(){

        },
        methods: {
            displayRankingForAll: function(role, type) {
                //console.log('test function:', role, type);
                switch(role) {
                    case 'M':
                        if (type === 'status') {
                            this.sales_manager_status = !this.sales_manager_status;
                        } else {
                            this.sales_manager_platinum = !this.sales_manager_platinum;
                        }
                        break;
                    case 'R':
                        if (type === 'status') {
                            this.retail_sales_consultant_status = !this.retail_sales_consultant_status;
                        } else {
                            this.retail_sales_consultant_platinum = !this.retail_sales_consultant_platinum;
                        }
                        break;
                    case 'F':
                        if (type === 'status') {
                            this.fleet_sales_executive_status = !this.fleet_sales_executive_status;
                        } else {
                            this.fleet_sales_executive_platinum = !this.fleet_sales_executive_platinum;
                        }
                        break;
                }
            },
            handleClick: function(role, action, type){
                var that = this;
                type = type || 'status';
                this.lastSelectedRole = role;
                this.lastSelectedAction = action;
                this.lastSelectedType = type;
                axios.get(
                    '/get_ranking?role='+role+'&action='+action+'&type='+type
                ).then(function(res){
                    if(res.data.error_no === 100){
                        that.blocks = res.data.data.blocks;
                        //console.log('block:', that.blocks);
                        that.modalTitle = res.data.data.modalTitle;
                        that.dialogTableVisible = true;
                        // that.tableTitle = that._getRoleNameText(role) + ': ' + action;
                        that.tableTitle = res.data.data.tableTitle + ': ' + action;
                        that.type = type;
                    }else{
                        that.$notify.error({
                            title: 'Notes',
                            message: 'System is busy, please try again!'
                        });
                    }
                });
            },
            _getRoleNameText: function(abbr){
                var name = '';
                console.log(abbr);
                switch (abbr){
                    case 'PS':
                        name = 'PARTS SALES REPRESENTATIVE';
                        break;
                    case 'PM':
                        name = 'PARTS MANAGER';
                        break;
                    case 'SM':
                        name = 'SERVICE MANAGER';
                        break;
                    case 'SA':
                        name = 'SERVICE ADVISOR';
                        break;
                    case 'I':
                        name = 'F&I MANAGER';
                        break;
                    case 'C':
                        name = 'FINANCIAL CONTROLLER';
                        break;
                    case 'M':
                        name = 'SALES MANAGER';
                        break;
                    case 'R':
                        name = 'RETAIL SALES CONSULTANT';
                        break;
                    case 'SC':
                        name = 'STOCK CONTROLLER';
                        break;
                    case 'FM+F':
                        name = 'FLEET MANAGER/SALES CONSULTANT';
                        break;
                    case 'F':
                        name = 'FLEET SALES EXECUTIVE';
                        break;
                    case 'T':
                        name = 'Technician Master/Advanced';
                        break;
                    default:
                        break;
                }
                return name;
            },
            printThis: function(){
                if(this.lastSelectedAction && this.lastSelectedRole && this.lastSelectedType){
                    window.open('/admin/data_export/ranking?role='+this.lastSelectedRole+'&action='+this.lastSelectedAction+'&type='+this.lastSelectedType);
                }else{
                    return false;
                }
            },
            tableRowClassName: function(param) {
                if (param.row.re === 'NO') {
                    return param.row.cn + ' warning-row';
                }
                return param.row.cn ;
            }
        }
    });
//}
