<?php

namespace Wanphp\Plugins\Releases\Entities;

use Wanphp\Libray\Mysql\EntityTrait;

class AuthorizationHeaderEntity implements \JsonSerializable
{
  use EntityTrait;

  /**
   * @DBType({"type":"varchar(20) NOT NULL DEFAULT ''"})
   * @var string
   * @OA\Property(description="API Token")
   */
  private string $token;
}