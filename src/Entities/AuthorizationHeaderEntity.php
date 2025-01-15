<?php

namespace Wanphp\Plugins\Releases\Entities;

use Wanphp\Libray\Mysql\EntityTrait;

class AuthorizationHeaderEntity implements \JsonSerializable
{
  use EntityTrait;

  /**
   * @DBType({"key":"PRI","type":"smallint(6) NOT NULL AUTO_INCREMENT"})
   * @var integer|null
   * @OA\Property(description="ID")
   */
  private ?int $id;
  /**
   * @DBType({"type":"varchar(20) NOT NULL DEFAULT ''"})
   * @var string
   * @OA\Property(description="API Token")
   */
  private string $token;
}