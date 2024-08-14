// Chart.js Initialization
var ctx1 = document.getElementById('pieChart1').getContext('2d');
var pieChart1 = new Chart(ctx1, {
    type: 'pie',
    data: {
        labels: ['Red', 'Blue', 'Yellow'],
        datasets: [{
            label: 'Chart 1',
            data: [10, 20, 30],
            backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56']
        }]
    }
});

var ctx2 = document.getElementById('pieChart2').getContext('2d');
var pieChart2 = new Chart(ctx2, {
    type: 'pie',
    data: {
        labels: ['Green', 'Purple', 'Orange'],
        datasets: [{
            label: 'Chart 2',
            data: [15, 25, 35],
            backgroundColor: ['#4BC0C0', '#9966FF', '#FF9F40']
        }]
    }
});

var ctx3 = document.getElementById('pieChart3').getContext('2d');
var pieChart3 = new Chart(ctx3, {
    type: 'pie',
    data: {
        labels: ['Blue', 'Orange', 'Purple'],
        datasets: [{
            label: 'Chart 3',
            data: [20, 30, 25],
            backgroundColor: ['#36A2EB', '#FF9F40', '#9966FF']
        }]
    }
});

var ctx4 = document.getElementById('pieChart4').getContext('2d');
var pieChart4 = new Chart(ctx4, {
    type: 'pie',
    data: {
        labels: ['Red', 'Blue', 'Yellow'],
        datasets: [{
            label: 'Chart 4',
            data: [30, 25, 15],
            backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56']
        }]
    }
});
