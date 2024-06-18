document.addEventListener("DOMContentLoaded", function() {
    document.querySelector(".favorite-btn").addEventListener("click", function() {
        const albumId = this.getAttribute("data-album-id");
        fetch("add_to_favorites.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ album_id: albumId })
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
        })
        .catch(error => console.error('Error:', error));
    });
});
