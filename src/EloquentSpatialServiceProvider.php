<?php

declare(strict_types=1);

namespace Setwise\EloquentSpatial;


use Illuminate\Database\Connection;
use Illuminate\Database\DatabaseServiceProvider;
use Illuminate\Support\Facades\DB;
use Setwise\EloquentSpatial\Doctrine\GeometryCollectionType;
use Setwise\EloquentSpatial\Doctrine\LineStringType;
use Setwise\EloquentSpatial\Doctrine\MultiLineStringType;
use Setwise\EloquentSpatial\Doctrine\MultiPointType;
use Setwise\EloquentSpatial\Doctrine\MultiPolygonType;
use Setwise\EloquentSpatial\Doctrine\PointType;
use Setwise\EloquentSpatial\Doctrine\PolygonType;

class EloquentSpatialServiceProvider extends DatabaseServiceProvider
{
  public function boot(): void
  {
    /** @var Connection $connection */
    $connection = DB::connection();

    if ($connection->isDoctrineAvailable()) {
      $this->registerDoctrineTypes($connection);
    }
  }

  protected function registerDoctrineTypes(Connection $connection): void
  {
    $geometries = [
      'point' => PointType::class,
      'linestring' => LineStringType::class,
      'multipoint' => MultiPointType::class,
      'polygon' => PolygonType::class,
      'multilinestring' => MultiLineStringType::class,
      'multipolygon' => MultiPolygonType::class,
      'geometrycollection' => GeometryCollectionType::class,
      'geomcollection' => GeometryCollectionType::class,
    ];

    foreach ($geometries as $type => $class) {
      DB::registerDoctrineType($class, $type, $type);
      $connection->registerDoctrineType($class, $type, $type);
    }
  }
}
