<?php

namespace Wanphp\Plugins\Releases\Repositories;

use Wanphp\Libray\Mysql\BaseRepository;
use Wanphp\Libray\Mysql\Database;
use Wanphp\Plugins\Releases\Domain\ReleasesInterface;
use Wanphp\Plugins\Releases\Entities\ReleasesEntity;

class ReleasesRepository extends BaseRepository implements ReleasesInterface
{
  public function __construct(Database $database)
  {
    parent::__construct($database, self::TABLE_NAME, ReleasesEntity::class);
  }
}