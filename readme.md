# Specification Pattern

![PHP >= 8.1](https://img.shields.io/static/v1?label=PHP&message=^8.1&color=787CB5&style=for-the-badge&logo=php)
![phpstan Level 8](https://img.shields.io/static/v1?label=phpstan&message=Level%208&color=%3CCOLOR%3E&style=for-the-badge)
![License: MIT](https://img.shields.io/static/v1?label=License&message=MIT&color=%3CCOLOR%3E&style=for-the-badge)

A PHP implementation of the [Specification Pattern](https://en.wikipedia.org/wiki/Specification_pattern), a pattern that is frequently used in the context of **domain-driven design**. However, it is not exclusivly useful in DDD.

---

In computer programming, the specification pattern is a particular software design pattern, whereby business rules can be recombined by chaining the business rules together using boolean logic.

A specification pattern outlines a business rule that is combinable with other business rules. In this pattern, a unit of business logic inherits its functionality from the abstract aggregate Composite Specification class. The Composite Specification class has one function called IsSatisfiedBy that returns a boolean value. After instantiation, the specification is "chained" with other specifications, making new specifications easily maintainable, yet highly customizable business logic. Furthermore, upon instantiation the business logic may, through method invocation or inversion of control, have its state altered in order to become a delegate of other classes such as a persistence repository.

As a consequence of performing runtime composition of high-level business/domain logic, the Specification pattern is a convenient tool for converting ad-hoc user search criteria into low level logic to be processed by repositories.

Since a specification is an encapsulation of logic in a reusable form it is very simple to thoroughly unit test, and when used in this context is also an implementation of the humble object pattern.

* https://en.wikipedia.org/wiki/Specification_pattern
* http://www.martinfowler.com/apsupp/spec.pdf

## How to use them

When using specifications with Domain-Driven Design, a common question is how to check conditions on aggregates without breaking encapsulation. There are several approaches, from delegating checks to aggregate query methods, to using read models in CQRS architectures, to pragmatic property access for simpler use cases.

See [How to use Specifications](docs/How-to-use-Specifications.md) for detailed guidance and complete examples.

## Example

The following example demonstrates a debt collection business rule for invoices.

```php
// Define specifications for invoice collection rules
$overDue = new OverDueSpecification();
$noticeSent = new NoticeSentSpecification();
$inCollection = new InCollectionSpecification();

// Business Rule: Send to collection agency when invoice is:
// - Past due date AND
// - Customer has been notified AND
// - Not already in collection
$sendToCollection = $overDue
    ->and($noticeSent)
    ->andNot($inCollection);

// Apply the business rule to all invoices
foreach ($service->getInvoices() as $invoice) {
    if ($sendToCollection->isSatisfiedBy($invoice)) {
        $invoice->sendToCollection();
    }
}
```

Each specification encapsulates a single business rule check (e.g., `OverDueSpecification` checks if `$invoice->dueDate < now()`). The pattern allows combining these atomic rules using boolean logic (`and`, `or`, `not`, `andNot`, `orNot`) to form complex, readable business rules that can be reused and unit tested independently.

## License

This library is under the MIT license.

Copyright Florian Krämer
