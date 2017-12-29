<?php

const ALPHABET = ["a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z"];

$command = readline("Command: ");

switch ($command) {
  case "cryp":
    $text = readline("text: ");
    $key = intval(readline("key: "));
    echo cryp($text, $key);
    echo "\n";
    break;
  case "decryp":
    $text = readline("text: ");
    $key = intval(readline("key: "));
    echo decryp($text, $key);
    echo "\n";
    break;
  case "try-decryp":
    $text = readline("text: ");
    echo tryDecryp($text);
    echo "\n";
    break;
  default:
    echo "Unknown command " . $command;
    break;

}

function cryp($text, $key)
{
  $caesarAlphabet = getCaesarAlphabet($key);
  $letters = str_split($text);
  $crypt = implode(crypLetters($letters, $caesarAlphabet));
  return $crypt;
}

function crypLetters($letters, $caesarAlphabet)
{
  $newLetters = [];
  foreach ($letters as $index => $letter) {
    $newLetter = getCaesarLetterByAlphabeticLetter($letter, $caesarAlphabet);
    $newLetters[$index] = $newLetter;
  }
  return $newLetters;

}

function getCaesarLetterByAlphabeticLetter($letter, $caesarAlphabet)
{
  $letter = strtolower($letter);
  if (in_array($letter, ALPHABET)) {
    $alphabetIndex = array_search($letter, ALPHABET);
    return $caesarAlphabet[$alphabetIndex] ? $caesarAlphabet[$alphabetIndex] : $letter;
  } else {
    return $letter;
  }
}

function decryp($crypt, $key)
{
  $caesarAlphabet = getCaesarAlphabet($key);
  $letters = str_split($crypt);
  $text = implode(decrypLetters($letters, $caesarAlphabet));
  return $text;
}

function decrypLetters($letters, $caesarAlphabet)
{
  $oldLetters = [];
  foreach ($letters as $index => $letter) {
    $oldLetter = getAlphabeticLetterByCaesarLetter($letter, $caesarAlphabet);
    $oldLetters[$index] = $oldLetter;
  }
  return $oldLetters;

}

function getAlphabeticLetterByCaesarLetter($letter, $caesarAlphabet)
{
  $letter = strtolower($letter);
  if (in_array($letter, $caesarAlphabet)) {
    $alphabetIndex = array_search($letter, $caesarAlphabet);
    return ALPHABET[$alphabetIndex] ? ALPHABET[$alphabetIndex] : $letter;
  } else {
    return $letter;
  }
}

function tryDecryp($crypt)
{
  for ($i = 0; $i < count(ALPHABET); $i++) {
    $caesarAlphabet = getCaesarAlphabet($i);
    $letters = str_split($crypt);
    $text = implode(decrypLetters($letters, $caesarAlphabet));
    if (isText($text)) {
      echo "\n";
      echo "key was " . $i;
      echo "\n";
      return $text;
    }
  }

}

function isText($text)
{
  $countOfLettersInText = [];
  foreach (ALPHABET as $letter) {
    $countOfLettersInText[$letter] = countOccurrenceOfLetterInText($letter, $text);
  }
  asort($countOfLettersInText, SORT_NUMERIC);
  $biggestCountLetter = "";
  $biggestCount = 0;
  foreach ($countOfLettersInText as $letter => $count) {
    if ($count > $biggestCount){
      $biggestCount = $count;
      $biggestCountLetter = $letter;
    }
  }
  return $biggestCountLetter === "e";
}


function countOccurrenceOfLetterInText($letter, $text)
{
  $count = 0;
  foreach (str_split($text) as $textLetter) {
    if ($textLetter === $letter) {
      $count++;
    }
  }
  return $count;
}
function getCaesarAlphabet($key)
{
  $caesarAlphabet = [];
  foreach (ALPHABET as $index => $letter) {
    if ($index < $key) {
      $caesarAlphabet[count(ALPHABET) - ($key - $index)] = $letter;
    } else {
      $caesarAlphabet[$index - $key] = $letter;
    }
  }
  return $caesarAlphabet;
}

function printAlphabet($alphabet)
{
  for ($i = 0; $i < count($alphabet); $i++) {
    echo $alphabet[$i];
  }
  echo "\n";
}