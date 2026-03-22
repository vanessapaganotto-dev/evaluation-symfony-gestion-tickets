<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    protected function configureContainer(ContainerConfigurator $container): void
    {
        $container->import('../config/{packages}/*.yaml');
        $container->import('../config/{packages}/'.$this->environment.'/*.yaml');
        $container->import('../config/{services}.yaml');
        $container->import('../config/{services}_'.$this->environment.'.yaml');
    }

   protected function configureRoutes(RoutingConfigurator $routes): void
{
    // Import de routes.yaml (fichier principal)
    $routes->import('../config/routes.yaml');
    
    // Import des fichiers dans le dossier routes/
    $routes->import('../config/{routes}/*.yaml');
    $routes->import('../config/{routes}/'.$this->environment.'/*.yaml');
}
}