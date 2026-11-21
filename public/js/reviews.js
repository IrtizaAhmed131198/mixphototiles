(() => {
    'use strict';
    const form = document.getElementById('review-form');
    if (!form) return;
    const descriptions = ['Poor', 'Fair', 'Good', 'Very good', 'Excellent'];
    const ratings = [...form.querySelectorAll('[name="rating"]')];
    function updateRating() {
        const value = Number(ratings.find(input => input.checked)?.value || 0);
        ratings.forEach(input => input.parentElement.classList.toggle('selected', Number(input.value) <= value));
        document.getElementById('rating-description').textContent = value
            ? `${value} out of 5 · ${descriptions[value - 1]}`
            : 'Select a star to rate your experience';
    }
    ratings.forEach(input => input.addEventListener('change', updateRating));
    updateRating();
})();
