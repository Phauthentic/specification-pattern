# Specification Pattern

![PHP >= 8.1](https://img.shields.io/static/v1?label=PHP&message=^8.1&color=787CB5&style=for-the-badge&logo=php)
![phpstan Level 8](https://img.shields.io/static/v1?label=phpstan&message=Level%208&color=%3CCOLOR%3E&style=for-the-badge)
![License: MIT](https://img.shields.io/static/v1?label=License&message=MIT&color=%3CCOLOR%3E&style=for-the-badge)

A PHP implementation of the [Specification Pattern](https://en.wikipedia.org/wiki/Specification_pattern), a pattern that is frequently used in the context of **domain-driven design**.

---

In computer programming, the specification pattern is a particular software design pattern, whereby business rules can be recombined by chaining the business rules together using boolean logic.

A specification pattern outlines a business rule that is combinable with other business rules. In this pattern, a unit of business logic inherits its functionality from the abstract aggregate Composite Specification class. The Composite Specification class has one function called IsSatisfiedBy that returns a boolean value. After instantiation, the specification is "chained" with other specifications, making new specifications easily maintainable, yet highly customizable business logic. Furthermore, upon instantiation the business logic may, through method invocation or inversion of control, have its state altered in order to become a delegate of other classes such as a persistence repository.

As a consequence of performing runtime composition of high-level business/domain logic, the Specification pattern is a convenient tool for converting ad-hoc user search criteria into low level logic to be processed by repositories.

Since a specification is an encapsulation of logic in a reusable form it is very simple to thoroughly unit test, and when used in this context is also an implementation of the humble object pattern.

* https://en.wikipedia.org/wiki/Specification_pattern
* http://www.martinfowler.com/apsupp/spec.pdf

## Example

```php
$overDue = new OverDueSpecification();
$noticeSent = new NoticeSentSpecification();
$inCollection = new InCollectionSpecification();

// Example of specification pattern logic chaining
$sendToCollection = $overDue
    ->and($noticeSent)
    ->and($inCollection->not());

$invoiceCollection = $service->getInvoices();

foreach ($invoiceCollection as $invoice) {
    if ($sendToCollection->isSatisfiedBy($invoice)) {
        $invoice->sendToCollection();
    }
}
```

## License

The MIT License (MIT)
