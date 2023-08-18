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
            'description' => 'Get representation of the user',
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
            'description' => 'Get users Returns a list of users, filtered according to query parameters',
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
            'description' => 'Create a new user Username must be unique.',
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
            'description' => 'Delete a user',
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

    ) //End of Operations Array
);//End of return array
