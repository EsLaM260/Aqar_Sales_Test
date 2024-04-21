import { showIcon } from "./loginpage.js";
import { chooseYourLocation, displayYourLocation } from "./map.js";
import { selectDetails } from "./select.js";
import { sidebarDetails } from "./sidebar.js";
import { handleFiles } from "./uploadMedia.js";
import { displayAllProduct } from "./displayProduct.js";
import { checkId } from "./verifyId.js";
// Start Login page
if (location.href.includes("/login.php")) {
  showIcon();
}
// End Login page
if (
  !location.href.includes("/login.php") &&
  !location.href.includes("/changepassword.php")
) {
  sidebarDetails();
  console.log("true");
}
// Start dashboard page

// End dashboard page
// Start page add Data
if (
  location.href.includes("/addProperty.php") ||
  location.href.includes("/website-data.php") ||
  location.href.includes("/addConstruction.php")
) {
  selectDetails();
  let uploadImage = document.getElementById("fileInput");
  uploadImage.addEventListener("change", (e) => {
    handleFiles(e.target.files);
  });
}
if (
  location.href.includes("/addProperty.php") ||
  location.href.includes("/addConstruction.php")
) {
  chooseYourLocation();
}
// End page add Data
// Start Show Page
if (
  location.href.includes("/showProperty.php") ||
  // location.href.includes("/clients.php") ||
  location.href.includes("/showConstruction.php")
) {
  // the function have a function pramiter
  // the parmiter function have a click to show the id client and edit it
  displayAllProduct(checkId);
}
// End Show Page
// Start Details property page
if (
  location.href.includes("/detailsProperty.php") ||
  location.href.includes("/detailsConstruction.php")
) {
  displayYourLocation();
}
// End Details property page
