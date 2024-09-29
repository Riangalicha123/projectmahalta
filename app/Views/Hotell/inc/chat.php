<style>
    /* Style for the floating messenger button */
    .floating-messenger {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 999;
    }

    /* Style for the messenger icon */
    .floating-messenger img {
        width: 50px;
        height: auto;
        cursor: pointer;
        border-radius: 50%;
    }

    /* Style for the messenger form container */
    #messenger-form {
        position: fixed;
        bottom: 80px;
        right: 20px;
        z-index: 998;
        background-color: #fff;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        display: none; /* Form is hidden initially */
    }


 /* Style for the close button */
#close-btn {
    background: none; /* Removes any background */
    border: none; /* Removes the border */
    cursor: pointer;
    padding: 0; /* Ensures no padding is added */
}

#close-btn img {
    width: 50px; /* Keep this as is */
    cursor: pointer;
    border-radius: 50%; /* Keep this as is */
}

    /* Hide messenger icon when form is open */
    .hidden {
        display: none;
    }
</style>

<!-- Updated HTML -->
<?php if(session()->get('isLoggedIn')): ?>
    <div class="floating-messenger">
        <!-- Messenger icon (default state) -->
        <a id="messenger-btn">
            <img src="/guest/images/logomessage.jpg" alt="Messenger Icon">
        </a>

        <!-- Close button with image (hidden initially) -->
        <button id="close-btn" class="hidden">
            <img src="/guest/images/close-icon.png" alt="Close Messenger">
        </button>
    </div>

    <!-- Messenger form -->
    <div id="messenger-form" style="position: fixed; bottom: 80px; right: 20px; width: 300px; background-color: #fff; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); border-radius: 10px; display: none;">
        <div class="card" style="border: none;">
            <div class="card-header text-center" style="background-color: #4e8cff; color: #fff; border-radius: 10px 10px 0 0;">
                MESSAGE
            </div>
            <div class="card-body" style="padding: 15px;">
                <div class="text-center" style="font-size: 10px;">
                    <?php foreach ($chats as $chat): ?>
                        <div class="row" style="overflow-y: auto; max-height: 130px;">
                            <div class="col-md-12 text-center">
                                <button id="chatmsgs" style="cursor: pointer; padding: 10px 20px; font-size: 14px; background-color: #007bff; color: white; border: none; border-radius: 5px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); transition: transform 0.2s ease, box-shadow 0.2s ease;" 
                                    onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0px 6px 8px rgba(0, 0, 0, 0.2)';"
                                    onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0px 4px 6px rgba(0, 0, 0, 0.1)';">
                                    <?= $chat['Question'] ?>
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div id="chatmsg" class="chatmsg" style="z-index: 99999 !important; overflow-y: auto; max-height: 200px; color: black"></div>
                <hr style="border-top: 1px solid #ccc; margin: 10px 0;">
                <form id="chatForm">
                    <div class="row">
                        <div class="col-md-8 col-sm-9 form-group" style="padding-right: 5px;">
                            <textarea placeholder="Type message.." name="msg" id="msg" class="form-control" cols="30" rows="1"></textarea>
                        </div>
                        <div class="col-md-4 col-sm-3 form-group" style="padding-left: 5px;">
                            <button type="submit" class="btn btn-primary" style="padding: 5px 5px; border-radius: 5px; width: 100%;">
                                Send
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php else: ?>
    <div class="floating-messenger">
        <!-- Messenger icon (default state) -->
        <a id="messenger-btn">
            <img src="/guest/images/logomessage.jpg" alt="Messenger Icon">
        </a>

        <!-- Close button with image (hidden initially) -->
        <button id="close-btn" class="hidden">
            <img src="/guest/images/close-icon.png" alt="Close Messenger">
        </button>
    </div>

    <div id="messenger-form" style="display: none;">
        <div class="card">
            <div class="card-header text-center" style="background-color: #4e8cff; color: #fff; border-radius: 10px 10px 0 0;">
                MESSAGE
            </div>
            <div class="card-body">
                <a class="nav-link" href="<?= route_to('login') ?>" style="color: blue; font-size: 18px; text-decoration: none;">
              <i class="fas fa-sign-in-alt mr-2"></i>Log In First
                </a>
            </div>
        </div>
    </div>
    
<?php endif; ?>

<script>
        const messengerBtn = document.getElementById('messenger-btn');
        const closeBtn = document.getElementById('close-btn');
        const messengerForm = document.getElementById('messenger-form');

        // Show form and close button when messenger button is clicked
        messengerBtn.addEventListener('click', function() {
            messengerForm.style.display = 'none';      // Show messenger form
            messengerBtn.classList.add('hidden');      // Hide the messenger icon
            closeBtn.classList.remove('hidden');       // Show the "X" close button
        });

        // Hide form and revert to messenger icon when "X" button is clicked
        closeBtn.addEventListener('click', function() {
            messengerForm.style.display = 'block';      // Hide the messenger form
            messengerBtn.classList.remove('hidden');   // Show the messenger icon
            closeBtn.classList.add('hidden');          // Hide the "X" close button
        });
    </script>
