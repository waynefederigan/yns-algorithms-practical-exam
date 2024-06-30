<?php

// Because the three CLI-related challenges in the practical exam involve
// user input on the command line, I've decided to extract a simple validation code
// to a separate file, so I can reuse it on all three challenges.

/**
 * Validate user's input.
 *
 * @param  string  $prompt  The prompt for the expected input.
 * @param  \Closure  $validator  The validation rules.
 */
function validateInput(string $prompt, \Closure $validator, string $errorMessage)
{
    do {
        echo $prompt;
        $input = trim(fgets(STDIN));

        if ($validator($input) === false) {
            echo $errorMessage;
        }
    } while (!$validator($input));

    return $input;
}