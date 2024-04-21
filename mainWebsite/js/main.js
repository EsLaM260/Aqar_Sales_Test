// Start Header
let header = document.querySelector("header");
let headerMenu = document.querySelector("header .responsiveMenu");
let ulList = document.querySelector("header ul");
let banner = document.querySelector(".banner");
headerMenu.addEventListener("click", () => {
  ulList.classList.toggle("active");
  banner.classList.toggle("openlist");
})

window.addEventListener("scroll", () => {
  if (scrollY >= 150) {
    header.classList.add("active");
  } else {
    header.classList.remove("active");
  }
})

// End Header

// Start Banner

// End Banner