<?php if(session()->get('isLoggedIn')): ?>
<div class="floating-messenger">
        <a id="messenger-btn">
            <img src="/guest/images/mess.png" alt="Messenger Icon">
        </a>
    </div>

    <div id="messenger-form" style="display: none;">
        <!-- Close icon -->
        <button id="close-btn" style="position: absolute; top: 1px; right: 10px; background: none; border: none; cursor: pointer;">
            <i>X</i>
        </button>

        <!-- Your form content goes here -->
        <div class="card">
            <div class="card-header text-center">
                Message
            </div>
            <div class="card-body">
            <div id="chatmsg" class="chatmsg" style="z-index: 99999 !important; overflow-y: auto; max-height: 100px;"></div>
                <hr>
                <form id="chatForm">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <textarea placeholder="Type message.." name="msg" id="msg" class="form-control" cols="30" rows="2" style="overflow-y: auto;" required></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group text-center">
                            <button type="submit" class="btn">Send</button>
                        </div>
                    </div>
                </form>
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
        <button id="close-btn" style="position: absolute; top: 1px; right: 10px; background: none; border: none; cursor: pointer;">
            <i>X</i>
        </button>

        <!-- Your form content goes here -->
        <div class="card" style="width: 18rem;">
        <div class="card-header text-center">
          Chat
        </div>
          <div class="card-body">
          <a class="nav-link" href="<?= route_to('login') ?>" style="color: black; font-size: 20px;">
                                <i class="fas fa-sign-in-alt mr-2"></i>Log In First
                            </a>
          </div>
        </div>
    </div>
    <?php endif; ?>