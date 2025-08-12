const hideshowDiv = document.querySelector(".step-info");
hideshowDiv.addEventListener("click", (event) => {
  event.preventDefault();
  let nextDiv = hideshowDiv.nextElementSibling,
    ishidden = nextDiv.hidden;
  ishidden ? (nextDiv.hidden = false) : (nextDiv.hidden = true);
});
