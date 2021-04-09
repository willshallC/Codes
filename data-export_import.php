<?php
	require_once '../app/Mage.php';
	umask(0);
	Mage::app('default');
	Mage::app()->setCurrentStore(1);


	ini_set('display_errors', '1');
	ini_set('memory_limit','2048M');
	ini_set('max_execution_time',3600);
	error_reporting( E_ALL );

	$productCollection = Mage::getModel('catalog/product')
     ->getCollection()
     ->addAttributeToSelect('*')
     ->joinField('qty',
                 'cataloginventory/stock_item',
                 'qty',
                 'product_id=entity_id');


	$count = 0;
	$data = array();
	$base_file = fopen('IM_Products_24_03_2021_for_IMPORT.csv', 'r');
	$new_file = fopen('IM_default_store_view_after_updated_30_12_2021.csv', 'w');  /// file to write entries
	$fieldKeys = array('SKU');
	fputcsv($new_file,$fieldKeys);

	while (($line = fgetcsv($base_file)) !== FALSE)
	{

		if($count > 1 && $count < 10 && !empty($line[0]))
		{
			$product_sku = $line[0];

			echo $product_sku." /// count : $count<br>";
			$product = Mage::getModel('catalog/product')->loadByAttribute('sku', $product_sku);

			//$product_id = Mage::getModel('catalog/product')->loadByAttribute('sku', $product_sku)->getId();
			//$product = Mage::getModel('catalog/product')->load($product_id);

			if($product)
			{

				$data[0] = $product->getSku();

				$product->setIncludes($line[1]);
				$product->setTechnical($line[2]);

				$product->save();

				fputcsv($new_file,$data);

			}
		}
		$count++;

	}

echo "<br>".$count."done";

?>
