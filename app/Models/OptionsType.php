<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductOption;

class OptionsType extends Model
{
    protected $fillable = [
    	'name',
    ];

    /*|==========| Relationships |==========|*/

    public function options()
    {
    	return $this->hasMany(ProductOption::class, 'type_id');
    }
}
