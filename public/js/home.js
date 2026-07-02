document.addEventListener("DOMContentLoaded", function () {

const slides = document.querySelectorAll(".slide");
const dots = document.querySelectorAll(".slider-dot");
const next = document.querySelector(".slider-arrow.next");
const prev = document.querySelector(".slider-arrow.prev");

if(slides.length===0) return;

let index=0;

function show(i){

slides.forEach(s=>s.classList.remove("active"));
dots.forEach(d=>d.classList.remove("active"));

if(i>=slides.length) index=0;
else if(i<0) index=slides.length-1;
else index=i;

slides[index].classList.add("active");

if(dots[index])
dots[index].classList.add("active");

}

next?.addEventListener("click",()=>show(index+1));

prev?.addEventListener("click",()=>show(index-1));

dots.forEach((dot,i)=>{
dot.addEventListener("click",()=>show(i));
});

setInterval(()=>{
show(index+1);
},5000);

});