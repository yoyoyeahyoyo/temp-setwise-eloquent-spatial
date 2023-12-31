<?php

declare(strict_types=1);

namespace Setwise\EloquentSpatial\Doctrine;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class PointType extends Type
{
  public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
  {
    // @codeCoverageIgnoreStart
    return 'point';
    // @codeCoverageIgnoreEnd
  }

  public function getName(): string
  {
    return 'point';
  }
}
