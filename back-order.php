<?php

require 'functions.php';

$numberOfStudents = validateInput(
    "Number of students: ",
    fn ($input): bool => filter_var($input, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]),
    "Please enter a positive integer.\n"
);

$students = inputStudents($numberOfStudents);
$students = sortStudents($students);
displayListOfStudents($students);


/**
 * Prompt the user to input student details.
 */
function inputStudents(int $numberOfStudents): array
{
    $students = [];

    for ($i = 0; $i < $numberOfStudents; $i++) {
        $name = validateInput(
            "Name of student #" . $i + 1 . " (all lowercase): ",

            // Check if all of the characters in the provided string are alphabetic, lowercase,
            // and if the string (i.e. student's name) doesn't already exist in the current list.
            fn ($input): bool => ctype_alpha($input) && ctype_lower($input) && !in_array($input, array_column($students, 'name')),

            "Either you entered an invalid name or it is already listed.\n"
        );

        $height = validateInput(
            "$name's height (cm): ",
            fn ($input): bool => filter_var($input, FILTER_VALIDATE_FLOAT, ['options' => ['min_range' => 1]]),
            "Invalid height.\n"
        );

        $birthMonth = validateInput(
            "$name's birth month (1-12): ",
            fn ($input): bool => filter_var($input, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 12]]),
            "Invalid birth month. Please enter the month as a number (1-12).\n"
        );

        array_push($students, [
            'name' => $name,
            'height' => (int) $height,
            'birthMonth' => (int) $birthMonth,
        ]);
    }

    return $students;
}

/**
 * Sort the students according to the criteria
 * described in the practical exam, taking advantage
 * of PHP's built-in `usort` function.
 */
function sortStudents(array $students): array
{
    usort($students, function ($a, $b) {
        // Firstly, compare 2 students ($a and $b) based on their height.
        if ($a['height'] !== $b['height']) {
            return $a['height'] <=> $b['height'];
        }

        // If student $a's height is equal to student $b's height,
        // compare their birth months.
        if ($a['birthMonth'] !== $b['birthMonth']) {
            return $b['birthMonth'] <=> $a['birthMonth'];
            // Student $b is on the left side of the
            // spaceship operator to make sure that birth months
            // are sorted in descending order.
        }

        // Finally, if their height and birth month are the same,
        // compare/sort them alphabetically.
        return strcmp($a['name'], $b['name']);
        // Taking advantage of PHP's built-in `strcmp` function
        // that acts like a spaceship operator, but compares
        // strings alphabetically.
    });

    return $students;
}

function displayListOfStudents(array $students): void
{
    echo "LIST OF STUDENTS:\n";

    foreach ($students as $student) {
        echo $student['name'] . "\n";
    }
}
