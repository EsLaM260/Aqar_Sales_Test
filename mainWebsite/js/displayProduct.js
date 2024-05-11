export function displayAllProduct(users , callback) {
  fetch("json/productData.json")
    .then((response) => response.json())
    .then((data) => {
      let allProductList = document.querySelector(".allproduct-list .row");
      let currentNumber = document.querySelector(
        ".allproduct-list .number-page"
      );
      const prevBtn = document.querySelector(".prev-btn");
      const nextBtn = document.querySelector(".next-btn");
      let products;
      // check any page open
      if (location.href.includes("/showProperty.php")) {
        products = data.products;
      } else if (location.href.includes("/showConstruction.php")) {
        products = data.construction;
      } else if (location.href.includes("/clients.php")) {
        products = data.user;
        // products = users;
      }
      console.log(products);
      let currentPage = 1;
      const itemsPerPage = 9;
      const loadingTime = 200;




      function displayProducts() {
        allProductList.innerHTML = `
        <div class="container-loading">
        <div class="loader"></div>
      </div>
        `;
        setTimeout(() => {
          const start = (currentPage - 1) * itemsPerPage;
          const end = start + itemsPerPage;
          const productToShow = products.slice(start, end);
          allProductList.innerHTML = "";
          currentNumber.innerHTML = currentPage;
          productToShow.map((product) => {
            // select the page and show his data
            if (location.href.includes("/showProperty.php")) {
              allProductList.innerHTML += `
              <div class="col-lg-4 col-md-6 col-sm-12">
              <div class="box">
                <div class="product-image">
                  <img src="${product["productimage"]}" alt="" />
                </div>
                <div class="product-details">
                  <p>${product["title"]}</p>
                  <h2>$ <span>${product["price"]}</span></h2>
                  <ul>
                    <li>
                      <span class="mdi mdi-bed-empty icon"></span>
                      <span class="number">${product["numberOfBeds"]}</span>
                      Beds
                    </li>
                    <li>
                      <span class="mdi mdi-shower  icon"></span>
                      <span class="number">${product["numberOfBaths"]}</span>
                      Bath
                    </li>
                    <li>
                      <span class="mdi mdi-fullscreen  icon"></span>
                      <span class="number">${product["space"]}</span>
                      m
                    </li>
                  </ul>
                  <p>${product["description"]}</p>
                </div>
                <div class="product-ref">
                  <div class="client-details">
                    <img src="${product["image-user"]}" alt="">
                    <span>${product["UserName"]}</span>
                  </div>
                  <a href="detailsProperty.php">Details</a>
                </div>
              </div>
            </div>`;
            } else if (location.href.includes("/showConstruction.php")) {
              allProductList.innerHTML += `
              <div class="col-lg-4 col-md-6 col-sm-12">
              <div class="box">
                <div class="product-image">
                  <img src="${product["constructionImage"]}" alt="" />
                </div>
                <div class="product-details">
                  <p class="main-title">${product["title"]}</p>
                  <p>${product["description"]}</p>
                </div>
                <div class="product-ref">
                  <div class="client-details">
                    <img src="${product["image-user"]}" alt="">
                    <span>${product["UserName"]}</span>
                  </div>
                  <a href="detailsConstruction.php">Details</a>
                </div>
              </div>
            </div>`;
            } else if (location.href.includes("/clients.php")) {
              allProductList.innerHTML += `
              <div class="col-lg-4 col-md-4 col-sm-12">
              <div class="client-data">
                <div class="main">
                  <div class="image">
                    <img src="${product["userImage"]}" alt="profiles">
                  </div>
                  <h3>${product["name"]}</h3>
                </div>
                <div class="other">
                  <p>
                    البريد الالكتروني : <span>${product["email"]}</span>
                  </p>
                  <p>
                    الهاتف : <span>${product["phone"]}</span>
                  </p>
                  <p>
                    العنوان : <span>${product["address"]}</span>
                  </p>
                  <p>
                    تاريخ الميلاد : <span>${product["barth-of-date"]}</span>
                  </p>
                </div>
                <div class="btn open-id" data-id="${product["id"]}" >تحقق من الهويه</div>
                <div class="id-container">
                  <div class="img">
                    <span class="close-image-id"><i class="fa-solid fa-xmark"></i></span>
                    <img src="image/background01.jpg" alt="ID Image">
                    <button data-id="${product["id"]}">هويه صحيحه</button>
                  </div>
                </div>
              </div>
            </div>`;
            }
          });
          // Call the callback function if provided
          if (callback && typeof callback === "function") {
            callback();
          }
          scrollToProductList();
          checkBtn();

        }, loadingTime);
      }

      const scrollToProductList = () => {
        document.body.scrollTop = document.documentElement.scrollTop = 0;
      };
      function checkBtn() {
        prevBtn.disabled = currentPage == 1;
        nextBtn.disabled = currentPage * itemsPerPage >= products.length;
      }
      prevBtn.addEventListener("click", () => {
        allProductList.innerHTML = "";
        currentPage--;
        displayProducts();
      });
      nextBtn.addEventListener("click", () => {
        allProductList.innerHTML = "";
        currentPage++;
        displayProducts();
      });
      // Initialize
      displayProducts();
    });
}

// test
// export function displayAllProduct(users , callback) {
//   fetch("json/productData.json")
//     .then((response) => response.json())
//     .then((data) => {
//       let allProductList = document.querySelector(".allproduct-list .row");
//       let currentNumber = document.querySelector(
//         ".allproduct-list .number-page"
//       );
//       const prevBtn = document.querySelector(".prev-btn");
//       const nextBtn = document.querySelector(".next-btn");
//       let products;
//       // check any page open
//       if (location.href.includes("/showProperty.php")) {
//         products = data.products;
//       } else if (location.href.includes("/showConstruction.php")) {
//         products = data.construction;
//       } else if (location.href.includes("/clients.php")) {
//         // products = data.user;
//         products = users;
//       }
//       console.log(products);
//       let currentPage = 1;
//       const itemsPerPage = 9;
//       const loadingTime = 200;




//       function displayProducts() {
//         allProductList.innerHTML = `
//         <div class="container-loading">
//         <div class="loader"></div>
//       </div>
//         `;
//         setTimeout(() => {
//           const start = (currentPage - 1) * itemsPerPage;
//           const end = start + itemsPerPage;
//           const productToShow = products.slice(start, end);
//           allProductList.innerHTML = "";
//           currentNumber.innerHTML = currentPage;
//           productToShow.map((product) => {
//             // select the page and show his data
//             if (location.href.includes("/showProperty.php")) {
//               allProductList.innerHTML += `
//               <div class="col-lg-4 col-md-6 col-sm-12">
//               <div class="box">
//                 <div class="product-image">
//                   <img src="${product["productimage"]}" alt="" />
//                 </div>
//                 <div class="product-details">
//                   <p>${product["title"]}</p>
//                   <h2>$ <span>${product["price"]}</span></h2>
//                   <ul>
//                     <li>
//                       <span class="mdi mdi-bed-empty icon"></span>
//                       <span class="number">${product["numberOfBeds"]}</span>
//                       Beds
//                     </li>
//                     <li>
//                       <span class="mdi mdi-shower  icon"></span>
//                       <span class="number">${product["numberOfBaths"]}</span>
//                       Bath
//                     </li>
//                     <li>
//                       <span class="mdi mdi-fullscreen  icon"></span>
//                       <span class="number">${product["space"]}</span>
//                       m
//                     </li>
//                   </ul>
//                   <p>${product["description"]}</p>
//                 </div>
//                 <div class="product-ref">
//                   <div class="client-details">
//                     <img src="${product["image-user"]}" alt="">
//                     <span>${product["UserName"]}</span>
//                   </div>
//                   <a href="detailsProperty.php">Details</a>
//                 </div>
//               </div>
//             </div>`;
//             } else if (location.href.includes("/showConstruction.php")) {
//               allProductList.innerHTML += `
//               <div class="col-lg-4 col-md-6 col-sm-12">
//               <div class="box">
//                 <div class="product-image">
//                   <img src="${product["constructionImage"]}" alt="" />
//                 </div>
//                 <div class="product-details">
//                   <p class="main-title">${product["title"]}</p>
//                   <p>${product["description"]}</p>
//                 </div>
//                 <div class="product-ref">
//                   <div class="client-details">
//                     <img src="${product["image-user"]}" alt="">
//                     <span>${product["UserName"]}</span>
//                   </div>
//                   <a href="detailsConstruction.php">Details</a>
//                 </div>
//               </div>
//             </div>`;
//             } else if (location.href.includes("/clients.php")) {
//               allProductList.innerHTML += `
//               <div class="col-lg-4 col-md-4 col-sm-12">
//               <div class="client-data">
//                 <div class="main">
//                   <div class="image">
//                     <img src="${product["userImage"]}" alt="profiles">
//                   </div>
//                   <h3>${product["name"]}</h3>
//                 </div>
//                 <div class="other">
//                   <p>
//                     البريد الالكتروني : <span>${product["email"]}</span>
//                   </p>
//                   <p>
//                     الهاتف : <span>${product["phone"]}</span>
//                   </p>
//                   <p>
//                     العنوان : <span>${product["address"]}</span>
//                   </p>
//                   <p>
//                     تاريخ الميلاد : <span>${product["barth-of-date"]}</span>
//                   </p>
//                 </div>
//                 <div class="btn open-id" data-id="${product["id"]}" >تحقق من الهويه</div>
//                 <div class="id-container">
//                   <div class="img">
//                     <span class="close-image-id"><i class="fa-solid fa-xmark"></i></span>
//                     <img src="image/background01.jpg" alt="ID Image">
//                     <button data-id="${product["id"]}">هويه صحيحه</button>
//                   </div>
//                 </div>
//               </div>
//             </div>`;
//             }
//           });
//           // Call the callback function if provided
//           if (callback && typeof callback === "function") {
//             callback();
//           }
//           scrollToProductList();
//           checkBtn();

//         }, loadingTime);
//       }

//       const scrollToProductList = () => {
//         document.body.scrollTop = document.documentElement.scrollTop = 0;
//       };
//       function checkBtn() {
//         prevBtn.disabled = currentPage == 1;
//         nextBtn.disabled = currentPage * itemsPerPage >= products.length;
//       }
//       prevBtn.addEventListener("click", () => {
//         allProductList.innerHTML = "";
//         currentPage--;
//         displayProducts();
//       });
//       nextBtn.addEventListener("click", () => {
//         allProductList.innerHTML = "";
//         currentPage++;
//         displayProducts();
//       });
//       // Initialize
//       displayProducts();
//     });
// }



