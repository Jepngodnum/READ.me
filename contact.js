document.getElementById("contactForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent default form submission

    // Get form data
    var formData = new FormData(this);

    // You can perform validation here before sending the data

    // Simulate sending the form data to a server (this is just a placeholder)
    setTimeout(function() {
        document.getElementById("responseMessage").innerHTML = "Your message has been sent successfully!";
    }, 1000);
});

