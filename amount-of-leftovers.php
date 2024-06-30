<?php

require 'functions.php';

$freshFood = validateInput(
    "Weight of fresh food (kg): ",
    fn ($input): bool => filter_var($input, FILTER_VALIDATE_FLOAT) && $input > 0,
    "Please enter a positive amount.\n"
);

$freshFoodSold = $freshFood * (promptPercentage("Percentage of fresh/raw food sold (%): ") / 100);
$freshFoodUnsold = $freshFood - $freshFoodSold;
$sideDishesSold = $freshFoodUnsold * (promptPercentage("Percentage of side dishes sold (%): ") / 100);

echo "UNSOLD QUANTITY (kg): " . ($freshFoodUnsold - $sideDishesSold);


/**
 * Prompt the user to enter a percentage (without the percent sign)
 * to be used for the calculations.
 */
function promptPercentage(string $prompt)
{
    return validateInput(
        $prompt,
        fn ($input): bool => filter_var($input, FILTER_VALIDATE_FLOAT) && $input > 0,
        "Please enter a positive number.\n"
    );
}
