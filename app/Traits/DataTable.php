<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait DataTable
{
    protected static function generateDataTable(Request $request)
    {
        # Server send parameters to me (draw-totalRecord-filtered-data)
        # Access to these parameters with Request

    }
}