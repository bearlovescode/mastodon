<?php
    namespace Bearlovescode\Mastodon\Models;

    use League\Uri\Uri;
    use Bearlovescode\Datamodels\DataModel;


    class MastodonConfiguration extends DataModel
    {
        public Uri $instance;
        public string $clientId;
        public string $clientSecret;

        public function __construct(array|object $data = null)
        {
            $this->setInstanceUrlFromData($data);

            parent::__construct($data);
        }



        private function setInstanceUrlFromData(array|object &$data) : void
        {
            if (gettype($data) === 'array')
            {
                $this->setInstanceUrl($data['instance']);
                unset($data['instance']);
            }

            elseif (gettype($data) === 'object')
            {
                $this->setInstanceUrl($data->instance);
                unset($data->instance);
            }
        }


        public function setInstanceUrl(string $url) : void
        {
            $this->instance = Uri::new($url);
        }

    }