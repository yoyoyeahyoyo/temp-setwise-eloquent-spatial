<?php

declare(strict_types=1);

namespace Setwise\EloquentSpatial;

use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\PostgresConnection;
use PDO;

class AxisOrder
{
  public function __construct()
  {
  }

  public function supported(ConnectionInterface $connection): bool
  {
    /** @var PostgresConnection $connection */
    if ($this->isPostgres($connection)) {
      // @codeCoverageIgnoreStart
      return false;
      // @codeCoverageIgnoreEnd
    }

    return true;
  }

  private function isPostgres(PostgresConnection $connection): bool
  {
    /** @var string $version */
    $version = $connection->getPdo()->getAttribute(PDO::ATTR_SERVER_VERSION);

    return version_compare($version, '5.8.0', '<');
  }
}
