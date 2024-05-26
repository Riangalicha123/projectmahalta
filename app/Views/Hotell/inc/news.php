<style>
#loaderr {
    position: fixed;
    width: 80%;
    max-width: 350px; /* Reduced max-width for a smaller appearance */
    height: auto;
    max-height: 80%; /* Ensuring the height doesn't exceed 80% of the viewport height */
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
    overflow-y: auto; /* Added for scrollability if content overflows */
}

#loaderr img {
    width: 100%;
    height: auto;
    max-width: 350px; /* Reduced max-width for a smaller appearance */
    margin: 0 auto;
}

#loaderr .exit-button {
    display: inline-block;
    margin-top: 20px;
    padding: 10px 20px;
    background-color: #ff0000;
    color: #ffffff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

#loaderr.show {
    visibility: visible;
    opacity: 1;
    transition: opacity 0.3s ease-in-out;
}

</style>

<div id="loaderr">
<?php if (!empty($news)): ?>
    <img src="<?=base_url('/news/'.$news[0]['Image'])?>" alt="user-avatar">
<?php endif; ?>
    
    <button class="exit-button" onclick="hideLoader()">Exit</button>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function(event) { 
        document.getElementById("loaderr").classList.add("show");
        setTimeout(function(){
            document.getElementById("loaderr").classList.remove("show");
        }, 10000); 
    });
    function hideLoader() {
        document.getElementById("loaderr").classList.remove("show");
    }
</script>
