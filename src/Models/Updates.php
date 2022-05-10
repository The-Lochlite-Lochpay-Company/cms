<?php

namespace lochlite\cms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Settings;

class Updates extends Model
{
    use HasFactory;
	
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
	'version',
	'lastversion',
	'path',
	'backup',
	'description',
	'status',
    ];	

}
