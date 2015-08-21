# Relation form bundle

Form type for relation fields.

[![Latest Stable Version](https://poser.pugx.org/illibejiep/relation-form-bundle/v/stable)](https://packagist.org/packages/illibejiep/relation-form-bundle) [![Total Downloads](https://poser.pugx.org/illibejiep/relation-form-bundle/downloads)](https://packagist.org/packages/illibejiep/relation-form-bundle) [![Latest Unstable Version](https://poser.pugx.org/illibejiep/relation-form-bundle/v/unstable)](https://packagist.org/packages/illibejiep/relation-form-bundle) [![License](https://poser.pugx.org/illibejiep/relation-form-bundle/license)](https://packagist.org/packages/illibejiep/relation-form-bundle)

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
