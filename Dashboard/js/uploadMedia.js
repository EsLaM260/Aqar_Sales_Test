  // upload image
  export function handleFiles(files) {
    let modifiableFiles = []; // This will hold your modifiable array of files
    // Initialize the modifiableFiles array with the selected files
    modifiableFiles = Array.from(files); // Now you have an array you can modify
    // Get the container where images will be displayed
    const imageContainer = document.getElementById("imageContainer");
    // Clear any previously displayed images
    imageContainer.innerHTML = "";
    // Iterate over each selected file
    modifiableFiles.forEach((file, index) => {
      // Note: we're also passing the index
      // Create a new FileReader
      const reader = new FileReader();
      // Set up the onload event handler
      reader.onload = function (event) {
        // Create the wrapper, image, and delete button elements
        const imgWrapper = document.createElement("div");
        imgWrapper.classList.add("image-wrapper");
        const img = document.createElement("img");
        img.src = event.target.result;
        img.alt = "Product-Image";
        const deleteBtn = document.createElement("button");
        deleteBtn.innerText = "X";
        deleteBtn.classList.add("delete-btn");
        deleteBtn.onclick = function () {
          // Remove the image wrapper
          imgWrapper.remove();
          // Also remove the file from the modifiableFiles array
          modifiableFiles.splice(index, 1); // This removes the file from the array
        };

        // Append the elements
        imgWrapper.appendChild(img);
        imgWrapper.appendChild(deleteBtn);
        imageContainer.appendChild(imgWrapper);
      };
      // Read the file as a data URL
      reader.readAsDataURL(file);
    });
  }
