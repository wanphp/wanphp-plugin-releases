<?php

namespace Wanphp\Plugins\Releases\Application\Manage;

use Exception;
use Parsedown;
use Psr\Http\Message\ResponseInterface as Response;
use Random\RandomException;
use Wanphp\Libray\Slim\Action;
use Wanphp\Plugins\Releases\Domain\AuthorizationHeaderInterface;
use Wanphp\Plugins\Releases\Domain\ReleasesInterface;

/**
 * Class ReleasesApi
 * @title 发布版本
 * @route /admin/releases
 * @package Wanphp\Plugins\Releases\Application\Manage
 */
class ReleasesApi extends Action
{
  private ReleasesInterface $releases;
  private string $token;

  /**
   * @throws RandomException
   * @throws Exception
   */
  public function __construct(ReleasesInterface $releases, AuthorizationHeaderInterface $authorizationHeader)
  {
    $this->releases = $releases;
    try {
      $this->token = $authorizationHeader->get('token');
    } catch (\Exception $e) {
      $this->token = $this->createToken();
      $authorizationHeader->insert(['token' => $this->token]);
    }
  }

  /**
   * @inheritDoc
   */
  protected function action(): Response
  {
    if ($this->request->getMethod() == 'POST') {
      $authorization = $this->request->getHeaderLine('Authorization') ?? '';
      if (str_starts_with($authorization, 'Bearer ')) {
        $authorization = substr($authorization, 7);
        $token = $this->unmaskToken($authorization);
        if ($token == $this->token) {
          $data = $this->getFormData();
          // 获取发布操作类型
          $action = $data['action'] ?? null;

          // 记录发布信息
          $release = [
            'tag_name' => $data['release']['tag_name'],
            'name' => $data['release']['name'],
            'body' => $data['release']['body'],
            'prerelease' => $data['release']['prerelease'] ? 1 : 0,
            'releasesTime' => strtotime($data['release']['created_at'])
          ];
          switch ($action) {
            case 'published':
              $release['id'] = $data['release']['id'];
              return $this->respondWithData(['id' => $this->releases->insert($release)]);
            case 'updated':
              return $this->respondWithData(['upNum' => $this->releases->update($release, ['id' => $data['release']['id']])]);
            case 'deleted':
              return $this->respondWithData(['delNum' => $this->releases->delete(['id' => $data['release']['id']])]);
            default:
              return $this->respondWithData(['msg' => '无效请求！']);
          }
        }
      }
      return $this->respondWithData(['msg' => 'Token 无效！']);
    } else {
      if ($this->request->getHeaderLine("X-Requested-With") == "XMLHttpRequest") {
        $data = [];
        $parseDown = new Parsedown();
        foreach ($this->releases->select('*', ['ORDER' => ['id' => 'DESC']]) as $release) {
          $release['body'] = $parseDown->text($release['body']);
          $data[] = $release;
        }

        return $this->respondWithData([
          'data' => $data
        ]);
      } else {
        $data = [
          'title' => '发布版本',
          'webhook_receiver' => $this->request->getUri()->getScheme() . '://' . $this->request->getUri()->getHost() . ($this->args['basePath'] ?? '') . '/webhook-receiver',
          'token' => $this->maskToken($this->token),
          'basePath' => $this->args['basePath'] ?? ''
        ];

        return $this->respondView('@releases/releases.html', $data);
      }
    }
  }

  /**
   * @return string
   * @throws RandomException
   */
  private function createToken(): string
  {
    return bin2hex(random_bytes(20));
  }

  /**
   * @param string $token Token to mask
   * @return string Masked token, base64 encoded
   * @throws Exception
   */
  private function maskToken(string $token): string
  {
    $key = random_bytes(strlen($token));
    return base64_encode($key . ($key ^ $token));
  }

  /**
   * @param string $maskedToken Masked token, base64 encoded
   * @return string Unmasked token
   * @see maskToken()
   */
  private function unmaskToken(string $maskedToken): string
  {
    $decoded = base64_decode($maskedToken, true);
    if ($decoded === false) return '';
    $tokenLength = strlen($decoded) / 2;
    if (!is_int($tokenLength)) return '';

    $key = substr($decoded, 0, $tokenLength);
    $decodedMaskedToken = substr($decoded, $tokenLength, $tokenLength);

    return $key ^ $decodedMaskedToken;
  }
}