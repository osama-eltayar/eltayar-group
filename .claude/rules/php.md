---
paths:
  - "**/*.php"
---

# Modern PHP 8.3 Rules

Rules for working with modern PHP 8.3 features and best practices
Dont fix linter errors 

## Type System
- Always use typed properties for class properties
- Always add return types to methods and functions
- Use union types (string|int|null) instead of docblocks
- Use typed class constants where appropriate

## PHP 8.3 Specific Features
- Use `#[Attribute]` where metadata is needed over comments

## Modern Practices
- Use constructor property promotion for simpler class definitions
- Replace switch statements with match expressions
- Use named arguments for improved readability
- Implement null safe operator (?->) to avoid null checks
- Use arrow functions for simple closures
- Convert class constants to proper PHP enums where appropriate
- Implement attributes for metadata instead of docblocks

## Code Quality
- Prefer early returns to reduce nesting
- Use named constructors for multiple initialization paths
- Follow PSR-12 coding standards
- Implement value objects for complex values
- Implement proper exception handling with custom exceptions

## Naming Conventions
- Classes: `PascalCase`
- Methods: `camelCase`
- Properties: `camelCase`
- Constants: `UPPER_CASE`
- Filenames must match class names (PSR-4 autoloading)