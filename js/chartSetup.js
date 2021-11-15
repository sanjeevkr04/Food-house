const labels = [
  'January',
  'February',
  'March',
  'April',
  'May',
  'June',
  'July',
  'August',
  'September',
  'October',
  'November',
  'December'
];

const data = {
  labels: labels,
  datasets: [{
    label: 'Revenue (in ₹)',
    backgroundColor: '#50c783',
    borderColor: '#50c783',
    data: [0, 20, 50, 20, 0, 30, 40],
  },{
    label: 'Revenue (in ₹)',
    backgroundColor: '#50c783',
    borderColor: '#50c783',
    data: [0, 10, 40, 30, 0, 20, 30],
  }]
};

const config = {
  type: 'line',
  data: data,
  options: {}
};

const myChart = new Chart(
    document.getElementById('myChart'),
    config
  );