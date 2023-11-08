<?php

declare(strict_types=1);

namespace Setwise\EloquentSpatial;

use Geometry as geoPHPGeometry;
use GeometryCollection as geoPHPGeometryCollection;
use geoPHP;
use InvalidArgumentException;
use LineString as geoPHPLineString;
use Setwise\EloquentSpatial\Objects\Geometry;
use Setwise\EloquentSpatial\Objects\Point;
use Setwise\EloquentSpatial\Objects\Polygon;
use Setwise\EloquentSpatial\Objects\GeometryCollection;
use Setwise\EloquentSpatial\Objects\LineString;
use Setwise\EloquentSpatial\Objects\MultiLineString;
use Setwise\EloquentSpatial\Objects\MultiPoint;
use Setwise\EloquentSpatial\Objects\MultiPolygon;
use MultiLineString as geoPHPMultiLineString;
use MultiPoint as geoPHPMultiPoint;
use MultiPolygon as geoPHPMultiPolygon;
use Point as geoPHPPoint;
use Polygon as geoPHPPolygon;

class Factory
{
    public static function parse(string $value): Geometry
    {
        try {
            /** @var geoPHPGeometry|false $geoPHPGeometry */
            $geoPHPGeometry = geoPHP::load($value);
        } finally {
            if (! isset($geoPHPGeometry) || ! $geoPHPGeometry) {
                throw new InvalidArgumentException('Invalid spatial value');
            }
        }

        return self::createFromGeometry($geoPHPGeometry);
    }

    protected static function createFromGeometry(geoPHPGeometry $geometry): Geometry
    {
        $srid = is_int($geometry->getSRID()) ? $geometry->getSRID() : 0;

        if ($geometry instanceof geoPHPPoint) {
            if ($geometry->coords[0] === null || $geometry->coords[1] === null) {
                throw new InvalidArgumentException('Invalid spatial value');
            }

            return new Point($geometry->coords[1], $geometry->coords[0], $srid);
        }

        /** @var geoPHPGeometryCollection $geometry */
        $components = collect($geometry->components)
            ->map(static function (geoPHPGeometry $geometryComponent): Geometry {
                return self::createFromGeometry($geometryComponent);
            });

        if ($geometry::class === geoPHPMultiPoint::class) {
            return new MultiPoint($components, $srid);
        }

        if ($geometry::class === geoPHPLineString::class) {
            return new LineString($components, $srid);
        }

        if ($geometry::class === geoPHPPolygon::class) {
            return new Polygon($components, $srid);
        }

        if ($geometry::class === geoPHPMultiLineString::class) {
            return new MultiLineString($components, $srid);
        }

        if ($geometry::class === geoPHPMultiPolygon::class) {
            return new MultiPolygon($components, $srid);
        }

        return new GeometryCollection($components, $srid);
    }
}
