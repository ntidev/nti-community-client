[![Latest Version](https://img.shields.io/github/v/tag/MohammadWaleed/keycloak-admin-client.svg?style=flat-square)](https://github.com/ntidev/nti-community-client/releases)

[![Total Downloads](https://img.shields.io/packagist/dt/mohammad-waleed/keycloak-admin-client.svg?style=flat-square)](https://packagist.org/packages/mohammad-waleed/keycloak-admin-client)

[![Donate](https://img.shields.io/badge/Paypal-Donate-blue?style=flat-square)](https://paypal.me/mbarghash?locale.x=en_US)

- [Introduction](#introduction)
- [How to use](#how-to-use)
- [Customization](#customization)
- [Supported APIs](#supported-apis)
	- [Users](#users)
	- [Root](#root)


# Introduction

This is a php client to connect to Community Insided admin rest apis with no headache.

Features:
1. Easy to use
2. No need to get token or generate it - it's already handled by the client
3. No need to specify any urls other than the base uri
4. No encode/decode for json just data as you expect

# How to use

#### 1. Create new client

```php
$client = NTI\CommunityClient\Admin\CommunityClient::factory([
    'realm' => 'master',
    'username' => 'admin',
    'password' => '1234',
    'client_id' => 'admin-cli',
    'client_secret' => 'sfdasd',
    'baseUri' => 'http://127.0.0.1:8180',
]);
```

#### 2. Use it

```php
$client->getUsers();

//Result
// Array of users
/*
Array
(
    [0] => Array
        (
            'userid' => 1
            'usergroupid' => 0
            'membergroupids' =>
            'displaygroupid' => 0
            'username' => Anthony
            'email' => no-reply+anthony@insided.com
            'posts' => 5
            'deleted_posts' => 0
            'options' => 1024
            'autosubscribe' => 1
            'customoptions' => 7
            'topics' => 7
            'solved' => 1
            'ipaddress' =>
            'usertitle' => Pioneer
            'customtitle' => 1
            'pmunread' => 1
            'subscriptions' => 22
            'pmtotal' => 1
            'following' => 0
            'followers' => 0
            'avatar' => https://uploads-us-west-2.insided.com/alliant-en-sandbox/icon/200x200/4032f252-3c4a-46d7-83a0-5733ca2c3418.png
            'signature' =>
            'reputation' => 2
            'lastvisit' => 1614769533
            'lastactivity' => 1606228559
            'insided_sso_customeruid' =>
            'reviewcount' => 0
            'ratingcount' => 0
            'lastpostid' => 127
            'lastpost' => 1614771269
            'joindate' => 1403085355
            'likes' => 2
            'likes_given' => 3
            'blogposts' => 0
            'researches' => 0
            'rank_id' => 5
            'rank_name' => Inspiring
            'rank_display_name' => Inspiring
            'rank_avatar_icon' =>
            'rank_avatar_icon_thumb' =>
            'is_moderator' => 0
      )
)


$client->getUser([
    'id' => '39839a9b-de08-4d2c-b91a-a6ce2595b1f3'
]);

//Result

Array(
    'userid' => 3
    'usergroupid' => 0
    'membergroupids' =>
    'displaygroupid' => 0
    'username' => Eliza
    'email' => no-reply+eliza@insided.com
    'posts' => 3
    'deleted_posts' => 0
    'options' => 1024
    'autosubscribe' => 1
    'customoptions' => 7
    'topics' => 11
    'solved' => 1
    'ipaddress' => 54.182.244.102
    'usertitle' =>
    'customtitle' => 0
    'pmunread' => 0
    'subscriptions' => 22
    'pmtotal' => 1
    'following' => 0
    'followers' => 0
    'avatar' => https://uploads-us-west-2.insided.com/alliant-en-sandbox/icon/200x200/e481abd7-8942-4617-974a-0fa6c9d3a403.png
    'signature' =>
    'reputation' => 2
    'lastvisit' => 1662977253
    'lastactivity' => 1662982021
    'insided_sso_customeruid' =>
    'reviewcount' => 0
    'ratingcount' => 0
    'lastpostid' => 142
    'lastpost' => 1662977570
    'joindate' => 1563816419
    'likes' => 2
    'likes_given' => 1
    'blogposts' => 0
    'researches' => 0
    'rank_id' => 8
    'rank_name' => New Participant
    'rank_display_name' => New Participant
    'rank_avatar_icon' =>
    'rank_avatar_icon_thumb' =>
    'is_moderator' => 0
)

$client->createUser(['data' => [
            'email' => 'test@test.com',
            'username' => 'test',
            'password' => true,
            'user_role' => [
                    'roles.registered',
                    'Option A',
                    'Option B',
                    'Other'
                ],
                'profile_field' => [
                    '12' => 'Smith',
                    '34' => 'John'
                ],
                'sso' => [
                    'facebook' => '333ABBDDD',
                    'oauth2' => '4545ag63274'],
                ]]);

//Result
Array(
    'user' => Array(
            'username' => 'test'
            'email' => 'test@test.com',
            'joindate' => '1692394871'
            'userid' => 25
            'sso' => Array()
        )
)


$client->deleteUser([
    'id' => 1
]);
*/
```

# Customization

### Supported credentials

It is possible to change the credential's type used to authenticate by changing the configuration of the Community Insided client.

Currently, the following credentials are supported
- password credentials, used by default
  - to authenticate with a user account
  ````php
  $client = NTI\CommunityClient\Admin\CommunityClient::factory([
      ...
      'grant_type' => 'password',
      'username' => 'admin',
      'password' => '1234',
  ]);
  ````
- client credentials
  - to authenticate with a client service account
  ````php
  $client = NTI\CommunityClient\Admin\CommunityClient::factory([
      ...
      'grant_type' => 'client_credentials',
      'client_id' => 'admin-cli',
      'client_secret' => '84ab3d98-a0c3-44c7-b532-306f222ce1ff',
  ]);
  ````

### Injecting middleware

It is possible to inject [Guzzle client middleware](https://docs.guzzlephp.org/en/stable/handlers-and-middleware.html#middleware) 
in the Community Insided client configuration using the `middlewares` keyword.

For example: 
```php 
use GuzzleHttp\Middleware;
use Psr\Http\Message\RequestInterface;

$client = NTI\CommunityClient\Admin\CommunityClient::factory([
    ...
    'middlewares' => [
        // throws exceptions when request fails
        Middleware::httpErrors(),
        // other custom middlewares
        Middleware::mapRequest(function (RequestInterface $request) {
            return $request;
        }),
    ],
]);
```

### Changing how the token is saved and stored

By default, the token is saved at runtime. This means that the previous token is not used when creating a new client.

You can customize how the token is stored in the client configuration by implementing your own `TokenStorage`, 
an interface which describes how the token is stored and retrieved.
```php 
class CustomTokenStorage implements TokenStorage 
{
    public function getToken() 
    {
        // TODO
    }
    
    public function saveToken(array $token)
    {
        // TODO
    }
}

$client = NTI\CommunityClient\Admin\CommunityClient::factory([
    ...
    'token_storage' => new CustomTokenStorage(),
]);
```

### Custom Community Insided endpoints

It is possible to inject [Guzzle Service Operations](https://guzzle3.readthedocs.io/webservice-client/guzzle-service-descriptions.html#operations)
in the Community Insided configuration using the `custom_operations` keyword. This way you can extend the built-in supported endpoints with custom.

```php
$client = CommunityClient::factory([
...
    'custom_operations' => [
        'getUsersByAttribute' => [
            'uri' => '/auth/realms/{realm}/userapi-rest/users/search-by-attr',
            'description' => 'Get users by attribute Returns a list of users, filtered according to query parameters',
            'httpMethod' => 'GET',
            'parameters' => [
                'realm' => [
                    'location' => 'uri',
                    'description' => 'The Realm name',
                    'type' => 'string',
                    'required' => true,
                ],
                'attr' => [
                    'location' => 'query',
                    'type' => 'string',
                    'required' => true,
                ],
                'value' => [
                    'location' => 'query',
                    'type' => 'string',
                    'required' => true,
                ],
            ],
        ],
    ]
]);
```


# Supported APIs

 ## [Users]()

| API                                                                                                                                                                |    Function Name    | Supported |
|--------------------------------------------------------------------------------------------------------------------------------------------------------------------|:-------------------:|:---------:|
| Returns a Json User. The profile_field option in the request body provides a way to add profile fields to the registration.                                        
| The key refers to an existing profile field id.                                                                                                                    |     createUser      |    ✔️     |
| Note that profile fields can be set as mandatory registration fields.                                                                                              
| Get users Returns a list of users, filtered according to query parameters                                                                                          |      getUsers       |    ✔️     |
| GET /{realm}/users/count                                                                                                                                           |    getUserCount     |    ✔️     |
| Get representation of the user                                                                                                                                     |       getUser       |   ️️️✔️   |
| Update the user                                                                                                                                                    |     updateUser      |   ️️️✔️   |
| Delete the user                                                                                                                                                    |     deleteUser      |   ️️️✔️   |
| Get consents granted by the user                                                                                                                                   |                     |    ️✔️    |
| Revoke consent and offline tokens for particular client from user                                                                                                  |                     |     ❌     |
| Disable all credentials for a user of a specific type                                                                                                              |                     |     ❌     |
| Send a update account email to the user An email contains a link the user can click to perform a set of required actions.                                          | executeActionsEmail |    ✔️     |
| Get social logins associated with the user                                                                                                                         |                     |    ✔️     |
| Add a social login provider to the user                                                                                                                            |                     |    ✔️     |
| Remove a social login provider from user                                                                                                                           |                     |    ✔️     |
| GET /{realm}/users/{id}/groups                                                                                                                                     |    getUserGroups    |    ✔️     |
| GET /{realm}/users/{id}/groups/count                                                                                                                               | getUserGroupsCount  |    ✔️     |
| PUT /{realm}/users/{id}/groups/{groupId}                                                                                                                           |   addUserToGroup    |    ✔️     | 
| DELETE /{realm}/users/{id}/groups/{groupId}                                                                                                                        | deleteUserFromGroup |    ✔️     |
| Impersonate the user                                                                                                                                               |   impersonateUser   |    ✔️     |
| Remove all user sessions associated with the user Also send notification to all clients that have an admin URL to invalidate the sessions for the particular user. |     logoutUser      |    ✔️     |
| Get offline sessions associated with the user and client                                                                                                           |                     |     ❌     |
| Remove TOTP from the user                                                                                                                                          |                     |     ❌     |
| Set up a new password for the user.                                                                                                                                |  resetUserPassword  |    ✔️     |
| Send an email-verification email to the user An email contains a link the user can click to verify their email address.                                            |   sendVerifyEmail   |    ✔️     |
| Get sessions associated with the user                                                                                                                              |   getUserSessions   |    ✔️     |
| Get credentials associated with the user                                                                                                                           | getUserCredentials  |    ✔️     |
