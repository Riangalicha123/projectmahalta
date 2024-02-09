<style>
    #chatmsgs {
  border-radius: 20px; /* Half of the height to make it oblong */
  /* Add any other styling you want */
}
</style>
<?php if(session()->get('isLoggedIn')): ?>
<div class="floating-messenger">
        <a id="messenger-btn">
            <img src="/guest/images/mess.png" alt="Messenger Icon">
        </a>

        <div id="messenger-form" style="display: none; position: fixed; bottom: 20px; right: 20px; width: 300px; background-color: #fff; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); border-radius: 10px;">

<!-- Close icon -->
<button id="close-btn" style="position: absolute; top: -3px; right: 5px; background: none; border: none; cursor: pointer; font-size: 16px; color: #666;">
    <i>X</i>
</button>

<!-- Your form content goes here -->
<div class="card" style="border: none;">

    <div class="card-header text-center" style="background-color: #4e8cff; color: #fff; border-radius: 10px 10px 0 0;">
        MESSAGE
    </div>

    <div class="card-body" style="padding: 15px;">
        <div class="text-center" style="font-size: 10px;">
            <p>Choose one, type it and click send</p>
        </div>
        <div id="chatmsg" class="chatmsg" style="z-index: 99999 !important; overflow-y: auto; max-height: 200px;">
        <?php foreach ($chats as $chat): ?>
            <div class="row" style="overflow-y: auto; max-height: 130x;">
                        <div class="col-md-12 text-center" >
                            <button id="chatmsgs"><?= $chat['Question'] ?></button>
                        </div>
            </div>
        <?php endforeach;?>
        </div>
        <hr style="border-top: 1px solid #ccc; margin: 10px 0;">
        <form id="chatForm">
            <div class="row">
                <div class="col-md-12 form-group">
                    <textarea placeholder="Type message.." name="msg" id="msg" class="form-control" cols="30" rows="2" style="overflow-y: auto; resize: none; border: 1px solid #ccc; border-radius: 5px;"></textarea>
                </div>
            </div>

            
            <div class="row">
                <div class="col-md-12 form-group text-center">
                    <button type="submit" class="btn" style="background-color: #4e8cff; color: #fff; border: none; padding: 8px 55px; border-radius: 5px; cursor: pointer;">Send</button>
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
        <img src="/guest/images/mess.png" alt="Messenger Icon">
    </a>
</div>

<div id="messenger-form" style="display: none;">
    <!-- Close icon -->
    <button id="close-btn" style="position: absolute; top: -3px; right: 5px; background: none; border: none; cursor: pointer;font-size: 16px; color: #666;">
        <i>X</i>
    </button>

    <!-- Your form content goes here -->
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