<?php

namespace Wanphp\Plugins\Releases\Entities;

use Wanphp\Libray\Mysql\EntityTrait;

class ReleasesEntity implements \JsonSerializable
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
   * @OA\Property(description="标签名称，版本标记")
   */
  private string $tag_name;
  /**
   * @DBType({"key":"UNI","type":"varchar(30) NOT NULL DEFAULT ''"})
   * @var string
   * @OA\Property(description="发布标题")
   */
  private string $name;
  /**
   * @DBType({"type":"varchar(5000) NOT NULL DEFAULT ''"})
   * @var string
   * @OA\Property(description="发布说明")
   */
  private string $body;
  /**
   * @DBType({"type":"char(1) NOT NULL DEFAULT ''"})
   * @var integer
   * @OA\Property(description="预发布")
   */
  private int $prerelease;
  /**
   * @DBType({"type":"char(10) NOT NULL DEFAULT ''"})
   * @var integer
   * @OA\Property(description="发布时间")
   */
  private int $releasesTime;

}