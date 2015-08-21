<?php

namespace RelationFormBundle\Model;


use Doctrine\ORM\Mapping\ClassMetadataInfo;

class FieldGuesser {

    static public function guessTitleField(ClassMetadataInfo $metadata)
    {
        $guesses = array('name', 'title', 'file', 'filename', 'user', 'username');
        foreach ($guesses as $guess)
            if (in_array($guess, $metadata->fieldNames))
                return $guess;

        foreach($metadata->fieldMappings as $field) {
            $stringTypes = array('string','text');
            if (in_array($field['type'], $stringTypes))
                return $field['fieldName'];
        }

        return 'id';
    }

    static public function getterName($field)
    {
        return 'get' . ucfirst($field);
    }
} 