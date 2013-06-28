<?php

class Controller_Main extends Controller {

    public function action_index()
    {

        return Response::forge(ViewModel::forge('main/index'));

    }

}