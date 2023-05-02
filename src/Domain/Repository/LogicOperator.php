<?php

declare(strict_types=1);

namespace Look\Domain\Repository;

enum LogicOperator: string
{
    case AND = 'and';

    case OR = 'or';
}
