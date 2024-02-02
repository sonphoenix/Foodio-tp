
 function im1(){
    var img=document.getElementById("foodimg");
    img.src = "image/plate1.png";
}

function im2(){
    var img=document.getElementById("foodimg");
    img.src = "image/plate2.png";
}

 function im3(){
    var img=document.getElementById("foodimg");
    img.src = "image/plate3.png";
}

const menuIcon = document.querySelector(".toggle");

const mobileMenu = document.querySelector(".navMenu");

menuIcon.onclick = function(){
    if(mobileMenu.style.display != "block"){
        mobileMenu.style.display = "block"
    }
    else{
        mobileMenu.style.display = "none"
    }
}

// add hovered class to selected list item
let list = document.querySelectorAll(".navigation li");

function activeLink() {
  list.forEach((item) => {
    item.classList.remove("hovered");
  });
  this.classList.add("hovered");
}

list.forEach((item) => item.addEventListener("mouseover", activeLink));

// Menu Toggle
let toggle = document.querySelector(".toggle");
let navigation = document.querySelector(".navigation");
let main = document.querySelector(".main");

toggle.onclick = function () {
  navigation.classList.toggle("active");
  main.classList.toggle("active");
};
