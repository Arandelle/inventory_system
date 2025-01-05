function ShowModal(mode, item) {
  if (mode === "add") {
    const modal = document.getElementById("addModal");
    modal.classList.toggle("hidden");
  } else if (mode === "edit") {
    try {
      console.log("Item passed to ShowModal:", item);
      const editModal = document.getElementById("editModal");
      const editForm = editModal.querySelector(".edit-form");

      // Check if we have the form and required fields
      if (!editForm) {
        throw new Error("Edit form not found");
      }

      // Populate form fields with null checks
      const fields = ['id', 'title', 'price', 'category', 'quantity'];
      fields.forEach(field => {
        const input = editForm.querySelector(`[name="${field}"]`);
        if (input && item[field] !== undefined) {
          input.value = item[field];
        }
      });

      editModal.classList.toggle("hidden");
    } catch (error) {
      console.error("Error showing edit modal:", error);
      alert("There was an error loading the edit form. Please try again.");
    }
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
