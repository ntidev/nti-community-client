<?php

namespace NTI\CommunityClient\Admin;

use NTI\CommunityClient\Admin\Middleware\RefreshToken;
use GuzzleHttp\Command\Guzzle\GuzzleClient;
use GuzzleHttp\Command\Guzzle\Description;
use GuzzleHttp\Command\Guzzle\Serializer;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;
use NTI\CommunityClient\Admin\Classes\FullBodyLocation;
use NTI\CommunityClient\Admin\Classes\FullTextLocation;
use NTI\CommunityClient\Admin\TokenStorages\RuntimeTokenStorage;

/**
 * Class CommunityClient
 *
 * @package NTI\CommunityClient\Admin\CommunityClient
 *
 * @method array getSocialLogins(array $args = array()) { @command Keycloak getSocialLogins }
 * @method array addSocialLogin(array $args = array()) { @command Keycloak addSocialLogin }
 * @method array removeSocialLogin(array $args = array()) { @command Keycloak removeSocialLogin }
 * @method array syncUserStorage(array $args = array()) { @command Keycloak syncUserStorage }
 * @method array getUserConsents(array $args = array()) { @command Keycloak getUserConsents }
 *
 */

class CommunityClient extends GuzzleClient
{

    /**
     * Factory to create new CommunityClient instance.
     *
     * @param array $config
     *
     * @return CommunityClient
     */
    public static function factory($config = array())
    {
        $default = array(
            'apiVersion'  => '1.0',
            'username' => null,
            'password' => null,
            'baseUri'  => null,
            'verify'   => true,
            'token_storage' => new RuntimeTokenStorage(),
        );

        // Create client configuration
        $config = self::parseConfig($config, $default);

        $file = 'community-' . str_replace('.', '_', $config['apiVersion']) . '.php';

        $stack = new HandlerStack();
        $stack->setHandler(new CurlHandler());

        $middlewares = isset($config["middlewares"]) && is_array($config["middlewares"]) ? $config["middlewares"] : [];
        foreach ($middlewares as $middleware) {
            if (is_callable($middleware)) {
                $stack->push($middleware);
            }
        }

        $stack->push(new RefreshToken($config['token_storage']));

        $config['handler'] = $stack;

        $serviceDescription = include __DIR__ . "/Resources/{$file}";
        $customOperations = isset($config["custom_operations"]) && is_array($config["custom_operations"]) ? $config["custom_operations"] : [];
        foreach ($customOperations as $operationKey => $operation) {
            // Do not override built-in functionality
            if (isset($serviceDescription['operations'][$operationKey])) {
                continue;
            }
            $serviceDescription['operations'][$operationKey] = $operation;
        }
        $description = new Description($serviceDescription);

        // Create the new Keycloak Client with our Configuration
        return new static(
            new Client($config),
            $description,
            new Serializer($description, [
                "fullBody" => new FullBodyLocation(),
                "fullText" => new FullTextLocation(),
            ]),
            function ($response) {
                $responseBody = $response->getBody()->getContents();
                return json_decode($responseBody, true) ?? ['content' => $responseBody];
            },
            null,
            $config
        );
    }


    public function getCommand($name, array $params = [])
    {
        return parent::getCommand($name, $params);
    }

    /**
     * Sets the BaseUri used by the Keycloak Client
     *
     * @param string $baseUri
     */
    public function setBaseUri($baseUri)
    {
        $this->setConfig('baseUri', $baseUri);
    }
    /**
     * Sets the Realm name used by the Keycloak Client
     *
     * @param string $realm
     */
    public function getBaseUri()
    {
        return $this->getConfig('baseUri');
    }

    /**
     * Sets the API Version used by the Keycloak Client.
     * Changing the API Version will attempt to load a new Service Definition for that Version.
     *
     * @param string $version
     */
    public function setVersion($version)
    {
        $this->setConfig('apiVersion', $version);
    }

    /**
     * Gets the Version being used by the Keycloak Client
     *
     * @return string|null Value of the Version or NULL
     */
    public function getVersion()
    {
        return $this->getConfig('apiVersion');
    }


    /**
     * Attempt to parse config and apply defaults
     *
     * @param  array  $config
     * @param  array  $default
     *
     * @return array Returns the updated config array
     */
    protected static function parseConfig($config, $default)
    {
        array_walk($default, function ($value, $key) use (&$config) {
            if (!isset($config[$key])) {
                $config[$key] = $value;
            }
        });
        return $config;
    }
}
