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
  location.href.includes("/addProperty.php") ||
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
  location.href.includes("/website-data.php") ||
  location.href.includes("/addConstruction.php")
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





// // Firebase auth
// // import {initializeApp  } from "firebase/app";
// // import {RecaptchaVerifier,getAuth ,PhoneAuthProvider,signInWithPhoneNumber} from "firebase/auth";
// import { initializeApp } from "https://www.gstatic.com/firebasejs/10.8.0/firebase-app.js";
// import {
//   RecaptchaVerifier,
//   getAuth,
//   PhoneAuthProvider,
//   signInWithPhoneNumber
// } from "https://www.gstatic.com/firebasejs/10.8.0/firebase-auth.js";
// // import { error } from "console";

// // import { error } from "console";
// // For Firebase JS SDK v7.20.0 and later, measurementId is optional
// const firebaseConfig = {
//   apiKey: "AIzaSyBJ7w1DjWhIgpzYuSPPytZtT1C3UlGq-Bo",
//   authDomain: "aqar-sales.firebaseapp.com",
//   databaseURL: "https://aqar-sales-default-rtdb.firebaseio.com",
//   projectId: "aqar-sales",
//   storageBucket: "aqar-sales.appspot.com",
//   messagingSenderId: "220367685767",
//   appId: "1:220367685767:web:9acb4e2f4ee70335885022",
//   measurementId: "G-P24TV4XJZJ",
// };

// // Initialize Firebase
// const app = initializeApp(firebaseConfig);
// const auth = getAuth(app);

// // Get references to UI elements
// const countrySelect = document.getElementById("countrySelect");
// const phoneInput = document.getElementById("phoneInput");
// const continueBtn = document.getElementById("continueBtn");
// const pinView = document.getElementById("pinView");
// const otpButton = document.getElementById("otpButton");

// let verificationId;
// let recaptchaVerifier;

// // Function to show OTP input
// function showOtpInput() {
//   phoneInput.style.display = "none";
//   countrySelect.style.display = "none";
//   continueBtn.style.display = "none";
//   pinView.style.display = "block";
//   otpButton.style.display = "block";
// }


// // continueBtn.addEventListener("click", (e) => {
// //   e.preventDefault();
// //   const countryCode = countrySelect.value;
// //   const phoneNumber = phoneInput.value;
// //   const fullPhoneNumber = `+${countryCode}${phoneNumber}`;


// //   window.recaptchaVerifier = new RecaptchaVerifier(auth, 'recaptcha-container', {
// //     'size': 'normal',
// //     'callback': (response) => {
// //       // reCAPTCHA solved, allow signInWithPhoneNumber.
// //       // ...
// //     },
// //     'expired-callback': () => {
// //       // Response expired. Ask user to solve reCAPTCHA again.
// //       // ...
// //     }
// //   });



// // })



// continueBtn.addEventListener("click", (e) => {
//   e.preventDefault();
//   const countryCode = countrySelect.value;
//   const phoneNumber = phoneInput.value;
//   const fullPhoneNumber = `+${countryCode}${phoneNumber}`;

//   recaptchaVerifier = new RecaptchaVerifier("phoneDiv", {
//     size: "invisible",
//     "expired-callback": () => {
//       console.error("reCAPTCHA token expired");
//       // Handle expired reCAPTCHA token
//     },
//   });

//   const phoneProvider = new PhoneAuthProvider(auth);

//   phoneProvider.verifyPhoneNumber(
//     fullPhoneNumber,
//     recaptchaVerifier,
//     (verificationIdFromFirebase) => {
//       verificationId = verificationIdFromFirebase;
//       showOtpInput();
//     },
//     (error) => {
//       console.error(error);
//     }
//   );

//   // const phoneProvider = new PhoneAuthProvider(getAuth());

//   // phoneProvider.verifyPhoneNumber(
//   //   fullPhoneNumber,
//   //   recaptchaVerifier,
//   //   new RecaptchaVerifier("phoneDiv"),
//   //   (verificationIdFromFirebase) => {
//   //     verificationId = verificationIdFromFirebase;
//   //     showOtpInput();
//   //   },
//   //   (error) => {
//   //     console.log(error);
//   //   }
//   // );
// });


// otpButton.addEventListener("click", () => {
//   const code = pinView.value;
//   const credential = PhoneAuthProvider.credential(verificationId, code);
//   signInWithCredential(auth, credential)
//     .then((userCredential) => {
//       // Signed in successfully
//       const user = userCredential.user;
//       console.log("Signed in as: ", user.uid);
//       // Redirect to main page or perform necessary action
//     })
//     .catch((error) => {
//       console.error(error);
//       // Handle sign-in failure
//     });
// });