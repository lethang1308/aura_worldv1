<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttributeValue extends Model
{
   use HasFactory, SoftDeletes;

    protected $table = 'attributes_values';

    protected $fillable = ['attribute_id', 'value'];

    protected $dates = ['deleted_at'];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
    public function variants(){
        return $this->belongsToMany(variants::class,'variant_attributes','attribute_value_id','variant_id');
    }
}