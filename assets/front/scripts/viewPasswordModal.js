// Je récupère le champ qui a l'id "password"
let inputPassword = document.getElementById('viewPassword');
// Je récupère le bouton qui a l'id "viewPassword"
let btnViewPassword = inputPassword.nextElementSibling;

// Au clic sur le bouton le password s'affiche ou se cache
btnViewPassword.addEventListener('click', function(e) {
    e.preventDefault();
    if (inputPassword.type === 'password') {
        inputPassword.type = 'text';

    } else {
        inputPassword.type = 'password';
    };
});

// Blocage du btn input mail
let btnMailModal = document.querySelector('.mail-form .submit .search-user');

btnMailModal.addEventListener('click', function(e) {
    e.preventDefault();
});


