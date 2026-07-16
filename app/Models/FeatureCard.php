<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['icon', 'color_key', 'title', 'description', 'position'])]
class FeatureCard extends Model
{
    //
}
