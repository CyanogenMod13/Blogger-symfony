<?php
declare(strict_types=1);

namespace App\Application\Commands;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Uuid;

class BlogEditCommand implements Command
{
	#[NotBlank]
	#[Uuid]
	public string $blogId;
	#[NotBlank]
	public string $name;
	#[NotBlank]
	public string $alias;
	#[NotBlank]
	#[Uuid]
	public string $categoryId;
}