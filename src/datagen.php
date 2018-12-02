<?php

require_once 'vendor/autoload.php';
require_once 'config.php';

if ((DEMODATA['Authors'] > 0) && (DEMODATA['Categories'] > 0)) {

    $faker = Faker\Factory::create('ru_RU');
    $db = new MysqliDb (DB['host'], DB['username'], DB['password'], DB['dbname']);
    $dbs = new MysqliDb (DBS['host'], DBS['username'], DBS['password'], DBS['dbname']);

    $countRecord = ($db->rawQueryOne('SELECT COUNT(id) as countrecord FROM `articles` LIMIT 1'))['countrecord'];
    if ($countRecord == 0) {

        $authors = array();

        for ($i = 0; $i < DEMODATA['Authors']; $i++) {
            $authors[] = array('name' => $faker->firstName . ' ' . $faker->lastName);
        }
        $maxAuthorId = max($db->insertMulti('authors', $authors));
        unset($author);

        $category = array();
        for ($i = 0; $i <= DEMODATA['Categories']; $i++) {
            $category[] = array('name' => $faker->unique()->word);
        }

        $maxCategoryId = max($db->insertMulti('categories', $category));
        unset($category);

        if (DEMODATA['Articles'] > 0) {
            $articles = array();

            echo "Generating data articles ...\n";

            for ($i = 0; $i <= DEMODATA['Articles']; $i++) {
                $articles[] = array(
                    'name' => $faker->sentence,
                    'article_text' => $faker->paragraph(3, true),
                    'author_id' => $faker->numberBetween(1, $maxAuthorId),
                    'category_id' => $faker->numberBetween(1, $maxCategoryId),
                    'image' => $faker->imageUrl(640, 480, 'cats'),
                    'viewed' => $faker->numberBetween(1, DEMODATA['Articles']),
                    'published' => $faker->dateTimeThisYear('now')->format('Y-m-d h:i:s'),
                );
            }

            echo "Saving in table ... \n";

            $db->insertMulti('articles', $articles);
            $articles = array_map(function ($value) {
                unset($value['article_text']);
                unset($value['author_id']);
                unset($value['image']);
                unset($value['published']);
                return $value;
            }, $articles);

            $dbs->insertMulti('articles', $articles);
        }
    }
}
echo "All done.";

?>

