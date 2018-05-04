<?php
include ('labels.php');
$label = new labels();
$label->create_labels();
header ('location: ../view/mail.php');
?>