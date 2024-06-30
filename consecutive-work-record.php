<?php

require 'functions.php';

// This 3rd challenge of the practical exam is basically asking to calculate
// the user's longest streak of consecutive workdays, given the start and
// end dates of each task. The streak is broken when the user doesn't have a task
// on a specific day.

// This is similar to how Duolingo's streak system works.

// My solution is to create a "calendar", an array of days where the user
// has tasks to do. To make the dates easier to understand, the indexes of
// the array correspond to the dates of the tasks. Each date is marked with
// the boolean "true" if the user has a task on that day. On days where the user
// doesn't have a task, the array element corresponding to the date remains unset.

$numberOfTasks = validateInput(
    "Number of tasks: ",
    fn ($input): bool => filter_var($input, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]),
    "Please enter a positive integer.\n"
);

$calendar = inputStartAndEndDates($numberOfTasks);

echo "Longest streak of consecutive workdays: " . countLongestStreak($calendar);


/**
 * Prompt the user to input the start & end dates of each task.
 */
function inputStartAndEndDates(int $numberOfTasks): array
{
    $calendar = [];

    for ($taskNumber = 1; $taskNumber <= $numberOfTasks; $taskNumber++) {

        $startDate = validateInput(
            "Task #" . $taskNumber . " start date: ",
            fn ($input): bool => filter_var($input, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]),
            "Please enter a positive integer.\n",
        );

        $endDate = validateInput(
            "Task #" . $taskNumber . " end date: ",
            fn ($input): bool => filter_var($input, FILTER_VALIDATE_INT, ['options' => ['min_range' => $startDate + 1]]),
            "Please enter a positive integer greater than the start date.\n"
        );

        for ($day = $startDate; $day <= $endDate; $day++) {
            $calendar[$day] = true;
        }
    }

    return $calendar;
}

function countLongestStreak(array $calendar): int
{
    $currentStreak = 0;
    $longestStreak = 0;

    for ($day = 1; $day <= array_key_last($calendar); $day++) {
        if (isset($calendar[$day])) {
            $currentStreak++;

            if ($currentStreak > $longestStreak) {
                $longestStreak = $currentStreak;
            }
        } else {
            $currentStreak = 0;
        }
    }

    return $longestStreak;
}
