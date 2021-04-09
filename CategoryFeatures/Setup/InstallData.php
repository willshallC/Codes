<?php

namespace WS\CategoryFeatures\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;

/**
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface
{
    protected $eavSetupFactory;

    protected $_logger;

    protected $_attributeRepository;

    protected $_attributeOptionManagement;

    protected $_option;

    protected $_attributeOptionLabel;

    public function __construct(
        EavSetupFactory $eavSetupFactory, // the following parameters are optional
        \Psr\Log\LoggerInterface $logger,
        \Magento\Eav\Model\AttributeRepository $attributeRepository,
        \Magento\Eav\Api\AttributeOptionManagementInterface $attributeOptionManagement,
        \Magento\Eav\Model\Entity\Attribute\OptionLabelFactory $attributeOptionLabel,
        \Magento\Eav\Model\Entity\Attribute\OptionFactory $option
    ){

        $this->_eavSetupFactory = $eavSetupFactory;

        /* These are optional and used only to populate the attribute with some mock options */
        $this->_logger = $logger;
        $this->_attributeRepository = $attributeRepository;
        $this->_attributeOptionManagement = $attributeOptionManagement;
        $this->_option = $option;
        $this->_attributeOptionLabel = $attributeOptionLabel;
    }

    /**
     * {@inheritdoc}
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        /** @var EavSetup $eavSetup */
        $eavSetup       = $this->_eavSetupFactory->create(['setup' => $setup]);
        $entityTypeId   = $eavSetup->getEntityTypeId(\Magento\Catalog\Model\Category::ENTITY);
        $attributeSetId = $eavSetup->getDefaultAttributeSetId($entityTypeId);

        $eavSetup->removeAttribute(\Magento\Catalog\Model\Category::ENTITY, 'categoryFeatures');
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Category::ENTITY,
            'categoryFeatures',
            [
                'type'          => 'text',
                'label'         => 'Category Features',
                'input'         => 'multiselect',
                'source'        => 'WS\CategoryFeatures\Model\Category\Attribute\Source\Custom',
                'backend'       => 'WS\CategoryFeatures\Model\Category\Attribute\Backend\CategoryFeatures',
                'input_renderer'=> 'WS\CategoryFeatures\Block\Adminhtml\Category\Helper\Custom\Options',
                'required'      => false,
                'sort_order'    => 70,
                'global'        => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'group'         => 'Content',
            ]
        );

        /*
         * The following lines are optional
         * and used only to populate the attribute with some mock options
         * used script from here: http://magento.stackexchange.com/questions/103934/magento2-programmatically-add-product-attribute-options
         */

        $mockOptions = [
            'IP44',
            'Infra red sensor',
			'Shaver socket',
			'Demist pad',
			'IP65 Zone 1',
			'Dim Switch',
			'Battery',
			'Pull Cord',
			'Ambient Range',
			'Fluorescent Tube',
			'3X Area',
			'AI Aluminium',
			'Auto RGB',
			'Digital clock',
			'Bluetooth',
			'LED Bulbs',
			'Aluminium Frame',
			'Hinges',
			'LED',
			'Table only',
			'Stool only',
			'Table and Stool'
        ];

        $attributeId = $this->_attributeRepository->get(
            \Magento\Catalog\Model\Category::ENTITY,
            'categoryFeatures'
        )->getAttributeId();



        foreach($mockOptions as $label){
            /** @var \Magento\Eav\Model\Entity\Attribute\Option $option */
            $option = $this->_option->create();
            $labelObj  = $this->_attributeOptionLabel->create();

            $labelObj->setStoreId(0);
            $labelObj->setLabel($label);
            $option->setLabel($label);
            $option->setStoreLabels([$labelObj]);
            $option->setSortOrder(0);
            $option->setIsDefault(false);
            $option->setAttributeId($attributeId)->getResource()->save($option);
            $this->_attributeOptionManagement->add(\Magento\Catalog\Model\Category::ENTITY, $attributeId, $option);
        }

    }
}
