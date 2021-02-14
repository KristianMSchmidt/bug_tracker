<?php
require('shared/post_check.inc.php');
require_once('form_handlers/AddCommentHandler.class.php');
session_start();

$comment_handler = new AddCommentHandler($_POST);
$_SESSION['errors'] = $comment_handler->add_comment();

header("location: ../view/ticket_details.php?ticket_id={$_POST['ticket_id']}");
