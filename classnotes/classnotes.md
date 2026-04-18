# ITFN 2214 - Class Notes

---

## PHP Functions (2) — Thursday, March 19, 2026

### Simple Function Examples

```php
// simple function example
function display_store_name(){
    echo "Widgets &amp; McGuffins";
}

function get_store_name(){
    return "Widgets &amp; McGuffins";
}
```

```html
<p>The store is called <?= get_store_name() ?></p>
```

### Functions with Parameters

```php
function find_store_name($name){
    return "The store is $name.";
}

function display_product($name, $price){
    echo "<p>$name - \$$price</p>";
}

display_product("Sprocket", 4.99);
```

### Calculating Cost with Tax

```php
function calculate_cost($price, $quantity){
    $cost = $price * $quantity;
    $tax = $cost * (10/100);
    return $cost + $tax;
}
```

```html
<p>The cost of <?= $quantity ?> $<?= $item_cost ?> items with 
<?= $tax ?>% is <?= $result ?></p>
```

---

## PHP Functions (3) — Tuesday, March 24, 2026

*(No code notes recorded for this lecture.)*

---

## PHP Functions (4) — Thursday, March 26, 2026

### Constants, Built-In Functions, and Debugging

```php
<?php
$title = "Built-In Function Examples";
include "example_header.php";

define('DRINKING_AGE', 21);
define('DEFAULT_LANG', 'English');

$shopping_list = ['eggs', 'milk', 'butter'];
$pangram = '   The wizard quickly jinxed the gnomes before they 
vaporized!   ';
?>
```

```html
<body>
<p>The legal drinking age is <?= DRINKING_AGE ?>.</p>
<p>Shopping list: <?php print_r($shopping_list) ?></p>
<p>Dump of shopping list:</p>
<?php var_dump($shopping_list) ?>
<p>Phrase: <?= $pangram ?></p>
<p>Phrase: <?php var_dump($pangram) ?></p>
```

### String Functions

```html
<p><?= $pangram ?> has <?= strlen($pangram) ?> characters.</p>
<p><?= $pangram ?> has <?= str_word_count($pangram) ?> words.</p>
<p><?= $pangram ?> all lowercase = <br> 
       <?= strtolower($pangram) ?></p>
<p><?= $pangram ?> all uppercase = <br>
       <?= strtoupper($pangram) ?></p>
<p><?= $pangram ?> with first letter of each word <br> 
       <?= ucwords($pangram) ?></p>
```

### Trimming Strings

```html
<p><?= strlen(trim($pangram)) ?></p>
<p><?= strlen(ltrim($pangram)) ?></p>
<p><?= strlen(rtrim($pangram)) ?></p>
<p><?= trim('//clayton.edu/cims/', '/'); ?></p>
</body>
</html>
```

---

## PHP Functions (5) — Tuesday, March 31, 2026

### String Searching, Splitting, and Formatting

```php
if(str_contains($trimmed, "Wizard")){
    echo "There's a wizard here!";
}else{
    echo "These are not the wizards you're looking for.";
}
```

```php
<?php
$shopping_list = ['eggs', 'milk', 'butter'];
$pangram = '   The wizard quickly jinxed the gnomes before they 
vaporized!   ';
$trimmed = trim($pangram);

$split_str = explode(" ", $trimmed);
$list = implode($shopping_list);
$empty_list = [];
$empty = implode($empty_list);

$price = 9503.5;
$item = 'Gnome Vaporizer 3000';
?>
```

```html
<p><?= var_dump($split_str) ?></p>
<p>The imploded list is <?= $list ?></p>
<p>The empty imploded list is <?= $empty ? 'true' : 'false' ?></p>
<p>Item Details: <br>
<?= sprintf("The %s costs %f.", $item, $price) ?><br>
<?= sprintf("The %s costs %.2f.", $item, $price) ?>
</p>
```

---

## Regular Expressions (1) — Thursday, April 2, 2026

### Basic Pattern Matching

Reference: https://regex101.com/

```php
<?php
$kernel_patt = '/kern.l/';
?>
```

```html
<p>kernel: <?= preg_match($kernel_patt, 'kernel') ?></p>
<p>kern!l: <?= preg_match($kernel_patt, 'kern!l') ?></p>
<p>kernel mode: <?= preg_match('/...../', 'kernel mode') ?></p>
```

### Anchors

```php
$url = "http://www.clayton.edu";
```

```html
<h2>Anchors</h2>
<p><strong>Does <?= $url ?> start with http?</strong>
<?= preg_match('/^http/', $url) ?></p>

<p><strong>Does <?= $url ?> start with https?</strong>
<?= preg_match('/^https/', $url) ?></p>

<p><strong>Does <?= $url ?> end with .edu?</strong>
<?= preg_match('/.edu$/', $url) ?></p>

<p><strong>Does http://www.clayton*edu end with .edu?</strong>
<?= preg_match('/\.edu$/', 'http://www.clayton*edu') ?></p>
```

---

## Regular Expressions (2) — Tuesday, April 7, 2026

### Metacharacter Reference Table

| Metacharacter | Description |
|---|---|
| `/./ ` | Matches any character |
| `/doozy/` | Matches exactly these characters |
| `/^We/` | Matches any string that starts with these characters |
| `/day$/` | Matches any string that ends with these characters |
| `/!?/` | The character before the `?` is optional |
| `/o+/` | The character before the `+` appears one or more times |
| `/o*/` | The character before the `*` appears zero or more times |
| `/ab{3}/` | The character before the `{n}` appears at least n times |
| `/ab{3,5}/` | Indicates minimum and maximum number of times a character appears |
| `/(ab)cd/` | Parentheses form groups |
| `/[aeiou]/` | Character classes specifies options |
| `/[a-z]/` or `/[0-9]/` | Indicate a range with a hyphen |
| `/[^a-e]/` | Exclude the characters in this range |
| `/[1-31](st\|nd\|rd\|th)$/` | `\|` indicates a logical OR |

---

## Regular Expressions (3) + User Input (1) — Thursday, April 9, 2026

### Specifying Options with `|`

```html
<h2>Specifying Options with |</h2>
<p><strong>clayton.edu</strong>
<?= preg_match('/\.(com|edu|org|gov)$/', 'www.clayton.edu') ?>
</p>
<p><strong>something.net</strong>
<?= preg_match('/\.(com|edu|org|gov)$/', 'something.net') ?>
</p>
<p><strong>ghc.anitab.org</strong>
<?= preg_match('/\.(com|edu|org|gov)$/', 'ghc.anitab.org') ?>
</p>
```

### HTML Forms & GET Requests

Query string example:
`https://clayton.edu/search/index.php?q=cstem+symposium`

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Example for User Input</title>
</head>
<body>
    <form action="example_handler.php" method="get">
        <label for="name">Genre Name:
            <input type="text" id="name" name="genre">
        </label>
        <input type="submit" name="Add Genre">
    </form>
</body>
</html>
```

Resulting URL:
`http://localhost/2026-spring/example_handler.php?genre=Action&Add+Genre=Submit`

### Handling User Input & Validation

```php
<?php
$genre = $_GET['genre'];
echo "The genre is $genre";

function is_valid_genre($genre){
    $error = '';
    // check the genre is not empty
    // and that it has at least 1, but no more than
    // 50 characters
    // if true -- no error
    // if not -- return appropriate error message
    if(empty($genre)){
        $error = 'Genre must not be empty.';
    }
    if(!(empty) && preg_match('/[a-zA-Z]{1, 50}/', $genre) == 0){
        $error = 'Genre must be between 1 and 50 letters';
    }
    return array($error, $genre);
}
?>
```

---

## PHP User Input (2) — Tuesday, April 14, 2026

### Validation Functions

```php
<?php
// file for validation functions

// validate movie title
function is_valid_title($title){
    // what is a valid movie title?
    // letters, numbers, ', !, ?, ,, spaces, &, -, :
    $error = '';
    if(empty($title)){
        $error = 'Movie title required.';
    }else if(preg_match('/^[a-zA-Z0-9 !:&\?\'\.,-]+$/', $title) == 0){
        $error = 'Title invalid.';
    }
    return $error;
}

// validate release year
function is_valid_year($year){
    // check if is int and in valid range
    $error = '';
    $valid = filter_var($year, FILTER_VALIDATE_INT, [
        'options' => ['min_range'=>1888, 'max_range'=>2030]
    ]);
    if($valid === false){
        $error = 'Must be between 1888 and 2030';
    }
    return $error;
}
```
