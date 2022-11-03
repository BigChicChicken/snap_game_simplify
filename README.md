Snap Game Simplify
---

Rules:
- One deck of 52 cards (with a value from 1 to 52) are shuffled and dealt between two payers.
- Each player show the first card of his deck, the player with the strongest card score one point.
- The game continues until there are no more cards.
- The winner is the player with the highest score.

Prerequisite
---

| Tools  | Version |
|--------|---------|
| Docker | <=20.10 |
| Docker | <=1.29  |

Installation
---

Install dependencies:
```bash
composer install
```

Usage
---

Run tests:
```bash
./vendor/bin/phpunit tests
```
Run application:
```bash
php src/Kernel.php
```

UML
---

![](https://github.com/BigChicChicken/snap_game_simplify/blob/main/docs/UML.jpg "UML")