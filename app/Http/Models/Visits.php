<?php
namespace App\Http\Models;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Visits extends Model
{
protected $fillable = ['page', 'visits'];
//protected $table = 'visits';
}
