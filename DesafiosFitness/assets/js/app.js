document.addEventListener("DOMContentLoaded", () => {
    // Aplicar efecto de entrada a todas las tarjetas
    const cards = document.querySelectorAll('.card');
    cards.forEach(card => {
        card.classList.add('fade-in');
    });

    // Cambio de tema en tiempo real (si existe el botón o select en preferencias)
    const temaSelect = document.querySelector('select[name="tema"]');
    if (temaSelect) {
        temaSelect.addEventListener('change', () => {
            const value = temaSelect.value;
            document.body.style.backgroundColor = value === 'oscuro' ? '#121212' : '#f3e5f5';
            document.body.style.color = value === 'oscuro' ? '#fff' : '#333';
        });
    }
});
// Ejemplo de animación simple para botones
document.addEventListener('DOMContentLoaded', () => {
  const buttons = document.querySelectorAll('button, input[type="submit"]');
  buttons.forEach(btn => {
    btn.addEventListener('mouseenter', () => {
      btn.style.transform = 'scale(1.05)';
    });
    btn.addEventListener('mouseleave', () => {
      btn.style.transform = 'scale(1)';
    });
  });
});
