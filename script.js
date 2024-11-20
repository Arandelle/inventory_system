function AddItem() {
    const modal = document.getElementById("modal");
    modal.classList.toggle("hidden");
}   

function reloadTable() {
    fetch('tableBody.php')
        .then(response => response.text())
        .then(data => {
            document.getElementById('table-container').innerHTML = data;
        })
        .catch(error => console.error('Error fetching table:', error));
}
