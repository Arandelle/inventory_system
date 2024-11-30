function ShowModal(mode, item) {
  if (mode === "add") {
    const modal = document.getElementById("addModal");
    modal.classList.toggle("hidden");
  } else if (mode === "edit") {
    const editModal = document.getElementById("editModal");
    const editForm = editModal.querySelector(".edit-form");

    // Populate form fields
    editForm.querySelector('input[name="id"').value = item.ID;
    editForm.querySelector('input[name="name"]').value = item.Name;
    editForm.querySelector('input[name="cost"]').value = item.Cost;
    editForm.querySelector('select[name="category"]').value = item.Category;
    editForm.querySelector('input[name="date"]').value = item.ConsumptionDate;
    editForm.querySelector('input[name="quan"]').value = item.Quantity;

    editModal.classList.toggle("hidden");
  }
}

document.addEventListener("DOMContentLoaded", (e) => {
 document.querySelectorAll('input[type="text"]').forEach((input) => {
    input.addEventListener("blur", function (){
        this.value = this.value.replace(/\b\w/g, function (char){
            return char.toUpperCase();
        })
    })
 })
});

function reloadTable() {
  fetch("tableBody.php")
    .then((response) => response.text())
    .then((data) => {
      document.getElementById("table-container").innerHTML = data;
    })
    .catch((error) => console.error("Error fetching table:", error));
}
