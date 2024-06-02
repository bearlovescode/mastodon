<?php
    namespace Bearlovescode\Mastodon\Services;

    use Bearlovescode\Mastodon\Models\Application;
    use GuzzleHttp\Psr7\Request;

    class InstanceService extends ApiService
    {
        public function registerApp() : Application
        {
            $req = new Request('POST', '/api/v1/apps', [
                'form_params' => [
                    'client_name' => $this->config->getAppName(),
                    'redirect_uris' => $this->config->getRedirectUrl(),
                    'scopes' => $this->config->scopes,
                    'website' => $this->config->website
                ]
            ], null);

            $data = $this->client->handle($req);

            return new Application($data);

        }
    }