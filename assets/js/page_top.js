const scrollToTopBtn = document.querySelector("#page-top");

window.addEventListener("scroll", function () {
  if (window.pageYOffset > 100) {
    scrollToTopBtn.classList.add("show");
  } else {
    scrollToTopBtn.classList.remove("show");
  }
});

scrollToTopBtn.addEventListener("click", function () {
  window.scrollTo({
    top: 0,
    behavior: "smooth"
  });
});