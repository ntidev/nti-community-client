<?php

require 'Definitions/community-1_0.php';

return array(
    'name'        => 'Community Insided',
    'baseUri' => $config['baseUri'],
    'apiVersion'  => '1.0',
    'operations'  => array(

        // Users

        'getUser' => array(
            'uri'         => '/user/{id}',
            'description' => 'Fetch a single user by UserId',
            'httpMethod'  => 'GET',
            'parameters'  => array(
                'id' => array(
                    'location' => 'uri',
                    'description' => 'User id',
                    'type' => 'string',
                    'required' => true
                )
            )
        ),
        'getUsers' => array(
            'uri'         => '/user',
            'description' => 'Fetches all users',
            'httpMethod'  => 'GET',
            'parameters'  => array(
                '_returnIterable' => array(
                    'location'    => 'query',
                    'type'        => 'boolean',
                    'required'    => false,
                ),
                'page' => array(
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false,
                ),
                'pageSize' => array(
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                )
            )
        ),
        'createUser' => array(
            'uri' => '/user/register',
            'description' => 'Returns a Json User. The profile_field option in the request body provides a way to add profile fields to the registration. The key refers to an existing profile field id. Note that profile fields can be set as mandatory registration fields.',
            'httpMethod' => 'POST',
            'parameters' => array(
                '_returnIterable' => array(
                    'location'    => 'query',
                    'type'        => 'boolean',
                    'required'    => false,
                ),
                'page' => array(
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false,
                ),
                'email' => array(
                    'location' => 'json',
                    'type' => 'string',
                    'required' => true
                ),
                'username' => array(
                    'location' => 'json',
                    'type' => 'string',
                    'required' => true
                ),
                'password' => array(
                    'location' => 'json',
                    'type' => 'string',
                    'required' => true
                ),
                'sso' => array(
                    'location' => 'json',
                    'type' => 'object',
                    'required' => false,
                    'properties' => array(
                        'oauth2' => array(
                            'location' => 'json',
                            'type' => 'string',
                            'required' => false
                        ),
                    ),
                ),
            )
        ),
        'updateUser' => array(
            'uri' => '/user/{id}',
            'description' => 'Update a user (Username must be unique)',
            'httpMethod' => 'PUT',
            'parameters' => array(
                    'id' => array(
                        'location'    => 'uri',
                        'description' => 'User id',
                        'type'        => 'string',
                        'required'    => true,
                    ),
                )
        ),
        'deleteUser' => array(
            'uri' => '/user/{id}/erase',
            'description' => 'Deletes an existing user and anonymizes content created by the user',
            'httpMethod' => 'DELETE',
            'parameters' => array(
                'id' => array(
                    'location'    => 'uri',
                    'description' => 'User id',
                    'type'        => 'string',
                    'required'    => true,
                ),
            ),
        ),
        'getActivities' => array(
            'uri'         => '/user/activity',
            'description' => 'Fetches all users activities or a single users activities in public categories. The result is sorted by descending order of time activity was added.',
            'httpMethod'  => 'GET',
            'parameters'  => array(
                '_returnIterable' => array(
                    'location'    => 'query',
                    'type'        => 'boolean',
                    'required'    => false,
                ),
                'page' => array(
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false,
                ),
                'pageSize' => array(
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                )
            )
        )

    ) //End of Operations Array
);//End of return array
