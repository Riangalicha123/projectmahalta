<!-- Include Bootstrap CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<style>
#loaderr {
    position: fixed;
    width: 80%;
    max-width: 350px;
    height: auto;
    max-height: 80%;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    background-color: rgba(255, 255, 255, 0.9);
    box-shadow: 0px 24px 64px rgba(0, 0, 0, 0.24);
    border-radius: 16px;
    opacity: 0;
    visibility: hidden;
    z-index: 1000;
    text-align: center;
    padding: 20px;
    overflow-y: auto;
}

#loaderr.show {
    visibility: visible;
    opacity: 1;
    transition: opacity 0.3s ease-in-out;
}
.exit-button {
    color: gray;
    cursor: pointer;
    transition: color 0.3s ease; /* Smooth transition for color change */
}

.exit-button:hover {
    color: red; /* Change color to red on hover */
}
</style>

<div id="loaderr">
    <?php if (!empty($news)): ?>
    <!-- Carousel Start -->
    <div id="newsCarousel" class="carousel slide" data-ride="carousel" data-interval="3000"> <!-- Automatic sliding with 3-second interval -->
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <?php foreach ($news as $index => $item): ?>
                <li data-target="#newsCarousel" data-slide-to="<?= $index ?>" class="<?= $index == 0 ? 'active' : '' ?>"></li>
            <?php endforeach; ?>
        </ol>

        <!-- Carousel Items -->
        <div class="carousel-inner">
            <?php foreach ($news as $index => $item): ?>
                <div class="carousel-item <?= $index == 0 ? 'active' : '' ?>">
                    <img src="<?= base_url('/news/' . $item['Image']) ?>" alt="News Image" style="width: 100%; height: auto; max-height: 400px;">
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Controls -->
        <a class="carousel-control-prev" href="#newsCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#newsCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <!-- Carousel End -->
    <?php endif; ?>
    <br>
    <!-- Exit Button -->
    <u class="exit-button" onclick="hideLoader()">Don't show</u>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function(event) { 
    document.getElementById("loaderr").classList.add("show");
    setTimeout(function(){
        document.getElementById("loaderr").classList.remove("show");
    }, 10000); // Adjust the timeout as necessary
});

function hideLoader() {
    document.getElementById("loaderr").classList.remove("show");
}
</script>
