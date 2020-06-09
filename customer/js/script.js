$(document).ready(function() {
    $.get("../../api/getDishes.php", function data() { })
        .done(function(dishes) {
            alert(dishes.length);
            for (i = 0; i < dishes.length; i++)
            {
                // Populate a new box with dish info.
                // Append it to the slider.
                var dish = dishes[i];
                $('#autoWidth').append(`
                <li class="item">
                    <div class="box">
                        <img src="${dish["image_url"]}" class="model">
                        <div class="details">
                            <p>${dish["name"]}</p>
                        </div>
                    </div>
                </li>`);
            }

            $('#autoWidth').lightSlider({
                autoWidth: true,
                loop: true,
                onSliderLoad: function() {
                    $('#autoWidth').removeClass('cS-hidden');
                } 
            });
        });
});