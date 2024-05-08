<?php
    namespace Bearlovescode\Mastodon\Services;


    use Bearlovescode\Mastodon\Models\Token;
    use DateTime;
    use GuzzleHttp\Psr7\Request;
    use League\Uri\Uri;

    class AuthService extends ApiService
    {

        public function buildAuthorizeUrl(): Uri {
            $params = [
                'client_id' => $this->config->clientId,
                'scope' => 'read+write+push',
                'redirect_uri' => $this->config->redirect,
                'response_type' => 'code'
            ];

            $uriString = sprintf('https://%s?%s', $this->config->instance, http_build_query($params));

            return Uri::new($uriString);
        }

        public function authorize() {
            $req = new Request('GET', '/oauth/authorize', [
                'query' => [
                    'client_id' => $this->config->clientId,
                    'scope' => 'read+write+push',
                    'redirect_uri' => $this->config->redirect,
                    'response_type' => 'code'
                ]
            ]);

            $res = $this->client->handle($req);
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