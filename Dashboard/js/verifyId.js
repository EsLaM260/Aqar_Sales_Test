export function checkId() {
  let openId = document.querySelectorAll(
    " .showPage .client-data .btn.open-id"
  );
  openId.forEach((item, id) => {
    let imageContainer = document.querySelectorAll(".id-container")[id];
    let closeBtn = imageContainer.querySelector("span");
    item.addEventListener("click", () => {
      imageContainer.classList.add("active");
    });
    closeBtn.addEventListener("click", () => {
      imageContainer.classList.remove("active");
    });
  });
}
