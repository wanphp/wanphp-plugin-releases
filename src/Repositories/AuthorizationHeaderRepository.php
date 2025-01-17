<?php

namespace Wanphp\Plugins\Releases\Repositories;

use Wanphp\Libray\Mysql\BaseRepository;
use Wanphp\Libray\Mysql\Database;
use Wanphp\Libray\Slim\Setting;
use Wanphp\Plugins\Releases\Domain\AuthorizationHeaderInterface;
use Wanphp\Plugins\Releases\Entities\AuthorizationHeaderEntity;

class AuthorizationHeaderRepository extends BaseRepository implements AuthorizationHeaderInterface
{
  public function __construct(Database $database, Setting $setting)
  {
    // 使用SQLite存储发布数据，未配置数据存储到mysql
    $options = $setting->get('releaseSqlite') ?? [];
    if (!empty($options)) {
      if (!file_exists($options['database'])) touch($options['database']);
      $database = new Database($options);
    }
    parent::__construct($database, self::TABLE_NAME, AuthorizationHeaderEntity::class);
  }
}