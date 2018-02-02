llustration :
==========

In 2014, there are 4 edges which have their own tax rate:
 - From Rp 0 to Rp 50,000,000 the tax rate is 5%.
 - From Rp 50,000,000 to Rp 250,000,000 the tax rate is 15%.
 - From Rp 250,000,000 to Rp 500,000,000 the tax rate is 25%.
 - Above 500,000,000 the tax rate is 30%.

Examples:

1) If your annual taxable income is Rp 75,000,000.
Your annual income tax amount will be:
 > 5%*50,000,000 + 15%*25,000,000 =
2,500,000 + 3,750,000 = Rp 6,250,000

2) If your annual taxable income is Rp 750,000,000,
Your annual income tax amount will be:
> 5%*50,000,000 + 15%*200,000,000 + 25%*250,000,000 + 30%*250,000,000 =
2,500,000 + 30,000,000 + 62,500,000 + 75,000,000 = Rp 170,000,000

## The solution design:

The application Domain Drive structure separates well the Domain layer (the Model), the application layer (RuleSet management and amountTax calculation) and the
infrastructure layer (the CLI command).

This separation allows to extends the Domain, the Application and the infrastructure independently from one another. The Domain
can than be enrished by adding new Rule types, the Application can also be extended
by adding new computation capabilities and so we can do with the infrastructure by adding new entry points (HTTP, REST, ...)

Here's a Domain Driven design used to implement the sorting solution,

// picture

## How to install the application

The application needs [composer to be installed globally](https://getcomposer.org/doc/00-intro.md#globally). Then you've to run the following command,

```sh
make build
```

## How to run your application

```sh
php src/application.php  app:tax-amount 750000000
```

And the result should be (Cf. the example):

```sh
The tax amount for 750000000 is estimated to:
==============================================
170000000
```

## How to run phpspec tests

```sh
make test
```

## How to extend the application (Adding new types of calculation rules)

Adding new types of calculation rules is as easy as just implementing the `MV\Domain\Model\RuleInterface`.

If you want to benefits from the basic shared behaviors every rule type has to cover, you can add an abstract class `Domain\Model\AbstractRule`
that extends the same interface and embed the common logic:

```php
namespace MW\Domain\Model;

class NewRule extends RuleInterface
{
    /**
     * {@inheritdoc}
     */
    public function apply($rp)
    {
        // implement here the calculation rule for this specific rule
    }
}
```

The application design provides also other extension points, the computation logic provided within the TaxAmount Manager can be overrided by extended the appropriate interface:

```php
namespace MW\Application\Tax;

class NewTaxAmount implements TaxAmountInterface
{
    /**
     * {@inheritdoc}
     */
    public function calculate($rp)
    {
        // implement the specific calculation logic for this new Tax amount manager
    }
}
```

The last extension point is the infrastructure level, when you can add as many delivery mechanism as you want (HTTP, REST, ...)