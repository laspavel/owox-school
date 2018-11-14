<?php

Class adm_articles
{
    private $recordsOnPage = 30;
    private $db;
    private $template;
    private $data;
    private $output;

    public function __construct($db)
    {
        $this->db = $db;
    }


    function getAdmArticlesList()
    {

        $this->template = 'articles_list';
        $this->render();

    }

    function getAdmArticlesNew()
    {
        $this->data['categories'] = $this->db->rawQuery('SELECT id,name FROM `categories`');
        $this->data['authors'] = $this->db->rawQuery('SELECT id,name FROM `authors`');
        $this->template = 'articles_form';
        $this->render();

    }

    function getAdmArticlesUpdate($id)
    {

        $post = $this->requestclean($_POST);

        if ((int)$id == 0) {
            $this->db->rawQueryOne("INSERT INTO `articles` (name, image, article_text) VALUES ('" . $post['name'] . "', '" . $post['image'] . "', '" . $post['article_text'] . "')");
        } else {
            $this->db->rawQueryOne("UPDATE `articles` SET `viewed`='0', `name`='" . $post['name'] . "', `image`='" . $post['image'] . "', `article_text`='" . $post['article_text'] . "' WHERE id=" . $id);
        }

        $this->data['success'] = 'Updated !';
        $this->template = 'articles_list';
        $this->render();

    }

    function requestclean($data)
    {

        if (is_array($data)) {
            foreach ($data as $key => $value) {
                unset($data[$key]);
                $data[$this->requestclean($key)] = $this->requestclean($value);
            }
        } else {
            $data = htmlspecialchars($data, ENT_COMPAT);
        }
        return $data;
    }

    function getAdmArticlesEdit($id)
    {

        $this->data['article'] = $this->db->rawQueryOne('SELECT id,name,article_text,category_id,author_id,image FROM `articles`  
WHERE id=' . (int)$id);
        $this->data['categories'] = $this->db->rawQuery('SELECT id,name FROM `categories`');
        $this->data['authors'] = $this->db->rawQuery('SELECT id,name FROM `authors`');

        $this->template = 'articles_form';
        $this->render();

    }

    function getAdmArticlesDelete($id)
    {

        $this->db->rawQueryOne('DELETE FROM `articles` WHERE id=' . (int)$id);
        $this->data['success'] = 'Deleted !';
        $this->template = 'articles_list';
        $this->render();

    }

/*
    function article_form($id)
    {

        $this->data['article'] = $this->db->rawQueryOne('SELECT id,name,article_text,image,viewed FROM `articles`  
WHERE id=' . (int)$id);
        $this->data['max_id'] = $this->db->rawQueryOne('SELECT COUNT(id) FROM `articles` LIMIT 1');
        $this->db->rawQuery('UPDATE `articles` SET `viewed` = ' . ($this->data['article']['viewed'] + 1) . ' WHERE `articles`.`id` = ' . (int)$id);
        $this->template = 'articles_form';
        $this->render();

    }
*/
    function getAdmArticles($page)
    {

        $this->data['page'] = (int)$page;
        $this->data['max_page'] = $this->db->rawQuery('SELECT CEILING(COUNT(id)/' . $this->recordsOnPage . ') FROM `articles` LIMIT 1');
        $this->data['articles'] = $this->db->rawQuery('SELECT `id`,`name` FROM `articles` WHERE id>' . ($this->data['page'] - 1) * $this->recordsOnPage . ' AND id<' . $this->data['page'] * $this->recordsOnPage);
        $this->template = 'articles_info';
        $this->render();
    }


    protected function render()
    {

        if (file_exists(__DIR__ . '/templates/' . $this->template . '.php')) {

            if (!empty($this->data)) {
                extract($this->data);
            }
            ob_start();

            require(__DIR__ . '/templates/' . $this->template . '.php');

            $this->output = ob_get_contents();

            ob_end_clean();

            echo $this->output;
        } else {
            echo json_encode($this->data,
                JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
        }
    }


}
