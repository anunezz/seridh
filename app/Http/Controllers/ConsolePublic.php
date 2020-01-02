<?php

namespace App\Http\Controllers;

use App\Http\Models\CarouselImages;
use Illuminate\Http\Request;
use App\Http\Models\ConsolePublicRecommendation;
use App\User;
use DB;

class ConsolePublic extends Controller
{

    public function saveMessages(Request $request)
    {
        $data = $request->all();
        //dd($data);
        if ($data['type']==2){
            foreach ($data['ids'] as $id){
                $reg = null;
                $reg = CarouselImages::find($id);
                $reg->isActive = true;
                $reg->type = 2;
                $reg->save();
            }
            foreach ($data['idsDelete'] as $id){
                $regDelet = null;
                $regDelet = CarouselImages::find($id);
                $regDelet->isActive = false;
                $regDelet->type = 2;
                $regDelet->save();
            }
            return response()->json([
                'success'   => true
            ]);
        }else if ($data['type']==1){
            foreach ($data['ids'] as $id){
                $reg = null;
                $reg = CarouselImages::find($id);
                $reg->isActive = true;
                $reg->type = 1;
                $reg->save();
            }
            foreach ($data['idsDelete'] as $id){
                $regDelet = null;
                $regDelet = CarouselImages::find($id);
                $regDelet->isActive = false;
                $regDelet->type = 1;
                $regDelet->save();
            }
            return response()->json([
                'success'   => true
            ]);
        }else{
            $data['path_dgdhd'] = $data['path_dgdhd'][0]['url'];
            $data['path_undersecretary'] = $data['path_undersecretary'][0]['url'];

            $confPublic = ConsolePublicRecommendation::find(1);
            $confPublic->fill($data);
            $confPublic->save();
        }
    }

    public function getData()
    {
        try {
            $configPublic = ConsolePublicRecommendation::find(1);
            $dataPublic = [
                'seridh'               => $configPublic->seridh,
                'activeSeridh'         => $configPublic->activeSeridh == 1 ? true : false,
                'undersecretary'       => $configPublic->undersecretary,
                'path_undersecretary'  => [],
                'activeUndersecretary' => $configPublic->activeUndersecretary == 1 ? true : false,
                'dgdhd'                => $configPublic->dgdhd,
                'path_dgdhd'           => [],
                'activeDgdhd'          => $configPublic->activeDgdhd == 1 ? true : false,
            ];
            //dd( $configPublic->path_undersecretary,$configPublic->path_dgdhd);
            return response()->json([
                'dataPublic' => $dataPublic,
                'path_undersecretary'  => $configPublic->path_undersecretary,
                'path_dgdhd'           => $configPublic->path_dgdhd,
                'success'   => true
            ]);

        }
        catch ( \Exception $e ){
            return response()->json([
                'success' => false,
                'message' => dd($e)
            ]);
        }
    }

    public function updateImg(Request $request){
        try {
            DB::beginTransaction();

            if(isset($request->allies)){
                
                $file = new CarouselImages();
                $path = public_path().'/img/public/allies/';
                $document = $request->document;
                $nameHash = encrypt($file->id) . '.' . $document->extension();

                //dd($nameHash);

                $file->user_id = auth()->user()->id;
                $file->fileName = $document->getClientOriginalName();
                $file->fileNameHash = $nameHash;
                $file->save();
                $document->move($path, $nameHash);
                DB::commit();

                return response()->json([
                    'success'    => true,
                    'documentId' => $file->id,
                    'fileName'   => $document->getClientOriginalName(),
                    'fileNameHash'   => $nameHash,
                    'path'      => '/img/public/allies/'.$nameHash
                ]);
            }else if (isset($request->carousel)){
                $file = new CarouselImages();
                $path = public_path().'/img/public/carousel/';
                $document = $request->document;
                $nameHash = encrypt($file->id) . '.' . $document->extension();

                $file->user_id = auth()->user()->id;
                $file->fileName = $document->getClientOriginalName();
                $file->fileNameHash = $nameHash;
                $file->save();
                $document->move($path, $nameHash);
                DB::commit();

                return response()->json([
                    'success'    => true,
                    'documentId' => $file->id,
                    'fileName'   => $document->getClientOriginalName(),
                    'fileNameHash'   => $nameHash,
                    'path'      => '/img/public/carousel/'.$nameHash
                ]);

            }else{
                $path = public_path().'/img/public/messages/';
                $document = $request->document;
                $name = $document->getClientOriginalName();
                $document->move($path, $name);
                $url = '/img/public/messages/'.$name;

                $confPublic = ConsolePublicRecommendation::find(1);

                if (isset($request->undersecretary)){
                    $confPublic->path_undersecretary = $url;
                    $confPublic->save();
                }else{
                    $confPublic->path_dgdhd = $url;
                    $confPublic->save();
                }
                DB::commit();

                return response()->json([
                    'success'    => true,
                ]);
            }

        }
        catch ( \Exception $e ) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function deleteImg(Request $request)
    {
        try {
            $data = $request->all();
            $path = public_path().$data['url'];
            $configPublic = ConsolePublicRecommendation::wherePathUndersecretary($data['url'])->orWhere('path_dgdhd',$data['url'])->first();
            if (file_exists($path)) {
                unlink($path);
            }

            if ($data['url']==$configPublic->path_undersecretary){
                $configPublic->path_undersecretary = null;
                $configPublic->save();
            }else{
                $configPublic->path_dgdhd = null;
                $configPublic->save();
            }
        }
        catch ( \Exception $e ){
            return response()->json([
                'success' => false,
                'message' => dd($e)
            ]);
        }
    }

    public function carouselImages()
    {
        return CarouselImages::whereIsactive(1)->whereType(1)->get();
    }

    public function alliesImages()
    {
        return CarouselImages::whereIsactive(1)->whereType(2)->get();
    }

}
