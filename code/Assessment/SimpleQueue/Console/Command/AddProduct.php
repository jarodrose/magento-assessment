<?php
declare(strict_types=1);

namespace Assessment\SimpleQueue\Console\Command;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\MessageQueue\PublisherInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AddProduct extends Command
{

    const PROD_ID_ARGUMENT = "name";
    const PRODUCT_TOPIC = 'product.topic';
    /**
     * @var PublisherInterface
     */
    private $publisher;
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * AddProduct constructor.
     * @param PublisherInterface $publisher
     * @param ProductRepositoryInterface $productRepository
     * @param string|null $name
     */
    public function __construct(PublisherInterface $publisher,
                                ProductRepositoryInterface $productRepository,
                                string $name = null)
    {
        parent::__construct($name);
        $this->publisher = $publisher;
        $this->productRepository = $productRepository;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ) {

        $productId = $input->getArgument(self::PROD_ID_ARGUMENT);
        if($this->validateProductId($productId)) {
            try {
                $product = $this->productRepository->getById((int)$productId);

                $this->publisher->publish(self::PRODUCT_TOPIC, 'Sku ' . $product->getSku()
                    . ' was added via commandline');
                $output->writeln($productId . " was published");
            } catch (NoSuchEntityException $e) {
                $output->writeln($productId . " is an invalid product id please"
                 . " specify a different product id in the formant of an integer. ");
            }
        }else{
            $output->writeln("Please specify a product id in the formant of an integer. ");
        }
    }

    /**
     * Quick validation for the product id argument
     * @param $productId
     * @return bool
     */
    protected function validateProductId($productId){
        return is_numeric($productId);
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName("assessment_simplequeue:addproduct");
        $this->setDescription("Adds a product to a simple message queue");
        $this->setDefinition([
            new InputArgument(self::PROD_ID_ARGUMENT, InputArgument::REQUIRED, "Product Id"),
        ]);
        parent::configure();
    }
}

