<?php
/**
 * @author Serbu Florin-Adrian <florin.serbu@gmail.com>
 * @copyright Copyright (c) 2016 Serbu Florin-Adrian (https://serbu.me)
 * @package Bb_Tags
 */
 
namespace WS\CategoryFeatures\Model\Category\Attribute\Backend;
 
class CategoryFeatures extends \Magento\Eav\Model\Entity\Attribute\Backend\AbstractBackend
{
    public function beforeSave($object)
    {
        $attributeCode = $this->getAttribute()->getName();
        if ($attributeCode == 'categoryFeatures') {
            $data = $object->getData($attributeCode);
            if (!is_array($data)) {
                $data = [];
            }
            $object->setData($attributeCode, implode(',', $data) ?: null);
        }
        if (!$object->hasData($attributeCode)) {
            $object->setData($attributeCode, null);
        }
        return $this;
    }
 
    public function afterLoad($object)
    {
        $attributeCode = $this->getAttribute()->getName();
        if ($attributeCode == 'categoryFeatures') {
            $data = $object->getData($attributeCode);
            if ($data) {
                if (!is_array($data)) {
                    $object->setData($attributeCode, explode(',', $data));
                } else {
                    $object->setData($attributeCode, $data);
                }
 
            }
        }
        return $this;
    }
}