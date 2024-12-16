document.addEventListener("DOMContentLoaded", function() {
    var ctx = document.getElementById('monthlySalesChart').getContext('2d');

    // Labels for the months of the year
    var monthlyChartData = {
        labels: ['Jan', 'Feb', 'March', 'April', 'May', 'June', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [
            {
                label: 'This Month Sales',
                data: [],  // This will be populated by PHP/JS with current month's data
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
                label: 'Last Month Sales',
                data: [],  // This will be populated by PHP/JS with last month's data
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

    var monthlySalesChart = new Chart(ctx, {
        type: 'line',
        data: monthlyChartData,
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

    function fetchData() {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '../function/php/fetch_monthly_sales_data.php', true); 
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                console.log('Response Text:', xhr.responseText); 
                if (xhr.responseText.includes('|')) {
                    try {
                        var response = xhr.responseText.split('|');
                        var thisMonthData = response[0].split(',').map(Number);
                        var lastMonthData = response[1].split(',').map(Number);
            
                        monthlySalesChart.data.datasets[0].data = thisMonthData;  
                        monthlySalesChart.data.datasets[1].data = lastMonthData;  
                        monthlySalesChart.update();
                    } catch (e) {
                        console.error('Error parsing response:', e);
                    }
                } else {
                    console.error('Unexpected response format:', xhr.responseText);
                }
            } else if (xhr.readyState === 4) {
                console.error('Error fetching data:', xhr.statusText);
            }
        };
        xhr.send();
    }

    fetchData();
});
