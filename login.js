document.getElementById("submit").addEventListener("click", function(event) {
    var password = document.getElementById("password").value;
    if (password !== "yourCorrectPassword") { // Change "yourCorrectPassword" to the correct password
        document.getElementById("password-error").innerHTML = "Incorrect password";
        event.preventDefault(); // Prevent form submission
    }
});