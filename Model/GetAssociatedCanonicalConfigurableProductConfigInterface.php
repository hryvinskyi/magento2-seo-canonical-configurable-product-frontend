<?php
/**
 * Copyright (c) 2021. All rights reserved.
 * @author: Volodymyr Hryvinskyi <mailto:volodymyr@hryvinskyi.com>
 */

declare(strict_types=1);

namespace Hryvinskyi\SeoCanonicalConfigurableProductFrontend\Model;

interface GetAssociatedCanonicalConfigurableProductConfigInterface
{
    /**
     * @return bool
     */
    public function execute(): bool;
}
