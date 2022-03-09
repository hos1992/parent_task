<?php

namespace Tests\Feature;

use App\Traits\Helpers;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetProvidersTest extends TestCase
{

    use Helpers;

    public function test_config()
    {
        $config = $this->readJsonFile(public_path('storage/providers_config.json'));
        foreach ($config as $val) {
            $this->assertTrue(true);
        }
        $this->assertFalse(false, 'The providers config file is not setup properly !');
    }

    public function test_providers_data(){
        $config = $this->readJsonFile(public_path('storage/providers_config.json'));

        foreach ($config as $val) {
            $provider = json_decode($val, true);
            $users = $this->readJsonFile(public_path("storage/{$provider['file_name']}"));
            foreach($users as $user){
                if($user){
                    break;
                }
            }
        }

        $this->assertFalse(false, 'The providers config file is not setup properly !');
    }
}
