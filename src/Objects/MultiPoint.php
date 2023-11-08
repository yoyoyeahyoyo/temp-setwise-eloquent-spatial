<?php

declare(strict_types=1);

namespace Setwise\EloquentSpatial\Objects;

class MultiPoint extends PointCollection
{
  protected int $minimumGeometries = 1;

  public function toWkt(): string
  {
    $wktData = $this->getWktData();

    return "MULTIPOINT({$wktData})";
  }

  public function getWktData(): string
  {
    return $this->geometries
      ->map(static function (Point $point): string {
        return $point->getWktData();
      })
      ->join(', ');
  }
}
