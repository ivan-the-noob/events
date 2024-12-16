document.addEventListener("DOMContentLoaded", function () {
    var ctx = document.getElementById('salesChart').getContext('2d');

    var chartData = {
        labels: ['Mon', 'Tues', 'Wed', 'Thurs', 'Fri', 'Sat', 'Sun'],
        datasets: [
            {
                label: 'Today',
                data: [],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                fill: true,
                pointBackgroundColor: 'rgba(54, 162, 235, 1)',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgba(54, 162, 235, 1)'
            },
            {
                label: 'Yesterday',
                data: [],
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1,
                fill: true,
                pointBackgroundColor: 'rgba(255, 99, 132, 1)',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgba(255, 99, 132, 1)'
            }
        ]
    };

    var salesChart = new Chart(ctx, {
        type: 'line',
        data: chartData,
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    min: 1000, 
                    max: 20000, 
                    ticks: {
                        callback: function (value) {
                            return value.toLocaleString(); 
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            var label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += context.raw.toLocaleString(); 
                            return label;
                        }
                    }
                }
            }
        }
    });

    function fetchData() {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '../function/php/fetch_sales_data.php', true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                console.log('Response Text:', xhr.responseText); 
                if (xhr.responseText.includes('|')) {
                    try {
                        var response = xhr.responseText.split('|');
                        var todayData = response[0].split(',').map(Number);
                        var yesterdayData = response[1].split(',').map(Number);
            
                        salesChart.data.datasets[0].data = todayData;
                        salesChart.data.datasets[1].data = yesterdayData;
                        salesChart.update();
                    } catch (e) {
                        console.error('Error parsing response:', e);
                    }
                } else {
                    console.error('Unexpected response format:', xhr.responseText);
                }
            }
             else if (xhr.readyState === 4) {
                console.error('Error fetching data:', xhr.statusText);
            }
        };
        xhr.send();
    }

    fetchData();
});
