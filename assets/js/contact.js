document.querySelector('.contact-form').addEventListener('submit', function (e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);

    fetch(form.action, {
        method: 'POST',
        body: formData
    })
    .then(res => res.text())
    .then(data => {
        document.querySelector('.form-messages').innerHTML = data;
    })
    .catch(error => {
        document.querySelector('.form-messages').innerHTML = '<div class="form-messages error">An error occurred. Please try again.</div>';
    });
});
