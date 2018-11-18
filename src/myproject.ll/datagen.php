<?php

$maxCategories = 35;
$maxAuthors = 5010;
$maxArticles = 501000;

require_once 'vendor/autoload.php';
$faker = Faker\Factory::create('ru_RU');
$db = new MysqliDb ('localhost', 'myproject', '2Ple86kcJZibGC5y', 'myproject');

$db->rawQuery('TRUNCATE TABLE `authors`');
$db->rawQuery('TRUNCATE TABLE `articles`');
$db->rawQuery('TRUNCATE TABLE `categories`');
$authors = array();

for ($i = 1; $i < $maxAuthors; $i++) {
    $authors[] = array('name' => $faker->firstName . ' ' . $faker->lastName);
}
$maxAuthorId = max($db->insertMulti('authors', $authors));
unset($author);

$category = array();
for ($i = 1; $i < $maxCategories; $i++) {
    $category[] = array('name' => $faker->unique()->word);
}

$maxCategoryId = max($db->insertMulti('categories', $category));
unset($category);

$articles = array();

echo "Generating data articles ...\n";

for ($i = 1; $i < $maxArticles; $i++) {
    $articles[] = array(
        'name' => $faker->sentence,
        'article_text' => $faker->paragraph(3, true),
        'author_id' => $faker->numberBetween(1, $maxAuthorId),
        'category_id' => $faker->numberBetween(1, $maxCategoryId),
        'image' => $faker->imageUrl(640, 480, 'cats'),
        'viewed' => $faker->numberBetween(1, 1000),
        'published' => $faker->dateTimeThisCentury('now')->format('Y-m-d h:i:s'),
    );
}

echo "Saving in table ... \n";

$db->insertMulti('articles', $articles);

echo "All done.";

?>

