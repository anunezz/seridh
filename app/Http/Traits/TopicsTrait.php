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

//        $subtopics = CatSubtopic::with('topic')->where('isActive', 1)
//                ->orderBy('name')
//                ->get(['id', 'name']);

        $total = count($data);
//        $tree = [];
        $ideEdit = [];
        $topics = [];
        if ($items!==null){
            foreach ($items as $item){
                array_push($ideEdit, $item->id);
            }
        }



        $showIde = [];
        $lists=[];
        foreach ($data as $topic) {
            $subtopics = [];

            foreach ($topic->subtopics as $subtopic) {
                        $total++;
                        $name = '';
                        $validName= strpos($subtopic->name, '.-');
                        if ($validName==false) {
                            $name = $subtopic->name;
                        }else{
                            $aux = explode(".-", $subtopic->name);
                            $name = $aux[1];
                        }

                        $subtopics[] = [
                            'id' => $total,
                            'label' => $subtopic->name,
                            'name' => $name,
                            'cat_topic_id' => $topic -> id,
                            'cat_subtopic_id' => $subtopic->id,
                        ];
                        foreach ($ideEdit as $value){
                            if ($value===$subtopic->id){
                                array_push($showIde,$total);
                                $lists[] = [
                                    'id' => $total,
                                    'label' => $subtopic->name,
                                    'name' => $name,
                                    'cat_topic_id' => $topic->id,
                                    'cat_subtopic_id' => $subtopic->id,
                                ];
                            }
                        }
            }
            $topics[] = [
                'id' => $topic->id,
                'name' => $topic->name,
                'children' => $subtopics
            ];
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
}
