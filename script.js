
// MENU
const icone = document.querySelector('i');
const modal = document.querySelector('.modal');
const overlay = document.querySelector('.overlay');

icone.addEventListener('click', function() {
    console.log('cliquey')
    modal.classList.toggle('change-modal');
    overlay.classList.toggle('show-overlay'); // Toggle the overlay
    icone.classList.toggle('fa-xmark');
});


document.addEventListener('DOMContentLoaded', function () {
    const willElement = document.querySelector('.will');
    const popupElement = document.getElementById('popup');

    willElement.addEventListener('click', function () {
        popupElement.style.display = 'block';
    });
});

function closePopup() {
    const popupElement = document.getElementById('popup');
    popupElement.style.display = 'none';
}