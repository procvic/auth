<?php

namespace Procvic;

use OAuth2\Storage\UserCredentialsInterface;
use OAuth2\ResponseType\AccessTokenInterface;
use OAuth2\RequestInterface;
use OAuth2\ResponseInterface;
use OAuth2\GrantType\GrantTypeInterface;

class UserCredentials implements GrantTypeInterface
{
	private $userInfo;

	public function getQuerystringIdentifier()
	{
		return 'password';
	}

	public function validateRequest(RequestInterface $request, ResponseInterface $response)
	{
		if (!$request->request("password") || !$request->request("username")) {
			$response->setError(200, 'invalid_request', 'Missing parameters: "username" and "password" required');

			return null;
		}

		if ($request->request("username") != 'demouser' || $request->request("password") != 'testpass') {
			$response->setError(200, 'invalid_grant', 'Invalid username and password combination');

			return null;
		}

		$userInfo = [
			'user_id' => 1,
			'name' => 'John',
			'surname' => 'Doe',
		];

		if (empty($userInfo)) {
			$response->setError(200, 'invalid_grant', 'Unable to retrieve user information');

			return null;
		}

		if (!isset($userInfo['user_id'])) {
			throw new \LogicException("you must set the user_id on the array returned by getUserDetails");
		}

		$this->userInfo = $userInfo;

		return true;
	}

	public function getClientId()
	{
		return null;
	}

	public function getUserId()
	{
		return $this->userInfo['user_id'];
	}

	public function getScope()
	{
		return isset($this->userInfo['scope']) ? $this->userInfo['scope'] : null;
	}

	public function createAccessToken(AccessTokenInterface $accessToken, $client_id, $user_id, $scope)
	{
		return $accessToken->createAccessToken($client_id, $user_id, $scope);
	}
}
