<?php

namespace TotalContestVendors\League\Container;
! defined( 'ABSPATH' ) && exit();


interface ContainerAwareInterface
{
    /**
     * Set a container
     *
     * @param \TotalContestVendors\League\Container\ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container);

    /**
     * Get the container
     *
     * @return \TotalContestVendors\League\Container\ContainerInterface
     */
    public function getContainer();
}
