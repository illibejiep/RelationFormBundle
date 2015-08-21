# Relation form bundle

Form type for relation fields.

## Installation

```
    composer require illibejiep/relation-form-bundle dev-master
```

Then add in AppKernel.php

```
//...
    $bundles[] = new \RelationFormBundle\RelationFormBundle();

    return $bundles;
//...
```

add route in app/config/routing.yml

```
//...
relation_form:
    resource: "@RelationFormBundle/Resources/config/routing.yml"
    prefix:   /relation_form
//...
```
