var offset = 0;
var limit = 10;
var orderBy = 'id'; // Example: Replace with the column you want to sort by
var orderDirection = 'DESC'; // Example: Can be 'ASC' or 'DESC'
var loading = false;
var contentDiv = document.getElementById('content');
var loadingDiv = document.getElementById('loading');
var loggedUser = document.getElementById('LoggedUser').value

async function fetchData() {
    if (loading) return;
    loading = true;
    loadingDiv.style.display = 'block';

    try {
        const response = await fetch(`./lib/forum/controllers/my-posts.php?offset=${offset}&limit=${limit}&orderBy=${orderBy}&orderDirection=${orderDirection}&loggedUser=${loggedUser}`);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        const data = await response.json();
        renderData(data);
        offset += limit;
    } catch (error) {
        console.error('Error fetching data:', error);
    }

    loading = false;
    loadingDiv.style.display = 'none';
}

function renderData(data) {
    data.forEach(item => {
        const div = document.createElement('div');
        div.innerHTML = item;
        contentDiv.appendChild(div);
    });
}

window.addEventListener('scroll', () => {
    if (window.innerHeight + window.scrollY >= document.body.offsetHeight) {
        fetchData();
    }
});

// Initial fetch
fetchData();