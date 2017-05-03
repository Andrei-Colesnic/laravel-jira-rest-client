<?php

namespace Atlassian\JiraRest\Requests\Auth;

use Atlassian\JiraRest\Requests\BaseRequest;

/**
 * Class Session.
 *
 * @method mixed get(array $params = [])
 * @method mixed post(array $params = [])
 * @method mixed delete(array $params = [])
 */
class Session extends BaseRequest
{

    protected $options = [
        'post' => [
            'username',
            'password'
        ]
    ];

    public function getResource()
    {
        return 'session';
    }

    public function getApi()
    {
        return 'auth/1';
    }

    /**
     * Get the available methods
     * The request will throw an exception if a method is called that is not available
     *
     * @return array
     */
    public function getAvailableMethods()
    {
        return [
            'get',
            'post',
            'delete'
        ];
    }

    public function beforeHandle($method)
    {
        if ($method === 'post') {
            $this->skipAuthentication = true;
        }
    }

    public function handleResponse($response, $method)
    {
        $response = json_decode($response);

        if ($method === 'post') {
            $cookie = json_encode([
                'name' => $response->session->name,
                'value' => $response->session->value
            ]);

            \Cache::put('jira_cookie', $cookie, 3600);

            return $cookie;
        } elseif ($method === 'delete') {
            \Cache::forget('jira_cookie');
        }

        return $response;
    }
}