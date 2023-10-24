function showAlert(value) {
    if (Array.isArray(value)) {
        document.getElementById("success-header").innerText =
            value[0];
        document.getElementById("success-message").innerText =
            value[1];

        $("#success-alert")
            .fadeTo(2000, 500)
            .slideUp(500, function () {
                $("#success-alert").slideUp(500);
            });
    } else {
        document.getElementById("error-message").innerText =
            value.responseText;
        document.getElementById("error-header").innerText =
            capitalize(value.statusText);
        $("#error-alert")
            .fadeTo(2000, 500)
            .slideUp(500, function () {
                $("#error-alert").slideUp(500);
            });
    }
}

function capitalize(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
}

function CustomerHeader() {
    fetch('customerheader.html')
        .then(response => response.text())
        .then(data => {
            document.body.insertAdjacentHTML('afterbegin', data);
        })
        .catch(error => console.error(error));
}

function ManagerHeader() {
    fetch('managerheader.html')
        .then(response => response.text())
        .then(data => {
            document.body.insertAdjacentHTML('afterbegin', data);
        })
        .catch(error => console.error(error));
}


function Alert() {
    fetch('alert.html')
        .then(response => response.text())
        .then(data => {
            document.body.insertAdjacentHTML('afterbegin', data);
            $("#success-alert").hide();
            $("#error-alert").hide();
        })
        .catch(error => console.error(error));
}
