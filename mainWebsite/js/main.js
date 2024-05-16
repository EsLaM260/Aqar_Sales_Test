// Start Header
// let header = document.querySelector("header");
// let headerMenu = document.querySelector("header .responsiveMenu");
// let ulList = document.querySelector("header ul");
// let banner = document.querySelector(".banner");
// headerMenu.addEventListener("click", () => {
//   ulList.classList.toggle("active");
//   banner.classList.toggle("openlist");
// })

// window.addEventListener("scroll", () => {
//   if (scrollY >= 150) {
//     header.classList.add("active");
//   } else {
//     header.classList.remove("active");
//   }
// })

// End Header

// Start Banner

// End Banner

import { chooseYourLocation, displayYourLocation } from "./map.js";
import { selectDetails } from "./select.js";
import { handleFiles } from "./uploadMedia.js";
import { displayAllProduct } from "./displayProduct.js";
import { checkId } from "./verifyId.js";

// Start page add Data
if (
  location.href.includes("/addproperty.php") ||
  location.href.includes("/addProperty.php") ||
  location.href.includes("/addconstruction.php")||
  location.href.includes("/addConstruction.php")
) {
  chooseYourLocation();
  let uploadVideo = document.getElementById("fileInputVideo");
  uploadVideo.addEventListener("change", (e) => {
    handleFiles(e.target.files, "video");
  });
}
if (
  location.href.includes("/addProperty.php") ||
  location.href.includes("/addproperty.php") ||
  location.href.includes("/website-data.php") ||
  location.href.includes("/addConstruction.php")||
  location.href.includes("/addconstruction.php")
) {
  selectDetails();
  let uploadImage = document.getElementById("fileInput");
  uploadImage.addEventListener("change", (e) => {
    handleFiles(e.target.files, "image");
  });
}
// End page add Data
// Start Show Page
if (
  location.href.includes("/showProperty.php") ||
  location.href.includes("/showproperty.php") ||
  // location.href.includes("/clients.php") ||
  location.href.includes("/showConstruction.php")||
  location.href.includes("/showconstruction.php")
) {
  // the function have a function pramiter
  // the parmiter function have a click to show the id client and edit it
  displayAllProduct(checkId);
}
// End Show Page
// Start Details property page
if (
  location.href.includes("/detailsProperty.php") ||
  location.href.includes("/detailsproperty.php") ||
  location.href.includes("/detailsConstruction.php")||
  location.href.includes("/detailsconstruction.php")
) {
  displayYourLocation();
}
// End Details property page

