<?php

declare(strict_types=1);


namespace App\Application\Commands;

use Symfony\Component\Validator\Constraints\NotBlank;

class CategoryCreateCommand implements Command
{
	#[NotBlank]
	public string $name;
}