$(".after-card").hide();
$(document).ready(function () {
  $(".after-card").fadeIn("slow");
  $("input").change(function (e) {
    e.preventDefault();
    $(".field-hint, .alert-error, .text-error").hide();
  });
});

// Minimal vanilla-JS carousel, replaces Bootstrap's carousel component.
// Usage: <div id="X"><div class="carousel-inner">...<div class="carousel-item">...</div></div></div>
// Buttons: onclick="carouselMove('X', -1)" / onclick="carouselMove('X', 1)"
function carouselMove(id, dir) {
  const wrap = document.getElementById(id);
  if (!wrap) return;
  const inner = wrap.querySelector(".carousel-inner");
  const items = inner ? inner.children.length : 0;
  if (!items) return;
  let idx = parseInt(wrap.dataset.idx || "0", 10);
  idx = (idx + dir + items) % items;
  wrap.dataset.idx = idx;
  inner.style.transform = `translateX(-${idx * 100}%)`;
}

const Toast = Swal.mixin({
  toast: true,
  position: "top-end",
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener("mouseenter", Swal.stopTimer);
    toast.addEventListener("mouseleave", Swal.resumeTimer);
  },
});
