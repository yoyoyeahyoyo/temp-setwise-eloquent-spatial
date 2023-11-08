<?php

namespace Setwise\EloquentSpatial\Tests\TestModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Setwise\EloquentSpatial\Objects\GeometryCollection;
use Setwise\EloquentSpatial\Objects\LineString;
use Setwise\EloquentSpatial\Objects\MultiLineString;
use Setwise\EloquentSpatial\Objects\MultiPoint;
use Setwise\EloquentSpatial\Objects\MultiPolygon;
use Setwise\EloquentSpatial\Objects\Point;
use Setwise\EloquentSpatial\Objects\Polygon;
use Setwise\EloquentSpatial\SpatialBuilder;
use Setwise\EloquentSpatial\Tests\TestFactories\TestPlaceFactory;
use Setwise\EloquentSpatial\Traits\HasSpatial;

/**
 * @property Point $point
 * @property MultiPoint $multi_point
 * @property LineString $line_string
 * @property MultiLineString $multi_line_string
 * @property Polygon $polygon
 * @property MultiPolygon $multi_polygon
 * @property GeometryCollection $geometry_collection
 * @property float|null $distance
 * @property float|null $distance_in_meters
 * @property Point|null $centroid
 * @property Point|null $centroid_alias
 * @mixin Model
 *
 * @method static SpatialBuilder<TestPlace> query()
 */
class TestPlace extends Model
{
  use HasFactory, HasSpatial;

  protected $fillable = [
    'address',
    'point',
    'multi_point',
    'line_string',
    'multi_line_string',
    'polygon',
    'multi_polygon',
    'geometry_collection',
    'point_with_line_string_cast',
  ];

  protected $casts = [
    'point' => Point::class,
    'multi_point' => MultiPoint::class,
    'line_string' => LineString::class,
    'multi_line_string' => MultiLineString::class,
    'polygon' => Polygon::class,
    'multi_polygon' => MultiPolygon::class,
    'geometry_collection' => GeometryCollection::class,
    'point_with_line_string_cast' => LineString::class,
  ];

  protected static function newFactory(): TestPlaceFactory
  {
    return new TestPlaceFactory;
  }
}
