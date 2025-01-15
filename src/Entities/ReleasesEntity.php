<?php

namespace Wanphp\Plugins\Releases\Entities;

class ReleasesEntity implements \JsonSerializable
{
  /**
   * @DBType({"key":"PRI","type":"smallint(6) NOT NULL AUTO_INCREMENT"})
   * @var integer|null
   * @OA\Property(description="ID")
   */
  private ?int $id;
  /**
   * @DBType({"key":"UNI","type":"varchar(200) NOT NULL DEFAULT ''"})
   * @var string
   * @OA\Property(description="发布标题")
   */
  private string $title;
  /**
   * @DBType({"type":"varchar(1000) NOT NULL DEFAULT ''"})
   * @var string
   * @OA\Property(description="发布说明")
   */
  private string $content;
  /**
   * @DBType({"type":"varchar(10) NOT NULL DEFAULT ''"})
   * @var string
   * @OA\Property(description="版本标记")
   */
  private string $tag;
  /**
   * @DBType({"type":"char(10) NOT NULL DEFAULT ''"})
   * @var integer
   * @OA\Property(description="发布时间")
   */
  private int $releasesTime;

  /**
   * 初始化实体
   * @param array $array
   */
  public function __construct(array $array)
  {
    foreach ($array as $key => $value) {
      if (property_exists($this, $key)) $this->{$key} = $value;
    }
  }

  /**
   * @param $name
   * @param null $arguments
   * @return mixed|null
   */
  public function __call($name, $arguments = null)
  {
    $action = substr($name, 0, 3);
    $property = substr($name, 3);
    if ($action == 'set' && property_exists($this, $property)) {
      $this->{$property} = $arguments;
      return $arguments;
    } elseif ($action == 'get' && property_exists($this, $property)) {
      return $this->{$property};
    } else {
      return null;
    }
  }

  public function jsonSerialize(): array
  {
    return get_object_vars($this);
  }
}