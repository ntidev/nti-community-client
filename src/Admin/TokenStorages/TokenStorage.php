<?php

namespace NTI\CommunityClient\Admin\TokenStorages;

interface TokenStorage
{
    /**
     * @return array|null
     */
    public function getToken();

    /**
     * @param array $token
     */
    public function saveToken(array $token);
}