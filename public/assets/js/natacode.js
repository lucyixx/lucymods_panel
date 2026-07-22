// Toggles a password field between hidden/visible, swapping the trailing
// eye icon to match. Shared here since more than one form uses it
// (login, register) — plain JS, no jQuery dependency, works on pages
// that don't load jQuery (Layout/Starter) as well as ones that do.
function togglePw(id, btn) {
  var input = document.getElementById(id);
  var isHidden = input.type === "password";
  input.type = isHidden ? "text" : "password";
  btn.querySelector("use").setAttribute("href", isHidden ? "#i-eye-off" : "#i-eye");
  btn.setAttribute("aria-label", isHidden ? "Hide password" : "Show password");
}

if (typeof $ !== "undefined") {
  $(".after-card").hide();
  $(document).ready(function () {
    $(".after-card").fadeIn("slow");
    $("input").change(function (e) {
      e.preventDefault();
      $(".field-hint, .alert-error, .text-error").hide();
    });
  });
}

if (typeof Swal !== "undefined") {
  var Toast = Swal.mixin({
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
}
