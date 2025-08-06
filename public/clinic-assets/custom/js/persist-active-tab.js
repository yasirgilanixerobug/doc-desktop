$(document).ready(function () {
    // Get the active tab from the URL hash
    const activeTab = window.location.hash.replace('#', ''); // e.g., "locations" or "doctors"

    if (activeTab) {
        // Remove 'active' class from all tabs and tab panes
        $('.nav-link').removeClass('active');
        $('.tab-pane').removeClass('show active');

        // Activate the specified tab
        $(`#${activeTab}-tab`).addClass('active');
        $(`#${activeTab}`).addClass('show active');
    }

    // Update the URL when a tab is clicked
    $('.nav-link').on('click', function () {
        const tabId = $(this).attr('href').replace('#', ''); // Extract tab ID from href
        window.location.hash = tabId; // Update the URL hash
    });
});