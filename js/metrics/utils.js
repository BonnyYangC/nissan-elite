google.charts.load('current', {'packages':['corechart']});
setTimeout(function () { adjustLegendMargin(); }, 4000);
/* Moves the legend up slightly for each chart */
function adjustLegendMargin () {
    const charts = document.querySelectorAll('svg');
    for (let i = 0; i < charts.length; i++) {
        let children = charts[i].querySelector('g').querySelectorAll('*');
        for (let j = 0; j < children.length; j++) {
            children[j].setAttribute('y', children[j].getAttribute('y') - 10);
        }
    }
}
function newDrawFunc(obj){
    if(!obj.pilot){
        obj.pilot = ['Month', 'Credits'];
    }
    if(!obj.duration){
        obj.duration = 1600;
    }

    var dArray = [
        obj.pilot
    ];
    for (var i=0;i < obj.dataSource.length;i++){
        dArray.push(obj.dataSource[i]);
    }
    var data = google.visualization.arrayToDataTable(dArray);

    // By default, use bars chart
    if(!obj.type){
        obj.type = 'bars';
    }

    var options = {
        chartArea:{left:65,top:40,bottom:40,width:'80%',height:'75%'},
        legend: 'top',
        animation: {
            duration: obj.duration,
            easing: 'out',
            startup: true
        },
        colors: obj.colors,
        vAxis: {
            viewWindowMode: 'explicit',
            viewWindow: {
                max: obj.max
            }
            , ticks: new Array(obj.length).fill(obj.step).map((n, i) => n * (i + 1))
        },
        seriesType: obj.type
    };
    var chart = new google.visualization.ComboChart(document.getElementById(obj.el));
    chart.draw(data, options);
}

$(document).ready(function(){
    if(typeof CHART_DATA !== 'undefined'){
        $.each(CHART_DATA, function(idx, item){
            google.charts.setOnLoadCallback(function() {newDrawFunc(item)});
        });
    }
});