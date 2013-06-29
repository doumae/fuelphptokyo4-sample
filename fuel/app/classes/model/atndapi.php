<?php

class Model_Atndapi extends Model_Crud
{

    public function search($array){

        $param1 = '';
        $param2 = '';
        $param3 = '';

        $keyword = str_replace(' ',',',$array['keyword']);
        $area = str_replace(' ',',',$array['area']);
        $area != '' ? $param1 = $keyword.','.$area : $param1 = $keyword;
        strlen($array['date']) == 6 ? $param2 = $array['date'] : $param3 = $array['date'];

        $curl = Request::forge('http://api.atnd.org/events/?keyword='.$param1.'&ym='.$param2.'&ymd='.$param3.'&format=json'.'&count=100','curl');
        $curl->set_method('get');
        $result = json_decode($curl->execute());

        $date = new Datetime();
        $events = $result->events;
        $returnarray['results'] = null;
        $cnt = 0;
        for($i = 0;$i < $result->results_returned;$i++){
            if(!(array_key_exists('notpast',$array) && $date->format('Y-m-d') > substr($events[$i]->started_at,0,10))){
                $tmep = array(
                    'date' => substr($events[$i]->started_at,0,10),
                    'title' => $events[$i]->title,
                    'recruiting' => $events[$i]->accepted+$events[$i]->waiting.' / '.$events[$i]->limit,
                    'url' => $events[$i]->event_url,
                    'owner' => $events[$i]->owner_nickname,
                    'ownerurl' => 'http://atnd.org/users/'.$events[$i]->owner_id
                );
                $returnarray['results'][$cnt] = $tmep;
                $cnt++;
            }

        }

        $returnarray['counter'] = $cnt;

        return $returnarray;

    }

}


