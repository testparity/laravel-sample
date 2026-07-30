<p align="center">
  <img src="https://testparity.com/brand/testparity-readme-banner.jpg" alt="TestParity" width="100%">
</p>

# Laravel Sample

[![Parity Sample](https://github.com/testparity/laravel-sample/actions/workflows/parity.yml/badge.svg)](https://github.com/testparity/laravel-sample/actions/workflows/parity.yml)

This repository is an end-to-end Parity demo for Laravel 13. It runs the real PHPUnit suite through `php artisan test`, generates one Clover report per test file, and lets Parity prove which test owns each service.

## What this sample proves

`InvoiceTotal.php` reaches 80% when every test is combined, but its belonging test owns only 40%. `DiscountPolicyTest.php` supplies the other coverage by calling invoice helpers as part of its scenario.

| Source file | Belonging test | All tests | Belonging test | Attribution |
| --- | --- | ---: | ---: | ---: |
| `app/Services/InvoiceTotal.php` | `tests/Unit/Services/InvoiceTotalTest.php` | 80% | 40% | `2|1` |
| `app/Services/DiscountPolicy.php` | `tests/Unit/Services/DiscountPolicyTest.php` | 100% | 100% | `1|0` |
| Project total | - | 85.71% | - | - |

`coverage-attribution` uses `total covering tests|non-matching covering tests`. The `2|1` result proves that a passing global gate can conceal weak test ownership.

## How the proof works

The matching invoice test calls `fromSubtotal` and `afterCredit`. The discount test also calls `quantityTotal` and `splitPayments`, while `withBuffer` remains intentionally uncovered. `parity test` invokes each PHPUnit file separately with Xdebug Clover coverage, writes `.parity/per-test`, and runs `parity check` automatically.

## Run locally

Requirements: PHP 8.4+, Composer, and Xdebug with coverage support.

```bash
composer install
php artisan test --colors=never
composer global require testparity/parity:^1.2
```

Generate fresh per-test evidence and check it:

```bash
parity test --config=parity.yaml --format=json
```

To inspect the same generated reports without rerunning Laravel:

```bash
parity check --config=parity.yaml --format=json
```

The expected result is `passed = true`, `global_coverage = 85.71`, and the file-level values shown above. No coverage fixture is committed.

## CI

GitHub Actions installs locked Composer dependencies, runs the complete Laravel suite, installs public `testparity/parity:^1.2`, and executes `parity test`. The generated `.parity/per-test` directory and JSON result are uploaded as the `parity-per-test-evidence` artifact for 14 days. No private token is required.
