<?php

class View_Main_index extends ViewModel
{

    /**
     * Prepare the view data, keeping this in here helps clean up
     * the controller.
     *
     * @return void
     */
    public function view()
    {

        //ビューに必要な基本データを準備
        $this->title = Config::get('appname');
        $this->fuelversion = Config::get('fuelversion');
        $this->year = Config::get('madeyear');
        $this->author = Config::get('author');

        //フォームのエラー処理を行う
        $this->is_error = function($array,$name){
            if($array != null){
                foreach($array as $key => $value){
                    if($key == $name){
                        echo 'error';
                    }
                }

            }
            echo '';
        };
    }
}