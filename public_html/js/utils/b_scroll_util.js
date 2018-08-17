const BS_WRAPPER_CLASS = '.bs-wrapper';

var wrapper = document.querySelector(BS_WRAPPER_CLASS);
if(wrapper){
    var scroll = new BScroll(wrapper,{
        click: true
    });
}
