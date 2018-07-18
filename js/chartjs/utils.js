window.chartColors = {
	red: '#c40030',
	red1: '#c40030',
	lightgrey: '#d2d2d2',
	white: '#FFFFFF',
	midgrey: '#555555',
	lowred: '#999999',
	darkgrey: '#333333',
	black: '#111111',
	purple: 'rgb(153, 102, 255)',
	grey: '#555555'
};

window.randomScalingFactor = function() {
	return (Math.random() > 0.5 ? 1.0 : -1.0) * Math.round(Math.random() * 100);
}