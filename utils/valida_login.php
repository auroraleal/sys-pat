<?php

if (!isset($_SESSION['email']) && !isset($_SESSION['perfil'])) {
	header('Location: /sys-pat/pages/login.php');
}

?>