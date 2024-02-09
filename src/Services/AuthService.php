<?php
    namespace Bearlovescode\Mastodon\Services;


    use Bearlovescode\Mastodon\Models\Dtos\RegisterAppDto;
    use Bearlovescode\Mastodon\Models\Token;
    use DateTime;
    use GuzzleHttp\Psr7\Request;

    class AuthService extends ApiService
    {

        public function registerApp() : Token
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
        }

        public function getAccessToken(string $code) : Token
        {
            $data = $this->client->token($code);

            return new Token([
                'value' => $data->access_token,
                'type' => $data->token_type,
                'scope' => $data->scope,
                'createdAt' => (new DateTime())->setTimestamp($data->created_at)
            ]);
        }
    }