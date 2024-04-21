export function sidebarDetails() {
  // Start sub-menu sidebar
  // open and close list
  let mainListBtn = document.querySelectorAll("aside .sidebar-submenu > a");
  let mainListItem = document.querySelectorAll("aside .sidebar-submenu-item");
  mainListBtn.forEach((one, id) => {
    one.addEventListener("click", (e) => {
      e.preventDefault();
      mainListItem[id].classList.toggle("active");
    });
  });
  // rotate item
  let mainList = document.querySelectorAll("aside .sidebar-submenu");
  mainList.forEach((ele) => {
    ele.addEventListener("click", () => {
      ele.classList.toggle("active");
    });
  });
  // open and close sidebar
  let openBtn = document.querySelector("main header .first .tab span");
  let sidebar = document.querySelector("aside");
  let mainContent = document.querySelector("main");
  if (!location.href.includes("/login.php")) {
    openBtn.addEventListener("click", () => {
      sidebar.classList.toggle("active");
      mainContent.classList.toggle("active");
    });
  }
  // End sub-menu sidebar
}
