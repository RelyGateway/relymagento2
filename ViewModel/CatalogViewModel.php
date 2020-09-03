<?php

namespace Rely\Payment\ViewModel;

use Magento\Framework\View\Asset\Repository as AssetRepository;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Rely\Payment\Model\Config\ModuleConfigurations;

class CatalogViewModel implements ArgumentInterface
{
    /**
     * @var ModuleConfigurations
     */
    private $moduleConfigurations;
    /**
     * @var AssetRepository
     */
    private $assetRepo;
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;
    /**
     * @var \Magento\Directory\Model\Currency
     */
    private $currency;

    /**
     * CatalogViewModel constructor.
     * @param ModuleConfigurations $moduleConfigurations
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Directory\Model\Currency $currency
     * @param AssetRepository $assetRepo
     */
    public function __construct(
        ModuleConfigurations $moduleConfigurations,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Directory\Model\Currency $currency,
        AssetRepository $assetRepo
    ) {
        $this->moduleConfigurations = $moduleConfigurations;
        $this->assetRepo = $assetRepo;
        $this->storeManager = $storeManager;
        $this->currency = $currency;
    }

    public function getLogo()
    {
        if ($this->moduleConfigurations->getRelyProductType()==='rely_instalment') {
            return  $this->assetRepo->getUrl('Rely_Payment::images/installment/logo.png');
        } else {
            return  $this->assetRepo->getUrl('Rely_Payment::images/paylater/logo.png');
        }
    }
    public function getCurrencyCode()
    {
        return $this->currency->getCurrencySymbol();
    }
}
