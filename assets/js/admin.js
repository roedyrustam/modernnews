jQuery(document).ready(function ($) {
    // Initialize Color Picker
    $('.modernnews-color-picker').wpColorPicker();

    // Tab Switching Logic
    $('.modernnews-tab-link').on('click', function (e) {
        e.preventDefault();

        // Remove active class from all tabs and content
        $('.modernnews-tab-link').removeClass('active');
        $('.modernnews-tab-content').removeClass('active');

        // Add active class to clicked tab
        $(this).addClass('active');

        // Show corresponding content
        var tabID = $(this).data('tab');
        $('#' + tabID).addClass('active');

        // Persist tab selection (Optional: could use localStorage)
    });
});
