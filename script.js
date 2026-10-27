document.querySelectorAll('a[href^="#"]').forEach(function (link) {
    link.addEventListener('click', function (event) {
        const target = document.querySelector(this.getAttribute('href'));

        if (target) {
            event.preventDefault();
            target.scrollIntoView({ behavior: 'smooth' });
        }
    });
});

const addTripButton = document.getElementById('add-trip');
const message = document.getElementById('dashboard-message');

if (addTripButton && message) {
    addTripButton.addEventListener('click', function () {
        message.textContent = 'Саяхат қосу функциясы келесі кезеңде жасалады.';
    });
}

document.querySelectorAll('.trip-button').forEach(function (button) {
    button.addEventListener('click', function () {
        document.getElementById('dashboard-message').textContent =
            'Бұл саяхаттың толық ақпараты келесі кезеңде қосылады.';
    });
});