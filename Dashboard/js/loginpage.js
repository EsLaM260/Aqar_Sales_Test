// Start Login Page
export function showIcon() {
  let showHideBtn = document.querySelectorAll(".icon-display");
  showHideBtn.forEach((btn) => {
    btn.addEventListener("click", () => {
      let getInput = btn.parentElement.querySelector("input");
      if (getInput.type == "password") {
        getInput.type = "text";
        btn.classList.replace("mdi-eye-off-outline", "mdi-eye-outline");
      } else {
        getInput.type = "password";
        btn.classList.replace("mdi-eye-outline", "mdi-eye-off-outline");
      }
    });
  })
}
// End Login Page