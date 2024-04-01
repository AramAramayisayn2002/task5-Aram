<?php

class IndexController extends Controller
{
    public function index()
    {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $select = $this->modelRender('Posts')->select()->execute()->numRows();
        $limitPage = ceil($select / POSTSPERPAGE);
        if ($page > $limitPage || $page < 0) {
            redirect('error');
        } else {
            $ofset = ($page - 1) * POSTSPERPAGE;
        }
        $select = $this->modelRender('Posts')->select()->limit(POSTSPERPAGE)->offset($ofset)->execute()->fetchAssocs();
        $_SESSION['thisPage'] = $page;
        $_SESSION['limitPage'] = $limitPage;
        $paff = 'index';
        $this->view($paff, $select);
    }

    public function show($id)
    {
        $select = $this->modelRender('Posts')->select()->where('id', '=', $id)->execute()->fetchAssoc();
        $paff = 'show';
        $this->view($paff, $select);
    }

    public function view($paff, $select)
    {
        if ($select) {
            $this->viewRender($paff, $select);
        } else {
            $this->viewRender('error');
        }
    }
}