<?php

// Function to generate lorem ipsum dummy text
function lorem($data_type, $length)
{
    $allowed_data_type = ["p", "w", "c"];
    $text_file = __DIR__."/lorem.txt";
    $lorem_text = "";
    $data_type = strtolower($data_type);
    
    // Validates if supported data_type request.
    if (!in_array($data_type, $allowed_data_type, true)) {
        throw new InvalidArgumentException("Invalid first argument. 'p' for paragraph and 'w' for words and 'c' for characters");
    }

    $opened_file = fopen($text_file, "r"); // Opening the text content file

    // Words
    // Words are counted as spaces found. Number of space equals to number of words read
    if ($data_type === "w") {
        $word_num = 0;
        while ($word_num < $length) {
            $character = fgetc($opened_file);
            $lorem_text .= $character;
            // Increments the word_number when encounters a whitespace
            if (preg_match("/\s/", $character)) {
                $word_num++;
            }
        }
    }

    // Characters
    elseif ($data_type === "c") {
        $lorem_text .= fread($opened_file, $length);
    }
    
    // Paragraphs
    elseif ($data_type === "p") {
        for ($i = 0; $i < $length; $i++) {
            $lorem_text .= fgets($opened_file);
            if (feof($opened_file)) { //reopens the file, when reachs the end
                $opened_file = fopen($text_file, "r");
            }
        }
    }

    fclose($opened_file);
    return nl2br($lorem_text);
}


// Function to create HTML text content wrapped with a tag
function lorem_heading($content, $HTMLtag = "p", $classes = "", $loop = 1)
{
    //create class attribute with classes
    $class_set = $classes === "" ? "" : "class='" . $classes . "'";

    //To loop the heading 
    for ($i = 0; $i < $loop; $i++) {
        echo "<$HTMLtag $class_set>$content</$HTMLtag>";
    }
}



