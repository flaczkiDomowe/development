<?php declare(strict_types=1);

namespace SwagShopFinder\Storefront\Page\Example;

use Shopware\Storefront\Page\Page;
use SwagShopFinder\Core\Content\ShopFinder\ShopFinderEntity;

class ExamplePage extends Page
{
    protected ShopFinderEntity $exampleData;

    public function getExampleData(): ShopFinderEntity
    {
        return $this->exampleData;
    }

    public function setExampleData(ShopFinderEntity $exampleData): void
    {
        $this->exampleData = $exampleData;
    }
}
