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
                        console.log(that.platinum);
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
});