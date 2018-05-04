<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A layout example that shows off a responsive email layout.">
    <title>My Emails</title>
    <link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/pure-min.css" integrity="sha384-" crossorigin="anonymous">
    <script type="text/javascript" src="//code.jquery.com/jquery-3.2.1.min.js" charset="utf-8"></script>
    <script type="text/javascript" src="script.js"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
    <link rel="stylesheet" href="css/email.css">
    <link rel="stylesheet" type="text/css" href="css/modal.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css">
    <script src="bootstrap.js"></script> 
    <script type="text/javascript" src="dragndrop.js"></script>
</head>
<body class="real_body">
    
    <div id="layout" class="content pure-g">
        <div id="nav" class="pure-u">
            <a href="#" class="nav-menu-button">Menu</a>
            <h2 id="title-nav">My mails</h2>
            <div class="nav-inner">
                <button class="primary-button pure-button" href="#modalSendMail" data-toggle="modal">Compose</button>
                <div class="pure-menu">
                    <ul class="pure-menu-list">
                        <li class="pure-menu-item"><a href="mail.php" class="pure-menu-link">Inbox <span class="email-count"></span></a></li>
                        <li class="pure-menu-item"><a href="#" class="pure-menu-link">Important</a></li>
                        <li class="pure-menu-item"><a href="#" class="pure-menu-link">Sent</a></li>
                        <li class="pure-menu-item"><a href="drafts.php" class="pure-menu-link pure-menu-selected">Drafts</a></li>
                        <li class="pure-menu-item"><a href="#" class="pure-menu-link">Trash</a></li>
                        <li class="pure-menu-heading">Labels <a href="#modalAddFolder" data-toggle="modal"><span id="add_folder" class="fas fa-plus-circle"></span></a></li>
                        <?php 
                        for ($i=0; $i < count($_SESSION); $i++) { 
                        if (isset($_SESSION['label-name-'.$i]) && isset($_SESSION['label-filter-'.$i])) {
                            echo '<li class="pure-menu-item pure-menu-selected folder" id="'.$_SESSION['label-name-'.$i].'"><a href="mail.php?labels='.$_SESSION['label-filter-'.$i].'" class="pure-menu-link"><span class="email-label-personal"></span>'.$_SESSION['label-name-'.$i].'</a></li>';
                        }} ?>
                        <li class="pure-menu-heading">Actions</li>
                        <li class="pure-menu-item"><a href="#myModal" class="pure-menu-link" data-toggle="modal"><span class="fas fa-search"></span>  Search</a></li>
                        <li class="pure-menu-item"><a href="javascript:{}" class="pure-menu-link" onclick="document.getElementById('my_form').submit();"><span class="far fa-trash-alt"></span>  Delete</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="list" class="pure-u-1">
            <?php 
            if(isset($_GET['labels'])){
                echo '<div class="pure-u little-nav"><form method="POST" id="form_delete_filter" action="../model/confirm_delete_label.php"><input type="hidden" name="folder-name" value="'.$_GET['labels'].'"/></form><span class="email-label-personal color-span"></span><h3 class="pure-menu-link label_name">'.$_GET['labels'].'</h3>';
                echo "<a id='link-span' href='javascript:{}' onclick=document.getElementById('form_delete_filter').submit(); >";
                echo '<span class="fas fa-minus-circle labels-delete"></span></a></div>';
            }
            ?>
            <form method="POST" id="my_form" name="checkbox-all-mail" action="../model/delete_mail.php">
                <?php 
                include ('../model/mail.php');
                $list = new mail();
                $list->list_mail(0,'drafts');
                ?>
            </form>
        </div>
        <div id="main" class="pure-u-1">
            <?php
            $list->list_mail(1,'drafts');
            ?>
        </div>
    </div>

    <script src="https://yui-s.yahooapis.com/3.18.1/build/yui/yui-min.js"></script>
    <script>
        YUI().use('node-base', 'node-event-delegate', function (Y) {

            var menuButton = Y.one('.nav-menu-button'),
            nav        = Y.one('#nav');

        // Setting the active class name expands the menu vertically on small screens.
        menuButton.on('click', function (e) {
            nav.toggleClass('active');
        });

        // Your application code goes here...

    });
</script>
<div id="myModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Search :</h2>
                    <button class="close-btn" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form method="POST" class="pure-form" action="">
                        <input type="text" class="pure-input-1" name="search-input" placeholder="Enter something here..."/>
                </div>
                <div class="modal-footer modal-footer-right">
                    <button type="button" class="pure-button button-small" data-dismiss="modal">Close</button>
                    <button type="submit" class="pure-button button-small  pure-button-primary">Search <span class="fas fa-search"></span></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="modalAddFolder" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Add folder with filter :</h2>
                    <button class="close-btn" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form method="POST" class="pure-form" action="../model/confirm_label.php">
                        <h3 class="subtitle-modal">Name the folder :</h3>
                        <input type="text" class="pure-input-1" name="input-add-folder-name" placeholder="Enter something here..."/>
                        <h3 class="subtitle-modal">Filter :</h3>
                        <input type="text" class="pure-input-1" name="input-add-folder-filter" placeholder="Enter something here..."/>
                </div>
                <div class="modal-footer modal-footer-right">
                    <button type="button" class="pure-button button-small" data-dismiss="modal">Close</button>
                    <button type="submit" class="pure-button button-small  pure-button-primary">Add <span class="fas fa-plus" id="plus-folder"></span><span class="fas fa-folder"></span></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
     <div id="modalSendMail" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Send a message :</h2>
                    <button class="close-btn" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form class="pure-form" action="../model/confirm_send_mail.php" id="form-send" method="POST">
                        <fieldset class="pure-group">
                            <input type="email" name="mail_to0" class="pure-input-1-2" placeholder="To"><span class="fas fa-plus-circle" id="plus-to"></span>
                            <input type="text" name="mail_subject" class="pure-input-1-2" placeholder="Subject">
                        </fieldset>
                        <fieldset class="pure-group">
                            <textarea class="pure-input-1" name="mail_content" placeholder="Your message"></textarea>
                        </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="button" class="pure-button button-small add-file" data-toggle="collapse" data-target="#collapseDrag" aria-expanded="false" aria-controls="collapseDrag">Add file <span class="fas fa-plus" id="plus-icon-file"></span><span id="file-icon" class="fas fa-file"></span></button>
                    <button type="button" id="draftIt" class="pure-button button-small">Save to draft</button>
                    <button type="button" id="timer" class="pure-button button-small">Timer <span id="time-icon" class="fas fa-stopwatch"></span></button>
                    <button type="button" id="close-btn" class="pure-button button-small" data-dismiss="modal">Close</button>
                    <button type="submit" id="send-btn" class="pure-button button-small  pure-button-primary">Send <span class="fas fa-paper-plane"></span></button>
                    </form>
                </div>
                <div class="collapse" id="collapseDrag">
                    <form class="box" method="post" action="" enctype="multipart/form-data">
                      <div id="dropfile" class="box__input">
                        <span class="fas fa-download drag-n-drop-icon"></span>
                        <p id="txt-drag">Drop a file from your computer</p>
                      </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>