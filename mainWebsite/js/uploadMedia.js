
export function handleFiles(files, expectedType) {
  const imageContainer = document.getElementById("imageContainer");
  const videoContainer = document.getElementById("videoContainer");

  Array.from(files).forEach((file) => {
    const fileType = file.type.split("/")[0]; // Get the file type (image or video)
    // Validation check
    if (expectedType === "image" && fileType !== "image") {
      alert("يرجى تحميل الصور فقط في المكان المخصص لها");
      return;
    } else if (expectedType === "video" && fileType !== "video") {
      alert("يرجى تحميل مقاطع الفيديو فقط في المكان المخصص لها");
      return;
    }

    if (fileType === "image") {
      const reader = new FileReader();
      // Clear any previous content
      imageContainer.innerHTML = "";
      reader.onload = function (event) {
        const imgWrapper = document.createElement("div");
        imgWrapper.classList.add("image-wrapper");
        const img = document.createElement("img");
        img.src = event.target.result;
        img.alt = "Product Image";
        imgWrapper.appendChild(img);
        imageContainer.appendChild(imgWrapper);
      };
      reader.readAsDataURL(file);
    } else if (fileType === "video") {
      const reader = new FileReader();
      // Clear any previous content
      videoContainer.innerHTML = "";
      reader.onload = function (event) {
        const videoWrapper = document.createElement("div");
        videoWrapper.classList.add("video-wrapper");
        const video = document.createElement("video");
        video.src = event.target.result;
        video.controls = true;
        videoWrapper.appendChild(video);
        videoContainer.appendChild(videoWrapper);
      };
      reader.readAsDataURL(file);
    }
  });
}
