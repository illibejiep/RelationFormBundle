<?php

namespace RelationFormBundle;

use RelationFormBundle\DependencyInjection\Compiler\RelationFormPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class RelationFormBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass( new RelationFormPass() );
    }
}
