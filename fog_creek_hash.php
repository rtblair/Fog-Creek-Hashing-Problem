<?php

/**
 * PHP solution to Fog Creek hashing question at http://www.fogcreek.com/jobs/SoftwareDeveloper.
 *
 * @param $target_hash           Hash integer to solve for.
 * @param $allowed_characters    Domain of allowed characters.
 * @param $target_keyword_length Number of letters the target keyword should be.
 * @param bool $show_work        Determine whether calculation steps should be printed with output.
 */
function keyword_generator($target_hash = 945924806726376, $allowed_characters = 'acdegilmnoprstuw', $target_keyword_length = 9, $show_work = TRUE) {

    $i = 0;
    $keyword_index_array = array();
   // ($show_work == TRUE) ? show_work($target_hash) : '';

    /* $target_hash is a multiplicative function of the
    length of the target keyword. Loop in reverse. */


    while ($i <= ($target_keyword_length - 1)) {
        $allowed_character_iterator = 0;
        $allowed_character_length = strlen($allowed_characters);

        /**
         * There are [$allowed_character_length] possible string indices
         * to subtract from the hash before dividing by 37. Try each
         * until one is found that is a factor of 37.
         */

        while ($allowed_character_iterator < ($allowed_character_length - 1)) {
            $offset = $target_hash - $allowed_character_iterator;
            if ($offset % 37 == 0) {
                $keyword_index_array[$i] = $allowed_character_iterator;
                break;
            } else {
                $allowed_character_iterator++;
            }
        }

        /**
         * Once the correct index is found, subtract it from the
         * hash and divide by 37. Repeat until target keyword length
         * has been covered.
         */

        $step = $target_hash - $keyword_index_array[$i];
        $step2 = $step / 37;
        ($show_work == TRUE) ? show_calc_steps($target_hash, $keyword_index_array[$i], $step, $step2) : '' ;

        $target_hash = $step2;
        $i++;


    }

    // Map the index to letters.
    $word = array();
    foreach ($keyword_index_array as $key => $value) {
        // Reverse the order in which they're stored in $keyword_index_array.
        array_unshift($word, substr($allowed_characters, $value, 1));
        ($show_work == TRUE) ? print( "[" .$value . "] => " . $word[0] . "\n"): '' ;

    }

    // Generate CLI-friendly output.
    echo "The keyword is \"";
    foreach ($word as $key => $value) {
        echo $value;
    }
    echo ".\"\n";

}

function show_calc_steps($target_hash, $keyword_index, $step, $step2) {
    // Per Fog Creek's hashing function, the base multiplier
    // should be "7".

    print (number_format($target_hash) . " - [" . $keyword_index . "] = " . number_format($step) . "\n" . number_format($step) ." / 37 = " . number_format($step2) . "\n");
    echo "\n";
}


keyword_generator();

