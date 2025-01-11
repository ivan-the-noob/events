
function fetchRatings() {
    return new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', '../function/php/fetch_ratings.php', true);

        xhr.onload = function() {
            if (xhr.status === 200) {

                console.log('Ratings fetched:', xhr.responseText);  
                const ratings = xhr.responseText.split(',');  
                resolve(ratings);
            } else {
                reject('Error fetching ratings');
            }
        };

        xhr.onerror = function() {
            reject('Request error');
        };

        xhr.send();
    });
}

fetchRatings().then(ratings => {
    console.log('Data received:', ratings);  

    if (ratings.length === 0) {
        console.log('No ratings available.');
        return;
    }


    const ratingCount = {};
    ratings.forEach(rating => {
        if (ratingCount[rating]) {
            ratingCount[rating]++;
        } else {
            ratingCount[rating] = 1;
        }
    });

    console.log('Rating Count:', ratingCount); 

    const totalRatings = ratings.length;
    console.log('Total Ratings:', totalRatings); 

    const percentages = {
        5: (ratingCount['5'] || 0) / totalRatings * 100,
        4: (ratingCount['4'] || 0) / totalRatings * 100,
        3: (ratingCount['3'] || 0) / totalRatings * 100,
        2: (ratingCount['2'] || 0) / totalRatings * 100
    };

    console.log('Percentages:', percentages); 

    const ctx = document.getElementById('ratingPieChart').getContext('2d');
    const data = {
        labels: ['5 Stars', '4 Stars', '3 Stars', '2 Stars'],
        datasets: [{
            data: [
                percentages[5] || 0,
                percentages[4] || 0,
                percentages[3] || 0,
                percentages[2] || 0
            ],
            backgroundColor: [
                'rgba(255, 99, 132, 0.6)',
                'rgba(255, 159, 64, 0.6)',
                'rgba(255, 205, 86, 0.6)',
                'rgba(54, 162, 235, 0.6)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 205, 86, 1)',
                'rgba(54, 162, 235, 1)'
            ],
            borderWidth: 1
        }]
    };

    const config = {
        type: 'pie',
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Total Ratings'
                }
            }
        },
    };

    const myChart = new Chart(ctx, config);
}).catch(error => {
    console.error('Error:', error);
});