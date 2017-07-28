<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
   protected $fillable = [
    'setting_type', 'name', 'value', 'title', 'help_text', 'field_type', 'field_options', 'min_value', 'max_value', 'max_length'
  ];
}
