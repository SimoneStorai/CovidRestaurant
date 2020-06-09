$(document).ready(function() {
    $('#autoWidth').append(`
    <li class="item">
        <div class="box">
            <img src="img/stuff.png" class="model">
            <div class="details">
                <img src="img/stuff.png" class="logo" width="100%" style="height: auto;">
                <p>Placeholder.</p>
            </div>
        </div>
    </li>`);
    $('#autoWidth').lightSlider({
        autoWidth: true,
        loop: true,
        onSliderLoad: function() {
            $('#autoWidth').removeClass('cS-hidden');
        } 
    });
});