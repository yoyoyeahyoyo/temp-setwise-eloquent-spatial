<?php

namespace Setwise\EloquentSpatial\Traits;

use Setwise\EloquentSpatial\SpatialBuilder;

trait HasSpatial
{
  public function newEloquentBuilder($query): SpatialBuilder
  {
    return new SpatialBuilder($query);
  }
}
