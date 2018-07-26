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
});