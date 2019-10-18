<?php
namespace App\Http\Models;
use App\User;
use Illuminate\Database\Eloquent\Model;

class VisitsQuery extends Model
{
protected $fillable = ['page', 'visits'];
//protected $table = 'visits_queries';
}
