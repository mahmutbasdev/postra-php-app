<?php
function addFlash(string $type, string $message): void
{
    $_SESSION[$type][] = $message;
}
