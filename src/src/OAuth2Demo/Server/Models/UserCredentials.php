<?php

namespace Procvic;

use OAuth2\Storage\UserCredentialsInterface;
use OAuth2\ResponseType\AccessTokenInterface;
use OAuth2\RequestInterface;
use OAuth2\ResponseInterface;
use OAuth2\GrantType\GrantTypeInterface;
use PDO;
use Nette\Security\Passwords;

class UserCredentials implements GrantTypeInterface
{
	private $userInfo;

	public function getQuerystringIdentifier()
	{
		return 'password';
	}

	public function validateRequest(RequestInterface $request, ResponseInterface $response)
	{
		try {
			$pdo = new PDO(DB_DNS, DB_USER, DB_PASSWORD);
		} catch (\PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
		}

		if (!$request->request("password") || !$request->request("username")) {
			$response->setError(200, 'invalid_request', 'Missing parameters: "username" and "password" required');

			return null;
		}

		$query = 'SELECT id, name, surname, password FROM users WHERE email = ?';
		$prepare = $pdo->prepare($query);
		$prepare->execute([$request->request("username")]);
		$userInfo = $prepare->fetch(\PDO::FETCH_ASSOC);
		if (empty($userInfo) || !Passwords::verify($request->request("password"), $userInfo['password'])) {
			$response->setError(200, 'invalid_grant', 'Invalid username and password combination');

			return null;
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
