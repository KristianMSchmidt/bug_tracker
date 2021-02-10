<?php
if (isset($_POST['new_comment'])) {
    include('../classes/form_handlers/AddCommentHandler.class.php');
    session_start();
    $comment_handler = new AddCommentHandler($_POST);
    $_SESSION['errors'] = $comment_handler->add_comment();
    header("location: ../views/ticket_details.php?ticket_id={$_POST['ticket_id']}");
}
