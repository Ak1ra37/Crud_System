<?php
// ============================================
// ARQUIVO: logout.php
// REQUISITO: 3 (Sessão)
// O QUE FAZ: Encerra sessão e apaga o cookie do tema.
// ============================================

session_start();
session_destroy();                                      // Encerra a sessão
setcookie('tema_usuario', '', time() - 3600, "/");      // Apaga o cookie
header("Location: login.php");
exit;