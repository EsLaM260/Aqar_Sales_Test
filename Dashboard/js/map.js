export function chooseYourLocation() {
  //  openstreet Map
  // كده بتبتدء تشتغل علي الخريطه و بتكتب جوا اسم ال id للعنصر
  let map = L.map("map");
  // بياخد خط الطول و العرض عشان يروح علي المكان الاساسي
  map.setView([29.88756, 31.06435], 16);
  // هنا بتستخدم اللينك عشان يعرضها عندك
  L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    attribution: "© OpenStreetMap contributors",
    maxZoom: 20,
  }).addTo(map);
  // انت كده بتعمل الايقون و لسه هتستخدمها
  let customIcon = L.icon({
    iconUrl: "image/Home.png",
    iconSize: [40, 40],
  });
  //
  let marker = L.marker([29.88756, 31.06435], {
    title: "home", // عنوان
    draggable: true, // بتحدد قابله للسحب ولا لا
    icon: customIcon, // هنا بتستخدم الايقون الي اخترتها
  })
    .bindPopup("<h2>Home</h2>") // بتخليك لما تدوس علي اللوكيشن يظهر الي هتكتبه هنا
    .addTo(map);
  marker.on("dragend", function (event) {
    var position = marker.getLatLng();
    let lat =  document.querySelectorAll(".stylemap input")[0].value = position.lat;
    let lng =  document.querySelectorAll(".stylemap input")[1].value = position.lng;
    console.log(lat, lng);
  });
  // ###########################
  // ده الي بيجيب اللوكيشن بتاعك
  var LocateControl = L.Control.extend({
    options: {
      position: "topleft", // Position of the button on the map
    },
    onAdd: function (map) {
      var container = L.DomUtil.create(
        "div",
        "leaflet-bar leaflet-control leaflet-control-custom"
      );
      container.style.backgroundColor = "white";
      container.style.backgroundImage = "url('image/currentlocation.png')"; // Set the path to your location icon
      container.style.backgroundSize = "30px 30px";
      container.style.width = "34px";
      container.style.height = "34px";
      container.onclick = function () {
        map.locate({ setView: true, maxZoom: 16 });
      };
      return container;
    },
  });
  map.addControl(new LocateControl());

  let customIconHome = L.icon({
    iconUrl: "image/home2.png",
    iconSize: [40, 40],
  });
  map.on("locationfound", function (e) {
    L.marker(e.latlng, {
      icon: customIconHome, // هنا بتستخدم الايقون الي اخترتها
    })
      .addTo(map)
      .bindPopup("You're location")
      .openPopup();
  });
  map.on("locationerror", function (e) {
    alert(e.message);
  });
}
export function displayYourLocation() {
  // كده بتبتدء تشتغل علي الخريطه و بتكتب جوا اسم ال id للعنصر
  let map = L.map("showmap");
  // بياخد خط الطول و العرض عشان يروح علي المكان الاساسي
  map.setView([29.88756, 31.06435], 16);
  // هنا بتستخدم اللينك عشان يعرضها عندك
  L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    attribution: "© OpenStreetMap contributors",
    maxZoom: 20,
  }).addTo(map);
  // انت كده بتعمل الايقون و لسه هتستخدمها
  let customIcon = L.icon({
    iconUrl: "image/home2.png",
    iconSize: [40, 40],
  });
  let marker = L.marker([29.88756, 31.06435], {
    title: "home", // عنوان
    draggable: false, // بتحدد قابله للسحب ولا لا
    icon: customIcon, // هنا بتستخدم الايقون الي اخترتها
  }).addTo(map);
}
