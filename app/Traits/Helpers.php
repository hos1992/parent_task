<?php

namespace App\Traits;

use JsonMachine\Items;
use JsonMachine\JsonDecoder\PassThruDecoder;

trait Helpers
{
    function readJsonFile(String $filePath)
    {
        return Items::fromFile($filePath, ['decoder' => new PassThruDecoder]);
    }
}
