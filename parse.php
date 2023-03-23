<?php

//Funkcija za brojanje suglasnika
function vowelCounter(string $word) {
    $vowelCount = 0;
    $vowel = ['a','e','i','o','u'];
    foreach ($vowel as $appearance) {
        //Brojanje preko subrst_count-a koji je case-sensitive stoga je dodan strtolower
        $vowelCount += substr_count(strtolower($word), $appearance);
    }
    return $vowelCount;    
}

//Unos
$word = $_POST["word"];

//Error handling za prazan unos
if(!$word) {
    echo "<h3>Polje za unos ne može biti prazno!</h3>\n";
    echo "<button onclick='history.go(-1);'>Povratak na unos </button>";
}

//Logika za točan unos
else if(ctype_alpha($word)) {
    //Broj slova u riječi
    $numLetter = strlen($word);

    //Poziv funkcije za brojanje samoglasnika
    $numVowels = vowelCounter($word);

    //Izračun suglasnika na temelju samoglasnika
    $numConsonants = $numLetter - $numVowels;

    //Json decoding, encoding uz pospremanje unosa
    $wordsJson = file_get_contents('words.json');

    $wordsArr = json_decode($wordsJson, true);

    $wordsArr[] = [
        'word' => $word,
        'numLetter' => $numLetter,
        'numVowel' => $numVowels,
        'numConsonant' => $numConsonants
    ];

    $wordsJson = json_encode($wordsArr);

    file_put_contents('words.json', $wordsJson);

    //Funkcija vraća na početnu s novozapisanim unosom
    header("Location: index.php");
}

//Error handling za ostale slučajeve (brojevi, whitespaces)
else {
    echo "<h3>Došlo je do greške pri unosu. Provjerite jeste li ispunili sljedeće uvjete:</h3>\n";
    echo "<ol><li>Unos mora bitit SAMO 1 riječ - bez razmaka.</li>";
    echo "<li>Unos ne smije sadržavati brojeve!</li>";
    echo "<li>Unos mora biti isključivo u slovima američke abecede.</li></ol>";
    echo "<button onclick='history.go(-1);'>Povratak na unos </button>";
}