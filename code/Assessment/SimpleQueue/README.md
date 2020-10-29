# Mage2 Module Assessment SimpleQueue

    ``assessment/module-simplequeue``

 - [Main Functionalities](#markdown-header-main-functionalities)
 - [Installation](#markdown-header-installation)
 - [Configuration](#markdown-header-configuration)
 - [Specifications](#markdown-header-specifications)
 - [Attributes](#markdown-header-attributes)


## Main Functionalities
Simple Queue module used for assessment

The main goal of this module is to capture actions taken on a product and add them
to the message queue to be logged to the system.  In this case its the simple actions
of viewing or loading the product by id. 

The viewing is handled using an event observer catalog_controller_product_view and the 
load by product id is done with the new command assessment_simplequeue:addproduct

The messages will get logged to the consumer.log file located in the <magento root>/var/log directory.

## Installation

## Configuration

## Specifications

 - Observer
	- catalog_controller_product_view > Assessment\SimpleQueue\Observer\Frontend\Catalog\ControllerProductView

 - Console Command
	- assessment_simplequeue:addproduct <product_id>
	- ex:  bin/magento assessment_simplequeue:addproduct 1


## Attributes



