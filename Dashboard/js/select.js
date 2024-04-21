export function selectDetails() {
  // select logic
  // Query all .select-box elements
  var selectBoxes = document.querySelectorAll(".select-box");
  // Iterate over each select box to add event listeners
  selectBoxes.forEach(function (select) {
    // This function toggles the visibility of the select items
    var toggleSelectItems = function () {
      // بتحدد الي انت دوست عليها ف الي جواها
      var selectItems = select.querySelector(".select-items");
      selectItems.classList.toggle("select-hide");
    };
    // Add click event listener to the current select box
    select.addEventListener("click", function (event) {
      // Prevents the click from immediately closing the dropdown
      event.stopPropagation();
      toggleSelectItems();
    });

    // Add click event listener to each option within the select box
    select.querySelectorAll(".select-items div").forEach(function (item) {
      item.addEventListener("click", function () {
        // Set the text of the select-selected to the text of the clicked item
        var selectedText = select.querySelector(".select-selected");
        // this ref for select-items div on click
        selectedText.textContent = this.textContent;
        toggleSelectItems();
        // Remove the 'selected-item' class from previously selected item, if any
        var previouslySelected = select.querySelector(".selected-item");
        if (previouslySelected) {
          previouslySelected.classList.remove("selected-item");
        }
        // Add 'selected-item' class to the newly selected item
        this.classList.add("selected-item");
        // Close the dropdown after selection
        toggleSelectItems();
      });
    });
  });
  // Close the dropdown if the user clicks outside of it
  // This listener is attached to the window to capture all clicks
  window.addEventListener("click", function () {
    // Query all .select-items elements
    var allSelectItems = document.querySelectorAll(".select-items");
    allSelectItems.forEach(function (selectItems) {
      // Add the 'select-hide' class to close the dropdown
      selectItems.classList.add("select-hide");
    });
  });
}
