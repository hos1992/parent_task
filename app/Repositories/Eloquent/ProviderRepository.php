<?php

namespace App\Repositories\Eloquent;

use App\Repositories\ProviderRepositoryInterface;
use Illuminate\Support\Collection;

class ProviderRepository extends BaseRepository implements ProviderRepositoryInterface
{

    const AUTHORISED_STATUS = 1;
    const DECLINE_STATUS    = 2;
    const REFUNDED_STATUS   = 3;
    private array $providers_config = [];
    private array $data_collection  = [];

    /**
     * List the providers data according to the given data in the data array
     *
     * @param array $data
     * @return Collection
     */
    function list(array $data): Collection
    {
        // get config
        $this->getProvidersConfig();

        if (empty($this->providers_config)) {
            throw new \Exception("There's no providers in the config file !");
        }

        // get providers data
        $this->getProvidersData();

        if (empty($this->data_collection)) {
            throw new \Exception("No users fetched !");
        }

        // return all or filtered users collection
        return $this->filterUsers($data);

    }

    /**
     * push providers from the config file to providers_config property
     *
     * @return void
     */
    private function getProvidersConfig()
    {
        // path = storage/app/public
        $config = $this->readJsonFile(public_path('storage/providers_config.json'));
        foreach ($config as $val) {
            $this->providers_config[] = json_decode($val, true);
        }
    }

    /**
     * Read all providers file and push the user object to data_collection property
     *
     * @return void
     */
    private function getProvidersData()
    {
        foreach ($this->providers_config as $config) {
            $users = $this->readJsonFile(public_path("storage/{$config['file_name']}"));
            foreach ($users as $user) {
                $this->data_collection[] = $this->constructUserObject(json_decode($user, true), $config);
            }
        }
    }

    /**
     * Create user object depending on the provider config
     *
     * @param array $user
     * @param array $config
     * @return array
     */
    private function constructUserObject(array $user, array $config)
    {
        $userArr = [
            'provider' => $config['provider_name'],
            'balance' => $user[$config['amount_key']],
            'currency' => $user[$config['currency_key']],
            'parent_email' => $user[$config['parent_email_key']],
            'registration_date' => $user[$config['registration_date_key']],
            'id' => $user[$config['id_key']],
        ];

        switch ($user[$config['status_code_key']]) {
            case $config['status_authorised_val']:
                $userArr['status'] = SELF::AUTHORISED_STATUS;
                break;
            case $config['status_decline_val']:
                $userArr['status'] = SELF::DECLINE_STATUS;
                break;
            case $config['status_refunded_val']:
                $userArr['status'] = SELF::REFUNDED_STATUS;
                break;
        }
        return $userArr;

    }

    /**
     * Filter users according to request data
     *
     * @param array $data
     * @return Collection
     */
    private function filterUsers(array $data): Collection
    {
        // create users collection
        $users = collect($this->data_collection);

        // get users by provider
        if (isset($data['provider']) && !empty($data['provider'])) {
            $users = $users->where('provider', $data['provider']);
        }

        // get usesrs by status
        if (isset($data['statusCode']) && !empty($data['statusCode'])) {

            switch ($data['statusCode']) {
                case 'authorised';
                    $users = $users->where('status', SELF::AUTHORISED_STATUS);
                    break;
                case 'decline';
                    $users = $users->where('status', SELF::DECLINE_STATUS);
                    break;
                case 'refunded';
                    $users = $users->where('status', SELF::REFUNDED_STATUS);
                    break;
            }
        }

        // get users by balanceMin
        if (isset($data['balanceMin']) && !empty($data['balanceMin'])) {
            $users = $users->where('balance', '>=', $data['balanceMin']);
        }

        // get users by balanceMax
        if (isset($data['balanceMax']) && !empty($data['balanceMax'])) {
            $users = $users->where('balance', '<=', $data['balanceMax']);
        }

        // get users by currency
        if (isset($data['currency']) && !empty($data['currency'])) {
            $users = $users->where('currency', $data['currency']);
        }

        return $users;

    }

}
