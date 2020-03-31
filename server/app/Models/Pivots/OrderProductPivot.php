<?php

namespace App\Models\Pivots;

use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderProductPivot extends Pivot
{
    public function getOptionsAttribute()
    {
    	if (is_string($options = $this->getAttributeFromArray('options'))) {
    		$this->setAttribute('options', $obj = json_decode($options, true));

    		return $obj;
    		
    	} else {
    		return $options;
    	}
    }


}
