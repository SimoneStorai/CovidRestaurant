$(document).ready(function() {
    $.get("../../api/getDishes.php", function data() { })
        .done(function(dishes) {
            for (i = 0; i < dishes.length; i++)
            {
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