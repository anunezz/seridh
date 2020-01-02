<?php namespace App\Http\Models;

use App\Http\Traits\CustomModelLogic;
use App\User;
use Illuminate\Database\Eloquent\Model;



class Files extends Model
{
    protected $appends = ['hash'];
    protected $fillable = ['title', 'description', 'document_id', 'isPublished', 'downloadCount', 'isType'];

     function documents(){
         return $this->belongsTo(Document::class,'document_id','id', 'isType');
     }

    public function getHashAttribute()
    {
        return encrypt( $this->id );
    }
}
