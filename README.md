LocalinksDependentAutoCompleteBundle
====================================

What for ?
==========

LocalinksDependentAutoCompleteBundle allows, ub a Sonata Admin form, to filter the results of a "sonata_type_model_autocomplete" field using the value of one (or more) other field present in the same form.


Installation
============

### Step 1: Download the DependentAutoCompleteBundle

***Using Composer***

Add the following to the "require" section of your `composer.json` file:

```
    "localinks/dependentautocompletebundle": "dev-master"
```

And update your dependencies

```
    php composer.phar update
```

### Step 2: Enable the bundle

Registers the bundle in your `app/AppKernel.php`:

```php
<?php
...
public function registerBundles()
{
    $bundles = array(
        ...
        new Localinks\DependentAutoCompleteBundle\LocalinksDependentAutoCompleteBundle(),
        ...
    );
...
```


Usage
=====


Imagine that you have an autocomplete "country" form field and another one: "city". You want your "city" field to be filtered according to the content of the "country" field.

For this you need to update your Admin class:

```php
<?php
...
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('country', 'sonata_type_model_autocomplete', array(
                'label' => 'Country',
                'property' => 'name',
                'attr' => array('data-dependent-id' => 'country'),
                'required' => false
            ))
            ->add('city', 'sonata_type_model_autocomplete', array(
                    'label' => 'City',
                    'dependencies' => array('country' => 'country_id'),
                    'property' => 'name',
                    'callback' => function (Admin $admin, $property, $value) {
                        $request = Request::createFromGlobals();
                        $dependencies = $request->get('dependencies');

                        $datagrid = $admin->getDatagrid();
                        $queryBuilder = $datagrid->getQuery();

                        if(!is_null($dependencies['country_id']) && $dependencies['country_id'] !== "") {
                            $queryBuilder
                                ->leftJoin($queryBuilder->getRootAlias() . '.country', 'cco')
                                ->where($queryBuilder->getRootAlias() . '.' .$property . ' LIKE :value')
                                ->andWhere('cco.id = :country_id')
                                ->setParameters(array(
                                    'country_id' => $dependencies['country_id'],
                                    'value' => $value . '%'
                                ));
                            }
                        else {
                            $queryBuilder
                                ->where($queryBuilder->getRootAlias() . '.' .$property . ' LIKE :value')
                                ->setParameters(array(
                                    'value' => $value . '%'
                                ));
                        }
                    },
                    'required' => false
            ))
        ;
    }
```

Please note the "data-dependent-id" value in the "country" field. This value will be used to identify the field. To avoid any error, use the same value than the field name (for instance "country").

In the "city" field, add a "dependencies" option, as above. In this array, use the same "data-dependent-id" value than above as key, and any variable name you want as value.

You still have to create the "callback" function: the variable that you named above is accessible via the Request object (see example). From there, you can create the query necessary to filter your field.


Requirements
============

`LocalinksDependentAutoCompleteBundle` needs SonataAdminBundle in order to work

License
=======

This bundle is under GNU GENERAL PUBLIC LICENSE 3 license

Author
======

Mathieu Hautenauve
mathieu@proxymart.be
www.localinks.be