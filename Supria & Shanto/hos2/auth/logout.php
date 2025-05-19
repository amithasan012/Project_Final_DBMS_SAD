<?php
session_start();
session_destroy();
header('Location: /hos2/index.php');
exit();