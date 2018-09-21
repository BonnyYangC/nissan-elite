var slideout = new Slideout({
    'panel': document.getElementById('panel'),
    'menu': document.getElementById('menu'),
    'padding': 256,
    'tolerance': 70,
    'easing': 'cubic-bezier(.32,2,.55,.27)'
});

// Toggle button
document.querySelector('.toggle-button').addEventListener('click', function() {
    slideout.toggle();
});

function slideOutClose(eve) {
    eve.preventDefault();
    slideout.close();
}

slideout.on('beforeopen', function() {
        this.panel.classList.add('panel-mask-open');
    })
    .on('open', function() {
        this.panel.addEventListener('click', slideOutClose);
    })
    .on('beforeclose', function() {
        this.panel.classList.remove('panel-mask-open');
        this.panel.removeEventListener('click', slideOutClose);
    });

// Load menu items
var menuEl = document.getElementById('menu');
if(menuEl){
    var menuApp = new Vue({
        el: '#menu',
        delimiters: ['${', '}'],
        data(){
            return {
                menus: [
                    {
                        title: 'Dashboard',
                        url: '/Dashboard',
                        index: 1
                    },{
                        title: 'Dashboard',
                        url: '/Dashboard',
                        index: 2
                    },{
                        title: 'Dashboard',
                        url: '/Dashboard',
                        index: 3
                    }
                ],
                activeIndex: null,
                currentUri:''
            }
        },
        created(){
            $('.el-menu-vertical-nissan').css('display','block');
            this.currentUri = $('#currentUri').data('content');
            this._loadMenus();
        },
        methods:{
            handleClick: function(item){
                window.location.href = item.url;
            },
            _loadMenus: function(){
                var that = this;
                axios.get(
                    '/api/get-menus?current='+this.currentUri
                ).then(function(res){
                    if(res.status === 200){
                        that.menus = res.data.data;
                        for (var i = 0; i < that.menus.length ; i++) {
                            if(that.menus[i].a){
                                that.activeIndex = i;
                            }
                        }
                    }
                });
            }
        }
    });
}