<?php

class Simple_PagesController extends JaksonController
{
    public function MainPage($args)
    {
        echo 'Hello!';
    }

    public function ViewPage($args)
    {
        echo '<pre>';
        print_r($args);
    }
}