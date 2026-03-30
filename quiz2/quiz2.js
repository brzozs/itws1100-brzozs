// f
alert("Page is about to load");

// g
$(document).ready(function() {
  // g1
  var defaultTitle = "ITWS 1100 - Quiz 2";
  document.title = defaultTitle;

  // h
  $("#go-btn").click(function() {
    // h1
    if (document.title === defaultTitle) {
      document.title = "Sebastian Brzozowski - Quiz 2";
    // h2
    } else {
      document.title = defaultTitle;
    }
  });

  // h3
  $("#last-name").mouseenter(function() {
    $(this).addClass("makeItPurple");
  });

  // h4
  $("#last-name").mouseleave(function() {
    $(this).removeClass("makeItPurple");
  });
});
