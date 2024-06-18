document.addEventListener("DOMContentLoaded", function() {
    fetch('profile.php')
        .then(response => response.json())
        .then(data => {
            if (data) {
                document.querySelector('input[name="username"]').value = data.username || '';
                document.querySelector('input[name="name"]').value = data.name || '';
                document.querySelector('input[name="email"]').value = data.email || '';
                document.querySelector('input[name="phone"]').value = data.phone || '';
                document.querySelector('input[name="age"]').value = data.age || '';
                document.querySelector('.profile-img img').src = data.avatar || 'starboy.jpg';
                
                // Display favorites
                const favoritesList = document.querySelector('.profile-work .favorites-list');
                data.favorites.forEach(favorite => {
                    const listItem = document.createElement('a');
                    listItem.href = favorite.link;
                    listItem.textContent = favorite.title;
                    favoritesList.appendChild(listItem);
                    favoritesList.appendChild(document.createElement('br'));
                });
            }
        })
        .catch(error => console.error('Error:', error));
    
    document.querySelector(".profile-edit-btn").addEventListener("click", function() {
        var formData = new FormData(document.querySelector("form"));
        fetch("profile.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            if (data.status === 'success') {
                setTimeout(function() {
                    window.location.href = "profile.html";
                }, 3000);
            }
        })
        .catch(error => console.error('Error:', error));
    });

    document.querySelector('input[name="avatar"]').addEventListener('change', function(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.querySelector('.profile-img img');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    });
});
