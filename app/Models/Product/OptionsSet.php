<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product\Option;

class OptionsSet extends Model
{
	private const DEFAULT_ID = 1;

    protected $table = 'products_options_sets';

    protected $fillable = [
    	'name',
    ];

    /*|==========| Relationships |==========|*/

    public function options()
    {
    	return $this->hasMany(Option::class, 'set_id');
    }

    /*|==========| Scopes |==========|*/

    public function scopeDefault($query)
    {
    	return $query->where($this->getKeyName(),self::DEFAULT_ID);
    }
    
    public static function getDefaultID() 
    {
    	return self::DEFAULT_ID;
    }
}
