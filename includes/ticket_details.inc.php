<?php
if (isset($_POST['new_comment'])) {
    include('../classes/form_handlers/AddCommentHandler.class.php');
    $comment_handler = new AddCommentHandler($_POST);
    $comment_handler->process_input();
}
