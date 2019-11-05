<?php

namespace App\Http\Traits;

use App\Http\Models\Cats\CatTopic;
use App\Http\Models\Cats\CatSubtopic;
use stdClass;

trait TopicsTrait
{
    public static function orderTopics($items)
    {
        $newTopics = CatTopic::with('subtopics')
                ->where('isActive', 1)
                ->orderBy('name')
                ->get(['id', 'name']);

//        $subtopics = CatSubtopic::with('topic')->where('isActive', 1)
//                ->orderBy('name')
//                ->get(['id', 'name']);

        $total = count($newTopics);
       // $tree = [];
        $ideEdit = [];
        $topics = [];


        if ($items!==null){
            foreach ($items as $item){
                array_push($ideEdit, $item->id);
            }
        }

        $showIde = [];
        $list=[];
        foreach ($newTopics as $topic) {
            $subtopics = [];

            foreach ($topic->subtopics as $subtopic) {
                if ($items!==null){
                    $total++;
                    $subtopics[] = [
                        'id' => $total,
                        'label' => $subtopic->name,
                        'cat_topic_id' => $topic->id,
                        'cat_subtopic_id' => $subtopic->id,
                    ];
                    foreach ($ideEdit as $value){
                        if ($value===$subtopic->id){
                            array_push($showIde,$subtopic->id);
                            $list[] = [
                                'id' => $total,
                                'label' => $subtopic->name,
                                'cat_topic_id' => $topic->id,
                                'cat_subtopic_id' => $subtopic->id,
                            ];
                        }
                    }
                }else{
                    $subtopics[] = [
                        'id' => $subtopic->id,
                        'label' => $subtopic->name,
                        'cat_topic_id' => $topic->id
                    ];
                }

            }
            $topics[] = [
                'id' => $topic->id,
                'label' => $topic->name,
                'children' => $subtopics
            ];
        }
        $tree[]=[
            'id' => 0,
            'label' => 'Tema(s)',
            'children' => $topics
        ];

        if ($items!==null){
            return $aux = [
                'tree'            => $tree,
                'showIde'          => $showIde,
                'listThemes'        => $list
            ];
        }else{
            return $tree;
        }

    }
}
