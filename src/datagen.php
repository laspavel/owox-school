<?php

$maxCategories = 35;
$maxAuthors = 5010;
$maxArticles = 501000;

require_once 'vendor/autoload.php';
require_once 'config.php';

$faker = Faker\Factory::create('ru_RU');
$db = new MysqliDb (DB['host'], DB['username'], DB['password'], DB['dbname']);
$dbs = new MysqliDb (DBS['host'], DBS['username'], DBS['password'], DBS['dbname']);
$sql='CREATE TABLE IF NOT EXISTS `articles` (';
$sql.='`id` int(11) NOT NULL AUTO_INCREMENT,';
$sql.='`name` varchar(200) NOT NULL,';
$sql.='`article_text` text NOT NULL,';
$sql.='`author_id` int(5) NOT NULL,';
$sql.='`category_id` int(3) NOT NULL,';
$sql.='`image` varchar(255) NOT NULL,';
$sql.='`viewed` int(6) NOT NULL,';
$sql.='`published` datetime NOT NULL,';
$sql.='PRIMARY KEY (`id`)';
$sql.=') ENGINE=InnoDB DEFAULT CHARSET=utf8; ';
$sql.='CREATE TABLE IF NOT EXISTS `authors` (`id` int(11) NOT NULL AUTO_INCREMENT,';
$sql.='`name` varchar(100) NOT NULL, PRIMARY KEY (`id`) ENGINE=InnoDB DEFAULT CHARSET=utf8; ';
$sql.='CREATE TABLE IF NOT EXISTS `categories` (`id` int(11) NOT NULL AUTO_INCREMENT,';
$sql.='`name` varchar(100) NOT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;';

$db->rawQuery($sql);

$authors = array();

for ($i = 1; $i < $maxAuthors; $i++) {
    $authors[] = array('name' => $faker->firstName . ' ' . $faker->lastName);
}$db->insertMulti('articles', $articles);
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

$sqls='DROP TABLE IF EXISTS `articles`;';
$sqls.='CREATE TABLE `articles` (';
$sqls.='`id` int(11) NOT NULL AUTO_INCREMENT,';
$sqls.='`name` varchar(200) NOT NULL,';
$sqls.='`category_id` int(3) NOT NULL,';
$sqls.='`viewed` int(6) NOT NULL,';
$sqls.='PRIMARY KEY (`id`)';
$sqls.=') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
$dbs->rawQuery($sqls);

$dbs->insertMulti('articles', $articles);

/*
array_map(function($value) {
    unset ($value['article_text']);
    unset ($value['author_id']);$sqls='DROP TABLE IF EXISTS `articles`;'
    unset ($value['image']);
    unset ($value['published']);
    return $value;
},$articles, );
*/

echo "All done.";

?>

