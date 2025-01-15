<?php

namespace Wanphp\Plugins\Releases\Repositories;

use Wanphp\Libray\Mysql\BaseRepository;
use Wanphp\Libray\Mysql\Database;
use Wanphp\Plugins\Releases\Domain\AuthorizationHeaderInterface;
use Wanphp\Plugins\Releases\Entities\AuthorizationHeaderEntity;

class AuthorizationHeaderRepository extends BaseRepository implements AuthorizationHeaderInterface
{
  public function __construct(Database $database)
  {
    parent::__construct($database, self::TABLE_NAME, AuthorizationHeaderEntity::class);
  }
}