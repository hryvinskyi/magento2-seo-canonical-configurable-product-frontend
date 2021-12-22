<?php
/**
 * Copyright (c) 2021. All rights reserved.
 * @author: Volodymyr Hryvinskyi <mailto:volodymyr@hryvinskyi.com>
 */

declare(strict_types=1);

namespace Hryvinskyi\SeoCanonicalConfigurableProductFrontend\Model\CanonicalUrl;

use Hryvinskyi\SeoCanonicalApi\Api\CanonicalUrl\ProcessInterface;
use Hryvinskyi\SeoCanonicalApi\Api\CheckIsProductEnabledInterface;
use Hryvinskyi\SeoCanonicalConfigurableProductFrontend\Model\GetAssociatedCanonicalConfigurableProductConfigInterface;
use Magento\ConfigurableProduct\Model\ResourceModel\Product\Type\Configurable;

class ConfigurableProductProcess implements ProcessInterface
{
    /**
     * @var GetAssociatedCanonicalConfigurableProductConfigInterface
     */
    private $config;

    /**
     * @var Configurable
     */
    private $productTypeConfigurable;

    /**
     * @var CheckIsProductEnabledInterface
     */
    private $checkIsProductEnabled;

    /**
     * @param GetAssociatedCanonicalConfigurableProductConfigInterface $config
     * @param Configurable $productTypeConfigurable
     * @param CheckIsProductEnabledInterface $checkIsProductEnabled
     */
    public function __construct(
        GetAssociatedCanonicalConfigurableProductConfigInterface $config,
        Configurable $productTypeConfigurable,
        CheckIsProductEnabledInterface $checkIsProductEnabled
    ) {
        $this->config = $config;
        $this->productTypeConfigurable = $productTypeConfigurable;
        $this->checkIsProductEnabled = $checkIsProductEnabled;
    }

    /**
     * @inheritDoc
     */
    public function execute(array &$data): void
    {
        if (isset($data['associatedProductId']) === false && $this->config->execute() === true
            && ($parentConfigurableProductIds = $this->productTypeConfigurable->getParentIdsByChild($data['productId']))
            && isset($parentConfigurableProductIds[0])
            && $this->checkIsProductEnabled->executeById((int)$parentConfigurableProductIds[0])
        ) {
            $data['associatedProductId'] = $parentConfigurableProductIds[0];
        }
    }
}
