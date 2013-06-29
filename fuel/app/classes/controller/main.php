<?php

class Controller_Main extends Controller {

    protected $viewmodel = null;

    public function before(){

        //Viewの初期設定値をセット
        $this->viewmodel = ViewModel::forge('main/index');
        $this->viewmodel->set('keyword',null);
        $this->viewmodel->set('area',null);
        $this->viewmodel->set('date',null);
        $this->viewmodel->set('counter',null);
        $this->viewmodel->set('results',null);
        $this->viewmodel->set('notpast',true);
        $this->viewmodel->set('errors',null);

    }

    public function action_index(){

        return Response::forge($this->viewmodel);

    }

    public function action_search(){

        //バリデーション
        $validation = Validation::forge();

        //$_POSTの値を取得
        $value = Input::post();

        //$_GETのデータ取得
        if($value){

            //入力フォームの内容を記録する
            $this->viewmodel->set('keyword',$value['keyword']);
            $this->viewmodel->set('area',$value['area']);
            $this->viewmodel->set('date',$value['date']);

            //チェックボックスの内容を記録する
            array_key_exists('notpast',$value) ? $notpastflag = true : $notpastflag = false;
            $this->viewmodel->set('notpast',$notpastflag);

            //キーワードは必須入力
            $validation->add('keyword','keyword')->add_rule('required');

            //日付の入力フォーマットチェック
            $validation->add('date','date')->add_rule('match_pattern','/^(\d{4}\d{2}(\d{2})?)?$/');

            //バリデーションチェック
            if($validation->run()){
                //正常な場合
                $atndapi = new Model_Atndapi();
                $atndapiresults = $atndapi->search($value);

                $this->viewmodel->set('counter',' --- '.$atndapiresults['counter'].'件');
                $this->viewmodel->set('results',$atndapiresults['results']);

                //検索結果をデータベースに保存
                $insertdata = array('search_date' => Date::time()->format("%Y-%m-%d %H:%M:%S"),
                    'keyword' => $value['keyword'],
                    'area' => $value['area'],
                    'date' => $value['date'],
                    'notpast' => $notpastflag,
                    'result_number' => $atndapiresults['counter']);
                $searchrecord = new Model_Searchrecord($insertdata);
                $searchrecord->save();


            }else{
                //エラーな場合
                $error = array();
                foreach($validation->error() as $key => $value)
                {
                    $error[$key] = $value->get_message();
                }

                $this->viewmodel->set('errors',$error);
            }

            return Response::forge($this->viewmodel);

        }else{
            return Response::redirect('main/index');

        }

    }


}