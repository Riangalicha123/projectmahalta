<style>
    #chatmsgs {
  border-radius: 20px;
}
.card-body {
    position: relative; 
}

.form-group {
    margin-bottom: 0; 
}

.fa-paper-plane {
    position: absolute;
    top: 40%;
    right: 10px; 
    transform: translateY(-50%);
}
textarea {
    overflow-y: auto;
    resize: none;
    border: 1px solid #ccc;
    border-radius: 2px;
    
}

button {
    padding: 5px 0px;
    border-radius: 5px;
    cursor: pointer;
    width: 100%; /* Make button take full width in smaller screens */
}

@media (max-width: 768px) {
    .form-group {
        margin-bottom: 10px;
    }
}

</style>
<?php if(session()->get('isLoggedIn')): ?>
                    <div class="floating-messenger">
                            <a id="messenger-btn">
                                <img src="/guest/images/logomessage.jpg" alt="Messenger Icon">
                            </a>

                            <div id="messenger-form" style="display: none; position: fixed; bottom: 20px; right: 20px; width: 300px; background-color: #fff; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); border-radius: 10px;">

                                <button id="close-btn" style="position: absolute; top: -3px; right: 5px; background: none; border: none; cursor: pointer; font-size: 16px; color: #666;">
                                    <i>X</i>
                                </button>
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
                            <?php endforeach;?>
                        </div>
                            <div id="chatmsg" class="chatmsg" style="z-index: 99999 !important; overflow-y: auto; max-height: 200px; color: black"></div>
                            <hr style="border-top: 1px solid #ccc; margin: 10px 0;">
                            <form id="chatForm">
                        <div class="row">
                            <div class="col-md-8 col-sm-9 form-group" style="padding-right: 5px;">
                                <textarea placeholder="Type message.." name="msg" id="msg" class="form-control" cols="30" rows="1" style="overflow-y: auto; resize: none; border: 1px solid #ccc; border-radius: 2px;"></textarea>
                            </div>
                            <div class="col-md-4 col-sm-3 form-group" style="padding-left: 5px; display: flex; align-items: center; justify-content: flex-start; ">
                                <button type="submit" class="btn btn-primary" style="padding: 5px 5px; border-radius: 5px; cursor: pointer;">
                                    Send
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php else: ?>
        <div class="floating-messenger">
    <a id="messenger-btn">
        <img src="/guest/images/logomessage.jpg" alt="Messenger Icon">
    </a>
</div>

<div id="messenger-form" style="display: none;">
    <button id="close-btn" style="position: absolute; top: -3px; right: 5px; background: none; border: none; cursor: pointer;font-size: 16px; color: #666;">
        <i>X</i>
    </button>
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