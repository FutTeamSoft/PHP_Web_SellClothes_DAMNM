<!--End-body-->
<!--Footer-->
<footer>
    <div class="container-fluid padding">
        <div class="row">
            <div class="col-md-4 mx-auto text-center">
                <h1>FTeam</h1>
                <p>Fashion is like the breath of life every day and it always changes with the flow of events. You can
                    even see a revolutionary approach in clothing. You can see and feel everything with fashion.</p>
                <strong>Contact info</strong>
                <p>+84-399-128-713<br />fteam@gmail.com</p>
                <a href="#" target="_blank"> <i class="fab fa-facebook-square"></i></a>
                <a href="#" target="_blank"> <i class="fab fa-twitter-square"></i></a>
                <a href="#" target="_blank"> <i class="fab fa-instagram-square"></i></a>
            </div>
            <div class="col-10 mx-auto text-center">
                <hr class="light" />
                <p>Copyright 2023. Design by FTeam.</p>
            </div>
        </div>

    </div>
</footer>
<!--End-footer-->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="assets/js/bootstrap.bundle.js"></script>
<script src="assets/js/main.js"></script>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }


    function numberWithDot(x) {
        return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ".");
    }



    function redirectParams(name, value) {
        var url = new URL(window.location.href);
        url.searchParams.set(name, value);
        window.location.href = url.href;
    }

    function pagination(num) {
        redirectParams('page', num);
    }




    // Get the update button element
</script>
</body>

</html>