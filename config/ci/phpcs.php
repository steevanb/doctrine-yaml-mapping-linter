<?php

declare(strict_types=1);

use steevanb\PhpCodeSniffs\Steevanb\Sniffs\Uses\GroupUsesSniff;

GroupUsesSniff::addSymfonyPrefixes();
GroupUsesSniff::addThirdLevelPrefix('PhpPp\\Core');
