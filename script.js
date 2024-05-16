// function fetchData() {
//     return fetch('generate_data.php')
//         .then(response => response.json())
//         .then(data => {
//             return data;
//         });
// }

// function createLinearChart(data) {
//     const labels = data.map(entry => entry[0]); 
//     const answerCounts = data.map(entry => entry[1]); 
//     const noAnswerCounts = data.map(entry => entry[2]); 
//     const abandonedCounts = data.map(entry => entry[3]); 

//     const ctx = document.getElementById('answerCallChart').getContext('2d');

//     new Chart(ctx, {
//         type: 'line',
//         data: {
//             labels: labels,
//             datasets: [{
//                 label: 'Answer',
//                 data: answerCounts,
//                 borderColor: 'green',
//                 backgroundColor: 'rgba(0, 128, 0, 0.2)',
//                 borderWidth: 2,
//                 fill: true,
//             }, {
//                 label: 'No Answer',
//                 data: noAnswerCounts,
//                 borderColor: 'red',
//                 backgroundColor: 'rgba(255, 0, 0, 0.2)',
//                 borderWidth: 2,
//                 fill: true,
//             }, {
//                 label: 'Abandoned',
//                 data: abandonedCounts,
//                 borderColor: 'orange',
//                 backgroundColor: 'rgba(255, 165, 0, 0.2)',
//                 borderWidth: 2,
//                 fill: true,
//             }]
//         },
//         options: {
//             responsive: true,
//             maintainAspectRatio: false,
//             scales: {
//                 x: {
//                     display: true,
//                     title: {
//                         display: true,
//                         text: 'Date',
//                     },
//                 },
//                 y: {
//                     display: true,
//                     title: {
//                         display: true,
//                         text: 'Count',
//                     },
//                 },
//             },
//         },
//     });
// }
// document.addEventListener('DOMContentLoaded', () => {
//     fetchData().then(data => createLinearChart(data));
// });




function fetchData() {
    return fetch('generate_data.php')
        .then(response => response.json())
        .then(data => {
            return data;
        });
}

function createLinearChart(data) {
    const labels = data.map(entry => entry[0] + ' (' + entry[1] + 's)'); 
    const answerCounts = data.map(entry => entry[2]); 
    const noAnswerCounts = data.map(entry => entry[3]); 
    const abandonedCounts = data.map(entry => entry[4]); 

    const ctx = document.getElementById('answerCallChart').getContext('2d');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Answer',
                data: answerCounts,
                borderColor: 'green',
                backgroundColor: 'rgba(0, 128, 0, 0.2)',
                borderWidth: 2,
                fill: true,
            }, {
                label: 'No Answer',
                data: noAnswerCounts,
                borderColor: 'red',
                backgroundColor: 'rgba(255, 0, 0, 0.2)',
                borderWidth: 2,
                fill: true,
            }, {
                label: 'Abandoned',
                data: abandonedCounts,
                borderColor: 'orange',
                backgroundColor: 'rgba(255, 165, 0, 0.2)',
                borderWidth: 2,
                fill: true,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Date (Duration)',
                    },
                },
                y: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Count',
                    },
                },
            },
        },
    });
}

document.addEventListener('DOMContentLoaded', () => {
    fetchData().then(data => createLinearChart(data));
});
