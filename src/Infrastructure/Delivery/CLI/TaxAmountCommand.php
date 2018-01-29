<?php

namespace MW\Infrastructure\Delivery\CLI;

use MW\Application\Tax\TaxAmountInterface;
use MW\Application\Exception\UnableToCalculateTaxIncomeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TaxAmountCommand extends Command
{
    /** @var TaxAmountInterface */
    private $taxAmount;

    /**
     * @param TaxAmountInterface $taxAmount
     */
    public function __construct(TaxAmountInterface $taxAmount, $name = null)
    {
        $this->taxAmount = $taxAmount;

        parent::__construct($name);
    }

    protected function configure()
    {
        $this
            ->setName('app:tax-amount')
            ->setDescription('Calculate the amount tax')
            ->setHelp('This command allows you to calculate the tax amount for a given revenue')
            ->addArgument('rp', InputArgument::REQUIRED, 'Taxable income')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $rp = (float)$input->getArgument('rp');

        try {
            $output->writeln([
                sprintf('The tax amount for %d is estimated to:', $rp),
                '==============================================',
                $this->taxAmount->calculate($rp),
            ]);
        } catch (UnableToCalculateTaxIncomeException $e) {
            $output->writeln([
               'Unable to calculate tax income!',
            ]);
        }
    }
}
