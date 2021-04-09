<?php
namespace WS\CategoryFeatures\Model\Category\Attribute\Source;

class Custom extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    /**
     * Catalog config
     *
     * @var \Magento\Catalog\Model\Config
     */
    protected $_catalogConfig;

    /**
     * Construct
     *
     * @param \Magento\Catalog\Model\Config $catalogConfig
     */
    public function __construct(\Magento\Catalog\Model\Config $catalogConfig)
    {
        $this->_catalogConfig = $catalogConfig;
    }

    /**
     * Retrieve Catalog Config Singleton
     *
     * @return \Magento\Catalog\Model\Config
     */
    protected function _getCatalogConfig()
    {
        return $this->_catalogConfig;
    }

    /**
     * {@inheritdoc}
     */
    public function getAllOptions()
    {
        if ($this->_options === null) {
            $this->_options = [
                                ['label' => __('IP 44'), 'value' => 1],
                                ['label' => __('Infra red sensor'), 'value' => 2],
                                ['label' => __('Shaver socket'), 'value' => 3],
                                ['label' => __('Demist pad'), 'value' => 4],
                                ['label' => __('IP65'), 'value' => 5],
                                ['label' => __('Dim Switch'), 'value' => 6],
                                ['label' => __('Battery'), 'value' => 7],
                                ['label' => __('Pull Cord'), 'value' => 8],
                                ['label' => __('Ambient Range'), 'value' => 9],
                                ['label' => __('Fluorescent Tube'), 'value' => 10],
                                ['label' => __('X3 Area'), 'value' => 11],
                                ['label' => __('AI Aluminium'), 'value' => 12],
                                ['label' => __('Auto RGB'), 'value' => 13],
                                ['label' => __('Digital clock'), 'value' => 14],
                                ['label' => __('Bluetooth'), 'value' => 15],
                                ['label' => __('LED Bulbs'), 'value' => 16],
                                ['label' => __('Aluminium Frame'), 'value' => 17],
                                ['label' => __('Hinges'), 'value' => 18],
                                ['label' => __('LED'), 'value' => 19],
                                ['label' => __('Table only'), 'value' => 20],
                                ['label' => __('Stool only'), 'value' => 21],
                                ['label' => __('Table and Stool'), 'value' => 22]

                                ];

        }
        return $this->_options;
    }
}