<?php

namespace Wanphp\Plugins\Releases\Domain;

use Wanphp\Libray\Mysql\BaseInterface;

interface AuthorizationHeaderInterface extends BaseInterface
{
  const TABLE_NAME = "authorization_header";
}