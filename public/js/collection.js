// collection.js
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('live-search');
    const cards = document.querySelectorAll('.card-wrapper');

    searchInput.addEventListener('input', function () {
        const query = this.value.toLowerCase();

        cards.forEach(card => {
            const name = card.dataset.name;
            card.style.display = name.includes(query) ? 'block' : 'none';
        });
    });
});
