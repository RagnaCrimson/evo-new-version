// login
function login() {
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "login.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    window.location.href = response.redirectUrl;
                } else {
                    document.getElementById("error").innerText = "Invalid username or password.";
                }
            } else {
                console.error("Error occurred: " + xhr.status);
            }
        }
    };

    var data = "username=" + username + "&password=" + password;
    xhr.send(data);
}

// logout
function confirmLogout() {
    var confirmed = confirm("ต้องการออกจากระบบหรือไม่?");
    if (confirmed) {
        window.location.href = "logout.php";
    }
}

// Function to show success message popup
function showSuccessPopup() {
    alert('Data inserted successfully.');
}