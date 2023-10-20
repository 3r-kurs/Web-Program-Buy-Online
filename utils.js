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

function Header() {
    fetch('header.html')
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

function replacer(key, value) {
    if (value instanceof Map) {
        return {
            dataType: 'Map',
            value: Array.from(value.entries()),
        };
    } else {
        return value;
    }
}
function reviver(key, value) {
    if (typeof value === 'object' && value !== null) {
        if (value.dataType === 'Map') {
            return new Map(value.value);
        }
    }
    return value;
}