<?php
function createSlug(string $title): string
{
  if (empty($title)) return '';
  $slug = transliterator_transliterate('Any-Latin; Latin-ASCII; Lower()', $title);
  $slug = preg_replace('/[^a-z0-9-]+/', '-', $slug);
  $slug = preg_replace('/-+/', '-', $slug);
  $slug = trim($slug, '-');
  return $slug;
}
