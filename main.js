// Define custom elements
class Topnav extends HTMLElement {
  constructor() {
    super();
  }

  connectedCallback() {
    this.innerHTML = `
    <div class="topnav">
      <a class="logo" href="#logo" onclick="logo()"><img src="wd.png" alt="Logo" style="width: 113px; height: auto;"></a>
        <div class="topnav-right">
          <a id="logout" href="#logout" onclick="logout()">Logout</a>
          <a id="profile" href="#profile" onclick="profile()">Profile</a>
          <a id="contact" href="#contact" onclick="contact()">Contact</a>
          <a id="albums" href="#albums" onclick="album()">Albums</a>          
          <a id="home" href="#home" onclick="home()">Home</a>
        </div>
    </div>
    `;
  }
}
customElements.define('topnav-component', Topnav);

class Footer extends HTMLElement {
  constructor() {
    super();
  }

  connectedCallback() {
    this.innerHTML = `
    <div class="footer">
      <footer>
        <p id="p">
        #09057322809<br>
        weekdays135@gmail.com<br>
        Disclaimer: This website is for project purposes only!
        </p>
      </footer>
    </div>  
    `;
  }
}
customElements.define('footer-component', Footer);

// Favorite albums functionality
let favoriteAlbums = [];

function handleFavoriteButtonClick(event) {
    const albumId = event.target.getAttribute('data-album-id');
    if (!favoriteAlbums.includes(albumId)) {
        favoriteAlbums.push(albumId);
        updateFavoriteAlbumsDisplay();
        saveFavoritesToLocalStorage();
    }
}

function updateFavoriteAlbumsDisplay() {
    const favoritesContainer = document.getElementById('favoritesContainer');
    favoritesContainer.innerHTML = '';

    favoriteAlbums.forEach(albumId => {
        const albumCard = document.querySelector(`.album-card[data-album-id='${albumId}']`);
        const clone = albumCard.cloneNode(true);
        favoritesContainer.appendChild(clone);
    });
}

function saveFavoritesToLocalStorage() {
    localStorage.setItem('favoriteAlbums', JSON.stringify(favoriteAlbums));
}

function loadFavoritesFromLocalStorage() {
    const storedFavorites = localStorage.getItem('favoriteAlbums');
    if (storedFavorites) {
        favoriteAlbums = JSON.parse(storedFavorites);
        updateFavoriteAlbumsDisplay();
    }
}

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.favorite-btn').forEach(button => {
        button.addEventListener('click', handleFavoriteButtonClick);
    });
    loadFavoritesFromLocalStorage();
});

// Navigation functions
function logo() {
  location.replace("home.html")
}

function contact() {
  location.replace("contact.html")
}

function profile() {
  location.replace("profile.html")
}

function home() {
  location.replace("home.html")
}

function album() {
  location.replace("main.html")
}

function logout() {
  location.replace("login.html")
}

// Albums functions
function starboy() {
  location.replace("starboy.html")
}

function after() {
  location.replace("after.html")
}

function dawn() {
  location.replace("dawn.html")
}

function bbtm() {
  location.replace("bbtm.html")
}

function mdm() {
  location.replace("mdm.html")
}

function kiss() {
  location.replace("kiss.html")
}
