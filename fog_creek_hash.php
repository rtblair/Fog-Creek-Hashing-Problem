<?php

/**
 * Solves Fog Creek hashing question at http://www.fogcreek.com/jobs/SoftwareDeveloper.
 * @param $target_hash - the hash integer to solve for.
 * @param $allowed_characters - domain of allowed characters
 * @param $target_keyword_length - number of letters the target keyword should be
 * @param bool $show_work - determine whether calculation steps should be printed with output.
 */
function keyword_generator($target_hash = 945924806726376, $allowed_characters = 'acdegilmnoprstuw', $target_keyword_length = 9, $show_work=TRUE) {

	$i = 0;
	$keyword_index_array = array();
    if ($show_work == TRUE) {
        print_r ($target_hash);
        echo "\n";
    }

	// $target_hash is a multiplicative function of the
    // length of the target keyword. Loop in reverse.
    
	while ( $i <= ($target_keyword_length - 1)) {
		$allowed_character_iterator = 0;
        $allowed_character_length = strlen($allowed_characters);
        // There are [$allowed_character_length] possible string indices to
        // subtract from the hash before dividing by 37. Try each
        // until one is found that is a factor of 37.
		while ($allowed_character_iterator < ($allowed_character_length-1)) {
			$offset = $target_hash - $allowed_character_iterator;
			if ($offset % 37 == 0) {
				$keyword_index_array[$i] = $allowed_character_iterator;
				break;
			}
			else {
				$allowed_character_iterator++;
			}
		}
		// Once the right index is found, subtract it from the
        // hash and divide by 37. Repeat until target keyword length
        // has been covered.
		$step = $target_hash - $keyword_index_array[$i];
		$target_hash = $step / 37;

        if ($show_work == TRUE) {
            // Per Fog Creek's hashing function, the base multiplier
            // should be "7".
    		if ($target_hash == 7) {
		        echo "Base multiplier 7 reached. \n";
            }
            else {
                print_r($target_hash);
                echo "\n";
            }

        }
		$i++;
	}

    // Map the index to letters.
	$word = array();
	foreach ($keyword_index_array as $key => $value) {
	    // Reverse the order in which they're stored in $keyword_index_array.
		array_unshift($word, substr($allowed_characters, $value, 1));
	}

	// CLI-friendly output.
	echo "The keyword is \"";
	foreach ($word as $key => $value) {
	    echo $value;
    }
    echo ".\"\n";

}


keyword_generator();

