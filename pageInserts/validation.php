<?php
// shared validation functions used across all form pages
// each function returns an error message string, or empty string if valid

// constants for validation rules
define('MAX_NAME_LENGTH', 50);
define('MAX_EMAIL_LENGTH', 100);
define('ALLOWED_SUBSCRIPTIONS', ['free', 'basic', 'premium']);
define('MIN_SEARCH_LENGTH', 2);

// trims whitespace and escapes html characters
function sanitize($input) {
    $input = trim($input);
    $input = htmlspecialchars($input);
    return $input;
}

// checks if a field is empty
function validateRequired($value, $fieldName) {
    if (empty(trim($value))) {
        return "$fieldName is required.";
    }
    return '';
}

// checks if email is a valid format using filter_var
function validateEmail($email) {
    if (empty(trim($email))) {
        return "Email is required.";
    }
    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        return "Please enter a valid email address.";
    }
    return '';
}

// checks if rating is a number and within the allowed range
function validateRating($rating, $min = 1.0, $max = 5.0) {
    if (empty(trim($rating))) {
        return "Rating is required.";
    }
    if (!is_numeric($rating)) {
        return "Rating must be a number.";
    }
    if ($rating < $min || $rating > $max) {
        return "Rating must be between $min and $max.";
    }
    return '';
}

// checks if a string is within a min and max length
function validateLength($value, $fieldName, $min = 1, $max = 255) {
    $len = strlen(trim($value));
    if ($len < $min) {
        return "$fieldName must be at least $min characters.";
    }
    if ($len > $max) {
        return "$fieldName must be no more than $max characters.";
    }
    return '';
}

// checks if value is one of the allowed subscription types
function validateSubscription($value, $allowed = ALLOWED_SUBSCRIPTIONS) {
    if (!in_array(strtolower($value), $allowed)) {
        return "Must be one of: " . implode(', ', $allowed) . ".";
    }
    return '';
}

// formats first and last name for display
function formatName($first_name, $last_name) {
    $first_name = ucwords(strtolower(trim($first_name)));
    $last_name = ucwords(strtolower(trim($last_name)));
    return $first_name . ' ' . $last_name;
}

// validates all user fields at once, returns array of error messages
// set $requireId to true when updating (need user id)
function validateUserData($data, $requireId = false) {
    $errors = [
        'first_name'        => '',
        'last_name'         => '',
        'email'             => '',
        'subscription_type' => ''
    ];

    // only check user_id if this is an update form
    if ($requireId) {
        $errors['user_id'] = validateInt(isset($data['user_id']) ? $data['user_id'] : '', 'User ID');
    }

    // check required fields first
    $errors['first_name'] = validateRequired($data['first_name'], 'First name');
    $errors['last_name']  = validateRequired($data['last_name'], 'Last name');
    $errors['email']      = validateEmail($data['email']);

    // then check lengths if the required checks passed
    if (!$errors['first_name']) {
        $errors['first_name'] = validateLength($data['first_name'], 'First name', 1, MAX_NAME_LENGTH);
    }
    if (!$errors['last_name']) {
        $errors['last_name'] = validateLength($data['last_name'], 'Last name', 1, MAX_NAME_LENGTH);
    }
    if (!$errors['email']) {
        $errors['email'] = validateLength($data['email'], 'Email', 1, MAX_EMAIL_LENGTH);
    }

    // check subscription is a valid option
    $errors['subscription_type'] = validateSubscription($data['subscription_type']);

    return $errors;
}

// checks if value is a whole number
function validateInt($value, $fieldName) {
    if (empty(trim($value))) {
        return "$fieldName is required.";
    }
    if (!is_numeric($value) || intval($value) != $value) {
        return "$fieldName must be a whole number.";
    }
    return '';
}
?>
