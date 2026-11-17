(() => {
    'use strict';
    const form = document.getElementById('review-form');
    if (!form) return;
    const ratingLabels = ['Poor', 'Fair', 'Good', 'Very good', 'Excellent'];
    const radios = [...form.querySelectorAll('[name="rating"]')];
    function updateRating() {
        const value = Number(radios.find(radio => radio.checked)?.value || 0);
        radios.forEach(radio => radio.parentElement.classList.toggle('selected', Number(radio.value) <= value));
        document.getElementById('rating-description').textContent = value ? `${value} out of 5 · ${ratingLabels[value - 1]}` : 'Select a star to rate your experience';
    }
    radios.forEach(radio => radio.addEventListener('change', updateRating));
    document.getElementById('review-filter').addEventListener('change', event => {
        let count = 0;
        document.querySelectorAll('.review-card').forEach(card => {
            card.hidden = event.target.value !== 'all' && card.dataset.rating !== event.target.value;
            if (!card.hidden) count++;
        });
        document.getElementById('review-count').textContent = count;
        document.getElementById('empty-reviews').hidden = count > 0;
    });
    const status = document.getElementById('submission-status');
    form.addEventListener('submit', event => {
        event.preventDefault();
        // Preview only: never send or store personal data.
        form.hidden = true;
        status.hidden = false;
        status.focus();
    });
    document.getElementById('write-again').addEventListener('click', () => {
        form.reset();
        updateRating();
        status.hidden = true;
        form.hidden = false;
        radios[0].focus();
    });
})();
