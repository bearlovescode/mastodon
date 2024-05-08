<?php
    namespace Bearlovescode\Mastodon\Models;

    class Application
    {
        public string $id;
        public string $name;
        public string $website;
        public string $redirect_uri;
        public string $client_id;
        public string $client_secret;
        public string $vapid_key;
    }