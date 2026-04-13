/* Lab 8 - JavaScript / JSON / AJAX
   Sebastian Brzozowski
   Reads lab8projects.json via AJAX and builds the projects menu dynamically.
*/

$(document).ready(function () {

   // Load the JSON file and build the projects list
   $.ajax({
      type: "GET",
      url: "lab8projects.json",
      dataType: "json",
      success: function (data) {
         // Remove the loading message
         $('#loadingMsg').remove();

         // Build a card for each project item in the JSON
         $.each(data.menuItem, function (i, item) {
            var card = '<div class="projectCard" data-category="' + item.category + '">';
            card += '<span class="category">' + item.category + '</span>';
            // Store the description in a title attribute so jQuery UI tooltip can pick it up
            card += '<h2><a href="' + item.link + '" title="' + item.description + '">' + item.title + '</a></h2>';
            card += '<p>' + item.description + '</p>';
            card += '</div>';
            $('#projectsContainer').append(card);
         });

         // jQuery UI tooltip on project links - shows each project's description on hover
         $('.projectCard a').tooltip();

         // Apply active filter on load (show all by default)
         applyFilter('All');
      },
      error: function (msg) {
         $('#loadingMsg').text("Error loading projects: " + msg.status + " " + msg.statusText);
      }
   });

   // Filter buttons - show only cards matching selected category
   $('#filterButtons').on('click', '.filterBtn', function () {
      // Update active button style
      $('.filterBtn').removeClass('active');
      $(this).addClass('active');

      var selected = $(this).data('filter');
      applyFilter(selected);
   });

   // Show/hide cards based on category filter, with a quick fade effect
   function applyFilter(category) {
      if (category === 'All') {
         $('.projectCard').fadeIn(300);
      } else {
         $('.projectCard').each(function () {
            if ($(this).data('category') === category) {
               $(this).fadeIn(300);
            } else {
               $(this).fadeOut(200);
            }
         });
      }
   }

});
