document.addEventListener("DOMContentLoaded", function () {
    var ctx = document.getElementById('salesChart').getContext('2d');

    var chartData = {
        labels: [], // Week labels will be generated dynamically
        datasets: [
            {
                label: 'Weekly Sales',
                data: [], // Weekly data will be fetched dynamically
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                fill: true,
                pointBackgroundColor: 'rgba(54, 162, 235, 1)',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgba(54, 162, 235, 1)',
                tension: 0.4 // Adds wavy effect
            }
        ]
    };

    var salesChart = new Chart(ctx, {
        type: 'line',
        data: chartData,
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    min: 1000,
                    max: 100000,
                    ticks: {
                        callback: function (value) {
                            return value.toLocaleString(); // Format numbers with commas
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
                            label += context.raw.toLocaleString(); // Format numbers with commas
                            return label;
                        }
                    }
                }
            },
            elements: {
                line: {
                    tension: 0.4 // Global setting for smooth curves
                }
            }
        }
    });

    function fetchWeeklyData() {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '../function/php/fetch_sales_data.php', true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                console.log('Response Text:', xhr.responseText);
                try {
                    var weeklyData = xhr.responseText.split(',').map(Number);

                    // Generate week labels dynamically
                    var weeksInMonth = weeklyData.length;
                    chartData.labels = Array.from({ length: weeksInMonth }, (_, i) => `Week ${i + 1}`);

                    salesChart.data.labels = chartData.labels;
                    salesChart.data.datasets[0].data = weeklyData;
                    salesChart.update();
                } catch (e) {
                    console.error('Error parsing response:', e);
                }
            } else if (xhr.readyState === 4) {
                console.error('Error fetching data:', xhr.statusText);
            }
        };
        xhr.send();
    }

    fetchWeeklyData();
});
