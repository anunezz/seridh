<?php

namespace App\Http\Traits;

use App\Http\Models\Cats\CatTopic;
use App\Http\Models\Cats\CatSubtopic;
use stdClass;

trait TopicsTrait
{
    public static function orderTopics($items)
    {






        $data = CatTopic::with('subtopics')
            ->where('isActive', 1)
            ->orderBy('name')
            ->get(['id', 'name']);

        $total = count($data);

        $ideEdit = [];
        $topics = [];
        if ($items!==null){
            foreach ($items as $item){
                array_push($ideEdit, $item->id);
            }
        }



        $showIde = [];
        $lists=[];
        $totalAux = 1;
        foreach ($data as $topic) {
            $subtopics = [];


            foreach ($topic->subtopics as $sub){
                $valid= strpos($sub->name, '.-');
                if ($valid) {
                    $aux = explode(".-", $sub->name);
                    $sub->name= $aux[1];
                }
            }
            $subTopics = self::arraySort( $topic->subtopics->toArray(), 'name', SORT_ASC);

            foreach ($subTopics as $subtopic) {
                $total++;
                /*$name = '';
                $validName= strpos($subtopic->name, '.-');
                if ($validName==false) {
                    $name = $subtopic->name;
                }else{
                    $aux = explode(".-", $subtopic->name);
                    $name = $aux[1];
                }
dd($subtopic->name,$name);*/
                $subtopics[] = [
                    'id' => $total,
                    'label' => $subtopic['name'],
                    'name' => $subtopic['name'],
                    'cat_topic_id' => $topic -> id,
                    'cat_subtopic_id' => $subtopic['id'],
                ];
                foreach ($ideEdit as $value){
                    if ($value===$subtopic['id']){
                        array_push($showIde,$total);
                        $lists[] = [
                            'id' => $total,
                            'label' => $subtopic['name'],
                            'name' => $subtopic['name'],
                            'cat_topic_id' => $topic->id,
                            'cat_subtopic_id' => $subtopic['id'],
                        ];
                    }
                }



            }

            $topics[] = [
                'id' => $totalAux,
                'name' => $topic->name,
                'children' => $subtopics
            ];

            $totalAux += 1;
        }
        $tree[]=[
            'id' => 0,
            'name' => 'Tema(s)',
            'children' => $topics
        ];

        return $tree = [
            'tree'            => $tree,
            'showIde'          => $showIde,
            'listThemes'        => $lists
        ];

    }

    public static function arraySort($array, $on, $order=SORT_ASC){
        $new_array = array();
        $sortable_array = array();

        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            }

            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                    break;
                case SORT_DESC:
                    arsort($sortable_array);
                    break;
            }

            foreach ($sortable_array as $k => $v) {
                $new_array[$k] = $array[$k];
            }
        }
        return $new_array;
    }
}
