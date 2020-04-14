// Gage starts
gadeIndicatorStartingZIndex = 20;
function generateGageIndicator (gageId, percent, color, text) {
    var dec = percent * 0.01;
    var total = 180 + (-180 * dec);

    var indicator = document.createElement("div");
    indicator.className = "gage-indicator";
    indicator.style.transform = "rotate(-" + total + "deg)";
    indicator.style.zIndex = gadeIndicatorStartingZIndex--;

    var indicatorText = document.createElement("span");
    indicatorText.className = "gage-indicator-text";
    indicatorText.style.color = color;
    indicatorText.textContent = text;
    indicatorText.style.transform = "rotate(" + total + "deg)";

    indicator.appendChild(indicatorText);

    var gage = document.getElementById(gageId);
    console.log(indicator)
    gage.appendChild(indicator);
}

//for (var i = 0; i < GAGE_DATA.length; i++){
    //generateGageIndicator('g1',GAGE_DATA[i][0],GAGE_DATA[i][1],GAGE_DATA[i][2]);
//}
// document.addEventListener("DOMContentLoaded", function(event) {
//     var g1 = new JustGage({
//         id: 'g1',
//         value: YEAR_TO_DATE,
//         min: MIN,
//         max: MAX,
//         pointer: true,
//         levelColorsGradient: false,
//         levelColors: [LEVEL_COLOR],
//         formatNumber: true,
//         pointerOptions: {
//             toplength: -15,
//             bottomlength: 10,
//             bottomwidth: 12,
//             color: '#8e8e93',
//             stroke: '#ffffff',
//             stroke_width: 3,
//             stroke_linecap: 'round'
//         },
//         gaugeWidthScale: 0.35
//     });
// });
// End of gage

// MONTHLY POINTS
var monthlyCreditTableArray = [
    ['Month',  award_unit],
];
for (var i=0;i<JS_credits.length;i++){
    monthlyCreditTableArray.push(JS_credits[i]);
}
var barData = google.visualization.arrayToDataTable(monthlyCreditTableArray);

google.setOnLoadCallback(drawCharts);

// credits earned metrics
$(document).ready(function(){
    if(typeof CREDITS_EARNED_METRICS !== 'undefined'){
        var barChartData = {
            labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" , "Jan", "Feb", "Mar"],            
            datasets: CREDITS_EARNED_METRICS
        };
        window.onload = function() {
            var ctx = document.getElementById("credits-earned-canvas").getContext("2d");
            window.myBar = new Chart(ctx, {
                type: 'bar',
                data: barChartData,
                options: {
                    tooltips: {
                        mode: 'index',
                        intersect: false
                    },
                    responsive: true,
                    scales: {
                        xAxes: [{
                            stacked: true,
                        }],
                        yAxes: [{
                            stacked: true
                        }]
                    },
                },
            });
        };
        if(document.getElementById('randomizeData')){
            document.getElementById('randomizeData').addEventListener('click', function() {
                barChartData.datasets.forEach(function(dataset, i) {
                    dataset.data = dataset.data.map(function() {
                        return randomScalingFactor();
                    });
                });
                window.myBar.update();
            });
        }
    }
});
// credits earned metrics: end