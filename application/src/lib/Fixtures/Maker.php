<?php

declare(strict_types=1);

namespace App\lib\Fixtures;

use App\lib\ORMClassTools;
use App\lib\RandomGenerator;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ObjectManager;
use Faker;
use ReflectionClass;
use ReflectionException;

class Maker
{
    /**
     * @param int $numberOfItems
     * @param string $entity
     * @param ObjectManager $manager
     * @param string|null $parent
     * @return ArrayCollection|null
     * @throws ReflectionException
     */
    public static function make(
        int $numberOfItems,
        string $entity,
        ObjectManager $manager,
        string $parent = null
    ): ArrayCollection
    {
        $faker = Faker\Factory::create();
        $faker->addProvider(new Faker\Provider\Lorem($faker));
        $reflectionClass = new ReflectionClass($entity);
        $properties = $reflectionClass->getProperties();
        $propertyTypes = [];
        foreach ($properties as $property) {
            $isObject = false;
            $name = $property->getName();
            if ($name === 'id') {
                continue;
            }
            $type = (string)$property->getType();
            if ($type === $parent) {
                continue;
            }
            if ($type === Collection::class) {
                $isObject = true;
                $type = ORMClassTools::getClassType($property->getDocComment(), $entity);
            }
            $propertyTypes[$name]['type'] = $type;
            $propertyTypes[$name]['isObject'] = $isObject;
        }
        $items = new ArrayCollection();
        for ($i = 0; $i < $numberOfItems; $i++) {
            $item = new $entity();
            foreach ($propertyTypes as $property => $details) {
                if ($details['isObject']) {
                    if (RandomGenerator::generateBool() === false) {
                        continue;
                    }
                    $values = self::make(
                        RandomGenerator::generateInt(1, 5),
                        $details['type'],
                        $manager,
                        $entity
                    );
                    foreach ($values as $value) {
                        $setter = 'add' . ucfirst(substr($property, 0, -1));
                        $item->$setter($value);
                    }
                } else {
                    $fakerType = self::getFakerType($property, $details['type']);
                    $item->$property = $faker->$fakerType;
                }
            }
            $manager->persist($item);
            $manager->flush();
            $items->add($item);
        }
        return $items;
    }


    private static function getFakerType(string $property, string $type): string
    {
        if ($type === 'string') {
            return self::getStringFakerVerb($property);
        }
    }

    private static function getStringFakerVerb(string $property): string
    {
        switch ($property) {
            case 'title':
                $result = 'catchPhrase';
                break;
            case 'body':
                $result = 'text';
                break;
            case 'address':
                $result = 'streetAddress';
                break;
            case 'firstName':
                $result = 'firstName';
                break;
            case 'lastName':
                $result = 'lastName';
                break;
            case 'phone':
                $result = 'e164PhoneNumber';
                break;
            default:
                $result = 'word';
        }

        return $result;
    }
}