const deleteForms = document.querySelectorAll('.delete-form');
const restoreForms = document.querySelectorAll('.restore-form');
const modal = document.getElementById('modal');
const modalBody = document.querySelector('.modal-body');
const modalTitle = document.querySelector('.modal-title');
const confirmationButton = document.getElementById('modal-confirmation-button');

let activeForm = null;

deleteForms.forEach(form => {
    form.addEventListener('submit', e => {
        e.preventDefault();

        activeForm = form;

        confirmationButton.innerText = 'Conferma Elimina';
        confirmationButton.className = 'btn btn-danger';
        modalTitle.innerText = 'Elimina parola';
        modalBody.innerText = 'Sei sicuro di voler procedere all\'eliminazione?';
    })
})

restoreForms.forEach(form => {
    form.addEventListener('submit', e => {
        e.preventDefault();

        activeForm = form;

        confirmationButton.innerText = 'Conferma Ripristina';
        confirmationButton.className = 'btn btn-success';
        modalTitle.innerText = 'Ripristina parola';
        modalBody.innerText = 'Sei sicuro di voler procedere al ripristino della parola?';
    })
})

confirmationButton.addEventListener('click', () => {
    if (activeForm) activeForm.submit();
});

modal.addEventListener('hidden.bs.modal', () => {
    activeForm = null;
})