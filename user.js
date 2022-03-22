var form = document.getElementById('form');
var error = document.getElementById('error');

form.addEventListener('submit', function (e) {
    e.preventDefault()

    var email = document.getElementById('email').value
    var pwd = document.getElementById('pwd').value

    console.log(email);
    console.log(pwd);

    fetch('http://localhost:3000/idk.php', {
        method: 'POST',
        body: JSON.stringify({
            email:email,
            pwd:pwd
        }),
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
    })
    .then(function (response) {
        return response.json()
    })
    .then(function (data) {
        console.log(data)

        if (data == "Vous devez rentrer un mot de passe" || data == "L'adresse entrée n'est pas bonne") {
            error.innerHTML = data
            error.style.color = "red";
        }else{
            error.innerHTML = data
            error.style.color = "green";
        }
    })

})