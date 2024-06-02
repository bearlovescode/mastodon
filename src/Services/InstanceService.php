<?php
    namespace Bearlovescode\Mastodon\Services;

    use Bearlovescode\Mastodon\Models\Application;
    use Bearlovescode\Mastodon\Models\Token;
    use GuzzleHttp\Psr7\Request;

    class InstanceService extends ApiService
    {
        public function registerApp() : Application
        {
            $req = new Request('POST', '/api/v1/apps', [
                'form_params' => [
                    'client_name' => $this->config->getAppName(),
                    'redirect_uris' => $this->config->getRedirectUris(),
                    'scopes' => $this->config->scopes,
                    'website' => $this->config->website
                ]
            ]);

            $data = $this->client->handle($req);

            return new Application($data);

        }
    }