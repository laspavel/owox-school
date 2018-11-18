<?php

Class AdmArticles
{
    const recordsOnPage = 30;

    private $db;
    private $data;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAdmArticlesList()
    {
        $this->render('articles_list');
    }

    public function getAdmArticlesNew()
    {
        $this->data['categories'] = $this->db->rawQuery('SELECT id,name FROM `categories`');
        $this->data['authors'] = $this->db->rawQuery('SELECT id,name FROM `authors`');
        $this->render('articles_form');

    }

    public function getAdmArticlesUpdate($id)
    {

        $post = $this->requestclean($_POST);

        if ((int)$id == 0) {
            $this->db->rawQueryOne("INSERT INTO `articles` (name, image, article_text) VALUES ('" . $post['name'] . "', '" . $post['image'] . "', '" . $post['article_text'] . "')");
        } else {
            $this->db->rawQueryOne("UPDATE `articles` SET `viewed`='0', `name`='" . $post['name'] . "', `image`='" . $post['image'] . "', `article_text`='" . $post['article_text'] . "' WHERE id=" . $id);
        }

        $this->data['success'] = 'Updated !';
        $this->render('articles_list');

    }

    private function requestclean($data)
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

    public function getAdmArticlesEdit($id)
    {

        $this->data['article'] = $this->db->rawQueryOne('SELECT id,name,article_text,category_id,author_id,image FROM `articles`  
WHERE id=' . (int)$id);
        $this->data['categories'] = $this->db->rawQuery('SELECT id,name FROM `categories`');
        $this->data['authors'] = $this->db->rawQuery('SELECT id,name FROM `authors`');
        $this->render('articles_form');

    }

    public function getAdmArticlesDelete($id)
    {

        $this->db->rawQueryOne('DELETE FROM `articles` WHERE id=' . (int)$id);
        $this->data['success'] = 'Deleted !';
        $this->render('articles_list');

    }

    public function getAdmArticles($page)
    {

        $this->data['page'] = (int)$page;
        $this->data['max_page'] = $this->db->rawQuery('SELECT CEILING(COUNT(id)/' . AdmArticles::recordsOnPage . ') FROM `articles` LIMIT 1');
        $this->data['articles'] = $this->db->rawQuery('SELECT `id`,`name` FROM `articles` WHERE id>' . ($this->data['page'] - 1) * AdmArticles::recordsOnPage . ' AND id<' . $this->data['page'] * AdmArticles::recordsOnPage);
        $this->render('articles_info');
    }


    protected function render($template = '')
    {

        if (file_exists(__DIR__ . '/templates/' . $template . '.php')) {

            if (!empty($this->data)) {
                extract($this->data);
            }
            ob_start();

            require(__DIR__ . '/templates/' . $template . '.php');

            $output = ob_get_contents();

            ob_end_clean();

            echo $output;
        } else {
            echo json_encode($this->data,
                JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
        }
    }


}
