document.addEventListener("DOMContentLoaded", function() {
    var ctx = document.getElementById('yearlySalesChart').getContext('2d');
    var yearlyChartData = {
        labels: ['2018', '2019', '2020', '2021', '2022', '2023', '2024'],
        datasets: [
            {
                label: 'Current Sales',
                data: [100000, 135000, 160000, 185000, 210000, 250000, 300000],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
                fill: true,
                pointBackgroundColor: 'rgba(75, 192, 192, 1)',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgba(75, 192, 192, 1)'
            },
            {
                label: 'Previous Sales',
                data: [95000, 121000, 143000, 165003, 200000, 230000, 280000], 
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1,
                fill: true,
                pointBackgroundColor: 'rgba(153, 102, 255, 1)',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgba(153, 102, 255, 1)'
            }
        ]
    };

    var yearlySalesChart = new Chart(ctx, {
        type: 'line',
        data: yearlyChartData,
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    max: 350000,
                    ticks: {
                        callback: function(value, index, values) {
                            return value + '₱';
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            var label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += context.raw + '₱';
                            return label;
                        }
                    }
                }
            }
        }
    });
});
