<style>
    #loaderr {
        position: fixed;
        width: 50px;
        height: 50px;
        left: 50%;
        top: 62%;
        -webkit-transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
        background-color: rgba(255, 255, 255, 0.9);
        -webkit-box-shadow: 0px 24px 64px rgba(0, 0, 0, 0.24);
        box-shadow: 0px 24px 64px rgba(0, 0, 0, 0.24);
        border-radius: 16px;
        opacity: 0;
        visibility: hidden;
        z-index: 1000;
    }

    #loaderr img {
        height: 500px;
        width: 450px;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
    }

    #loaderr .exit-button {
        position: absolute;
        top: -225px; 
        right: -200px;
        cursor: pointer;
        z-index: 1001;
        padding: 5px 10px;
        background-color: #ff0000;
        color: #ffffff;
        border: none;
        border-radius: 5px;
    }

    #loaderr.show {
        visibility: visible;
        opacity: 1;
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
