<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    protected $fillable = ['title', 'type_id', 'single_price_min', 'single_price_max', 'revenue_share_price', 'detail'];
}
