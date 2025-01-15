<?php

namespace Wanphp\Plugins\Releases\Repositories;

use Wanphp\Libray\Mysql\BaseRepository;
use Wanphp\Libray\Mysql\Database;
use Wanphp\Libray\Slim\Setting;
use Wanphp\Plugins\Releases\Domain\AuthorizationHeaderInterface;
use Wanphp\Plugins\Releases\Entities\AuthorizationHeaderEntity;

class AuthorizationHeaderRepository extends BaseRepository implements AuthorizationHeaderInterface
{
  public function __construct(Setting $setting)
  {
    // 使用SQLite存储发布数据，未配置数据存储位置，放到日志目录
    if ($setting->get('releaseSqlite')) $dbFile = $setting->get('releaseSqlite');
    else $dbFile = $setting->get('logger')['path'] . '/release.sqlite';
    if (!file_exists($dbFile)) touch($dbFile);
    parent::__construct(new Database(['type' => 'sqlite', 'database' => $dbFile]), self::TABLE_NAME, AuthorizationHeaderEntity::class);
  }
}