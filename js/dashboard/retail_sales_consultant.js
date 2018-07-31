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
    gage.appendChild(indicator);
}

for (var i = 0; i < GAGE_DATA.length; i++){
    generateGageIndicator('g1',GAGE_DATA[i][0],GAGE_DATA[i][1],GAGE_DATA[i][2]);
}
document.addEventListener("DOMContentLoaded", function(event) {

    var g1 = new JustGage({
        id: 'g1',
        value: YEAR_TO_DATE,
        min: MIN,
        max: MAX,
        pointer: true,
        levelColorsGradient: false,
        levelColors: [LEVEL_COLOR],
        formatNumber: true,
        pointerOptions: {
            toplength: -15,
                bottomlength: 10,
                bottomwidth: 12,
                color: '#8e8e93',
                stroke: '#ffffff',
                stroke_width: 3,
                stroke_linecap: 'round'
        },
        gaugeWidthScale: 0.35
    });
    // document.getElementById('gauge_refresh').addEventListener('click', function() {
    //     g1.refresh(getRandomInt(0, 100));
    // });
});
// End of gage

// MONTHLY CREDITS
var monthlyCreditTableArray = [
    ['Month',  'Credits'],
];
for (var i=0;i<JS_credits.length;i++){
    monthlyCreditTableArray.push(JS_credits[i]);
}
var barData = google.visualization.arrayToDataTable(monthlyCreditTableArray);

google.setOnLoadCallback(drawCharts);