<?php

declare(strict_types=1);

namespace Studio15\Loymax\ApiClient;

use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AttributeLoader;
use Symfony\Component\Serializer\NameConverter\MetadataAwareNameConverter;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\BackedEnumNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\UidNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @internal
 */
final readonly class CreateSerializer
{
    public function __invoke(): Serializer
    {
        $classMetadataFactory = new ClassMetadataFactory(
            loader: new AttributeLoader(),
        );

        $metadataAwareNameConverter = new MetadataAwareNameConverter($classMetadataFactory);

        $reflectionExtractor = new ReflectionExtractor();
        $phpDocExtractor = new PhpDocExtractor();

        $propertyTypeExtractor = new PropertyInfoExtractor(
            listExtractors: [$reflectionExtractor],
            typeExtractors: [$phpDocExtractor, $reflectionExtractor],
            descriptionExtractors: [$phpDocExtractor],
            accessExtractors: [$reflectionExtractor],
            initializableExtractors: [$reflectionExtractor],
        );

        $objectNormalizer = new ObjectNormalizer(
            classMetadataFactory: $classMetadataFactory,
            nameConverter: $metadataAwareNameConverter,
            propertyTypeExtractor: $propertyTypeExtractor,
        );

        return new Serializer(
            normalizers: [
                new BackedEnumNormalizer(),
                new UidNormalizer(),
                new DateTimeNormalizer(),
                $objectNormalizer,
                new ArrayDenormalizer(),
            ],
            encoders: [
                new JsonEncoder(),
            ],
        );
    }
}
