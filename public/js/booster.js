document.addEventListener('DOMContentLoaded', () => {
	const buttons = document.querySelectorAll('.open-booster-btn');
	const modal = document.getElementById('booster-modal');
	const modalCards = document.getElementById('booster-cards-container');
	const closeBtn = document.getElementById('close-modal-btn');

	buttons.forEach(button => {
		button.addEventListener('click', async () => {
			const boosterId = button.dataset.id;
			const wrapper = button.closest('.booster-wrapper');

			button.disabled = true;
			button.textContent = "Ouverture...";

			try {
				const response = await fetch(`/api/booster/open/${boosterId}`, {
					method: 'POST',
					headers: {
						'X-Requested-With': 'XMLHttpRequest'
					}
				});

				const data = await response.json();

				if (data.success) {
					modalCards.innerHTML = data.html;
					modal.classList.remove('hidden');
					wrapper.remove();
				} else {
					alert(data.error || "Erreur inconnue.");
					button.disabled = false;
					button.textContent = "Ouvrir ce booster";
				}
			} catch (err) {
				console.error(err);
				alert("Erreur de connexion.");
				button.disabled = false;
				button.textContent = "Ouvrir ce booster";
			}
		});
	});

	closeBtn.addEventListener('click', () => {
		document.getElementById('booster-modal').classList.add('hidden');
	});
});
