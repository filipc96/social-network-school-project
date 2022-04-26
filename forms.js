//Kod za prelazak sa forme za registraciju na login formu i obrnuto
document.addEventListener('DOMContentLoaded',()=>{

    const loginForm = document.querySelector('#login');
    const createForm = document.querySelector('#create');

    document.querySelector('#linkCreateAccount').addEventListener('click',(e)=>{
        e.preventDefault();
        
        loginForm.classList.add('form__hidden');
        createForm.classList.remove('form__hidden');
    })
    
    document.querySelector('#linkLogIn').addEventListener('click',(e)=>{
        e.preventDefault();

        createForm.classList.add('form__hidden');
        loginForm.classList.remove('form__hidden');
    })

})

//Sprecava popout kada rifresujemo stranicu
if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
    }