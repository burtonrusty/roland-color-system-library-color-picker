jQuery(document).ready(function ($) {
    // Handle color block click
    $(".rcs-color-block").on("click", function () {
        var hex = $(this).data("color"); // Use the 'data-color' attribute which now holds the hex value
        $("#rcs-color-display").css("background-color", hex);
        $("#rcs-hex-display").val(hex); // Display Hex value in the text field
    });

    // Handle color save form submission
    var $saveColorForm = $("#rcs-save-color-form");
    if ($saveColorForm.length) {
        $saveColorForm.on("submit", function (e) {
            e.preventDefault();
            var color = $("#rcs-hex-display").val();

            $("#rcs_color").val(color);

            $.ajax({
                url: rcs_ajax_object.ajax_url,
                type: "POST",
                data: {
                    action: "rcs_save_user_color",
                    color: color,
                    security: rcs_ajax_object.security,
                },
                success: function (response) {
                    if (response.success) {
                        alert(response.data.message);
                        location.reload(); // Refresh the page to update the list of saved colors
                    } else {
                        alert("Error: " + response.data.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.log(xhr.responseText);
                },
            });
        });
    }

    // Handle delete color button click
    $(document).on("click", ".rcs-delete-color", function (e) {
        e.preventDefault();

        if (confirm("Are you sure you want to delete this color?")) {
            var color = $(this).data("color");

            $.ajax({
                url: rcs_ajax_object.ajax_url,
                type: "POST",
                data: {
                    action: "rcs_delete_user_color",
                    color: color,
                    security: rcs_ajax_object.security,
                },
                success: function (response) {
                    if (response.success) {
                        alert("Color deleted successfully.");
                        location.reload(); // Refresh the page to update the list of saved colors
                    } else {
                        alert("Failed to delete color: " + response.data.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.log(xhr.responseText);
                },
            });
        }
    });
});