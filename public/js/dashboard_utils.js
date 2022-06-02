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
                        // Disable the on-canvas tooltip
                        enabled: false,
                        mode: 'index',
                        custom: function(tooltipModel) {
                            // Tooltip Element
                            var tooltipEl = document.getElementById('chartjs-tooltip');

                            // Create element on first render
                            if (!tooltipEl) {
                                tooltipEl = document.createElement('div');
                                tooltipEl.id = 'chartjs-tooltip';
                                tooltipEl.innerHTML = '<table></table>';
                                document.body.appendChild(tooltipEl);
                            }

                            // Hide if no tooltip
                            if (tooltipModel.opacity === 0) {
                                tooltipEl.style.opacity = 0;
                                return;
                            }

                            // Set caret Position
                            tooltipEl.classList.remove('above', 'below', 'no-transform');
                            if (tooltipModel.yAlign) {
                                tooltipEl.classList.add(tooltipModel.yAlign);
                            } else {
                                tooltipEl.classList.add('no-transform');
                            }

                            function getBody(bodyItem) {
                                return bodyItem.lines;
                            }

                            // Set Text
                            if (tooltipModel.body) {
                                var titleLines = tooltipModel.title || [];
                                var bodyLines = tooltipModel.body.map(getBody);

                                var innerHtml = '<thead>';

                                titleLines.forEach(function(title) {
                                    innerHtml += '<tr><th style="color:#fff">' + title + '</th></tr>';
                                });
                                innerHtml += '</thead><tbody>';

                                bodyLines.forEach(function(body, i) {
                                    [metric, points] = body[0].split(': ');
                                    var colors = tooltipModel.labelColors[i];
                                    var style = 'width: 20px; height: 12px; background-color: ' + colors.backgroundColor;
                                    style += '; border: 1px solid #fff; float: right; margin-right: 1px';
                                    var span = '<td><div style="' + style + '"></div></td>';
                                    var first = '<td style="text-align: left; padding-right: 10px; color: #fff">' + metric + ' : ' + '</td>';
                                    var second = '<td style="text-align: right; color: #fff">' + points + '</td>';
                                    innerHtml += '<tr>' + span + first + second + '</tr>';
                                });
                                innerHtml += '</tbody>';

                                var tableRoot = tooltipEl.querySelector('table');
                                tableRoot.innerHTML = innerHtml;
                            }

                            // `this` will be the overall tooltip
                            var position = this._chart.canvas.getBoundingClientRect();

                            // Display, position, and set styles for font
                            tooltipEl.style.opacity = 1;

                            tooltipEl.style.backgroundColor = tooltipModel.backgroundColor;
                            tooltipEl.style.position = 'absolute';
                            tooltipEl.style.left = position.left + window.pageXOffset + tooltipModel.caretX + 'px';
                            tooltipEl.style.top = position.top + window.pageYOffset + tooltipModel.caretY + 'px';
                            tooltipEl.style.fontFamily = tooltipModel._bodyFontFamily;
                            tooltipEl.style.fontSize = tooltipModel.bodyFontSize + 'px';
                            tooltipEl.style.fontStyle = tooltipModel._bodyFontStyle;
                            tooltipEl.style.padding = tooltipModel.yPadding + 'px ' + tooltipModel.xPadding + 'px';
                            tooltipEl.style.pointerEvents = 'none';
                            tooltipEl.style.borderRadius = tooltipModel.cornerRadius + 'px';
                        }
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
    }
});
// credits earned metrics: end
/*
*                     scales: {
                        x: {
                            stacked: true,
                        },
                        y: {
                            stacked: true
                        }
                    },*/
