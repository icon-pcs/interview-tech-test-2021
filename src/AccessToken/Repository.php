<?php declare(strict_types=1);

namespace IconLanguageServices\ApiClient\AccessToken;

interface Repository
{
    public function get(): AccessToken;
}
