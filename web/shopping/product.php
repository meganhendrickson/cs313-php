<?php

class Product
{

    public $productArray = array(
        "bee-kind" => array(
            'id' => '1',
            'name' => 'Bee Kind Tshirt',
            'code' => 'bee-kind',
            'image' => 'product-images/bee-kind.jpg',
            'price' => '15.00'
        ),
        "chaos" => array(
            'id' => '2',
            'name' => 'Chaos Coordinator Tshirt',
            'code' => 'chaos',
            'image' => 'product-images/chaos-coordinator.jpg',
            'price' => '15.00'
        ),
        "fine" => array(
            'id' => '3',
            'name' => 'Everythings Fine Tshirt',
            'code' => 'fine',
            'image' => 'product-images/fine.jpg',
            'price' => '15.00'
        ),
        "mama-bear" => array(
            'id' => '4',
            'name' => 'Mama Bear Tshirt',
            'code' => 'mama-bear',
            'image' => 'product-images/mama-bear.jpg',
            'price' => '15.00'
        ),
        "shark" => array(
            'id' => '5',
            'name' => 'Shark Family Tshirt Set',
            'code' => 'shark',
            'image' => 'product-images/shark-set.jpg',
            'price' => '45.00'
        ),
        "it-is-well" => array(
            'id' => '6',
            'name' => 'Everythings Fine Tshirt',
            'code' => 'it-is-well',
            'image' => 'product-images/it-is-well.jpg',
            'price' => '15.00'
        )
    );

    public function getAllProduct()
    {
        return $this->productArray;
    }
}