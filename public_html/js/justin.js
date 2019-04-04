$(document).ready(function(){
    if($('#topnavbar').length === 1){
        $('#topnavbar').affix({
            offset: {
                top: $('#banner').height()
            }
        });
    }
    // md guide member
    var mdGuideMemberEl = document.getElementById('md-guide-member-app');
    if(mdGuideMemberEl){
        var mdGuideMemberApp = new Vue({
            el:'#md-guide-member-app',
            delimiters: ['${', '}'],
            data:{
                gold:[],
                platinum:[]
            },
            mounted: function(){
                var that = this;
                $.get(
                    '/data/md-guild/guild-members-platinum.json',
                    function(data){
                        that.platinum = data;
                    }
                );
                $.get(
                    '/data/md-guild/guild-members-gold.json',
                    function(data){
                        that.gold = data;
                    }
                );
            }
        });
    }
    var mdGuideWinnerEl = document.getElementById('md-guide-winner-app');
    if(mdGuideWinnerEl){
        var mdGuideWinnerApp = new Vue({
            el:'#md-guide-winner-app',
            delimiters: ['${', '}'],
            data:{
                thisYear:[],
                lastYear:[]
            },
            mounted: function(){
                var thisYearUrl = $('#this-year-winner-data').data('source');
                var lastYearUrl = $('#last-year-winner-data').data('source');
                var that = this;
                $.get(
                    thisYearUrl,
                    function(data){
                        that.thisYear = data;
                    }
                );
                $.get(
                    lastYearUrl,
                    function(data){
                        that.lastYear = data;
                    }
                );
            }
        });
    }
    var mdEventEl = document.getElementById('md-event-app');
    if(mdEventEl){
        var mdEventApp = new Vue({
            el:'#md-event-app',
            delimiters: ['${', '}'],
            data:{
                firstTable:[],
                secondTable:[]
            },
            mounted: function(){
                var firstTableUrl = $('#first-table').data('source');
                var secondTableUrl = $('#second-table').data('source');
                var that = this;
                $.get(
                    firstTableUrl,
                    function(data){
                        that.firstTable = data;
                    }
                );
                $.get(
                    secondTableUrl,
                    function(data){
                        that.secondTable = data;
                    }
                );
            }
        });
    }
    // Calendar page
    if($('#calendar').length === 1 && typeof calendarEvents !== 'undefined'){
        var currentYear = new Date().getFullYear();
        var CALENDAR = $('#calendar').calendar({
            dataSource: calendarEvents,
            clickDay: function (e) {
                dayClicked(e.events);
            },
            renderEnd: function (year) {
                try {
                    highlightMonths();
                } catch (e) {}
            },
            mouseOnDay: function(e) {
                if(e.events.length > 0) {
                    var content = '';

                    for(var i in e.events) {
                        content += '<div class="event-tooltip-content">'
                            + '<div class="event-name" style="color:' + e.events[i].color + '">' + e.events[i].name + '</div>'
                            + '</div>';
                    }
                    $(e.element).popover({
                        trigger: 'manual',
                        container: 'body',
                        html:true,
                        content: content
                    });

                    $(e.element).popover('show');
                }
            },
            mouseOutDay: function(e) {
                if(e.events.length > 0) {
                    $(e.element).popover('hide');
                }
            }
        });
        //
        var monthHighlightFeatureEnabled = false;
        var EARLIEST_START, LATEST_FINISH;

        function dayClicked (events) {
            if (!monthHighlightFeatureEnabled) {
                return false;
            }

            function getFurthest (events, prop, mathFunc) {
                var dates = [];

                for (var i = 0; i < events.length; i++) {
                    dates.push(events[i][prop]);
                }

                return new Date(mathFunc.apply(null, dates));
            }

            EARLIEST_START = getFurthest(events, 'startDate', Math.min);
            LATEST_FINISH = getFurthest(events, 'endDate', Math.max);

            highlightMonths();
        }

        /* Accepts a '<table class="month">' element */
        function getLastDayOfMonth (monthTable) {
            var day_DIVs = monthTable.querySelectorAll('div.day-content');

            /* The last day of the month should simply be the length of this
            NodeList */
            return day_DIVs.length;
        }

        function highlightMonths () {
            var month_TABLEs = document.querySelectorAll('table.month');

            for (var i = 0; i < month_TABLEs.length; i++) {
                tryHighlight(month_TABLEs[i], i);
            }
        }

        function tryHighlight (monthTable, index) {
            var currentYear = CALENDAR.getYear();
            var month = index;
            var lastDayOfMonth = getLastDayOfMonth(monthTable);

            /* Actal Date object */
            var lastDateOfMonth = new Date(currentYear, month, lastDayOfMonth);

            if (
                (lastDateOfMonth >= EARLIEST_START && lastDateOfMonth <= LATEST_FINISH) ||
                (lastDateOfMonth.getMonth() == EARLIEST_START.getMonth() && lastDateOfMonth.getYear() == EARLIEST_START.getYear()) ||
                (lastDateOfMonth.getMonth() == LATEST_FINISH.getMonth() && lastDateOfMonth.getYear() == LATEST_FINISH.getYear())
            ) {
                monthTable.setAttribute('class', 'month highlighted');
            } else {
                monthTable.setAttribute('class', 'month');
            }
        }
    }

    // General calendar widget
    if(typeof CALENDAR_EVENTS !== 'undefined' && $('#calendar').length > 0){
        $('#calendar').fullCalendar({
            header: {
                left: 'prev',
                center: 'title',
                right: 'next'
            },
            eventClick: function(date, jsEvent, view) {
                window.location.href = '/dashboard/Calendar';
            },
            dayClick: function(date, jsEvent, view) {
                window.location.href = '/dashboard/Calendar';
            },
            navLinks: true, // can click day/week names to navigate views
            editable: true,
            eventLimit: true, // allow "more" link when too many events,
            height: 350,
            dayNamesShort: ['S', 'M', 'T', 'W', 'T', 'F', 'S'],
            events: CALENDAR_EVENTS
        });
    }

    // Member rankings
    var memberRankingsEl = document.getElementById('member-ranking-app');
    if(memberRankingsEl){
        var MemberRankingsApp = new Vue({
            el: '#member-ranking-app',
            delimiters: ['${', '}'],
            data: function(){
                return {
                    blocks:[],
                    modalTitle:'',
                    dialogTableVisible:false,
                    tableTitle:'',
                    lastSelectedRole:null,
                    lastSelectedAction: null
                };
            },
            created: function(){

            },
            methods: {
                handleClick: function(role, action, type){
                    console.log('type = '+type)
                    var that = this;
                    this.lastSelectedRole = role;
                    this.lastSelectedAction = action;
                    this.lastSelectedType = type;
                    axios.get(
                        '/dashboard/get-rankings?role='+role+'&action='+action+'&type='+type
                    ).then(function(res){
                        if(res.data.error_no === 100){
                            that.blocks = res.data.data.blocks;
                            that.modalTitle = res.data.data.modalTitle;
                            that.dialogTableVisible = true;
                            that.tableTitle = that._getRoleNameText(role) + ': ' + action;
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
                        default:
                            break;
                    }
                    return name;
                },
                printThis: function(){
                    if(this.lastSelectedAction && this.lastSelectedRole){
                        window.open('/dashboard/print-rankings?role='+this.lastSelectedRole+'&action='+this.lastSelectedAction);
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
    }
});