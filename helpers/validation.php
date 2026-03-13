<?php
function validatePostData(string $title, string $content): array
{
    $errors = [];
    $title = trim($title);
    $content = trim($content);

    if (empty($title)) $errors[] = "Titel mag niet leeg zijn.";
    if (strlen($title) > 150) $errors[] = "Titel mag maximaal 150 karakters bevatten.";
    if (empty($content)) $errors[] = "Content mag niet leeg zijn.";

    return $errors;
}
