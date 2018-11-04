<?php

$categories=35;
$authors=5010;
$articles=501000;

//***************************************
require_once 'vendor/autoload.php';
$faker = Faker\Factory::create('ru_RU');
$db = new MysqliDb ('localhost', 'myproject', '2Ple86kcJZibGC5y', 'myproject');

echo PHP_EOL."Truncate tables ... ....";
$db->rawQuery("TRUNCATE TABLE `articles`");
$db->rawQuery("TRUNCATE TABLE `authors`");
$db->rawQuery("TRUNCATE TABLE `categories`");
echo "\033[5D"." done";

echo PHP_EOL."Filling table authors ... ....";
for ($i=1; $i < $authors; $i++) {
    $max_author = $db->insert('authors',array('name'=>$faker->firstName.' '.$faker->lastName));
    echo "\033[5D".str_pad((int)($i*100/$authors), 3, ' ', STR_PAD_LEFT) . " %";
}
echo "\033[5D"." done";

echo PHP_EOL."Filling table categories ... ....";
for ($i=1; $i < $categories; $i++) {
    $max_category = $db->insert('categories', array('name' => $faker->unique()->word));
    echo "\033[5D".str_pad((int)($i*100/$categories), 3, ' ', STR_PAD_LEFT) . " %";
}
echo "\033[5D"." done";

echo PHP_EOL."Filling table articles ... ....";
for ($i=1; $i < $articles; $i++) {
    $db->insert('articles', array(
        'name'=>$faker->sentence,
        'article_text'=>$faker->paragraph($nbSentences = 3, $variableNbSentences = true),
        'author_id'=>$faker->numberBetween(1,$max_author),
        'category_id'=>$faker->numberBetween(1,$max_category),
        'image'=>$faker->imageUrl(640, 480, 'cats'),
        'viewed'=>$faker->numberBetween(1,1000),
        'published'=>$faker->dateTimeThisCentury($max = 'now')->format('Y-m-d h:i:s'),
    ));

    echo "\033[5D".str_pad((int)($i*100/$articles), 3, ' ', STR_PAD_LEFT) . " %";
}
echo "\033[5D"." done".PHP_EOL;

?>

